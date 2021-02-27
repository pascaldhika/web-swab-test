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
  <link rel="stylesheet" href="{{url('adminlte/bower_components/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/select2/css/select2.min.css')}}">
  <!-- pace-progress -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/pace-progress/themes/black/pace-theme-flat-top.css')}}">
  <!-- Custom Style -->
  <link href="{{url('adminlte/dist/css/custom.css')}}" rel="stylesheet" type="text/css">

</head>
<body class="hold-transition sidebar-mini pace-yellow">
<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.head')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <br>
  @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.footer')
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
<!-- ChartJS -->
<script src="{{url('adminlte/bower_components/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<!-- <script src="{{url('adminlte/bower_components/sparklines/sparkline.js')}}"></script> -->
<!-- JQVMap -->
<script src="{{url('adminlte/bower_components/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('adminlte/bower_components/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('adminlte/bower_components/moment/moment.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('adminlte/bower_components/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('adminlte/bower_components/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('adminlte/bower_components/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<!-- <script src="{{url('adminlte/dist/js/pages/dashboard.js')}}"></script> -->
<!-- DataTables  & Plugins -->
<script src="{{url('adminlte/bower_components/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/datatables-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/datatables-select/js/dataTables.select.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('adminlte/dist/js/adminlte.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/toastr/toastr.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('adminlte/bower_components/select2/js/select2.full.min.js')}}"></script>
<!-- pace-progress -->
<script src="{{url('adminlte/bower_components/pace-progress/pace.min.js')}}"></script>

@push('scripts')
<script type="text/javascript">
  function clear_column(modal){
    for (var i = 0; i < $('#'+modal+' .form-clear').length; i++) {
        element = $('#'+modal+' .form-clear')[i];
        $(element).val('');
    }
  }

  function cek_filled_enable(modal) {
    var error = [];
    $('#'+modal+' .form-control.sort-tab').each(function (index) {
      if (!$(this).is('[readonly]') && !$(this).val()) {
        error.push(this.placeholder);
      }
    });
    return error;
  }

  /*Inputan Hanya Angka*/
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
  }

</script>
@endpush

@include('includes/library/index')

@stack('scripts')

</body>
</html>