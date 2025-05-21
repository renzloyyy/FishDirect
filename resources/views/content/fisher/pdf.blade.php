<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recent Orders Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
        h1 {
            font-size: 18px;
            margin: 0;
            color: #0056b3;
        }
        h2 {
            font-size: 16px;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
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
        .status-cancelled {
            color: #d70000;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FISHDIRECT - Recent Orders Report</h1>
        <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <h2>Order List</h2>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount (₱)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td>#ORD-{{ $order->id }}</td>
                <td>{{ $order->consumer->full_name ?? 'N/A' }}</td>
                <td>₱{{ number_format($order->total_price, 2) }}</td>
                <td class="status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">No recent orders found.</td>
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
