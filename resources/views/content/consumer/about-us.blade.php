@extends('layouts.contentNavbarLayout')

@section('title', 'About Us')

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

  .about-header-banner {
    background: linear-gradient(135deg, var(--ocean-medium) 0%, var(--ocean-deep) 100%);
    color: white;
    border-radius: 12px;
    padding: 2rem;
  }

  .team-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 95, 115, 0.15);
  }

  .team-member-img {
  object-fit: contain;
  background-color: #f8f8f8; /* Optional: gives a background */
}

  .team-card:hover .team-member-img {
    transform: scale(1.02);
  }

  .team-member-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .team-member-name {
    color: var(--ocean-deep);
    font-weight: 600;
    margin-bottom: 0.25rem;
  }

  .team-member-role {
    color: var(--ocean-medium);
    font-size: 0.9rem;
    margin-bottom: 1rem;
  }

  .team-member-bio {
    color: #444;
    font-size: 0.95rem;
    line-height: 1.6;
  }

  .social-links {
    margin-top: 1.25rem;
  }

  .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: var(--ocean-light);
    color: var(--ocean-deep);
    margin-right: 0.5rem;
    transition: all 0.3s ease;
  }

  .social-icon:hover {
    background-color: var(--ocean-medium);
    color: white;
    transform: translateY(-2px);
  }
  
  .mission-vision-card {
    height: 100%;
  }
  
  .mission-vision-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--ocean-medium);
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
  <!-- About Header Banner -->
  <div class="col-12 mb-4">
    <div class="card about-header-banner">
      <div class="d-flex align-items-center row">
        <div class="col-md-8">
          <h2 class="mb-3">About Us</h2>
          <p class="mb-0">We connect local fishers directly with consumers, ensuring fresher seafood and fair prices for everyone in the community.</p>
        </div>
        <div class="col-md-4 text-center text-md-end">
          <div class="pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/logo.png') }}" height="140" alt="Fish Market Illustration">
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Mission & Vision -->
  <div class="col-12 mb-4">
    <div class="row">
      <!-- Mission Card -->
      <div class="col-md-6 mb-4 mb-md-0">
        <div class="card mission-vision-card">
          <div class="card-body text-center p-4">
            <i class="bx bx-target-lock mission-vision-icon"></i>
            <h4 class="text-ocean-deep mb-3">Our Mission</h4>
            <p>To create a sustainable marketplace that empowers local fishers while delivering the freshest seafood directly to consumers, cutting out unnecessary middlemen and reducing waste in the supply chain.</p>
          </div>
        </div>
      </div>
      
      <!-- Vision Card -->
      <div class="col-md-6">
        <div class="card mission-vision-card">
          <div class="card-body text-center p-4">
            <i class="bx bx-bulb mission-vision-icon"></i>
            <h4 class="text-ocean-deep mb-3">Our Vision</h4>
            <p>To revolutionize the seafood industry in Southern Leyte by creating a community-focused ecosystem where sustainable fishing practices thrive and consumers have access to the highest quality, locally-caught seafood.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Our Story -->
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0 text-ocean-deep">Our Story</h5>
      </div>
      <div class="card-body">
        <p>Founded in 2025 by three friends from Southern Leyte State University - Tomas Oppus, our platform was born from a desire to support local fishing communities while providing consumers with access to the freshest catch possible.</p>
        
        <p>Growing up in Southern Leyte's coastal towns, we witnessed firsthand the challenges local fishers faced: fluctuating prices, limited market access, and unfair trade practices. Meanwhile, consumers often received seafood that had changed hands multiple times, increasing costs and reducing freshness.</p>
        
        <p>As technology students, we saw an opportunity to leverage our skills to create positive change. We developed a platform that connects fishers directly with consumers, eliminating unnecessary middlemen and ensuring both parties benefit from the exchange.</p>
        
        <p>Today, our platform supports over 50 fishing families across Southern Leyte and serves hundreds of customers, with plans to expand throughout the region and beyond.</p>
      </div>
    </div>
  </div>
  
  <!-- Meet Our Team -->
  <div class="col-12 mb-4">
    <h4 class="text-ocean-deep mb-3">Meet Our Team</h4>
    <div class="row">
      <!-- Team Member 1 -->
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="card team-card">
          <img src="{{ asset('assets/img/illustrations/member1.png') }}" class="team-member-img" alt="Engelbert R. Abordo">
          <div class="team-member-info">
            <h5 class="team-member-name">Engelbert R. Abordo</h5>
            <p class="team-member-role">Co-Founder & CEO</p>
            <p class="team-member-bio">A native of Padre Burgos, Southern Leyte, Engelbert combines his background in business administration with his deep connections to local fishing communities. His leadership guides our vision and ensures our platform serves both fishers and consumers effectively.</p>
            <div class="social-links">
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/facebook.png" alt="Facebook" style="width: 24px; height: 24px;">
            </a>
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/instagram.png" alt="Instragram" style="width: 24px; height: 24px;">
            </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 2 -->
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="card team-card">
          <img src="{{ asset('assets/img/illustrations/member2.jpg') }}" class="team-member-img" alt="Mary Grace T. Jacobe">
          <div class="team-member-info">
            <h5 class="team-member-name">Mary Grace T. Jacobe</h5>
            <p class="team-member-role">Co-Founder & CTO</p>
            <p class="team-member-bio">With her expertise in information technology and passion for sustainable development, Mary Grace leads our technical operations. She developed our mobile application and website interface to ensure accessibility for all users across Southern Leyte.</p>
            <div class="social-links">
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/facebook.png" alt="Facebook" style="width: 24px; height: 24px;">
            </a>
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/instagram.png" alt="Instragram" style="width: 24px; height: 24px;">
            </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Team Member 3 -->
      <div class="col-md-4">
        <div class="card team-card">
          <img src="{{ asset('assets/img/illustrations/member3.png') }}" class="team-member-img" alt="Aiza P. Membrano">
          <div class="team-member-info">
            <h5 class="team-member-name">Aiza P. Membrano</h5>
            <p class="team-member-role">Co-Founder & COO</p>
            <p class="team-member-bio">Aiza's background in logistics and community organizing makes her the perfect bridge between our platform and local communities. She works directly with fishing families to ensure smooth operations and maintains our quality standards.</p>
            <div class="social-links">
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/facebook.png" alt="Facebook" style="width: 24px; height: 24px;">
            </a>
            <a href="#" class="social-icon">
                <img src="assets/img/icons/brands/instagram.png" alt="Instragram" style="width: 24px; height: 24px;">
            </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Our Values -->
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0 text-ocean-deep">Our Values</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 mb-4 mb-md-0">
            <div class="text-center">
              <i class="bx bx-water text-ocean-medium" style="font-size: 3rem;"></i>
              <h5 class="mt-3 mb-2">Sustainability</h5>
              <p>We promote responsible fishing practices that protect marine ecosystems for future generations.</p>
            </div>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <div class="text-center">
              <i class="bx bx-group text-ocean-medium" style="font-size: 3rem;"></i>
              <h5 class="mt-3 mb-2">Community</h5>
              <p>We believe in building strong connections between fishers, consumers, and local communities.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="text-center">
              <i class="bx bx-check-shield text-ocean-medium" style="font-size: 3rem;"></i>
              <h5 class="mt-3 mb-2">Transparency</h5>
              <p>We provide clear information about where your seafood comes from and how it was caught.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Contact Us -->
  <div class="col-12">
    <div class="card bg-ocean-light">
      <div class="card-body text-center p-4">
        <h4 class="text-ocean-deep mb-3">Get In Touch</h4>
        <p class="mb-4">Have questions about our platform? Want to learn more about how we work? We'd love to hear from you!</p>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-ocean" data-bs-toggle="modal" data-bs-target="#contactModal">
            <i class="bx bx-envelope me-1"></i> Contact Us
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-ocean-deep" id="contactModalLabel">Contact Us</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="contact-name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="contact-name" placeholder="Enter your name">
          </div>
          <div class="mb-3">
            <label for="contact-email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="contact-email" placeholder="Enter your email">
          </div>
          <div class="mb-3">
            <label for="contact-subject" class="form-label">Subject</label>
            <select class="form-select" id="contact-subject">
              <option value="">Select a subject</option>
              <option value="general">General Inquiry</option>
              <option value="partnership">Partnership Opportunity</option>
              <option value="feedback">Feedback</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="contact-message" class="form-label">Message</label>
            <textarea class="form-control" id="contact-message" rows="4" placeholder="Type your message here"></textarea>
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