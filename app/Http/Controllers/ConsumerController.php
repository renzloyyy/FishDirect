<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use Illuminate\Http\Request;
use App\Models\FishProduct;
use App\Models\Fisher;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class ConsumerController extends Controller
{
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

        // Fetch orders with their items and the associated fish products
        $orders = Order::with(['orderItems.fishProduct'])
                      ->where('consumer_id', $consumer->id)
                      ->orderBy('created_at', 'desc')
                      ->get();

        // Return the view with orders
        return view('content.consumer.my-order', compact('orders'));
    }

    public function orderDetails($orderId)
    {
        $user = Auth::user();
        $consumer = $user->consumer;

        if (!$consumer) {
            return redirect()->back()->with('error', 'Consumer profile not found.');
        }

        // Get the order details, ensuring it belongs to the current consumer
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
            
            $consumer = Consumer::where('user_id', auth()->id())->first();

            if ($consumer) {
                $consumer->update([
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'street' => $validated['street'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'zip_code' => $validated['zip_code'],
                    'delivery_instructions' => $validated['delivery_instructions'],
                    'preferred_fish_types' => $fishTypesJson,
                    'dietary_restrictions' => $validated['dietary_restrictions'],
                    'preferred_payment_method' => $validated['preferred_payment_method'],
                    'agreed_terms' => $request->agreed_terms,
                ]);
            } else {
                $consumer = Consumer::create([
                    'user_id' => auth()->id(),
                    'full_name' => $validated['full_name'],
                    'phone' => $validated['phone'],
                    'street' => $validated['street'],
                    'barangay' => $validated['barangay'],
                    'city' => $validated['city'],
                    'province' => $validated['province'],
                    'zip_code' => $validated['zip_code'],
                    'delivery_instructions' => $validated['delivery_instructions'],
                    'preferred_fish_types' => $fishTypesJson,
                    'dietary_restrictions' => $validated['dietary_restrictions'],
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
   
}