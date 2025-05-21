@extends('layouts.contentNavbarLayout') 

@section('title', 'Edit Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('profile') }}" class="text-muted fw-light">User Profile /</a> Edit Profile
  </h4>

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <h5 class="card-header">Edit Profile</h5>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Profile Photo -->
            <div class="row mb-4">
              <div class="col-12 text-center">
                <div class="d-flex justify-content-center mb-3">
                  @if($profile && $profile->profile_photo)
                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="Profile Photo" class="rounded-circle border shadow-sm" width="150" height="150">
                  @else
                    <img src="{{ asset('assets/img/illustrations/default.png') }}" alt="Default Profile" class="rounded-circle border shadow-sm" width="150" height="150">
                  @endif
                </div>
                <div class="mb-2">
                  <label for="profile_photo" class="form-label">Change Profile Photo</label>
                  <input class="form-control" type="file" id="profile_photo" name="profile_photo" style="max-width: 300px; margin: 0 auto;">
                </div>
              </div>
            </div>

            <!-- Common Fields -->
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $profile ? $profile->full_name : '' }}" required>
              </div>
              
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $profile ? $profile->phone : '' }}">
              </div>
            </div>

            @if($user->role === 'Consumer')
            <!-- Consumer-specific fields -->
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Address Information</h5>
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="street" name="street" value="{{ $profile ? $profile->street : '' }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="barangay" class="form-label">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" value="{{ $profile ? $profile->barangay : '' }}">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ $profile ? $profile->city : '' }}">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" value="{{ $profile ? $profile->province : '' }}">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="zip_code" class="form-label">ZIP Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $profile ? $profile->zip_code : '' }}">
                  </div>
                </div>

                <div class="mb-3 mt-2">
                  <label for="delivery_instructions" class="form-label">Delivery Instructions</label>
                  <textarea class="form-control" id="delivery_instructions" name="delivery_instructions" rows="3">{{ $profile ? $profile->delivery_instructions : '' }}</textarea>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Preferences</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="preferred_fish_types" class="form-label">Preferred Fish Types</label>
                    <select class="form-select" id="preferred_fish_types" name="preferred_fish_types[]" multiple>
                      @php
                        $fishTypes = ['Tuna', 'Tilapia', 'Bangus', 'Galunggong', 'Salmon', 'Lapu-Lapu', 'Maya-Maya', 'Tanigue', 'Tambakol', 'Dalagang Bukid'];
                        $selectedTypes = $profile && $profile->preferred_fish_types ? json_decode($profile->preferred_fish_types) : [];
                      @endphp
                      
                      @foreach($fishTypes as $type)
                        <option value="{{ $type }}" {{ in_array($type, $selectedTypes) ? 'selected' : '' }}>{{ $type }}</option>
                      @endforeach
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple fish types</div>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="preferred_payment_method" class="form-label">Preferred Payment Method</label>
                    <select class="form-select" id="preferred_payment_method" name="preferred_payment_method">
                      <option value="">Select payment method</option>
                      <option value="Cash on Delivery" {{ $profile && $profile->preferred_payment_method === 'Cash on Delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                      <option value="GCash" {{ $profile && $profile->preferred_payment_method === 'GCash' ? 'selected' : '' }}>GCash</option>
                      <option value="Bank Transfer" {{ $profile && $profile->preferred_payment_method === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                      <option value="Credit Card" {{ $profile && $profile->preferred_payment_method === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                  </div>
                  
                  <div class="col-12 mb-3">
                    <label for="dietary_restrictions" class="form-label">Dietary Restrictions</label>
                    <textarea class="form-control" id="dietary_restrictions" name="dietary_restrictions" rows="2">{{ $profile ? $profile->dietary_restrictions : '' }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            @elseif($user->role === 'Fisher')
            <!-- Fisher-specific fields -->
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Fisher Information</h5>
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label for="fishing_license" class="form-label">Fishing License</label>
                    <input type="text" class="form-control" id="fishing_license" name="fishing_license" value="{{ $profile ? $profile->fishing_license : '' }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="fisher_type" class="form-label">Fisher Type</label>
                    <select class="form-select" id="fisher_type" name="fisher_type">
                      <option value="">Select fisher type</option>
                      <option value="Commercial" {{ $profile && $profile->fisher_type === 'Commercial' ? 'selected' : '' }}>Commercial</option>
                      <option value="Artisanal" {{ $profile && $profile->fisher_type === 'Artisanal' ? 'selected' : '' }}>Artisanal</option>
                      <option value="Cooperative" {{ $profile && $profile->fisher_type === 'Cooperative' ? 'selected' : '' }}>Cooperative</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="boat_name" class="form-label">Boat Name</label>
                    <input type="text" class="form-control" id="boat_name" name="boat_name" value="{{ $profile ? $profile->boat_name : '' }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="fishing_area" class="form-label">Fishing Area</label>
                    <input type="text" class="form-control" id="fishing_area" name="fishing_area" value="{{ $profile ? $profile->fishing_area : '' }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="fishing_experience_years" class="form-label">Experience (years)</label>
                    <input type="number" class="form-control" id="fishing_experience_years" name="fishing_experience_years" value="{{ $profile ? $profile->fishing_experience_years : '' }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="display_name" class="form-label">Display Name</label>
                    <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $profile ? $profile->display_name : '' }}">
                  </div>
                </div>
                
                <div class="mb-3 mt-2">
                  <label for="bio" class="form-label">Bio</label>
                  <textarea class="form-control" id="bio" name="bio" rows="3">{{ $profile ? $profile->bio : '' }}</textarea>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Fishing Details</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="fish_types" class="form-label">Fish Types You Catch</label>
                    <select class="form-select" id="fish_types" name="fish_types[]" multiple>
                      @php
                        $fishTypes = ['Tuna', 'Tilapia', 'Bangus', 'Galunggong', 'Salmon', 'Lapu-Lapu', 'Maya-Maya', 'Tanigue', 'Tambakol', 'Dalagang Bukid'];
                        $selectedTypes = $profile && $profile->fish_types ? json_decode($profile->fish_types) : [];
                      @endphp
                      
                      @foreach($fishTypes as $type)
                        <option value="{{ $type }}" {{ in_array($type, $selectedTypes) ? 'selected' : '' }}>{{ $type }}</option>
                      @endforeach
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple fish types</div>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="quantity_per_catch" class="form-label">Quantity per Catch (kg)</label>
                    <input type="text" class="form-control" id="quantity_per_catch" name="quantity_per_catch" value="{{ $profile ? $profile->quantity_per_catch : '' }}">
                  </div>
                  
                  <div class="col-12 mb-3">
                    <label for="sustainable_method" class="form-label">Sustainable Method</label>
                    <textarea class="form-control" id="sustainable_method" name="sustainable_method" rows="2">{{ $profile ? $profile->sustainable_method : '' }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Payout Information</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="payout_method" class="form-label">Payout Method</label>
                    <select class="form-select" id="payout_method" name="payout_method">
                      <option value="">Select payout method</option>
                      <option value="Bank Transfer" {{ $profile && $profile->payout_method === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                      <option value="GCash" {{ $profile && $profile->payout_method === 'GCash' ? 'selected' : '' }}>GCash</option>
                      <option value="PayMaya" {{ $profile && $profile->payout_method === 'PayMaya' ? 'selected' : '' }}>PayMaya</option>
                    </select>
                  </div>
                </div>

                <div class="bank-details" id="bank-details" {{ $profile && $profile->payout_method === 'Bank Transfer' ? '' : 'style=display:none;' }}>
                  <div class="row g-3">
                    <div class="col-md-4 mb-3">
                      <label for="bank_name" class="form-label">Bank Name</label>
                      <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $profile ? $profile->bank_name : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="account_holder" class="form-label">Account Holder</label>
                      <input type="text" class="form-control" id="account_holder" name="account_holder" value="{{ $profile ? $profile->account_holder : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="account_number" class="form-label">Account Number</label>
                      <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $profile ? $profile->account_number : '' }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <div class="mt-4">
              <button type="submit" class="btn btn-primary me-2">Save Changes</button>
              <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    const payoutMethodSelect = document.getElementById('payout_method');
    const bankDetailsDiv = document.getElementById('bank-details');
    
    if (payoutMethodSelect && bankDetailsDiv) {
      payoutMethodSelect.addEventListener('change', function() {
        if (this.value === 'Bank Transfer') {
          bankDetailsDiv.style.display = 'block';
        } else {
          bankDetailsDiv.style.display = 'none';
        }
      });
    }

    
    const multiSelects = document.querySelectorAll('select[multiple]');
    multiSelects.forEach(select => {
      select.style.height = '150px';
    });
  });
</script>
@endsection
@endsection