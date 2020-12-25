@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Security</li>
          <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Kelola Data User</a></li>
        </ol>
      </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active</th>
                    <th>Role</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Action</th>
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

<div class="modal fade" id="modalTambahRole">
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
                <div class="form-group">
                    <label>Name</label>
                    <select id="role" class="form-control sort-tab select2" style="width: 100%;">
                        <option value="">Pilih Role</option>
                        @foreach ($role as $p => $v)
                        <option value="{{$p}}">{{$v}}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="simpanRole()">Save</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalUser">
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
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control form-clear sort-tab" id="name" placeholder="Name">
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="active" value="Y">
                  <label for="active" class="custom-control-label">Active</label>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="simpanUser()">Save</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var table = false;
    $(document).ready(function(){
        //Initialize Select2 Elements
        $('.select2').select2()

        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            ajax       : {
                type: 'GET',
                url : '{{ route("user.data") }}',
            },
            columns: [
                {
                    "data" : "name",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "email",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "active",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "role",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "created_at",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "updated_at",
                    "className": "menufilter textfilter"
                },
                {data: 'action', orderable: false, searchable: false},
            ],
        });
    });

    function addRole(id){
        @can('isManager')
            clear_column('modalTambahRole');
            $('#modalTambahRole #myModalLabel').text("Tambah Role");
            $('#modalTambahRole #id').val(id);
            $('#modalTambahRole').modal("show");
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function editUser(id, e){
        @can('isManager')
            var name  = $(e).data('name');
            var active  = $(e).data('active');
            clear_column('modalUser');
            $('#modalUser #myModalLabel').text("Edit User");
            $('#modalUser #id').val(id);
            $('#modalUser #name').val(name);
            if (active == 'Y'){
                $('#modalUser #active').prop('checked', true);  
            } else $('#modalUser #active').prop('checked', false);
            
            $('#modalUser').modal("show");
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function simpanRole(){
        var id   = $('#modalTambahRole #id').val();
        var role = $('#modalTambahRole #role').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("user.add.role") }}',
            data: {
                id: id,
                role: role,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalTambahRole').modal('hide');
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

    function simpanUser(){
        var id   = $('#modalUser #id').val();
        var name = $('#modalUser #name').val();
        var active = $('.custom-control-input:checked').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("user.simpan") }}',
            data: {
                id: id,
                name: name,
                active: active,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalUser').modal('hide');
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

    // function hapusUser(id){
    //     $.ajax({
    //         type: 'POST',
    //         url: '{{ route("user.hapus") }}',
    //         data: {
    //             id: id,
    //             _token: "{{ csrf_token() }}"
    //         },
    //         dataType: "json",
    //         success: function(data){
    //             if(data.success){
    //                 toastr.success(data.message);
    //                 $('#modalTambahRole').modal('hide');
    //                 table.ajax.reload(null, true);
    //             }else{        
    //                 toastr.error(data.message);
    //             }
    //         },
    //         error: function(data){
    //             toastr.error(data.statusText + ' : ' + data.status);
    //         }
    //     });
    // }
</script>
@endpush