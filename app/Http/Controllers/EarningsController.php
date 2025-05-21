<?php

namespace App\Http\Controllers;

use App\Models\FisherEarning;
use App\Models\Order;
use App\Models\Fisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EarningsController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user()->load('fisher');
        
        if (!$user || !$user->fisher) {
            return redirect()->route('auth-login-basic')->with('error', 'Fisher profile not found.');
        }
        
        $query = FisherEarning::where('fisher_id', $user->fisher->id);
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('status')) {
            $query->where('payout_status', $request->status);
        }
        
        
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest':
                $query->orderBy('net_earning', 'desc');
                break;
            case 'lowest':
                $query->orderBy('net_earning', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $earnings = $query->paginate(15)->withQueryString();
        
        
        $totalEarnings = FisherEarning::where('fisher_id', $user->fisher->id)->sum('net_earning');
        $pendingEarnings = FisherEarning::where('fisher_id', $user->fisher->id)
                                    ->where('payout_status', 'pending')
                                    ->sum('net_earning');
        $completedEarnings = FisherEarning::where('fisher_id', $user->fisher->id)
                                    ->where('payout_status', 'completed')
                                    ->sum('net_earning');
                                    
        
        $monthlyEarnings = FisherEarning::where('fisher_id', $user->fisher->id)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(net_earning) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        return view('content.fisher.earnings', compact(
            'earnings', 
            'totalEarnings', 
            'pendingEarnings', 
            'completedEarnings',
            'monthlyEarnings'
        ));
    }
    
    
    public function processDelivery(Order $order)
    {
        try {
            
            $user = Auth::user()->load('fisher');
            $belongsToFisher = $order->orderItems()->whereHas('fishProduct', function($q) use ($user) {
                $q->where('fisher_id', $user->fisher->id);
            })->exists();
            
            if (!$belongsToFisher) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized action'
                ], 403);
            }
            
        
            $oldStatus = $order->status;
            $order->status = 'delivered';
            $order->save();

            if ($oldStatus !== 'delivered') {
                $this->createEarningsRecords($order);
            }
            
            return response()->json([
                'success' => true, 
                'new_status' => 'delivered',
                'message' => 'Order marked as delivered and earnings recorded'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function createEarningsRecords(Order $order)
    {
        $platformFeePercentage = 0.10;
        $orderItems = $order->orderItems;
        $totalOrderSubtotal = $orderItems->sum('subtotal');
        $totalOrderDiscount = $order->voucher_discount ?? 0;

        $itemsByFisher = $orderItems->groupBy(function ($item) {
            return $item->fishProduct->fisher_id;
        });

        foreach ($itemsByFisher as $fisherId => $items) {
            foreach ($items as $item) {
                $itemSubtotal = $item->subtotal;

                
                $discountShare = $totalOrderSubtotal > 0
                    ? ($itemSubtotal / $totalOrderSubtotal) * $totalOrderDiscount
                    : 0;

                $discountedSubtotal = max(0, $itemSubtotal - $discountShare);
                $platformFee = $discountedSubtotal * $platformFeePercentage;
                $netEarning = $discountedSubtotal - $platformFee;

                FisherEarning::create([
                    'fisher_id' => $fisherId,
                    'order_id' => $order->id,
                    'product_name' => $item->fishProduct->name,
                    'quantity_kg' => $item->quantity_kg,
                    'price_per_kg' => $item->price_per_kg,
                    'total_earning' => $discountedSubtotal,
                    'platform_fee' => $platformFee,
                    'net_earning' => $netEarning,
                    'payout_status' => 'completed'
                ]);
            }
        }
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->fisher) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = FisherEarning::where('fisher_id', $user->fisher->id);
        

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('payout_status', $request->status);
        }
        
        $earnings = $query->orderBy('created_at', 'desc')->get();

        $totalEarnings = $earnings->sum('net_earning');
        $platformFees = $earnings->sum('platform_fee');
        $grossEarnings = $earnings->sum('total_earning');
        
        $fromDate = $request->filled('date_from') ? $request->date_from : 'All time';
        $toDate = $request->filled('date_to') ? $request->date_to : 'Present';
        
        $pdf = PDF::loadView('content.fisher.earnings-pdf', compact(
            'earnings', 
            'user',
            'totalEarnings',
            'platformFees',
            'grossEarnings',
            'fromDate',
            'toDate'
        ));

        return $pdf->download('earnings-report.pdf');
    }
  public function updatePayoutInfo(Request $request)
{
    $request->validate([
        'payout_method' => 'required|string',
        'bank_name' => 'nullable|string|required_if:payout_method,Bank Transfer',
        'account_holder' => 'required|string',
        'account_number' => 'required|string',
    ]);

    $fisher = auth()->user()->fisher;
    $fisher->payout_method = $request->payout_method;
    $fisher->bank_name = $request->bank_name;
    $fisher->account_holder = $request->account_holder;
    $fisher->account_number = $request->account_number;
    $fisher->save();

    return response()->json([
        'success' => true,
        'updatedFisher' => $fisher,
    ]);
}


    public function getEarningsAnalytics()
    {
        $user = Auth::user()->load('fisher');
        
        if (!$user || !$user->fisher) {
            return response()->json([
                'success' => false,
                'error' => 'Fisher profile not found'
            ], 404);
        }

        $earningsSummary = [
            'total' => FisherEarning::where('fisher_id', $user->fisher->id)->sum('net_earning'),
            'pending' => FisherEarning::where('fisher_id', $user->fisher->id)
                            ->where('payout_status', 'pending')
                            ->sum('net_earning'),
            'completed' => FisherEarning::where('fisher_id', $user->fisher->id)
                            ->where('payout_status', 'completed')
                            ->sum('net_earning'),
        ];
        
        $monthlyEarnings = FisherEarning::where('fisher_id', $user->fisher->id)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(net_earning) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'year' => $item->year,
                    'total' => $item->total
                ];
            });
            
        $topProducts = FisherEarning::where('fisher_id', $user->fisher->id)
            ->select(
                'product_name',
                DB::raw('SUM(quantity_kg) as total_kg'),
                DB::raw('SUM(net_earning) as total_earnings')
            )
            ->groupBy('product_name')
            ->orderBy('total_earnings', 'desc')
            ->take(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => [
                'summary' => $earningsSummary,
                'monthly' => $monthlyEarnings,
                'top_products' => $topProducts
            ]
        ]);
    }
}