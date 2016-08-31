<?php defined('_FINDEX_') or die('Access Denied');?>
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
</head>
<body>
<?php 
require('librari/class_paging.php');
$kode		=($_SESSION[Jabatan]==18)? $_SESSION['prodi']: $_GET['kode'];
$disab		=($_SESSION[Jabatan]==18)? "disabled": "";
$BreadProdi	=(empty($kode))? "SEMUA PROGRAM STUDI":"PROGRAM STUDI <span class='divider'>/</span> $NamaProdi";
?>
<div class="row-fluid">
	<div class="span12">
<form method="post" id="form">
	   <div class="widget widget-table">
			
<div class="widget-toolbar">
<div class="row-fluid">
<div style="padding-top: 7px">
<?php 
echo"<div class='input-prepend input-append'>
	";?>
	<input class="input-medium" id="appendedInputButtons" value="<?php echo $_POST['gona'];?>" name="gona" placeholder=" Nama / Nim ..." type="text" autocomplete="off">
	<button class="btn" type="submit">Cari Mahasiswa</button>
	<a href="page-Web_alumni-<?php echo $kode; ?>-1.html" class="btn ui-tooltip" data-placement="top" title="Refresh">Refresh</a>
</div>

</div>
</div>
<div class="widget-header">						
<h3>&nbsp;&nbsp;</h3>
            </div> 
</div>

<div class="widget-content">
<table class="table table-striped table-bordered table-highlight responsive">
	<thead>
		<tr>
			<th><center>NO</center></th>
			<th>ANGKATAN</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>GENDER</th>
		</tr>
	</thead>
	<tbody>
<?php

	$p      	= new Paging;
    $batas  	= 20;
    $posisi 	= $p->cariPosisi($batas);
//WHERE
$whereProdi = "";
if($_POST['gona']!='')
{
	if (empty($kode))
		{
			$cari 		= $_POST['gona'];
			$whereProdi .= "NIM LIKE '%$cari%' OR Nama LIKE '%$cari%' AND NIM!='' AND LulusUjian='Y'";
			$limit.="";
		}else{
			$cari 		= $_POST['gona'];
			$whereProdi .= "NIM LIKE '%$cari%' OR Nama LIKE '%$cari%' AND kode_jurusan='$kode' AND NIM!='' AND LulusUjian='Y'";
			$limit.="";
		}
}else{
	if (empty($kode))
		{
			$whereProdi .= "NIM!='' AND LulusUjian='Y'";
			$limit.=" LIMIT $posisi,$batas";
		}else{
			$whereProdi .= "kode_jurusan='$kode' AND NIM!='' AND LulusUjian='Y'";
			$limit.=" LIMIT $posisi,$batas";
		}
}
// END
	$no = $posisi+1;
	$sql		="SELECT * FROM mahasiswa WHERE $whereProdi ORDER BY Angkatan, Nama, NIM ASC $limit";
	$qry		= _query($sql)or die ();
	while ($r=_fetch_array($qry)){  
	$sttus = ($r['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$kelas=GetName("program","ID",$r['IDProg'],"nama_program");
	$angkatan=GetName("tahun","Tahun_ID",$r['Angkatan'],"Nama");
	$AngkatThn = substr($angkatan, 15, 9); 
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$gender=($r[Kelamin]=='L')?"Laki - Laki":"Perempuan";
	$namaMahsw=strtoupper($r['Nama']);
	$linkDetail="<a class='ui-lightbox ui-tooltip' data-placement='right' href='get-detail-alumni-$r[NIM].html?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p' title='DETAIL ALUMNI'>$namaMahsw</a>";
	
	echo "<tr>
			<td>$no</td>
			<td>$AngkatThn</td>
			<td>$r[NIM]</td>
			<td>$namaMahsw</td>
			<td>$gender</td>
		</tr>";
$no++;
}
?>
</tbody>
</table></div><div class="widget-toolbar">
<?php 
	$link 			= "page-Web_alumni-$kode";
	$jmldata 		= _num_rows(_query("SELECT * FROM mahasiswa WHERE $whereProdi"));
    $jmlhalaman 	= $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman 	= $p->navHalaman($_GET['halaman'], $jmlhalaman,$link);
	$paging =(empty($_REQUEST['gona']))? $linkHalaman: '';
echo"";
echo "<div class='pagination' style='margin: 0;'>
<ul class='pull-left' ><li></li></ul>
<ul class='pull-right' >$paging</ul></div>";
?>
</div> <!-- /.widget-toolbar -->

</div></form></div></div>

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
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
</script>
</html>