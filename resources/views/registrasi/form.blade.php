@extends('layouts.app2')

@section('content')
<!-- general form elements -->
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Pilih Jenis Swab Test</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-6">
        <select id="type" class="form-control" style="width: 100%;">
            <option value="Antigen Test">Antigen Test</option>
            <option value="Antibodi Test">Antibodi Test</option>
        </select>
      </div>
      <div class="col-3">
        <input type="text" id="jumlah" class="form-control" placeholder="Jml Orang" onkeypress="return hanyaAngka(event)">
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-success" onclick="proses()">Proses</button>
      </div>
    </div>
  </div>
</div>

<div class="field fieldTEXT" id="fieldDynamic">

</div>
<div class="row">
  <div class="col-6">
    <button type="submit" class="btn btn-primary" onclick="simpan()">Save</button>
    <a href="{{route('frontend')}}" class="btn btn-warning">Back</a>
  </div>
</div>
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

  	var newRow 	= $(".field.fieldTEXT");
  	var html = "";

  	newRow.empty();

  	for (var i = 1; i <= jumlah; i++) {
  		html +=	'<div id="field'+i+'" class="card card-secondary">';
      html +=    '<div class="card-header"><h3 class="card-title">Data Peserta '+i+'</h3>';
      html +=     '<div class="card-tools">';
      html +=       '<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>';
      html +=     '</div>';
      html +=    '</div>';
      html +=    '<div class="card-body">';
      html +=    		'<div class="form-group">';
      html +=    			'<label for="name'+i+'">Nama</label>';
      html +=    			'<input type="text" class="form-control" id="name'+i+'" placeholder="Nama">';
      html +=    		'</div>';
      html +=    		'<div class="form-group">';
      html +=    			'<label for="address'+i+'">Alamat</label>';
      html +=    			'<input type="text" class="form-control" id="address'+i+'" placeholder="Alamat">';
      html +=    		'</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="identityno'+i+'">No. Identitas</label>';
      html +=         '<input type="text" class="form-control" id="identityno'+i+'" placeholder="No. Identitas" onkeypress="return hanyaAngka(event)">';
      html +=       '</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="birthplace'+i+'">Tempat Lahir</label>';
      html +=         '<input type="text" class="form-control" id="birthplace'+i+'" placeholder="Tempat Lahir">';
      html +=       '</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="birthdate'+i+'">Tgl. Lahir</label>';
      html +=           '<input type="date" class="form-control calendar" id="birthdate'+i+'" placeholder="Tgl. Lahir">';
      html +=       '</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="gender'+i+'">Jenis Kelamin</label>';
      html +=         '<select id="gender'+i+'" class="form-control"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select>';
      html +=       '</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="job'+i+'">Pekerjaan</label>';
      html +=         '<input type="text" class="form-control" id="job'+i+'" placeholder="Pekerjaan">';
      html +=       '</div>';
      html +=       '<div class="form-group">';
      html +=         '<label for="country'+i+'">Warga Negara</label>';
      html +=         '<input type="text" class="form-control" id="country'+i+'" placeholder="Warga Negara">';
      html +=       '</div>';
      html +=    	'</div>';
      html += '</div>';
  	}

	  newRow.append(html);
  }

  function simpan(){
  	var form_data = new FormData();
    
    if (jumlah >0){
      for (var i = 1; i <= jumlah; i++){
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
    	form_data.append('type', $('#type').val());
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
            var url = base+'?id='+data.id ;

            setTimeout(function(){
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
    }
  }
</script>
@endpush