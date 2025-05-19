<!DOCTYPE html>
<html>
<head>
    <title>My Catch Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>My Catch Report</h1>
    <p>Fisher: {{ $user->fisher->full_name }}</p>
    <p>Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

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
            @foreach($myCatches as $catch)
            <tr>
                <td>{{ $catch->name }}</td>
                <td>₱{{ number_format($catch->price_per_kg, 2) }}</td>
                <td>{{ $catch->stock_kg }}</td>
                <td>{{ ucfirst($catch->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($catch->catch_date)->format('F d, Y') }}</td>
                <td>{{ $catch->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
