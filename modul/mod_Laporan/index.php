<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php defined('_FINDEX_') or die('Access Denied'); 
 if($baca){ 
global $today,$BulanIni,$TahunIni; ?>
<div class="row">
<div class="span12">
<form method="post" id="form">
<div class="widget widget-table">
<?php
global $today,$BulanIni,$TahunIni;
$id		= (empty($_REQUEST['act']))? '' : $_REQUEST['act'];

$tAktif		=TahunAktif();
$tahunAkdm		= (empty($_POST['tahuns']))? $tAktif : $_POST['tahuns'];
$semester	= (empty($_POST['semester']))?  1: $_POST['semester'];
$bulan	= (empty($_POST['bulan']))? $BulanIni : $_POST['bulan'];
$tahun	= (empty($_POST['tahun']))? $TahunIni : $_POST['tahun'];

$hari1	= (empty($_POST['hari1']))? $today : $_POST['hari1'];
$bulan1	= (empty($_POST['bulan1']))? $BulanIni-1 : $_POST['bulan1'];
$tahun1	= (empty($_POST['tahun1']))? $TahunIni : $_POST['tahun1'];

$hari2	= (empty($_POST['hari2']))? $today : $_POST['hari2'];
$bulan2	= (empty($_POST['bulan2']))? $BulanIni : $_POST['bulan2'];
$tahun2	= (empty($_POST['tahun2']))? $TahunIni : $_POST['tahun2'];

$angkatan	= (empty($_POST['Angkatan']))? '0' : $_POST['Angkatan'];

$dari	=sprintf("%02d%02d%02d",$tahun1,$bulan1,$hari1);
$sampai	=sprintf("%02d%02d%02d",$tahun2,$bulan2,$hari2);
$Bulan1=getBulan2($bulan1);
$Bulan2=getBulan2($bulan2);

echo "<div class='widget-header'>						
		<h3><i class='icon-bar-chart'></i>LAPORAN KEUANGAN</h3>
		<div class='widget-actions'>
				<div class='input-prepend input-append'>
					<span class='add-on'>Pilih Laporan</span>
					<select name='buku' onChange=\"MM_jumpMenu('parent',this,0)\" class='input-xxlarge'>
					<option value='go-Laporan.html'>- Pilih Jenis Laporan -</option>";
						$sqlp="SELECT * FROM lapbau ORDER BY id";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$id){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='aksi-Laporan-$d[id].html' $cek> $d[Nama]</option>";
						}
				echo"</select>
				</div>	
					
		</div> 
	</div>";
$laporan=NamaLaporan($id);
$Bulan=getBulan($bulan);
$tahunAkademik=TahunID($tahunAkdm);
if($id==2){
	$export="<a class='btn btn-inverse' href='ke-eksport-lapBau-$id-$tahunAkdm-$semester-$tahun-$bulan.html'>Export Ke Excel</a>";
	$jdl="( $tahunAkademik | Semester $semester | BULAN : $Bulan - $tahun )";
}else{
	$export="<a class='btn btn-inverse' href='do-eksport-lapBau-$id-$dari-$sampai.html'>Export Ke Excel</a>";
	$jdl="( Periode : $hari1 $Bulan1 $tahun1 - $hari2 $Bulan2 $tahun2 )";
}
if(!empty($id)){
if($id==2){
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<div class='input-prepend input-append' style='margin-bottom: 0;margin-top: 0;'>
			<span class='add-on'>Tahun</span>
			<select name='tahuns' onChange='this.form.submit()'>
			<option value=''>- Pilih Tahun Akademik -</option>";
			$t=_query("SELECT * FROM tahun ORDER BY Nama DESC");
			while($r=_fetch_array($t)){
			$cek=($tahunAkdm == $r['Tahun_ID'])? 'selected': '';
			echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
			}
		echo "</select>
				<span class='add-on'>Semester</span>
				<select name='semester' onChange='this.form.submit()' class=''>
					<option value=''>- SEMESTER -</option>";
					$sm=array('1','2','3','4','5','6','7','8');
					foreach($sm as $smst){
						if ($smst==$semester){$cek="selected";}else{ $cek="";}
						echo "<option value='$smst' $cek> Semester $smst</option>";
					}
		echo"</select>
	</div>
</div>
<div class='pull-right'>
	<div class='input-prepend input-append' style='margin-bottom: 0;margin-top: 0;'>
	<span class='add-on'>Bulan</span>";
		Getcombonamabln2(01,12,'bulan',$bulan,$id,$tahun);
		Getcombothn2($TahunIni-10,$TahunIni+5,'tahun',$tahun,$id,$bulan);
		echo"</div>
</div>
</div></div>";
}else{
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;text-align:center;'>
<div class='input-prepend input-append' style='margin-bottom: 0;margin-top: 0;'>
	<span class='add-on'>Dari</span>";
				Getcombotgl2(1,31,'hari1',$hari1);
				Getcombonamabln2(01,12,'bulan1',$bulan1);
				Getcombothn2($TahunIni-10,$TahunIni+5,'tahun1',$tahun1);
	echo"<span class='add-on'>Sampai</span>";
				Getcombotgl2(1,31,'hari2',$hari2);
				Getcombonamabln2(01,12,'bulan2',$bulan2);
				Getcombothn2($TahunIni-10,$TahunIni+5,'tahun2',$tahun2);
	echo"
	</div>
</div>";
}
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<h4 style='margin-bottom: 0;margin-top: 5px;'><i class='icon-hand-right'></i> &nbsp;&nbsp; $laporan&nbsp;&nbsp;<i>$jdl</i></h4>
</div>
<div class='pull-right'>
<div class=btn-group>$export</div>
</div>
</div></div>";
}
echo"<div class='widget-content'>";
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
  echo "<div class='widget-content alert-info'>
		<center><br><br>
				<h2>Laporan Keuangan</h2>
				<div class='error-details'>
				 Untuk Mellihat laporan, Silahkan Pilih Menu <strong>Pilih Laporan </strong> di atas.
				</div> 
				<br>
				<br>
		</center>
		</div>";
	break;	
	case '1':	 
	 require('honorRektorat.php');
	break;
	case '2':	 
	 require('honorDosen.php');
	break;
	case '3':	 
	 require('honorStaff.php');
	break;
	case '4':	 
	 require('mahasiswas1.php');
	break;
	case '5':	 
	 require('mahasiswas2.php');
	break;
	case '6':	 
	 require('mahasiswas2.php');
	break;
case '7':	 
	 require('mahasiswas2.php');
	break;
case '10':	 
	 require('almamater.php');
	break;

}
echo"</div>
<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='span6'>
	
</div>
<div class='span6'>

</div>
</div></div>";
?>
</div></form></div></div>
<?php }else{
ErrorAkses();
} ?>