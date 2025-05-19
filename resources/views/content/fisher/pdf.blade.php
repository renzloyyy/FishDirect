<!DOCTYPE html>
<html>
<head>
  <title>Recent Orders</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background-color: #f0f0f0; }
  </style>
</head>
<body>
  <h2>Recent Orders</h2>
  <table>
    <thead>
      <tr>
        <th>Order #</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($recentOrders as $order)
      <tr>
        <td>#ORD-{{ $order->id }}</td>
        <td>{{ $order->consumer->full_name ?? 'N/A' }}</td>
        <td>₱{{ number_format($order->total_price, 2) }}</td>
        <td>{{ ucfirst($order->status) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
