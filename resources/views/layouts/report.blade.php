<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/jqvmap/jqvmap.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/summernote/summernote-bs4.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/datatables-scroller/css/scroller.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/datatables-select/css/select.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('adminlte/dist/css/adminlte.min.css')}}">
  <!-- Custom Style -->
  <link href="{{url('adminlte/dist/css/custom.css')}}" rel="stylesheet" type="text/css">

  @stack('stylesheets')

</head>
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
          <!-- page content -->
          <div class="right_col" role="main" style="margin-left: 0;">
              @yield('main_container')
          </div>
          <!-- /page content -->
      </div>
    </div>

    <div id="dataTablesSpinner" style="background-color:rgba(255, 255, 255, 0.2); position:fixed; width:100%; height:100%; top:0px; left:0px; z-index:2000; display: none;">
      <div style="position: absolute; top: 50%; left: 50%; margin: -26px 0 0 -26px; color: #26B99A;">
        <i class='fa fa-spinner fa-spin fa-4x'></i>
      </div>
    </div>

<!-- jQuery -->
<script src="{{url('adminlte/bower_components/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('adminlte/bower_components/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

@stack('scripts')

</body>
</html>