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
              <h4>
                <i class="fas fa-globe"></i> {{ config('app.name', 'Laravel') }}
                <small class="float-right">Date: <span id="docdate"></span></small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>No. Booking #<span id="docno"></span></b><br>
              <b>Jenis Swab Test:</b> <span id="type"></span><br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <br>
          <!-- Table row -->
          <div class="row">
            
          </div>
          <!-- /.row -->

          <div class="field fieldTEXT" id="fieldDynamic">

          </div>

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              <p class="lead">Payment Methods:</p>
              <img src="{{url('adminlte/dist/img/credit/visa.png')}}" alt="Visa">
              <img src="{{url('adminlte/dist/img/credit/mastercard.png')}}" alt="Mastercard">
              <img src="{{url('adminlte/dist/img/credit/american-express.png')}}" alt="American Express">
              <img src="{{url('adminlte/dist/img/credit/paypal2.png')}}" alt="Paypal">

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
                    <td><input type="text" class="form-control" id="total" placeholder="Total" disabled=""></td>
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

                @if(Gate::check('isKasir') || Gate::check('isSuperAdmin'))
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
    var jumlah = 0;
    generateForm();
    $(document).ready(function(){

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
      
      $.ajax({
        type: 'POST',
        url: '{{ route("registrasi.detail.data") }}',
        data: {
            id: id,
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
                html +=         '<label for="name'+i+'">Nama</label>';
                html +=         '<input type="text" class="form-control" id="name'+i+'" value="'+v.name+'" placeholder="Nama" disabled>';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="address'+i+'">Alamat</label>';
                html +=         '<input type="text" class="form-control" id="address'+i+'" value="'+v.address+'" placeholder="Alamat" disabled>';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="identityno'+i+'">No. Identitas</label>';
                html +=         '<input type="text" class="form-control" id="identityno'+i+'" value="'+v.identityno+'" placeholder="No. Identitas" disabled>';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="branch'+i+'">Branch</label>';
                html +=         '<div class="form-check">';
                
                if (v.branch == 'SBP'){
                  html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="SBP" checked>';
                } else{
                  html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="SBP">';
                }

                html +=           '<label class="form-check-label"> SPB</label>';
                html +=         '</div>';
                html +=         '<div class="form-check">';
                
                if (v.branch == 'Visit'){
                  html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="Visit" checked>';
                } else{
                  html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="Visit">';
                }

                html +=           '<label class="form-check-label"> Visit</label>';
                html +=         '</div>';
                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="paid'+i+'">Payment Status</label>';
                html +=         '<div class="form-check">';
                
                if (v.paid == 'Y'){
                  html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Paid" checked>';
                } else{
                  html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Paid">';
                }

                html +=           '<label class="form-check-label"> Paid</label>';
                html +=         '</div>';
                html +=         '<div class="form-check">';
                
                if (v.paid == 'N'){
                  html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Unpaid" checked>';
                } else{
                  html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Unpaid">';
                }

                html +=           '<label class="form-check-label"> Unpaid</label>';
                html +=         '</div>';

                // if (v.paid == 'Y'){
                //   html +=           '<option value="Paid" selected>Paid</option>';
                //   html +=           '<option value="Unpaid">Unpaid</option></select>';
                // } else{
                //   html +=           '<option value="Paid">Paid</option>';
                //   html +=           '<option value="Unpaid" selected>Unpaid</option></select>';
                // }

                html +=       '</div>';
                html +=       '<div class="form-group">';
                html +=         '<label for="payment'+i+'">Payment Method</label>';
                html +=         '<select id="payment'+i+'" name="payment'+i+'" class="form-control" onchange="return getSecondPayment(payment'+i+', '+i+')">';
                html +=           '<option value="">Pilih Payment</option>';
                html +=           '<option value="1">Cash</option>';
                html +=           '<option value="2">Qris</option>';
                html +=           '<option value="3">Mobile Banking</option>';
                html +=           '<option value="4">Partners</option>';
                html +=           '<option value="5">Airlines</option>';
                html +=           '<option value="6">Debit</option>';
                html +=           '<option value="7">Kartu Kredit</option>';
                html +=         '</select>';
                html +=       '</div>';

                html +=       '<div class="form-group fieldSecondPayment'+i+'"></div>';

                html +=       '<div class="form-group fieldThirdPayment'+i+'"></div>';

                html +=       '<div class="form-group fieldFourPayment'+i+'"></div>';

                html +=       '<div class="form-group">';
                html +=         '<label for="amount'+i+'">Amount</label>';
                html +=         '<input type="text" class="form-control amount" id="amount'+i+'" value="'+v.amount+'" placeholder="Amount" onkeypress="return hanyaAngka(event)">';
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
              $('#total').val(total).trigger('keyup');
              
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
        var form_data = new FormData();

        for (var i = 1; i <= jumlah; i++){
          form_data.append('id'+i, $('#id'+i).val());
          form_data.append('branch'+i, $('input[name="branch'+i+'"]:checked').val());
          form_data.append('paid'+i, $('input[name="paid'+i+'"]:checked').val());
          form_data.append('payment'+i, $('#payment'+i).val());
          form_data.append('secondpayment'+i, $('#secondpayment'+i).val());
          form_data.append('thirdpayment'+i, $('#thirdpayment'+i).val());
          form_data.append('fourpayment'+i, $('#fourpayment'+i).val());
          form_data.append('amount'+i, $('#amount'+i).val());
        }

        form_data.append('jumlah', jumlah);
        form_data.append('_token', "{{ csrf_token() }}");

        $.ajax({
            type: 'POST',
            url: '{{ route("registrasi.simpanpayment") }}',
            data: form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                if(data.success){
                    toastr.success(data.message);
                    setTimeout(function(){
                        var url = "{!! route('registrasi.index') !!}";
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

        return false;
    }

    function getSecondPayment(ele, i) {
      resetFieldPayment(i);
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldSecondPayment"+i);
      var html = "";

      switch(x) {
        case '2':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Qris</option>';
          html +=   '<option value="Linkaja">LinkAja</option>';
          html +=   '<option value="Gopay">Gopay</option>';
          html +=   '<option value="Dana">Dana</option>';
          html +=   '<option value="Ovo">Ovo</option>';
          html +=   '<option value="Shoppepay">ShoppePay</option>';
          html +=  '</select>';
          break;

        case '4':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Partners</option>';
          html +=   '<option value="Traveloka">Traveloka</option>';
          html +=   '<option value="Blibli">Blibli</option>';
          html +=   '<option value="Favebiz">Favebiz</option>';
          html +=   '<option value="Docuspace">Docuspace</option>';
          html +=  '</select>';
          break;

        case '5':
          html += '<select id="secondpayment'+i+'" class="form-control" onchange="return getThirdPayment(secondpayment'+i+', '+i+')">';
          html +=   '<option value="">Pilih Airlines</option>';
          html +=   '<option value="Airasia">Airasia</option>';
          html +=   '<option value="Liongroup">Liongroup</option>';
          html +=  '</select>';
          break;

        case '6':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Debit</option>';
          html +=   '<option value="BCA">BCA</option>';
          html +=   '<option value="Mandiri">Mandiri</option>';
          html +=  '</select>';
          break;

        case '7':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Credit</option>';
          html +=   '<option value="Visa">Visa</option>';
          html +=   '<option value="Master">Master</option>';
          html +=  '</select>';
          break;

        default:
          //
      } 

      newRow.empty();
      newRow.append(html);
    }

    function getThirdPayment(ele, i) {
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldThirdPayment"+i);
      var html = "";

      html += '<select id="thirdpayment'+i+'" class="form-control" onchange="return getFourPayment(thirdpayment'+i+', '+i+')">';
      html +=   '<option value="">Pilih Payment</option>';
      html +=   '<option value="Directpayment">Direct Payment</option>';
      html +=   '<option value="AR">A/R</option>';
      html +=  '</select>';

      newRow.empty();
      newRow.append(html);
    }

    function getFourPayment(ele, i) {
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldFourPayment"+i);
      var html = "";

      html += '<select id="fourpayment'+i+'" class="form-control">';
      html +=   '<option value="">Pilih Tipe Payment</option>';
      html +=   '<option value="Cash">Cash</option>';
      html +=   '<option value="Qris">Qris</option>';
      html +=  '</select>';

      newRow.empty();
      newRow.append(html);
    }

    function resetFieldPayment(i){
      var newRowSecond  = $(".form-group.fieldSecondPayment"+i);
      newRowSecond.empty();

      var newRowThird  = $(".form-group.fieldThirdPayment"+i);
      newRowThird.empty();

      var newRowFour  = $(".form-group.fieldFourPayment"+i);
      newRowFour.empty();
    }
        
</script>
@endpush