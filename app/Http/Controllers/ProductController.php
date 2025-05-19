<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishProduct;
use App\Models\Fisher;
use App\Models\User;
use App\Models\Order;
use App\Models\Consumer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
   public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:fish_products,id',
            'quantity' => 'required|numeric|min:0.5'
        ]);

        $product = FishProduct::findOrFail($request->product_id);

        if ($product->stock_kg < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Not enough stock. Available: {$product->stock_kg}kg"
            ], 400);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to add items to cart.'
            ], 401);
        }

        DB::beginTransaction();

        try {
            $consumer = Consumer::where('user_id', $user->id)->first();

            if (!$consumer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Consumer profile not found for this user.'
                ], 404);
            }

            // Retrieve or create order item (cart item)
            $item = OrderItem::firstOrNew([
                'consumer_id' => $consumer->id,
                'fish_product_id' => $product->id,
                'order_id' => null,
            ]);

            // Increase quantity in cart
            $item->quantity_kg = ($item->quantity_kg ?? 0) + $request->quantity;
            $item->price_per_kg = $product->price_per_kg;
            $item->subtotal = $item->quantity_kg * $item->price_per_kg;
            $item->image_path = $product->image_path;
            $item->save();

            // Deduct the quantity from the original product stock
            $product->stock_kg -= $request->quantity;

            // Optionally update status if stock hits zero or below
            if ($product->stock_kg <= 0) {
                $product->stock_kg = 0;
                $product->status = 'SoldOut';
            }

            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart.',
                'cartCount' => OrderItem::where('consumer_id', $consumer->id)
                                    ->whereNull('order_id')
                                    ->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
