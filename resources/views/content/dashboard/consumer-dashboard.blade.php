@extends('layouts.contentNavbarLayout')

@section('title', 'Consumer Dashboard')

@section('vendor-style')
<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<!-- Import Inter or Lato font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('page-style')
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
  }
  
  .bg-ocean-deep {
    background-color: var(--ocean-deep) !important;
  }
  
  .bg-ocean-medium {
    background-color: var(--ocean-medium) !important;
  }
  
  .bg-ocean-light {
    background-color: var(--ocean-light) !important;
  }
  
  .bg-sand-light {
    background-color: var(--sand-light) !important;
  }
  
  .bg-sand-medium {
    background-color: var(--sand-medium) !important;
  }
  
  .bg-coral-light {
    background-color: var(--coral-light) !important;
  }
  
  .bg-coral-medium {
    background-color: var(--coral-medium) !important;
  }
  
  .bg-coral-deep {
    background-color: var(--coral-deep) !important;
  }
  
  .text-ocean-deep {
    color: var(--ocean-deep) !important;
  }
  
  .text-ocean-medium {
    color: var(--ocean-medium) !important;
  }
  
  .text-ocean-light {
    color: var(--ocean-light) !important;
  }
  
  .text-coral-deep {
    color: var(--coral-deep) !important;
  }
  
  .border-ocean-light {
    border-color: var(--ocean-light) !important;
  }
  
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
  
  .card {
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0, 95, 115, 0.1);
    border: none;
  }
  
  .card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 95, 115, 0.1);
  }
  
  .avatar-initial {
    font-weight: 600;
  }
  
  .bg-label-primary {
    background-color: rgba(10, 147, 150, 0.15) !important;
    color: var(--ocean-medium) !important;
  }
  
  .bg-label-success {
    background-color: rgba(148, 210, 189, 0.15) !important;
    color: var(--ocean-deep) !important;
  }
  
  .bg-label-warning {
    background-color: rgba(238, 155, 0, 0.15) !important;
    color: var(--coral-medium) !important;
  }
  .greyed-menu {
  background-color: #e0e0e0 !important; 
  transition: background-color 0.3s ease;
}

  .welcome-banner {
    background: linear-gradient(135deg, var(--ocean-medium) 0%, var(--ocean-deep) 100%);
    color: white;
    border-radius: 12px;
  }
  
  .welcome-banner h4, .welcome-banner p {
    color: white;
  }
  
  .welcome-banner .btn-primary {
    background-color: white;
    color: var(--ocean-deep);
    border: none;
  }
  
  .welcome-banner .btn-outline-primary {
    border-color: white;
    color: white;
  }
  
  .welcome-banner .btn-outline-primary:hover {
    background-color: white;
    color: var(--ocean-deep);
  }
  
  .badge-fresh {
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
  }
  
  .swiper-pagination-bullet-active {
    background-color: var(--ocean-deep);
  }
  
  .table-hover tbody tr:hover {
    background-color: rgba(148, 210, 189, 0.1);
  }
  
  .badge-success {
    background-color: var(--ocean-light) !important;
    color: var(--ocean-deep) !important;
  }
</style>
@endsection

@section('vendor-script')
<!-- Vendor JS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head> 
<div class="row">
  <div class="col-12">
    <div class="card welcome-banner">
      <div class="d-flex align-items-end row">
        <div class="col-md-8">
          <div class="card-body">
            <h4 class="card-title">Welcome {{ auth()->user()->consumer ? auth()->user()->consumer->full_name : auth()->user()->email }}! 🎉</h4>
            <p class="mb-4">Get the freshest seafood delivered to your doorstep</p>
            
            @if(!auth()->user()->consumer)
              <p class="mb-2 text-warning">Complete your profile to get personalized recommendations and faster checkout.</p>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completeProfileModal">
                Complete Your Profile
              </button>
            @else
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#completeProfileModal">
                Update Profile
              </button>
            @endif
          </div>
        </div>
        <div class="col-md-4 text-center text-md-end">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/fishstore.png') }}" height="140" alt="Fish Market Illustration">
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Today's Fresh Catches Section -->
<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0 text-ocean-deep">Today's Fresh Catches</h5>
      <a href="" class="btn btn-sm btn-outline-ocean">View All</a>
    </div>
    <div class="card-body">
      <div class="row g-4">
        <!-- Loop through fresh catches -->
        @foreach($freshCatches as $product)
        <div class="col-md-3">
          <div class="position-relative" style="height: 180px; overflow: hidden; cursor: pointer" 
               data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
            <span class="badge bg-ocean-light text-ocean-deep position-absolute top-0 start-0 m-2">{{ ucfirst($product->status) }}</span>
            <img class="img-fluid rounded w-100 h-100 object-fit-cover" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
          </div>
          <div class="mt-3 d-flex flex-column justify-content-between" style="height: 120px;">
            <div>
              <h5 class="text-ocean-deep">{{ $product->name }}</h5>
              <p class="text-muted mb-2">{{ $product->description }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <div class="text-coral-deep fw-bold">₱{{ number_format($product->price_per_kg, 2) }} per kg</div>
              <button class="btn btn-sm btn-ocean" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">View Details</button>
            </div>
          </div>
        </div>
        
        <!-- Product Modal -->
        <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id }}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-ocean-light">
                <h5 class="modal-title text-ocean-deep" id="productModalLabel-{{ $product->id }}">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @if($product->fisher)
                    <div class="mt-3">
                      <h6 class="text-ocean-deep">Caught by:</h6>
                      <div class="d-flex align-items-center">
                        @if($product->fisher->profile_photo)
                          <img src="{{ asset('storage/' . $product->fisher->profile_photo) }}" alt="{{ $product->fisher->display_name }}" class="rounded-circle me-2" width="40" height="40">
                        @else
                          <span class="avatar-initial rounded-circle bg-ocean-medium text-white me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            {{ substr($product->fisher->display_name ?? $product->fisher->full_name, 0, 1) }}
                          </span>
                        @endif
                        <div>
                          <p class="mb-0 fw-semibold">{{ $product->fisher->display_name ?? $product->fisher->full_name }}</p>
                          <small class="text-muted">{{ $product->fisher->fishing_area ?? 'Local Fisher' }}</small>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <h6 class="text-ocean-deep">Description:</h6>
                      <p>{{ $product->description }}</p>
                    </div>
                    <div class="mb-3">
                      <h6 class="text-ocean-deep">Product Details:</h6>
                      <ul class="list-unstyled">
                        <li><strong>Price:</strong> ₱{{ number_format($product->price_per_kg, 2) }} per kg</li>
                        <li><strong>Status:</strong> {{ ucfirst($product->status) }}</li>
                        <li><strong>Catch Date:</strong> 
                          @if($product->catch_date && is_object($product->catch_date))
                            {{ $product->catch_date->format('F d, Y') }}
                          @elseif($product->catch_date)
                            {{ $product->catch_date }}
                          @else
                            Recent
                          @endif
                        </li>
                        <li><strong>Available Stock:</strong> {{ $product->stock_kg }} kg</li>
                      </ul>
                    </div>
                   <form id="add-to-cart-form-{{ $product->id }}">
                      @csrf
                      <input type="hidden" name="product_id" value="{{ $product->id }}">

                      <!-- Add this hidden input -->
                      <input type="hidden" class="price" data-product-id="{{ $product->id }}" value="{{ $product->price_per_kg }}">

                      <div class="mb-3">
                        <label for="quantity-{{ $product->id }}" class="form-label text-ocean-deep">Quantity (kg):</label>
                        <div class="input-group">
                          <button type="button" class="btn btn-outline-ocean qty-decrease" data-product-id="{{ $product->id }}">-</button>
                          <input type="number" class="form-control text-center quantity-input" id="quantity-{{ $product->id }}" name="quantity" value="1" min="0.5" max="{{ $product->stock_kg }}" step="0.5" data-product-id="{{ $product->id }}">
                          <button type="button" class="btn btn-outline-ocean qty-increase" data-product-id="{{ $product->id }}">+</button>
                        </div>
                        <small class="text-muted">Maximum available: {{ $product->stock_kg }} kg</small>
                      </div>

                      <div class="mb-3">
                        <label for="total-{{ $product->id }}" class="form-label text-ocean-deep">Total Price:</label>
                        <div class="input-group">
                          <span class="input-grou p-text">₱</span>
                          <input type="text" class="form-control total-price" id="total-{{ $product->id }}" value="{{ number_format($product->price_per_kg, 2) }}" readonly>
                        </div>
                      </div>        
                      <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-ocean add-to-cart-btn" data-product-id="{{ $product->id }}">
                          <i class="bx bx-cart me-1"></i> Add to Cart
                        </button>
                        <button type="button" class="btn btn-coral buy-now-btn" data-product-id="{{ $product->id }}">
                          <i class="bx bx-credit-card me-1"></i> Buy Now
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach     
        <!-- Add New Catch Card -->
        <div class="col-md-3">
          <div class="h-100 d-flex flex-column justify-content-center align-items-center text-center p-4 bg-light rounded">
            <div class="mb-3">
              <span class="bg-ocean-light p-3 rounded-circle d-inline-flex justify-content-center align-items-center">
                <i class="bx bx-plus text-ocean-deep fs-3"></i>
              </span>
            </div>
            <h5 class="text-ocean-deep mb-2">Discover More</h5>
            <p class="text-muted mb-4">Find more fresh catches from local fishermen</p>
            <a href="" class="btn btn-ocean w-100">EXPLORE MORE</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="row mt-4">
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0 text-ocean-deep">Featured Fishermen</h5>
     <a href="#" class="btn btn-sm btn-outline-ocean" data-bs-toggle="modal" data-bs-target="#featuredFishermenModal">
      View All
    </a>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        @forelse($featuredFishermen as $fisher)
          <li class="list-group-item d-flex align-items-center {{ $loop->first ? 'border-top-0' : '' }} px-0">
            <div class="avatar me-3">
              @if($fisher->profile_photo)
                <img src="{{ asset('storage/' . $fisher->profile_photo) }}" alt="{{ $fisher->display_name }}" class="rounded-circle" width="40" height="40">
              @else
                <span class="avatar-initial rounded-circle bg-ocean-{{ ['medium', 'light', 'deep'][array_rand(['medium', 'light', 'deep'])] }} text-white">
                  {{ substr($fisher->display_name ?? $fisher->full_name, 0, 1) }}{{ substr(explode(' ', $fisher->display_name ?? $fisher->full_name)[1] ?? '', 0, 1) }}
                </span>
              @endif
            </div>
            <div class="d-flex flex-column flex-grow-1">
              <span class="fw-semibold text-ocean-deep">{{ $fisher->display_name ?? $fisher->full_name }}</span>
              <small class="text-muted">
                @if($fisher->fisher_type)
                  Specializes in {{ strtolower($fisher->fisher_type) }} fishing
                @elseif($fisher->sustainable_method)
                  Sustainable fishing practices
                @elseif($fisher->fishing_area)
                  Fishes in {{ $fisher->fishing_area }}
                @else
                  {{ \Illuminate\Support\Str::limit($fisher->bio, 30) ?? 'Professional fisherman' }}
                @endif
              </small>
            </div>
            @if(Auth::check() && Auth::user()->role === 'consumer')
              <form action="" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm {{ $fisher->isFollowedByConsumer(Auth::user()->consumer->id) ? 'btn-ocean' : 'btn-outline-ocean' }}">
                  {{ $fisher->isFollowedByConsumer(Auth::user()->consumer->id) ? 'Following' : 'Follow' }}
                </button>
              </form>
            @else
              <a href="" class="btn btn-sm btn-outline-ocean">Follow</a>
            @endif
          </li>
        @empty
          <li class="list-group-item text-center">
            <p class="text-muted my-2">No featured fishermen available at this time.</p>
          </li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
    
  <!-- Recent Orders -->
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0 text-ocean-deep">Recent Orders</h5>
      <a href="{{route('consumer.orders')}}" class="btn btn-sm btn-outline-ocean">View All</a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentOrders as $order)
            <tr>
              <td>#ORD-{{ $order->id }}</td>
              <td>{{ $order->created_at->format('F d, Y') }}</td>
              <td class="text-coral-deep fw-bold">₱{{ number_format($order->total_price, 2) }}</td>
              <td><span class="badge bg-label-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'processing' ? 'warning' : 'primary') }}">{{ ucfirst($order->status) }}</span></td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">
                <p class="text-muted my-2">No recent orders found.</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
  <!-- Featured Fishermen Modal -->
<div class="modal fade" id="featuredFishermenModal" tabindex="-1" aria-labelledby="featuredFishermenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg"> <!-- scrollable if long list -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-ocean-deep" id="featuredFishermenModalLabel">All Featured Fishermen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          @forelse($featuredFishermen as $fisher)
            <li class="list-group-item d-flex align-items-center {{ $loop->first ? 'border-top-0' : '' }} px-0">
              <div class="avatar me-3">
                @if($fisher->profile_photo)
                  <img src="{{ asset('storage/' . $fisher->profile_photo) }}" alt="{{ $fisher->display_name }}" class="rounded-circle" width="40" height="40">
                @else
                  <span class="avatar-initial rounded-circle bg-ocean-{{ ['medium', 'light', 'deep'][array_rand(['medium', 'light', 'deep'])] }} text-white">
                    {{ substr($fisher->display_name ?? $fisher->full_name, 0, 1) }}{{ substr(explode(' ', $fisher->display_name ?? $fisher->full_name)[1] ?? '', 0, 1) }}
                  </span>
                @endif
              </div>
              <div class="d-flex flex-column flex-grow-1">
                <span class="fw-semibold text-ocean-deep">{{ $fisher->display_name ?? $fisher->full_name }}</span>
                <small class="text-muted">
                  @if($fisher->fisher_type)
                    Specializes in {{ strtolower($fisher->fisher_type) }} fishing
                  @elseif($fisher->sustainable_method)
                    Sustainable fishing practices
                  @elseif($fisher->fishing_area)
                    Fishes in {{ $fisher->fishing_area }}
                  @else
                    {{ \Illuminate\Support\Str::limit($fisher->bio, 30) ?? 'Professional fisherman' }}
                  @endif
                </small>
              </div>
              @if(Auth::check() && Auth::user()->role === 'consumer')
                <form action="{{ route('fishermen.follow', $fisher->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-sm {{ $fisher->isFollowedByConsumer(Auth::user()->consumer->id) ? 'btn-ocean' : 'btn-outline-ocean' }}">
                    {{ $fisher->isFollowedByConsumer(Auth::user()->consumer->id) ? 'Following' : 'Follow' }}
                  </button>
                </form>
              @else
                <a href="{{ route('auth-login-basic') }}" class="btn btn-sm btn-outline-ocean">Follow</a>
              @endif
            </li>
          @empty
            <li class="list-group-item text-center">
              <p class="text-muted my-2">No featured fishermen available at this time.</p>
            </li>
          @endforelse
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  <!-- Recommended for You and Sustainable Fishing Tips -->
  <div class="row mt-4">
    <!-- Recommended For You -->
<div class="col-md-8">
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0 text-ocean-deep">Recommended For You</h5>
      <a href="#" class="btn btn-sm btn-outline-ocean">View All</a>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <div class="card shadow-none border border-ocean-light h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="avatar me-3">
                <img src="/assets/img/illustrations/premium_tuna.jpeg" alt="Seafood Package" class="rounded">
                </div>
                <div>
                  <h6 class="mb-0 text-ocean-deep">Premium Tuna Cuts</h6>
                  <small class="text-muted">Based on your preferences</small>
                </div>
              </div>
              <p class="card-text">Freshly cut premium tuna, perfect for sashimi or grilling.</p>
              <button class="btn btn-sm btn-ocean">View Details</button>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-none border border-ocean-light h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="avatar me-3">
                  <img src="/assets/img/illustrations/seafood_package.jpeg" alt="Seafood Package" class="rounded">
                </div>
                <div>
                  <h6 class="mb-0 text-ocean-deep">Seafood Package</h6>
                  <small class="text-muted">Popular in your area</small>
                </div>
              </div>
              <p class="card-text">Assorted fresh seafood perfect for a family gathering.</p>
              <button class="btn btn-sm btn-ocean">View Details</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Sustainable Fishing Tips -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="card-title mb-0 text-ocean-deep">Sustainable Fishing Tips</h5>
        </div>
        <div class="card-body">
          <div class="d-flex mb-3">
            <span class="badge bg-label-primary rounded p-2 me-2">
              <i class="bx bx-info-circle"></i>
            </span>
            <div>
              <h6 class="mb-0 text-ocean-deep">Know Your Seasons</h6>
              <small>Some fish species are best consumed in specific seasons.</small>
            </div>
          </div>
          <div class="d-flex mb-3">
            <span class="badge bg-label-success rounded p-2 me-2">
              <i class="bx bx-check-circle"></i>
            </span>
            <div>
              <h6 class="mb-0 text-ocean-deep">Choose Sustainably Caught</h6>
              <small>Look for certifications and responsibly-caught seafood.</small>
            </div>
          </div>
          <div class="d-flex">
            <span class="badge bg-label-warning rounded p-2 me-2">
              <i class="bx bx-bookmark"></i>
            </span>
            <div>
              <h6 class="mb-0 text-ocean-deep">Support Local Fishermen</h6>
              <small>Buying local reduces carbon footprint and supports communities.</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include Complete Profile Modal -->
<div class="modal fade" id="completeProfileModal" tabindex="-1" aria-labelledby="completeProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-ocean-deep" id="completeProfileModalLabel">
          {{ auth()->user()->consumer ? 'Update Profile' : 'Complete Your Profile' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Display User Info -->
        <div class="user-info mb-4">
          <h3 class="text-ocean-deep">Welcome, {{ auth()->user()->consumer ? auth()->user()->consumer->full_name : auth()->user()->email }}</h3>
          <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
          <p><strong>Role:</strong> {{ auth()->user()->role ?? 'Not assigned' }}</p>
        </div>

        <p class="mb-4">Please fill in your profile information below.</p>
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route('complete-profile.update') }}" id="completeProfileForm">
          @csrf

          <!-- Profile Completion Fields -->
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="full_name" name="full_name" 
                       value="{{ auth()->user()->consumer->full_name ?? old('full_name') }}" 
                       placeholder="Full Name" required>
                <label for="full_name">Full Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="phone" name="phone" 
                       value="{{ auth()->user()->consumer->phone ?? old('phone') }}" 
                       placeholder="Phone">
                <label for="phone">Phone</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="street" name="street" 
                       value="{{ auth()->user()->consumer->street ?? old('street') }}" 
                       placeholder="Street">
                <label for="street">Street</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="barangay" name="barangay" 
                       value="{{ auth()->user()->consumer->barangay ?? old('barangay') }}" 
                       placeholder="Barangay">
                <label for="barangay">Barangay</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="city" name="city" 
                       value="{{ auth()->user()->consumer->city ?? old('city') }}" 
                       placeholder="City">
                <label for="city">City</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="province" name="province" 
                       value="{{ auth()->user()->consumer->province ?? old('province') }}" 
                       placeholder="Province">
                <label for="province">Province</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="zip_code" name="zip_code" 
                       value="{{ auth()->user()->consumer->zip_code ?? old('zip_code') }}" 
                       placeholder="Zip Code">
                <label for="zip_code">Zip Code</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="dietary_restrictions" name="dietary_restrictions" 
                       value="{{ auth()->user()->consumer->dietary_restrictions ?? old('dietary_restrictions') }}" 
                       placeholder="Dietary Restrictions">
                <label for="dietary_restrictions">Dietary Restrictions</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control" id="delivery_instructions" name="delivery_instructions" 
                        placeholder="Delivery Instructions">{{ auth()->user()->consumer->delivery_instructions ?? old('delivery_instructions') }}</textarea>
                <label for="delivery_instructions">Delivery Instructions</label>
              </div>
            </div>
            
            <!-- Preferred Fish Types (JSON field) -->
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <select class="form-control select2" id="preferred_fish_types" name="preferred_fish_types[]" multiple>
                  <option value="Tilapia">Tilapia</option>
                  <option value="Bangus (Milkfish)">Bangus (Milkfish)</option>
                  <option value="Tuna">Tuna</option>
                  <option value="Galunggong (Mackerel)">Galunggong (Mackerel)</option>
                  <option value="Lapu-Lapu (Grouper)">Lapu-Lapu (Grouper)</option>
                  <option value="Dilis (Anchovy)">Dilis (Anchovy)</option>
                  <option value="Talakitok (Trevally)">Talakitok (Trevally)</option>
                  <option value="Tambakol (Skipjack)">Tambakol (Skipjack)</option>
                </select>
                <label for="preferred_fish_types">Preferred Fish Types</label>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <select class="form-control" id="preferred_payment_method" name="preferred_payment_method" required>
                  <option value="Card" {{ (auth()->user()->consumer && auth()->user()->consumer->preferred_payment_method == 'Card') ? 'selected' : '' }}>Card</option>
                  <option value="e-Wallet" {{ (auth()->user()->consumer && auth()->user()->consumer->preferred_payment_method == 'e-Wallet') ? 'selected' : '' }}>e-Wallet</option>
                  <option value="Cash on Delivery" {{ (auth()->user()->consumer && auth()->user()->consumer->preferred_payment_method == 'Cash on Delivery') ? 'selected' : '' }}>Cash on Delivery</option>
                  <option value="In-App Wallet" {{ (auth()->user()->consumer && auth()->user()->consumer->preferred_payment_method == 'In-App Wallet') ? 'selected' : '' }}>In-App Wallet</option>
                </select>
                <label for="preferred_payment_method">Preferred Payment Method</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="agreed_terms" name="agreed_terms" value="1" 
                       {{ (auth()->user()->consumer && auth()->user()->consumer->agreed_terms) ? 'checked' : '' }} 
                       required>
                <label class="form-check-label" for="agreed_terms">
                  I agree to the <a href="#" class="text-ocean-medium">terms and conditions</a>
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-ocean" onclick="document.getElementById('completeProfileForm').submit()">
          {{ auth()->user()->consumer ? 'Update Profile' : 'Save Profile' }}
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  function updateTotalPrice(productId) {
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const totalPriceInput = document.getElementById(`total-${productId}`);
    const priceInput = document.querySelector(`.price[data-product-id="${productId}"]`);

    if (!quantityInput || !totalPriceInput || !priceInput) return;

    const quantity = parseFloat(quantityInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    totalPriceInput.value = (quantity * price).toFixed(2);
  }

  document.querySelectorAll('.qty-increase').forEach(button => {
    button.addEventListener('click', () => {
      const productId = button.dataset.productId;
      const input = document.getElementById(`quantity-${productId}`);
      const max = parseFloat(input.max) || Infinity;
      const step = parseFloat(input.step) || 1;
      let current = parseFloat(input.value) || 0;

      if (current + step <= max) {
        input.value = (current + step).toFixed(1);
        updateTotalPrice(productId);
      }
    });
  });

  document.querySelectorAll('.qty-decrease').forEach(button => {
    button.addEventListener('click', () => {
      const productId = button.dataset.productId;
      const input = document.getElementById(`quantity-${productId}`);
      const min = parseFloat(input.min) || 0;
      const step = parseFloat(input.step) || 1;
      let current = parseFloat(input.value) || 0;

      if (current - step >= min) {
        input.value = (current - step).toFixed(1);
        updateTotalPrice(productId);
      }
    });
  });

  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', () => {
      const productId = input.dataset.productId;
      const val = parseFloat(input.value);
      const min = parseFloat(input.min) || 0;
      const max = parseFloat(input.max) || Infinity;

      input.value = Math.min(Math.max(val, min), max).toFixed(1);
      updateTotalPrice(productId);
    });
  });

  function handleResponse(response, productId, successMessage, redirect = null) {
    const modal = document.getElementById(`productModal-${productId}`);
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) bootstrapModal.hide();

    if (response.success) {
      Swal.fire({
        icon: 'success',
        title: successMessage,
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true,
      }).then(() => {
        if (redirect) window.location.href = response.redirect_url;
      });

      const cartCountElement = document.querySelector('.cart-count');
      if (cartCountElement && response.cartCount !== undefined) {
        cartCountElement.textContent = response.cartCount;
      }

      const quantityInput = document.getElementById(`quantity-${productId}`);
      quantityInput.value = 1;
      updateTotalPrice(productId);

    } else {
      Swal.fire({
        icon: 'error',
        title: 'Action Failed',
        text: response.message || 'Something went wrong.',
      });
    }
  }

  function handleError(error, productId, title) {
    const modal = document.getElementById(`productModal-${productId}`);
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) bootstrapModal.hide();

    console.error(`${title} error:`, error);
    Swal.fire({
      icon: 'error',
      title,
      text: 'An error occurred. Please try again.',
    });
  }

  document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const productId = button.dataset.productId;
      const quantity = parseFloat(document.getElementById(`quantity-${productId}`).value);

      const formData = new FormData();
      formData.append('product_id', productId);
      formData.append('quantity', quantity);
      formData.append('_token', csrfToken);

      fetch('/cart/add', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
      })
      .then(res => res.json())
      .then(data => handleResponse(data, productId, 'Added to Cart!'))
      .catch(err => handleError(err, productId, 'Add to Cart Failed'));
    });
  });

  document.querySelectorAll('.buy-now-btn').forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const productId = button.dataset.productId;
      const quantity = parseFloat(document.getElementById(`quantity-${productId}`).value);

      const formData = new FormData();
      formData.append('product_id', productId);
      formData.append('quantity', quantity);
      formData.append('_token', csrfToken);

      fetch('/checkout/buynow', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
      })
      .then(res => res.json())
      .then(data => handleResponse(data, productId, 'Purchase Successful!', true))
      .catch(err => handleError(err, productId, 'Buy Now Failed'));
    });
  });
});
</script>

@endsection