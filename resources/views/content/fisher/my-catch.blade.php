@extends('layouts.contentNavbarLayout')
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

  .filter-dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .badge.rounded-pill {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
  }

  .bg-primary-subtle {
    background-color: rgba(10, 147, 150, 0.15) !important;
  }

  .text-primary {
    color: var(--ocean-medium) !important;
  }

  .btn-link {
    text-decoration: none;
  }

  .btn-link:hover {
    text-decoration: underline;
  }

  .empty-state {
    padding: 2rem;
  }

  .empty-state i {
    opacity: 0.5;
  }
</style>
@endsection

@section('vendor-script')
<!-- Vendor JS -->
<script src="

<script>

    var successMessage = "{{ session('success') }}";
    var errorMessage = "{{ session('error') }}";
</script>

<!-- Include your custom script file -->
<script src="{{ asset('assets/js/custom-scripts.js') }}"></script>

@endsection

@section('content')
<div class="container-xxl py-4">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card modern-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0 text-primary-dark">My Catch</h5>
            <p class="text-muted mb-0 small">Manage and track your active catches</p>
          </div>
          <div class="d-flex gap-2">
            <!-- Filter Dropdown -->
            <div class="dropdown">
              <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-filter me-1"></i> Filter
              </button>
              <div class="dropdown-menu dropdown-menu-end p-3 filter-dropdown-menu" style="min-width: 280px;">
                <h6 class="dropdown-header px-0 d-flex justify-content-between align-items-center">
                  <span>Filter Catches</span>
                  <a href="{{ url()->current() }}" class="text-muted small">Reset</a>
                </h6>
                <form action="{{ route('fisherman.my-catch.filter') }}" method="GET" id="catchFilterForm" onsubmit="return true;">
                  <!-- Fish Type Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Fish Type</label>
                    <select class="form-select form-select-sm" name="fish_type">
                      <option value="">All Fish Types</option>
                      @foreach(['Tuna', 'Salmon', 'Tilapia', 'Bangus', 'Galunggong', 'Maya-maya', 'Other'] as $type)
                        <option value="{{ $type }}" {{ request('fish_type') === $type ? 'selected' : '' }}>
                          {{ $type }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Date Range Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Catch Date Range</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input type="date" class="form-control form-control-sm" name="date_from" placeholder="From" value="{{ request('date_from') }}">
                      </div>
                      <div class="col-6">
                        <input type="date" class="form-control form-control-sm" name="date_to" placeholder="To" value="{{ request('date_to') }}">
                      </div>
                    </div>
                  </div>

                  <!-- Price Range Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Price Range (₱/kg)</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="price_min" placeholder="Min" value="{{ request('price_min') }}" step="0.01">
                      </div>
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="price_max" placeholder="Max" value="{{ request('price_max') }}" step="0.01">
                      </div>
                    </div>
                  </div>

                  <!-- Stock Range Filter -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Stock Range (kg)</label>
                    <div class="row g-2">
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="stock_min" placeholder="Min" value="{{ request('stock_min') }}" step="0.1">
                      </div>
                      <div class="col-6">
                        <input type="number" class="form-control form-control-sm" name="stock_max" placeholder="Max" value="{{ request('stock_max') }}" step="0.1">
                      </div>
                    </div>
                  </div>

                  <!-- Search by fish name -->
                  <div class="mb-3">
                    <label class="form-label small text-muted">Search</label>
                    <input type="text" class="form-control form-control-sm" name="search" placeholder="Fish name or description" value="{{ request('search') }}">
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="bx bx-filter-alt me-1"></i> Apply Filters
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Export button with current filters appended -->
            <a href="{{ route('fisherman.my-catch.export', request()->all()) }}" class="btn btn-outline-primary btn-sm">
              <i class="bx bx-export"></i> Export List
            </a>
          </div>
        </div>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['fish_type', 'date_from', 'date_to', 'price_min', 'price_max', 'stock_min', 'stock_max', 'search']))
        <div class="card-body py-2 px-4 border-bottom">
          <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="text-muted small me-2">Active filters:</span>
            <!-- ... Your active filter badges here, unchanged ... -->
            <!-- Same as your original code for badges -->
            @if(request()->has('search') && !empty(request('search')))
              <span class="badge bg-primary-subtle text-primary rounded-pill d-inline-flex align-items-center">
                <i class="bx bx-search me-1"></i>
                "{{ request('search') }}"
                <a href="{{ request()->url() }}?{{ http_build_query(array_merge(request()->except('search'), ['page' => 1])) }}" 
                  class="ms-1 text-primary" style="line-height: 0;">&times;</a>
              </span>
            @endif
            <!-- Repeat badges for all filters... -->

            <a href="{{ url()->current() }}" class="ms-auto btn btn-sm btn-link text-danger">
              <i class="bx bx-x-circle me-1"></i>Clear All
            </a>
          </div>
        </div>
        @endif

        @if($activeListings->isEmpty())
          <div class="card-body">
            <div class="text-center py-5">
              <div class="empty-state">
                <i class="bx bx-fish display-4 text-muted mb-3"></i>
                <h6 class="text-muted">No catches found</h6>
                <p class="text-muted small">
                  @if(request()->hasAny(['fish_type', 'date_from', 'date_to', 'price_min', 'price_max', 'stock_min', 'stock_max', 'search']))
                    Try adjusting your filters or <a href="{{ url()->current() }}">view all catches</a>.
                  @else
                    Your catches will appear here once you start listing them.
                  @endif
                </p>
                @if(!request()->hasAny(['fish_type', 'date_from', 'date_to', 'price_min', 'price_max', 'stock_min', 'stock_max', 'search']))
                  <a href="" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Add New Catch
                  </a>
                @endif
              </div>
            </div>
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle modern-table">
              <thead>
                <tr>
                  <th class="text-primary-medium fw-semibold">IMAGE</th>
                  <th class="text-primary-medium fw-semibold">NAME</th>
                  <th class="text-primary-medium fw-semibold">DESCRIPTION</th>
                  <th class="text-primary-medium fw-semibold">PRICE / KG</th>
                  <th class="text-primary-medium fw-semibold">STOCK (KG)</th>
                  <th class="text-primary-medium fw-semibold">CATCH DATE</th>
                  <th class="text-center text-primary-medium fw-semibold">ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @foreach($activeListings as $product)
              <tr>
                <td style="width: 100px;">
                  <img src="{{ asset($product->image_path ?? 'images/default-fish.jpg') }}" alt="{{ $product->name }}" class="rounded" style="height: 60px; object-fit: cover; width: 100px;">
                </td>
                <td class="text-ocean-medium fw-semibold">{{ $product->name }}</td>
                <td class="text-muted" style="max-width: 300px;">
                  {{ Str::limit($product->description, 80) ?? 'No description provided.' }}
                </td>
                <td>₱{{ number_format($product->price_per_kg, 2) }}</td>
                <td>{{ $product->stock_kg ?? 0 }}</td>
                <td class="text-muted">{{ $product->catch_date ? \Carbon\Carbon::parse($product->catch_date)->format('M d, Y') : 'N/A' }}</td>                                  
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-ocean btn-sm edit-catch-btn" data-bs-toggle="modal" data-bs-target="#editCatchModal"
                      data-id="{{ $product->id }}"
                      data-name="{{ $product->name }}"
                      data-price="{{ $product->price_per_kg }}"
                      data-stock="{{ $product->stock_kg }}"
                      data-fish-type="{{ $product->fish_type }}"
                      data-catch-date="{{ $product->catch_date }}"
                      data-description="{{ $product->description }}"
                      data-status="{{ $product->status }}"
                      data-image-path="{{ asset($product->image_path ?? 'images/default-fish.jpg') }}">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </button>
                    <form id="deleteForm_{{ $product->id }}" action="{{ route('my-catch.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-coral btn-sm" onclick="confirmDelete('deleteForm_{{ $product->id }}')">
                      <i class="bx bx-trash me-1"></i> Delete
                    </button>
                  </form>
                  </div>
                </td>
              </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if(method_exists($activeListings, 'hasPages') && $activeListings->hasPages())
          <div class="card-footer d-flex justify-content-end bg-light">
            {{ $activeListings->links() }}
          </div>
          @endif
        @endif
      </div>
    </div>
  </div>
</div>
<!-- Updated Edit Modal with correct form fields -->
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
          <input type="hidden" id="edit_id" name="id">
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
                  <option value="Active">Active</option>
                  <option value="SoldOut">Sold Out</option>
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
 
document.addEventListener('DOMContentLoaded', function() {
  
  initializeSweetAlert();
  
  
  initializeEditModal();
});


function initializeSweetAlert() {
  
  if (typeof successMessage !== 'undefined' && successMessage) {
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: successMessage,
      timer: 3000,
      showConfirmButton: false
    });
  }
  
  
  if (typeof errorMessage !== 'undefined' && errorMessage) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: errorMessage,
      timer: 3000,
      showConfirmButton: true
    });
  }
}


function initializeEditModal() {
  const editCatchModal = document.getElementById('editCatchModal');
  if (editCatchModal) {
    editCatchModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      if (!button) return;

      
      const id = button.getAttribute('data-id');
      const name = button.getAttribute('data-name');
      const price = button.getAttribute('data-price');
      const stock = button.getAttribute('data-stock');
      const status = button.getAttribute('data-status') || 'Active';
      const catchDate = button.getAttribute('data-catch-date');
      const description = button.getAttribute('data-description');
      const imagePath = button.getAttribute('data-image-path');

      
      const form = document.getElementById('editCatchForm');
      form.action = `/fisherman/my-catch/${id}`;

      
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_name').value = name;
      document.getElementById('edit_price_per_kg').value = price;
      document.getElementById('edit_stock_kg').value = stock;
      document.getElementById('edit_status').value = status;
      document.getElementById('edit_catch_date').value = catchDate;
      document.getElementById('edit_description').value = description || '';

      
      if (imagePath) {
        const preview = document.getElementById('editImagePreview');
        preview.src = imagePath;
        document.getElementById('editImagePreviewContainer').classList.remove('d-none');
      } else {
        document.getElementById('editImagePreviewContainer').classList.add('d-none');
      }
    });
  }
}


function confirmDelete(formId) {
  event.preventDefault(); 

  Swal.fire({
    title: 'Are you sure?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e3342f', 
    cancelButtonColor: '#6c757d',  
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    reverseButtons: true,
    focusCancel: true
  }).then((result) => {
    if (result.isConfirmed) {
      
      Swal.fire({
        title: 'Deleting...',
        text: 'Please wait while we remove the item.',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      
      setTimeout(() => {
        document.getElementById(formId).submit();
      }, 800);
    }
  });
}

</script>

@endsection
