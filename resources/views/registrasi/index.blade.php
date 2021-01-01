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
              @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
              <div class="card-header">
                <div class="card-tools">
                  <a onclick="refresh()" class="btn btn-success">Refresh</a>
                </div>
              </div>
              @endif
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped nowrap" width="100%">
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
                    <th>Input By</th>
                    <th>Input At</th>
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
            <div class="field fieldTEXT" id="fieldDynamic">

            </div>
            <!-- <div class="card-body">
                <input type="hidden" id="id" value="" class="form-control form-clear">
                <table id="table2" class="table table-bordered table-striped nowrap">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>No. Identitas</th>
                      <th>Doctor</th>
                      <th>Status</th>
                      <th>Jenis Reaktif</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div> -->
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
    var jumlah = 0;
    $(document).ready(function(){
        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 1000,
            "scrollX" : true,
            "order": [[ 2, "desc" ]],
            ajax       : {
                type: 'GET',
                url : '{{ route("registrasi.data") }}',
            },
            rowCallback: function( row, data, index ) {
                @if(Gate::check('isSuperAdmin') || Gate::check('isNakes'))
                    table.column(8).visible(true);
                    table.column(9).visible(true);
                    table.column(10).visible(true);

                    if (data.paid <= 0){
                        $(row).hide();
                    }
                @else
                    table.column(8).visible(false);
                    table.column(9).visible(false);
                    table.column(10).visible(false);
                @endif

                @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
                    table.column(11).visible(true);
                    table.column(12).visible(true);
                    table.column(13).visible(true);

                    if (data.status_at == null){
                        $(row).hide();
                    }
                @elseif(Gate::check('isNakes'))
                    table.column(11).visible(false);
                    table.column(12).visible(true);
                    table.column(13).visible(true);
                @else
                    table.column(11).visible(false);
                    table.column(12).visible(false);
                    table.column(13).visible(false);
                @endif
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
                    "className": "menufilter textfilter",
                    render:  function(data, type, row){
                        var html="";
                        var array = row.pasien.split(',');
                        for (var i = 0; i < array.length; i++) {
                            html += '- ' + array[i] + '<br>';
                        }

                        return html;
                    }
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
                    "data" : "status_by",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "status_at",
                    "className": "menufilter textfilter"
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
                    "className": "menufilter textfilter",
                    render:  function(data, type, row){
                        var html="";

                        if (row.hasil){
                            var array = row.hasil.split('|');
                            for (var i = 0; i < array.length; i++) {
                                html += '- ' + array[i] + '<br>';
                            }
                        }

                        return html;
                    }
                },
            ],
        });

        table2 = $('#table2').DataTable({
            "scrollX" : true,
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
                    data : 'doctor',
                },
                {
                    data : 'status',
                },
                {
                    data : 'jenisreaktif',
                },
            ],
        });

        // $('#table2').on('change', 'select.mySelect', function() {
        //     var colType = $(this).data('col');
        //     var colIndex = $(this).data('index');

        //     hideJenisReaktif(colType);

        //     if (this.value == 'Reaktif'){
        //         var dsts = "<select id='jenisreaktif' class='mySelect2'>" + getDetailStatusSelectOptions(null) + "</select>";
        //         table2.cell({row:colIndex, column:6}).data(dsts);
        //     } else{
        //         table2.cell({row:colIndex, column:6}).data("");
        //     }
        // });
    });

    function refresh(){
        table.ajax.reload(null, true);
    }

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
            var status_at = $(e).data('status_at');
            var doc = "";
            var sts = "";
            var dsts = "";

            if (paid > 0){
                clear_column('modalUbahStatus');
                var title = "Input Status / Hasil Pemeriksaan Lab";
                if (status_at){
                    title = "Ubah Status / Hasil Pemeriksaan Lab";
                }

                $('#modalUbahStatus #myModalLabel').text(title);
                $('#modalUbahStatus #id').val(id);

                hideJenisReaktif(type);

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
                          // table2.clear();
                          var newRow  = $(".field.fieldTEXT");
                          var html = "";
                          newRow.empty();

                          var i = 1;
                          jumlah = 0;

                          $.each(data.data, function (k, v) {

                            if (v.paid == 'Y'){
                                html += '<div id="field'+i+'" class="card card-secondary">';
                                html +=    '<div class="card-body">';
                                html +=       '<input type="hidden" class="form-control" id="id'+i+'" value="'+v.id+'">';
                                html +=       '<div class="form-group">';
                                html +=         '<label for="name'+i+'">Nama *Sesuai Kartu Identitas</label>';
                                html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" disabled>';
                                html +=       '</div>';
                                html +=       '<div class="form-group">';
                                html +=         '<label for="address'+i+'">Alamat *Sesuai Kartu Identitas</label>';
                                html +=         '<textarea input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" disabled>'+v.address+'</textarea>';
                                html +=       '</div>';
                                html +=       '<div class="form-group">';
                                html +=         '<label for="identityno'+i+'">No. Identitas KTP/SIM/Passport</label>';
                                html +=         '<input type="text" class="form-control" id="identityno'+i+'" disabled value="'+v.identityno+'">';
                                html +=       '</div>';

                                var selectedAdam = "";
                                var selectedHanif = "";
                                if (v.doctor == 'Adam S.A.K Hardiyanto'){
                                    selectedAdam = "selected";
                                } else if(v.doctor == 'Muhammad Hanif'){
                                    selectedHanif = "selected";
                                }

                                html +=       '<div class="form-group">';
                                html +=         '<label for="doctor'+i+'">Doctor</label>';
                                html +=         '<select id="doctor'+i+'" class="form-control">';
                                html +=           '<option value="">Pilih Doctor</option>';
                                html +=           '<option value="Adam S.A.K Hardiyanto" '+selectedAdam+'>dr. Adam S.A.K Hardiyanto</option>';
                                html +=           '<option value="Muhammad Hanif" '+selectedHanif+'>dr. Muhammad Hanif</option></select>';
                                html +=       '</div>';

                                html +=       '<div class="form-group">';
                                html +=         '<label for="status'+i+'">Status</label>';
                                html +=         '<select id="status'+i+'" class="form-control" data-jenis="'+v.detailstatus+'" onchange="return getJenisReaktif(status'+i+', '+i+')">';
                                html +=           '<option value="">Pilih Status</option>';

                                if (type == 'Antibodi Test'){
                                    var selectedReaktif = "";
                                    var selectedNonReaktif = "";
                                    if (v.status == 'Reaktif'){
                                        selectedReaktif = "selected";
                                    } else if(v.status == 'Non Reaktif'){
                                        selectedNonReaktif = "selected";
                                    }

                                    html +=           '<option value="Reaktif" '+selectedReaktif+'>Reaktif</option>';
                                    html +=           '<option value="Non Reaktif" '+selectedNonReaktif+'>Non Reaktif</option></select>';
                                } else{
                                    var selectedPositif = "";
                                    var selectedNegatif = "";
                                    if (v.status == 'Positif'){
                                        selectedPositif = "selected";
                                    } else if(v.status == 'Negatif'){
                                        selectedNegatif = "selected";
                                    }

                                    html +=           '<option value="Positif" '+selectedPositif+'>Positif</option>';
                                    html +=           '<option value="Negatif" '+selectedNegatif+'>Negatif</option></select>';
                                }
                                
                                html +=       '</div>';

                                html +=       '<div class="form-group fieldJenisReaktif'+i+'"></div>';

                                html +=     '</div>';
                                html += '</div>';

                                // doc = "<select id='doctor' class='mySelect'>" + getDoctorSelectOptions(v.doctor) + "</select>";
                                // sts = "<select id='status' class='mySelect1' data-index='"+k+"' data-col='"+type+"'>" + getStatusSelectOptions(type, v.status) + "</select>";
                                // dsts = "<select id='jenisreaktif' class='mySelect2'>" + getDetailStatusSelectOptions(v.detailstatus) + "</select>";
                                
                                // table2.rows.add([{
                                //     'id':v.id,
                                //     'name':v.name,
                                //     'address':v.address,
                                //     'identityno':v.identityno,
                                //     'doctor':doc,
                                //     'status':sts,
                                //     'jenisreaktif':dsts,
                                // }]);

                                i++;
                            }
                          });

                         // table2.draw();

                         newRow.append(html);

                         jumlah = i-1;

                         for (var i = 1; i <= jumlah; i++){
                            $('#status'+i).trigger('change');
                         };
                         
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

    function getJenisReaktif(ele, i) {
      var x = $(ele).val();
      var jenis = $(ele).data('jenis');
      var newRow  = $(".form-group.fieldJenisReaktif"+i);
      var html = "";

      if (x == 'Reaktif'){
        html += '<select id="jenisreaktif'+i+'" class="form-control">';
        html +=   '<option value="">Pilih Jenis Reaktif</option>';

        var selectedIGG = "";
        var selectedIGM = "";
        var selectedIGGIGM = "";
        if (jenis == 'IGG'){
            selectedIGG = "selected"
        } else if(jenis == 'IGM'){
            selectedIGM = "selected";
        } else{
            selectedIGGIGM = "selected";
        }

        html +=   '<option value="IGG" '+selectedIGG+'>IGG</option>';
        html +=   '<option value="IGM" '+selectedIGM+'>IGM</option>';
        html +=   '<option value="IGG,IGM" '+selectedIGGIGM+'>IGG & IGM</option>';
        html +=  '</select>';
      }

      newRow.empty();
      newRow.append(html);
    }

    function getDoctorSelectOptions(value) {
        var select = $("<select class='form-control'><option value=''>Pilih Dokter</option><option value='Adam S.A.K Hardiyanto'>dr. Adam S.A.K Hardiyanto</option><option value='Muhammad Hanif'>dr. Muhammad Hanif</option></select>");
        if (value) {
            select.val(value).find(':selected').attr('selected', true);
        }
        return select.html();
    }

    function getStatusSelectOptions(type, value) {
        if (type == 'Antibodi Test'){
            var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Reaktif'>Reaktif</option><option value='Non Reaktif'>Non-Reaktif</option></select>");
        } else{
            var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select>");
        }

        if (value) {
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

    function hideJenisReaktif(type){
        if (type == "Antibodi Test"){
            table2.column(6).visible(true);
        } else{
            table2.column(6).visible(false);
            $("#jenisreaktif").val($("#jenisreaktif option:first").val());
        }
    }

    function submitStatus(){
        var form_data = new FormData();

        for (var i = 1; i <= jumlah; i++){
            form_data.append('id'+i, $('#id'+i).val());
            form_data.append('doctor'+i, $('#doctor'+i).val());
            form_data.append('status'+i, $('#status'+i).val());
            form_data.append('jenisreaktif'+i, $('#jenisreaktif'+i).val());
        }

        form_data.append('jumlah', jumlah);
        form_data.append('_token', "{{ csrf_token() }}");

        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanstatus") }}',
            data: form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalUbahStatus').modal('hide');
                    table.ajax.reload(null, true);
                }else{        
                    var obj = JSON.parse(data.message);
                    for (var i = 0; i < obj.length; i++) {
                        toastr.error(obj[i]); 
                    }
                }
            },
            error: function(data){
                toastr.error(data.statusText + ' : ' + data.status);
            }
        });

        return false;

        // var rowData = table2.rows().data().toArray();
        // var arrDoctor = [];
        // var arrStatus = [];
        // var arrReaktif = [];
        // var data = [];

        // $.each(rowData, function(index, value){
        //     table2.column(4).nodes().each(function (node, index, dt) {
        //         var doctor = $(table2.cell(node).node()).find('.mySelect').val();
                
        //         arrDoctor[index] = {
        //             'id'        : rowData[index].id,
        //             'doctor'    : doctor
        //         };
        //     });

        //     table2.column(5).nodes().each(function (node, index, dt) {
        //         var status = $(table2.cell(node).node()).find('.mySelect1').val();
                
        //         arrStatus[index] = {
        //             'id'        : rowData[index].id,
        //             'status'    : status
        //         };
        //     });

        //     table2.column(6).nodes().each(function (node, index, dt) {
        //         var detailstatus = $(table2.cell(node).node()).find('.mySelect2').val();
                
        //         arrReaktif[index] = {
        //             'id'        : rowData[index].id,
        //             'detailstatus'    : (detailstatus != undefined) ? detailstatus : null
        //         };console.log(arrReaktif);
        //     });
        // });
        
        // data = arrDoctor.map((item, i) => Object.assign({}, item, arrStatus[i]));
        // data = data.map((item, i) => Object.assign({}, item, arrReaktif[i]));
    }

</script>
@endpush