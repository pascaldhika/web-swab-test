<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('adminlte/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{url('adminlte/bower_components/toastr/toastr.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('adminlte/bower_components/daterangepicker/daterangepicker.css')}}">
</head>
<body class="hold-transition register-page">

<div style="margin-top:10px;margin-left:10px;margin-right:10px">
<!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->
</div>

<!-- jQuery -->
<script src="{{url('adminlte/bower_components/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('adminlte/bower_components/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('adminlte/bower_components/select2/js/select2.full.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/toastr/toastr.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{url('adminlte/bower_components/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('adminlte/bower_components/moment/moment.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{url('adminlte/bower_components/daterangepicker/daterangepicker.js')}}"></script>

@push('scripts')
<script type="text/javascript">
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