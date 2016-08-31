<?php defined('_FINDEX_') or die('Access Denied');
require_once("librari/calender.php");
//tahun yang Aktif
$tahunAktif ="SELECT * FROM tahun WHERE Aktif='Y'";
$ta		=_query($tahunAktif) or die();
$t		=_fetch_array($ta);
//default
$tahun		= (empty($_POST['tahun']))? $t['Tahun_ID'] : $_POST['tahun'];
$semester	= (empty($_POST['smster']))? 1 : $_POST['smster'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>STIE YAPAN SURABAYA</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Styles -->
<?php 
	addCss('themes/css/bootstrap.css'); 
	addCss('themes/css/bootstrap-responsive.css');  
	addCss('themes/css/bootstrap-overrides.css');  
	addCss('themes/css/ui-lightness/jquery-ui-1.8.21.custom.css');  
	//addCss('themes/css/yapan.css');  
	addCss('themes/css/yapan-responsive.css');  
?>
<link href='themes/css/kalender.css' rel='stylesheet' type='text/css' media='all' />
</head>
<body>
<form method="post" id="form">
<div>
<?php 
echo "<div class='input-prepend input-append'>
	<span class='add-on'> TAHUN </span>
	<select name='tahun' onChange='this.form.submit()' id='prependedInput'>
	<option value=''>- Pilih Tahun Akademik -</option>";
	$sqlp="SELECT * FROM tahun ORDER BY Tahun_ID";
	$qryp=_query($sqlp) or die();
	while ($d=_fetch_array($qryp)){
	$cek= ($d['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d[Tahun_ID]' $cek> $d[Nama]</option>";
	}
	echo"</select>
	<span class='add-on'> SEMESTER </span>
	<select name='smster' onChange='this.form.submit()'>
	<option value=''>- Pilih Semester -</option>";
	$sqlp="SELECT * FROM evensemester ORDER BY smsterID";
	$qryp=_query($sqlp) or die();
	while ($d1=_fetch_array($qryp)){
	$cek= ($d1['smsterID']==$semester) ? 'selected' : '';
	echo "<option value='$d1[smsterID]' $cek>  $d1[Nama]</option>";
	}
	echo"</select></div><br><br>";
?>
	<div class="row-fluid">
		<div class="span12">
<div class="tab-content">
<?php 

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
?>
	</div></div>
		
	</div>
    <hr>
    <div class="row-fluid">
    <div class="span12">
<div class="widget widget-accordion">
	<div class='widget-header'>						
		<h3><i class='icon-calendar'></i>KETERANGAN KALENDER AKADEMIK</h3>	
	</div>
<?php 
echo"<table class='month'>";
	$sqld="SELECT * FROM evenjenis ORDER BY jenisID";
	$qryd= _query($sqld)or die ();
	while ($d=_fetch_array($qryd)){
    $judulan=strtoupper($d[Nama]);
	echo"<tr'>
			<th colspan='3'> $judulan </th> 
		</tr>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' AND JenisEvent='$d[jenisID]' ORDER BY StartDate,EventId";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){
	if($r['StartDate']==$r['EndDate']){
		$tanggal=tgl_indo($r['StartDate']);
	}else{
		$start=tgl_indo($r['StartDate']);
		$end=tgl_indo($r['EndDate']);
		$tanggal=$start.'&nbsp;<b>s/d</b>&nbsp;'.$end ;
	}
	$warna=$r[warna];
	$no++;
	echo "<tr>
			<td bgcolor='".$warna."'> &nbsp;&nbsp; &nbsp;&nbsp; </td> 
			<td style='text-align:left;'>&nbsp;&nbsp; <b>$tanggal </b></td> 
			<td style='text-align:left;'>&nbsp;&nbsp;  $r[NamaEvent]</td> 
		</tr>";        
	}
}
echo"</table>";
?>
		</div></div></div>
</div>
</form>
<!-- Javascript -->
	<?php 
		addJs('themes/js/jquery-1.7.2.min.js'); 
		addJs('themes/js/jquery-ui-1.8.21.custom.min.js'); 
		addJs('themes/js/jquery.ui.touch-punch.min.js'); 
		addJs('themes/js/bootstrap.js'); 
		addJs('themes/js/yapan.js'); 
	?>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
  </body>
</html>