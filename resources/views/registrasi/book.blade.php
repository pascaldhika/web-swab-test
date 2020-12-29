<div style="padding-top: 1pt;">
    <table width="100%" cellspacing="0" cellpadding="2">
        <tr>
            <td width="7%">Tgl : </td>
            <td width="23%">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y HH:mm:ss') }}</td>
            <td width="13%">Jenis Test : </td>
            <td width="15%">{{ $data[0]->type }}</td>
            <td width="7%">No. : </td>
            <td width="35%"><h3>#{{ $data[0]->docno }}<h3></td>
        </tr>
    </table>
</div>

<table width="100%" cellspacing="0" cellpadding="3" style="border-bottom: 1px solid #000;">
    <thead>
        <tr>
            <th width="5%" style="background-color: #dbe5f1; border: 1px solid #000;">No</th>
            <th width="23%" style="background-color: #dbe5f1; border: 1px solid #000;">Nama</th>
            <th width="52%" style="background-color: #dbe5f1; border: 1px solid #000;">Alamat</th>
            <th width="20%" style="background-color: #dbe5f1; border: 1px solid #000;">No.Identitas</th>
        </tr>
    </thead>
    <tbody>
        @php($n = 1)
        @foreach($data as $v)
        <tr>
            <td style="text-align:center; border: 1px solid #000;">{{ $n }}</td>
            <td style="border: 1px solid #000;">{{ $v->name }}</td>
            <td style="border: 1px solid #000;">{{ $v->address }}</td>
            <td style="border: 1px solid #000;">{{ $v->identityno }}</td>
        </tr>
        @php($n++)
        @endforeach
    </tbody>
</table>