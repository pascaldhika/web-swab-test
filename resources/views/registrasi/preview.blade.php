@extends('layouts.report')

@push('stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
@endpush

@section('main_container')
<div id="headbar">
    <div class="col-md-12">
        <br>
    </div>

    <div class="col-md-12">
        <button type="submit" id="btnKirimEmail" onclick="email('{{ $namafile }}')" class="btn btn-info"><i class="fa fa-mail-bulk"></i> Kirim Email</button>
        <button type="submit" id="btnClose" class="btn btn-danger" onclick="window.close()"><i class="fa fa-arrow-circle-left"></i> Tutup</button>
    </div>

    <div class="col-md-12">
        <hr>
    </div>
</div>

<div id="databar" class="col-md-12">
    <table style="margin-bottom:60px;width:100%;margin-left:36px;margin-right:36px;">
    @foreach($data as $v)
        @if ($v->status)
        <!------header----->
        <tr>
            <td style="text-align: center;" colspan="12">
                <strong>HASIL PEMERIKSAAN </strong>
            </td>
        </tr>

        <tr >
            <td colspan="12">
            <br><br>
            </td>
        </tr>

        <tr>
            <td>No. Laboratorium</td>
            <td></td>
            <td colspan="6">{{ $v->docno }}</td>
            <td colspan="4"></td>
        </tr>

        <tr>
            <td>Nama</td>
            <td style="text-align: center;"> : </td>
            <td colspan="6">{{ ($v->gender == 'Laki-laki') ? ' ' : ' ' }} {{ $v->name }}</td>
            <td colspan="4"></td>
        </tr>

        <tr>
            <td>Umur</td>
            <td style="text-align: center;"> : </td>
            <td style="text-align: left;">{{ $v->age }}</td>
            <td colspan="5">Tahun</td>
            <td colspan="5"></td>
        </tr>

        <tr>
            <td>Dokter Pengirim</td>
            <td style="text-align: center;"> : </td>
            <td colspan="6">dr. {{ $v->doctor }}</td>
            <td colspan="4"></td>
        </tr>

        <tr >
            <td colspan="12"><br><br><br></td>
        </tr>
        
        <tr>
            <td style="text-align: center;" colspan="12"><strong>PELAPORAN</strong></td>
        </tr>

        <tr >
            <td colspan="12"><br></td>
        </tr>
        
        <tr>
            <td style="text-align: center;" colspan="12"><strong>Hasil deteksi Antigen SARS-CoV 2 : {{ $v->status }}</strong></td>
        </tr>
        
        <tr >
            <td colspan="12"><br><br></td>
        </tr>

        <tr>
            <td colspan="12">Saran-saran</td>
        </tr>

        <tr >
            <td colspan="12"></td>
        </tr>
        
        <tr>
            <td colspan="12">a) Hasil deteksi antigen SARS-CoV 2 : positif</td>
        </tr>

        <tr >
            <td colspan="12"></td>
        </tr>
        
        <tr>
            <td colspan="12">- Pemeriksaan konfirmasi dengan pemeriksaan RT PCR sebanyak 2 kali dalam 2 hari berturut-turut</td>
        </tr>
        
        <tr>
            <td colspan="12">- Lakukan karantina atau isolasi sesuai dengan ketentuan</td>
        </tr>
        
        <tr>
            <td colspan="12" rowspan="2">- Menerapkan PHBS (perilaku hidup bersih dan sehat : mencuci tangan, menerapkan etika batuk, menggunakan masker saat sakit, menjaga stamina), dan physical distancing</td>
        </tr>
        
        <tr >
            <td colspan="12"><br><br></td>
        </tr>
        
        <tr>
            <td colspan="12">b) Hasil deteksi antigen SARS-CoV 2 : negatif</td>
        </tr>
        
        <tr><td colspan="12"></td></tr>
        
        <tr>
            <td colspan="12">- Hasil negatif tidak menyingkirkan kemungkinan terinfeksi SARS-CoV-2 sehingga masih berisiko menularkan ke orang lain.</td>
        </tr>
        
        <tr >
            <td colspan="12"></td>
        </tr>        <tr><td colspan="12"></td></tr>
        <tr>
            <td colspan="12">- Hasil negatif dapat terjadi pada kondisi kuantitas antigen pada spesimen dibawah level deteksi alat</td>
        </tr>
        <tr >
            <td colspan="12"><br><br></td>
        </tr>
        <tr >
            <td colspan="12"><br><br></td>
        </tr>
       
        <tr>
            <td colspan="8"></td>
            <td>Jakarta,</td>
            <td colspan="3">{{ $v->status_at_date }}</td>
        </tr>
        @endif
    @endforeach
    </table>

    <table style="margin-bottom:60px;width:100%;margin-left:36px;margin-right:36px;">
    @foreach($data as $v)
        @if ($v->status)

        <!------header----->
        <tr>
            <td colspan="12" style="text-align: center;"><strong>SURAT KETERANGAN</strong></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;"><strong>LETTER OF STATEMENT</strong></td>
        </tr>
        <tr >
            <td colspan="12" style="text-align: center;">{{ $v->docno }}<br><br></td>
        </tr>
        <tr>
            <td colspan="12">Yang bertanda tangan dibawah ini menerangkan bahwa / The undersigned below explains that :</td>
        </tr>
        <tr >
            <td colspan="12"><br></td>
        </tr>
        <tr>
            <td style="text-align: center;">1.</td>
            <td colspan="5">Nama / Name</td>
            <td style="text-align: center;"> : </td>
            <td colspan="5">{{ $v->name }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">2.</td>
            <td colspan="5">KTP / SIM / KK / Identification Number</td>
            <td style="text-align: center;"> : </td>
            <td colspan="5" style="text-align: left;">{{ $v->identityno }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">3.</td>
            <td colspan="5">Tempat, tanggal lahir / Place, Date of Birth</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $v->birthplace }},</td>
            <td colspan="2" style="text-align: center;">{{ $v->birthdate }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="text-align: center;">4.</td>
            <td colspan="5">Jenis kelamin / Sex</td>
            <td style="text-align: center;"> : </td>
            <td colspan="5">{{ $v->gender }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">5.</td>
            <td colspan="5">Pekerjaan / Occupation</td>
            <td style="text-align: center;"> : </td>
            <td colspan="5">{{ $v->job }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">6.</td>
            <td colspan="5">Alamat / Address</td>
            <td style="text-align: center;"> : </td>
            <td colspan="5">{{ $v->address }}</td>
        </tr>
        <tr><td></td></tr>
        <tr >
            <td colspan="12"></td>
        </tr>        <tr>
            <td colspan="12"> Selanjutnya disebut Pasien / hereinafter to as patient.</td>
        </tr>
        <tr >
            <td colspan="12"></td>
        </tr>        
        <tr>
            <td colspan="12" style="height:100px;">Pasien telah menjalani pemeriksaan yang di lakukan oleh tim Klinik Tridatama Husada di kota Tangerang Selatan meliputi / Patient underwent the following examination at Tridatama Husada Clinical in South Tangerang City</td>
        </tr>
        <tr >
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">Date</td>
            <td colspan="5" rowspan="2" style="text-align: center;border: 1px solid #000;">Jenis Pemeriksaan Type of Examination</td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;">Hasil Pemeriksaan</td>
        </tr>
        <tr><td></td></tr>
        <tr>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">{{ $v->status_at }}</td>
            <td colspan="5" rowspan="2" style="text-align: center;border: 1px solid #000;">Rapid Test Antigen SARS-COV-2</td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;">{{ $v->status }}</td>
        </tr>
        <tr>
            <td colspan="12"><br><br><br></td>
        </tr>
        <tr>
            <td colspan="12" >Demikianlah Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya / This Statement Letter is a Verification of examination and results</td>
        </tr>
        
        
        <tr>
            <td colspan="12"><br><br></td>
        </tr>
        <tr style="margin-top: 3%;"><td colspan="12"></td></tr>
        
        <tr>
            <td colspan="8"></td>
            <td>Jakarta,</td>
            <td colspan="3">{{ $v->status_at_date }}</td>
        </tr>
        <tr >
            <td><br><br><br>
            </td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td colspan="4">dr. {{ $v->doctor }}</td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td colspan="4">(Resident Medical Officer)</td>
        </tr>
        @endif
    @endforeach
    </table>
</div>

@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js "></script>
<script type="text/javascript">
    $(document).ready(function(){
        // $('#table_report').DataTable({
        //     dom: 'rt',
        //     paging: false,
        //     select: {style:'single'},
        //     scrollY : 150,
        //     scrollX : true,
        // });
    });

    function email(namafile){
        document.getElementById("btnKirimEmail").disabled = true;
        var id = "{!! $id !!}";
        var base = "{!! route('registrasi.email') !!}";
        var url = base+'?id='+id+'&namafile='+namafile;
        window.location.href = url;
    }
</script>
@endpush