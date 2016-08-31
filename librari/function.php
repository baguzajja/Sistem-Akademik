<?php
defined('_FINDEX_') or die('Access Denied');

/****************************************/
/*			 Loader Function 			*/
/****************************************/
//memuat admin apps
function baseApps($page)
{
	$buat	= false;
	$baca	= false;
	$tulis	= false;
	$hapus	= false;
	$level	= $_SESSION['Jabatan'];
	if (file_exists('modul/mod_'.$page.'/index.php'))
	{
		$rboleh = _query("SELECT hakmodul.*, modul.* FROM hakmodul INNER JOIN modul ON hakmodul.id=modul.id WHERE hakmodul.id_level='$level' AND modul.url='$page'");
		$ktm = _num_rows($rboleh);
		if ($ktm > 0) 
		{
			if($_SESSION['levele']==0)
			{
				$buat = true;
				$baca = true;
				$edit = true;
				$hapus = true;
				$file = "modul/mod_$page/index.php";
				include($file);
			}
			else
			{
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
					if($u=='Y'){$edit = true;}
					if($d=='Y'){$hapus = true;}
					$file = "modul/mod_$page/index.php";
					include($file);
			}
		}
		elseif($_SESSION['levele']==0)
		{
				$buat = true;
				$baca = true;
				$edit = true;
				$hapus = true;
				$file = "modul/mod_$page/index.php";
				include($file);
		} 
		elseif($page=='profil')
		{
				$buat = true;
				$baca = true;
				$edit = true;
				$hapus = true;
				$file = "modul/mod_$page/index.php";
				include($file);
		} 
		else 
		{ 
			ErrorAkses(); 
		}
	}
	else 
	{ 
		ErrorModul(); 
	}
}
//memuat admin system apps
function baseSystem($file){
	$file = "modul/mod_$file/proses.php";	
	if(file_exists($file)) include($file);	
}

//memuat admin modul Js
function baseAppJs($fileAp){
	$file = "modul/mod_$fileAp/style/js.php";	
	if(file_exists($file)) include($file);	
}
//memuat admin modul Js
function baseAppCss($fileAp){
	$file = "modul/mod_$fileAp/style/css.php";	
	if(file_exists($file)) include($file);	
}

//memuat fungsi admin apps
function loadSystemApps(){
	include('librari/modul.php');		
}

/****************************************/
/*			 Check User Login			*/
/****************************************/
//cek status user dalam keadaan login melalui tabel session_login
function check_backend_login() {
	if(!empty($_SESSION['yapane']) AND !empty($_SESSION['Identitas'])){
			load_themes();
	}
	else {
		$_SESSION['yapane']			= null ;
		$_SESSION['passwordte']		= null ;
		$_SESSION['Nama'] 			= null ;
		$_SESSION['levele']			= null ;
		$_SESSION['Identitas'] 		= null ;
		$_SESSION['prodi'] 			= null ;
		$_SESSION['Bagian']			= null ;
		$_SESSION['Jabatan']		= null ;
		load_login();
	}
}

//memanggil template sesuai fungsi select_themes()
function load_themes(){	
	if(isset($_POST['logout'])){
		CatatLog($_SESSION['Nama'],'Logout',"Logout Berhasil");
		session_destroy();
		load_login();
	} else {		
		select_themes('index','','');	
	}
}
//memanggil file Lupa Password
function load_barcode() {
	if (isset($_POST['readBarcode'])) 
	{
		$rs_check = _query("SELECT * FROM mahasiswa WHERE NIM='$_POST[readBarcode]'"); 
		$num = _num_rows($rs_check); 
		if($num <= 0){	
				select_themes('barcode','error','NIM Tidak terdaftar');
			} else {
				$r= _fetch_array($rs_check); 
				$NamaProdi=GetName("jurusan","kode_jurusan",$r['kode_jurusan'],"nama_jurusan");
				$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
				$Agama=NamaAgama($r['Agama']);
				$TglLhr=Tgl_indo($r['TanggalLahir']);
				$gender=($r['Kelamin']=='L') ? "Laki - Laki": "Perempuan";
				$prodi = GetFields('jurusan', 'kode_jurusan', $r['kode_jurusan'], '*');
	
				if($r['Foto']!=''){
						if (file_exists('media/images/foto_mahasiswa/'.$r['Foto'])){
							$foto ="<img src='media/images/foto_mahasiswa/medium_$r[Foto]' width='100px' alt='$r[Nama]'>";
						} elseif (file_exists('media/images/'.$r['Foto'])){
							$foto ="<img src='media/images/$r[Foto]' width='100px' alt='$r[Nama]'>";
						}else{
							$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' width='100px'>";
						}
				}else{
					$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' width='100px'>";
				}
	
$contents ="<div class='widget widget-table'>
	<div class='widget-header'>	
		<h3><i class='icon-user'></i>DETAIL MAHASISWA</h3> 	
	</div>
	<div class='widget-content'>
	<div class='row-fluid'>
	<div class='span8'>
		<table class='table table-striped table-bordered table-highlight responsive'>                            
		<tr>
		<td width='45%'>NAMA LENGKAP</td>
		<td><strong> $r[Nama]</strong></td>
		</tr>                    
		<tr>
		<td>NIM</td>
		<td><strong>$r[NIM] </strong></td>
		</tr>
		<tr><td>PROGRAM STUDI </td><td><strong> $NamaProdi</strong></td></tr>
		</table>
	</div>
	<div class='span4'>
		<center>$foto</center>
	</div>
</div>
<table class='table table-striped table-bordered table-highlight'>
						<tr><td colspan='2' style='text-align:center'><a href='go-barcode.html' class='btn btn-danger'> Kembali.</a></td></tr>					
					</tbody>
				</table>
		
	</div> 
</div>";	
			select_themes('barcode','info',$contents);
			}
	}else{
		select_themes('barcode','','');
	}
}
//memanggil file Lupa Password
function load_Reset_Password() {
if (isset($_POST['forgot_password'])) {
	$rs_check = _query("select * from useryapan where aktif='Y' AND email='$_POST[mail]'"); 
	$num = _num_rows($rs_check);
	$host  = $_SERVER['HTTP_HOST'];
		if($num <= 0){	
			select_themes('passw','error','Email Tidak Terdaftar');
		} else {
			$data= _fetch_array($rs_check);
			$new_pwd = GenPwd();
			$pwd_reset = md5($new_pwd);
			$rs_activ = _query("update useryapan set password='$pwd_reset' WHERE email='$_POST[mail]'") or die(mysql_error());
            
			$to  = "$_POST[mail]" ;
			$subject = 'Reset Password';
			$message = "<html>
		<head>
			 <title>Reset Password</title>
		</head>
		
		<body>
			<p>Atas permintaan anda, kami kirimkan email yang berisi username dan password anda yang terdaftar pada akademik.stieyapan.com</p>
			<p>Berikut ini Adalah Detail Akun Anda :</p>
			<p>=============================</p>
			<p>Username  = $data[username]</p>
			<p>Password  = $new_pwd</p>
			<p>=============================</p>
			<p>Simpan Password Anda Baik - Baik.</p>
		</body>
		
		</html>";

	// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
		$headers .= "To: $data[Nama] <$_POST[mail]>" . "\r\n";
		$headers .= 'From: Admin Password Reminder <no-reply@'.$host.'>' . "\r\n";
		$headers .= 'cc :' . "\r\n";
		$headers .= 'Bcc :' . "\r\n";

	// Mail it
		$mail = @mail($to,$subject,$message,$headers);
		if($mail){ 
			select_themes('passw','info','Password Berhasil Di Reset<br>Silahkan Cek Email Anda.');
			CatatLog($_SESSION[Nama],'Reset Password','Password Berhasil Di Reset');
		}else{
			select_themes('passw','error','Gagal Mengirim Email..!');
			CatatLog($_SESSION[Nama],'Reset Password','Gagal Mengirim Email');
		}
		}
	} else {
		select_themes('passw','','');
	}
}
//memanggil file login jika user belum login
function load_login() {
	global $tgl_sekarang, $jam_sekarang;
	if(isset($_POST['go_login'])) {
		$pass	=md5($_POST['passwordte']);
		$login	= _query("SELECT * FROM useryapan WHERE username='$_POST[yapane]' AND password='$pass' AND aktif='Y'") or die ("SQL Error:".mysql_error());
		$ketemu= _num_rows($login);
		if($ketemu > 0) {
			$data= _fetch_array($login);
			$_SESSION['yapane']			= $data['username'];
			$_SESSION['passwordte']		= $data['password'];
			$_SESSION['Nama'] 			= $data['Nama'];
			$_SESSION['levele']			= $data['LevelID'];
			$_SESSION['Identitas'] 		= $data['IdentitasID'];
			$_SESSION['prodi'] 			= $data['kodeProdi'];
			$_SESSION['Bagian']			= $data['Bagian'];
			$_SESSION['Jabatan']		= $data['Jabatan'];
			
			$qr=_query("UPDATE useryapan SET Log='$tgl_sekarang $jam_sekarang', SessionID='$tgl_sekarang/$data[password]' WHERE username='$data[username]'");
		if($qr or !empty($_SESSION['yapane']) AND !empty($_SESSION['passwordte'])) 
			CatatLog($_SESSION['Nama'],'Login',"Login Berhasil");
			load_themes();
		} else {
			CatatLog($_POST[yapane],'Login',"Login Gagal");
			select_themes('login','error',"Username / Password Salah ...!");
		}		
	} else {
		select_themes('login','','');
	}
}
//memilih tema AdminPanel sesuai dengan nilai admin_theme pada tabel setting
function select_themes($log, $pesan = NULL,$isipesan = NULL){
	define("AdminPath","themes");
	define("MediaPath","media");
	if($log=="login") {
		$file =  "themes/login.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}
	else if($log=="index") {	
		$file =   "themes/index.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}
	else if($log=="barcode") {	
		$file =   "themes/barcode.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}else if($log=="passw") {	
		$file =   "themes/password.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}else if($log=="blank") {	
		$file =   "themes/blank.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}else if($log=="profil") {	
		$file =   "themes/profil.php";
		if(file_exists($file))
			require $file;
		else
			echo "Failed to load Template";
	}
	else {
		redirect(FUrl);
	}		
}
function loadMail(){
	require_once("mail.php");	
}

//memanggil file JavaScript
function addJs($link) {	
	echo "<script type='text/javascript' src='$link'></script>";
}	

//memanggil file CSS
function addCss($link,$media = null) {
	if(empty($media)) $media = 'all';
	echo  "<link href='$link' rel='stylesheet' type='text/css' media='$media' />";
}	
//auto database query
function FQuery($table, $where = null, $output = null, $hide = null, $order = null, $select = null) {	
	$db = new FQuery();  
	$db -> connect();
	if(empty($select)) $select = "*";
	$sql = $db->select("$table","$select","$where","$order");
	if(!$sql) {
		if(!isset($hide))
			echo "<b>Error</b> :: failed to use <b>FQuery</b> function. Please check table <b>$table</b> or your sql (<b>$where</b>) or field (<b>$output</b>)<br>";	
	}
	else {
		$row = mysql_fetch_array($sql); 
		$sum = mysql_affected_rows();
		if(!empty($output))
			return @$row[$output] ;
		else
			return $sum;
	}
}
//query database untuk satu output
function oneQuery($table,$field,$value,$output = null) {
	$query = FQuery($table,"$field=$value",$output);
	return $query;	
}
/* Website Global Information */
function siteConfig($name) {
	$output = oneQuery('setting','name',"'$name'",'value');
	return $output;
}

function combotgl($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='input-small'>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}

function combobln($awal, $akhir, $var, $terpilih){
$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
 echo "<select name=$var class='input-medium'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
	$lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }
       if ($bln==$terpilih)
         echo "<option value=$b selected>$nama_bln[$bln]</option>";
      else
        echo "<option value=$b>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

function combothn($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='input-small'>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value=$i selected>$i</option>";
    else
      echo "<option value=$i>$i</option>";
  }
  echo "</select> ";
}
function Getcombothn($awal, $akhir, $var, $terpilih, $id,$bulan){
  echo "<select name=$var class='' onChange=\"MM_jumpMenu('parent',this,0)\">";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value='actions-bukubesar-$id-$bulan-$i.html' selected>$i</option>";
    else
      echo "<option value='actions-bukubesar-$id-$bulan-$i.html'>$i</option>";
  }
  echo "</select> ";
}
function Getcombonamabln($awal, $akhir, $var, $terpilih,$id,$tahun){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='' onChange=\"MM_jumpMenu('parent',this,0)\">";
  for ($bln=$awal; $bln<=$akhir; $bln++){
	$lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }
      if ($bln==$terpilih)
         echo "<option value='actions-bukubesar-$id-$b-$tahun.html' selected>$nama_bln[$bln]</option>";
      else
        echo "<option value='actions-bukubesar-$id-$b-$tahun.html'>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}
function Getcombotgl2($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='input-small' onChange='this.form.submit()'>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}
function Getcombothn2($awal, $akhir, $var, $terpilih){
  echo "<select name=$var class='input-small' onChange='this.form.submit()'>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value='$i' selected>$i</option>";
    else
      echo "<option value='$i'>$i</option>";
  }
  echo "</select> ";
}
function Getcombonamabln2($awal, $akhir, $var, $terpilih,$id,$tahun){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='input-medium' onChange='this.form.submit()'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
	$lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }
      if ($bln==$terpilih)
         echo "<option value='$b' selected>$nama_bln[$bln]</option>";
      else
        echo "<option value='$b'>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var class='span5'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
      if ($bln==$terpilih)
         echo "<option value=$bln selected>$nama_bln[$bln]</option>";
      else
        echo "<option value=$bln>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}
function FUrl() {
	$furl = str_replace('index.php','',$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
	if(_FINDEX_=='BACK') {
		$jurl = substr_count($furl,"/")-1;
		$ex = explode("/",$furl);
		$no = 1 ;
		$FUrl = '';
		foreach($ex as $b) {$FUrl .= "$b/";  if($no==$jurl) break; $no++;}	
	}
	else {
		$FUrl= $furl;
	}
	return $FUrl;
}
function htmlRedirect($link,$time = null){
	if($time) $time = $time; else $time = 0;
	echo "<meta http-equiv='REFRESH' content='$time; url=$link'>";
}
function alert($type,$text = null, $style = null){
	if($type=='info'){
			echo "<div class='alert alert-success alert-block'>
					<a class='close' data-dismiss='alert' href='#'>&times;</a>
					<h4 class='alert-heading'>$text !</h4> 
				</div>";
		}
		else if($type=='error')	{
			echo "<div class='alert alert-danger alert-block'>
					<a class='close' data-dismiss='alert' href='#'>&times;</a>
					<h4 class='alert-heading'>$text !</h4> 
				</div>";
		}
		else if($type=='loading'){		
			echo '<div id="loading"></div>';
	}
}
function alerPrint($judul,$text = null,$link1,$link2 ){
  echo "<div class='widget-content alert-success'>
		<center><br><br>
				<h2>$judul</h2>
				<div class='error-details'>
					$text
				</div> 
				<br>
				<br>
		</center>
<div class='widget-toolbar' style='text-align: center'>
			<div class='btn-group'>
				<a href='$link1' class='btn btn-large btn-success'>
						<i class='icon-ok'></i>
						&nbsp;
						Ok					
					</a>
					<a href='$link2?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p' class='btn btn-large btn-inverse ui-lightbox'>
						<i class='icon-print'></i>
						&nbsp;
						Cetak					
					</a>
			</div> 
</div>
		</div>";
}
//fungsi multiple select yang baru akan dipilih
function multipleSelect($x) {
	if($x) {
		$no = 1; $text = null;
		foreach ($x as $t){
			if($no==1)
				$t = "$t";
			else
				$t = ",$t";
			$text .= $t;
			$no++;
		}
		return $text;
	}
}

//fungsi multiple Delete yang telah terpilih
function multipleDelete($table, $source, $field = null) {
	$db = new FQuery();  
	$db->connect();
	$del = explode(",",$source);
	$where=(!empty($field))? $field: 'id';
	if(isset($source))
		foreach($del as $id){
			$qr = $db->delete($table,"$where='$id'");
		}
	if(isset($qr)) return 1;
	else if(isset($noempty)) return 'noempty';
	else return null;
}
function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
		  $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
		  $string = preg_replace("/[^a-zA-Z\s]/", "", $string);
		  
      return $string;
  }

  /**
   * cleanSanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function cleanSanitize($string, $trim = false,  $end_char = '&#8230;')
  {
	  $string = cleanOut($string);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim) {
        if (strlen($string) < $trim)
        {
            return $string;
        }

        $string = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $string));

        if (strlen($string) <= $trim)
        {
            return $string;
        }

        $out = "";
        foreach (explode(' ', trim($string)) as $val)
        {
            $out .= $val.' ';

            if (strlen($out) >= $trim)
            {
                $out = trim($out);
                return (strlen($out) == strlen($string)) ? $out : $out.$end_char;
            }       
        }
	  }
      return $string;
  }

function UploadPhoto($fupload_name,$lokasi_file,$vdir_upload){
  //direktori gambar
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($lokasi_file, $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 65 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 65;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  
  //Simpan dalam versi medium 360 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 160;
  $dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);

return true;
}
//Generate Password
function GenPwd($length = 7)
{
$password = "";
$possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels

$i = 0; 
while ($i < $length) { 
$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	if (!strstr($password, $char)) { 
	$password .= $char;
	$i++;
	}
}
return $password;
}
function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}