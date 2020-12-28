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
                <table id="table" class="table table-bordered table-striped nowrap">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>No. Booking</th>
                    <th>Tgl. Booking</th>
                    <th>Pasien</th>
                    <th>Jumlah</th>
                    <th>Type</th>
                    <th>Paid</th>
                    <th>Paid By</th>
                    <th>Sudah Input</th>
                    <th>Print</th>
                    <th>Print At</th>
                    <th>Hasil Pemeriksaan</th>
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

<div class="modal fade" id="modalUbahStatus">
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
                <table id="table2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>No. Identitas</th>
                      <th>Status</th>
                      <th>Jenis Reaktif</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitStatus()">Save</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var table, table2;
    $(document).ready(function(){
        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 1000,
            "scrollX" : true,
            "order": [[ 1, "desc" ]],
            ajax       : {
                type: 'GET',
                url : '{{ route("registrasi.data") }}',
            },
            columns: [
                {data: 'action', orderable: false, searchable: false},
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
                    "data" : "jumlah",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "type",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "paid",
                    "className": "menufilter textfilter",
                    "orderable" : false,
                    render : function(data, type, row) {
                        var data = row.paid;
                        if (data <= 0) {
                            return '<input type="checkbox" class="editor-active" onclick="return false;">';
                        } else {
                            return '<input type="checkbox" onclick="return false;" class="editor-active" checked>';
                        }
                        return data;    
                    }, 
                },
                {
                    "data" : "paid_by",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "status_at",
                    "className": "menufilter textfilter",
                    render : function(data, type, row) {
                        var data = row.status_at;
                        if (data) {
                            return '<input type="checkbox" onclick="return false;" class="editor-active" checked>';
                        } else {
                            return '<input type="checkbox" class="editor-active" onclick="return false;">';
                        }
                        return data;    
                    }, 
                },
                {
                    "data" : "print",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "print_at",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "hasil",
                    "className": "menufilter textfilter"
                },
            ],
        });

        @if(Gate::check('isSuperAdmin') || Gate::check('isNakes'))
            table.column(8).visible(true);
        @else
            table.column(8).visible(false);
        @endif

        @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
            table.column(9).visible(true);
            table.column(10).visible(true);
            table.column(11).visible(true);
        @elseif(Gate::check('isNakes'))
            table.column(9).visible(false);
            table.column(10).visible(true);
            table.column(11).visible(true);
        @else
            table.column(9).visible(false);
            table.column(10).visible(false);
            table.column(11).visible(false);
        @endif

        table2 = $('#table2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            columns     : [
                {
                    data : 'id',
                },
                {
                    data : 'name',
                },
                {
                    data : 'address',
                },
                {
                    data : 'identityno',
                },
                {
                    data : 'status',
                },
                {
                    data : 'jenisreaktif',
                },
            ],
        });

        table2.column(5).visible(false);

        $('#table2').on('change', 'select.mySelect1', function() {
            // var colIndex = +$(this).data('col');
            // var row = $(this).closest('tr')[0];
            // var data = table2.row(row).data();
            // data[colIndex] = this.value;

            if (this.value == "Reaktif"){
                table2.column(5).visible(true);
            } else{
                $("#jenisreaktif").val($("#jenisreaktif option:first").val());
                table2.column(5).visible(false);
            }

            // table2.row(row).data(data).draw();
        });
    });

    function detail(id){
        var base = "{!! route('registrasi.detail') !!}";
        var url = base+'?id='+id ;
        window.location.href = url;
    }

    function edit(id){
        var base = "{!! route('registrasi.edit') !!}";
        var url = base+'?id='+id ;
        window.location.href = url;
    }

    function print(id){
        var base = "{!! route('registrasi.print.pdf') !!}";
        var url = base+'?id='+id ;
        window.location.replace(url);

        setTimeout(function(){
          table.ajax.reload(null, true);
        },2000);
    }

    function editPayment(id){
        var base = "{!! route('registrasi.detail') !!}";
        var url = base+'?id='+id ;
        window.location.href = url;
    }

    function ubahStatus(id, e){
        @can('isNakes')
            var type  = $(e).data('type');
            var paid = $(e).data('paid');
            var sts = "";
            var dsts = "";

            if (paid > 0){
                clear_column('modalUbahStatus');
                $('#modalUbahStatus #myModalLabel').text("Ubah Status / Hasil Pemeriksaan Lab");
                $('#modalUbahStatus #id').val(id);

                $.ajax({
                    type: 'POST',
                    url: '{{ route("registrasi.detail.data") }}',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data){
                        if(data.success){
                          table2.clear();
                          $.each(data.data, function (k, v) {

                            sts = "<select id='status' class='mySelect1' data-col='" + k + "'>" + getStatusSelectOptions(type, v.status) + "</select>";
                            dsts = "<select id='jenisreaktif' class='mySelect2' data-col='" + k + "'>" + getDetailStatusSelectOptions(v.detailstatus) + "</select>";
                            
                            table2.rows.add([{
                                'id':v.id,
                                'name':v.name,
                                'address':v.address,
                                'identityno':v.identityno,
                                'status':sts,
                                'jenisreaktif':dsts,
                            }]);
                          });

                         table2.draw();
                         
                         $('#modalUbahStatus').modal("show");
                          
                        }else{        
                           toastr.error(data.message);
                        }
                    },
                    error: function(data){
                        toastr.error(data.statusText + ' : ' + data.status);
                    }
                });
            } else{
                toastr.error('Tidak bisa ubah status. Pembayaran belum diinput')
            }
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function getStatusSelectOptions(type, value) {
        if (type == 'Antibodi Test'){
            var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Reaktif'>Reaktif</option><option value='Nonreaktif'>Non-Reaktif</option></select>");
        } else{
            table2.column(5).visible(false);
            var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select>");
        }

        if (value) {
            if (value == 'Reaktif') table2.column(5).visible(true);
            select.val(value).find(':selected').attr('selected', true);
        }
        return select.html();
    }

    function getDetailStatusSelectOptions(value) {
        var select = $("<select class='form-control'><option value=''>Pilih Detail Status</option><option value='IGG'>IGG</option><option value='IGM'>IGM</option><option value='IGG,IGM'>IGG & IGM</option></select>");
        if (value) {
            select.val(value).find(':selected').attr('selected', true);
        }
        return select.html();
    }

    function submitStatus(){
        var rowData = table2.rows().data().toArray();
        var arrStatus = [];
        var arrReaktif = [];
        var data = [];

        $.each(rowData, function(index, value){
            table2.column(4).nodes().each(function (node, index, dt) {
                var status = $(table2.cell(node).node()).find('.mySelect1').val();
                
                arrStatus[index] = {
                    'id'        : rowData[index].id,
                    'status'    : status
                };
            });

            table2.column(5).nodes().each(function (node, index, dt) {
                var detailstatus = $(table2.cell(node).node()).find('.mySelect2').val();
                
                arrReaktif[index] = {
                    'id'        : rowData[index].id,
                    'detailstatus'    : detailstatus
                };
            });
        });
        
        data = arrStatus.map((item, i) => Object.assign({}, item, arrReaktif[i]));

        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanstatus") }}',
            data: {
                data: data,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalUbahStatus').modal('hide');
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