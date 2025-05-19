@extends('layouts.blankLayout')

@section('title', 'Complete Profile - Pages')

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Complete Profile -->
            <div class="card p-2">
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ url('/') }}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
                        <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                    </a>
                </div>

                <div class="card-body mt-2">
                    <h4 class="mb-2">Complete Your Profile, {{ auth()->user()->email }} 👋</h4>
                    <p class="mb-4">Please fill in the remaining information to complete your profile.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('complete-profile.update') }}">
                        @csrf

                        <!-- Profile Completion Fields -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" required>
                            <label for="full_name">Full Name</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                            <label for="phone">Phone</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="street" name="street" placeholder="Street">
                            <label for="street">Street</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay">
                            <label for="barangay">Barangay</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="city" name="city" placeholder="City">
                            <label for="city">City</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="province" name="province" placeholder="Province">
                            <label for="province">Province</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code">
                            <label for="zip_code">Zip Code</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="dietary_restrictions" name="dietary_restrictions" placeholder="Dietary Restrictions">
                            <label for="dietary_restrictions">Dietary Restrictions</label>
                        </div>
                        
                        <div class="form-floating form-floating-outline mb-3">
                            <textarea class="form-control" id="delivery_instructions" name="delivery_instructions" placeholder="Delivery Instructions"></textarea>
                            <label for="delivery_instructions">Delivery Instructions</label>
                        </div>

                        <!-- Preferences -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-control" id="preferred_payment_method" name="preferred_payment_method" required>
                                <option value="Card">Card</option>
                                <option value="e-Wallet">e-Wallet</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                                <option value="In-App Wallet">In-App Wallet</option>
                            </select>
                            <label for="preferred_payment_method">Preferred Payment Method</label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreed_terms" name="agreed_terms" value="1" required>
                            <label class="form-check-label" for="agreed_terms">
                                I agree to the <a href="#">terms and conditions</a>
                            </label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary d-grid w-100">Complete Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Complete Profile -->
        </div>
    </div>
</div>
@endsection
