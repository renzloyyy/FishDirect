@extends('layouts.contentNavbarLayout')

@section('title', 'My Cart')

@section('vendor-style')
<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('page-style')
<style>
  :root {
    /* Ocean blues palette */
    --ocean-deep: #005f73;
    --ocean-medium: #0a9396;
    --ocean-light: #94d2bd;

    /* Natural neutrals */
    --sand-light: #e9d8a6;
    --sand-medium: #ee9b00;

    /* Coral accents */
    --coral-light: #ee9b00;
    --coral-medium: #ca6702;
    --coral-deep: #bb3e03;
  }

  body {
    font-family: 'Inter', sans-serif;
  }

  /* ------------------ TEXT & BACKGROUND UTILITIES ------------------ */
  .bg-ocean-deep    { background-color: var(--ocean-deep) !important; }
  .bg-ocean-medium  { background-color: var(--ocean-medium) !important; }
  .bg-ocean-light   { background-color: var(--ocean-light) !important; }

  .text-ocean-deep  { color: var(--ocean-deep) !important; }
  .text-ocean-medium{ color: var(--ocean-medium) !important; }
  .text-coral-deep  { color: var(--coral-deep) !important; }

  .border-ocean-light { border-color: var(--ocean-light) !important; }

  /* ------------------ BUTTON STYLES ------------------ */
  .btn-ocean {
    background-color: var(--ocean-medium);
    border-color: var(--ocean-medium);
    color: white;
  }

  .btn-ocean:hover {
    background-color: var(--ocean-deep);
    border-color: var(--ocean-deep);
  }

  .btn-outline-ocean {
    background-color: transparent;
    border-color: var(--ocean-medium);
    color: var(--ocean-medium);
  }

  .btn-outline-ocean:hover {
    background-color: var(--ocean-medium);
    color: white;
  }

  .btn-coral {
    background-color: var(--coral-medium);
    border-color: var(--coral-medium);
    color: white;
  }

  .btn-coral:hover {
    background-color: var(--coral-deep);
    border-color: var(--coral-deep);
  }

  .btn-light-ocean {
    background-color: rgba(10, 147, 150, 0.1);
    color: var(--ocean-medium);
    border: none;
  }

  .btn-light-ocean:hover {
    background-color: rgba(10, 147, 150, 0.2);
  }

  /* ------------------ CARD DESIGN ------------------ */
  .card {
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0, 95, 115, 0.1);
    border: none;
  }

  .card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 95, 115, 0.1);
  }

  /* ------------------ QUANTITY CONTROLS ------------------ */
  .quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    width: 120px;
  }

  .quantity-btn {
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
    border: none;
    width: 32px;
    height: 32px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }

  .quantity-btn:hover {
    background-color: var(--ocean-medium);
    color: white;
  }

  .quantity-input {
    width: 56px;
    text-align: center;
    border: none;
    font-weight: 500;
    background: transparent;
  }

  .quantity-input:focus {
    outline: none;
  }

  /* ------------------ CART STYLING ------------------ */
  .cart-product-image {
    width: 100%;
    max-height: 100px;
    height: auto;
    object-fit: contain;
    display: block;
    border-radius: 8px;
  }

  .cart-item {
    transition: all 0.3s ease;
  }

  .cart-item:hover {
    background-color: rgba(148, 210, 189, 0.1);
  }

  .cart-item-delete {
    opacity: 0.5;
    transition: all 0.2s;
  }

  .cart-item-delete:hover {
    opacity: 1;
    color: #dc3545;
  }

  .cart-summary {
    position: sticky;
    top: 20px;
  }

  .cart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    text-align: center;
  }

  .cart-empty-icon {
    font-size: 4rem;
    color: var(--ocean-light);
    margin-bottom: 1rem;
  }

  /* ------------------ BADGES ------------------ */
  .badge-fresh,
  .badge-delivery {
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.8rem;
  }

  .badge-fresh {
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
  }

  .badge-delivery {
    background-color: var(--sand-light);
    color: var(--coral-medium);
  }

  /* ------------------ CHECKOUT MODAL ------------------ */
  #checkoutModal .modal-body {
    max-height: 80vh;
    overflow-y: auto;
  }

  #checkoutModal .nav-tabs {
    background-color: #f8f9fa;
    border-bottom: 1px solid var(--ocean-light);
  }

  #checkoutModal .nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    padding: 1rem 0.75rem;
    font-weight: 500;
    transition: all 0.2s;
  }

  #checkoutModal .nav-tabs .nav-link.active {
    background-color: transparent;
    border-bottom: 3px solid var(--ocean-medium);
    color: var(--ocean-deep);
  }

  #checkoutModal .tab-content {
    background-color: #fff;
  }

  #checkoutModal .tab-pane {
    padding: 1.5rem;
  }

  #checkoutModal .card {
    box-shadow: 0 2px 8px rgba(0, 95, 115, 0.08);
    border-color: rgba(0, 95, 115, 0.1);
  }

  /* ------------------ PAYMENT OPTIONS ------------------ */
  .payment-option {
    transition: all 0.2s;
    cursor: pointer;
    border-color: rgba(0, 95, 115, 0.1) !important;
  }

  .payment-option:hover {
    background-color: rgba(148, 210, 189, 0.1);
  }

  .payment-option input[type="radio"]:checked + label {
    font-weight: 500;
  }

  .payment-option input[type="radio"]:checked + label span {
    background-color: rgba(10, 147, 150, 0.2) !important;
  }

  /* ------------------ PROMO CODE ------------------ */
  .promo-code-form {
    display: flex;
    gap: 8px;
  }

  .divider {
    border-top: 1px dashed rgba(0, 95, 115, 0.2);
    margin: 1rem 0;
  }

  /* ------------------ RESPONSIVE FIXES ------------------ */
  @media (max-width: 767px) {
    .cart-item-info {
      flex-direction: column;
      align-items: flex-start !important;
    }

    .cart-item-quantity {
      margin-top: 1rem;
    }

    #checkoutModal .modal-dialog {
      margin: 0.5rem;
    }

    #checkoutModal .tab-pane {
      padding: 1rem;
    }

    .payment-option label {
      flex-direction: column;
      align-items: center !important;
      text-align: center;
    }

    .payment-option label span {
      margin-bottom: 0.5rem;
      margin-right: 0 !important;
    }
  }
</style>

@endsection

@section('vendor-script')

@endsection

@section('content')
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="container my-1">
  <div class="row">
    <div class="col-12 mb-3">
    </div>
    <div class="col-12 mb-4">
      <h4 class="text-ocean-deep">
        My Cart 
        <span id="cartItemCount" class="text-muted">({{ $cartItems->count() }})</span>
      </h4>
    </div>
  </div>

  <div class="row">
    <!-- Left Column: Cart Items -->
    <div class="col-lg-7 mb-4">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0 text-ocean-deep">Cart Items</h5>
          <a href="" class="btn btn-sm btn-light-ocean">
            <i class="bx bx-refresh me-1"></i> Refresh
          </a>
        </div>
        <div class="card-body" id="cartItemsList">
          @forelse ($cartItems as $item)
            @php
              $itemSubtotal = $item->quantity_kg * $item->price_per_kg;
            @endphp
            <div class="cart-item p-3 mb-3 rounded border">
              <div class="row align-items-center">
                <div class="col-3 col-md-2">
                  <img src="{{ asset($item->image_path) }}" alt="{{ $item->fishProduct->name }}" class="cart-product-image">
                </div>
                <div class="col-6 col-md-6">
                  <h5 class="text-ocean-deep mb-1">{{ $item->fishProduct->name }}</h5>
                  <p class="text-muted small mb-2">
                    {{ $item->fishProduct->description ?? 'No description.' }}
                  </p>
                  <div class="text-coral-deep fw-bold">
                    ₱{{ number_format($item->price_per_kg, 2) }} per kg
                  </div>
                </div>
                <div class="col-3 col-md-4 d-flex flex-column align-items-end justify-content-between">
                  <div class="quantity-control mb-2">
                    <button class="quantity-btn" data-action="decrease">−</button>
                    <input type="number"
                      class="quantity-input"
                      value="{{ $item->quantity_kg }}"
                      min="0.5" step="0.5"
                      data-id="{{ $item->id }}"
                      aria-label="Quantity">
                    <button class="quantity-btn" data-action="increase">+</button>
                  </div>
                  <div class="text-ocean-deep fw-bold mb-2">
                    ₱{{ number_format($itemSubtotal, 2) }}
                  </div>
                  <form method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-light-ocean cart-item-delete" type="submit">
                      <i class="bx bx-trash me-1"></i> Remove
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @empty
            <div class="cart-empty">
              <i class="cart-empty-icon bx bx-shopping-bag"></i>
              <p class="text-muted">Your cart is currently empty.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  <!-- Right Column: Order Summary -->
<div class="col-lg-5">
  <div class="card shadow-sm border">
    <div class="card-body">
      <h5 class="card-title mb-4 text-ocean-deep">Order Summary</h5>

    @php
        $shipping = $subtotal > 0 ? 80 : 0;
        $discountedSubtotal = max(0, $subtotal - $discount);
        $tax = round($discountedSubtotal * 0.10);
        $total = $discountedSubtotal + $shipping + $tax;
    @endphp


      <div class="d-flex justify-content-between mb-2">
        <span>Subtotal</span>
        <span>₱{{ number_format($subtotal, 2) }}</span>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <span>Shipping</span>
        <span>₱{{ number_format($shipping, 2) }}</span>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <span>Tax</span>
        <span>₱{{ number_format($tax, 2) }}</span>
      </div>

      <hr class="my-3">

      <!-- Promo Code Section -->
      @if ($availableVouchers->count())
        <div class="mt-4">
          <h6 class="text-ocean-deep mb-2">Available Vouchers</h6>
          <ul class="list-group">
            @foreach ($availableVouchers as $voucher)
              @php
                $meetsMinimum = !$voucher->minimum_order_amount || $subtotal >= $voucher->minimum_order_amount;
              @endphp
              <li class="list-group-item d-flex justify-content-between align-items-center {{ $meetsMinimum ? '' : 'text-muted text-decoration-line-through' }}">
                <div>
                  <strong>{{ $voucher->code }}</strong>
                  <small class="d-block">
                    {{ $voucher->type === 'percentage' ? $voucher->discount . '% off' : '₱' . number_format($voucher->discount, 2) . ' off' }}
                  </small>
                  @if ($voucher->minimum_order_amount)
                    <small class="d-block">Min: ₱{{ number_format($voucher->minimum_order_amount, 2) }}</small>
                  @endif
                </div>

                @if ($meetsMinimum)
                  @if (session('promo_code') === $voucher->code)
                    <form method="POST" action="{{ route('promo.remove') }}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('promo.apply') }}">
                      @csrf
                      <input type="hidden" name="promo_code" value="{{ $voucher->code }}">
                      <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                      <button type="submit" class="btn btn-sm btn-ocean">Apply</button>
                    </form>
                  @endif
                @else
                  <span class="badge bg-secondary">Unavailable</span>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      @if ($discount > 0)
        <div class="d-flex justify-content-between mb-2">
          <span>Discount</span>
          <span>-₱{{ number_format($discount, 2) }}</span>
        </div>
      @endif

      <hr class="my-3">

      <div class="d-flex justify-content-between mb-3">
        <strong>Total</strong>
        <strong class="text-ocean-deep">₱{{ number_format($total, 2) }}</strong>
      </div>

      <button class="btn btn-ocean w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">
        Proceed to Checkout
      </button>
    </div>
  </div>
</div>
<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-ocean-light">
        <h5 class="modal-title text-ocean-deep" id="checkoutModalLabel">Complete Your Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <form id="checkoutForm" action="{{ route('checkout') }}" method="POST">
          @csrf

          @if (!Auth::check())
            <div class="alert alert-info mb-0 rounded-0">
              <i class="bx bx-info-circle me-2"></i>
              Please <a href="{{ route('login') }}" class="text-ocean-deep fw-bold">login</a> to continue.
            </div>
          @endif

          <!-- Tabs -->
          <ul class="nav nav-tabs nav-fill" id="checkoutTabs" role="tablist">
            @php
              $steps = ['summary' => 'Order Summary', 'delivery' => 'Delivery', 'payment' => 'Payment'];
            @endphp
            @foreach ($steps as $id => $label)
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link text-ocean-deep @if($loop->first) active @endif"
                  id="{{ $id }}-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#{{ $id }}"
                  type="button"
                  role="tab"
                  aria-controls="{{ $id }}"
                  @if($loop->first) aria-selected="true" @else aria-selected="false" @endif
                >
                  <i class="bx bx-{{ $id==='payment'?'credit-card':($id==='delivery'?'map':'cart') }} me-1"></i>
                  {{ $label }}
                </button>
              </li>
            @endforeach
          </ul>

          <!-- Tab Content -->
          <div class="tab-content" id="checkoutTabContent" style="padding: 1.5rem;">
            <!-- Summary Tab -->
            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
              <h6 class="text-ocean-deep mb-1">Items in Your Cart</h6>
              @forelse ($cartItems as $item)
                @php $itemSubtotal = $item->quantity_kg * $item->price_per_kg; @endphp
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                  <img src="{{ asset($item->image_path) }}" alt="{{ $item->fishProduct->name }}"
                       class="me-3" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $item->fishProduct->name }}</h6>
                    <small class="text-muted">{{ $item->fishProduct->description ?? 'No description.' }}</small>
                  </div>
                  <div class="text-end">
                    <div class="fw-bold">₱{{ number_format($itemSubtotal,2) }}</div>
                    <small class="text-muted">{{ $item->quantity_kg }}kg × ₱{{ number_format($item->price_per_kg,2) }}</small>
                  </div>
                </div>
              @empty
                <p class="text-muted">Your cart is empty.</p>
              @endforelse

              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span><span>₱{{ number_format($subtotal,2) }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping</span><span>₱{{ number_format($shipping,2) }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Tax</span><span>₱{{ number_format($tax,2) }}</span>
              </div>
              @if($discount > 0)
              <div class="d-flex justify-content-between mb-2 text-success">
                <span>Discount</span><span>-₱{{ number_format($discount, 2) }}</span>
              </div>
              @endif
              <div class="divider my-3"></div>
              <div class="d-flex justify-content-between mb-3">
                <strong>Total</strong><strong class="text-ocean-deep">₱{{ number_format($total,2) }}</strong>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-ocean next-tab" data-next="delivery-tab">
                  Continue to Delivery <i class="bx bx-right-arrow-alt ms-1"></i>
                </button>
              </div>
            </div>

            <!-- Delivery Tab -->
            <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
              <h6 class="text-ocean-deep mb-3">Delivery Information</h6>
              @if (Auth::check())
                @php $c = Auth::user()->consumer; @endphp
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name"
                           value="{{ $c->full_name ?? Auth::user()->name }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           value="{{ $c->phone ?? '' }}" required>
                  </div>
                  <div class="col-12">
                    <label for="street" class="form-label">Street Address</label>
                    <input type="text" class="form-control" id="street" name="street"
                           value="{{ $c->street ?? '' }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="barangay" class="form-label">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay"
                           value="{{ $c->barangay ?? '' }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city"
                           value="{{ $c->city ?? '' }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province"
                           value="{{ $c->province ?? '' }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="zip_code" class="form-label">ZIP Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code"
                           value="{{ $c->zip_code ?? '' }}" required>
                  </div>
                </div>
              @else
                <p>Please <a href="{{ route('login') }}">login</a> to enter delivery info.</p>
              @endif

              <div class="mt-4 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-ocean prev-tab" data-prev="summary-tab">
                  <i class="bx bx-left-arrow-alt me-1"></i> Back to Summary
                </button>
                <button type="button" class="btn btn-ocean next-tab" data-next="payment-tab">
                  Continue to Payment <i class="bx bx-right-arrow-alt ms-1"></i>
                </button>
              </div>
            </div>

            <!-- Payment Tab -->
            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
              <h6 class="text-ocean-deep mb-3">Payment Method</h6>
              <p>Choose your payment option (integration coming soon).</p>

              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                  <label class="form-check-label" for="cod">Cash on Delivery</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash" disabled>
                  <label class="form-check-label" for="gcash">Gcash (Coming soon)</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" disabled>
                  <label class="form-check-label" for="credit_card">Credit Card (Coming soon)</label>
                </div>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-ocean prev-tab" data-prev="delivery-tab">
                  <i class="bx bx-left-arrow-alt me-1"></i> Back to Delivery
                </button>
                <button type="submit" class="btn btn-ocean">Place Order</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
 
  document.querySelectorAll('.next-tab').forEach(button => {
    button.addEventListener('click', function () {
      const nextTabId = this.getAttribute('data-next');
      if (!nextTabId) return;
      const nextTabTrigger = document.querySelector(`#${nextTabId}`);
      if (nextTabTrigger) {
        const tab = new bootstrap.Tab(nextTabTrigger);
        tab.show();
      }
    });
  });

  document.querySelectorAll('.prev-tab').forEach(button => {
    button.addEventListener('click', function () {
      const prevTabId = this.getAttribute('data-prev');
      if (!prevTabId) return;
      const prevTabTrigger = document.querySelector(`#${prevTabId}`);
      if (prevTabTrigger) {
        const tab = new bootstrap.Tab(prevTabTrigger);
        tab.show();
      }
    });
  });
});
</script>