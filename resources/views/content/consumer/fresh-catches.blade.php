@extends('layouts.contentNavbarLayout')
@section('title', 'Fresh Catches')
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
  
  .welcome-banner {
    background: linear-gradient(135deg, var(--ocean-medium) 0%, var(--ocean-deep) 100%);
    color: white;
    border-radius: 12px;
  }
  
  .welcome-banner h4, .welcome-banner p {
    color: white;
  }
  
  .product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 95, 115, 0.15);
  }
  
  .filter-item {
    cursor: pointer;
    padding: 8px 16px;
    border-radius: 20px;
    margin-right: 10px;
    transition: all 0.2s ease;
  }
  
  .filter-item:hover {
    background-color: rgba(10, 147, 150, 0.1);
  }
  
  .filter-item.active {
    background-color: var(--ocean-medium);
    color: white;
  }
  
  
  #loadMoreContainer {
    text-align: center;
    padding: 20px;
    display: none;
  }
  
  .loading-spinner {
    display: inline-block;
    width: 40px;
    height: 40px;
    border: 4px solid rgba(0, 95, 115, 0.1);
    border-radius: 50%;
    border-top-color: var(--ocean-medium);
    animation: spin 1s ease-in-out infinite;
    margin-bottom: 10px;
  }
  
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  
  
  #noResultsMessage {
    text-align: center;
    padding: 40px 20px;
    display: none;
  }
  
  
  .item-count-badge {
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    margin-left: 10px;
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
  <!-- Filters Section -->
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title text-ocean-deep mb-0">Filter Options</h5>
          <button class="btn btn-sm btn-outline-ocean" id="clearFilters">Clear Filters</button>
        </div>
    <div class="row g-3">
      <!-- Fish Type Filter -->
      <div class="col-md-3">
  <label for="fishTypeFilter" class="form-label text-ocean-deep">Fish Type</label>
  <select class="form-select" id="fishTypeFilter" name="fishType">
    <option value="">All Types</option>
            @foreach($fishTypes as $fishType)
            <option value="{{ $fishType }}" {{ request('fishType') == $fishType ? 'selected' : '' }}>
                @if($fishType == 'Bangus')
                Bangus (Milkfish)
                @elseif($fishType == 'Galunggong')
                Galunggong (Mackerel)
                @elseif($fishType == 'Lapu-Lapu')
                Lapu-Lapu (Grouper)
                @elseif($fishType == 'Dilis')
                Dilis (Anchovy)
                @else
                {{ $fishType }}
                @endif
            </option>
            @endforeach
        </select>
        </div>
            
      <!-- Price Range Filter -->
      <div class="col-md-3">
        <label for="priceRangeFilter" class="form-label text-ocean-deep">Price Range</label>
        <select class="form-select" id="priceRangeFilter">
          <option value="">Any Price</option>
          <option value="0-100">Under ₱100</option>
          <option value="100-200">₱100 - ₱200</option>
          <option value="200-300">₱200 - ₱300</option>
          <option value="300+">Above ₱300</option>
        </select>
      </div>
      
      <!-- Fisherman Filter -->
      <div class="col-md-3">
        <label for="fishermanFilter" class="form-label text-ocean-deep">Fisherman</label>
        <select class="form-select" id="fishermanFilter">
          <option value="">All Fishermen</option>
          @foreach($fishermen as $fisher)
            <option value="{{ $fisher->id }}">{{ $fisher->display_name ?? $fisher->full_name }}</option>
          @endforeach
        </select>
      </div>
      
      <!-- Freshness Filter -->
      <div class="col-md-3">
        <label for="freshnessFilter" class="form-label text-ocean-deep">Freshness</label>
        <select class="form-select" id="freshnessFilter">
          <option value="">Any</option>
          <option value="today">Caught Today</option>
          <option value="yesterday">Caught Yesterday</option>
          <option value="week">Within a Week</option>
        </select>
      </div>
    </div>
    
    <!-- Quick Filters -->
    <div class="mt-3">
      <label class="form-label text-ocean-deep d-block">Quick Filters</label>
      <div class="d-flex flex-wrap">
        <span class="filter-item border border-ocean-light" data-filter="sustainable">Sustainable Fishing</span>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- Sort and View Options with Results Count -->
  <div class="col-12 mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <span class="me-2">Sort by:</span>
        <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
          <option value="latest">Latest</option>
          <option value="price_low">Price: Low to High</option>
          <option value="price_high">Price: High to Low</option>
        </select>
        <span class="item-count-badge" id="resultCount">{{ $freshCatches->count() }} items</span>
      </div>
      <div class="d-flex align-items-center">
      </div>
    </div>
  </div>
  <!-- Fresh Catches Grid -->
  <div class="col-12">
    <div class="row g-4 mb-4" id="freshCatchesGrid">
      <!-- Loop through fresh catches -->
      @foreach($freshCatches as $product)
      <div class="col-lg-3 col-md-4 col-sm-6 product-card">
        <div class="card h-100">
          <div class="position-relative" style="height: 180px; overflow: hidden; cursor: pointer" 
               data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
            <span class="badge bg-ocean-light text-ocean-deep position-absolute top-0 start-0 m-2">{{ ucfirst($product->status) }}</span>
            @if($product->is_sustainable)
              <span class="badge bg-label-success position-absolute top-0 end-0 m-2">Sustainable</span>
            @endif
            <img class="img-fluid rounded-top w-100 h-100 object-fit-cover" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
          </div>
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <h5 class="text-ocean-deep">{{ $product->name }}</h5>
              <p class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
            </div>
            <div class="mt-3">
              <div class="d-flex justify-content-between align-items-center">
                <div class="text-coral-deep fw-bold">₱{{ number_format($product->price_per_kg, 2) }}/kg</div>
                <div class="text-muted small">{{ $product->stock_kg }} kg available</div>
              </div>
              @if($product->fisher)
              <div class="d-flex align-items-center mt-2">
                @if($product->fisher->profile_photo)
                  <img src="{{ asset('storage/' . $product->fisher->profile_photo) }}" alt="{{ $product->fisher->display_name }}" class="rounded-circle me-1" width="20" height="20">
                @else
                  <span class="avatar-initial rounded-circle bg-ocean-medium text-white me-1" style="width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                    {{ substr($product->fisher->display_name ?? $product->fisher->full_name, 0, 1) }}
                  </span>
                @endif
                <small class="text-muted">{{ $product->fisher->display_name ?? $product->fisher->full_name }}</small>
              </div>
              @endif
              <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-sm btn-ocean w-100 me-1" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">View Details</button>
                <button class="btn btn-sm btn-outline-ocean quick-add-btn" data-product-id="{{ $product->id }}">
                  <i class="bx bx-cart"></i>
                </button>
              </div>
            </div>
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
              
              <!-- Additional product images carousel (if available) -->
              @if(isset($product->additional_images) && count($product->additional_images) > 0)
              <div class="mt-3">
                <h6 class="text-ocean-deep">More Images:</h6>
                <div class="d-flex overflow-auto">
                  @foreach($product->additional_images as $image)
                  <img src="{{ asset($image) }}" alt="Additional image" class="rounded me-2" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" 
                       onclick="document.querySelector('#productModal-{{ $product->id }} .col-md-6 > img').src = this.src">
                  @endforeach
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
                  @if(isset($product->fishing_method) && $product->fishing_method)
                  <li><strong>Fishing Method:</strong> {{ $product->fishing_method }}</li>
                  @endif
                  @if(isset($product->nutritional_info) && $product->nutritional_info)
                  <li><strong>Nutritional Info:</strong> {{ $product->nutritional_info }}</li>
                  @endif
                  @if(isset($product->sustainability_rating) && $product->sustainability_rating)
                  <li><strong>Sustainability Rating:</strong> 
                    <div class="stars">
                      @for($i = 1; $i <= 5; $i++)
                        <i class="bx {{ $i <= $product->sustainability_rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                      @endfor
                    </div>
                  </li>
                  @endif
                </ul>
              </div>
              <form id="add-to-cart-form-{{ $product->id }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
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
                    <span class="input-group-text">₱</span>
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
</div>

<!-- Loading Indicator (Visible when "Load More" is enabled) -->
<div id="loadMoreContainer">
  <div class="loading-spinner"></div>
  <p>Loading more fresh catches...</p>
</div>

<!-- No Results Message -->
<div id="noResultsMessage" class="card p-5">
  <div class="text-center">
    <i class="bx bx-search-alt text-ocean-medium" style="font-size: 60px;"></i>
    <h4 class="mt-3 text-ocean-deep">No fresh catches found</h4>
    <p class="text-muted">Try adjusting your search filters or check back later for new arrivals.</p>
    <button class="btn btn-outline-ocean mt-3" id="resetFiltersBtn">Reset All Filters</button>
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

  function setupQuantityButtons() {
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
        updateTotalPrice(productId);
      });

      input.addEventListener('change', () => {
        const productId = input.dataset.productId;
        const val = parseFloat(input.value);
        const min = parseFloat(input.min) || 0;
        const max = parseFloat(input.max) || Infinity;

        input.value = Math.min(Math.max(val, min), max).toFixed(1);
        updateTotalPrice(productId);
      });
    });
  }

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
        if (redirect && response.redirect_url) window.location.href = response.redirect_url;
      });

      const cartCountElement = document.querySelector('.cart-count');
      if (cartCountElement && response.cartCount !== undefined) {
        cartCountElement.textContent = response.cartCount;
      }

      const quantityInput = document.getElementById(`quantity-${productId}`);
      if (quantityInput) {
        quantityInput.value = 1;
        updateTotalPrice(productId);
      }
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

  function setupCartAndPurchaseButtons() {
    document.querySelectorAll('.quick-add-btn').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const productId = button.dataset.productId;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1);
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

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const productId = button.dataset.productId;
        const quantityInput = document.getElementById(`quantity-${productId}`);
        if (!quantityInput) return;

        const quantity = parseFloat(quantityInput.value);

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
        const quantityInput = document.getElementById(`quantity-${productId}`);
        if (!quantityInput) return;

        const quantity = parseFloat(quantityInput.value);

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
  }

  const filterForm = {
    fishType: document.getElementById('fishTypeFilter'),
    priceRange: document.getElementById('priceRangeFilter'),
    fisherman: document.getElementById('fishermanFilter'),
    freshness: document.getElementById('freshnessFilter'),
    sort: document.querySelector('#sortSelect'),
    itemsPerView: document.querySelector('#itemsPerViewSelect'),
    quickFilters: document.querySelectorAll('.filter-item'),
    clearButton: document.getElementById('clearFilters'),
    resetFiltersBtn: document.getElementById('resetFiltersBtn')
  };

  function getFilterValues() {
    return {
      fishType: filterForm.fishType?.value || '',
      priceRange: filterForm.priceRange?.value || '',
      fisherman: filterForm.fisherman?.value || '',
      freshness: filterForm.freshness?.value || '',
      sort: filterForm.sort?.value || 'latest',
      itemsPerView: filterForm.itemsPerView?.value || '12',
      quickFilter: document.querySelector('.filter-item.active')?.dataset.filter || ''
    };
  }

  function applyFilters() {
    const filterValues = getFilterValues();
    const queryParams = new URLSearchParams();

    for (const [key, value] of Object.entries(filterValues)) {
      if (value) queryParams.append(key, value);
    }

    const productsGrid = document.getElementById('freshCatchesGrid');
    if (productsGrid) {
      productsGrid.classList.add('opacity-50');
    }

    fetch(`fresh-catches?${queryParams.toString()}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (productsGrid) {
        productsGrid.innerHTML = data.html;
        productsGrid.classList.remove('opacity-50');
      }

      const resultCount = document.getElementById('resultCount');
      if (resultCount && data.count !== undefined) {
        resultCount.textContent = `${data.count} items`;
      }

      const noResultsMessage = document.getElementById('noResultsMessage');
      if (noResultsMessage) {
        if (data.count === 0) {
          noResultsMessage.style.display = 'block';
          productsGrid.style.display = 'none';
        } else {
          noResultsMessage.style.display = 'none';
          productsGrid.style.display = 'flex';
        }
      }

      window.history.pushState({}, '', `/fresh-catches`);

      setupQuantityButtons();
      setupCartAndPurchaseButtons();
    })
    .catch(error => {
      console.error('Error applying filters:', error);
      if (productsGrid) {
        productsGrid.classList.remove('opacity-50');
      }

      Swal.fire({
        icon: 'error',
        title: 'Filter Error',
        text: 'Unable to apply filters. Please try again.',
      });
    });
  }

  if (filterForm.fishType) filterForm.fishType.addEventListener('change', applyFilters);
  if (filterForm.priceRange) filterForm.priceRange.addEventListener('change', applyFilters);
  if (filterForm.fisherman) filterForm.fisherman.addEventListener('change', applyFilters);
  if (filterForm.freshness) filterForm.freshness.addEventListener('change', applyFilters);
  if (filterForm.sort) filterForm.sort.addEventListener('change', applyFilters);
  if (filterForm.itemsPerView) filterForm.itemsPerView.addEventListener('change', applyFilters);

  if (filterForm.quickFilters) {
    filterForm.quickFilters.forEach(item => {
      item.addEventListener('click', () => {
        const wasActive = item.classList.contains('active');

        document.querySelectorAll('.filter-item').forEach(el => {
          el.classList.remove('active');
        });

        if (!wasActive) {
          item.classList.add('active');
        }

        applyFilters();
      });
    });
  }

  if (filterForm.clearButton) {
    filterForm.clearButton.addEventListener('click', () => {
      resetAllFilters();
    });
  }

  if (filterForm.resetFiltersBtn) {
    filterForm.resetFiltersBtn.addEventListener('click', () => {
      resetAllFilters();
    });
  }

  function resetAllFilters() {
    if (filterForm.fishType) filterForm.fishType.value = '';
    if (filterForm.priceRange) filterForm.priceRange.value = '';
    if (filterForm.fisherman) filterForm.fisherman.value = '';
    if (filterForm.freshness) filterForm.freshness.value = '';
    if (filterForm.sort) filterForm.sort.value = 'latest';
    if (filterForm.itemsPerView) filterForm.itemsPerView.value = '12';

    document.querySelectorAll('.filter-item').forEach(el => {
      el.classList.remove('active');
    });

    applyFilters();
  }

  
  setupQuantityButtons();
  setupCartAndPurchaseButtons();
});
</script>

@endsection