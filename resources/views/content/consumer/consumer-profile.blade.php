@extends('layouts.contentNavbarLayout') 

@section('title', 'Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Notifications -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <h4 class="fw-bold py-3 mb-4">
    User Profile
    <a href="{{ route('profile.edit') }}" class="btn btn-primary float-end">
      <i class="bx bx-edit-alt me-1"></i> Edit Profile
    </a>
  </h4>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body text-center">
          @if($profile && $profile->profile_photo)
            <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="Profile Photo" class="rounded-circle mb-3" width="150" height="150">
          @else
            <img src="{{ asset('assets/img/illustrations/default.png') }}" alt="Default Profile" class="rounded-circle mb-3" width="150" height="150">
          @endif

          <h5 class="mb-0">{{ $profile ? $profile->full_name : $user->email }}</h5>
          <small class="text-muted">{{ $user->role }}</small>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5>Account Information</h5>
        </div>
        <div class="card-body">
          <p><strong>Email:</strong> {{ $user->email }}</p>
          <p><strong>Role:</strong> {{ $user->role }}</p>
          <p><strong>Created At:</strong> {{ $user->created_at->format('M d, Y') }}</p>
          <p><strong>Updated At:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
        </div>
      </div>

      @if($user->role === 'Consumer' && $profile)
      <div class="card mb-4">
        <div class="card-header">
          <h5>Consumer Details</h5>
        </div>
        <div class="card-body">
          <p><strong>Full Name:</strong> {{ $profile->full_name }}</p>
          <p><strong>Phone:</strong> {{ $profile->phone ?? 'N/A' }}</p>
          <p><strong>Address:</strong> 
            {{ $profile->street }}, {{ $profile->barangay }}, {{ $profile->city }}, {{ $profile->province }}, {{ $profile->zip_code }}
          </p>
          <p><strong>Delivery Instructions:</strong> {{ $profile->delivery_instructions ?? 'None' }}</p>
          <p><strong>Preferred Fish Types:</strong> 
            @if($profile->preferred_fish_types)
              @foreach(json_decode($profile->preferred_fish_types) as $fishType)
                <span class="badge bg-primary">{{ $fishType }}</span>
              @endforeach
            @else
              N/A
            @endif
          </p>
          <p><strong>Dietary Restrictions:</strong> {{ $profile->dietary_restrictions ?? 'None' }}</p>
          <p><strong>Preferred Payment Method:</strong> {{ $profile->preferred_payment_method ?? 'N/A' }}</p>
        </div>
      </div>
      @endif

      @if($user->role === 'Fisher' && $profile)
      <div class="card mb-4">
        <div class="card-header">
          <h5>Fisher Details</h5>
        </div>
        <div class="card-body">
          <p><strong>Full Name:</strong> {{ $profile->full_name }}</p>
          <p><strong>Phone:</strong> {{ $profile->phone ?? 'N/A' }}</p>
          <p><strong>Fishing License:</strong> {{ $profile->fishing_license ?? 'N/A' }}</p>
          <p><strong>Fisher Type:</strong> {{ $profile->fisher_type ?? 'N/A' }}</p>
          <p><strong>Boat Name:</strong> {{ $profile->boat_name ?? 'N/A' }}</p>
          <p><strong>Fishing Area:</strong> {{ $profile->fishing_area ?? 'N/A' }}</p>
          <p><strong>Experience (years):</strong> {{ $profile->fishing_experience_years ?? 'N/A' }}</p>
          <p><strong>Display Name:</strong> {{ $profile->display_name ?? 'N/A' }}</p>
          <p><strong>Bio:</strong> {{ $profile->bio ?? 'N/A' }}</p>
          <p><strong>Fish Types:</strong>
            @if($profile->fish_types)
              @foreach(json_decode($profile->fish_types) as $fishType)
                <span class="badge bg-info">{{ $fishType }}</span>
              @endforeach
            @else
              N/A
            @endif
          </p>
          <p><strong>Quantity per Catch:</strong> {{ $profile->quantity_per_catch ?? 'N/A' }}</p>
          <p><strong>Sustainable Method:</strong> {{ $profile->sustainable_method ?? 'N/A' }}</p>
          <p><strong>Payout Method:</strong> {{ $profile->payout_method ?? 'N/A' }}</p>
          <p><strong>Bank Name:</strong> {{ $profile->bank_name ?? 'N/A' }}</p>
          <p><strong>Account Holder:</strong> {{ $profile->account_holder ?? 'N/A' }}</p>
          <p><strong>Account Number:</strong> {{ $profile->account_number ?? 'N/A' }}</p>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>
@endsection