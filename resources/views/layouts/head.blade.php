<nav class="main-header navbar navbar-expand navbar-primary navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <b><a href="#" id="homeoutlet" class="nav-link">{{ (session('outlet')) ? App::make('App\Http\Controllers\HomeController')->cekOutlet(session('outlet')) : ''}}</a></b>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-cog"></i>
      </a>
    </li> -->
    <li class="nav-item">
      <a title="Switch Outlet" class="nav-link" href="{{ url('/switchc') }}" role="button">
        <i class="fas fa-exchange-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a title="Fullscreen" class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a title="Profile" class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!--<a href="#" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profile
          <span class="float-right text-muted text-sm"></span>
        </a>-->

        <a href="{{ route('password.change') }}" class="dropdown-item">
          <i class="fas fa-user-cog mr-2"></i> Change Password
          <span class="float-right text-muted text-sm"></span>
        </a>

        <div class="dropdown-divider"></div>

        <a href="{{ route('logout') }}" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
          <span class="float-right text-muted text-sm"></span>
        </a>
        
      </div>
    </li>
  </ul>
</nav>