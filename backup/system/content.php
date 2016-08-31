<?php	
$level		= $_SESSION[Jabatan];
$page		= $_GET[page];
$buat= false;
$baca= false;
$tulis= false;
$hapus= false;
if (file_exists('core/'.$page.'.php')){
	$sboleh = "SELECT * FROM hakmodul a,modul b WHERE a.id=b.id AND a.id_level='$level' AND b.url='$page'";
	$rboleh = _query($sboleh);
	$ktm = _num_rows($rboleh);
 if ($ktm > 0) {
	while ($w = _fetch_array($rboleh)) 
	{
		$script=$w[url];
		$c=$w[buat];
		$r=$w[baca];
		$u=$w[tulis];
		$d=$w[hapus];
	}
		if($c=='Y'){$buat = true;}
		if($r=='Y'){$baca = true;}
		if($u=='Y'){$tulis = true;}
		if($d=='Y'){$hapus = true;}
		include "core/$script.php";	
} else {
	$sboleh1 = "SELECT * FROM modul WHERE parent_id='999' AND url='$page' AND aktif='N'";
	$rboleh1 = _query($sboleh1);
	$ktm1 = _num_rows($rboleh1);
 if ($ktm1 > 0) {
	while ($w1 = _fetch_array($rboleh1)) 
	{
		$script1=$w1[url];
		$c=$w1[buat];
		$r=$w1[baca];
		$u=$w1[tulis];
		$d=$w1[hapus];
	}
		if($c=='Y'){$buat = 1;}
		if($r=='Y'){$baca = 1;}
		if($u=='Y'){$tulis = 1;}
		if($d=='Y'){$hapus = 1;}
	include "core/$script1.php";	
} elseif ($page=='dasboard'){
include "core/dasboard.php";
} else {
ErrorAkses();
}
}
}else {
  echo "<div class='panel-content'><div class='panel-error'>
	<h1><i class='icon-warning-sign'></i></h1>
	<h2>OOPSS... , MODUL BELUM ADA ATAU BELUM LENGKAP.</h2>
	<a href='go-dasboard.html' class='btn'>Home</a>
</div></div>";
}
?>
