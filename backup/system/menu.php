<?php
$level= $_SESSION[levele];
$Jabatan= $_SESSION[Jabatan];
$page= $_GET[page];
$parent=GetMenuParent($page);
$bagian=$_SESSION[Bagian];
echo"<div class='top'>
<div id='top-strip'>
    <div class='container'>
        <div class='row'>
            <div class='offset8 span4'>
				<div class='control-group'>
					<div class='controls'>
						<div class='btn-group pull-right'>
							<button class='btn active btn-inverse dropdown-toggle' data-toggle='dropdown'><i class='icon-user'></i>  $_SESSION[Nama] <span class='caret'></span></button>
							<ul class='dropdown-menu'>
								<li><a href='go-profile.html'>Profile</a></li>
								<li class='divider'></li>
								<li><a href='go-exit.html'>Logout </a></li>
							</ul>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<div id='logo-strip'>
    <div class='container'>
        <div class='row'>
            <div class='span12'>
                <div class='logo'>
                    <a href='go-dasboard.html'><img src='../yapan/img/logo-stieyapan.png'/></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id='nav-strip'>

<div class='container'>
	<div class='row'>
	<div class='span12'>

              <div class='navbar'>
                <div class='navbar-inner'>
                  <div class='container'>
                    <div class='nav-collapse'>
                      <ul class='nav' id=''>";
$MODUL=_query("SELECT * FROM hakmodul a,modul b WHERE a.id=b.id 
	AND a.id_level='$Jabatan'");
if (_num_rows($MODUL)>15)
	{
$main=mysql_query("SELECT * FROM hakmodul a,modul b WHERE a.id=b.id 
	AND a.id_level='$Jabatan' AND b.parent_id='0' AND b.aktif='Y' ORDER BY b.menu_order");
	while($r=mysql_fetch_array($main)){
	$submenu=punyasub($r[id]);
	$aktif=CurrentMenu($parent,$r['id'],$r['url'],$page);
	if ($submenu > 0 ){
	echo "<li class='dropdown  $aktif'><a href='javascript:void(0)' class='dropdown-toggle' data-toggle='dropdown'>$r[judul] <b class='caret $aktif'></b></a>";
	} else { 
	echo "<li class='$aktif'><a href='go-$r[url].html'>$r[judul]</a>";
	}
	$sub=mysql_query("SELECT * FROM hakmodul,modul WHERE hakmodul.id=modul.id AND hakmodul.id_level='$Jabatan' AND modul.parent_id='$r[id]' AND modul.aktif='Y' ORDER BY modul.menu_order");
		$jml=mysql_num_rows($sub);
		// apabila sub menu ditemukan                
		if ($jml > 0){
			echo "<ul class='dropdown-menu pull-left' id=''>";             
			while($w=mysql_fetch_array($sub)){
			$saktif=CurrentMenu($parent,$w['id'],$w['url'],$page);
			echo "<li class='$saktif'><a href='go-$w[url].html'><span>&#187; $w[judul]</span></a></li>";
            	}           
	        echo "</ul></li>";
                } else {
                  echo "</li>";
                }
              }
	}else{
$active=($page=='dasboard') ? 'active': '';
echo"<li class='$active'><a href='go-dasboard.html'>HOME</a></li>";
	$main=mysql_query("SELECT * FROM hakmodul a,modul b WHERE a.id=b.id 
	AND a.id_level='$Jabatan' AND b.parent_id!='0' AND b.aktif='Y' ORDER BY b.id");
	while($r=_fetch_array($main)){
	$submenu=punyasub($r[id]);
	$aktif=CurrentMenu($parent,$r['id'],$r['url'],$page);
	echo "<li class='$aktif'><a href='go-$r[url].html'>$r[judul]</a></li>";
	}
}
echo"</ul>
	</div></div></div></div></div></div></div></div>";
?>