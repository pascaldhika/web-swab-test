<html>	
    <table>
    	@foreach($data as $v)
    	<tr>
            <td colspan="9"><strong>HASIL PEMERIKSAAN</strong></td>
            <td colspan="9" style="text-align: center;"><strong>SURAT KETERANGAN</strong></td>
        </tr>
        <tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td colspan="9" style="text-align: center;"><strong>LETTER OF STATEMENT</strong></td>
        </tr>
        <tr>
            <td>No. Laboratorium</td>
            <td></td>
        	<td colspan="3">{{ $v->docno }}</td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td colspan="2" style="text-align: right;">No:</td>
        	<td colspan="4">{{ $v->docno }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">{{ $v->name }}</td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td style="text-align: center;"> : </td>
            <td style="text-align: left;">{{ $v->age }}</td>
            <td>Tahun</td>
            <td></td>
            <td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td colspan="9">Yang bertanda tangan dibawah ini menerangkan bahwa / The undersigned below explains that :</td>
        </tr>
        <tr>
            <td>Dokter Pengirim</td>
            <td style="text-align: center;"> : </td>
            <td colspan="4">dr. Adam S.A.K Hardiyanto </td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        </tr>
        <tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td style="text-align: center;">1.</td>
        	<td colspan="2">Nama / Name</td>
        	<td></td>
        	<td></td>
        	<td></td>
            <td style="text-align: center;"> : </td>
        	<td colspan="3">{{ $v->name }}</td>
        </tr>
        <tr>
            <td colspan="9"><strong>PELAPORAN</strong></td>
            <td style="text-align: center;">2.</td>
            <td colspan="5">KTP / SIM / KK / Identification Number</td>
            <td style="text-align: center;"> : </td>
        	<td colspan="3" style="text-align: left;">{{ $v->identityno }}</td>
        </tr>
        <tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td style="text-align: center;">3.</td>
        	<td colspan="5">Tempat, tanggal lahir / Place, Date of Birth</td>
            <td style="text-align: center;"> : </td>
        	<td>{{ $v->birthplace }},</td>
        	<td colspan="2" style="text-align: center;">{{ $v->birthdate }}</td>
        </tr>
        <tr>
            <td colspan="9"><strong>Hasil deteksi Antigen SARS-CoV 2 : {{ $v->status }}</strong></td>
            <td style="text-align: center;">4.</td>
        	<td colspan="2">Jenis kelamin / Sex</td>
        	<td></td>
        	<td></td>
        	<td></td>
            <td style="text-align: center;"> : </td>
        	<td colspan="3">{{ $v->gender }}</td>
        </tr>
        <tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td style="text-align: center;">5.</td>
        	<td colspan="3">Pekerjaan / Occupation</td>
        	<td></td>
        	<td></td>
            <td style="text-align: center;"> : </td>
        	<td colspan="3">{{ $v->job }}</td>
        </tr>
        <tr>
            <td>Saran-saran</td>
            <td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td style="text-align: center;">6.</td>
        	<td colspan="2">Alamat / Address</td>
        	<td></td>
        	<td></td>
        	<td></td>
            <td style="text-align: center;"> : </td>
        	<td colspan="3">{{ $v->address }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="9">a) Hasil deteksi antigen SARS-CoV 2 : positif</td>
        </tr>
        <tr>
        	<td></td>
            <td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td colspan="9"> Selanjutnya disebut Pasien / hereinafter to as patient.</td>
        </tr>
        <tr>
            <td colspan="9">- Pemeriksaan konfirmasi dengan pemeriksaan RT PCR sebanyak 2 kali dalam 2 hari berturut-turut</td>
        </tr>
        <tr>
            <td colspan="9">- Lakukan karantina atau isolasi sesuai dengan ketentuan</td>
            <td colspan="9">- Pasien telah menjalani pemeriksaan yang di lakukan oleh tim Klinik Tridatama Husada di kota</td>
        </tr>
        <tr>
            <td colspan="9">- Menerapkan PHBS (perilaku hidup bersih dan sehat : mencuci tangan, menerapkan etika</td>
            <td colspan="9">- Tangerang Selatan meliputi / Patient underwent the following examination at Tridatama Husada </td>
        </tr>
        <tr>
            <td colspan="9">batuk, menggunakan masker saat sakit, menjaga stamina), dan physical distancing</td>
            <td colspan="9">Clinical in South Tangerang City</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="9">b) Hasil deteksi antigen SARS-CoV 2 : negatif</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">Date</td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;">Jenis Pemeriksaan Type of Examination</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">Hasil Pemeriksaan</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="9">- Hasil negatif tidak menyingkirkan kemungkinan terinfeksi SARS-CoV-2 sehingga masih berisiko</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">23 Desember 2020</td>
            <td colspan="4" rowspan="2" style="text-align: center;border: 1px solid #000;">Rapid Test Antigen SARS-COV-2</td>
            <td colspan="3" rowspan="2" style="text-align: center;border: 1px solid #000;">{{ $v->status }}</td>
        </tr>
        <tr>
            <td colspan="9">menularkan ke orang lain.</td>
        </tr>
        <tr>
            <td colspan="9">- Hasil negatif dapat terjadi pada kondisi kuantitas antigen pada spesimen dibawah level deteksi alat</td>
        </tr>
        <tr>
        	<td colspan="9"></td>
        	<td colspan="9">Demikianlah Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya / This</td>
        </tr>
        <tr>
        	<td colspan="9"></td>
        	<td colspan="9">Statement Letter is a Verification of examination and results</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
        	<td colspan="9"></td>
        	<td>Jakarta,</td>
        	<td colspan="2">23 Desember 2020</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
        	<td colspan="9"></td>
        	<td colspan="3">dr. Adam S.A.K Hardiyanto</td>
        </tr>
        <tr>
        	<td colspan="9"></td>
        	<td colspan="3">(Resident Medical Officer)</td>
        </tr>
        <tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td>Jakarta,</td>
        	<td colspan="2">23 Desember 2020</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        @endforeach
    </table>

</html>