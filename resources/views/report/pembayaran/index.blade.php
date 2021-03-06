@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Report</li>
          <li class="breadcrumb-item active"><a href="{{ route('report.pembayaran.index') }}">Rekap Pembayaran</a></li>
        </ol>
      </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-body">
                <form>
					<div class="row">
						<div class="col-sm-2">
						  <label>From:</label>
						  <div class="input-group input-group-sm">
						    <input type="date" class="form-control" id="tglawal" value="{{ date('Y-m-d') }}" placeholder="Tgl. Awal">
						  </div>
						</div>
						<div class="col-sm-2">
						  <label>To:</label>
						  <div class="input-group input-group-sm">
						    <input type="date" class="form-control" id="tglakhir" value="{{ date('Y-m-d') }}" placeholder="Tgl. Akhir">
						  </div>
						</div>
						<div class="col-sm-4">
						  <label>Filter:</label>
						  <div class="input-group input-group-sm">
						    <select id="filter" name="filter" class="form-control">
						    	<option value="">Pilih Filter</option>
						    	<!--<option value="Paid">Paid</option>-->
						    	<option value="Cash">Pembayaran Cash</option>
						    	<option value="NonCash">Pembayaran Non-Cash (Mobile Banking, QRIS, etc)</option>
						    	<option value="Pasien">Pasien Reguler</option>
						    	<option value="PasienMitra">Pasien Mitra (Traveloka, AirAsia, etc)</option>
						    	<option value="Antibodi">Data Antibodi</option>
						    	<option value="Antigen">Data Antigen</option>
						    	<option value="Total">Data Keseluruhan</option>
						    	<option value="AllTotal">Data Keseluruhan Semua Outlet</option>
						    </select>
						  </div>
						</div>
						<div class="col-sm-4">
						  <label>Nama:</label>
						  <div class="input-group input-group-sm">
						    <input type="text" class="form-control" id="name" placeholder="Cari Nama">
						    <span class="input-group-append">
			                    <a onclick="proses()" type="button" class="btn btn-info btn-flat">Proses</a>
			                </span>
						  </div>
						</div>
					</div>
                </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

	function proses(){
		var base = "{!! route('report.pembayaran.print') !!}";
		var tglawal = $('#tglawal').val();
		var tglakhir = $('#tglakhir').val();
		var name = $('#name').val();
		var filter = $('#filter').val();

		var url = base+'?tglawal='+tglawal+'&tglakhir='+tglakhir+'&name='+name+'&filter='+filter;

		window.location.href = url;
	}
</script>
@endpush