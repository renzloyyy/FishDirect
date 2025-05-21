<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use Illuminate\Http\Request;
use App\Models\FishProduct;
use App\Models\Fisher;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ConsumerController extends Controller
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

        try {
            return Crypt::encryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function index()
    {
        return view('content.consumer.profile');
    }

    public function myOrder()
    {
        $user = Auth::user();
        $consumer = $user->consumer;

        if (!$consumer) {
            return redirect()->back()->with('error', 'Consumer profile not found.');
        }

        $orders = Order::with(['orderItems.fishProduct'])
                      ->where('consumer_id', $consumer->id)
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('content.consumer.my-order', compact('orders'));
    }

    public function orderDetails($orderId)
    {
        $user = Auth::user();
        $consumer = $user->consumer;

        if (!$consumer) {
            return redirect()->back()->with('error', 'Consumer profile not found.');
        }

        $order = Order::with(['orderItems.fishProduct'])
                     ->where('id', $orderId)
                     ->where('consumer_id', $consumer->id)
                     ->firstOrFail();

        return view('content.consumer.order-details', compact('order'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'delivery_instructions' => 'nullable|string',
            'preferred_fish_types' => 'nullable|array',
            'preferred_fish_types.*' => 'string',
            'dietary_restrictions' => 'nullable|string|max:255',
            'preferred_payment_method' => 'nullable|in:Card,e-Wallet,Cash on Delivery,In-App Wallet',
            'agreed_terms' => 'accepted',
        ]);

        try {
            $fishTypesJson = isset($validated['preferred_fish_types']) ? json_encode($validated['preferred_fish_types']) : null;

            
            $encryptedPhone = $this->safeEncrypt($validated['phone'] ?? null);
            $encryptedDeliveryInstructions = $this->safeEncrypt($validated['delivery_instructions'] ?? null);
            $encryptedDietaryRestrictions = $this->safeEncrypt($validated['dietary_restrictions'] ?? null);

            $consumer = Consumer::where('user_id', auth()->id())->first();

            if ($consumer) {
                $consumer->update([
                    'full_name' => $validated['full_name'],
                    'phone' => $encryptedPhone,
                    'street' => $validated['street'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'zip_code' => $validated['zip_code'],
                    'delivery_instructions' => $encryptedDeliveryInstructions,
                    'preferred_fish_types' => $fishTypesJson,
                    'dietary_restrictions' => $encryptedDietaryRestrictions,
                    'preferred_payment_method' => $validated['preferred_payment_method'],
                    'agreed_terms' => $request->agreed_terms,
                ]);
            } else {
                $consumer = Consumer::create([
                    'user_id' => auth()->id(),
                    'full_name' => $validated['full_name'],
                    'phone' => $encryptedPhone,
                    'street' => $validated['street'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'zip_code' => $validated['zip_code'],
                    'delivery_instructions' => $encryptedDeliveryInstructions,
                    'preferred_fish_types' => $fishTypesJson,
                    'dietary_restrictions' => $encryptedDietaryRestrictions,
                    'preferred_payment_method' => $validated['preferred_payment_method'],
                    'agreed_terms' => $request->agreed_terms,
                ]);
            }
            return redirect()->route('consumer-dashboard')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error saving consumer profile: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was an issue saving your profile. Please try again.']);
        }
    }

    public function showProfile()
    {
        $user = auth()->user()->load('consumer');

        if ($user->consumer) {
            $user->consumer->phone = $this->safeDecrypt($user->consumer->phone);
            $user->consumer->delivery_instructions = $this->safeDecrypt($user->consumer->delivery_instructions);
            $user->consumer->dietary_restrictions = $this->safeDecrypt($user->consumer->dietary_restrictions);
            if ($user->consumer->preferred_fish_types) {
                $user->consumer->preferred_fish_types = json_decode($user->consumer->preferred_fish_types, true);
            }
        }

        return view('content.consumer-dashboard', compact('user'));
    }

    public function deliveryFaq()
    {
        return view('content.consumer.delivery-faq');
    }

    public function aboutUs()
    {
        return view('content.consumer.about-us');
    }
    public function profile()
    {
    $user = Auth::user();

    if ($user->role === 'Consumer') {
        $profile = $user->consumer; 
    } elseif ($user->role === 'Fisher') {
        $profile = $user->fisher; 
    } else {
        $profile = null;
    }

    return view('content.consumer.consumer-profile', compact('user', 'profile'));
    }
    public function freshCatches(Request $request)
    {
      
       $fishermen = Fisher::select('id', 'full_name', 'display_name', 'profile_photo')
                        ->where('user_id', '!=', null)
                        ->get();
    
        $fishTypes = FishProduct::select('name')
                            ->where('status', 'Active')
                            ->where('stock_kg', '>', 0)
                            ->distinct()
                            ->orderBy('name')
                            ->pluck('name');
        
        $query = FishProduct::with(['fisher' => function($query) {
                    $query->select('id', 'full_name', 'display_name', 'profile_photo', 'fishing_area');
                }])
                ->where('status', 'Active')
                ->where('stock_kg', '>', 0);
   
        if ($request->has('fishType') && !empty($request->fishType)) {
            $query->where('name', $request->fishType);
        }

        if ($request->has('priceRange') && !empty($request->priceRange)) {
            $priceRange = explode('-', $request->priceRange);
            if (count($priceRange) == 2) {
                $minPrice = $priceRange[0];
                $maxPrice = $priceRange[1];
                $query->whereBetween('price_per_kg', [$minPrice, $maxPrice]);
            } elseif (str_contains($request->priceRange, '+')) {
                $minPrice = str_replace('+', '', $request->priceRange);
                $query->where('price_per_kg', '>=', $minPrice);
            }
        }
        
        if ($request->has('fisherman') && !empty($request->fisherman)) {
            $query->where('fisher_id', $request->fisherman);
        }
        
        if ($request->has('freshness') && !empty($request->freshness)) {
            $today = now()->startOfDay();
            $yesterday = now()->subDay()->startOfDay();
            $weekAgo = now()->subWeek()->startOfDay();
            
            switch($request->freshness) {
                case 'today':
                    $query->whereDate('catch_date', $today);
                    break;
                case 'yesterday':
                    $query->whereDate('catch_date', $yesterday);
                    break;
                case 'week':
                    $query->whereDate('catch_date', '>=', $weekAgo);
                    break;
            }
        }
    
        if ($request->has('quickFilter') && !empty($request->quickFilter)) {
            switch($request->quickFilter) {
                case 'sustainable':
                    $query->whereHas('fisher', function($q) {
                        $q->where('sustainable_method', true);
                    });
                    break;
                case 'bestseller':
                    $query->orderBy('popularity', 'desc');
                    break;
                case 'discount':
                    $query->where('discount_percent', '>', 0);
                    break;
                case 'season':
                    $currentMonth = now()->month;
                    $query->where(function($q) use ($currentMonth) {
                        $q->whereJsonContains('season_months', $currentMonth)
                        ->orWhere('always_in_season', true);
                    });
                    break;
            }
        }
    
        if ($request->has('sort') && !empty($request->sort)) {
            switch($request->sort) {
                case 'price_low':
                    $query->orderBy('price_per_kg', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price_per_kg', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('popularity', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $itemsPerView = $request->has('itemsPerView') ? $request->itemsPerView : '12';
        if ($itemsPerView !== 'all') {
            $query->limit((int)$itemsPerView);
        }

        $freshCatches = $query->get();

        foreach($freshCatches as $product) {
            $product->is_sustainable = $product->fisher && 
                                    $product->fisher->sustainable_method ? true : false;

            $product->sustainability_rating = $product->is_sustainable ? 
                                            rand(3, 5) : 
                                            rand(1, 3);
        }

          if ($request->ajax()) {
                return response()->json([
                    'html' => view('content.consumer.partials.product-grid', compact('freshCatches'))->render(),
                    'count' => $freshCatches->count()
                ]);
            }
        
        return view('content.consumer.fresh-catches', compact('freshCatches', 'fishermen', 'fishTypes'));
    }
}
