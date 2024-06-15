  <!-- partial:../../partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{Auth::guard('admin')->name??''}}</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
 
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home-data') }}">
          <span class="menu-title">@lang('lang.home_page')</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item text-right">
        <a class="nav-link" href="{{ route('services.index') }}">
          <span class="menu-title">@lang('lang.services')</span>
          {{-- <i class="fa fa-handshake-o"></i> --}}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('areas.index') }}">
          <span class="menu-title">@lang('lang.areas')</span>
          {{-- <i class="mdi mdi-home menu-icon"></i> --}}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('cities.index') }}">
          <span class="menu-title">@lang('lang.cities')</span>
          {{-- <i class="mdi mdi-home menu-icon"></i> --}}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('neighborhoods.index') }}">
          <span class="menu-title">@lang('lang.neighborhoods')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">
          <span class="menu-title">@lang('lang.categories')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('objectives.index') }}">
          <span class="menu-title">@lang('lang.objectives')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('infos.index') }}">
          <span class="menu-title">@lang('lang.infos')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('ads.index') }}">
          <span class="menu-title">@lang('lang.ads')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contact_us.index') }}">
          <span class="menu-title">@lang('lang.contact_us')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('subscriptions.index') }}">
          <span class="menu-title">@lang('lang.subscriptions')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('company.index') }}">
          <span class="menu-title">@lang('lang.company')</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('clients.index') }}">
          <span class="menu-title">@lang('lang.clients')</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('property_type.index') }}">
          <span class="menu-title">@lang('lang.property_type')</span>
        </a>
      </li>


      
      
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Basic UI Elements</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../pages/ui-features/dropdowns.html">Dropdowns</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a>
            </li>
          </ul>
        </div>
      </li> --}}
  
    </ul>
  </nav>