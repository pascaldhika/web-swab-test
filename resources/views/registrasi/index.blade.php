@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Transaction</li>
          <li class="breadcrumb-item active"><a href="{{ route('registrasi.index') }}">Kelola Data Registrasi</a></li>
        </ol>
      </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No. Booking</th>
                    <th>Tgl. Booking</th>
                    <th>Pasien</th>
                    <th>Type</th>
                    <th>Payment</th>
                    <th>Amount</th>
                    <th>Print</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var table = false;
    $(document).ready(function(){
        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            ajax       : {
                type: 'GET',
                url : '{{ route("registrasi.data") }}',
            },
            columns: [
                {
                    "data" : "docno",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "docdate",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "pasien",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "type",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "payment",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "amount",
                    "className": "menufilter textfilter",
                    render: $.fn.dataTable.render.number( '.' )
                },
                {
                    "data" : "print",
                    "className": "menufilter textfilter"
                },
                {data: 'action', orderable: false, searchable: false},
            ],
        });
    });

</script>
@endpush