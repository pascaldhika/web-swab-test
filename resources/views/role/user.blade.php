@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Security</li>
          <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Kelola Data Role User</a></li>
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
                  <a href="{{ route('role.index') }}" class="btn btn-warning">Back</a>
                </div>
              </div>
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $v)
                    <tr>
                        <td>{{ $v->id }}</td>
                        <td>{{ $v->name }}</td>
                        <td><div onclick="hapusRoleUser('{{ $v->id }}', '{{ $v->role_id }}')" class="btn btn-xs btn-danger no-margin-action" title="Hapus Role User"><i class="fa fa-trash"></i></div></td>
                    </tr>
                    @endforeach
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
    });

    function hapusRoleUser(user_id, role_id){
        $.ajax({
            type: 'POST',
            url: '{{ route("role.user.hapus") }}',
            data: {
                user_id: user_id,
                role_id: role_id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    setTimeout(function(){
                        window.location.reload();
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
</script>
@endpush