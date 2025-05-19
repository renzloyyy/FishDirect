@extends('layouts.contentNavbarLayout')

@section('title', 'Delivery FAQ')

@section('vendor-style')
<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}">
<!-- Import Inter or Lato font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('page-style')
<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
<style>
  :root {
    /* Ocean blues palette */
    --ocean-deep: #005f73;
    --ocean-medium: #0a9396;
    --ocean-light: #94d2bd;
    
    /* Natural neutrals */
    --sand-light: #e9d8a6;
    --sand-medium: #ee9b00;
    
    /* Coral accents */
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
  
  .card {
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0, 95, 115, 0.1);
    border: none;
  }
  
  .card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 95, 115, 0.1);
  }

  .faq-header-banner {
    background: linear-gradient(135deg, var(--ocean-medium) 0%, var(--ocean-deep) 100%);
    color: white;
    border-radius: 12px;
    padding: 2rem;
  }

  .faq-item {
    border-bottom: 1px solid rgba(0, 95, 115, 0.1);
    padding: 1.5rem 0;
  }

  .faq-item:last-child {
    border-bottom: none;
  }

  .faq-question {
    font-weight: 600;
    color: var(--ocean-deep);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
  }

  .faq-question i {
    margin-right: 0.75rem;
    color: var(--ocean-medium);
  }

  .faq-answer {
    padding-left: 2rem;
    color: #444;
  }

  .tooltip-info {
    color: var(--ocean-medium);
    cursor: pointer;
    margin-left: 0.5rem;
  }
</style>
@endsection

@section('vendor-script')
<!-- Vendor JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
@endsection

@section('content')
<div class="row">
  <!-- FAQ Header Banner -->
  <div class="col-12 mb-4">
    <div class="card faq-header-banner">
      <div class="d-flex align-items-center row">
        <div class="col-md-8">
          <h2 class="mb-3">Delivery FAQ</h2>
          <p class="mb-0">Find answers to commonly asked questions about our delivery service</p>
        </div>
        <div class="col-md-4 text-center text-md-end">
          <div class="pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/delivery.png') }}" height="140" alt="Delivery Illustration">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FAQ Content -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-ocean-deep">Frequently Asked Questions</h5>
        <button class="btn btn-sm btn-outline-ocean" data-bs-toggle="modal" data-bs-target="#contactSupportModal">Contact Support</button>
      </div>
      <div class="card-body">
        <!-- FAQ Item 1 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-map-pin"></i>
            Where do you deliver?
          </h5>
          <div class="faq-answer">
            <p>We currently deliver within Southern Leyte areas. Expansion to more areas is coming soon!</p>
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-time"></i>
            How long does delivery take?
          </h5>
          <div class="faq-answer">
            <ul>
              <li>Same-day delivery is available for orders placed before 12:00 noon.</li>
              <li>Orders placed after the cutoff will be delivered next day.</li>
            </ul>
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-money"></i>
            How much is the delivery fee?
          </h5>
          <div class="faq-answer">
            <p>Delivery fees depend on your location and order size. The exact fee will be shown at checkout before you confirm your order.</p>
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-package"></i>
            How is my fish kept fresh during delivery?
          </h5>
          <div class="faq-answer">
            <p>Your order is packed in insulated coolers or with ice packs to maintain optimal freshness until it reaches your doorstep.</p>
          </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-map"></i>
            Can I track my order?
          </h5>
          <div class="faq-answer">
            <p>Yes! You will receive a tracking link via SMS or email once your order is dispatched.</p>
          </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-home"></i>
            What if I'm not home during delivery?
          </h5>
          <div class="faq-answer">
            <p>You can assign someone to receive your order or request the delivery team to leave it in a safe location. Please note, we are not responsible for product quality after unattended drop-offs.</p>
          </div>
        </div>

        <!-- FAQ Item 7 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-x-circle"></i>
            Can I cancel or change my delivery?
          </h5>
          <div class="faq-answer">
            <p>Changes or cancellations are allowed up to 1 hour after placing your order. Please contact support immediately.</p>
          </div>
        </div>

        <!-- FAQ Item 8 -->
        <div class="faq-item">
          <h5 class="faq-question">
            <i class="bx bx-error-circle"></i>
            What should I do if my order is wrong or damaged?
          </h5>
          <div class="faq-answer">
            <p>Please contact customer support within 24 hours with photos of the issue. We will resolve it with a refund, replacement, or store credit.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Still Have Questions -->
  <div class="col-12 mt-4">
    <div class="card bg-ocean-light">
      <div class="card-body text-center p-4">
        <h4 class="text-ocean-deep mb-3">Still Have Questions?</h4>
        <p class="mb-4">Our support team is here to help you with any other questions you might have.</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-ocean" data-bs-toggle="modal" data-bs-target="#contactSupportModal">
            <i class="bx bx-support me-1"></i> Contact Support
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Support Modal -->
<div class="modal fade" id="contactSupportModal" tabindex="-1" aria-labelledby="contactSupportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-ocean-deep" id="contactSupportModalLabel">Contact Support</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="support-name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="support-name" placeholder="Enter your name">
          </div>
          <div class="mb-3">
            <label for="support-email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="support-email" placeholder="Enter your email">
          </div>
          <div class="mb-3">
            <label for="support-subject" class="form-label">Subject</label>
            <select class="form-select" id="support-subject">
              <option value="">Select a subject</option>
              <option value="delivery">Delivery Issue</option>
              <option value="order">Order Problem</option>
              <option value="payment">Payment Question</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="support-message" class="form-label">Message</label>
            <textarea class="form-control" id="support-message" rows="4" placeholder="Describe your issue or question"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-ocean">Send Message</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
</script>
@endsection