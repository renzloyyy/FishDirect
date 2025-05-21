
@extends('layouts.contentNavbarLayout')

@section('title', 'My Earnings')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datepicker/daterangepicker.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datepicker/daterangepicker.js')}}"></script>
@endsection

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 breadcrumb-wrapper mb-4">
    <span class="text-muted fw-light">Earnings /</span> Overview
  </h4>

  <!-- Earnings Summary Cards -->
  <div class="row">
    <div class="col-lg-4 col-md-12">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-wallet"></i></span>
            </div>
          </div>
          <span class="d-block mb-1">Total Earnings</span>
          <h3 class="card-title text-nowrap mb-2">₱{{ number_format($totalEarnings, 2) }}</h3>
          <small class="text-muted">Lifetime earnings from all sales</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-hourglass"></i></span>
            </div>
          </div>
          <span class="d-block mb-1">Pending Payout</span>
          <h3 class="card-title text-nowrap mb-2">₱{{ number_format($pendingEarnings, 2) }}</h3>
          <small class="text-muted">Earnings awaiting payment</small>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-circle"></i></span>
            </div>
          </div>
          <span class="d-block mb-1">Paid Out</span>
          <h3 class="card-title text-nowrap mb-2">₱{{ number_format($completedEarnings, 2) }}</h3>
          <small class="text-muted">Successfully transferred earnings</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Earnings Chart -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Monthly Earnings</h5>
        </div>
        <div class="card-body">
          <div id="monthlyEarningsChart"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bank Account Info -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Payout Information</h5>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPayoutInfoModal">Update</button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p class="mb-1 text-muted">Payout Method</p>
              <p class="fw-semibold" id="display-payout-method">{{ auth()->user()->fisher->payout_method ?? 'Not set' }}</p>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted">Bank Name</p>
              <p class="fw-semibold" id="display-bank-name">{{ auth()->user()->fisher->bank_name ?? 'Not set' }}</p>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted">Account Holder</p>
              <p class="fw-semibold" id="display-account-holder">{{ auth()->user()->fisher->account_holder ?? 'Not set' }}</p>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted">Account Number</p>
              <p class="fw-semibold" id="display-account-number">
                @if(auth()->user()->fisher->account_number)
                  •••• •••• •••• {{ substr(auth()->user()->fisher->account_number, -4) }}
                @else
                  Not set
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings Filter -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('earnings.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
              <label class="form-label">From Date</label>
              <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">To Date</label>
              <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select class="form-select" name="status">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Sort By</label>
              <select class="form-select" name="sort">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Amount</option>
                <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Amount</option>
              </select>
            </div>
            <div class="col-12">
              <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('earnings.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-outline-secondary">
                  <i class="bx bxs-file-pdf me-1"></i> Export PDF
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings Table -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <h5 class="card-header">Earnings History</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity (kg)</th>
                <th>Price (₱/kg)</th>
                <th>Total (₱)</th>
                <th>Platform Fee (₱)</th>
                <th>Net Earning (₱)</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse($earnings as $earning)
              <tr>
                <td>
                  <a href="#" class="text-body">#{{ $earning->order_id }}</a>
                </td>
                <td>{{ $earning->product_name }}</td>
                <td>{{ number_format($earning->quantity_kg, 2) }}</td>
                <td>₱{{ number_format($earning->price_per_kg, 2) }}</td>
                <td>₱{{ number_format($earning->total_earning, 2) }}</td>
                <td>₱{{ number_format($earning->platform_fee, 2) }}</td>
                <td><strong>₱{{ number_format($earning->net_earning, 2) }}</strong></td>
                <td>
                  @if($earning->payout_status == 'pending')
                  <span class="badge bg-label-warning">Pending</span>
                  @elseif($earning->payout_status == 'processing')
                  <span class="badge bg-label-info">Processing</span>
                  @elseif($earning->payout_status == 'completed')
                  <span class="badge bg-label-success">Completed</span>
                  @else
                  <span class="badge bg-label-danger">Failed</span>
                  @endif
                </td>
                <td>{{ $earning->created_at->format('M d, Y') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center py-4">No earnings found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
          {{ $earnings->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Payout Information Edit Modal -->
<div class="modal fade" id="editPayoutInfoModal" tabindex="-1" aria-labelledby="editPayoutInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPayoutInfoModalLabel">Edit Payout Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="payoutInfoForm" action="{{ route('fisher.update-payout-info') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <label for="payout_method" class="form-label">Payout Method <span class="text-danger">*</span></label>
            <select class="form-select" id="payout_method" name="payout_method" required>
              <option value="">Select Payout Method</option>
              <option value="Bank Transfer" {{ auth()->user()->fisher->payout_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
              <option value="GCash" {{ auth()->user()->fisher->payout_method == 'GCash' ? 'selected' : '' }}>GCash</option>
              <option value="Paymaya" {{ auth()->user()->fisher->payout_method == 'Paymaya' ? 'selected' : '' }}>Paymaya</option>
              <option value="Cash" {{ auth()->user()->fisher->payout_method == 'Cash' ? 'selected' : '' }}>Cash</option>
            </select>
            <div class="invalid-feedback">Please select a payout method.</div>
          </div>
          
          <div class="bank-details" id="bankDetailsSection">
            <div class="mb-3">
              <label for="bank_name" class="form-label">Bank Name <span class="text-danger bank-required">*</span></label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ auth()->user()->fisher->bank_name ?? '' }}">
              <div class="invalid-feedback">Please enter your bank name.</div>
            </div>
            
            <div class="mb-3">
              <label for="account_holder" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="account_holder" name="account_holder" value="{{ auth()->user()->fisher->account_holder ?? '' }}" required>
              <div class="invalid-feedback">Please enter the account holder name.</div>
            </div>
            
            <div class="mb-3">
              <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="account_number" name="account_number" value="{{ auth()->user()->fisher->account_number ?? '' }}" required>
              <div class="invalid-feedback">Please enter your account number.</div>
            </div>
          </div>
          
          <div class="alert alert-info">
            <i class="bx bx-info-circle me-1"></i>
            Your payout information is securely stored and will be used for all future payouts.
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="savePayoutInfo">Save Changes</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  
  const monthlyData = @json($monthlyEarnings);
  
  
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const chartData = [];
  
  
  const currentYear = new Date().getFullYear();
  let yearData = {};
  
  
  for (let i = 0; i < 12; i++) {
    yearData[months[i]] = 0;
  }
  
  
  monthlyData.forEach(item => {
    const monthIndex = parseInt(item.month) - 1;
    yearData[months[monthIndex]] = parseFloat(item.total);
  });
  
  
  const seriesData = Object.values(yearData);
  const categories = Object.keys(yearData);
  
  
  const chartOptions = {
    series: [{
      name: 'Net Earnings',
      data: seriesData
    }],
    chart: {
      height: 350,
      type: 'bar',
    },
    plotOptions: {
      bar: {
        borderRadius: 10,
        columnWidth: '50%',
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: 2
    },
    grid: {
      row: {
        colors: ['#fff', '#f2f2f2']
      }
    },
    xaxis: {
      categories: categories,
      position: 'bottom',
      labels: {
        rotateAlways: false,
      }
    },
    yaxis: {
      title: {
        text: 'Earnings (₱)'
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'light',
        type: "horizontal",
        shadeIntensity: 0.25,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [50, 0, 100]
      },
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return "₱" + val.toFixed(2)
        }
      }
    }
  };

  const earningsChart = new ApexCharts(document.querySelector("#monthlyEarningsChart"), chartOptions);
  earningsChart.render();

  
  const payoutMethodSelect = document.getElementById('payout_method');
  const bankDetailsSection = document.getElementById('bankDetailsSection');
  const bankNameInput = document.getElementById('bank_name');
  const saveButton = document.getElementById('savePayoutInfo');
  const form = document.getElementById('payoutInfoForm');

  
  function toggleBankDetails() {
    if (payoutMethodSelect.value === 'Bank Transfer') {
      bankDetailsSection.style.display = 'block';
      bankNameInput.setAttribute('required', 'required');
      document.querySelectorAll('.bank-required').forEach(el => el.style.display = 'inline');
    } else if (payoutMethodSelect.value === 'GCash' || payoutMethodSelect.value === 'Paymaya') {
      bankDetailsSection.style.display = 'block';
      bankNameInput.removeAttribute('required');
      document.querySelectorAll('.bank-required').forEach(el => el.style.display = 'none');
    } else {
      bankDetailsSection.style.display = 'none';
      bankNameInput.removeAttribute('required');
    }
  }

  toggleBankDetails();
  payoutMethodSelect.addEventListener('change', toggleBankDetails);

  
  function clearValidation() {
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
  }

  
  function validateForm() {
    clearValidation();
    let valid = true;
    
    if (!payoutMethodSelect.value) {
      payoutMethodSelect.classList.add('is-invalid');
      valid = false;
    }
    
    if (payoutMethodSelect.value === 'Bank Transfer' && !bankNameInput.value.trim()) {
      bankNameInput.classList.add('is-invalid');
      valid = false;
    }
    
    
    const accountHolder = document.getElementById('account_holder');
    const accountNumber = document.getElementById('account_number');
    
    if (!accountHolder.value.trim()) {
      accountHolder.classList.add('is-invalid');
      valid = false;
    }
    
    if (!accountNumber.value.trim()) {
      accountNumber.classList.add('is-invalid');
      valid = false;
    }
    
    return valid;
  }

  
  saveButton.addEventListener('click', function() {
    if (!validateForm()) {
      return;
    }

    
    saveButton.disabled = true;
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`;

    
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData,
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        
        const modalEl = document.getElementById('editPayoutInfoModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();

        const payoutMethod = document.getElementById('display-payout-method');
        const bankName = document.getElementById('display-bank-name');
        const accountHolder = document.getElementById('display-account-holder');
        const accountNumber = document.getElementById('display-account-number');
        
        payoutMethod.textContent = payoutMethodSelect.value || 'Not set';
        bankName.textContent = bankNameInput.value || 'Not set';
        accountHolder.textContent = document.getElementById('account_holder').value || 'Not set';
        
        const accNum = document.getElementById('account_number').value;
        if (accNum) {
          accountNumber.textContent = '•••• •••• •••• ' + accNum.slice(-4);
        } else {
          accountNumber.textContent = 'Not set';
        }

        alert('Payout information updated successfully!');
      } else {
        alert(data.message || 'Failed to update payout information.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while updating payout information.');
    })
    .finally(() => {
      saveButton.disabled = false;
      saveButton.innerHTML = originalText;
    });
  });
});
</script>
@endsection
