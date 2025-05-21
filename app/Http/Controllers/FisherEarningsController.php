<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use Illuminate\Support\Facades\Auth;

class FisherEarningsController extends Controller
{
   public function showAnalytics()
    {
        $fisherId = Auth::user()->fisher->id;

        $totalEarnings = Earning::where('fisher_id', $fisherId)->sum('amount');
        $earningsByStatus = Earning::where('fisher_id', $fisherId)
            ->selectRaw('status, SUM(amount) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentEarnings = Earning::where('fisher_id', $fisherId)
            ->with('orderItem')
            ->latest()
            ->take(10)
            ->get();

        return view('content.fisher.earning', compact(
            'totalEarnings',
            'earningsByStatus',
            'recentEarnings'
        ));
    }
}
