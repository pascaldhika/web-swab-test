@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active"><a href="{{ route('outlet.index') }}">Kelola Data Outlet User</a></li>
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
                  <a href="{{ route('outlet.index') }}" class="btn btn-warning">Back</a>
                </div>
              </div>
              <div class="card-body">
                @if(session('status'))
                <div class="alert alert-{{ session('status')[0] }}">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  {{ session('status')[1] }}
                </div>
                @endif
                <form method="POST" action="{{ route('outlet.add.user') }}">
                  @csrf
                  <input type="hidden" id="outletid" name="outletid" value="{{$outlet_id}}">
                  <div class="row">
                    <div class="col-sm-6">
                      <label>User:</label>
                      <select id="userid" name="userid" class="form-control sort-tab select2" style="width: 100%;">
                        <option value="">Pilih User</option>
                        @foreach ($user as $p => $v)
                        <option value="{{$p}}">{{$v}}</option>  
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <br> 

                  <div class="row">
                    <div class="col-sm-3">
                      <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                  </div>
                </form>

                <br>

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
                        <td><div onclick="hapusOutletUser('{{ $v->id }}', '{{ $v->outlet_id }}')" class="btn btn-xs btn-danger no-margin-action" title="Hapus Outlet User"><i class="fa fa-trash"></i></div></td>
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
        //Initialize Select2 Elements
        $('.select2').select2();

        $('#table').dataTable().fnDestroy();
    });

    function hapusOutletUser(user_id, outlet_id){
      $.ajax({
          type: 'POST',
          url: '{{ route("outlet.user.hapus") }}',
          data: {
            user_id: user_id,
            outlet_id: outlet_id,
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