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