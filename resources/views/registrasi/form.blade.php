@extends('layouts.app2')

@section('content')
<!-- general form elements -->
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Pilih Jenis Test</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <select id="outlet" name="outlet" class="form-control">
          <option value="">Pilih Outlet</option>
          @foreach($outlet as $p => $v)
          <option value="{{$p}}">{{$v}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-6">
        <select id="type" class="form-control" style="width: 100%;">
          <option value="">Pilih Jenis Rapid</option>
          @foreach($jenisrapid as $p => $v)
          <option value="{{$v}}">{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-4">
        <input type="text" id="jumlah" class="form-control" placeholder="Jml Pasien" onkeypress="return hanyaAngka(event)">
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-success" onclick="proses()">Proses</button>
      </div>
    </div>
  </div>
</div>

<div class="field fieldTEXT" id="fieldDynamic">

</div>
<!-- <div class="row">
  <div class="col-6">
    <button type="submit" class="btn btn-primary" onclick="simpan()">Save</button>
    <a href="{{route('frontend')}}" class="btn btn-warning">Back</a>
  </div>
</div> -->
<!-- /.card -->
@endsection

@push('scripts')
<script type="text/javascript">
  var jumlah = 0;

  $(document).ready(function(){
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

  });

  function proses(){
    jumlah = $('#jumlah').val();
    var outlet = $('#outlet').val();
    var type = $('#type').val();

    var newRow  = $(".field.fieldTEXT");
    var html = "";

    newRow.empty();

    if (outlet && type)
    {
      html += '<form id="formTambah" class="form-horizontal" method="post" enctype="multipart/form-data">';
      for (var i = 1; i <= jumlah; i++) {
        html += '<div id="field'+i+'" class="card card-secondary">';
        html +=    '<div class="card-header"><h3 class="card-title">Data Peserta '+i+'</h3>';
        html +=     '<div class="card-tools">';
        html +=       '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>';
        html +=     '</div>';
        html +=    '</div>';
        html +=    '<div class="card-body">';
        html +=       '<div class="form-group">';
        html +=         '<label for="identityno'+i+'">No. Identitas KTP/SIM/Passport</label>';
        html +=         '<input type="text" class="form-control" id="identityno'+i+'" placeholder="No. Identitas" onChange="cekNoIdentitas(this,'+i+')" onkeypress="return hanyaAngka(event)">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="name'+i+'">Nama </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=         '<input type="text-area" class="form-control" id="name'+i+'" placeholder="Nama">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="address'+i+'">Alamat </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=         '<textarea type="text" class="form-control" id="address'+i+'" placeholder="Alamat"></textarea>';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="birthplace'+i+'">Tempat Lahir </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=         '<input type="text" class="form-control" id="birthplace'+i+'" placeholder="Tempat Lahir">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="birthdate'+i+'">Tgl. Lahir </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=           '<input type="date" class="form-control calendar" id="birthdate'+i+'" placeholder="Tgl. Lahir">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="gender'+i+'">Jenis Kelamin</label>';
        html +=         '<select id="gender'+i+'" class="form-control"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select>';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="job'+i+'">Pekerjaan </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=         '<input type="text" class="form-control" id="job'+i+'" placeholder="Pekerjaan">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="country'+i+'">Warga Negara </label><small style="color: red"> *Sesuai Kartu Identitas</small>';
        html +=         '<input type="text" class="form-control" id="country'+i+'" placeholder="Warga Negara">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="email'+i+'">Email </label>';
        html +=         '<input type="text" class="form-control" id="email'+i+'" placeholder="Email">';
        html +=       '</div>';
        html +=       '<div class="form-group">';
        html +=         '<label for="file'+i+'">Foto KTP/SIM/Passport/KK </label><small style="color: red"> *Max size: 2MB</small>';
        html +=         '<input type="file" class="form-control" id="file'+i+'" onChange="resizeImage(this,'+i+')" accept="image/*" capture="camera">';
        html +=         '<input type="hidden" class="form-control" id="image'+i+'">';
        html +=         '<img id="preview'+i+'" src=""/>';
        html +=       '</div>';
        html +=     '</div>';
        html += '</div>';
      }
      html += '</form>';

      if (jumlah > 0){
        html += '<div class="card-footer">';
        html +=   '<button type="submit" class="btn btn-primary" onclick="simpan()">Submit</button>';
        html +=   '<button type="submit" class="btn btn-warning float-right" onclick="back()">Back</button>';
        html += '</div>';
      } else{
        toastr.error('Jumlah pasien harus diisi.'); 
        $('#jumlah').focus();
      }

      newRow.append(html);
    }
    else
    {
      toastr.error('Outlet dan Jenis Rapid harus dipilih.');   
    }
  }

  function cekNoIdentitas(elem, currentIndex) {
    showLoading(true, () => {
      var identityno = elem.value;

      $.ajax({
        type: 'GET',
        url: '{{ route("registrasi.ceknoidentitas") }}',
        data:{
          identityno: identityno,
        },
        success:function(result){
          showLoading(false);
          if(result.success)
          {
            if (result.data)
            {
              // $('#outlet').val(result.data.outlet_id).change();
              $('#name'+currentIndex).val(result.data.name);
              $('#address'+currentIndex).val(result.data.address);
              $('#identityno'+currentIndex).val(result.data.identityno);
              $('#birthplace'+currentIndex).val(result.data.birthplace);
              $('#birthdate'+currentIndex).val(result.data.birthdate);
              $('#gender'+currentIndex).val(result.data.gender);
              $('#job'+currentIndex).val(result.data.job);
              $('#country'+currentIndex).val(result.data.country);
              $('#email'+currentIndex).val(result.data.email);
              $('#image'+currentIndex).val(result.image);
              document.getElementById('preview'+currentIndex).src = result.image;
            }
            else
            {
              resetValue(currentIndex);
            }
          }
          else
          {
            toastr.error(result.message);
            resetValue(currentIndex);
          }
        },
        error:function(result){
          showLoading(false);
          resetValue(currentIndex);
          toastr.error('Terjadi kesalahan pada sistem');
        }
      });
    }, 'Sedang mengecek No. Identitas');
  }

  function resetValue(currentIndex)
  {
    $('#name'+currentIndex).val('');
    $('#address'+currentIndex).val('');
    // $('#identityno'+currentIndex).val('');
    $('#birthplace'+currentIndex).val('');
    $('#birthdate'+currentIndex).val('');
    $('#gender'+currentIndex).val('');
    $('#job'+currentIndex).val('');
    $('#country'+currentIndex).val('');
    $('#email'+currentIndex).val('');
    $('#image'+currentIndex).val('');
    document.getElementById('preview'+currentIndex).src = '';
  }

  function simpan(){
    var form_data = new FormData();
    
    showLoading(true, () => {
      if (jumlah > 0){
        for (var i = 1; i <= jumlah; i++){
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
        form_data.append('type', $('#type').val());
        form_data.append('outlet', $('#outlet').val());
        form_data.append('_token', "{{ csrf_token() }}");
        
        $.ajax({
          type: 'POST',
          url: '{{ route("registrasi.simpan") }}',
          data: form_data,
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          success: function(data){
            showLoading(false);
            if(data.success){
              $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Success',
                // subtitle: 'Subtitle',
                body: data.message
              });

              $(".field.fieldTEXT").empty();
              $('#jumlah').val('');

              var base = "{!! route('registrasi.print.book') !!}";
              var url = base+'?id='+data.id;

              setTimeout(function(){
                window.location.href = url;
              },1000);
            }else{
              if(typeof data.message != 'string')
              {
                var obj = JSON.parse(data.message);
                for (var i = 0; i < obj.length; i++) {
                  toastr.error(obj[i]); 
                }
              } else{
                toastr.error(data.message);
              }
            }
          },
          error: function(data){
            showLoading(false);
            toastr.error(data.statusText + ' : ' + data.status);
          }
        });
      }
      else
      {
        showLoading(false);
        toastr.error("Tidak ada data untuk disimpan");
      }
    }, 'Sedang menyimpan data');
  }

  function back(){
    var url = "{!! route('frontend') !!}";
    window.location.href = url;
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