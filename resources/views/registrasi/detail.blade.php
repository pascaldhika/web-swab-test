@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> Note:</h5>
          This page has been enhanced for printing. Click the print button at the bottom of the invoice.
        </div> -->

        <br>
        
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
              <b>Jenis Test:</b> <span id="type"></span><br>
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
            <div class="col-8">
              <p class="lead">Payment Methods:</p>
              <img src="{{url('adminlte/dist/img/credit/visa.png')}}" alt="Visa">
              <img src="{{url('adminlte/dist/img/credit/mastercard.png')}}" alt="Mastercard">
              <img src="{{url('adminlte/dist/img/credit/american-express.png')}}" alt="American Express">
              <img src="{{url('adminlte/dist/img/credit/paypal2.png')}}" alt="Paypal">

              <!-- <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
              </p> -->
            </div>
            <!-- /.col -->
            <div class="col-4">

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Total:</th>
                    <td><input type="text" class="form-control" id="total" placeholder="0" disabled="" style="font-size: 20pt; text-align: right"></td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <br>
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
    var arrSecondPayment = [];
    var arrThirdPayment = [];
    var arrFourPayment = [];

    var objSecond = {};
    var objThird = {};
    var objFour = {};

    $(document).ready(function(){
        generateForm();
      $('#total').on('keyup',function(event) {
        // skip for arrow keys
        if(event.which >= 100 && event.which <= 100) return;

        // format number
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        if ($(this).val() == ""){
          $(this).val("0");
          $(this)[0].setSelectionRange(0, 0);
        }

      });
    });

    function generateForm(){
      var id = "{!! $id !!}";
      showLoading(true, () => {
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
    
                  $('#docdate').html(data.data[0].newdocdate);
                  $('#docno').html(data.data[0].docno);
                  $('#type').html(data.data[0].type);
    
                  newRow.empty();
    
                  var i = 1;
                  var total = 0;
                  $.each(data.data, function (k, v) {
                    html += '<div id="field'+i+'" class="card card-secondary">';
                    html +=    '<div class="card-header"><h3 class="card-title">Data Pasien '+i+'</h3>';
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
                    // html +=       '<div class="form-group">';
                    // html +=         '<label for="branch'+i+'">Branch</label>';
                    // html +=         '<div class="form-check">';
                    // html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="SBP" checked>';
                    // html +=           '<label class="form-check-label"> SPB</label>';
                    // html +=         '</div>';
                    // html +=         '<div class="form-check">';
                    
                    // var checkedVisit = "";
                    // if (v.branch == 'Visit'){
                    //   checkedVisit ="checked";
                    // }
    
                    // html +=           '<input class="form-check-input" type="radio" name="branch'+i+'" value="Visit" '+checkedVisit+'>';
                    // html +=           '<label class="form-check-label"> Visit</label>';
                    // html +=         '</div>';
                    // html +=       '</div>';
    
                    // var checkedUnPaid = "";
                    // if (v.paid == 'N'){
                    //   checkedUnPaid ="checked";
                    // }
    
                    var checkedCancel = "";
                    if (v.paid == 'C'){
                      checkedCancel ="checked";
                    }
    
                    var disabledPaid, disabledUnpaid, disabledCancel = "";
                    if (v.status){
                      disabledPaid = "disabled";
                      disabledUnpaid = "disabled";
                      disabledCancel = "disabled";
                    }
                    
                    var arrPayment = [];
                    var mitra = "";
                    var payment = "";
                    if (v.paymentlist){
                      arrPayment = v.paymentlist.split(',');
                      
                      mitra = arrPayment[0];
                      payment = arrPayment[1];
                    
                      objSecond['payment'+i] = arrPayment[1];
                      arrSecondPayment.push(objSecond);
    
                      objThird['payment'+i] = arrPayment[2];
                      arrThirdPayment.push(objThird);
    
                      objFour['payment'+i] = arrPayment[3];
                      arrFourPayment.push(objFour);
                    }
    
                    html +=       '<div class="form-group">';
                    html +=         '<label for="paid'+i+'">Payment Status</label>';
                    html +=         '<div class="form-check">';
                    html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Paid" checked '+disabledPaid+' data-mitra="'+mitra+'" data-status="'+v.status+'" onchange="return getPaidChange(this,'+i+')">';
                    html +=           '<label class="form-check-label"> Paid</label>';
                    html +=         '</div>';
                    // html +=         '<div class="form-check">';
                    // html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Unpaid" '+checkedUnPaid+' '+disabledUnpaid+' onchange="return getPaidChange(this,'+i+')">';
                    // html +=           '<label class="form-check-label"> Unpaid</label>';
                    // html +=         '</div>';
                    html +=         '<div class="form-check">';
                    html +=           '<input class="form-check-input" type="radio" name="paid'+i+'" value="Cancel" '+checkedCancel+' '+disabledCancel+' onchange="return getPaidChange(this,'+i+')">';
                    html +=           '<label class="form-check-label"> Cancel</label>';
                    html +=         '</div>';
                    html +=       '</div>';
                    html +=     '</div>';
    
                    html +=    '<div class="card-footer">';
    
                    html +=       '<div class="form-group">';
                    html +=         '<label for="mitra'+i+'">Mitra</label>';
                    html +=         '<select id="mitra'+i+'" name="mitra'+i+'" class="form-control" data-amount="'+v.amount+'" onchange="return getAmount(this, '+i+')">';
                    
                    html +=         '</select>';
                    html +=       '</div>';
                    html +=       '<div class="form-group">';
                    html +=         '<label for="amount'+i+'">Amount</label>';
                    html +=         '<select id="amount'+i+'" name="amount'+i+'" class="form-control" data-payment="'+payment+'" onchange="return getPaymentMethod(this, '+i+')">';
    
                    html +=         '</select>';
                    html +=       '</div>';
                    html +=       '<div class="form-group">';
                    html +=         '<label for="payment'+i+'">Payment Method</label>';
                    html +=         '<select id="payment'+i+'" name="payment'+i+'" class="form-control">';
    
                    html +=         '</select>';
                    html +=       '</div>';
    
                    html +=       '<div class="form-group fieldSecondPayment'+i+'"></div>';
    
                    html +=       '<div class="form-group fieldThirdPayment'+i+'"></div>';
    
                    html +=       '<div class="form-group fieldFourPayment'+i+'"></div>';
    
                    html +=      '</div>';
    
                    html += '</div>';
                    
                    total = total + parseInt(v.amount);
    
                    i++;
                  });
    
                  newRow.append(html);
    
                  jumlah = i-1;
    
                //   for (var j = 1; j <= jumlah; j++){console.log(j);
                //     $('input:radio[name=paid'+j+']:checked').trigger("change");
                //     $('#mitra'+j).trigger('change');
                //     j++;
                //   }
    
                  // looping ulang untuk menentukan selected
                  var j = 1;
                  $.each(data.data, function (k, v) {
                    $('input:radio[name=paid'+j+']:checked').trigger("change");
                    $('#mitra'+j).trigger('change');
                    j++;
                  });
    
                  $('#total').val(total).trigger('keyup');
                  showLoading(false);
                }else{        
                    showLoading(false);
                   toastr.error(data.message);
                }
            },
            error: function(data){
                showLoading(false);
                toastr.error(data.statusText + ' : ' + data.status);
            }
          });
        }, 'Sedang mengambil data');

      return false;
    }

    function submitPayment(){
      var form_data = new FormData();

      for (var i = 1; i <= jumlah; i++){
        form_data.append('id'+i, $('#id'+i).val());
        // form_data.append('branch'+i, $('input[name="branch'+i+'"]:checked').val());
        form_data.append('paid'+i, $('input[name="paid'+i+'"]:checked').val());
        form_data.append('mitra'+i, $('#mitra'+i+' option:selected').text());
        form_data.append('amount'+i, $('#amount'+i+' option:selected').text());
        form_data.append('payment'+i, $('#payment'+i+' option:selected').text());
        // form_data.append('secondpayment'+i, $('#secondpayment'+i).val());
        // form_data.append('thirdpayment'+i, $('#thirdpayment'+i).val());
        // form_data.append('fourpayment'+i, $('#fourpayment'+i).val());
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
            toastr.error(data.statusText + ' : ' + data.status);
        }
      });

      return false;
    }

    function getPaidChange(ele, i) {
      var value = ele.value;
      var mitra = $(ele).data('mitra');
      var status = $(ele).data('status');
      if (value == 'Cancel' || value == 'Unpaid'){
        resetFieldPayment(i);
        $('#mitra'+i).attr('disabled', true);
        $('#payment'+i).attr('disabled', true);
        $('#amount'+i).attr('disabled', true);
      } else{
        if (status)
        {
            $('#mitra'+i).attr('disabled', true);
            $('#payment'+i).attr('disabled', true);
            $('#amount'+i).attr('disabled', true);
        }
        else
        {
            $('#mitra'+i).attr('disabled', false);  
            $('#payment'+i).attr('disabled', false);
            $('#amount'+i).attr('disabled', false);
        }
        
        var str = $('#docno').html();
        var res = str.split("-");
        
        $.ajax({
            url: "{{ route('harga.mitra')}}",
            data : {
              jenisrapidid: res[0]
            },
            type: 'GET',
            dataType: 'json',
            success: function(val) {
              var k = $('select[name="mitra'+i+'"]');
              k.empty();
              k.append('<option value="">Pilih Mitra</option>');
              $.each(val, function(key, value){
                var selected = "";
                if (mitra == value)
                {
                  selected = 'selected';
                }
                k.append('<option value="'+key+'" '+selected+'>'+value+'</option>');
              });
              k.trigger("change");
            },
            error: function(data){
                toastr.error('Error harga mitra : ' + data.message);
            }
        });
      }

      separatorRibuan('amount'+i);
    }

    function getAmount(ele, i) {
      var amount = $(ele).data('amount');
      var str = $('#docno').html();
      var res = str.split("-");
      $.ajax({
        url: "{{ route('harga.amount')}}",
        data : {
          jenisrapidid: res[0],
          mitraid: ele.value
        },
        type: 'GET',
        dataType: 'json',
        success: function(val) {
          var k = $('select[name="amount'+i+'"]');
          k.empty();
          k.append('<option value="0">Pilih Amount</option>');
          $.each(val, function(key, value){
            var selected = "";
            if (amount == value)
            {
              selected = 'selected';
            }
            k.append('<option value="'+key+'" '+selected+'>'+value+'</option>');
          });
          k.trigger("change");
        },
        error: function(data){
            toastr.error('Error harga : ' + data.message);
        }
      });
    }

    function getPaymentMethod(ele, i) {
      var payment = $(ele).data('payment');
      $.ajax({
        url: "{{ route('harga.payment')}}",
        data : {
          hargaid: ele.value
        },
        type: 'GET',
        dataType: 'json',
        success: function(val) {
          var k = $('select[name="payment'+i+'"]');
          k.empty();
          k.append('<option value="0">Pilih Payment Method</option>');
          $.each(val, function(key, value){
            var selected = "";
            if (payment == value)
            {
              selected = 'selected';
            }
            k.append('<option value="'+key+'" '+selected+'>'+value+'</option>');
          });
          k.trigger("change");
          separatorRibuan('amount'+i);
        },
        error: function(data){
            toastr.error('Error payment method : ' + data.message);
        }
      });
    }

    function getSecondPayment(ele, i) {
      resetFieldPayment(i);
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldSecondPayment"+i);
      var html = "";

      var obj;
      for (var key in arrSecondPayment) {
        obj = arrSecondPayment[key];
      }

      switch(x) {
        case 'Qris':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Qris</option>';

          var selectedLinkAja, selectedGopay, selectedDana, selectedOvo, selectedShopeepay = "";
          for (var prop in obj) {
            if (obj[prop] == "LinkAja"){
              selectedLinkAja = "selected";
              break;
            } else if(obj[prop] == "Gopay"){
              selectedGopay = "selected";
              break;
            } else if(obj[prop] == "Dana"){
              selectedDana = "selected";
              break;
            } else if(obj[prop] == "Ovo"){
              selectedOvo = "selected";
              break;
            } else if(obj[prop] == "Shopeepay"){
              selectedShopeepay = "selected";
              break;
            }
          }

          html +=   '<option value="Linkaja" '+selectedLinkAja+'>LinkAja</option>';
          html +=   '<option value="Gopay" '+selectedGopay+'>Gopay</option>';
          html +=   '<option value="Dana" '+selectedDana+'>Dana</option>';
          html +=   '<option value="Ovo" '+selectedOvo+'>Ovo</option>';
          html +=   '<option value="Shopeepay" '+selectedShopeepay+'>Shopeepay</option>';
          html +=  '</select>';
          break;

        case 'Partners':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Partners</option>';

          var selectedTraveloka, selectedBlibli, selectedFavebiz, selectedDocuspace = "";
          for (var prop in obj) {
            if (obj[prop] == "Traveloka"){
              selectedTraveloka = "selected";
              break;
            } else if(obj[prop] == "Blibli"){
              selectedBlibli = "selected";
              break;
            } else if(obj[prop] == "Favebiz"){
              selectedFavebiz = "selected";
              break;
            } else if(obj[prop] == "Docuspace"){
              selectedDocuspace = "selected";
              break;
            }
          }

          html +=   '<option value="Traveloka" '+selectedTraveloka+'>Traveloka</option>';
          html +=   '<option value="Blibli" '+selectedBlibli+'>Blibli</option>';
          html +=   '<option value="Favebiz" '+selectedFavebiz+'>Favebiz</option>';
          html +=   '<option value="Docuspace" '+selectedDocuspace+'>Docuspace</option>';
          html +=  '</select>';
          break;

        case 'Airlines':
          html += '<select id="secondpayment'+i+'" class="form-control" onchange="return getThirdPayment(secondpayment'+i+', '+i+')">';
          html +=   '<option value="">Pilih Airlines</option>';

          var selectedAirAsia, selectedLionGroup = "";
          for (var prop in obj) {
            if (obj[prop] == "Airasia"){
              selectedAirAsia = "selected";
              break;
            } else if(obj[prop] == "Liongroup"){
              selectedLionGroup = "selected";
              break;
            }
          }

          html +=   '<option value="Airasia" '+selectedAirAsia+'>Airasia</option>';
          html +=   '<option value="Liongroup" '+selectedLionGroup+'>Liongroup</option>';
          html +=  '</select>';
          break;

        case 'Debit Card':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Debit</option>';

          var selectedBCA, selectedMandiri = "";
          for (var prop in obj) {
            if (obj[prop] == "BCA"){
              selectedBCA = "selected";
              break;
            } else if(obj[prop] == "Mandiri"){
              selectedMandiri = "selected";
              break;
            }
          }

          html +=   '<option value="BCA" '+selectedBCA+'>BCA</option>';
          html +=   '<option value="Mandiri" '+selectedMandiri+'>Mandiri</option>';
          html +=  '</select>';
          break;

        case 'Credit Card':
          html += '<select id="secondpayment'+i+'" class="form-control">';
          html +=   '<option value="">Pilih Kartu Kredit</option>';

          var selectedVisa, selectedMaster = "";
          for (var prop in obj) {
            if (obj[prop] == "Visa"){
              selectedVisa = "selected";
              break;
            } else if(obj[prop] == "Master"){
              selectedMaster = "selected";
              break;
            }
          }

          html +=   '<option value="Visa" '+selectedVisa+'>Visa</option>';
          html +=   '<option value="Master" '+selectedMaster+'>Master</option>';
          html +=  '</select>';
          break;

        default:
          //
      } 

      newRow.empty();
      newRow.append(html);

      for (var i = 1; i <= jumlah; i++){
        $('#secondpayment'+i).trigger('change');
      }
    }

    function getThirdPayment(ele, i) {
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldThirdPayment"+i);
      var html = "";

      var obj;
      for (var key in arrThirdPayment) {
        obj = arrThirdPayment[key];
      }

      html += '<select id="thirdpayment'+i+'" class="form-control" onchange="return getFourPayment(thirdpayment'+i+', '+i+')">';
      html +=   '<option value="">Pilih Payment</option>';

      var selectedDirectPayment, selectedAR = "";
      for (var prop in obj) {
        if (obj[prop] == "Direct Payment"){
          selectedDirectPayment = "selected";
          break;
        } else if(obj[prop] == "A/R"){
          selectedAR = "selected";
          break;
        }
      }

      html +=   '<option value="Direct Payment" '+selectedDirectPayment+'>Direct Payment</option>';
      html +=   '<option value="A/R" '+selectedAR+'>A/R</option>';
      html +=  '</select>';

      newRow.empty();
      newRow.append(html);

      for (var i = 1; i <= jumlah; i++){
        $('#thirdpayment'+i).trigger('change');
      }
    }

    function getFourPayment(ele, i) {
      var x = $(ele).val();
      var newRow  = $(".form-group.fieldFourPayment"+i);
      var html = "";

      var obj;
      for (var key in arrFourPayment) {
        obj = arrFourPayment[key];
      }

      html += '<select id="fourpayment'+i+'" class="form-control">';
      html +=   '<option value="">Pilih Tipe Payment</option>';

      var selectedCash, selectedQris = "";
      for (var prop in obj) {
        if (obj[prop] == "Cash"){
          selectedCash = "selected";
          break;
        } else if(obj[prop] == "Qris"){
          selectedQris = "selected";
          break;
        }
      }

      html +=   '<option value="Cash" '+selectedCash+'>Cash</option>';
      html +=   '<option value="Qris" '+selectedQris+'>Qris</option>';
      html +=  '</select>';

      newRow.empty();
      newRow.append(html);
    }

    function resetFieldPayment(i){
        $('select[name="mitra'+i+'"]').empty();
        $('select[name="amount'+i+'"]').empty();
        $('select[name="payment'+i+'"]').empty();
        
        var newRowSecond  = $(".form-group.fieldSecondPayment"+i);
        newRowSecond.empty();
        
        var newRowThird  = $(".form-group.fieldThirdPayment"+i);
        newRowThird.empty();
        
        var newRowFour  = $(".form-group.fieldFourPayment"+i);
        newRowFour.empty();
    }

    function separatorRibuan(ele){
      $(ele).on('keyup',function(event) {
        // skip for arrow keys
        if(event.which >= 100 && event.which <= 100) return;

        // format number
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        if ($(this).val() == ""){
          $(this).val("0");
          $(this)[0].setSelectionRange(0, 0);
        }
      });

      // Calculate
      var total = 0;
      for (var i = 1; i <= jumlah; i++){
        var amount = parseInt($('#amount'+i+' option:selected').text());
        if (!isNaN(amount))
        {
          total = total + amount;
        }
      }
      $('#total').val(total).trigger('keyup');

      // $(ele).on('focus click', function() {
      //   if ($(ele).val() == "" || $(ele).val() == "0"){
      //     $(this)[0].setSelectionRange(0, 0);
      //   }
      // });
    }
        
</script>
@endpush