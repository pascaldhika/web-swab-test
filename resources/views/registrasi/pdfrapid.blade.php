<html>  
    <table style="margin-bottom:60px;width:100%;margin-left:36px;margin-right:36px;">
    @foreach($data as $v)
        @if ($v->status)

        <!------header----->

        <tr>
            <td colspan="12" style="text-align: center;"><br><br><br><br><br><br></td>
        </tr><tr>
            <td style="text-align: center;" colspan="12">
            <strong>HASIL PEMERIKSAAN </strong>
            </td>
        </tr>

        <tr >
            <td colspan="12">
            <br>
            </td>
        </tr>

        <tr>
            <td colspan="4">No. Laboratorium</td>
            <td style="text-align: center;"> : </td>
            <td colspan="6">{{ $v->docno }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">Nama</td>
            <td style="text-align: center;"> : </td>
            <td colspan="6">{{ ($v->gender == 'Laki-laki') ? ' ' : ' ' }} {{ $v->name }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">Umur</td>
            <td style="text-align: center;"> : </td>
            <td style="text-align: left;">{{ $v->age }}</td>
            <td colspan="5">Tahun</td>
            <td ></td>
        </tr>

        <tr>
            <td colspan="4">Dokter Pengirim</td>
            <td style="text-align: center;"> : </td>
            <td colspan="6">dr. {{ $v->doctor }}</td>
            <td ></td>
        </tr>

        <tr>
            <td colspan="12"><br><br></td>
        </tr>

        <tr style="height:86px">
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;"><strong>ASSAY</strong></td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;"><strong>RESULT</strong></td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;"><strong>NORMAL</strong></td>
        </tr>

        <tr>
            <td colspan="12"><br></td>
        </tr>

        <tr>
            <td colspan="12"><strong><br>SEROLOGI</strong></td>
        </tr>

        <tr>
            <td colspan="12" style="text-align: center;">Anti SARS-CoV2 (Rapid)</td>
        </tr>

        <tr>
            <td colspan="12" style="text-align: center;"><br></td>
        </tr>

        <tr >
            <td colspan="3" style="text-align: center;">IgG</td>
            <td colspan="5" style="text-align: center;">{{ ($v->detailstatus == 'IGG' || $v->detailstatus == 'IGG,IGM') ? 'Reaktif' : 'Non Reaktif' }}</td>
            <td colspan="4" style="text-align: center;">Non Reaktif</td>
        </tr>

        <tr>
            <td colspan="12"><br></td>
        </tr>

        <tr >
            <td colspan="3" style="text-align: center;">IgM</td>
            <td colspan="5" style="text-align: center;">{{ ($v->detailstatus == 'IGM' || $v->detailstatus == 'IGG,IGM') ? 'Reaktif' : 'Non Reaktif' }}</td>
            <td colspan="4" style="text-align: center;">Non Reaktif</td>
        </tr>
        <tr>
            <td colspan="12"><br><strong>KETERANGAN :</strong></td>
        </tr>

        <tr>
            <td colspan="12"><br></td>
        </tr>

        <tr>
            <td colspan="12" style="text-align: left;">Hasil non reaktif tidak menyingkirkan  infeksi SARS-CoV2, kemungkinan :</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">- Tidak terinfeksi SARS- CoV2</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">- Belum terbentuk antibodi (masa inkubasi)</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">- Gangguan produksi antibodi (immuno compromised)</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">Saran : ulang pemeriksaan setelah  7 sampai 10 hari</td>
        </tr>
        
        <tr>
            <td colspan="12" style="text-align: left;"><br>Hasil reaktif tidak memastikan infeksi SARS-CoV2, kemungkinan :</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">- Terinfeksi SARS-CoV2</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;">- Infeksi SARS-CoV2 masa lampau</td>
        </tr>        

        <tr>
            <td></td>
            <td colspan="11" style="text-align: left;"> - Reaksi silang dengan virus lain</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="11">Saran : lakukan  pemeriksaan  konfirmasi dengan metode PCR</td>
        </tr>
        <tr >
            <td colspan="12"><br><br><br></td>
        </tr>
       
        <tr>
            <td colspan="8"></td>
            <td>Jakarta,</td>
            <td colspan="3">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
            
        </tr>
        @endif   
    @endforeach
    </table>
    
    
    
    
    
    

    <table style="margin-bottom:60px;margin-left:36px;margin-right:36px;width:100%;">
    @foreach($data as $v)
        @if ($v->status)
        <tr>
            <td colspan="12" style="text-align: center;"><br><br><br><br><br><br></td>
        </tr>
       <tr>
            <td colspan="12" style="text-align: center;"><strong>SURAT KETERANGAN</strong></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;"><strong>LETTER OF STATEMENT</strong></td>
        </tr>
        <tr >
            <td colspan="12" style="text-align: center;"><strong>{{ $v->docno }}</strong><br><br><br></td>
        </tr>
        <tr>
            <td colspan="12">Yang bertanda tangan dibawah ini menerangkan bahwa / The undersigned below explains that :</td>
        </tr>
        <tr >
            <td colspan="12"><br></td>
        </tr>
        <tr>
            <td style="text-align: center;">1.</td>
            <td colspan="6">Nama / Name</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">{{ $v->name }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">2.</td>
            <td colspan="6">KTP / SIM / KK / Identification Number</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4" style="text-align: left;">{{ $v->identityno }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">3.</td>
            <td colspan="6">Tempat, tanggal lahir / Place, Date of Birth</td>
            <td style="text-align: center;"> : </td>
            <td>{{ $v->birthplace }},</td>
            <td colspan="3" style="text-align: center;">{{ $v->birthdate }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="text-align: center;">4.</td>
            <td colspan="6">Jenis kelamin / Sex</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">{{ $v->gender }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">5.</td>
            <td colspan="6">Pekerjaan / Occupation</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">{{ $v->job }}</td>
        </tr>
        <tr>
            <td style="text-align: center;">6.</td>
            <td colspan="6">Alamat / Address</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">{{ $v->address }}</td>
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
            <td colspan="12" style="height:95px;" >Pasien telah menjalani pemeriksaan yang di lakukan oleh tim Klinik Tridatama Husada di kota Tangerang Selatan meliputi / Patient underwent the following examination at Tridatama Husada Clinical in South Tangerang City</td>
        </tr>
        <tr >
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">Date</td>
            <td colspan="6" rowspan="2" style="text-align: center;border: 1px solid #000;">Jenis Pemeriksaan Type of Examination</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">Hasil Pemeriksaan</td>
        </tr>
        <tr><td></td></tr>
        <tr>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">{{ $v->status_at }}</td>
            <td colspan="6" rowspan="2" style="text-align: center;border: 1px solid #000;">Rapid Test Antibody SARS-COV-2</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">{{ $v->status }}</td>
        </tr>
        <tr>
            <td colspan="12"><br><br><br></td>
        </tr>
        <tr>
            <td colspan="12" >Demikianlah Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya / This Statement Letter is a Verification of examination and results</td>
        </tr>
        
        
        <tr >
            <td colspan="12"><br><br></td>
        </tr>
        
        <tr>
            <td colspan="8"></td>
            <td>Jakarta,</td>
            <td colspan="3">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
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
</html>