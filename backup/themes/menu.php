<?php
defined('_FINDEX_') or die('Access Denied');
global $hari_ini,$saiki;
$tanGal=tgl_indo($saiki);
if(isset($_REQUEST['page']))
$p = $_REQUEST['page']; 

$levels	= ceklevel($_SESSION['yapane']);
$tbl	= GetaField('level', 'id_level', $levels, 'TabelUser');
$prof	= _query("SELECT * FROM $tbl WHERE username='$_SESSION[yapane]'");
$data	= _fetch_array($prof);
if($tbl=='mahasiswa'){
$direktori="foto_mahasiswa";
$fileFoto=$data[Foto];
}elseif($tbl=='dosen'){
$direktori="foto_dosen";
$fileFoto=$data[foto];
}else{
$direktori="foto_user";
$fileFoto=$data[foto];
}
if($fileFoto!=''){
		if (file_exists('media/images/'.$direktori.'/'.$fileFoto)){
			$foto ="<img src='media/images/$direktori/small_$fileFoto' height='65px' alt='$_SESSION[Nama]'>";
		} elseif (file_exists('media/images/'.$fileFoto)){
			$foto ="<img src='media/images/$fileFoto' height='65' alt='$_SESSION[Nama]'>";
		}else{
			$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$_SESSION[Nama]'>";
		}
}else{
	$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$_SESSION[Nama]'>";
}

$user		= _query("SELECT * FROM useryapan WHERE username='$_SESSION[yapane]'");
$dataUser	= _fetch_array($user);
$dept		=NamaDepatmen($dataUser['Bagian']);
$NamaProdi	=NamaProdi($dataUser['kodeProdi']);
$Jbatan		=JabatanStaff($dataUser['Jabatan']);  
$jabatan	=$_SESSION['Jabatan'];  
$dibagian	=($_SESSION['levele']==4)? 'Program Studi <b>'.$NamaProdi.'</b>': 'Departemen <b>'.$dept.'</b>';   
?>
<div id="header">
	<div class="container">	
		<h1><a href="./"><?php echo SiteName; ?> </a></h1>			
		<div id="info">	
			<a href="javascript:;" id="info-trigger">
				<i class="icon-cog"></i>
			</a>
			<div id="info-menu">
				<div class="info-details">
				
					<h4>Selamat Datang , <?php echo $_SESSION['Nama'];?></h4>
					<form method="post">
						<p>
							<?php echo $Jbatan; ?> | <?php echo $dibagian; ?>
							<br>
							<div class="btn-group pull-right">
							<a class="btn btn-mini btn-info" href="go-profil.html">
								<i class="icon-user"></i> Profil									
							</a>
							<button class="btn btn-inverse btn-mini" type="submit" name="logout">
								<i class="icon-signout"></i> Keluar									
							</button>
							</div>
						</p>
					</form>
				</div> <!-- /.info-details -->
				<div class="info-avatar">
					<?php echo $foto; ?>
				</div> <!-- /.info-avatar -->
			</div> <!-- /#info-menu -->
		</div> <!-- /#info -->
	</div> <!-- /.container -->
</div> <!-- /#header -->
<div id="nav">
	<div class="container">
		<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        	<i class="icon-reorder"></i>
      	</a>
		
		<div class="nav-collapse">
<?php 
$level		= $_SESSION['levele'];
$parent		= GetMenuParent($p);
$homeAktif	=(empty($p))? "active":"";
echo"<ul class='nav'>
	<li class='nav-icon $homeAktif'>
	<a href='./'><i class='icon-home'></i><span>Home</span></a></li>";
//Menu Master
if ($_SESSION['levele']==0){
	$main=mysql_query("SELECT * FROM modul WHERE parent_id='0' AND aktif='Y' ORDER BY menu_order");
	while($r=mysql_fetch_array($main)){
	$submenu=punyasub($r['id']);
	$aktif=CurrentMenu($parent,$r['id'],$r['url'],$p);
	$ikon=($r['class']=='')? "icon-th": $r['class'];
	if ($submenu > 0 ){
	echo "<li class='dropdown $aktif'><a class='dropdown-toggle' href='javascript:void(0)' data-toggle='dropdown'><i class='$ikon'></i>$r[judul] <b class='caret'></b></a>";
	} else { 
	echo "<li class='$aktif'><a href='go-$r[url].html'><i class='$ikon'></i>$r[judul]</a>";
	}
	$sub=mysql_query("SELECT * FROM modul WHERE parent_id='$r[id]' AND aktif='Y' ORDER BY menu_order");
		$jml=mysql_num_rows($sub);
		// apabila sub menu ditemukan                
		if ($jml > 0){
			echo "<ul class='dropdown-menu'>";             
			while($w=mysql_fetch_array($sub)){
			$saktif=CurrentMenu($parent,$w['id'],$w['url'],$p);
			echo "<li class='$saktif'><a href='go-$w[url].html'>$w[judul]</a></li>";
            	}           
	        echo "</ul></li>";
                } else {
                  echo "</li>";
                }
              }
//Menu Non Master
}else{
$MODUL=_num_rows(_query("SELECT hakmodul.*, modul.* FROM hakmodul INNER JOIN modul ON hakmodul.id=modul.id WHERE hakmodul.id_level='$jabatan'"));

if ($MODUL > 6)
	{
	$main=mysql_query("SELECT hakmodul.*, modul.* FROM hakmodul INNER JOIN modul ON hakmodul.id=modul.id WHERE hakmodul.id_level='$jabatan' AND modul.parent_id='0' AND modul.aktif='Y' ORDER BY modul.menu_order");
	while($r=mysql_fetch_array($main)){
	$submenu=punyasub($r['id']);
	$aktif=CurrentMenu($parent,$r['id'],$r['url'],$p);
	$ikon=($r['class']=='')? "icon-th": $r['class'];
	if ($submenu > 0 ){
	echo "<li class='dropdown $aktif'><a class='dropdown-toggle' href='javascript:void(0)' data-toggle='dropdown'><i class='$ikon'></i>$r[judul] <b class='caret'></b></a>";
	} else { 
	echo "<li class='$aktif'><a href='go-$r[url].html'><i class='$ikon'></i>$r[judul]</a>";
	}
	$sub=mysql_query("SELECT hakmodul.*, modul.* FROM hakmodul INNER JOIN modul ON hakmodul.id=modul.id WHERE hakmodul.id_level='$jabatan' AND modul.parent_id='$r[id]' AND modul.aktif='Y' ORDER BY modul.menu_order");
		$jml=mysql_num_rows($sub);
		// apabila sub menu ditemukan                
		if ($jml > 0){
			echo "<ul class='dropdown-menu'>";             
			while($w=mysql_fetch_array($sub)){
			$saktif=CurrentMenu($parent,$w['id'],$w['url'],$p);
			echo "<li class='$saktif'><a href='go-$w[url].html'>$w[judul]</a></li>";
            	}           
	        echo "</ul></li>";
                } else {
                  echo "</li>";
                }
              }
	}else{
	$main=mysql_query("SELECT hakmodul.*, modul.* FROM hakmodul INNER JOIN modul ON hakmodul.id=modul.id WHERE hakmodul.id_level='$jabatan' AND modul.parent_id!='0' AND modul.aktif='Y' ORDER BY modul.id");
	while($r=_fetch_array($main)){
	$submenu=punyasub($r['id']);
	$aktif=CurrentMenu($parent,$r['id'],$r['url'],$p);
	echo "<li class='$aktif'><a href='go-$r[url].html'>$r[judul]</a></li>";
	}
}
}
echo"</ul>";
?>
<ul class="nav pull-right">
	<li class="active">
		<div class="navbar-search pull-left">
			<input type="text" class="search-query" value="<?php echo"$hari_ini , $tanGal";?>" placeholder="<?php echo"$hari_ini , $tanGal";?>">
			<span class='search-btn'><i class="icon-dashboard"></i></span>
		</div>	    				
	</li>
</ul>
		</div> 
	</div> 
</div> 
