@extends('layouts.contentNavbarLayout')

@section('title', 'Fisher Dashboard')

@section('vendor-style')
<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<!-- Import Inter font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('page-style')
<!-- Page CSS -->
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
  
  .listings-card.h-100 {
    box-shadow: none;
    transition: transform 0.2s ease;
  }

  .listings-card.h-100:hover {
    transform: translateY(-5px);
  }

  .bg-ocean-light {
    background-color: var(--ocean-light) !important;
    opacity: 0.9;
  }

  .add-listing-card {
    border: 2px dashed var(--ocean-light);
    background-color: rgba(148, 210, 189, 0.1);
  }

  
  #earningsChart {
    height: 100%;
    min-height: 120px;
  }

  .card-info h4 {
    color: var(--ocean-deep);
    font-weight: 600;
  }

  .bg-light {
    background-color: rgba(148, 210, 189, 0.1) !important;
  }

  .text-success {
    color: #2e8b57 !important;
  }

  
.customer-card {
  box-shadow: none;
  border: 1px solid rgba(0, 95, 115, 0.1);
  transition: all 0.2s ease;
}

.customer-card:hover {
  border-color: var(--ocean-light);
  background-color: rgba(148, 210, 189, 0.05);
}

.avatar.bg-ocean-light {
  background-color: var(--ocean-light) !important;
  opacity: 1;
}

.badge.bg-label-primary {
  background-color: rgba(10, 147, 150, 0.1) !important;
  color: var(--ocean-medium) !important;
}
</style>
@endsection

@section('vendor-script')
<!-- Vendor JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

@section('content')
<div class="row">
  <!-- Welcome Card -->
  <div class="col-12">
    <div class="card welcome-banner">
      <div class="d-flex align-items-end row">
        <div class="col-md-8">
          <div class="card-body">
            <h4 class="card-title">Welcome {{ auth()->user()->fisher ? auth()->user()->fisher->full_name : auth()->user()->email }}! 🎣</h4>
            <p class="mb-4">Connect with customers and sell your fresh catch directly</p>
            
            @if(!auth()->user()->fisher)
              <p class="mb-2 text-warning">Complete your profile to gain better visibility to customers</p>
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
            <img src="{{ asset('assets/img/illustrations/fishing_boat.png') }}" height="140" alt="Fishing Boat Illustration">
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Today's Listings Section -->
<div class="col-md-12 mt-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0 text-ocean-deep">Your Active Listings</h5>
      <a href="" class="btn btn-sm btn-outline-ocean">
        <i class="bx bx-list-ul me-1"></i> View All catches
      </a>
    </div>
    <div class="card-body">
      <!-- Swiper Container -->
      <div class="swiper" id="swiper-today-listings">
        <div class="swiper-wrapper">

          @foreach ($activeListings as $listing)
          <!-- Listing Item -->
          <div class="swiper-slide" style="width: 300px;">
            <div class="card shadow-none listings-card h-100">
              <div class="position-relative">
               <img class="card-img-top" src="{{ asset($listing->image_path) }}" alt="{{ $listing->name }}"
                     style="object-fit: cover; width: 100%; height: 200px;">
                <span class="badge badge-fresh position-absolute top-0 end-0 mt-2 me-2">Active</span>
              </div>
              <div class="card-body d-flex flex-column" style="height: 180px;">
                <div>
                  <h5 class="card-title text-ocean-deep">{{ $listing->name }}</h5>
                  <p class="card-text">{{ $listing->description }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                  <div class="text-coral-deep fw-bold">₱{{ $listing->price_per_kg }} per kg</div>
                <button type="button" class="btn btn-outline-ocean" 
                  data-bs-toggle="modal" 
                  data-bs-target="#editCatchModal"
                  data-id="{{ $listing->id }}"
                  data-name="{{ $listing->name }}"
                  data-price="{{ $listing->price_per_kg }}"
                  data-stock="{{ $listing->stock_kg }}"
                  data-status="{{ $listing->status }}"
                  data-date="{{ $listing->catch_date }}"
                  data-description="{{ $listing->description }}"
                  data-image="{{ $listing->image_path }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          <!-- Empty Listing Card -->
          <div class="swiper-slide" style="width: 300px;">
            <div class="card shadow-none listings-card h-100 d-flex align-items-center justify-content-center bg-light">
              <div class="card-body text-center py-4">
                <div class="bg-ocean-light p-3 rounded-circle d-inline-flex mb-3">
                  <i class="bx bx-plus text-ocean-deep fs-4"></i>
                </div>
                <h5 class="mb-2 text-ocean-deep">Add New Catch</h5>
                <p class="text-muted mb-3">List your fresh catch for customers</p>
                <button type="button" class="btn btn-sm btn-ocean" data-bs-toggle="modal" data-bs-target="#addNewCatchModal">
                  <i class="fas fa-plus me-1"></i> Add New Catch
                </button>
              </div>
            </div>
          </div>

        </div>
        <div class="swiper-pagination mt-3"></div>
      </div>
    </div>
  </div>
</div>
<div class="row g-4"> <!-- Add gutter to row for spacing -->

  <!-- Recent Orders Card -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-ocean-deep">Recent Orders</h5>
        <a href="{{route('catches.order')}}" class="btn btn-sm btn-outline-ocean">View All</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0"> <!-- remove extra margin below table -->
          <thead>
            <tr>
              <th>ORDER #</th>
              <th>CUSTOMER</th>
              <th>AMOUNT</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentOrders as $order)
              <tr>
                <td>#ORD-{{ $order->id }}</td>
                <td>{{ $order->consumer->full_name ?? 'N/A' }}</td>
                <td class="text-coral-deep fw-bold">₱{{ number_format($order->total_price, 2) }}</td>
                <td>
                  @php
                    $statusClasses = [
                      'pending' => 'bg-label-warning',
                      'confirmed' => 'bg-label-info',
                      'shipped' => 'bg-label-primary',
                      'delivered' => 'bg-label-success',
                      'cancelled' => 'bg-label-danger'
                    ];
                  @endphp
                  <span class="badge {{ $statusClasses[$order->status] ?? 'bg-label-secondary' }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No recent orders found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
<!-- Earnings Overview Card -->
<div class="col-md-6">
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0 text-ocean-deep">Earnings Overview</h5>
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-ocean dropdown-toggle" type="button" data-bs-toggle="dropdown">
          {{ $earningsPeriodText }}
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="?period=this_week">This Week</a></li>
          <li><a class="dropdown-item" href="?period=this_month">This Month</a></li>
          <li><a class="dropdown-item" href="?period=last_3_months">Last 3 Months</a></li>
        </ul>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
          <div class="p-3 bg-light rounded-3">
            <div class="d-flex align-items-center">
              <div class="card-info">
                <h4 class="mb-0">₱{{ number_format($totalEarnings, 2) }}</h4>
                @php
                  $isPositive = $earningsChangePercent >= 0;
                  $arrow = $isPositive ? 'up' : 'down';
                  $textClass = $isPositive ? 'text-success' : 'text-danger';
                @endphp
                <small class="{{ $textClass }} fw-semibold">
                  <i class="bx bx-chevron-{{ $arrow }}"></i>
                  {{ abs(number_format($earningsChangePercent, 1)) }}%
                </small>
              </div>
            </div>
            <h5 class="mt-3 pt-1 mb-1 text-ocean-deep">Total Earnings</h5>
            <p class="mb-0 text-muted">{{ $earningsPeriodText }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <canvas id="earningsChart" height="160"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js Script -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('earningsChart').getContext('2d');
  const earningsChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($chartLabels),
      datasets: [{
        label: 'Earnings',
        data: @json($chartValues),
        borderColor: '#1e88e5',
        backgroundColor: 'rgba(30, 136, 229, 0.1)',
        fill: true,
        tension: 0.3,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return '₱' + parseFloat(context.raw).toFixed(2);
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return '₱' + value;
            }
          }
        }
      }
    }
  });
</script>
@endpush


</div> <!-- end .row -->

  <!-- Customers and Fishing Tips -->
  <div class="row mt-4">
   <!-- Top Customers -->
    <div class="col-md-8">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0 text-ocean-deep">Top Customers</h5>
          <button type="button" class="btn btn-sm btn-outline-ocean" data-bs-toggle="modal" data-bs-target="#topCustomersModal">
          View All
        </button>
        </div>
        <div class="card-body">
          <div class="row g-3">
            @foreach ($topCustomers as $customer)
              <div class="col-md-6">
                <div class="card shadow-none customer-card h-100">
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <div class="avatar avatar-sm me-2 bg-ocean-light">
                        <span class="avatar-initial rounded-circle text-ocean-deep">
                        {{ strtoupper(substr($customer->consumer->full_name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $customer->consumer->full_name)[1] ?? '', 0, 1)) }}
                        </span>
                      </div>
                      <div>
                        <h6 class="mb-0 text-ocean-deep">{{ $customer->consumer->full_name }}</h6>

                        <small class="text-muted">
                          {{-- Add a note here, or hardcode for now --}}
                          Regular buyer
                        </small>
                      </div>
                    </div>
                    <div class="mb-3 p-2 bg-light rounded-2">
                      <span class="fw-medium text-dark mb-1 d-block">Prefers</span>
                      @if(!empty($customer->preferred_fish_types))
                        @foreach(json_decode($customer->preferred_fish_types) as $fish)
                          <span class="badge bg-label-primary me-1">{{ $fish }}</span>
                        @endforeach
                      @else
                        <span class="text-muted">No preferences</span>
                      @endif
                    </div>
                    <p class="text-muted mb-3">
                      Orders: {{ $customer->orders_count }} | Total: ₱{{ number_format($customer->total_spent, 2) }}
                    </p>
                  </div>
                </div>
              </div>
            @endforeach
            @if ($topCustomers->isEmpty())
              <p class="text-center text-muted">No top customers found yet.</p>
            @endif
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
      <div class="modal-header bg-ocean-light border-ocean-light">
        <h5 class="modal-title text-ocean-deep" id="completeProfileModalLabel">
          {{ auth()->user()->fisher && auth()->user()->fisher->is_profile_complete ? 'Update Profile' : 'Complete Your Profile' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Display User Info -->
        <div class="user-info mb-4 p-3 rounded bg-ocean-light bg-opacity-25">
          <h3 class="h5 mb-2 text-ocean-deep">Welcome, {{ auth()->user()->fisher ? auth()->user()->fisher->full_name : auth()->user()->email }}</h3>
          <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
          <p class="mb-0"><strong>Role:</strong> {{ auth()->user()->role }}</p>
        </div>

        <p class="mb-4 text-ocean-medium">Please complete your fisher profile information below.</p>
        @if ($errors->any())
          <div class="alert alert-danger border-coral-deep">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('fisher.complete-profile.update') }}" id="completeProfileForm" enctype="multipart/form-data">
          @csrf
          <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
              <a class="nav-link active text-ocean-medium" data-bs-toggle="tab" href="#personal-info">Personal Info</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-ocean-medium" data-bs-toggle="tab" href="#fishing-details">Fishing Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-ocean-medium" data-bs-toggle="tab" href="#payment-info">Payment Info</a>
            </li>
          </ul>
          
          <div class="tab-content">
            <!-- Personal Info Tab -->
            <div class="tab-pane fade show active" id="personal-info">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="full_name" name="full_name" 
                          value="{{ auth()->user()->fisher->full_name ?? old('full_name') }}" 
                          placeholder="Full Name" required>
                    <label for="full_name">Full Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="phone" name="phone" 
                          value="{{ auth()->user()->fisher->phone ?? old('phone') }}" 
                          placeholder="Phone" required>
                    <label for="phone">Phone</label>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-floating form-floating-outline">
                    <textarea class="form-control border-ocean-light" id="bio" name="bio" 
                              placeholder="Tell customers about yourself and your fishing experience" 
                              style="height: 100px">{{ auth()->user()->fisher->bio ?? old('bio') }}</textarea>
                    <label for="bio">Bio</label>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="profile_photo" class="form-label text-ocean-deep">Profile Image</label>
                    <input type="file" class="form-control border-ocean-light" id="profile_photo" name="profile_photo">
                    <small class="text-muted">Upload a clear photo of yourself or your boat.</small>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Fishing Details Tab -->
            <div class="tab-pane fade" id="fishing-details">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                  <select name="fisher_type" id="fisher_type" class="form-control border-ocean-light" required>
                      <option value="">-- Select Fisher Type --</option>
                      @foreach(\App\Models\Fisher::FISHER_TYPES as $type)
                          <option value="{{ $type }}" {{ (isset($fisher) && $fisher->fisher_type == $type) ? 'selected' : '' }}>{{ $type }}</option>
                      @endforeach
                  </select>
                    <label for="fisher_type">Fisher Type</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="fishing_license" name="fishing_license" 
                          value="{{ auth()->user()->fisher->fishing_license ?? old('fishing_license') }}" 
                          placeholder="Fishing License Number">
                    <label for="fishing_license">Fishing License Number</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="fishing_area" name="fishing_area" 
                          value="{{ auth()->user()->fisher->fishing_area ?? old('fishing_area') }}" 
                          placeholder="Primary Fishing Area">
                    <label for="fishing_area">Primary Fishing Area</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="number" class="form-control border-ocean-light" id="fishing_experience_years" name="fishing_experience_years" 
                          value="{{ auth()->user()->fisher->fishing_experience_years ?? old('fishing_experience_years') }}" 
                          placeholder="Years of Experience">
                    <label for="fishing_experience_years">Years of Experience</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="boat_name" name="boat_name"
                      value="{{ auth()->user()->fisher->boat_name ?? old('boat_name') }}" 
                      placeholder="Boat Name (if applicable)">
                    <label for="boat_name">Boat Name (if applicable)</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <select class="form-control border-ocean-light" id="sustainable_method" name="sustainable_method">
                      <option value="">Select Method</option>
                      <option value="Net Fishing" {{ (auth()->user()->fisher && auth()->user()->fisher->sustainable_method == 'Net Fishing') ? 'selected' : '' }}>Net Fishing</option>
                      <option value="Line Fishing" {{ (auth()->user()->fisher && auth()->user()->fisher->sustainable_method == 'Line Fishing') ? 'selected' : '' }}>Line Fishing</option>
                      <option value="Trap Fishing" {{ (auth()->user()->fisher && auth()->user()->fisher->sustainable_method == 'Trap Fishing') ? 'selected' : '' }}>Trap Fishing</option>
                      <option value="Spear Fishing" {{ (auth()->user()->fisher && auth()->user()->fisher->sustainable_method == 'Spear Fishing') ? 'selected' : '' }}>Spear Fishing</option>
                      <option value="Multiple Methods" {{ (auth()->user()->fisher && auth()->user()->fisher->sustainable_method == 'Multiple Methods') ? 'selected' : '' }}>Multiple Methods</option>
                    </select>
                    <label for="sustainable_method">Fishing Method</label>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-floating form-floating-outline">
                    <select class="form-control border-ocean-light select2" id="fish_types" name="fish_types[]" multiple>
                      <option value="Tilapia" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Tilapia', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Tilapia</option>
                      <option value="Bangus (Milkfish)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Bangus (Milkfish)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Bangus (Milkfish)</option>
                      <option value="Tuna" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Tuna', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Tuna</option>
                      <option value="Galunggong (Mackerel)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Galunggong (Mackerel)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Galunggong (Mackerel)</option>
                      <option value="Lapu-Lapu (Grouper)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Lapu-Lapu (Grouper)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Lapu-Lapu (Grouper)</option>
                      <option value="Dilis (Anchovy)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Dilis (Anchovy)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Dilis (Anchovy)</option>
                      <option value="Talakitok (Trevally)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Talakitok (Trevally)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Talakitok (Trevally)</option>
                      <option value="Tambakol (Skipjack)" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Tambakol (Skipjack)', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Tambakol (Skipjack)</option>
                      <option value="Crabs" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Crabs', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Crabs</option>
                      <option value="Shrimp" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Shrimp', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Shrimp</option>
                      <option value="Squid" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Squid', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Squid</option>
                      <option value="Other" {{ (auth()->user()->fisher && auth()->user()->fisher->fish_types && in_array('Other', json_decode(auth()->user()->fisher->fish_types))) ? 'selected' : '' }}>Other</option>
                    </select>
                    <label for="fish_types">Fish Types You Catch</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="quantity_per_catch" name="quantity_per_catch" 
                          value="{{ auth()->user()->fisher->quantity_per_catch ?? old('quantity_per_catch') }}" 
                          placeholder="Average Quantity Per Catch">
                    <label for="quantity_per_catch">Average Quantity Per Catch (kg)</label>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Payment Info Tab -->
            <div class="tab-pane fade" id="payment-info">
              <div class="row g-3">
                <div class="col-md-12">
                  <div class="form-floating form-floating-outline">
                    <select class="form-control border-ocean-light" id="payout_method" name="payout_method">
                      <option value="Bank Transfer" {{ (auth()->user()->fisher && auth()->user()->fisher->payout_method == 'Bank Transfer') ? 'selected' : '' }}>Bank Transfer</option>
                      <option value="GCash" {{ (auth()->user()->fisher && auth()->user()->fisher->payout_method == 'GCash') ? 'selected' : '' }}>GCash</option>
                      <option value="PayMaya" {{ (auth()->user()->fisher && auth()->user()->fisher->payout_method == 'PayMaya') ? 'selected' : '' }}>PayMaya</option>
                      <option value="Cash" {{ (auth()->user()->fisher && auth()->user()->fisher->payout_method == 'Cash') ? 'selected' : '' }}>Cash</option>
                    </select>
                    <label for="payout_method">Preferred Payout Method</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="bank_name" name="bank_name" 
                          value="{{ auth()->user()->fisher->bank_name ?? old('bank_name') }}" 
                          placeholder="Bank Name">
                    <label for="bank_name">Bank Name</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="account_holder" name="account_holder" 
                          value="{{ auth()->user()->fisher->account_holder ?? old('account_holder') }}" 
                          placeholder="Account Holder Name">
                    <label for="account_holder">Account Holder Name</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control border-ocean-light" id="account_number" name="account_number" 
                          value="{{ auth()->user()->fisher->account_number ?? old('account_number') }}" 
                          placeholder="Account Number">
                    <label for="account_number">Account Number</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreed_terms" name="agreed_terms" value="1" 
                          {{ (auth()->user()->fisher && auth()->user()->fisher->agreed_terms) ? 'checked' : '' }} 
                          required>
                    <label class="form-check-label" for="agreed_terms">
                      I agree to the <a href="#" class="text-ocean-medium">terms and conditions</a>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>        
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-ocean me-sm-3 me-1">Save Profile</button>
            <button type="button" class="btn btn-outline-ocean" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add New Catch Modal -->
<div class="modal fade" id="addNewCatchModal" tabindex="-1" aria-labelledby="addNewCatchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-ocean-light border-ocean-light">
        <h5 class="modal-title text-ocean-deep" id="addNewCatchModalLabel">Add New Catch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-4 text-ocean-medium">Add your fresh catch to make it available to customers. Please provide accurate information.</p>
        <form method="POST" action="{{ route('catches.store') }}" id="addCatchForm" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <!-- Catch Name -->
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control border-ocean-light" id="name" name="name" 
                      placeholder="Name of catch (e.g. Fresh Tuna)" required>
                <label for="name">Name of Catch</label>
              </div>
            </div>
            
            <!-- Price Per Kg -->
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="number" class="form-control border-ocean-light" id="price_per_kg" name="price_per_kg" 
                      placeholder="Price Per Kg" step="0.01" min="0" required>
                <label for="price_per_kg">Price Per Kg (₱)</label>
              </div>
            </div>
            
            <!-- Stock Kg -->
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="number" class="form-control border-ocean-light" id="stock_kg" name="stock_kg" 
                      placeholder="Available Stock in Kg" step="0.1" min="0" required>
                <label for="stock_kg">Available Stock (kg)</label>
              </div>
            </div>
            
            <!-- Status -->
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <select class="form-control border-ocean-light" id="status" name="status" required>
                  <option value="active">Active</option>
                </select>
                <label for="status">Status</label>
              </div>
            </div>
            
            <!-- Catch Date -->
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="date" class="form-control border-ocean-light" id="catch_date" name="catch_date" 
                      value="{{ date('Y-m-d') }}" required>
                <label for="catch_date">Catch Date</label>
              </div>
            </div>
            
            <!-- Description -->
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control border-ocean-light" id="description" name="description" 
                          placeholder="Describe your catch in detail" 
                          style="height: 100px" required></textarea>
                <label for="description">Description</label>
                <small class="text-muted">Include details like how it was caught, what makes it special, etc.</small>
              </div>
            </div>
            
            <!-- Fish Image -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="image_path" class="form-label text-ocean-deep">Fish Image</label>
                <input type="file" class="form-control border-ocean-light" id="image_path" name="image_path" required>
                <small class="text-muted">Upload a clear image of your fresh catch. Recommended size: 800x600px.</small>
              </div>
            </div>
            
            <!-- Preview Image -->
            <div class="col-md-12 mb-3 d-none" id="imagePreviewContainer">
              <label class="form-label text-ocean-deep">Image Preview</label>
              <div class="border rounded p-2 text-center">
                <img id="imagePreview" src="#" alt="Fish Image Preview" style="max-height: 200px; max-width: 100%;">
              </div>
            </div>
          </div>
          
          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-ocean me-sm-3 me-1">
              <i class="bx bx-plus-circle me-1"></i> Add Listing
            </button>
            <button type="button" class="btn btn-outline-ocean" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="topCustomersModal" tabindex="-1" aria-labelledby="topCustomersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable"> <!-- scrollable for long content -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-ocean-deep" id="topCustomersModalLabel">All Top Customers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          @foreach ($topCustomers as $customer)
            <div class="col-md-6">
              <div class="card shadow-none customer-card h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-sm me-2 bg-ocean-light">
                      <span class="avatar-initial rounded-circle text-ocean-deep">
                        {{ strtoupper(substr($customer->consumer->full_name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $customer->consumer->full_name)[1] ?? '', 0, 1)) }}
                      </span>
                    </div>
                    <div>
                      <h6 class="mb-0 text-ocean-deep">{{ $customer->consumer->full_name }}</h6>
                      <small class="text-muted">Regular buyer</small>
                    </div>
                  </div>
                  <div class="mb-3 p-2 bg-light rounded-2">
                    <span class="fw-medium text-dark mb-1 d-block">Prefers</span>
                    @if(!empty($customer->preferred_fish_types))
                      @foreach(json_decode($customer->preferred_fish_types) as $fish)
                        <span class="badge bg-label-primary me-1">{{ $fish }}</span>
                      @endforeach
                    @else
                      <span class="text-muted">No preferences</span>
                    @endif
                  </div>
                  <p class="text-muted mb-3">
                    Orders: {{ $customer->orders_count }} | Total: ₱{{ number_format($customer->total_spent, 2) }}
                  </p>
                </div>
              </div>
            </div>
          @endforeach

          @if ($topCustomers->isEmpty())
            <p class="text-center text-muted">No top customers found yet.</p>
          @endif
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Edit  -->
<div class="modal fade" id="editCatchModal" tabindex="-1" aria-labelledby="editCatchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-ocean-light border-ocean-light">
        <h5 class="modal-title text-ocean-deep" id="editCatchModalLabel">Edit Catch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" id="editCatchForm" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" id="edit_id">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control border-ocean-light" id="edit_name" name="name" required>
                <label for="edit_name">Name of Catch</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="number" class="form-control border-ocean-light" id="edit_price_per_kg" name="price_per_kg" step="0.01" min="0" required>
                <label for="edit_price_per_kg">Price Per Kg (₱)</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="number" class="form-control border-ocean-light" id="edit_stock_kg" name="stock_kg" step="0.1" min="0" required>
                <label for="edit_stock_kg">Available Stock (kg)</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <select class="form-control border-ocean-light" id="edit_status" name="status" required>
                  <option value="active">Active</option>
                  <option value="sold_out">Sold Out</option>
                </select>
                <label for="edit_status">Status</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="date" class="form-control border-ocean-light" id="edit_catch_date" name="catch_date" required>
                <label for="edit_catch_date">Catch Date</label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control border-ocean-light" id="edit_description" name="description" style="height: 100px" required></textarea>
                <label for="edit_description">Description</label>
              </div>
            </div>

            <div class="col-md-12">
              <label for="edit_image_path" class="form-label text-ocean-deep">Fish Image (optional)</label>
              <input type="file" class="form-control border-ocean-light" id="edit_image_path" name="image_path">
              <small class="text-muted">Upload a new image only if you want to replace the existing one.</small>
            </div>

            <div class="col-md-12 mb-3 d-none" id="editImagePreviewContainer">
              <label class="form-label text-ocean-deep">Current Image Preview</label>
              <div class="border rounded p-2 text-center">
                <img id="editImagePreview" src="#" alt="Fish Image Preview" style="max-height: 200px; max-width: 100%;">
              </div>
            </div>
          </div>

          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-ocean me-sm-3 me-1">
              <i class="bx bx-save me-1"></i> Update Catch
            </button>
            <button type="button" class="btn btn-outline-ocean" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  const editCatchModal = document.getElementById('editCatchModal');
  editCatchModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const price = button.getAttribute('data-price');
    const stock = button.getAttribute('data-stock');
    const status = button.getAttribute('data-status');
    const date = button.getAttribute('data-date');
    const description = button.getAttribute('data-description');
    const imagePath = button.getAttribute('data-image');

    const form = document.getElementById('editCatchForm');
    form.action = `/catches/${id}`;

    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price_per_kg').value = price;
    document.getElementById('edit_stock_kg').value = stock;
    document.getElementById('edit_status').value = 'Active';
    document.getElementById('edit_catch_date').value = date;
    document.getElementById('edit_description').value = description;

    if (imagePath) {
      const preview = document.getElementById('editImagePreview');
      preview.src = `/${imagePath}`;
      document.getElementById('editImagePreviewContainer').classList.remove('d-none');
    } else {
      document.getElementById('editImagePreviewContainer').classList.add('d-none');
    }
  });
</script>

<!-- Initialize profile modal script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    const profileModal = document.getElementById('completeProfileModal');
    if (profileModal) {
      
      profileModal.addEventListener('shown.bs.modal', function() {
        if (typeof $.fn.select2 !== 'undefined') {
          $('.select2-container--default .select2-selection--multiple').css({
            'border-color': 'var(--ocean-light)',
            'border-radius': '8px'
          });
          
          $('.select2-container--default .select2-selection--single').css({
            'border-color': 'var(--ocean-light)',
            'border-radius': '8px'
          });
          
          $('.select2-container--default .select2-results__option--highlighted').css({
            'background-color': 'var(--ocean-medium)'
          });
        }
      });
    }
 
    if (typeof $.fn.select2 !== 'undefined') {
      
      $('.select2').select2({
        dropdownParent: $('#completeProfileModal'),
        theme: 'classic',
        templateResult: formatSelect2Option,
        templateSelection: formatSelect2Option
      });
      
      
      function formatSelect2Option(option) {
        if (!option.id) return option.text;
        return $('<span class="select2-option">').text(option.text);
      }
      
      
      @if(auth()->user()->fisher && auth()->user()->fisher->fish_types)
        try {
          const fishTypes = JSON.parse('{!! auth()->user()->fisher->fish_types !!}');
          $('#fish_types').val(fishTypes).trigger('change');
        } catch (e) {
          console.error('Error parsing fish types', e);
        }
      @endif
    }
    
    
    $('.nav-tabs .nav-link').on('click', function() {
      $('.nav-tabs .nav-link').removeClass('active-tab');
      $(this).addClass('active-tab');
    });
    
    
    $('.nav-tabs .nav-link.active').addClass('active-tab');
    
    
    const form = document.getElementById('completeProfileForm');
    if (form) {
      form.addEventListener('submit', function() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
      });
    }
  });
  
</script>
<script>
  const swiper = new Swiper('#swiper-today-listings', {
    slidesPerView: 'auto',
    spaceBetween: 16,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
</script>

@endsection