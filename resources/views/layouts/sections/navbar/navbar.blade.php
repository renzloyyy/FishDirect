@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@else
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">
@endif

  <!-- Brand -->
  @if(isset($navbarFull))
  <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="{{ url('/') }}" class="app-brand-link gap-2">
      <span class="app-brand-logo demo">
        @include('_partials.macros', ["height" => 30])
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-1">{{ config('variables.templateName') }}</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
    </a>
  </div>
  @endif

  <!-- Toggle menu -->
  @if(!isset($navbarHideToggle))
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="mdi mdi-menu mdi-24px"></i>
    </a>
  </div>
  @endif

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="mdi mdi-magnify mdi-24px lh-0"></i>
        <input type="text" class="form-control border-0 shadow-none bg-body" placeholder="Search..." aria-label="Search...">
      </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">

      @guest
      <!-- Guest: show Login and Register -->
      <li class="nav-item me-3">
        <a href="{{ route('auth-login-basic') }}" class="btn btn-outline-primary">Login</a>
      </li>
      @if (Route::has('register'))
      <li class="nav-item me-3">
        <a href="{{ route('auth.register-basic') }}" class="btn btn-primary">Register</a>
      </li>
      @endif
      @else
      <!-- Authenticated user -->

      <!-- GitHub Star button -->
      <li class="nav-item lh-1 me-3">
        <a class="github-button" href="https://github.com/themeselection/materio-bootstrap-html-laravel-admin-template-free" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star themeselection/materio-bootstrap-html-laravel-admin-template-free on GitHub">Star</a>
      </li>

      <!-- User dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
          <li>
            <a class="dropdown-item pb-2 mb-1" href="javascript:void(0);">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-2 pe-1">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                  <small class="text-muted">{{ Auth::user()->role ?? 'User' }}</small>
                </div>
              </div>
            </a>
          </li>
          <li><div class="dropdown-divider my-1"></div></li>
          <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item text-danger">Logout</button>
            </form>
          </li>
        </ul>
      </li>
      @endguest
    </ul>
  </div>

@if(!isset($navbarDetached))
  </div>
@endif
</nav>
<!-- / Navbar -->
