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
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Nakes By</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Status At</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        @php($n = 1)
        @php($total = 0)
        @foreach($data as $v)
            @if ($v->paid != 'Cancel')
                <tr>
                    <td style="border: 1px solid #000;">{{ $n }}</td>
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
                    <td style="border: 1px solid #000;">{{ $v->nakes_by }}</td>
                    <td style="border: 1px solid #000;">{{ $v->status_at }}</td>
                    <td style="border: 1px solid #000;">{{ $v->amount }}</td>
                </tr>        
                @php($n++)
                @php($total = $total + $v->amount)
            @endif
        @endforeach
        <tr>
            <td colspan="14" style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>Total</strong></td>
            <td style="text-align: right; background-color: #dbe5f1; border: 1px solid #000;"><strong>{{ $total }}</strong></td>
        </tr>
    </tbody>
</table>
<table>
    <tr>
        <td style="font-style: italic;">{{ $username }} {{ date('d/m/Y H:i:s') }}</td>
    </tr>
</table>