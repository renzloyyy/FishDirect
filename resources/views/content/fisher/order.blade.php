@extends('layouts.contentNavbarLayout')
@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
<style>
  :root {
    --ocean-deep: #005f73;
    --ocean-medium: #0a9396;
    --ocean-light: #94d2bd;
    --sand-light: #e9d8a6;
    --sand-medium: #ee9b00;
    --coral-light: #ee9b00;
    --coral-medium: #ca6702;
    --coral-deep: #bb3e03;
  }

  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
  }

  .bg-ocean-deep { background-color: var(--ocean-deep) !important; }
  .bg-ocean-medium { background-color: var(--ocean-medium) !important; }
  .bg-ocean-light { background-color: var(--ocean-light) !important; }
  .bg-sand-light { background-color: var(--sand-light) !important; }
  .bg-sand-medium { background-color: var(--sand-medium) !important; }
  .bg-coral-light { background-color: var(--coral-light) !important; }
  .bg-coral-medium { background-color: var(--coral-medium) !important; }
  .bg-coral-deep { background-color: var(--coral-deep) !important; }

  .text-ocean-deep { color: var(--ocean-deep) !important; }
  .text-ocean-medium { color: var(--ocean-medium) !important; }
  .text-ocean-light { color: var(--ocean-light) !important; }
  .text-coral-deep { color: var(--coral-deep) !important; }

  .btn-ocean {
    background-color: var(--ocean-medium);
    border-color: var(--ocean-medium);
    color: white;
  }

  .btn-ocean:hover {
    background-color: var(--ocean-deep);
    border-color: var(--ocean-deep);
    color: white;
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
    color: white;
  }

  .card,
  .modern-card {
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0, 95, 115, 0.1);
    border: none;
    background-color: #fff;
  }

  .card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 95, 115, 0.1);
    font-weight: 600;
    font-size: 1rem;
    color: var(--ocean-deep);
  }

  .table-hover tbody tr:hover {
    background-color: rgba(148, 210, 189, 0.1);
    transition: background-color 0.2s ease;
  }

  .modern-table th {
    background-color: rgba(148, 210, 189, 0.2);
    border: none;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .modern-table td {
    vertical-align: middle;
    font-size: 0.925rem;
    color: #333;
  }

  .modern-table .badge {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
    border-radius: 20px;
  }

  .badge-paid {
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
  }

  .badge-pending {
    background-color: var(--sand-light);
    color: var(--sand-medium);
  }

  .badge-cancelled {
    background-color: #f8d7da;
    color: #842029;
  }

  .form-select,
  .form-control {
    border-radius: 8px;
    box-shadow: none;
    border: 1px solid #ced4da;
    font-size: 0.95rem;
  }

  .form-select:focus,
  .form-control:focus {
    border-color: var(--ocean-medium);
    box-shadow: 0 0 0 0.2rem rgba(10, 147, 150, 0.25);
  }

  .text-muted small {
    color: #6c757d !important;
  }
</style>
@endsection

@section('content')
<div class="container-xxl py-4">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card modern-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0 text-primary-dark">Recent Orders</h5>
            <p class="text-muted mb-0 small">Manage and track your customer orders</p>
          </div>
          <div class="d-flex gap-2">
            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-filter me-1"></i> Filter
              </button>
              <div class="dropdown-menu dropdown-menu-end p-3 filter-dropdown-menu" style="min-width: 260px;">
                <h6 class="dropdown-header px-0 d-flex justify-content-between align-items-center">
                  <span>Filter Orders</span>
                  <a href="{{ url()->current() }}" class="text-muted small">Reset</a>
                </h6>
                <form action="{{ route('fisher.orders.filter') }}" method="GET" id="orderFilterForm">
                  <!-- Status Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Status</label>
                    <div class="d-flex flex-wrap gap-2">
                      @foreach(['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $status)
                        <div class="form-check form-check-inline mb-0">
                          <input class="form-check-input" type="checkbox" name="status[]" id="status-{{ $status }}" 
                                value="{{ $status }}" {{ in_array($status, request()->get('status', [])) ? 'checked' : '' }}>
                          <label class="form-check-label small" for="status-{{ $status }}">
                            {{ ucfirst($status) }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  
                  <!-- Date Range Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Date Range</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input type="date" class="form-control form-control-sm" name="date_from" 
                              placeholder="From" value="{{ request('date_from') }}">
                      </div>
                      <div class="col-6">
                        <input type="date" class="form-control form-control-sm" name="date_to" 
                              placeholder="To" value="{{ request('date_to') }}">
                      </div>
                    </div>
                  </div>
                  
                  <!-- Price Range Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Price Range (₱)</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="price_min" 
                              placeholder="Min" value="{{ request('price_min') }}">
                      </div>
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="price_max" 
                              placeholder="Max" value="{{ request('price_max') }}">
                      </div>
                    </div>
                  </div>
                  
                  <!-- Search by customer name or order ID -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" class="form-control form-control-sm" name="search" 
                          placeholder="Customer name or Order #" value="{{ request('search') }}">
                  </div>
                  
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="bx bx-filter-alt me-1"></i> Apply Filters
                    </button>
                  </div>
                </form>
              </div>
            </div>
            
            <a href="{{ route('orders.exportPdf') }}" class="btn btn-outline-primary btn-sm">
                <i class="bx bx-export"></i> Export PDF
            </a>
          </div>
        </div>
        
        <!-- Active Filters Display -->
        @if(request()->hasAny(['status', 'date_from', 'date_to', 'price_min', 'price_max', 'search']))
        <div class="card-body py-2 px-4 border-bottom">
          <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="text-muted small me-2">Active filters:</span>
            
            @if(request()->has('search') && !empty(request('search')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-search me-1"></i>
                "{{ request('search') }}"
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('search'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            
            @if(request()->has('status'))
              @foreach(request('status') as $status)
                <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                  <i class="bx bx-check-circle me-1"></i>
                  Status: {{ ucfirst($status) }}
                  <a href="{{ request()->url() }}?{{ http_build_query(array_merge(
                    request()->except('status'), 
                    ['status' => array_diff(request('status'), [$status]), 'page' => 1]
                  )) }}" class="ms-1 text-primary" style="line-height: 0;">&times;</a>
                </span>
              @endforeach
            @endif
            
            @if(request()->has('date_from') && !empty(request('date_from')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-calendar me-1"></i>
                From: {{ request('date_from') }}
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('date_from'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            
            @if(request()->has('date_to') && !empty(request('date_to')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-calendar me-1"></i>
                To: {{ request('date_to') }}
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('date_to'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            
            @if(request()->has('price_min') && !empty(request('price_min')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-money me-1"></i>
                Min: ₱{{ number_format(request('price_min'), 2) }}
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('price_min'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            
            @if(request()->has('price_max') && !empty(request('price_max')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-money me-1"></i>
                Max: ₱{{ number_format(request('price_max'), 2) }}
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('price_max'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            
            <a href="{{ url()->current() }}" class="ms-auto btn btn-sm btn-link text-danger">
              <i class="bx bx-x-circle me-1"></i>Clear All
            </a>
          </div>
        </div>
        @endif
        
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle modern-table">
            <thead>
              <tr>
                <th scope="col" class="text-primary-medium fw-semibold">ORDER #</th>
                <th scope="col" class="text-primary-medium fw-semibold">CUSTOMER</th>
                <th scope="col" class="text-primary-medium fw-semibold">AMOUNT</th>
                <th scope="col" class="text-primary-medium fw-semibold">STATUS</th>
                <th scope="col" class="text-center text-primary-medium fw-semibold">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              @php
                $statusConfig = [
                  'pending' => [
                    'class' => 'bg-warning-subtle text-warning-emphasis',
                    'icon' => 'bx-time-five',
                    'text' => 'Pending Review'
                  ],
                  'confirmed' => [
                    'class' => 'bg-info-subtle text-info-emphasis',
                    'icon' => 'bx-check-circle',
                    'text' => 'Confirmed'
                  ],
                  'shipped' => [
                    'class' => 'bg-primary-subtle text-primary-emphasis',
                    'icon' => 'bx-package',
                    'text' => 'In Transit'
                  ],
                  'delivered' => [
                    'class' => 'bg-success-subtle text-success-emphasis',
                    'icon' => 'bx-check-double',
                    'text' => 'Delivered'
                  ],
                  'cancelled' => [
                    'class' => 'bg-danger-subtle text-danger-emphasis',
                    'icon' => 'bx-x-circle',
                    'text' => 'Cancelled'
                  ]
                ];
              @endphp
              @forelse ($recentOrders as $order)
              <tr class="table-row-hover">
                <td>
                  <span class="fw-semibold text-primary-dark">#ORD-{{ $order->id }}</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-3">
                      <span class="avatar-initial rounded-circle bg-gradient-primary text-white">
                        {{ substr($order->consumer->full_name ?? 'N', 0, 1) }}
                      </span>
                    </div>
                    <div>
                      <h6 class="mb-0">{{ $order->consumer->full_name ?? 'N/A' }}</h6>
                      <small class="text-muted">Customer</small>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="fw-bold text-success">₱{{ number_format($order->total_price, 2) }}</span>
                </td>
                <td>
                  @php $status = $statusConfig[$order->status] ?? $statusConfig['pending']; @endphp
                  <span class="badge {{ $status['class'] }} d-inline-flex align-items-center" id="status-badge-{{ $order->id }}">
                    <i class="bx {{ $status['icon'] }} me-1"></i>
                    {{ $status['text'] }}
                  </span>
                </td>
                <td class="text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary btn-sm btn-view-order modern-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#orderDetailsModal"
                            data-id="#ORD-{{ $order->id }}"
                            data-customer="{{ $order->consumer->full_name ?? 'N/A' }}"
                            data-amount="{{ number_format($order->total_price, 2) }}"
                            data-status="{{ $order->status }}"
                            data-items='{{ json_encode($order->orderItems->map(function($item) {
                                return [
                                    "name" => $item->fishProduct->name ?? "Unknown Product", 
                                    "qty" => $item->quantity_kg ?? 0,
                                    "price" => $item->price_per_kg ?? 0
                                ];
                            })) }}'>
                      <i class="bx bx-show me-1"></i> View Details
                    </button>
                    
                    @if(!in_array($order->status, ['delivered', 'cancelled']))
                    <div class="dropdown">
                      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                              type="button" 
                              data-bs-toggle="dropdown" 
                              aria-expanded="false"
                              data-order-id="{{ $order->id }}">
                        <i class="bx bx-cog me-1"></i> Update Status
                      </button>
                      <ul class="dropdown-menu">
                        @if($order->status === 'pending')
                          <li><a class="dropdown-item status-update-item" href="#" data-order-id="{{ $order->id }}" data-status="confirmed">
                            <i class="bx bx-check-circle me-2 text-info"></i>Confirm Order
                          </a></li>
                          <li><a class="dropdown-item status-update-item" href="#" data-order-id="{{ $order->id }}" data-status="cancelled">
                            <i class="bx bx-x-circle me-2 text-danger"></i>Cancel Order
                          </a></li>
                        @elseif($order->status === 'confirmed')
                          <li><a class="dropdown-item status-update-item" href="#" data-order-id="{{ $order->id }}" data-status="shipped">
                            <i class="bx bx-package me-2 text-primary"></i>Mark as Shipped
                          </a></li>
                          <li><a class="dropdown-item status-update-item" href="#" data-order-id="{{ $order->id }}" data-status="cancelled">
                            <i class="bx bx-x-circle me-2 text-danger"></i>Cancel Order
                          </a></li>
                        @elseif($order->status === 'shipped')
                          <li><a class="dropdown-item status-update-item" href="#" data-order-id="{{ $order->id }}" data-status="delivered">
                            <i class="bx bx-check-double me-2 text-success"></i>Mark as Delivered
                          </a></li>
                        @endif
                      </ul>
                    </div>
                    @endif
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="empty-state">
                    <i class="bx bx-package display-4 text-muted mb-3"></i>
                    <h6 class="text-muted">No orders found</h6>
                    <p class="text-muted small">
                      @if(request()->hasAny(['status', 'date_from', 'date_to', 'price_min', 'price_max', 'search']))
                        Try adjusting your filters or <a href="{{ url()->current() }}">view all orders</a>.
                      @else
                        Orders will appear here once customers start placing them.
                      @endif
                    </p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($recentOrders->hasPages())
        <div class="card-footer d-flex justify-content-end bg-light">
          {{ $recentOrders->links() }}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Modern Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content modern-modal">
      <div class="modal-header bg-gradient-primary text-white border-0">
        <div>
          <h5 class="modal-title mb-1" id="orderDetailsModalLabel">Order Details</h5>
          <p class="mb-0 small opacity-75">Review and manage order information</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
          <div class="col-md-6">
            <div class="info-card mb-4">
              <h6 class="text-primary-medium mb-3">
                <i class="bx bx-receipt me-2"></i>Order Information
              </h6>
              <div class="info-item mb-3">
                <label class="text-muted small">Order ID</label>
                <p class="fw-semibold mb-0" id="modal-order-id"></p>
              </div>
              <div class="info-item mb-3">
                <label class="text-muted small">Customer</label>
                <p class="fw-semibold mb-0" id="modal-customer-name"></p>
              </div>
              <div class="info-item mb-3">
                <label class="text-muted small">Total Amount</label>
                <p class="fw-bold text-success mb-0">₱<span id="modal-total-amount"></span></p>
              </div>
              <div class="info-item">
                <label class="text-muted small">Status</label>
                <p class="mb-0"><span id="modal-status" class="badge"></span></p>
              </div>
            </div>

            <!-- Status Update Section -->
            <div class="info-card" id="status-update-section">
              <h6 class="text-primary-medium mb-3">
                <i class="bx bx-cog me-2"></i>Update Status
              </h6>
              <select class="form-select" id="status-select" disabled>
                <option value="">Select new status...</option>
              </select>
              <button type="button" id="btn-update-status" class="btn btn-primary mt-2" disabled>
                <i class="bx bx-check me-1"></i>
                <span class="btn-text">Update Status</span>
              </button>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="info-card">
              <h6 class="text-primary-medium mb-3">
                <i class="bx bx-package me-2"></i>Order Items
              </h6>
              <div id="modal-items-list" class="items-list"></div>
              <div class="mt-3 pt-3 border-top">
                <div class="d-flex justify-content-between">
                  <span class="text-muted">Total Items:</span>
                  <span class="fw-semibold" id="modal-total-items">0</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
          <i class="bx bx-x me-1"></i>Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('orderDetailsModal');
  const statusSelect = document.getElementById('status-select');
  const updateStatusBtn = document.getElementById('btn-update-status');
  const statusUpdateSection = document.getElementById('status-update-section');

  const modalOrderId = document.getElementById('modal-order-id');
  const modalCustomerName = document.getElementById('modal-customer-name');
  const modalTotalAmount = document.getElementById('modal-total-amount');
  const modalStatus = document.getElementById('modal-status');
  const modalItemsList = document.getElementById('modal-items-list');
  const modalTotalItems = document.getElementById('modal-total-items');

  let currentOrderId = null;
  let currentStatus = null;

  const statusConfig = {
    'pending': {
      'class': 'bg-warning-subtle text-warning-emphasis',
      'icon': 'bx-time-five',
      'text': 'Pending Review'
    },
    'confirmed': {
      'class': 'bg-info-subtle text-info-emphasis',
      'icon': 'bx-check-circle',
      'text': 'Confirmed'
    },
    'shipped': {
      'class': 'bg-primary-subtle text-primary-emphasis',
      'icon': 'bx-package',
      'text': 'In Transit'
    },
    'delivered': {
      'class': 'bg-success-subtle text-success-emphasis',
      'icon': 'bx-check-double',
      'text': 'Delivered'
    },
    'cancelled': {
      'class': 'bg-danger-subtle text-danger-emphasis',
      'icon': 'bx-x-circle',
      'text': 'Cancelled'
    }
  };

  // Handle modal show event
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    // Set current order ID without prefix "#ORD-"
    currentOrderId = button.getAttribute('data-id').replace('#ORD-', '');
    currentStatus = button.getAttribute('data-status');

    // Populate modal fields
    modalOrderId.textContent = button.getAttribute('data-id');
    modalCustomerName.textContent = button.getAttribute('data-customer');
    modalTotalAmount.textContent = button.getAttribute('data-amount');

    // Status badge with modern styling
    const status = statusConfig[currentStatus] || statusConfig['pending'];
    modalStatus.innerHTML = `<i class="bx ${status.icon} me-1"></i>${status.text}`;
    modalStatus.className = `badge ${status.class} d-inline-flex align-items-center`;

    // Populate items list with proper quantity handling
    const itemsData = button.getAttribute('data-items');
    if (itemsData) {
      try {
        const items = JSON.parse(itemsData);
        modalItemsList.innerHTML = '';
        let totalItems = 0;
        
        items.forEach(item => {
          const quantity = parseFloat(item.qty) || 0; 
          const unitPrice = parseFloat(item.price) || 0;
          totalItems += quantity;
          
          const itemCard = document.createElement('div');
          itemCard.className = 'item-card d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded';
          itemCard.innerHTML = `
            <div class="d-flex align-items-center">
              <div class="icon-circle bg-primary-subtle text-primary me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%;">
                <i class="bx bx-cube"></i>
              </div>
              <div>
                <h6 class="mb-0">${item.name || 'Unknown Product'}</h6>
                <small class="text-muted">₱${unitPrice.toFixed(2)} per kg</small>
              </div>
            </div>
            <div class="text-end">
              <span class="badge bg-primary rounded-pill">${quantity} kg</span>
              <div class="small text-muted mt-1">₱${(quantity * unitPrice).toFixed(2)}</div>
            </div>
          `;
          modalItemsList.appendChild(itemCard);
        });

        modalTotalItems.textContent = `${totalItems.toFixed(2)} kg`;
      } catch (error) {
        console.error('Error parsing items data:', error);
        modalItemsList.innerHTML = '<p class="text-muted">Error loading items</p>';
        modalTotalItems.textContent = '0';
      }
    } else {
      modalItemsList.innerHTML = '<p class="text-muted">No items data available</p>';
      modalTotalItems.textContent = '0';
    }

    // Setup status update dropdown
    setupStatusDropdown(currentStatus);
  });

  function setupStatusDropdown(currentStatus) {
    statusSelect.innerHTML = '<option value="">Select new status...</option>';
    
    // Hide/show status update section based on current status
    if (currentStatus === 'delivered' || currentStatus === 'cancelled') {
      statusUpdateSection.style.display = 'none';
      return;
    } else {
      statusUpdateSection.style.display = 'block';
    }

    // Add appropriate status options based on current status
    const statusOptions = {
      'pending': [
        { value: 'confirmed', text: 'Confirmed', icon: 'bx-check-circle' },
        { value: 'cancelled', text: 'Cancelled', icon: 'bx-x-circle' }
      ],
      'confirmed': [
        { value: 'shipped', text: 'In Transit', icon: 'bx-package' },
        { value: 'cancelled', text: 'Cancelled', icon: 'bx-x-circle' }
      ],
      'shipped': [
        { value: 'delivered', text: 'Delivered', icon: 'bx-check-double' }
      ]
    };

    const availableOptions = statusOptions[currentStatus] || [];
    
    availableOptions.forEach(option => {
      const optionElement = document.createElement('option');
      optionElement.value = option.value;
      optionElement.textContent = option.text;
      statusSelect.appendChild(optionElement);
    });

    statusSelect.disabled = false;
  }

  // Handle status select change
  statusSelect.addEventListener('change', function() {
    updateStatusBtn.disabled = !this.value;
  });

  // Handle status update button click
  updateStatusBtn.addEventListener('click', function() {
    const newStatus = statusSelect.value;
    if (!newStatus || !currentOrderId) return;
    
    updateOrderStatus(currentOrderId, newStatus);
  });

  // Handle dropdown status updates from table
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('status-update-item')) {
      e.preventDefault();
      const orderId = e.target.getAttribute('data-order-id');
      const newStatus = e.target.getAttribute('data-status');
      
      if (orderId && newStatus) {
        updateOrderStatus(orderId, newStatus);
      }
    }
  });

  function updateOrderStatus(orderId, newStatus) {
    const originalText = updateStatusBtn.querySelector('.btn-text').textContent;
    const icon = updateStatusBtn.querySelector('i');
    
    updateStatusBtn.disabled = true;
    updateStatusBtn.querySelector('.btn-text').textContent = 'Updating...';
    icon.className = 'bx bx-loader-alt me-1 bx-spin';

    fetch(`/orders/${orderId}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
      if(data.success) {
        // Update current status
        currentStatus = newStatus;
        
        // Update modal status badge
        const status = statusConfig[newStatus];
        modalStatus.innerHTML = `<i class="bx ${status.icon} me-1"></i>${status.text}`;
        modalStatus.className = `badge ${status.class} d-inline-flex align-items-center`;

        // Update status in the table row
        const statusBadge = document.getElementById(`status-badge-${orderId}`);
        if (statusBadge) {
          statusBadge.innerHTML = `<i class="bx ${status.icon} me-1"></i>${status.text}`;
          statusBadge.className = `badge ${status.class} d-inline-flex align-items-center`;
        }

        // Update the view button's data-status attribute
        const triggerBtn = document.querySelector(`.btn-view-order[data-id="#ORD-${orderId}"]`);
        if (triggerBtn) {
          triggerBtn.setAttribute('data-status', newStatus);
        }

        // Reset status dropdown
        setupStatusDropdown(newStatus);
        statusSelect.value = '';
        updateStatusBtn.disabled = true;

        // Show success message
        showToast('Success!', `Order has been marked as ${status.text}.`, 'success');
      } else {
        showToast('Error', data.message || 'Failed to update status. Please try again.', 'error');
      }
    })
    .catch(err => {
      console.error('Error updating status:', err);
      showToast('Error', 'Network error. Please try again.', 'error');
    })
    .finally(() => {
      updateStatusBtn.disabled = false;
      updateStatusBtn.querySelector('.btn-text').textContent = originalText;
      icon.className = 'bx bx-check me-1';
    });
  }

  function showToast(title, message, type) {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    // Create new toast
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed toast-notification`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
    toast.innerHTML = `
      <strong>${title}</strong> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
      if (toast.parentNode) {
        toast.remove();
      }
    }, 5000);
  }
});
</script>
@endsection