<div style="padding-top: 1pt;">
    <table width="100%" cellspacing="0" cellpadding="2">
        <tr>
            <td><h2><strong>Laporan Data Pasien</strong><h2></td>
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
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Nama</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">No.Identitas</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Tempat Lahir</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Tgl. Lahir</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Usia</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Jenis Kelamin</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Pekerjaan</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Alamat</th>
            <th style="background-color: #dbe5f1; border: 1px solid #000;">Warga Negara</th>
        </tr>
    </thead>
    <tbody>
        @php($n = 1)
        @foreach($data as $v)
        <tr>
            <td style="border: 1px solid #000;">{{ $n }}</td>
            <td style="border: 1px solid #000;">{{ $v->docno }}</td>
            <td style="border: 1px solid #000;">{{ $v->docdate }}</td>
            <td style="border: 1px solid #000;">{{ ($v->gender == 'Laki-laki') ? 'Tn. ' : 'Ny. ' }} {{ $v->name }}</td>
            <td style="border: 1px solid #000;">{{ $v->identityno }}</td>
            <td style="border: 1px solid #000;">{{ $v->birthplace }}</td>
            <td style="border: 1px solid #000;">{{ $v->birthdate }}</td>
            <td style="border: 1px solid #000;">{{ $v->age }}</td>
            <td style="border: 1px solid #000;">{{ $v->gender }}</td>
            <td style="border: 1px solid #000;">{{ $v->job }}</td>
            <td style="border: 1px solid #000;">{{ $v->address }}</td>
            <td style="border: 1px solid #000;">{{ $v->country }}</td>
        </tr>
        @php($n++)
        @endforeach
    </tbody>
</table>
