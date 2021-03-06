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
    @if ( session()->has('message') )
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      {{ session()->get('message') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
              <!-- @if(Gate::check('isSuperAdmin') || Gate::check('isAdmin'))
              <div class="card-header">
                <div class="card-tools">
                  <a onclick="refresh()" class="btn btn-success">Refresh</a>
                </div>
              </div>
              @endif -->
              <div class="card-body">

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
                      <label>No. Booking:</label>
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="docno" placeholder="Cari No. Booking">
                        <span class="input-group-append">
                            <a onclick="refresh()" type="button" class="btn btn-success btn-flat">Refresh</a>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a class="btn btn-info" id="skeyIns" data-toggle="modal" data-target=".bd-example-modal-lg" title='Flag' style='border-radius: 50%;'><i class="fa fa-info"></i></a>
                    </div>
                </div>

                <table id="table" class="table table-bordered table-striped display nowrap mbuhsakarepku" width="100%" cellspacing="0">
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
                    <th>ID</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>

                <br>

                <!--<div class="row">-->
                <!--    <div class="col-sm-6">-->
                <!--        <div class="input-group mb-3">-->
                <!--          <div class="input-group-prepend">-->
                <!--            <span class="input-group-text">Total Data Registrasi Pasien hari ini:</span>-->
                <!--          </div>-->
                <!--          <input type="text" id="total" class="form-control col-sm-2" value="{{ $today }}" placeholder="0" disabled="">-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Informasi</h4>
      </div>
      <div class="modal-body">
        <P></P>
          <ul class="legend list-unstyled">
            <p>
              <span class="icon"><i class="fa fa-square fa-lg" style="color : #ffc92d;"></i></span> &nbsp;&nbsp; <strong>Kuning :</strong> <span class="name">menandakan sebagian pasien dengan kode booking tersebut ada yang dibatalkan</span>
            </p>
            </li>
            <li>
            <p>
              <span class="icon"><i class="fa fa-square fa-lg" style="color : #f5473b;"></i></span> &nbsp;&nbsp; <strong>Merah :</strong> <span class="name">menandakan semua pasien dengan kode booking tersebut sudah dibatalkan</span>
            </p>
            </li>
          </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
        // $('#table').dataTable().fnDestroy();
        table = $('#table')
        .on('preXhr.dt', function(){ $("#dataTablesSpinner").show(); })
        .on('xhr.dt', function(){ $("#dataTablesSpinner").hide(); })
        .DataTable({
            "serverSide" : true,
            "stateSave"  : true,
            "deferRender": true,
            "ordering"   : false,
            "searching"  : false,
            ajax       : {
                type: 'GET',
                url : '{{ route("registrasi.data") }}',
                data    : function ( d ) {
                    d.tglawal  = $('#tglawal').val();
                    d.tglakhir = $('#tglakhir').val();
                    d.docno    = $('#docno').val();
                },
            },
            scrollY   : 300,
            scrollX   : true,
            scroller  : {
                loadingIndicator: true
            },
            "order": [[ 14, "desc" ]],
            rowCallback: function( row, data, index ) {
                var array = data.paymentstatus.split(',');
                var other = 0;
                var cancel = 0;
                for (var i = 0; i < array.length; i++) {
                    if (array[i] == 'C'){
                        cancel++;
                    } else{
                        other++;
                    }
                }

                @if(Gate::check('isNakes'))
                    table.column(8).visible(true);
                    table.column(9).visible(true);
                    table.column(10).visible(true);

                    if (data.paid <= 0){
                        $(row).hide();
                    } else{
                        if(cancel > 0 && other <= 0){
                            $(row).attr('style', 'background-color: #f5473b;');
                        } else if(cancel > 0 && other > 0){
                            $(row).attr('style', 'background-color: #ffc92d;');
                        }
                    }
                @else
                    table.column(8).visible(false);
                    table.column(9).visible(false);
                    table.column(10).visible(false);

                    @if(Gate::check('isSuperAdmin') || Gate::check('isKasir'))
                        if(cancel > 0 && other <= 0){
                            $(row).attr('style', 'background-color: #f5473b;');
                        } else if(cancel > 0 && other > 0){
                            $(row).attr('style', 'background-color: #ffc92d;');
                        }
                    @endif
                @endif

                @if(Gate::check('isAdmin'))
                    table.column(11).visible(true);
                    table.column(12).visible(true);
                    table.column(13).visible(true);

                    if (data.status_at == null){
                        $(row).hide();
                    } else{
                        if(cancel > 0 && other > 0){
                            $(row).attr('style', 'background-color: #ffc92d;');
                        }
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
                
                table.column(14).visible(false);
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
                    "className": "menufilter text-right"
                },
                {
                    "data" : "type",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "paid",
                    "className": "menufilter text-center",
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
                    "className": "menufilter text-center",
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
                {
                    "data" : "id",
                    "className": "menufilter textfilter"
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

    function email(id){
        var base = "{!! route('registrasi.preview') !!}";
        var url = base+'?id='+id ;
        window.open(url);
        // window.location.href = url;
    }

    function ubahStatus(id, e){
        @if(Gate::check('isNakes') || Gate::check('isSuperAdmin'))
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
                showLoading(true, () => {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("registrasi.detail.data") }}',
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data){
                            showLoading(false);
                            if(data.success){
                              // table2.clear();
                              var newRow  = $(".field.fieldTEXT");
                              var html = "";
                              newRow.empty();
    
                              var i = 1;
                              jumlah = 0;
                              
                              var str = data.data[0].docno;
                              var res = str.split("-");
    
                              $.each(data.data, function (k, v) {
    
                                if (v.paid == 'Y'){
                                    html += '<div id="field'+i+'" class="card card-secondary">';
                                    html +=    '<div class="card-body">';
                                    html +=       '<input type="hidden" class="form-control" id="id'+i+'" value="'+v.id+'">';
                                    html +=       '<div class="form-group">';
                                    html +=         '<label for="name'+i+'">Nama </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
                                    html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" disabled>';
                                    html +=       '</div>';
                                    html +=       '<div class="form-group">';
                                    html +=         '<label for="address'+i+'">Alamat </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
                                    html +=         '<textarea input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" disabled>'+v.address+'</textarea>';
                                    html +=       '</div>';
                                    html +=       '<div class="form-group">';
                                    html +=         '<label for="identityno'+i+'">No. Identitas KTP/SIM/Passport</label>';
                                    html +=         '<input type="text" class="form-control" id="identityno'+i+'" disabled value="'+v.identityno+'">';
                                    html +=       '</div>';
                                    html +=       '<div class="form-group">';
                                    html +=         '<label for="doctor'+i+'">Doctor</label>';
                                    html +=         '<select id="doctor'+i+'" class="form-control">';
                                    html +=           '<option value="">Pilih Doctor</option>';
                                    html +=           '@foreach($dokter as $p => $v)';
                                    html +=           '<option value="{{$v}}">{{$v}}</option>';
                                    html +=           '@endforeach';
                                    html +=         '</select>';
                                    html +=       '</div>';
                                    html +=       '<div class="form-group">';
                                    html +=         '<label for="status'+i+'">Status</label>';
                                    html +=         '<select id="status'+i+'" class="form-control" data-jenis="'+v.detailstatus+'" onchange="return getJenisReaktif(status'+i+', '+i+')">';
                                    html +=           '<option value="">Pilih Status</option>';
    
                                    if (res[0] == 'AB'){
                                        html +=           '<option value="Reaktif">Reaktif</option>';
                                        html +=           '<option value="Non Reaktif">Non Reaktif</option></select>';
                                    } else{
                                        html +=           '<option value="Positif">Positif</option>';
                                        html +=           '<option value="Negatif">Negatif</option></select>';
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
    
                             // looping ulang untuk menentukan selected
                             var j = 1;
                             $.each(data.data, function (k, v) {
                                $('#doctor'+j).val(v.doctor).change();
                                $('#status'+j).val(v.status).change();
                                j++;
                             });
                             
                             $('#modalUbahStatus').modal("show");
                              
                            }else{        
                               toastr.error(data.message);
                            }
                        },
                        error: function(data){
                            showLoading(false);
                            toastr.error(data.statusText + ' : ' + data.status);
                        }
                    });
                }, 'Sedang mengambil data');
            } else{
                toastr.error('Tidak bisa ubah status. Pembayaran belum diinput')
            }
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endif
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