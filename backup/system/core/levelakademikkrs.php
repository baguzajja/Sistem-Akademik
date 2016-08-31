<?php
function defaultbaakademikkrs(){
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$semester 	= (empty($_POST[semester]))? '' : $_POST[semester];
$nim 		= (empty($_POST[NIM]))? '' : $_POST[NIM];
$pilihsem=Semester(1, 8,$semester );
buka("BAAK :: Kartu Rencana Studi (KRS)");  
echo "<form method=post action='go-levelakademikkrs.html'>
<div class='well'><div class='row-fluid'>
<div class='span3'>
	<label>TAHUN</label>
	<select name='tahun' class='span12'>
		<option value=0 selected>- Pilih Tahun Akademik -</option>";
		$t=_query("SELECT * FROM tahun ORDER BY Tahun_ID DESC");
		while($r=_fetch_array($t)){
		$cek=($tahun == $r['Tahun_ID'])? 'selected': '';
		echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
		}
	echo "</select>
</div>
<div class='span3'>
<label>SEMESTER</label>
<select name='semester' class='span12'>
$pilihsem
</select>
</div>
<div class='span6'>
<label>NIM</label>
<input type=text name=NIM value='$nim' placeholder='Masukkan NIM Mahasiswa' class='span8'>
<input type=submit class='btn btn-success pull-right span4' value=Tampilkan>
</div>
</div></div></form>";
if (! empty($nim)){
  $sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
  $qry=_query($sql) or die ();
  $ab=_num_rows($qry);
  if ($ab > 0){    
	$data=_fetch_array($qry);
	if (empty($data['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[Foto]"; }
	$PRODI=NamaProdi($data[kode_jurusan]);
	$kelas=NamaKelasa($data[IDProg]);
	$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
	$namaSemester=namaSemester($semester);
	$konsentrasi=strtoupper(NamaKonsentrasi($data[Kurikulum_ID]));
echo"<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NAMA</th><th> $data[Nama]</th>
	<th rowspan=4><img alt='$data[Nama]' src='$foto' width='150px' class='gambar pull-right'></th></tr>
	<tr><th>PROGRAM STUDI</th><th> $PRODI</th></tr>
	<tr><th>KELAS</th><th>$kelas</th></tr>
	<tr><th>KONSENTRASI</th><th>$konsentrasi</th></tr>
	</thead></table>";
		
echo"<legend>DATA KRS SEMESTER $namaSemester ( $semester )
	<div class='btn-group pull-right'>
	<a class='btn btn-inverse' href='cetakK-KRS-$tahun-$semester-$nim.html' target='_blank'>Cetak</a>
	</div></legend>
	<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NO</th><th>KODE</th><th>MATAKULIAH</th><th>KREDIT</th>
	</tr></thead>";
	$sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
	$no=0;
	$qry=_query($sql) or die ();
	while($data2=_fetch_array($qry)){
	$no++;
	$ruang=GetName("ruang","ID",$data[Ruang_ID],"Nama");
		$namaMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama"); 
	echo "<tr>
		<td align=center> $no</td>          
		<td>$kelompok - $data2[Jadwal_ID]</td>
		<td>$namaMtk</td>
		<td>$sksMtk SKS</td>
	</tr>";
$Tot=$Tot+$sksMtk;
}
echo "<tfoot><tr><td colspan='6'><b>Jumlah Kredit Yang Ditempuh : $Tot SKS</b></td></tr></tfoot></table>";
	} else {
ErrorMsg("Opps.. !!","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
  }
}else{
InfoMsg("Menu KRS Mahasiswa","Untuk Melihat data KRS, Silahkan pilih Tahun Akademik dan Masukkan NIM Mahasiswa..!");
}
tutup();
}

switch($_GET[PHPIdSession]){

  default:
    defaultbaakademikkrs();
  break;   

}
?>