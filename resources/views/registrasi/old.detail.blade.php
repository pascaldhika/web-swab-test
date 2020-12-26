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
                  <th>Branch</th>
                  <th>Payment</th>
                  <th>Amount</th>
                  <th>Paid</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                <tr>
                  <td>{{ $v->id }}</td>
                  <td>{{ $v->name }}</td>
                  <td>{{ $v->address }}</td>
                  <td>{{ $v->identityno }}</td>
                  <td>{{ $v->branch }}</td>
                  <td>{{ $v->paymentid }}</td>
                  <td>{{ $v->amount }}</td>
                  <td style="text-align: center;">{{ $v->paid }}</td>
                  <td>{{ $v->status }}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <br>

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              <p class="lead">Payment Methods:</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa">
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="../../dist/img/credit/american-express.png" alt="American Express">
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

              <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
              </p>
            </div>
            <!-- /.col -->
            <div class="col-6">

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Total:</th>
                    <td>$265.24</td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
                <a href="{{route('registrasi.index')}}" class="btn btn-warning">Back</a>
                
                <a href="{{route('registrasi.print.excel', ['id' => $data[0]->registrasiid ])}}" class="btn btn-default"><i class="fas fa-print"></i> Print Excel</a>
                <a href="{{route('registrasi.print.pdf', ['id' => $data[0]->registrasiid ])}}" class="btn btn-default"><i class="fas fa-print"></i> Print Pdf</a>

                @if(Gate::check('isManager') || Gate::check('isNakes'))
                    <button type="button" class="btn btn-primary float-right" onclick="submitStatus()">Submit Status</button>
                @endif

                @if(Gate::check('isManager') || Gate::check('isKasir'))
                    <button type="button" class="btn btn-success float-right" onclick="submitPayment()" style="margin-right: 5px;"><i class="far fa-credit-card"></i> Submit Payment</button>
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

      function getBranchSelectOptions(value) {
        var select = $("<select class='form-control'><option value=''>Pilih Branch</option><option value='SBP'>SBP</option><option value='Visit'>Visit</option></select>");
        if (value) {
          select.val(value).find(':selected').attr('selected', true);
        }
        return select.html()
      }

      function getPaymentStatusSelectOptions(value) {
        var select = $("<select class='form-control'><option value=''>Pilih Payment Status</option><option value='Paid'>Paid</option><option value='Unpaid'>Unpaid</option></select>");
        if (value) {
          select.val(value).find(':selected').attr('selected', true);
        }
        return select.html()
      }

      function getStatusSelectOptions(value) {
        var select = $("<select class='form-control'><option value=''>Pilih Status</option><option value='Positif'>Positif</option><option value='Negatif'>Negatif</option></select>");
        if (value) {
          select.val(value).find(':selected').attr('selected', true);
        }
        return select.html()
      }

      var cannotMedis = "";
      @cannot('isNakes')
      var cannotMedis = "disabled";
      @endcan

      var cannotKasir = "";
      @cannot('isKasir')
      var cannotKasir = "disabled";
      @endcan

      table = $('#table').DataTable({
          "columnDefs": [
          {
            "targets": -1,
            "render": function(data, type, row, meta) {
              return "<select class='mySelect1' "+ cannotMedis +" data-col='" + meta.col + "'>" + getStatusSelectOptions(data) + "</select>";
            }
          },
          {
            "targets": -2,
            "render": function(data, type, row, meta) {
              return "<select class='mySelect2' "+ cannotKasir +" data-col='" + meta.col + "'>" + getPaymentStatusSelectOptions(data) + "</select>";
            }
          },
          {
            "targets": -3,
            "render": function(data, type, row, meta) {
              return "<input type='text' class='form-control MyInput' placeholder='Amount' onkeypress='return hanyaAngka(event)'>";
            }
          },
          {
            "targets": -5,
            "render": function(data, type, row, meta) {
              return "<select class='mySelect3' "+ cannotKasir +" data-col='" + meta.col + "'>" + getBranchSelectOptions(data) + "</select>";
            }
          }
          ],

      });

      $('#table').on('change', 'select.mySelect1, select.mySelect2, select.mySelect3, input.MyInput', function() {
          var colIndex = +$(this).data('col');
          var row = $(this).closest('tr')[0];
          var data = table.row(row).data();
          data[colIndex] = this.value
          console.log(this.value);
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
        var form_data = table.data().toArray();
        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanpayment") }}',
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
        
</script>
@endpush