
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="{{url('/')}}"><img src="{{!empty($settings['logo']) ?asset('storage/' . $settings['logo']):''}}" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="{{url('/')}}"><img src="{{!empty($settings['logo']) ?asset('storage/' . $settings['logo']):''}}" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
        
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  {{-- <img src="../../assets/images/faces/face1.jpg" alt="image"> --}}
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{Auth::guard('admin')->name??''}}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="dropdown-item text-danger">
                  
                   <i class="mdi mdi-logout me-2 text-primary"></i>Logout</a>
                   <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                   style="display: none;">
                   @csrf
               </form>
    
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="langDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                    
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><i class="fa fa-language"></i> {{LaravelLocalization::getCurrentLocale()}}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="langDropdown">
             
                   @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                   <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                       {{ $properties['native'] }}
                   </a>
               @endforeach
              </div>
            </li>
        
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>