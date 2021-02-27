<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('adminlte/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('home') }}" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-header">TRANSACTION</li>
        @if(Gate::check('isSuperAdmin') || Gate::check('isNakes') || Gate::check('isKasir'))
        <li class="nav-item">
          <a href="{{ route('registrasi.index') }}" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>Registrasi</p>
          </a>
        </li>
        @endif

        <li class="nav-header">REPORT</li>
        @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
        <li class="nav-item">
          <a href="{{ route('report.pasien.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Pasien</p>
          </a>
        </li>
        @endif

        @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
        <li class="nav-item">
          <a href="{{ route('registrasi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Cetak Hasil</p>
          </a>
        </li>
        @endif

        @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
        <li class="nav-item">
          <a href="{{ route('report.pembayaran.index') }}" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>Rekap Pembayaran</p>
          </a>
        </li>
        @endif

        <li class="nav-header">MASTER</li>
        @if(Gate::check('isSuperAdmin'))
        <li class="nav-item">
          <a href="{{ route('outlet.index') }}" class="nav-link">
            <i class="nav-icon fas fa-house-user"></i>
            <p>Outlet</p>
          </a>
        </li>
        @endcan

        <li class="nav-header">SECURITY</li>
        @if(Gate::check('isSuperAdmin'))
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link">
            <i class="nav-icon far fa-user"></i>
            <p>Kelola User</p>
          </a>
        </li>
        @endcan
        @if(Gate::check('isSuperAdmin'))
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