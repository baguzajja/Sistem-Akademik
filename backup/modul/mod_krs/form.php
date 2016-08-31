<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
$tAktif		=TahunAktif();
$tahun 		=$_GET['md'];
$jurusan	=$_GET['id'];
$program	=$_GET['do'];
$semester 	=$_GET['di'];
$nim 		=$_GET['ke'];

$data = GetFields('mahasiswa', 'NIM', $nim, '*'); 
$Kons=($jurusan=='61101') ? 42:41; 

?>
<div class="row">
<div class="span12">
<div class="widget widget-table">
	<div class="widget-header">	      				
		<h3><i class='icon-plus'></i>TAMBAH KRS</h3>	
	</div>
	
<?php
echo"<form class='form-horizontal' method='post'>
<div class='widget-content'>
<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th>KODE</th>
	<th>MATAKULIAH </th><th>KREDIT</th><th>PENANGGUNG JAWAB</th><th><center><input type='checkbox' id='checkall' class='ui-tooltip' data-placement='top' title='Ambil Semua'></center></th></tr></thead>";  
	$sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND Jurusan_ID='$jurusan' AND Semester='$semester' AND Kurikulum_ID IN ($Kons,$data[Kurikulum_ID]) ORDER BY Matakuliah_ID";
	$no=0;
	$qry=_query($sql) or die ();
	while($m=_fetch_array($qry)){
	$no++;
	$sqlr="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' AND Jadwal_ID='$m[Matakuliah_ID]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	if ($cocok==1){ $cek="disabled"; } else { $cek=""; } 
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$m[KelompokMtk_ID],"Nama");
		$dosen1=NamaDosen($m[Penanggungjawab]); 
echo"<input type=hidden name=NIM value=$nim>
	<input type=hidden name=tahun value=$tahun>
	<input type=hidden name=kode_jurusan value=$m[Jurusan_ID]>               
	<input type=hidden name=sks value=$m[SKS]>
	<input type=hidden name=semester value=$m[Semester]>
	<input type=hidden name=kelas value=$program>
	<tr><td>$no</td>
		<td>$kelompok - $m[Kode_mtk]</td>
		<td>$m[Nama_matakuliah]</td>
		<td>$m[SKS] SKS</td>
		<td>$dosen</td>";
echo"<td><center><input name='Kode_mtk[]' type='checkbox' value='$m[Matakuliah_ID]' class='ui-tooltip' data-placement='left' title='Ambil Matakuliah $m[Nama_matakuliah]'  $cek></center></td></tr>";
$Tot=$Tot+$m[SKS];
	} 
echo"</table></div>
<div class='widget-toolbar'>
<div class='row-fluid'>
<div class='span6'>
</div>
<div class='span3'>
<button class='btn  btn-large' disabled>
Total : $Tot SKS
</button>
</div>
<div class='span3'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='AMBIL' name='simpanKrs'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-krs.html';\">
</div>
</div>
</div>		
</div>		

";
?>					
</div></form></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>