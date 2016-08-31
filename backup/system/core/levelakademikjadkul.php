<script language="javascript" type="text/javascript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){// v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
	}
	//-->
</script>
<?php 
function deflevelakademikjadkul(){
buka("KAPRODI :: Jadwal Kuliah stie yapan Surabaya");
$tAktif=TahunAktif();
	$institusi= $_SESSION['Identitas'];
	$jurusan=$_SESSION['prodi'];
    $program=$_POST['program'];
    $tahun= (empty($_POST['tahun'])) ? $tAktif : $_POST['tahun'];
    $sms= $_POST['semester'];
echo "<form action='go-levelakademikjadkul.html' method='post' class='form-horizontal'>
<div class='well'><div class='row-fluid'>
<div class='span3'>
	<label>PROGRAM STUDI</label>
	<select name='jurusan' onChange='this.form.submit()' class='span12' disabled>
	<option value=''>- Pilih Prodi -</option>";
	$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d1=mysql_fetch_array($qryp)){
	$cek= ($d1['kode_jurusan']==$jurusan) ? 'selected' : '';
	echo "<option value='$d1[kode_jurusan]' $cek>  $d1[nama_jurusan]</option>";
	}
	echo"</select></div>
<div class='span3'>
	<label> TAHUN AKADEMIK </label>
	<select name='tahun' onChange='this.form.submit()' class='span12'>
	<option value=''>- Tahun -</option>";
	$sqlp="SELECT * FROM tahun WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d2=mysql_fetch_array($qryp)){
	$cek= ($d2['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d2[Tahun_ID]' $cek> $d2[Nama] </option>";
	}
	echo " </select></div>

<div class='span3'>
	<label>KELAS </label>
	<select name='program' onChange='this.form.submit()' class='span12'>
	<option value=''>- Pilih Kelas -</option>";
	$sqlp="SELECT * FROM program WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp) or die();
	while ($d2=mysql_fetch_array($qryp)){
	$cek= ($d2['ID']==$program) ? 'selected' : '';
	echo "<option value='$d2[ID]' $cek>  $d2[nama_program]</option>";
	}
	echo"</select></div>
<div class='span3'>
<label>SEMESTER </label>
<select name='semester' onChange='this.form.submit()' class='span12'>
	<option value=''>- Pilih Semester -</option>";
echo Semester(1,8, $sms);
	echo " </select></div>
</div>
</div>
</form>";
$PRODI=NamaProdi($jurusan);
$kelas=NamaKelasa($program);
echo"
<div class='row-fluid'>
<legend>
	<div class='pull-left'>
	PRODI : $PRODI :: $kelas :: Semester : $sms
	</div>
	<div class='btn-group pull-right'>
		<a class='btn btn-inverse' href='cetakJadwal-JadwalKuliah-$institusi-$tahun-$program-$jurusan-$sms.html' target='_blank'>Cetak</a>
	</div>
</legend>
</div><legend></legend>";
JadwalHarian("Senin",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Selasa",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Rabu",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Kamis",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Jumat",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Sabtu",$institusi,$jurusan,$program,$tahun,$sms);	
tutup();
}
function JadwalHarian($hari,$institusi,$jurusan,$program,$tahun,$sms){
echo"<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> $hari</div>
	<div class='panel-content panel-tables'>
<table class='table table-bordered table-striped'>  
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Waktu</th>
			<th>Ruang</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>";
		$sql="SELECT * FROM jadwal WHERE Identitas_ID='$institusi' AND Kode_Jurusan='$jurusan' AND Program_ID='$program' AND Hari='$hari' AND Tahun_ID='$tahun' AND semester='$sms' ORDER BY Jadwal_ID";
		$qry= _query($sql)or die ();
		while ($r=_fetch_array($qry)){  
		$no++;
		$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
		$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");
		$dosen1=NamaDosen($r[Dosen_ID]);
		$dosen2=NamaDosen($r[Dosen_ID2]); 
		echo "<tr>                            
			<td>$no</td>
			<td>$kelompok - $r[Kode_Mtk]</td>
			<td>$namaMtk</td>
			<td>$sksMtk</td>
			<td>1- $dosen1 <br>2- $dosen2</td>
			<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>
			<td>$ruang</td>
			<td>$sttus</td>
			<td>
			<div class='btn-group pull-right'>
			<button class='btn dropdown-toggle btn-mini' data-toggle='dropdown'>
			Aksi <span class='caret'></span>
			</button>
				<ul class='dropdown-menu'>
					<li><a href='get-levelakademikjadkul-DetailJadwal-$r[Jadwal_ID].html'>Detail Jadwal</a></li>
					<li><a href='get-levelakademikjadkul-DetailUjian-$r[Jadwal_ID].html'>Detail Ujian</a></li>
				</ul>
			</div>			
			</td>                    
		</tr>";        
	}
echo"</table></div></div>";
}

function DetailJadwal(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("KAPRODI :: Jadwal Kuliah Stie Yapan Surabaya");
$id = $_REQUEST['id'];
$w = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$identitas=GetName("identitas","Identitas_ID",$w[Identitas_ID],"Nama_Identitas");
$jurusan=GetName("jurusan","kode_jurusan",$w[Kode_Jurusan],"nama_jurusan");
$jenjang=GetName("jurusan","kode_jurusan",$w[Kode_Jurusan],"jenjang");
$kelas=GetName("program","ID",$w[Program_ID],"nama_program");
$tahun=GetName("tahun","Tahun_ID",$w[Tahun_ID],"Nama");
$mtk=GetName("matakuliah","Kode_mtk",$w[Kode_Mtk],"Nama_matakuliah");
$ruang=GetName("ruang","ID",$w[Ruang_ID],"Nama");
$semester= $w[semester];
$dosen1=NamaDosen($w[Dosen_ID]);
$dosen2=NamaDosen($w[Dosen_ID2]);
echo"<div class='panel-content'>
<legend>Detail Jadwal Kuliah
	<a class='btn btn-danger pull-right' href=go-levelakademikjadkul.html><i class'icon-undo'></i>Kembali</a>
</legend>
	<table class='table table-bordered table-striped'>     
     <tbody>
<tr>
	<td class='span6'>Institusi</td>
	<td class='span6'>$identitas</td>
</tr>
<tr>
	<td class='span6'> Program Studi</td>
	<td class='span6'>(&nbsp;$jenjang&nbsp;) &nbsp;&nbsp; $jurusan</td>
</tr> 
<tr>
	<td class='span6'> Kelas</td>
	<td class='span6'>$kelas</td>
</tr> 
<tr>
	<td class='span6'> Tahun Akademik</td>
	<td class='span6'>$tahun</td>
</tr> 
<tr>
	<td class='span6'> Semester</td>
	<td class='span6'>$semester</td>
</tr> 
<tr>
	<td class='span6'> Waktu Kuliah</td>
	<td class='span6'>Hari : <b>$w[Hari]</b>&nbsp;&nbsp;&nbsp;Jam : <b>$w[Jam_Mulai]</b> &nbsp;S/D :<b>$w[Jam_Selesai]</b></td>
</tr> 
<tr>
	<td class='span6'> Matakuliah</td>
	<td class='span6'>$mtk</td>
</tr>
<tr>
	<td class='span6'> Ruang</td>
	<td class='span6'>$ruang</td>
</tr>
<tr>
	<td class='span6'> Dosen I</td>
	<td class='span6'>$dosen1</td>
</tr>
<tr>
	<td class='span6'> Dosen II</td>
	<td class='span6'>$dosen2</td>
</tr> 
            
	</tbody></table></div>"; 
tutup();
}
function DetailUjian(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("KAPRODI :: Detail Jadwal Ujian");
$id = $_REQUEST['id'];
$w = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$tglUjiaUts=tgl_indo($w[UTSTgl]);
$tglUjiaUas=tgl_indo($w[UASTgl]);
$ruangUts=GetName("ruang","ID",$w[UTSRuang],"Nama");
$ruangUas=GetName("ruang","ID",$w[UASRuang],"Nama");
echo"<div class='panel-content'>
<legend>Detail Jadwal Ujian
	<a class='btn btn-danger pull-right' href=go-levelakademikjadkul.html><i class'icon-undo'></i>Kembali</a>
</legend>
<table class='table table-bordered table-striped'>   
	<thead><tr><th colspan='2'>Jadwal UTS</th></tr></thead>  
     <tbody>
<tr>
	<td class='span6'>Tanggal Ujian</td>
	<td class='span6'>$tglUjiaUts</td>
</tr>
<tr>
	<td class='span6'> Waktu</td>
	<td class='span6'>Hari : <b>$w[UTSHari]</b>&nbsp;&nbsp;&nbsp;Jam : <b>$w[UTSMulai]</b> &nbsp;S/D :<b>$w[UTSSelesai]</b></td>
</tr> 
<tr>
	<td class='span6'>Ruang Ujian</td>
	<td class='span6'>$ruangUts</td>
</tr>      
	</tbody></table>
<table class='table table-bordered table-striped'>   
	<thead><tr><th colspan='2'>Jadwal UAS</th></tr></thead>  
     <tbody>
<tr>
	<td class='span6'>Tanggal Ujian</td>
	<td class='span6'>$tglUjiaUas</td>
</tr>
<tr>
	<td class='span6'> Waktu</td>
	<td class='span6'>Hari : <b>$w[UASHari]</b>&nbsp;&nbsp;&nbsp;Jam : <b>$w[UASMulai]</b> &nbsp;S/D :<b>$w[UASSelesai]</b></td>
</tr> 
<tr>
	<td class='span6'>Ruang Ujian</td>
	<td class='span6'>$ruangUas</td>
</tr>      
	</tbody></table>

</div>";  
tutup();
}
switch($_GET[PHPIdSession]){
  
  default:
deflevelakademikjadkul();       				
  break;   

  case "DetailJadwal":
 DetailJadwal();   
  break;
 
  case "DetailUjian":
DetailUjian();  
  break;     
}
?>
