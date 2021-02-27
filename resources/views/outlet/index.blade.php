@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active"><a href="{{ route('outlet.index') }}">Kelola Data Outlet</a></li>
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
                  <a onclick="tambahOutlet()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Outlet</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>CreatedBy</th>
                    <th>UpdatedBy</th>
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

<div class="modal fade" id="modalTambahOutlet">
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
                    <label>Code</label>
                    <input type="text" class="form-control form-clear sort-tab" id="code" placeholder="Code">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control form-clear sort-tab" id="name" placeholder="Name">
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="simpanOutlet()">Save</button>
        </div>
      </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    var table = false;
    $(document).ready(function(){
        $('#table').dataTable().fnDestroy();
        table = $('#table').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 1000,
            ajax       : {
                type: 'GET',
                url : '{{ route("outlet.data") }}',
            },
            columns: [
                {
                    "data" : "code",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "name",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "active",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "createdby",
                    "className": "menufilter textfilter"
                },
                {
                    "data" : "updatedby",
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

    function tambahOutlet(){
        @can('isSuperAdmin')
            clear_column('modalTambahOutlet');
            $('#modalTambahOutlet #myModalLabel').text("Tambah Outlet");
            $('#modalTambahOutlet').modal("show");
        @else
            toastr.error('Anda tidak memiliki HAK AKSES!')
        @endcan
    }

    function simpanOutlet(){
        var id   = $('#modalTambahOutlet #id').val();
        var code = $('#modalTambahOutlet #code').val();
        var name = $('#modalTambahOutlet #name').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("outlet.simpan") }}',
            data: {
                id: id,
                code: code,
                name: name,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    $('#modalTambahOutlet').modal('hide');
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
</script>
@endpush