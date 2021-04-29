<div style="padding-top: 1pt;">
    <table width="100%" cellspacing="0" cellpadding="2">
        <tr>
            <td><h2><strong>Laporan Rekap Pembayaran</strong><h2></td>
        </tr>
        <tr>
            <td><h2><strong>Periode : {{ $tglawal }} s/d {{ $tglakhir }}</strong><h2></td>
        </tr>
    </table>
</div>
<table width="100%" cellspacing="0" cellpadding="3" style="border-bottom: 1px solid #000;">
    <thead>
        <tr>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">No</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Outlet</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Kode Booking</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Tgl. Booking</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Nama Pasien</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Tgl. Lahir</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Usia</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">No.Identitas</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Jenis Test</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Hasil Test</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Status Payment</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Payment Method</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Paid By</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Paid At</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Nakes By</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Status At</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        @php($n = 1)
        @php($paymentlist = '')
        @php($amount_cash = 0)
        @php($amount_traveloka = 0)
        @php($amount_blibli = 0)
        @php($amount_favebiz = 0)
        @php($amount_docuspace = 0)
        @php($amount_airasia = 0)
        @php($amount_lionair = 0)
        @php($amount_citilink = 0)
        @php($amount_qris = 0)
        @php($amount_bankingbca = 0)
        @php($amount_bankingmandiri = 0)
        @php($amount_bankingbni = 0)
        @php($amount_bankingbri = 0)
        @php($amount_debitbca = 0)
        @php($amount_debitmandiri = 0)
        @php($amount_debitbni = 0)
        @php($amount_debitbri = 0)
        @php($amount_pasienfree = 0)        
        @php($total = 0)
        @foreach($data as $v)
            @if ($v->paid != 'Cancel')
                <tr>
                    <td style="border: 1px solid #000;">{{ $n }}</td>
                    <td style="border: 1px solid #000;">{{ $v->outlet }}</td>
                    <td style="border: 1px solid #000;">{{ $v->docno }}</td>
                    <td style="border: 1px solid #000;">{{ $v->docdate }}</td>
                    <td style="border: 1px solid #000;">{{ ($v->gender == 'Laki-laki') ? 'Tn. ' : 'Ny. ' }} {{ $v->name }}</td>
                    <td style="border: 1px solid #000;">{{ $v->birthdate }}</td>
                    <td style="border: 1px solid #000;">{{ $v->age }}</td>
                    <td style="border: 1px solid #000;">{{ $v->identityno }}</td>
                    <td style="border: 1px solid #000;">{{ $v->type }}</td>
                    <td style="border: 1px solid #000;">{{ $v->status }}</td>
                    <td style="border: 1px solid #000;">{{ $v->paid }}</td>
                    <td style="border: 1px solid #000;">{{ $v->paymentlist }}</td>            
                    <td style="border: 1px solid #000;">{{ $v->paid_by }}</td>
                    <td style="border: 1px solid #000;">{{ $v->paid_at }}</td>
                    <td style="border: 1px solid #000;">{{ $v->nakes_by }}</td>
                    <td style="border: 1px solid #000;">{{ $v->status_at }}</td>
                    <td style="border: 1px solid #000;">{{ $v->amount }}</td>
                </tr>        
                @php($n++)
                
                @php($paymentlist = preg_replace('/[^A-Za-z0-9\-]/', '', $v->paymentlist))
                @if ($v->filter == 'AllTotal')
                    @if (strpos($paymentlist, 'Cash') !== false)
                        @php($amount_cash = $amount_cash + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Traveloka') !== false)
                        @php($amount_traveloka = $amount_traveloka + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Blibli') !== false)
                        @php($amount_blibli = $amount_blibli + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Favebiz') !== false)
                        @php($amount_favebiz = $amount_favebiz + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Docuspace') !== false)
                        @php($amount_docuspace = $amount_docuspace + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'AirAsia') !== false)
                        @php($amount_airasia = $amount_airasia + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'LionAir') !== false)
                        @php($amount_lionair = $amount_lionair + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Citilink') !== false)
                        @php($amount_citilink = $amount_citilink + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'Qris') !== false)
                        @php($amount_qris = $amount_qris + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'BankingBCA') !== false)
                        @php($amount_bankingbca = $amount_bankingbca + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'BankingMandiri') !== false)
                        @php($amount_bankingmandiri = $amount_bankingmandiri + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'BankingBNI') !== false)
                        @php($amount_bankingbni = $amount_bankingbni + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'BankingBRI') !== false)
                        @php($amount_bankingbri = $amount_bankingbri + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'DebitBCA') !== false)
                        @php($amount_debitbca = $amount_debitbca + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'DebitMandiri') !== false)
                        @php($amount_debitmandiri = $amount_debitmandiri + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'DebitBNI') !== false)
                        @php($amount_debitbni = $amount_debitbni + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'DebitBRI') !== false)
                        @php($amount_debitbri = $amount_debitbri + $v->amount)
                    @endif

                    @if (strpos($paymentlist, 'PasienFree') !== false)
                        @php($amount_pasienfree = $amount_pasienfree + $v->amount)
                    @endif
                @endif

                @php($total = $total + $v->amount)
            @endif
        @endforeach
        @if ($data)
            @if ($data[0]->filter == 'AllTotal')
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Cash</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_cash }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Traveloka</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_traveloka }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Blibli</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_blibli }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Favebiz</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_favebiz }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Docuspace</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_docuspace }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Air Asia</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_airasia }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Lion Air</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_lionair }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Citilink</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_citilink }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Qris</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_qris }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran m-Banking BCA</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_bankingbca }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran m-Banking Mandiri</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_bankingmandiri }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran m-Banking BNI</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_bankingbni }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran m-Banking BRI</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_bankingbri }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Debit BCA</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_debitbca }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Debit Mandiri</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_debitmandiri }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Debit BNI</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_debitbni }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Debit BRI</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_debitbri }}</strong></td>
                </tr>
                <tr>
                    <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Pasien Free</strong></td>
                    <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $amount_pasienfree }}</strong></td>
                </tr>
            @endif
        @endif
        <tr>
            <td colspan="16" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total Pembayaran Keseluruhan</strong></td>
            <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $total }}</strong></td>
        </tr>
    </tbody>
</table>
<table>
    <tr>
        <td style="font-style: italic;">{{ $username }} {{ date('d/m/Y H:i:s') }}</td>
    </tr>
</table>