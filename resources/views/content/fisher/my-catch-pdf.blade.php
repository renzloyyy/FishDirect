<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Catch Report</title>
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
        .fisher-info {
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>FISHDIRECT - My Catch Report</h1>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="fisher-info">
        <p><strong>Fisher:</strong> {{ $user->fisher->full_name }}</p>
    </div>

    <h2>Catch Records</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price (₱/kg)</th>
                <th>Stock (kg)</th>
                <th>Status</th>
                <th>Catch Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($myCatches as $catch)
            <tr>
                <td>{{ $catch->name }}</td>
                <td>₱{{ number_format($catch->price_per_kg, 2) }}</td>
                <td>{{ $catch->stock_kg }}</td>
                <td>{{ ucfirst($catch->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($catch->catch_date)->format('F d, Y') }}</td>
                <td>{{ $catch->description }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No catch records available.</td>
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
