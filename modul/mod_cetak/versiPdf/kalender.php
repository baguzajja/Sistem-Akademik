<style type="text/css">
<!--
table.month{
    width:100%;
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table.ket td{
    border:1px solid #ddd;
    color:#333;
	padding:1px;
}

table.ket th {
    padding:1px;
	background-image: url(themes/img/hbg.gif);
	background-repeat: repeat-x;
    color:#fff;
	text-align:center;
}
table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:center;
}

table.month th {
    padding:5px;
	background-image: url(themes/img/hbg.gif);
	background-repeat: repeat-x;
    color:#fff;
	text-align:center;
}

table.month td.pilih{
    color:#FFF;
	font-weight:bold;
}
td.days{
    background-color:#eeeeee;
}
table.month td.minggu{
	color:#ee0202;
	font-weight:bold;
}
    table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    div.note {border: solid 1mm #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 2mm; width: 100%; }
    ul.main { width: 95%; list-style-type: square; }
    ul.main li { padding-bottom: 2mm; }
    h1 { text-align: center; font-size: 20mm}
    h3 { text-align: center; font-size: 14mm}
-->
</style>
<page backtop='10mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 12pt'>
<?php 
require_once("librari/calender.php");
$tahun		= $_GET['md'];
$semester	= $_GET['id'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama"); 
HeaderPdf("KALENDER AKADEMIK","SEMESTER : $NamaSemester");
?>
 <div style="text-align: center; width: 100%;">
<h4><?php echo $NamaTahun; ?></h4>
<table style="width: 100%; border: solid 1px #FFFFFF;">
<?php 
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' GROUP BY MONTH(EndDate),YEAR(EndDate) ORDER BY YEAR(EndDate),MONTH(EndDate) ASC";
$qryd= _query($sql)or die ();
$ab=_num_rows($qryd);
$col = 3;
echo"<tr>";
$cnt = 0;
	for($i=1;$i<=$ab;$i++)
	{
  if ($cnt >= $col) {
     echo "</tr><tr>";
      $cnt = 0;
  }
$ct=($i ==2 OR $i ==5) ? "style='width: 40%;'":"style='width: 30%;'";
echo"<td $ct>";
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
$calendar->showPdf(true);
echo"</td>";
 $cnt++;
	}
echo"</tr>";
?>
</table></div>
    <br>
<table class='ket' style='width: 100%; border: solid 1px #FFFFFF;'>
<?php 
	$sqld="SELECT * FROM evenjenis ORDER BY jenisID";
	$qryd= _query($sqld)or die ();
	while ($d=_fetch_array($qryd)){
echo"<tr><th colspan='2'>$d[Nama]</th><th colspan='2'> Tanggal</th></tr>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' AND JenisEvent='$d[jenisID]' ORDER BY StartDate,EventId";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){  
	$start=tgl_indo($r['StartDate']);
	$end=tgl_indo($r['EndDate']);
	$no++;
	echo "
	<tr>
	<td  style='width: 6%;' bgcolor='$r[warna]'>&nbsp;&nbsp;</td>
	<td style='width: 48%;'>$r[NamaEvent]</td>";
if($r['StartDate']==$r['EndDate']){
echo"<td style='width: 46%;' colspan='2'>$start</td>";
}else{
echo"<td style='width: 23%;'>$start</td><td style='width: 23%;'>$end</td>";
}
echo"</tr>";        
	}
}
echo"</table>";
FooterPdf();
?>
</page>