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

  $(document).ready(function(){
    generateForm();
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
    showLoading(true, () => {
      $.ajax({
        type: 'POST',
        url: '{{ route("registrasi.detail.data") }}',
        data: {
            id: id,
            tipe: "edit",
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
              html +=         '<label for="name'+i+'">Nama </label><small style="color: red"> </small>';
              html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" placeholder="Nama " >';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="address'+i+'">Alamat </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
              html +=         '<input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" placeholder="Alamat " >';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="identityno'+i+'">No. Identitas KTP/SIM/Passport</label>';
              html +=         '<input type="text" class="form-control" id="identityno'+i+'" value="'+v.identityno+'" placeholder="No. Identitas KTP/SIM/Passport" >';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="birthplace'+i+'">Tempat Lahir </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
              html +=         '<input type="text" class="form-control" id="birthplace'+i+'" value="'+v.birthplace+'" placeholder="Tempat Lahir " >';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="birthdate'+i+'">Tgl. Lahir</label>';
              html +=         '<input type="date" class="form-control" id="birthdate'+i+'" value="'+v.birthdate+'" placeholder="Tgl. Lahir " >';
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
              html +=         '<label for="job'+i+'">Pekerjaan </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
              html +=         '<input type="text" class="form-control" id="job'+i+'" value="'+v.job+'" placeholder="Pekerjaan ">';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="country'+i+'">Warga Negara </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
              html +=         '<input type="text" class="form-control" id="country'+i+'" value="'+v.country+'" placeholder="Warga Negara ">';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="email'+i+'">Email </label>';
              html +=         '<input type="text" class="form-control" id="email'+i+'" value="'+v.email+'" placeholder="Email">';
              html +=       '</div>';
              html +=       '<div class="form-group">';
              html +=         '<label for="email'+i+'">Foto KTP/SIM/Passport/KK </label><small style="color: red"> *Max size: 2MB</small>';
              html +=         '<input type="file" class="form-control" id="file'+i+'" onChange="resizeImage(this,'+i+')" accept="image/*" capture="camera">';
              html +=         '<input type="hidden" class="form-control" id="image'+i+'" value="'+v.image+'">';
              html +=         '<img id="preview'+i+'" src="'+v.image+'"/>';
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
            
            showLoading(false);
          }else{        
            showLoading(false);
            toastr.error(data.message);
          }
        },
        error: function(data){
          showLoading(false);
          toastr.error(data.statusText + ' : ' + data.status);
        }
      });
    }, 'Sedang mengambil data');

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
      form_data.append('email'+i, $('#email'+i).val());

      var base64data = $('#image'+i).val().replace("data:image/png;base64,", "");
      var bs = atob(base64data);
      var buffer = new ArrayBuffer(bs.length);
      var ba = new Uint8Array(buffer);
      for (var j = 0; j < bs.length; j++) {
          ba[j] = bs.charCodeAt(j);
      }
      var file = new Blob([ba], { type: "image/png" });

      form_data.append('image'+i, file);
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

  function resizeImage(elem, currentIndex)
  {
    var file, img, width = 0, height = 0;

    if ((file = $("#file"+currentIndex)[0].files[0])) {
      img = new Image();
      img.onload = function() {
        
        max_size = 400,
        width = this.width;
        height = this.height;
      
        if (width > height) {
          if (width > max_size) {
            height *= max_size / width;
            width = max_size;
          }
        } else {
          if (height > max_size) {
            width *= max_size / height;
            height = max_size;
          }
        }

        var reader = new FileReader();

        reader.onload = function(event) {
          var image = new Image();

          image.onload = function() {
            var oc = document.createElement('canvas'), octx = oc.getContext('2d');
            
            oc.width = width;
            oc.height = height;
            octx.drawImage(image, 0, 0, oc.width, oc.height);
            
            $("#image"+currentIndex).val(oc.toDataURL());
            document.getElementById("preview"+currentIndex).src = oc.toDataURL();
          };
          image.src = event.target.result;
        };

        reader.readAsDataURL(file);
      };
      img.onerror = function() {
        toastr.error("Bukan tipe gambar yang valid : " + file.type);
      };
      img.src = URL.createObjectURL(file);
    }
  }
        
</script>
@endpush