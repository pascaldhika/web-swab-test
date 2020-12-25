@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> Note:</h5>
          This page has been enhanced for printing. Click the print button at the bottom of the invoice.
        </div>


        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <input type="hidden" id="id" value="{{ $data[0]->registrasiid }}" class="form-control">
              <h4>
                <i class="fas fa-globe"></i> AdminLTE, Inc.
                <small class="float-right">Date: {{ $data[0]->newdocdate }}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>No. Booking #{{ $data[0]->docno }}</b><br>
              <b>Jenis Swab Test:</b> {{ $data[0]->type }}<br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <br>
          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table id="table" class="table table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No. Identitas</th>
                  <th>Tempat Lahir</th>
                  <th>Tgl. Lahir</th>
                  <th>Gender</th>
                  <th>Pekerjaan</th>
                  <th>WN</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @php($emptyStatus = 0)
                @foreach($data as $v)
                <tr>
                  <td>{{ $v->id }}</td>
                  <td>{{ $v->name }}</td>
                  <td>{{ $v->address }}</td>
                  <td>{{ $v->identityno }}</td>
                  <td>{{ $v->birthplace }}</td>
                  <td>{{ $v->birthdate }}</td>
                  <td>{{ $v->gender }}</td>
                  <td>{{ $v->job }}</td>
                  <td>{{ $v->country }}</td>
                  <td>{{ $v->status }}</td>
                </tr>
                @if ($v->status == null)
                    @php($emptyStatus++)
                @endif
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <br>
          
          @if ($emptyStatus == 0)
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              <p class="lead">Payment Methods:</p>
              <img src="{{url('public/adminlte/dist/img/credit/visa.png')}}" alt="Visa">
              <img src="{{url('public/adminlte/dist/img/credit/mastercard.png')}}" alt="Mastercard">
              <img src="{{url('public/adminlte/dist/img/credit/american-express.png')}}" alt="American Express">
              <img src="{{url('public/adminlte/dist/img/credit/paypal2.png')}}" alt="Paypal">

              <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
              </p>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <!-- <p class="lead">Amount Due 2/22/2014</p> -->

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Payment Gateway:</th>
                    <td>
                        <select id="payment" class="form-control">
                            <option value="Gopay" @if( $data[0]->payment ? $data[0]->payment == 'Gopay' : '' ) selected="" @endif>Go-Pay</option>
                            <option value="Ovo" @if( $data[0]->payment ? $data[0]->payment == 'Ovo' : '' ) selected="" @endif>Ovo</option>
                            <option value="Dana" @if( $data[0]->payment ? $data[0]->payment == 'Dana' : '' ) selected="" @endif>Dana</option>
                            <option value="Shopee-Pay" @if( $data[0]->payment ? $data[0]->payment == 'Shopee-Pay' : '' ) selected="" @endif>Shopee-Pay</option>
                            <option value="LinkAja" @if( $data[0]->payment ? $data[0]->payment == 'LinkAja' : '' ) selected="" @endif>LinkAja</option>
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <th>Total (Rp):</th>
                    <td><input type="text" id="total" class="form-control" value="{{ $data[0]->amount }}" placeholder="Total" onkeypress="return hanyaAngka(event)"></td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          @endif

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
                <a href="{{route('registrasi.index')}}" class="btn btn-warning">Back</a>
                @if ($emptyStatus == 0)
                    <a href="{{route('registrasi.print.excel', ['id' => $data[0]->registrasiid ])}}" class="btn btn-default"><i class="fas fa-print"></i> Print Excel</a>
                    <a href="{{route('registrasi.print.pdf', ['id' => $data[0]->registrasiid ])}}" class="btn btn-default"><i class="fas fa-print"></i> Print Pdf</a>
                @endif

                @if(Gate::check('isManager') || Gate::check('isMedis'))
                    <button type="button" class="btn btn-primary float-right" onclick="submitStatus()">Submit Status</button>
                @endif

                @if(Gate::check('isManager') || Gate::check('isKasir'))
                    @if ($emptyStatus == 0)
                    <button type="button" class="btn btn-success float-right" onclick="submitPayment()" style="margin-right: 5px;"><i class="far fa-credit-card"></i> Submit Payment</button>
                    @endif
                @endif
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
    $(document).ready(function(){
        function getSelectOptions(value) {
            var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select>");
            if (value) {
              select.val(value).find(':selected').attr('selected', true);
            }
            return select.html()
        }

        table = $('#table').DataTable({
            "columnDefs": [{

              "targets": -1,
              "render": function(data, type, row, meta) {
                return "<select class='mySelect' data-col='" + meta.col + "'>" +
                        getSelectOptions(data) + "</select>";
              }
            }],

        });

        $('#table').on('change', 'select.mySelect', function() {
            var colIndex = +$(this).data('col')
            var row = $(this).closest('tr')[0];
            var data = table.row(row).data();
            data[colIndex] = this.value
            // data[colIndex-1] = $(this).find(':selected').text();
            table.row(row).data(data).draw();
        });

        $('#total').on('keyup',function(event) {
            // skip for arrow keys
            if(event.which >= 100 && event.which <= 100) return;

            // format number
            $(this).val(function(index, value) {
                return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    });

    function submitStatus(){
        var form_data = table.data().toArray();
        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanstatus") }}',
            data: {
                data: form_data,
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

        return false;
    }

    function submitPayment(){
        var id = $('#id').val();
        var total = $('#total').val();
        var payment = $('#payment').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanpayment") }}',
            data: {
                id: id,
                total: total.replace(/\./g,''),
                payment: payment,
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

        return false;
    }
        
</script>
@endpush