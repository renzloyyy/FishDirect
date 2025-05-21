<?php

namespace App\Http\Controllers;

use App\Models\Fisher;
use App\Models\FisherEarning;
use App\Models\Order;
use App\Models\FishProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FishermanController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('fisher');
        $activeListings = FishProduct::where('fisher_id', Auth::user()->fisher->id)
                                    ->where('status', 'active')
                                    ->inRandomOrder()
                                    ->take(3)
                                    ->get();
        return view('content.dashboard.fisherman-dashboard', compact('user', 'activeListings'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'fishing_license' => 'nullable|string|max:100',
            'fisher_type' => 'required|in:Small-scale,Deep sea,Inland,Aquaculture',
            'boat_name' => 'nullable|string|max:100',
            'fishing_area' => 'nullable|string|max:100',
            'fishing_experience_years' => 'nullable|integer',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|file|image|max:2048',
            'fish_types' => 'nullable|array',
            'fish_types.*' => 'string',
            'quantity_per_catch' => 'nullable|string|max:100',
            'sustainable_method' => 'nullable|string|in:Net Fishing,Line Fishing,Trap Fishing,Spear Fishing,Multiple Methods',
            'payout_method' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'account_holder' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:100',
            'agreed_terms' => 'accepted',
        ]);


        try {
            $fishTypesJson = isset($validated['fish_types']) ? json_encode($validated['fish_types']) : null;
            
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            }

            $fisher = Fisher::where('user_id', auth()->id())->first();

            $profileData = [
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'fishing_license' => $validated['fishing_license'] ?? null,
                'fisher_type' => $validated['fisher_type'],
                'boat_name' => $validated['boat_name'] ?? null,
                'fishing_area' => $validated['fishing_area'] ?? null,
                'fishing_experience_years' => $validated['fishing_experience_years'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'fish_types' => $fishTypesJson,
                'quantity_per_catch' => $validated['quantity_per_catch'] ?? null,
                'sustainable_method' => $validated['sustainable_method'] ?? null,
                'payout_method' => $validated['payout_method'] ?? null,
                'bank_name' => $validated['bank_name'] ?? null,
                'account_holder' => $validated['account_holder'] ?? null,
                'account_number' => $validated['account_number'] ?? null,
                'agreed_terms' => true,
                'is_profile_complete' => true,
            ];
            
            if ($profilePhotoPath) {
                $profileData['profile_photo'] = $profilePhotoPath;
            }

            if ($fisher) {
                $fisher->update($profileData);
            } else {
                $profileData['user_id'] = auth()->id();
                $fisher = Fisher::create($profileData);
            }

            return redirect()->route('fisherman-dashboard')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error saving fisher profile: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was an issue saving your profile. Please try again.']);
        }
    }
    
    public function showDashboard()
    {
        $user = auth()->user()->load('fisher');
     
        $activeListings = FishProduct::where('fisher_id', $user->fisher->id)
                                      ->where('status', 'active')
                                      ->inRandomOrder()
                                      ->take(3)
                                      ->get();
    
        return view('content.dashboard.fisherman-dashboard', compact('user', 'activeListings'));
    }
    
    public function fisherFaq()
    {
        return view('content.fisher.fisher-faq');
    }
    
    public function storeCatch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_kg' => 'required|numeric|min:0',
            'stock_kg' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,sold_out,reserved',
            'catch_date' => 'required|date',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('assets/img/illustrations/' . $imageName);
            $image->move(public_path('assets/img/illustrations'), $imageName);
            $validated['image_path'] = 'assets/img/illustrations/' . $imageName;
        }

        $product = new FishProduct();
        $product->fisher_id = Auth::user()->fisher->id; 
        $product->name = $validated['name'];
        $product->price_per_kg = $validated['price_per_kg'];
        $product->stock_kg = $validated['stock_kg'];
        $product->status = $validated['status'];
        $product->catch_date = $validated['catch_date'];
        $product->description = $validated['description'];
        $product->image_path = $validated['image_path'];
        $product->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Catch added successfully',
                'catch' => $product
            ], 201);
        }
        return redirect()->back()->with('swalSuccess', 'Your catch has been listed successfully!');
    }
    
    public function myCatch()
    {
        $user = auth()->user()->load('fisher');
        
        $activeListings = FishProduct::where('fisher_id', $user->fisher->id)
            ->orderBy('catch_date', 'desc')
            ->paginate(12);
        
        return view('content.fisher.my-catch', compact('activeListings'));
    }
    
    public function updateCatch(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_kg' => 'required|numeric|min:0',
            'stock_kg' => 'required|numeric|min:0',
            'status' => 'required|string|in:Active,SoldOut',
            'catch_date' => 'required|date',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = FishProduct::where('id', $id)
            ->where('fisher_id', Auth::user()->fisher->id)
            ->firstOrFail();

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/illustrations'), $imageName);
            $validated['image_path'] = 'assets/img/illustrations/' . $imageName;
        }

        $product->update($validated);

        return redirect()->back()->with('swalSuccess', 'Catch updated successfully!');
    }
    
    public function viewOrder()
    {
        $user = auth()->user()->load('fisher');

        $recentOrders = Order::whereHas('orderItems.fishProduct', function ($q) use ($user) {
            $q->where('fisher_id', $user->fisher->id);
        })
        ->with(['consumer', 'orderItems.fishProduct'])
        ->orderBy('created_at', 'desc')
        ->paginate(20); 

        return view('content.fisher.order', compact('recentOrders'));
    }
    
    public function confirm(Order $order)
    {
        $order->status = 'confirmed';
        $order->save();

        return response()->json(['success' => true, 'new_status' => 'confirmed']);
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            ]);

            $old_status = $order->status;
            $order->status = $validated['status'];
            $order->save();

            
            if ($validated['status'] === 'delivered' && $old_status !== 'delivered') {
                $earningsController = new EarningsController();
                $earningsController->createEarningsRecords($order);
            }

            return response()->json(['success' => true, 'new_status' => $order->status]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function showEarnings(Request $request)
    {
        $earningsController = new EarningsController();
        return $earningsController->index($request);
    }
    
    public function exportEarningsPdf(Request $request)
    {
        $earningsController = new EarningsController();
        return $earningsController->exportPdf($request);
    }
    
    public function exportPdf()
    {
        $user = auth()->user();

        if (!$user || !$user->fisher) {
            abort(403, 'Unauthorized action.');
        }
        
        $recentOrders = Order::whereHas('orderItems.fishProduct', function ($query) use ($user) {
            $query->where('fisher_id', $user->fisher->id);
        })
        ->with('consumer', 'orderItems.fishProduct')
        ->latest()
        ->get();

        $pdf = Pdf::loadView('content.fisher.pdf', compact('recentOrders'));

        return $pdf->download('recent-orders.pdf');
    }
    
    public function filterMyCatch(Request $request) 
    {
        $user = auth()->user()->load('fisher');
        
        $activeListings = FishProduct::where('fisher_id', $user->fisher->id);
        
        if ($request->filled('fish_type')) {
            $activeListings->where('name', $request->fish_type);
        }

        if ($request->filled('date_from')) {
            $activeListings->whereDate('catch_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $activeListings->whereDate('catch_date', '<=', $request->date_to);
        }

        if ($request->filled('price_min')) {
            $activeListings->where('price_per_kg', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $activeListings->where('price_per_kg', '<=', $request->price_max);
        }

        if ($request->filled('stock_min')) {
            $activeListings->where('stock_kg', '>=', $request->stock_min);
        }
        
        if ($request->filled('stock_max')) {
            $activeListings->where('stock_kg', '<=', $request->stock_max);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $activeListings->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $activeListings->orderBy('catch_date', 'asc');
                break;
            case 'price_high':
                $activeListings->orderBy('price_per_kg', 'desc');
                break;
            case 'price_low':
                $activeListings->orderBy('price_per_kg', 'asc');
                break;
            case 'name_asc':
                $activeListings->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $activeListings->orderBy('name', 'desc');
                break;
            case 'stock_high':
                $activeListings->orderBy('stock_kg', 'desc');
                break;
            case 'stock_low':
                $activeListings->orderBy('stock_kg', 'asc');
                break;
            case 'newest':
            default:
                $activeListings->orderBy('catch_date', 'desc');
                break;
        }
        
        $activeListings = $activeListings->paginate(12)->withQueryString();
        
        return view('content.fisher.my-catch', compact('activeListings'));
    }
    
    public function exportcatchpdf()
    {
        $user = auth()->user();

        if (!$user || !$user->fisher) {
            abort(403, 'Unauthorized action.');
        }

        $myCatches = FishProduct::where('fisher_id', $user->fisher->id)
            ->orderBy('catch_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('content.fisher.my-catch-pdf', compact('myCatches', 'user'));

        return $pdf->download('my-catch-report.pdf');
    }
    public function updateMyCatch(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'price_per_kg' => 'required|numeric|min:0',
        'stock_kg' => 'required|numeric|min:0',
        'status' => 'required|string|in:Active,SoldOut', 
        'catch_date' => 'required|date',
        'description' => 'required|string',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = FishProduct::where('id', $id)
        ->where('fisher_id', Auth::user()->fisher->id)
        ->firstOrFail();

    
    $product->name = $validated['name'];
    $product->price_per_kg = $validated['price_per_kg'];
    $product->stock_kg = $validated['stock_kg'];
    $product->status = $validated['status'];
    $product->catch_date = $validated['catch_date'];
    $product->description = $validated['description'];

    
    if ($request->hasFile('image_path')) {
        
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            try {
                unlink(public_path($product->image_path));
            } catch (\Exception $e) {
                \Log::error('Failed to delete old image: ' . $e->getMessage());
            }
        }
        
        $image = $request->file('image_path');
        $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/img/illustrations'), $imageName);
        $product->image_path = 'assets/img/illustrations/' . $imageName;
    }

    $product->save();

    return redirect()->route('mycatch')->with('success', 'Catch updated successfully!');
}
public function destroyCatch($id) {
    try {
        $product = FishProduct::where('id', $id)
            ->where('fisher_id', Auth::user()->fisher->id)
            ->firstOrFail();
        
        
        if ($product->status !== 'sold out') {
            
            $hasOrders = DB::table('order_items')
                ->where('fish_product_id', $id)
                ->exists();
            
            if ($hasOrders) {
                return redirect()->route('mycatch')
                    ->with('error', 'This catch cannot be deleted as it has related orders.');
            }
        }
        
        
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            try {
                unlink(public_path($product->image_path));
            } catch (\Exception $e) {
                \Log::error('Failed to delete product image: ' . $e->getMessage());
            }
        }
        
        
        $product->delete();
        
        return redirect()->route('mycatch')
            ->with('success', 'Catch deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Error deleting catch: ' . $e->getMessage());
        return redirect()->route('mycatch')
            ->with('error', 'An error occurred while deleting this catch. Please try again.');
    }
}
}