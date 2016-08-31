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
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='37mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
$r = GetFields('mahasiswa', 'NIM', $_GET[id], '*');
if($r['Foto']!=''){
		if (file_exists('media/images/foto_mahasiswa/'.$r['Foto'])){
			$foto ="<img src='media/images/foto_mahasiswa/medium_$r[Foto]' style='height:150px;' alt='$r[Nama]'>";
		} elseif (file_exists('media/images/'.$r['Foto'])){
			$foto ="<img src='media/images/$r[Foto]' style='height:150px;' alt='$r[Nama]'>";
		}else{
			$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' style='height:150px;'>";
		}
}else{
	$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' style='height:150px;'>";
}
	$NamaProdi=NamaProdi($r['kode_jurusan']);
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$gender=($r[Kelamin]=='L')?"Laki - Laki":"Perempuan";
	$TglSkrang	= tgl_indo(date("Y m d"));
	$prodi = GetFields('jurusan', 'kode_jurusan', $r[kode_jurusan], '*');
if($r[kode_jurusan]=='61101'){
HeaderS2();
}else{
HeaderS1($NamaProdi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:5px; font-size: 12pt;'>
        <tr>
            <th style='width: 100%; text-align:center;'>KETERANGAN TENTANG DIRI MAHASISWA<br/>(BUKU INDUK MAHASISWA)</th>
        </tr>
		<tr><th style='width: 100%; text-align:center;'>$foto</th></tr>
    </table><br>";
echo"<table class='month' style='width: 100%; color:#444; border: 1px #eee; font-size: 12pt;'>
	<tr>
      <td style='width: 10%;'><strong>01</strong></td>
      <td style='width: 30%;'><strong>NAMA LENGKAP</strong></td>
      <td style='width: 60%;'><strong>:&nbsp;&nbsp;$r[Nama] </strong></td>
	</tr>
    <tr>
      <td class=basic><strong>02</strong></td>
      <td class=basic><strong>NIM</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[NIM]</strong></td>
    </tr>
    <tr>
      <td class=basic><strong>03</strong></td>
      <td class=basic><strong>Jenis Kelamin</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$gender</strong></td>
    </tr>
    <tr>
      <td class=basic><strong>04</strong></td>
	  <td class=basic><strong>Tempat Tgl Lahir</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[TempatLahir], $TglLhr</strong></td>
    </tr>
    <tr>
      <td class=basic><strong>05</strong></td>
      <td class=basic><strong>Agama</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$Agama</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>06</strong></td>
      <td class=basic><strong>Alamat Mahasiswa</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[Alamat] <br>&nbsp; &nbsp; RT: $r[RT] - RW: $r[RW]. $r[KodePos]. $r[Kota] <br>&nbsp; &nbsp;( $r[Propinsi]-$r[Negara] )</strong></td>
    </tr>";
if($prodi[jenjang]=='S1'){
	echo"<tr>
	  <td class=basic><strong>07</strong></td>
      <td class=basic><strong>Nama SMK / SMA / MA</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>08</strong></td><td class=basic colspan='2'><strong>SURAT TANDA TAMAT BELAJAR / IJAZAH</strong></td></tr>";
}else{
echo"<tr>
	  <td class=basic><strong>07</strong></td>
      <td class=basic><strong>Nama Perguruan Tinggi</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>08</strong></td><td class=basic colspan='2'><strong>IJAZAH S1</strong></td></tr>";

}
$Tahun=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
$NamaTahun=explode(" ",$Tahun);
echo"<tr>
	  <td class=basic><strong>A</strong></td>
      <td class=basic><strong>TAHUN</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[TahunLulus]</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>B</strong></td>
      <td class=basic><strong>NOMOR</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[NilaiSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>09</strong></td><td class=basic colspan='2'><strong>DITERIMA DI STIE YAPAN</strong></td></tr>
	<tr>
	  <td class=basic><strong>A</strong></td>
      <td class=basic><strong>PROGRAM STUDI</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$NamaProdi</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>B</strong></td>
      <td class=basic><strong>TAHUN</strong></td>
      <td class=basic><strong>: &nbsp;&nbsp;$NamaTahun[2]</strong></td>
    </tr>
  </table>";
//$Kaprodi=_fetch_array(_query("SELECT * FROM karyawan WHERE Jabatan='18' AND kode_jurusan='$d[kode_jurusan]'"));
echo"<br><br><br>";  
FooterPdf();
echo"</page>";
?>