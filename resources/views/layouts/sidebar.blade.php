<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('public/adminlte/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-header">TRANSACTION</li>
        @if(Gate::check('isManager') || Gate::check('isMedis') || Gate::check('isKasir'))
        <li class="nav-item">
          <a href="{{ route('registrasi.index') }}" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>Registrasi</p>
          </a>
        </li>
        @endif

        <li class="nav-header">REPORT</li>
        @if(Gate::check('isManager') || Gate::check('isMedis') || Gate::check('isKasir'))
        <li class="nav-item">
          <a href="{{ route('report.pasien.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Pasien</p>
          </a>
        </li>
        @endif

        <li class="nav-header">SECURITY</li>
        @can('isManager')
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link">
            <i class="nav-icon far fa-user"></i>
            <p>Kelola User</p>
          </a>
        </li>
        @endcan
        @can('isManager')
        <li class="nav-item">
          <a href="{{ route('role.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Roles</p>
          </a>
        </li>
        @endcan
        
      </ul>
    </nav>
  </div>
<!-- /.sidebar -->
</aside>