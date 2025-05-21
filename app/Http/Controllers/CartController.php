<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\FishProduct;
use App\Models\Consumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher;

class CartController extends Controller
{
    public function viewCartPage()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view the cart.');
        }

        $consumer = Consumer::where('user_id', $user->id)->first();

        if (!$consumer) {
            return redirect()->back()->with('error', 'Consumer profile not found.');
        }

        $cartItems = OrderItem::with('fishProduct')
            ->where('consumer_id', $consumer->id)
            ->whereNull('order_id')
            ->get();

        $cartProductIds = $cartItems->pluck('fish_product_id')->toArray();

        $recommendedProducts = FishProduct::where('status', 'active')
            ->whereNotIn('id', $cartProductIds)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $availableVouchers = Voucher::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->get();

        $subtotal = $cartItems->sum(fn($i) => $i->quantity_kg * $i->price_per_kg);

        $promoType = session('promo_type', null);
        $promoValue = session('promo_value', null);
        $discount = 0;

        if ($promoType && $promoValue) {
            if ($promoType === 'percentage') {
                $discount = ($promoValue / 100) * $subtotal;
            } elseif ($promoType === 'fixed') {
                $discount = $promoValue;
            }
        }

        $discount = min($discount, $subtotal);
        $subtotalAfterDiscount = max(0, $subtotal - $discount);

        $shipping = 80;
        $tax = round($subtotalAfterDiscount * 0.10);
        $total = $subtotalAfterDiscount + $shipping + $tax;

        return view('content.consumer.add-to-cart', compact(
            'cartItems',
            'recommendedProducts',
            'availableVouchers',
            'subtotal',
            'discount',
            'shipping',
            'tax',
            'total'
        ));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to checkout.');
        }

        $consumer = $user->consumer;

        if (!$consumer) {
            return redirect()->back()->with('error', 'Consumer profile not found.');
        }

        $cartItems = OrderItem::where('consumer_id', $consumer->id)
            ->whereNull('order_id')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity_kg * $item->price_per_kg);

        $promoType = session('promo_type', null);
        $promoValue = session('promo_value', null);
        $discountAmount = 0;

        if ($promoType && $promoValue) {
            if ($promoType === 'percentage') {
                $discountAmount = ($promoValue / 100) * $subtotal;
            } elseif ($promoType === 'fixed') {
                $discountAmount = $promoValue;
            }
        }

        $discountAmount = min($discountAmount, $subtotal);
        $subtotalAfterDiscount = max(0, $subtotal - $discountAmount);

        $shipping = 80;
        $tax = round($subtotalAfterDiscount * 0.10);
        $total = $subtotalAfterDiscount + $shipping + $tax;

        DB::beginTransaction();

        try {
            $paymentMethod = match ($request->input('payment_method')) {
                'cash_on_delivery', 'cod' => 'cod',
                'gcash' => 'gcash',
                'bank_transfer' => 'bank_transfer',
                default => throw new \Exception("Invalid payment method."),
            };

            $order = Order::create([
                'consumer_id' => $consumer->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'delivery_address' => $request->input('street') . ', ' .
                    $request->input('barangay') . ', ' .
                    $request->input('city') . ', ' .
                    $request->input('province') . ' ' .
                    $request->input('zip_code'),
                'delivery_instructions' => $request->input('delivery_instructions'),
                'promo_code' => session('promo_code'),
            ]);

            foreach ($cartItems as $item) {
                $item->order_id = $order->id;
                $item->subtotal = $item->quantity_kg * $item->price_per_kg;
                $item->save();

                FishProduct::where('id', $item->fish_product_id)
                    ->decrement('stock_kg', $item->quantity_kg);
            }

            DB::commit();

            session()->forget(['promo_code', 'promo_type', 'promo_value']);

            return redirect()->route('orders.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function apply(Request $request)
    {
        $code = $request->input('promo_code');
        $subtotal = $request->input('subtotal');

        $voucher = Voucher::where('code', $code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Invalid or expired promo code.');
        }

        if ($voucher->minimum_order_amount && $subtotal < $voucher->minimum_order_amount) {
            return redirect()->back()->with('error', 'Minimum order not met for this promo.');
        }

        session([
            'promo_code' => $voucher->code,
            'promo_type' => $voucher->type,
            'promo_value' => $voucher->discount,
        ]);

        return redirect()->back()->with('success', 'Promo code applied.');
    }
}
