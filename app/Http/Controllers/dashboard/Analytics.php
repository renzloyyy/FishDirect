<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FishProduct;
use App\Models\Fisher;
use App\Models\Consumer;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
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
      $recentOrders = \App\Models\Order::where('consumer_id', Auth::user()->consumer->id)
          ->orderBy('created_at', 'desc')
          ->take(3)
          ->get();
  }      
    return view('content.dashboard.consumer-dashboard', compact('freshCatches', 'featuredFishermen','recentOrders'));
  }
 public function fisherman()
    {
        $user = auth()->user()->load('fisher');

    
        $activeListings = FishProduct::where('fisher_id', $user->fisher->id)
                                    ->where('status', 'Active')
                                    ->inRandomOrder()
                                    ->take(3)
                                    ->get();


        $recentOrders = Order::whereHas('orderItems.fishProduct', function($q) use ($user) {
                $q->where('fisher_id', $user->fisher->id);
            })
            ->with(['consumer', 'orderItems.fishProduct'])
            ->orderBy('created_at', 'desc')
            ->limit(50)  // Fetch more to aggregate customers info
            ->get();


        $topCustomers = $recentOrders
            ->groupBy('consumer_id')
            ->map(function($orders, $consumerId) {
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

        return view('content.dashboard.fisherman-dashboard', compact('user', 'activeListings', 'recentOrders', 'topCustomers'));
    }
}
