<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-ocean-light">
        <h5 class="modal-title text-ocean-deep" id="checkoutModalLabel">Complete Your Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <form id="checkoutForm" action="" method="POST">
          @csrf
          
          @if(!Auth::check())
            <div class="alert alert-info mb-0 border-0 rounded-0">
              <i class="bx bx-info-circle me-2"></i> 
              Please <a href="{{ route('login') }}" class="fw-bold text-ocean-deep">login</a> to complete your checkout.
            </div>
          @endif
          
          <!-- Tabs -->
          <ul class="nav nav-tabs nav-fill mb-0" id="checkoutTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active text-ocean-deep" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab" aria-controls="summary" aria-selected="true">
                <i class="bx bx-cart me-1"></i> Order Summary
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link text-ocean-deep" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#delivery" type="button" role="tab" aria-controls="delivery" aria-selected="false">
                <i class="bx bx-map me-1"></i> Delivery
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link text-ocean-deep" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">
                <i class="bx bx-credit-card me-1"></i> Payment
              </button>
            </li>
          </ul>
          
          <!-- Tab Content -->
          <div class="tab-content" id="checkoutTabContent">
            <!-- Order Summary Tab -->
            <div class="tab-pane fade show active p-4" id="summary" role="tabpanel" aria-labelledby="summary-tab">
              <div class="card border shadow-sm">
                <div class="card-body">
                  <h6 class="text-ocean-deep mb-3">Items in Your Cart</h6>
                  
                  <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ asset('assets/img/illustrations/red_snapper.jpg') }}" alt="Red Snapper" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                    <div class="flex-grow-1">
                      <h6 class="mb-1">Red Snapper (Maya Maya)</h6>
                      <p class="text-muted small mb-0">Wild-caught using sustainable methods</p>
                    </div>
                    <div class="text-end">
                      <div class="fw-bold">₱640.00</div>
                      <small class="text-muted">2kg × ₱320.00</small>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₱640.00</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>₱80.00</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Tax</span>
                    <span>₱0.00</span>
                  </div>
                  
                  <div class="divider my-3"></div>
                  
                  <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-ocean-deep">₱720.00</span>
                  </div>
                  
                  <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-ocean" data-bs-dismiss="modal">
                      <i class="bx bx-arrow-back me-1"></i> Continue Shopping
                    </button>
                    <button type="button" class="btn btn-ocean next-tab" data-next="delivery-tab">
                      Delivery Info <i class="bx bx-right-arrow-alt ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Delivery Information Tab -->
            <div class="tab-pane fade p-4" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
              <div class="card border shadow-sm">
                <div class="card-body">
                  <h6 class="text-ocean-deep mb-3">Delivery Information</h6>
                  
                  @if(Auth::check())
                    @php
                      $consumer = Auth::user()->consumer;
                    @endphp
                    
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $consumer ? $consumer->full_name : Auth::user()->name }}" required>
                      </div>
                      <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $consumer ? $consumer->phone : '' }}" required>
                      </div>
                      <div class="col-md-12">
                        <label for="street" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="street" name="street" value="{{ $consumer ? $consumer->street : '' }}" required>
                      </div>
                      <div class="col-md-6">
                        <label for="barangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" value="{{ $consumer ? $consumer->barangay : '' }}" required>
                      </div>
                      <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $consumer ? $consumer->city : '' }}" required>
                      </div>
                      <div class="col-md-6">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" name="province" value="{{ $consumer ? $consumer->province : '' }}" required>
                      </div>
                      <div class="col-md-6">
                        <label for="zip_code" class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $consumer ? $consumer->zip_code : '' }}" required>
                      </div>
                      <div class="col-12">
                        <label for="delivery_instructions" class="form-label">Delivery Instructions (Optional)</label>
                        <textarea class="form-control" id="delivery_instructions" name="delivery_instructions" rows="2">{{ $consumer ? $consumer->delivery_instructions : '' }}</textarea>
                      </div>
                    </div>
                  @else
                    <div class="alert alert-warning">
                      <i class="bx bx-lock-alt me-2"></i> 
                      You need to be logged in to provide delivery information.
                    </div>
                  @endif
                  
                  <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-ocean prev-tab" data-prev="summary-tab">
                      <i class="bx bx-left-arrow-alt me-1"></i> Back to Summary
                    </button>
                    <button type="button" class="btn btn-ocean next-tab" data-next="payment-tab">
                      Payment Method <i class="bx bx-right-arrow-alt ms-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Payment Tab -->
            <div class="tab-pane fade p-4" id="payment" role="tabpanel" aria-labelledby="payment-tab">
              <div class="card border shadow-sm">
                <div class="card-body">
                  <h6 class="text-ocean-deep mb-3">Payment Method</h6>
                  
                  @if(Auth::check())
                    <div class="payment-options mb-4">
                      <div class="payment-option mb-3 p-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="cashOnDelivery" value="cash_on_delivery" checked>
                        <label class="form-check-label d-flex align-items-center w-100" for="cashOnDelivery">
                          <span class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bx bx-money text-success fs-4"></i>
                          </span>
                          <div>
                            <span class="d-block fw-bold">Cash on Delivery</span>
                            <small class="text-muted">Pay when you receive your order</small>
                          </div>
                        </label>
                      </div>
                      
                      <div class="payment-option mb-3 p-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="gcash" value="gcash" {{ $consumer && $consumer->preferred_payment_method == 'gcash' ? 'checked' : '' }}>
                        <label class="form-check-label d-flex align-items-center w-100" for="gcash">
                          <span class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bx bx-credit-card text-primary fs-4"></i>
                          </span>
                          <div>
                            <span class="d-block fw-bold">GCash</span>
                            <small class="text-muted">Pay using your GCash account</small>
                          </div>
                        </label>
                      </div>
                      
                      <div class="payment-option p-3 border rounded d-flex align-items-center">
                        <input class="form-check-input me-3" type="radio" name="payment_method" id="bankTransfer" value="bank_transfer" {{ $consumer && $consumer->preferred_payment_method == 'bank_transfer' ? 'checked' : '' }}>
                        <label class="form-check-label d-flex align-items-center w-100" for="bankTransfer">
                          <span class="bg-ocean-light p-2 rounded-circle me-3">
                            <i class="bx bx-bank text-ocean-deep fs-4"></i>
                          </span>
                          <div>
                            <span class="d-block fw-bold">Bank Transfer</span>
                            <small class="text-muted">Pay through bank transfer</small>
                          </div>
                        </label>
                      </div>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="form-check mb-4">
                      <input class="form-check-input" type="checkbox" id="agreed_terms" name="agreed_terms" required>
                      <label class="form-check-label" for="agreed_terms">
                        I agree to the <a href="#" class="text-ocean-medium">Terms of Service</a> and <a href="#" class="text-ocean-medium">Privacy Policy</a>
                      </label>
                    </div>
                    
                    <!-- Order Review Summary -->
                    <div class="card bg-light mb-4">
                      <div class="card-body">
                        <h6 class="text-ocean-deep mb-3">Order Review</h6>
                        <div class="d-flex justify-content-between">
                          <span>Items Total:</span>
                          <span>₱640.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <span>Shipping:</span>
                          <span>₱80.00</span>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="d-flex justify-content-between fw-bold">
                          <span>Total Amount:</span>
                          <span class="text-ocean-deep">₱720.00</span>
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="alert alert-warning">
                      <i class="bx bx-lock-alt me-2"></i> 
                      You need to be logged in to complete payment.
                    </div>
                  @endif
                  
                  <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-ocean prev-tab" data-prev="delivery-tab">
                      <i class="bx bx-left-arrow-alt me-1"></i> Back to Delivery
                    </button>
                    @if(Auth::check())
                      <button type="submit" class="btn btn-ocean">
                        <i class="bx bx-check me-1"></i> Place Order
                      </button>
                    @else
                      <a href="{{ route('login') }}" class="btn btn-ocean">
                        <i class="bx bx-log-in me-1"></i> Login to Continue
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>