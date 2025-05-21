<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FishProduct;
use App\Models\Fisher;
use App\Models\FisherEarning;
use App\Models\Consumer;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class Analytics extends Controller
{
    protected function safeDecrypt($value)
    {
        if (!$value) return null;

        try {
            return Crypt::decryptString($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $value;
        }
    }

    protected function safeEncrypt($value)
    {
        if (!$value) return null;
        return Crypt::encryptString($value);
    }

    public function consumer()
    {
        $freshCatches = FishProduct::where('status', 'active')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $featuredFishermen = Fisher::inRandomOrder()
            ->with('user')
            ->take(4)
            ->get();

        $recentOrders = [];
        if (Auth::check() && Auth::user()->consumer) {
            $recentOrders = Order::where('consumer_id', Auth::user()->consumer->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }

        return view('content.dashboard.consumer-dashboard', compact('freshCatches', 'featuredFishermen', 'recentOrders'));
    }

    public function fisherman(Request $request)
    {
        $user = auth()->user()->load('fisher');

        if (!$user->fisher) {
            abort(404, 'Fisher profile not found.');
        }

        $user->fisher->bank_name = $this->safeDecrypt($user->fisher->bank_name);
        $user->fisher->account_holder = $this->safeDecrypt($user->fisher->account_holder);
        $user->fisher->account_number = $this->safeDecrypt($user->fisher->account_number);

        $activeListings = FishProduct::where('fisher_id', $user->fisher->id)
            ->where('status', 'Active')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $recentOrders = Order::whereHas('orderItems.fishProduct', function ($q) use ($user) {
                $q->where('fisher_id', $user->fisher->id);
            })
            ->with(['consumer', 'orderItems.fishProduct'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $topCustomers = $recentOrders
            ->groupBy('consumer_id')
            ->map(function ($orders, $consumerId) {
                $consumer = $orders->first()->consumer;
                return (object)[
                    'consumer' => $consumer,
                    'orders_count' => $orders->count(),
                    'total_spent' => $orders->sum('total_price'),
                ];
            })
            ->sortByDesc('total_spent')
            ->take(2)
            ->values();

        $period = $request->input('period', 'this_month');
        $now = now();

        switch ($period) {
            case 'this_week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $earningsPeriodText = 'This Week';
                break;

            case 'last_3_months':
                $startDate = $now->copy()->subMonths(3)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $earningsPeriodText = 'Last 3 Months';
                break;

            case 'this_month':
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $earningsPeriodText = $now->format('F Y');
                break;
        }

        $totalEarnings = \DB::table('fisher_earnings')
            ->where('fisher_id', $user->fisher->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('net_earning');

        if ($period === 'this_week') {
            $prevStart = $now->copy()->subWeek()->startOfWeek();
            $prevEnd = $now->copy()->subWeek()->endOfWeek();
        } elseif ($period === 'last_3_months') {
            $prevStart = $now->copy()->subMonths(6)->startOfMonth();
            $prevEnd = $now->copy()->subMonths(3)->endOfMonth();
        } else {
            $prevStart = $now->copy()->subMonth()->startOfMonth();
            $prevEnd = $now->copy()->subMonth()->endOfMonth();
        }

        $previousEarnings = \DB::table('fisher_earnings')
            ->where('fisher_id', $user->fisher->id)
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('net_earning');

        if ($previousEarnings == 0) {
            $earningsChangePercent = $totalEarnings > 0 ? 100 : 0;
        } else {
            $earningsChangePercent = (($totalEarnings - $previousEarnings) / $previousEarnings) * 100;
        }

        $earningsByDate = \App\Models\FisherEarning::where('fisher_id', $user->fisher->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($item) use ($period) {
                return $period === 'this_week'
                    ? $item->created_at->format('D') 
                    : $item->created_at->format('M d'); 
            })
            ->map(function ($group) {
                return $group->sum('net_earning');
            });

        $chartLabels = $earningsByDate->keys()->toArray();
        $chartValues = $earningsByDate->values()->toArray();

        return view('content.dashboard.fisherman-dashboard', compact(
            'user',
            'activeListings',
            'recentOrders',
            'topCustomers',
            'totalEarnings',
            'earningsChangePercent',
            'earningsPeriodText',
            'period',
            'chartLabels',
            'chartValues'
        ));
    }
    
    public function profile()
    {
        $user = Auth::user();

        if ($user->role === 'Consumer') {
            $profile = $user->consumer; 
        } elseif ($user->role === 'Fisher') {
            $profile = $user->fisher; 

            if ($profile) {
                $profile->bank_name = $this->safeDecrypt($profile->bank_name);
                $profile->account_holder = $this->safeDecrypt($profile->account_holder);
                $profile->account_number = $this->safeDecrypt($profile->account_number);
            }
        } else {
            $profile = null;
        }

        return view('content.consumer.consumer-profile', compact('user', 'profile'));
    }
    
    public function editProfile()
    {
        $user = Auth::user();

        if ($user->role === 'Consumer') {
            $profile = $user->consumer;
        } elseif ($user->role === 'Fisher') {
            $profile = $user->fisher;

            if ($profile) {
                $profile->bank_name = $this->safeDecrypt($profile->bank_name);
                $profile->account_holder = $this->safeDecrypt($profile->account_holder);
                $profile->account_number = $this->safeDecrypt($profile->account_number);
            }
        } else {
            $profile = null;
        }

        return view('content.consumer.consumer-profile-edit', compact('user', 'profile'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'Consumer') {
            $this->validateConsumerProfile($request);
        } else if ($user->role === 'Fisher') {
            $this->validateFisherProfile($request);
        } else {
            return redirect()->route('profile')->with('error', 'Invalid user role');
        }
        

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        }
        
        if ($user->role === 'Consumer') {
            $this->updateConsumerProfile($user, $request, $profilePhotoPath);
        } else if ($user->role === 'Fisher') {
            $this->updateFisherProfile($user, $request, $profilePhotoPath);
        }
        
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
    
    private function validateConsumerProfile(Request $request)
    {
        return $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'delivery_instructions' => 'nullable|string|max:500',
            'preferred_fish_types' => 'nullable|array',
            'dietary_restrictions' => 'nullable|string|max:500',
            'preferred_payment_method' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
    
    private function validateFisherProfile(Request $request)
    {
        return $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'fishing_license' => 'nullable|string|max:100',
            'fisher_type' => 'nullable|string|max:50',
            'boat_name' => 'nullable|string|max:100',
            'fishing_area' => 'nullable|string|max:255',
            'fishing_experience_years' => 'nullable|integer|min:0',
            'display_name' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'fish_types' => 'nullable|array',
            'quantity_per_catch' => 'nullable|string|max:50',
            'sustainable_method' => 'nullable|string|max:500',
            'payout_method' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:100',
            'account_holder' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
    
    private function updateConsumerProfile($user, $request, $profilePhotoPath = null)
    {

        $profile = Consumer::firstOrNew(['user_id' => $user->id]);
        

        $profile->full_name = $request->full_name;
        $profile->phone = $request->phone;
        

        $profile->street = $request->street;
        $profile->barangay = $request->barangay;
        $profile->city = $request->city;
        $profile->province = $request->province;
        $profile->zip_code = $request->zip_code;

        $profile->delivery_instructions = $request->delivery_instructions;
        $profile->preferred_fish_types = $request->preferred_fish_types ? json_encode($request->preferred_fish_types) : null;
        $profile->dietary_restrictions = $request->dietary_restrictions;
        $profile->preferred_payment_method = $request->preferred_payment_method;
        
    
        if ($profilePhotoPath) {

            if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $profile->profile_photo = $profilePhotoPath;
        }
        
        $profile->save();
        
        return $profile;
    }
    
    private function updateFisherProfile($user, $request, $profilePhotoPath = null)
    {
       
        $profile = Fisher::firstOrNew(['user_id' => $user->id]);
        
       
        $profile->full_name = $request->full_name;
        $profile->phone = $request->phone;
        
        $profile->fishing_license = $request->fishing_license;
        $profile->fisher_type = $request->fisher_type;
        $profile->boat_name = $request->boat_name;
        $profile->fishing_area = $request->fishing_area;
        $profile->fishing_experience_years = $request->fishing_experience_years;
        $profile->display_name = $request->display_name;
        $profile->bio = $request->bio;
        $profile->fish_types = $request->fish_types ? json_encode($request->fish_types) : null;
        $profile->quantity_per_catch = $request->quantity_per_catch;
        $profile->sustainable_method = $request->sustainable_method;
        $profile->payout_method = $request->payout_method;

        if ($request->payout_method === 'Bank Transfer') {
            $profile->bank_name = $this->safeEncrypt($request->bank_name);
            $profile->account_holder = $this->safeEncrypt($request->account_holder);
            $profile->account_number = $this->safeEncrypt($request->account_number);
        }
        

        if ($profilePhotoPath) {
            
            if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $profile->profile_photo = $profilePhotoPath;
        }
        
        $profile->save();
        
        return $profile;
    }
}
