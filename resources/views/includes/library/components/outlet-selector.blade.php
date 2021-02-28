@if(!session('outlet'))
    <script type="text/javascript">
        $(document).ready(function() {         
            var tableawal = $('#tableoutletpilihawal').DataTable({
                dom        : 'lrtp',//lrtip -> lrtp
                serverSide : true,
                stateSave  : true,
                deferRender: true,
                select: true,
                ajax  : {
                    url : '{{ route("home.data") }}',
                    data: function ( d ) {
                        d.length = 50;
                    },
                },
                scrollY : "33vh",
                scrollX : true,
                scroller: {
                    loadingIndicator: true
                },
                columns: [
                    { "data" : "code" },
                    { "data" : "name" },
                    { "data" : "active" },
                ],
                "fnDrawCallback": function( oSettings ) {
                    if(!tableawal.data().any()) {
                       alert("User {{ auth()->user()->name }} belum memiliki hak akses ke Outlet, silahkan hubungi Manager!"); 
                    }else if(!$('#modalhomeOutlet').hasClass('in')){
                        $('#modalhomeOutlet').modal('show');
                    }
                }
            });

            $('#modalhomeOutlet').on('shown.bs.modal', function () {
                tableawal.columns.adjust().draw();
            });

            $('#modalhomeOutlet table#tableoutletpilihawal tbody').on('dblclick', 'tr', function(){
                var data = tableawal.row( { selected: true } ).data();
                $.ajaxSetup({
                    headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
                });

                $.ajax({
                    type: 'POST',
                    url : '{{route("home.setoutlet")}}',
                    data: {
                        _token  :"{{ csrf_token() }}",
                        id: data.id
                    },
                    dataType: "json",
                    success : function(data){
                        if(data.success){
                            $('#modalhomeOutlet').modal('hide');
                            $('#homeoutlet').html('{{auth()->user()->name}} - '+data.outlet);
                            window.location.reload(true); 
                        }
                    },
                });
            });

            $('#btnPilihOutlet').click(function(){
                var data = tableawal.row( { selected: true } ).data();
                
                $.ajaxSetup({
                    headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
                });

                $.ajax({
                    type: 'POST',
                    url : '{{route("home.setoutlet")}}',
                    data: {
                        _token  :"{{ csrf_token() }}",
                        id: data.id
                    },
                    dataType: "json",
                    success : function(data){
                        if(data.success){
                            $('#modalhomeOutlet').modal('hide');
                            $('#homeoutlet').html(data.outlet);
                            window.location.reload(true);
                        }
                    },
                });
            })
        });
    </script>
@endif
