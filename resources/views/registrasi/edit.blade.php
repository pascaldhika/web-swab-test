@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-edit"></i> Edit Data Pasien
              </h4>
            </div>
            <!-- /.col -->
          </div>

          <div class="field fieldTEXT" id="fieldDynamic">

          </div>

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <a href="{{route('registrasi.index')}}" class="btn btn-warning">Back</a>
              <button type="button" class="btn btn-primary float-right" onclick="simpan()" style="margin-right: 5px;">Save</button>
            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
@endsection

@push('scripts')
<script type="text/javascript">
    var table = false;
    var jumlah = 0;
    generateForm();
    $(document).ready(function(){

      $('#total').on('keyup',function(event) {
          // skip for arrow keys
          if(event.which >= 100 && event.which <= 100) return;

          // format number
          $(this).val(function(index, value) {
              return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          });
      });
    });

    function generateForm(){
      var id = "{!! $id !!}";
      
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
              var newRow  = $(".field.fieldTEXT");
              var html = "";

              newRow.empty();

              var i = 1;
              var total = 0;
              $.each(data.data, function (k, v) {
                html += '<div id="field'+i+'" class="card card-secondary">';
                html +=    '<div class="card-header"><h3 class="card-title">Data Peserta '+i+'</h3>';
                html +=     '<div class="card-tools">';
                html +=       '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>';
                html +=     '</div>';
                html +=    '</div>';
                html +=    '<div class="card-body">';
                html +=       '<input type="hidden" class="form-control" id="id'+i+'" value="'+v.id+'">';
                html +=       '<div class="form-group">';
                html +=         '<label for="name'+i+'">Nama</label>';
                html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" placeholder="Nama" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="address'+i+'">Alamat</label>';
                html +=         '<input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" placeholder="Alamat" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="identityno'+i+'">No. Identitas</label>';
                html +=         '<input type="text" class="form-control" id="identityno'+i+'" value="'+v.identityno+'" placeholder="No. Identitas" >';
                html +=       '</div>';
                html +=     '</div>';
                html += '</div>';

                i++;
                total = total + parseInt(v.amount);
              });

              newRow.append(html);

              jumlah = i-1;
              $('#docdate').html(data.data[0].newdocdate);
              $('#docno').html(data.data[0].docno);
              $('#type').html(data.data[0].type);
              
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

    function simpan(){
        var form_data = new FormData();

        for (var i = 1; i <= jumlah; i++){
          form_data.append('id'+i, $('#id'+i).val());
          form_data.append('name'+i, $('#name'+i).val());
          form_data.append('address'+i, $('#address'+i).val());
          form_data.append('identityno'+i, $('#identityno'+i).val());
        }

        form_data.append('jumlah', jumlah);
        form_data.append('_token', "{{ csrf_token() }}");

        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanedit") }}',
            data: form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    setTimeout(function(){
                        var url = "{!! route('registrasi.index') !!}";
                        window.location.href = url;
                    },1000);
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