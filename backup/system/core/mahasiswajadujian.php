 <script language="javascript" type="text/javascript">
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
  </script>
<?php
function defmahasiswajadujian(){
buka("Jadwal Kuliah stie yapan Surabaya");
$w = GetFields('mahasiswa', 'NIM', $_SESSION[yapane], '*');
	$tAktif=TahunAktif();
	$institusi= $_SESSION['Identitas'];
	$jurusan=$_SESSION[prodi];
    $program=$w['IDProg'];
    $tahun= (empty($_POST['tahun'])) ? $tAktif : $_POST['tahun'];
    $sms= $_POST['semester'];
echo"<div class='row-fluid'>
<form action='go-mahasiswajadujian.html' method='post' class='form-horizontal'>
<div class='span4'>
	<div class='pull-left'>
	<select name='tahun' onChange='this.form.submit()' class=''>
	<option value=''>- Tahun -</option>";
	$sqlp="SELECT * FROM tahun WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d2=mysql_fetch_array($qryp)){
	$cek= ($d2['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d2[Tahun_ID]' $cek> $d2[Nama] </option>";
	}
	echo " </select>
	</div>
	</div>
	<div class='span4'>
<select name='semester' onChange='this.form.submit()' class='span12'>
	<option value=''>- Pilih Semester -</option>";
$pu=($jurusan=='61101') ? 4:8;
echo Semester(1,$pu, $sms);
	echo " </select>
</div>
	<div class='span4'>
	<div class='btn-group pull-right'>
	<a class='btn btn-inverse' href='cetakJadwal-JadwalKuliah-$institusi-$tahun-$program-$jurusan-$sms.html' target='_blank'>Cetak</a>
	</div>
	</div>
</form>
</div><br><legend></legend>";
JadwalHarian("Senin",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Selasa",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Rabu",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Kamis",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Jumat",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Sabtu",$institusi,$jurusan,$program,$tahun,$sms);	
tutup();
}
function ujian(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Jadwal Ujian");
	$id = $_REQUEST['id'];
    $ed = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$tglUas=tgl_indo($ed[UTSTgl]);
$tglUts=tgl_indo($ed[UASTgl]);
echo"<legend> Jadwal UTS </legend>
<table class='table table-bordered table-striped'>  
	<tr>
		<th>Tanggal Ujian</th>
		<td>$tglUas</td>
	</tr>
<tr>
	<th>Hari</th>
	<td>$ed[UTSHari]</td>
</tr>
<tr>
	<th>Jam</th>
	<td>$ed[UTSMulai] s/d $ed[UTSSelesai]</td>
</tr>
<tr>
	<th>Ruang</th>
	<td>$ed[UTSRuang]</td>
</tr>
</table>";
echo"<legend>Jadwal UAS</legend>
<table class='table table-bordered table-striped'>  
	<tr>
		<th>Tanggal Ujian</th>
		<td>$tglUts</td>
	</tr>
<tr>
	<th>Hari</th>
	<td>$ed[UASHari]</td>
</tr>
<tr>
	<th>Jam</th>
	<td>$ed[UASMulai] s/d $ed[UASSelesai]</td>
</tr>
<tr>
	<th>Ruang</th>
	<td>$ed[UASRuang]</td>
</tr>
</table>";  
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
			<a class='btn btn-mini' href='get-mahasiswajadujian-ujian-$r[Jadwal_ID].html'>Ujian</a>
			</div>			
			</td>                    
		</tr>";        
	}
echo"</table></div></div>";
}

//parameter
switch($_GET[PHPIdSession]){
  default:
    defmahasiswajadujian();			
  break;   
	case "ujian":
ujian();
	break; 
}
?>