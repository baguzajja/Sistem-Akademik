<style type="text/css">
<!--
table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:left;
}

table.month th {
    padding:5px;
	background-color:#208bbd;
    color:#fff;
	text-align:center;
}
table.month th.head{
	background-color:#EEE;
	text-align:center;
	color:#444444;
}
.img { border:1px solid #ddd; padding: 5px; }
-->
</style>
<?php
echo"<page backtop='37mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
$TglSkrang	= tgl_indo(date("Y m d"));
	$r 		= GetFields('mahasiswa', 'MhswID', $_GET['id'], '*');
	$NamaProdi=NamaProdi($r['kode_jurusan']);
	$NamaKonsentrasi=NamaKonsentrasi($r['Kurikulum_ID']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$gender=($r[Kelamin]=='L')? "Laki - Laki":"Perempuan";

if($r[kode_jurusan]=='61101'){
HeaderS2();
}else{
HeaderS1($NamaProdi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:5px; font-size: 12pt;'>
        <tr>
            <th colspan='3' style='width: 100%; text-align:center; border-bottom:1px dashed #444; padding-bottom:5mm;'>PENDAFTARAN MAHASISWA BARU</th>
        </tr>
		<tr>
            <th colspan='3' style='width: 100%; text-align:center;'>&nbsp;&nbsp;</th>
        </tr>
		<tr style='color:#444;'>
			<td style=' text-align:left; font-size: 10pt;'>$Tahun </td>
			<td style='text-align:right; font-size: 10pt;'>NOMOR PENDAFTARAN : </td>
			<td style='width: 10%; text-align:left; font-size: 10pt;'>$r[NoReg]</td></tr>
    </table><br>";
echo"<table class='month' style='width: 100%; color:#444; border: 1px #eee; font-size: 12pt;'>
	<tr>
      <td style='width: 30%;'><strong>Nama Calon Mahasiswa</strong></td>
      <td style='width: 70%;'><strong>:&nbsp;&nbsp;$r[Nama] </strong></td>
	</tr>
   
    <tr>
      <td class=basic><strong>Jenis Kelamin</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$gender</strong></td>
    </tr>
	<tr>
      <td class=basic><strong>Kewarganegaraan</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[WargaNegara]</strong></td>
    </tr>
    <tr>
	  <td class=basic><strong>Tempat / Tgl Lahir</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[TempatLahir], $TglLhr</strong></td>
    </tr>

    <tr>
      <td class=basic><strong>Agama</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$Agama</strong></td>
    </tr>

	<tr>
      <td class=basic><strong>Alamat</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[Alamat] </strong></td>
    </tr>
	<tr>
      <td class=basic><strong>Telp / Hp</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[Telepon] / $r[Handphone]</strong></td>
    </tr>
<tr>
      <td class=basic><strong>Program Studi</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$NamaProdi</strong></td>
    </tr><tr>
      <td class=basic><strong>Konsentrasi</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$NamaKonsentrasi</strong></td>
    </tr>

";
if($r[kode_jurusan]=='61101'){
	echo"<tr>
		  <td class=basic><strong>Asal Perguruan Tinggi</strong></td>
		  <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah] - $r[KotaSekolah]</strong></td>
		</tr>";
}else{
	echo"<tr>
		  <td class=basic><strong>Asal SMU / SMK & Kota</strong></td>
		  <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah] - $r[KotaSekolah]</strong></td>
		</tr>";
}

echo"</table>";
//penutup
echo"<br><br><table style='width: 100%;color:#444;font-weight: bold;'>
            <tr>
                <td style='width: 40%; text-align:left;text-align:center;'> </td>
				<td style='width:20%;'></td>
				 <td style='width:40%;text-align:center;'>Surabaya, $TglSkrang </td>
            </tr>
			<tr>
                <td style='width: 40%; text-align:left;border-bottom:1px dashed #000000;text-align:center;'> Petugas Pendaftaran </td>
				<td style='width:20%;border-bottom:1px dashed #000000;'></td>
				 <td style='width:40%;border-bottom:1px dashed #000000; text-align:center;'>Calon Mahasiswa</td>
            </tr>
            <tr>
                <td style='width:40%;text-align:left;text-align:center;vertical-align:top;'> <br><br><br><br><br>( $_SESSION[Nama] )</td>
                <td style='width:20%;'></td>
                <td style='width: 40%; text-align:center;vertical-align:top;'><br><br><br><br><br>( $r[Nama] )</td>
            </tr>
        </table>";  
FooterPdf();
echo"</page>";
?>