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
                html +=         '<label for="name'+i+'">Nama *Sesuai Kartu Identitas</label>';
                html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" placeholder="Nama *Sesuai Kartu Identitas" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="address'+i+'">Alamat *Sesuai Kartu Identitas</label>';
                html +=         '<input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" placeholder="Alamat *Sesuai Kartu Identitas" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="identityno'+i+'">No. Identitas KTP/SIM/Passport</label>';
                html +=         '<input type="text" class="form-control" id="identityno'+i+'" value="'+v.identityno+'" placeholder="No. Identitas KTP/SIM/Passport" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="birthplace'+i+'">Tempat Lahir *Sesuai Kartu Identitas</label>';
                html +=         '<input type="text" class="form-control" id="birthplace'+i+'" value="'+v.birthplace+'" placeholder="Tempat Lahir *Sesuai Kartu Identitas" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="birthdate'+i+'">Tgl. Lahir</label>';
                html +=         '<input type="date" class="form-control" id="birthdate'+i+'" value="'+v.birthdate+'" placeholder="Tgl. Lahir *Sesuai Kartu Identitas" >';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="gender'+i+'">Jenis Kelamin</label>';
                html +=         '<select id="gender'+i+'" class="form-control">';

                if (v.gender == 'Laki-laki'){
                  html +=           '<option value="Laki-laki" selected>Laki-laki</option>';
                  html +=           '<option value="Perempuan">Perempuan</option></select>';
                } else{
                  html +=           '<option value="Laki-laki">Laki-laki</option>';
                  html +=           '<option value="Perempuan" selected>Perempuan</option></select>';
                }

                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="job'+i+'">Pekerjaan *Sesuai Kartu Identitas</label>';
                html +=         '<input type="text" class="form-control" id="job'+i+'" value="'+v.job+'" placeholder="Pekerjaan *Sesuai Kartu Identitas">';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="country'+i+'">Warga Negara *Sesuai Kartu Identitas</label>';
                html +=         '<input type="text" class="form-control" id="country'+i+'" value="'+v.country+'" placeholder="Warga Negara *Sesuai Kartu Identitas">';
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
          form_data.append('birthplace'+i, $('#birthplace'+i).val());
          form_data.append('birthdate'+i, $('#birthdate'+i).val());
          form_data.append('gender'+i, $('#gender'+i).val());
          form_data.append('job'+i, $('#job'+i).val());
          form_data.append('country'+i, $('#country'+i).val());
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
                        // var url = "{!! route('registrasi.index') !!}";
                        // window.location.href = url;
                        window.location.reload();
                    },1000);
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
    }
        
</script>
@endpush