<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('adminlte/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav id="content-l" class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        @if(session('outlet'))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Transaction
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Gate::check('isSuperAdmin') || Gate::check('isNakes') || Gate::check('isKasir'))
              <li class="nav-item">
                <a href="{{ route('registrasi.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Registrasi</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
              <li class="nav-item">
                <a href="{{ route('report.pasien.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p>Pasien</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
              <li class="nav-item">
                <a href="{{ route('registrasi.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p>Cetak Hasil</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
              <li class="nav-item">
                <a href="{{ route('report.pembayaran.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p>Rekap Pembayaran</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('outlet.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Outlet</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('mitra.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Mitra</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('payment.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Payment Metode</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('dokter.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Dokter</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('jenisrapid.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p>Jenis Rapid</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Security
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>User</p>
                </a>
              </li>
              @endif

              @if(Gate::check('isSuperAdmin'))
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Roles</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
        @endif
      </ul>
    </nav>
  </div>
<!-- /.sidebar -->
</aside>