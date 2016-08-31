  <script language="javascript" type="text/javascript">
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
  </script>
<?php
function defakademiktahun(){
global $buat,$baca,$tulis,$hapus;
if($baca){
require_once("../librari/calender.php");
//tahun yang Aktif
$tahunAktif ="SELECT * FROM tahun a,event b WHERE a.Tahun_ID=b.TahunID AND a.Aktif='Y' AND b.aktif='Y'";
$ta		=_query($tahunAktif) or die();
$t		=_fetch_array($ta);
//default
$tahun		= (empty($_POST['tahun']))? $t['TahunID'] : $_POST['tahun'];
$semester	= (empty($_POST['smster']))? $t['Semester'] : $_POST['smster'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
buka("Kalender Akademik stie yapan Surabaya");
echo "<div class='row-fluid'>
		<div class='input-prepend input-append  pull-left'>
	<form action='go-akademiktahun.html' method='post'>
	<span class='add-on'> Tahun </span>
	<select name='tahun' onChange='this.form.submit()'>
	<option value='0'>- Pilih Tahun Akademik -</option>";
	$sqlp="SELECT * FROM tahun ORDER BY Tahun_ID";
	$qryp=_query($sqlp) or die();
	while ($d=_fetch_array($qryp)){
	$cek= ($d['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d[Tahun_ID]' $cek> $d[Nama]</option>";
	}
	echo"</select>
	<span class='add-on'> Semester </span>
	<select name='smster' onChange='this.form.submit()'>
	<option value='0'>- Pilih Semester -</option>";
	$sqlp="SELECT * FROM evensemester ORDER BY smsterID";
	$qryp=_query($sqlp) or die();
	while ($d1=_fetch_array($qryp)){
	$cek= ($d1['smsterID']==$semester) ? 'selected' : '';
	echo "<option value='$d1[smsterID]' $cek>  $d1[Nama]</option>";
	}
	echo"</select></form></div>
		<div class='btn-group pull-right'>
		<a class='btn btn-success' href='action-akademiktahun-editTahun-1.html'>Tahun Akademik</a>
		<a class='btn' href='aksi-akademiktahun-Kalender.html'>Kalender Akademik</a>
		</div>
	</div>
<legend></legend>";
echo"<div class='row-fluid'><div class='span7'>
<legend>        
	<span> $NamaTahun SEMESTER <strong>$NamaSemester </strong></span>
<div class='btn-group pull-right'>
<a class='btn btn-mini btn-inverse iframe' href='cetkal-CetakKalender-$tahun-$semester.html'><i class='icon-print'></i>Cetak</a>
</div>
</legend>";

$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' GROUP BY MONTH(EndDate),YEAR(EndDate) ORDER BY YEAR(EndDate),MONTH(EndDate) ASC";
$qryd= _query($sql)or die ();
$ab=_num_rows($qryd);
$col = 2;
echo"<div class='row-fluid'>";
$cnt = 0;
	for($i=1;$i<=$ab;$i++)
	{
  if ($cnt >= $col) {
      echo "</div><div class='row-fluid'>";
      $cnt = 0;
  }
echo"<div class='span6'>";
	$d=_fetch_array($qryd);
	$bln=substr("$d[EndDate]",5,2);
	$thn=substr("$d[EndDate]",0,4);

	$blns=substr("$d[StartDate]",5,2);
	$thns=substr("$d[StartDate]",0,4);
	$namaBulan=getBulan3($bln);
	$calendar = new SimpleCalendar();
	$calendar->setStartOfWeek('Monday');
	$calendar->setDate($d['EndDate']);

	$query = "SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' ORDER BY StartDate,EventId";
	$result = _query($query) or die('cannot get results!');
	$no=0;
	while ($r=_fetch_array($result)){
	$no++;
	$calendar->addDailyHtml( $r[warna], $r[StartDate], $r[EndDate]);
	}
$calendar->show(true);
echo"</div>";
 $cnt++;
	}
echo"</div>";
echo"</div><div class='span5'>
<legend>Kegiatan Akademik</legend>
<table class='table'>";
	$sqld="SELECT * FROM evenjenis ORDER BY jenisID";
	$qryd= _query($sqld)or die ();
	while ($d=_fetch_array($qryd)){
echo"<thead>
	<tr><th>$d[Nama]</th></tr>
</thead><tbody>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' AND JenisEvent='$d[jenisID]' ORDER BY StartDate,EventId";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){       	
	$no++;
	echo "<tr><td><i class='icon-file'></i> <a href='actions-akademiktahun-editKalender-0-$r[EventId].html'><span style=\"font-family:arial;color:$r[warna]\" >$r[NamaEvent]</span></a></td></tr>";        
	}
}
echo"</tbody></table></div>
</div>";
}else{
ErrorAkses();
}
tutup();
}
function editTahun(){
global $buat,$baca,$tulis,$hapus,$today,$BulanIni,$TahunIni,$saiki;
$nextThn=$TahunIni+1;
$tutup="$nextThn-$BulanIni-$today";
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('tahun', 'Tahun_ID', $id, '*');
    $jdl = "Edit Tahun Akademik";
    $hiden = "<input type=hidden name='id' value='$w[Tahun_ID]'>";
  } else {
	$ThnID=IDtahun();
    $w = array();
    $w['Tahun_ID']= $ThnID;
    $w['Identitas_ID']= $_SESSION[Identitas];
    $w['TglBuka']= $saiki;
    $w['TglTutup'] = $tutup;
    $w['Nama'] = '';
    $w['Aktif'] = '';
    $jdl = "Tambah Tahun Akademik";
    $hiden = "<input type=hidden name='id' value='$ThnID'>";
  }
	$tahundepan=$TahunIni+1;
buka("Tahun Akademik");
if($buat OR $tulis){
   echo"<fieldset>
<div class='row-fluid'>
	<div class='span6'>
<legend>Tahun Akademik</legend>
<table class='table table-bordered table-striped'>
<thead><tr><th>No</th><th>ID Tahun</th><th>Nama Tahun</th><th>Status</th><th>Aksi</th></tr></thead>";
	$sql="SELECT * FROM tahun WHERE Identitas_ID='$_SESSION[Identitas]'";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';        	
	$no++;
	echo "<tr bgcolor=$warna>                            
		<td>$no</td>
		<td>$r[Tahun_ID]</td>
		<td>$r[Nama]</td>
		<td><center>$sttus</center></td>
		<td>
		<center>
			<div class='btn-group'>
		<a class='btn btn-mini btn-inverse' href='actions-akademiktahun-editTahun-0-$r[Tahun_ID].html'>Edit</a>
			</div>
		</center>
		</td></tr>";        
	}
echo"</table> 
</div>
<div class='span6'>
<legend>$jdl</legend>
<form action='aksi-akademiktahun-simpanTahun.html' method='post' id='example_form'>
<input type=hidden name='md' value='$md'>
$hiden
	<div class='control-group'>
		<label class='control-label'>Institusi</label>
			<div class='controls'>
			<select name='identitas' class='span12'>
            <option value=''>- Pilih Institusi -</option>";
    	  $sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
    	  $qryp=_query($sqlp) or die();
    	  while ($d=_fetch_array($qryp)){
			$cek = ($d['Identitas_ID']==$w['Identitas_ID']) ? 'selected' : '';
          echo "<option value='$d[Identitas_ID]' $cek>$d[Nama_Identitas]</option>";
    		}
    echo"</select></div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Nama Tahun Akademik</label>
	<div class='controls'>
	<input type=text name=nama value='$w[Nama]' class='span12' placeholder='Contoh : TA $TahunIni/$tahundepan'>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Tanggal Buka </label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[TglBuka]",8,2);
		combotgl(1,31,'tglB',$get_tgl2);
        $get_bln2=substr("$w[TglBuka]",5,2);
        combonamabln(1,12,'blnB',$get_bln2);
        $get_thn2=substr("$w[TglBuka]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnB',$get_thn2);
	echo"</div>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'>Tanggal Tutup</label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[TglTutup]",8,2);
		combotgl(1,31,'tglT',$get_tgl2);
        $get_bln2=substr("$w[TglTutup]",5,2);
        combonamabln(1,12,'blnT',$get_bln2);
        $get_thn2=substr("$w[TglTutup]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnT',$get_thn2);
	echo"</div>
	</div>
	</div>

<div class='control-group row-fluid'>
	<label class='control-label'>Status</label>
	<div class='controls'>";
if($w['Aktif'] == 'Y'){
	echo"<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N ";
}else{
	echo"<input type=radio name=aktif value='Y'>Y 
		<input type=radio name=aktif value='N' checked>N ";
}
	echo"</div>
</div>
	<div class='form-actions'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-akademiktahun.html';\">
	</div></center>
	</div>
</form>
</div></div></fieldset>"; 
}elseif($baca){
DetailTahun();
}else{
ErrorAkses();
} 
tutup();
}
function DetailTahun() {
echo"<div class='panel-content panel-tables'>
<legend>Tahun Akademik  <a class='btn btn-danger pull-right' href='go-akademiktahun.html'>Kembali</a> </legend>
<table class='table table-bordered table-striped'>
<thead><tr><th>No</th><th>ID Tahun</th><th>Nama Tahun</th><th>Status</th></tr></thead>";
	$sql="SELECT * FROM tahun WHERE Identitas_ID='$_SESSION[Identitas]'";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';        	
	$no++;
	echo "<tr bgcolor=$warna>                            
		<td>$no</td>
		<td>$r[Tahun_ID]</td>
		<td>$r[Nama]</td>
		<td><center>$sttus</center></td>
		</tr>";        
	}
echo"</table> 
</div>";
}
function DetailKalender($id) {
$w = GetFields('event', 'EventId', $id, '*');
$NamaTahun=strtoupper(GetName("tahun","Tahun_ID",$w[TahunID],"Nama"));
$NamaSemester=strtoupper(GetName("evensemester","smsterID",$w[Semester],"Nama"));
$JenisEvent=strtoupper(GetName("evenjenis","jenisID",$w[JenisEvent],"Nama"));
$mulai=tgl_indo($w[StartDate]);
$sampai=tgl_indo($w[EndDate]);
$tglEvent=($w[EndDate]==$w[StartDate])? $mulai: "$mulai - $sampai";
$Status=($w['aktif'] == 'Y')? "AKTIF": "NON-AKTIF";
echo"<legend>$w[NamaEvent] <a class='btn btn-danger pull-right' href='go-akademiktahun.html'>Kembali</a> </legend><div class='panel-content panel-tables'>";
echo"<table class='table table-bordered table-striped'>     
		<tr><td>Tahun Akademik</td><td>$NamaTahun</td></tr>
		<tr><td>Semester</td><td>$NamaSemester</td></tr>
		<tr><td>Jenis Event</td><td>$JenisEvent</td></tr>
		<tr><td>Tanggal</td><td>$tglEvent</td></tr>
		<tr><td>Status</td><td>$Status</td></tr>
</table></div>";
}
function simpanTahun() {
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$nama		 	= $_POST['nama']; 
	$identitas		= $_POST['identitas'];   
	$TglBuka=sprintf("%02d%02d%02d",$_POST[thnB],$_POST[blnB],$_POST[tglB]);
	$TglTutup=sprintf("%02d%02d%02d",$_POST[thnT],$_POST[blnT],$_POST[tglT]);
	$aktif 			= $_POST['aktif'];
  if ($md == 0) {
	$update=_query("UPDATE tahun SET
			Nama			= '$nama',
			Identitas_ID	= '$identitas',
			TglBuka			= '$TglBuka',
			TglTutup		= '$TglTutup',
			Aktif			= '$aktif'
			WHERE Tahun_ID	= '$id'");
    if ($update) {
	if ($aktif=="Y"){
	$updateaLL=_query("UPDATE tahun SET Aktif = 'N'
			WHERE Tahun_ID	NOT IN ('$id')");
		}
	}
 PesanOk("Update Tahun Akademik","Tahun Akademik Berhasil di Update ","action-akademiktahun-editTahun-1.html");
  } else {
    $ada = GetFields('tahun', 'Tahun_ID', $id, '*');
    if (empty($ada)) {
     $query = "INSERT INTO tahun(Tahun_ID,Identitas_ID,TglBuka,TglTutup,Nama,Aktif) 
		VALUES('$id','$identitas','$TglBuka','$TglTutup','$nama','$aktif')";
	$insert=_query($query);
	if ($insert) {
	if ($aktif=="Y"){
	$updateaLL=_query("UPDATE tahun SET Aktif = 'N'
			WHERE Tahun_ID NOT IN ('$id')");
		}
	}
	PesanOk("Tambah Tahun Akademik","Tahun Akademik Baru Berhasil di Simpan ","action-akademiktahun-editTahun-1.html");
    } else{
	PesanEror("Tahun Akademik Gagal disimpan", "Tahun Akademik Sudah ada dalam database");
	}
  }
}
function Kalender(){
global $buat,$baca,$tulis,$hapus;
//tahun yang Aktif
$tahunAktif ="SELECT * FROM tahun a,event b WHERE a.Tahun_ID=b.TahunID AND a.Aktif='Y' AND b.aktif='Y'";
$ta		=_query($tahunAktif) or die();
$t		=_fetch_array($ta);
//default
$tahun= (empty($_POST['tahun']))? $t['TahunID'] : $_POST['tahun'];
$semester= (empty($_POST['smster']))? $t['Semester'] : $_POST['smster'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
if($baca){
buka("Kalender Akademik");
echo "<form action='aksi-akademiktahun-Kalender.html' method='post'>
<div class='input-prepend input-append'>
	<span class='add-on'> Pilih Tahun Akademik </span>
	<select name='tahun' onChange='this.form.submit()'>
	<option value='0'>- Pilih Tahun Akademik -</option>";
	$sqlp="SELECT * FROM tahun ORDER BY Tahun_ID";
	$qryp=_query($sqlp) or die();
	while ($d=_fetch_array($qryp)){
	$cek= ($d['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d[Tahun_ID]' $cek> $d[Nama]</option>";
	}
	echo"</select>
	<span class='add-on'> Semester </span>
	<select name='smster' onChange='this.form.submit()'>
	<option value='0'>- Pilih Semester -</option>";
	$sqlp="SELECT * FROM evensemester ORDER BY smsterID";
	$qryp=_query($sqlp) or die();
	while ($d1=_fetch_array($qryp)){
	$cek= ($d1['smsterID']==$semester) ? 'selected' : '';
	echo "<option value='$d1[smsterID]' $cek>  $d1[Nama]</option>";
	}
	echo"</select>
	</div>
</form><legend></legend>";
echo"<div class='panel'>
 <div class='panel-header'>  Kalender Akademik Semester $NamaSemester :: $NamaTahun
<div class='btn-group pull-right'>";
if($buat){
echo"<a class='btn btn-mini btn-success' href='action-akademiktahun-editKalender-1.html'><i class='icon-plus-sign'></i>Tambah</a>";
}
echo"<a class='btn  btn-mini  btn-danger' href='go-akademiktahun.html'>Kembali</a>
		</div>
</div>
<div class='panel-content panel-tables'><table class='table table-bordered table-striped'>";
	$sqld="SELECT * FROM evenjenis ORDER BY jenisID";
	$qryd= _query($sqld)or die ();
	while ($d=_fetch_array($qryd)){
echo"<thead><tr><th colspan='4'>$d[Nama]</th></tr>
<tr><th>No</th><th>Nama Kegiatan</th><th><center>Tanggal</center></th><th>Aksi</th></tr>
</thead>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' AND JenisEvent='$d[jenisID]' ORDER BY StartDate";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){
	$start=tgl_indo($r['StartDate']);
	$end=tgl_indo($r['EndDate']);
	$tanggal = ($r['StartDate']==$r['EndDate'])? $start : $start.'-'.$end;        	
	$no++;
	echo "<tr>                            
		<td>$no</td>
		<td><span style=\"font-family:arial;color:$r[warna]\" >$r[NamaEvent]</span></td>
		<td><center>$tanggal</center></td>
		<td>
		<center>
			<div class='btn-group'>";
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='actions-akademiktahun-editKalender-0-$r[EventId].html'>Edit</a>";
}
if($hapus){
echo"<a class='btn btn-mini btn-danger' href='get-akademiktahun-hapusKalender-$r[EventId].html' onClick=\"return confirm('Anda yakin akan Menghapus data kalender $r[NamaEvent] ?')\">Hapus</a>";
}
echo"</div>
		</center>
		</td></tr>";        
	}
}
echo"</table></div></div>";
}else{ErrorAkses();}
tutup();
}
function editKalender(){
global $buat,$baca,$tulis,$hapus,$today,$BulanIni,$TahunIni,$saiki;
buka("Kalender Akademik Stie Yapan Surabaya");


if($baca && $buat && $tulis){
$nextThn=$TahunIni+1;
$tutup="$nextThn-$BulanIni-$today";
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('event', 'EventId', $id, '*');
    $jdl = "Edit Event Akademik";
    $hiden = "<input type=hidden name='id' value='$w[EventId]'>";
  } else {
	$IDeven=IDeven();
    $w = array();
    $w['EventId']= $IDeven;
    $w['TahunID']= '';
    $w['JenisEvent']= '';
    $w['Semester'] = '';
    $w['NamaEvent'] = '';
    $w['StartDate'] = $saiki;
    $w['EndDate'] = $saiki;
    $w['warna'] = '#8fff00';
    $w['aktif'] = 'N';
    $jdl = "Tambah Event Akademik";
    $hiden = "<input type=hidden name='id' value='$IDeven'>";
  }
	$tahundepan=$TahunIni+1;
	if($baca){
		if ($md == 0){
		DetailKalender($_REQUEST['id']);
		}
	}else{
	ErrorAkses();
	}
echo"<fieldset>
<div class='row-fluid'>
<div class='span12'>
<legend>$jdl</legend>
<form action='aksi-akademiktahun-simpanKalender.html' method='post' class='form-horizontal' id='example_form'>
<input type=hidden name='md' value='$md'>
$hiden
	<div class='control-group'>
		<label class='control-label'>Tahun Akademik</label>
			<div class='controls'>
			<select name='tahun' class='span12'>
            <option value='0'>- Pilih Tahun Akademik -</option>";
			$sqlp="SELECT * FROM tahun ORDER BY Tahun_ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
			$cek= ($d['Tahun_ID']==$w['TahunID']) ? 'selected' : '';
			echo "<option value='$d[Tahun_ID]' $cek> $d[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Semester</label>
			<div class='controls'>
			<select name='semester' class='span12'>
            <option value='0'>- Pilih Semester -</option>";
			$sqlp="SELECT * FROM evensemester ORDER BY smsterID";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
			$cek= ($d1['smsterID']==$w['Semester']) ? 'selected' : '';
			echo "<option value='$d1[smsterID]' $cek>  $d1[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Jenis Event</label>
			<div class='controls'>
			<select name='jnEven' class='span12'>
            <option value='0'>- Pilih Jenis Event Akademik -</option>";
			$sqlp="SELECT * FROM evenjenis ORDER BY jenisID";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
			$cek= ($d1['jenisID']==$w['JenisEvent']) ? 'selected' : '';
			echo "<option value='$d1[jenisID]' $cek>  $d1[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Nama Event</label>
	<div class='controls'>
	<input type=text name=nama value='$w[NamaEvent]' class='span12' placeholder='Nama Agenda / Event Akademik'>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Tanggal Mulai </label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[StartDate]",8,2);
		combotgl(1,31,'tglS',$get_tgl2);
        $get_bln2=substr("$w[StartDate]",5,2);
        combonamabln(1,12,'blnS',$get_bln2);
        $get_thn2=substr("$w[StartDate]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnS',$get_thn2);
	echo"</div>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'>Tanggal Selesai</label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[EndDate]",8,2);
		combotgl(1,31,'tglE',$get_tgl2);
        $get_bln2=substr("$w[EndDate]",5,2);
        combonamabln(1,12,'blnE',$get_bln2);
        $get_thn2=substr("$w[EndDate]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnE',$get_thn2);
	echo"</div>
	</div>
	</div>

<div class='control-group row-fluid'>
<div class='span6'>	<label class='control-label'>Warna</label>
	<div class='controls'>
<input type='text' name='warna' class='span12' value='$w[warna]' id='cp1' >
</div></div>

<div class='span6'>
<label class='control-label'>Status</label>
	<div class='controls'>";
if($w['aktif'] == 'Y'){
	echo"<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N ";
}else{
	echo"<input type=radio name=aktif value='Y'>Y 
		<input type=radio name=aktif value='N' checked>N ";
}
	echo"</div>
</div>
</div>
	<div class='form-actions'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='aksi-akademiktahun-Kalender.html';\">
	</div></center>
	</div>
</form>
</div></div></fieldset>"; 
}else{ErrorAkses();}
tutup();
}
function CetakKalender() {
require("../librari/pdf/html2fpdf.php");
$htmlFile = "cetkal-CetakKalender-TA32013-1.html";
$file = fopen($htmlFile,"r");
$size_of_file = filesize($htmlFile);
$buffer = fread($file, $size_of_file);
fclose($file);
$pdf=new HTML2FPDF();
$pdf->AddPage();
$pdf->WriteHTML($buffer);
$pdf->Output('doc.pdf','I');
}
function simpanKalender() {
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$nama		 	= $_POST['nama']; 
	$tahun			= $_POST['tahun'];   
	$semester		= $_POST['semester'];   
	$jenis			= $_POST['jnEven'];   
	$StartDate=sprintf("%02d%02d%02d",$_POST[thnS],$_POST[blnS],$_POST[tglS]);
	$EndDate=sprintf("%02d%02d%02d",$_POST[thnE],$_POST[blnE],$_POST[tglE]);
	$warna 			= $_POST['warna'];
	$aktif 			= $_POST['aktif'];
  if ($md == 0) {
	$update=_query("UPDATE event SET
			TahunID			= '$tahun',
			JenisEvent		= '$jenis',
			Semester		= '$semester',
			NamaEvent		= '$nama',
			StartDate		= '$StartDate',
			EndDate			= '$EndDate',
			warna			= '$warna',
			aktif			= '$aktif'
			WHERE EventId	= '$id'");
	if ($update){
	if ($aktif=="Y"){
	$updateaLL=_query("UPDATE event SET aktif = 'N'
			WHERE TahunID='$tahun' AND Semester NOT IN ('$semester')");
		}
	}
	PesanOk("Update Event Kalender Akademik","Event Akademik Berhasil di Update ","aksi-akademiktahun-Kalender.html");
  } else {
    $query = "INSERT INTO event(EventId,TahunID,JenisEvent,Semester,NamaEvent,StartDate,EndDate,warna,aktif) 
		VALUES('$id','$tahun','$jenis','$semester','$nama','$StartDate','$EndDate','$warna','$aktif')";
	$insert=_query($query);
	if ($insert){
	if ($aktif=="Y"){
	$updateaLL=_query("UPDATE event SET aktif = 'N'
			WHERE TahunID='$tahun' AND Semester NOT IN ('$semester')");
		}
	}
	PesanOk("Tambah Event Kalender Akademik","Event Akademik Baru Berhasil di Simpan ","aksi-akademiktahun-Kalender.html");
  }
}

switch($_GET[PHPIdSession]){

  default:
defakademiktahun();
  break;  

  case "editTahun":
editTahun(); 
  break;

case"simpanTahun":
simpanTahun();
  break;

case "Kalender":
Kalender(); 
  break;

case "editKalender":
editKalender(); 
  break;

case"simpanKalender":
simpanKalender();
  break;

case"CetakKalender":
CetakKalender();
  break;  

 case "hapusKalender":
      $sql=_query("DELETE FROM event WHERE EventId='$_GET[id]'");
 PesanOk("Hapus Kalender Akademik","Kalender Akademik Berhasil di Hapus ","aksi-akademiktahun-Kalender.html");
  break;
}
?>
