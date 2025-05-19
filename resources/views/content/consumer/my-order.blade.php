@extends('layouts.contentNavbarLayout')

@section('title', 'My Orders')

@section('content')
<div class="container-xxl flex-grow-1 p-y">
  <div class="card">
    <div class="card-header bg-ocean-light">
      <h4 class="text-ocean-deep">My Orders</h4>
    </div>
    <div class="card-body">
      @if($orders->isEmpty())
        <div class="alert alert-info">You haven't placed any orders yet.</div>
      @else
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="bg-ocean-light text-ocean-deep">
              <tr>
                <th>#</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Address</th><th>Details</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>₱{{ number_format($order->total_price,2) }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td>{!! $order->status_badge !!}</td>
                <td>{{ Str::limit($order->delivery_address, 30) }}</td>
                <td>
                  <button
                    class="btn btn-sm btn-ocean"
                    data-bs-toggle="modal"
                    data-bs-target="#orderDetailsModal{{ $order->id }}"
                  >View</button>
                </td>
              </tr>

              <!-- === Modal for this order === -->
              <div
                class="modal fade"
                id="orderDetailsModal{{ $order->id }}"
                tabindex="-1"
                aria-labelledby="orderDetailsLabel{{ $order->id }}"
                aria-hidden="true"
              >
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header bg-ocean-medium text-white">
                      <h5 class="modal-title" id="orderDetailsLabel{{ $order->id }}">
                        Order #{{ $order->id }} Details
                      </h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      @if($order->orderItems->isEmpty())
                        <p>No items in this order.</p>
                      @else
                        <div class="list-group">
                          @foreach($order->orderItems as $item)
                            <div class="list-group-item d-flex align-items-center">
                              <img
                                src="{{ asset($item->fishProduct->image_path ?? 'assets/img/illustrations/default-fish.png') }}"
                                alt="{{ $item->fishProduct->name ?? 'Product' }}"
                                class="rounded me-3"
                                style="width:60px; height:60px; object-fit:cover;"
                              >
                              <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->fishProduct->name ?? 'Product Name Unavailable' }}</h6>
                                <p class="mb-1 text-muted">{{ $item->fishProduct->description ?? 'No description available.' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                  <div>
                                    <span class="badge bg-ocean-light text-ocean-deep">{{ $item->quantity_kg }} kg</span>
                                    <span class="ms-2">₱{{ number_format($item->price_per_kg, 2) }}/kg</span>
                                  </div>
                                  <div class="fw-bold">₱{{ number_format($item->subtotal, 2) }}</div>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        </div>
                        <div class="mt-3 p-3 bg-light rounded">
                          <div class="d-flex justify-content-between">
                            <h6>Total:</h6>
                            <h6>₱{{ number_format($order->total_price, 2) }}</h6>
                          </div>
                        </div>
                      @endif
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-outline-ocean" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
