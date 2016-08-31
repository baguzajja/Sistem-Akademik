  <script language="javascript" type="text/javascript">
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
  </script>
<?php
function defhumasKlderAkademik(){
require_once("../librari/calender.php");
buka("HUMAS :: Kalender Akademik stie yapan Surabaya");
//tahun yang Aktif
$tahunAktif ="SELECT * FROM tahun a,event b WHERE a.Tahun_ID=b.TahunID AND a.Aktif='Y' AND b.aktif='Y'";
$ta		=_query($tahunAktif) or die();
$t		=_fetch_array($ta);
//default
$tahun= (empty($_POST['tahun']))? $t['TahunID'] : $_POST['tahun'];
$semester= (empty($_POST['smster']))? $t['Semester'] : $_POST['smster'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
echo "<div class='row-fluid'>
		<div class='input-prepend input-append  pull-left'>
	<form action='go-humasKlderAkademik.html' method='post'>
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
	</div>
<legend></legend>";
echo"<div class='row-fluid'><div class='span7'>
<legend>        
	<span> $NamaTahun Semester <strong>$NamaSemester </strong></span>
<div class='btn-group pull-right'>
<a class='btn btn-mini btn-inverse' href='cetkal-CetakKalender-$tahun-$semester.html' target='_blank'><i class='icon-print'></i>Cetak</a>
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
	$calendar->setDate($d[EndDate]);

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
	echo "
	<tr><td><i class='icon-file'></i> <span style=\"font-family:arial;color:$r[warna]\" >$r[NamaEvent]</span></td></tr>";        
	}
}
echo"</tbody></table></div>
</div>";
tutup();
}

switch($_GET[PHPIdSession]){

  default:
defhumasKlderAkademik();
  break;  

}
?>
