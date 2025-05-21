<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Earnings Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 18px;
            margin: 0;
            color: #0056b3;
        }
        .fisher-info {
            margin-bottom: 20px;
        }
        .summary {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .summary-table {
            width: 100%;
        }
        .summary-table td {
            padding: 5px;
        }
        .date-range {
            margin-bottom: 15px;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-pending {
            color: #e49100;
        }
        .status-processing {
            color: #066db5;
        }
        .status-completed {
            color: #008a00;
        }
        .status-failed {
            color: #d70000;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FISHDIRECT - Earnings Report</h1>
        <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>
    
    <div class="fisher-info">
        <h2>Fisher Information</h2>
        <p><strong>Name:</strong> {{ $user->fisher->full_name }}</p>
        <p><strong>Contact:</strong> {{ $user->fisher->phone }}</p>
        <p><strong>Fisher Type:</strong> {{ $user->fisher->fisher_type }}</p>
        <p><strong>Fishing Area:</strong> {{ $user->fisher->fishing_area }}</p>
    </div>
    
    <div class="summary">
        <h2>Earnings Summary</h2>
        <div class="date-range">
            <p>Report Period: {{ $fromDate }} to {{ $toDate }}</p>
        </div>
        <table class="summary-table">
            <tr>
                <td width="33%"><strong>Gross Earnings:</strong> P{{ number_format($grossEarnings, 2) }}</td>
                <td width="33%"><strong>Platform Fees:</strong> P{{ number_format($platformFees, 2) }}</td>
                <td width="33%"><strong>Net Earnings:</strong> P{{ number_format($totalEarnings, 2) }}</td>
            </tr>
        </table>
    </div>
    
    <h2>Earnings Details</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Product</th>
                <th>Quantity (kg)</th>
                <th>Price (P/kg)</th>
                <th>Total (P)</th>
                <th>Platform Fee (P)</th>
                <th>Net (P)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($earnings as $earning)
            <tr>
                <td>#{{ $earning->order_id }}</td>
                <td>{{ $earning->created_at->format('M d, Y') }}</td>
                <td>{{ $earning->product_name }}</td>
                <td>{{ number_format($earning->quantity_kg, 2) }}</td>
                <td>P{{ number_format($earning->price_per_kg, 2) }}</td>
                <td>P{{ number_format($earning->total_earning, 2) }}</td>
                <td>P{{ number_format($earning->platform_fee, 2) }}</td>
                <td>P{{ number_format($earning->net_earning, 2) }}</td>
                <td class="status-{{ $earning->payout_status }}">
                    {{ ucfirst($earning->payout_status) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">No earnings data available for this period</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>FishDirect - Connecting Fishers Directly to Consumers</p>
        <p>This is an automatically generated report and requires no signature.</p>
    </div>
</body>
</html>