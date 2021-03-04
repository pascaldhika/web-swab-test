@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active"><a href="{{ route('harga.index') }}">Kelola Data Harga</a></li>
        </ol>
      </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="card-tools">
                  <a onclick="tambahHarga()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Harga</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Mitra</th>
                    <th>Jenis Rapid</th>
                    <th>Nominal</th>
                    <th>Payment Method</th>
                    <th>Active</th>
                    <th>Keterangan</th>
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

<div class="modal fade" id="modalTambahHarga">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <input type="hidden" id="id" value="" class="form-control form-clear">
                <div class="form-group">
                    <label>Mitra</label>
                    <select id="mitraid" class="form-control form-clear">
                        <option value="">Pilih Jenis Mitra</option>
                        @foreach($mitra as $p => $v)
                        <option value="{{$p}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Rapid</label>
                    <select id="jenisrapid" class="form-control form-clear">
                        <option value="">Pilih Jenis Rapid</option>
                        @foreach($jenisrapid as $p => $v)
                        <option value="{{$p}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nominal</label>
                    <input type="text" class="form-control form-clear sort-tab" id="nominal" placeholder="Nominal" onkeypress="return hanyaAngka(event)">
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <select id="paymentid" class="select2 form-control form-clear" multiple="multiple" data-placeholder="Pilih Payment Method" style="width: 100%;">
                        @foreach($payment as $p => $v)
                        <option value="{{$v}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea type="text" class="form-control form-clear sort-tab" id="keterangan" placeholder="Keterangan"></textarea>
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="active" value="Y">
                  <label for="active" class="custom-control-label">Active</label>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="simpanHarga()">Save</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var table = false;
    $(document).ready(function(){
        //Initialize Select2 Elements
        $('.select2').select2();

        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 1000,
            ajax       : {
                type: 'GET',
                url : '{{ route("harga.data") }}',
            },
            columns: [
                {
                    "data" : "mitra",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "jenisrapid",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "nominal",
                    "className": "menufilter text-right",
                    render: $.fn.dataTable.render.number( '.' )
                },
                {
                    "data" : "paymentlist",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "active",
                    "className": "menufilter text-center"
                },
                {
                    "data" : "remark",
                    "className": "menufilter textfilter"
                },
                {data: 'action', orderable: false, searchable: false},
            ],
        });

        $('#nominal').on('keyup',function(event) {
            // skip for arrow keys
            if(event.which >= 100 && event.which <= 100) return;

            // format number
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });

            if ($(this).val() == ""){
              $(this).val("0");
              $(this)[0].setSelectionRange(0, 0);
            }

        });
    });

    function tambahHarga(){
        @can('isSuperAdmin')
            clear_column('modalTambahHarga');
            $('#modalTambahHarga #myModalLabel').text("Tambah Harga");
            $('#modalTambahHarga').modal("show");
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function editHarga(id, e){
        @can('isSuperAdmin')
            var mitra  = $(e).data('mitraid');
            var jenisrapid  = $(e).data('jenisrapid');
            var nominal  = $(e).data('nominal');
            var active  = $(e).data('active');
            var keterangan  = $(e).data('keterangan');

            clear_column('modalTambahHarga');
            $('#modalTambahHarga #myModalLabel').text("Edit Harga");
            $('#modalTambahHarga #id').val(id);
            $('#modalTambahHarga #mitraid').val(mitra).change();
            $('#modalTambahHarga #jenisrapid').val(jenisrapid).change();
            $('#modalTambahHarga #nominal').val(nominal).change();
            $('#modalTambahHarga #keterangan').val(keterangan);
            if (active == 'Y'){
                $('#modalTambahHarga #active').prop('checked', true);  
            } else $('#modalTambahHarga #active').prop('checked', false);

            var paymentlist  = $(e).data('paymentlist');
            var selectedValues = new Array();
            selectedValues = paymentlist.split(",");

            $('#paymentid').val(selectedValues).change();
            // $.each($(".select2"), function(){
            //     $(this).select2('val', selectedValues);
            // });
            
            $('#modalTambahHarga').modal("show");
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function simpanHarga(){
        var id   = $('#modalTambahHarga #id').val();
        var nominal = $('#modalTambahHarga #nominal').val().replace(/\./g,'');
        var mitraid = $('#modalTambahHarga #mitraid').val();
        var jenisrapid = $('#modalTambahHarga #jenisrapid').val();
        var active = $('.custom-control-input:checked').val();
        var keterangan = $('#modalTambahHarga #keterangan').val();
        var paymentid = $('#modalTambahHarga #paymentid').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("harga.simpan") }}',
            data: {
                id: id,
                mitraid: mitraid,
                jenisrapid: jenisrapid,
                nominal: nominal,
                active: active,
                keterangan: keterangan,
                paymentid: paymentid,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalTambahHarga').modal('hide');
                    table.ajax.reload(null, true);
                }else{        
                    toastr.error(data.message);
                }
            },
            error: function(data){
                toastr.error(data.statusText + ' : ' + data.status);
            }
        });

        return false;
    }

</script>
@endpush