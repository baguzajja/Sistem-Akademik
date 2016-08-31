<?php
// Bagian Home
if  ($_GET[page]=='home'){
echo "<div class='span1'></div>
	<div class='span4'>
		<h5 class='center'>
			<img src='yapan/img/logo.png'/>
			<div>Sekolah Tinggi Ilmu Ekonomi</div>
			<div>STIE YAPAN - SURABAYA</div>
		</h5>
	</div>
	<div class='span5'>
		<div class='panel'>
			<div class='panel-header'><i class='icon-lock icon-large'></i>Maintenance ...</div>
			<div class='panel-content'><center>";
			echo"<h3>Sistem Dalam Pengembangan</h3>";
			echo"<h4>Mohon Tunggu Update Dari Kami.....</h4><br><br><br>";
			echo"<h4>Best Regards, IT Development</h4>";
			echo"</center></div>
		</div>
	</div>
	<div class='span2'></div>";
  }elseif  ($_GET[page]=='homess'){
echo "<div class='span1'></div>
	<div class='span4'>
		<h5 class='center'>
			<img src='yapan/img/logo.png'/>
			<div>Sekolah Tinggi Ilmu Ekonomi</div>
			<div>STIE YAPAN - SURABAYA</div>
		</h5>
	</div>
	<div class='span5'>
		<div class='panel'>
			<div class='panel-header'><i class='icon-lock icon-large'></i> Login Sistem Akademik</div>
			<div class='panel-content'>";
		if (isset($_GET['logout']) && $_GET['logout'] == 'ok') {
		InfoMsg("Silahkan Login Kembali ..!","");
		} elseif (isset($_GET['login']) && $_GET['login'] =='salah') {
		ErrorMsg("Opss... ! ","Username atau password salah");
		} else { echo ""; }
	
		echo"<form action='ceck.do' method=POST class='login-form'>
				<div class='control-group'>
					<div class='controls'>
						<div class='input-prepend'>
							<span class='add-on'><i class='icon-flag icon-large'></i></span>
							<select name='KodeId' class='span4'><option value=0 selected>STIE YAPAN - SURABAYA</option></select>
						</div>
					</div>
				</div>
				<div class='control-group'>
					<div class='controls'>
						<div class='input-prepend'>
							<span class='add-on'><i class='icon-user icon-large'></i></span><input class='span4' placeholder='Username' id='prependedInput' name='yapane' type='text' autocomplete='off'>
						</div>
					</div>
				</div>
				<div class='control-group'>
					<div class='controls'>
						<div class='input-prepend'>
							<span class='add-on'><i class='icon-key icon-large'></i></span><input class='span4' placeholder='Password' type='password' name='passwordte' id='prependedInput' autocomplete='off'>
						</div>
					</div>
				</div>
				<div class='control-group'>
					<div class='controls'>
						<button class='btn btn-large' name='Submit' type='submit'>Masuk <i class='icon-signin  icon-large'></i></button>
					</div>
				</div>
				
				<div class='divider'></div>
				<div class='control-group'>
					<div class='controls'>
						<div class='btn-group pull-right'>
							<input type='reset' value='Reset' class='btn btn-small btn-inverse'>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class='span2'></div>";
  }
elseif ($_GET[page]=='CekLogin'){

$pass=md5($_POST[passwordte]);
$usernaem=$_POST[yapane];
if (!empty($_POST[passwordte]) && !empty ($_POST[yapane])){

$login	= _query("SELECT * FROM useryapan WHERE username='$usernaem' AND password='$pass' AND aktif='Y'") or die ("SQL Error:".mysql_error());

$ketemu= _num_rows($login);
$data= _fetch_array($login);

if ($ketemu > 0){
global $jam_sekarang, $tgl_sekarang;
	session_start();
	$_SESSION[yapane]			= $data[username];
	$_SESSION[passwordte] 		= $data[password];
	$_SESSION[Nama] 			= $data[Nama];
	$_SESSION[levele] 			= $data[LevelID];
	$_SESSION[Identitas] 		= $data[IdentitasID];
	$_SESSION[prodi] 			= $data[kodeProdi];
	$_SESSION[Bagian] 			= $data[Bagian];
	$_SESSION[Jabatan] 			= $data[Jabatan];
	
	_query("UPDATE useryapan SET Log='$tgl_sekarang $jam_sekarang', SessionID='$tgl_sekarang/$data[password]' WHERE username='$data[username]'");
	lompat_ke('system/go-dasboard.html');
} else {
  lompat_ke('salah');
  }
} else {
  lompat_ke('salah');
  }
}
?>

