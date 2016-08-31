<?php
function defuser(){
$linkx="<a class='btn btn-mini btn-success' href='action-AdminUser-edit-1.html'>Tambah Admin User</a>";
buka("Manajemen Admin User",$linkx);
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
    <thead><tr><th>No</th><th>Nama</th><th>Nama Lengkap</th><th>Jabatan</th><th>E-mail</th><th>Telepon</th><th>Aktif</th><th></th></tr></thead><tbody>"; 
	$sql="SELECT * FROM admin WHERE username NOT IN ('master') ORDER BY id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$sttus = ($data['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$link = ($data['id_level'] == '0')? "<a class='btn btn-mini btn-danger' href='#' onClick=\"return confirm('Super Administrator Tidak Bisa Dihapus?')\" >Hapus</a>": "<a class='btn btn-mini btn-danger' href='get-AdminUser-hapus-$data[id].html' onClick=\"return confirm('Anda yakin akan Menghapus data User ?')\">Hapus</a>";
	$jabatan=NamaJabatan($data[Jabatan]);
	$no++;
echo"<tr>             
	<td>$no</td>               
	<td><a href='actions-AdminUser-edit-0-$data[id].html'>$data[username]</a></td>
	<td>$data[nama_lengkap]</td>
	<td>$jabatan</td>
	<td>$data[email]</td>
	<td>$data[telepon]</td>
	<td>$sttus</td>
	<td>
	<center>
		<div class='btn-group'>
		<a class='btn btn-mini btn-inverse' href='actions-AdminUser-edit-0-$data[id].html'>Edit</a>
		$link
		</div>
	</center>
	</td>
	</tr>";        
	} 
echo"</tbody></table>"; 
tutup();     
}

function edit(){
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('admin', 'id', $id, '*');
	$jdl = "UPDATE DATA USER ADMIN";
    $hiden = "<input type=hidden name='id' value='$w[id]'>
			<input type=hidden name='username' value='$w[username]'>";
	$username = "<input type=text value='$w[username]' disabled>";
	$Ppwd='Biarkan kosong jika tidak diubah';
  } else {
    $w = array();
    $w['id_level']= '';
    $w['Identitas_ID']= '';
    $w['kode_jurusan']= '';
    $w['username'] = '';
    $w['Bagian'] = '';
    $w['Jabatan'] = '';
    $w['nama_lengkap'] = '';
    $w['email'] = '';
    $w['telepon'] = '';
    $w['foto'] = '';
    $w['aktif'] = '';
    $jdl = "TAMBAH USER BARU";
    $hiden = "";
    $username = "<input type=text name=username value='$w[username]'>";
	$profile='';
	$Ppwd='Masukkan Password Min 6 Karakter';
  }
buka($jdl);
if($md == 0){
	$MaxFileSize = 50000;
	$foto	= (empty($w['foto'])) ? 'file/no-foto.jpg' : $w['foto'];
	$jabatan=NamaJabatan($w[Jabatan]);
	echo"<form method=post enctype='multipart/form-data' action='aksi-AdminUser-aplodFotoUserAdmin.html'>  
		<table class='well table table-striped'><thead>
		<tr><th colspan=3> INFORMASI USER</th></tr>                               
		<tr><td>Username  </td><td><strong> $w[username]</strong></td>
		<td rowspan=3><img alt='$w[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $w[nama_lengkap]</strong></td></tr>
	<tr><td>Level / Jabatan</td> <td><strong>$jabatan</strong></td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='Id' value='$w[id]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-AdminUser.html'><i class='icon-undo'></i> Kembali</a> 
			</div></td>
		<td>	
		<div class='fileupload fileupload-new pull-right' data-provides='fileupload'>
			<div class='input-append'>
				<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='foto'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
				<input class='btn btn-success' type=submit name='Upload' value='Upload Foto'>
			</div>
		</div>
		</td></tr>
		</thead></table></form>";
}
echo"<form method=POST action=aksi-AdminUser-update.html>
	<input type=hidden name='md' value='$md'>
	 $hiden
	<table class='table table-bordered table-striped'><thead>      
	<tr>
		<td>Username</td>
		<td>$username</td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input placeholder='$Ppwd' type=password name=password></td>
	</tr>
	<tr><td>Level User</td> <td>
		<select name='Level'>
			<option value=0 selected>- Pilih Level User -</option>";
			$level=_query("SELECT * FROM level ORDER BY id_level");
			while($l=_fetch_array($level)){
			if($l[id_level]==$w[id_level]){
			echo "<option value=$l[id_level] selected>$l[level]</option>";
			}else{
			echo "<option value=$l[id_level]>$l[level]</option>";
			}
		}
	echo "</select>
	</td></tr>
	<tr><td class=cc>Departemen</td>   <td><select name='bagian'>"; 
		$tampil=mysql_query("SELECT * FROM Departemen ORDER BY DepartemenId");
		while($r=mysql_fetch_array($tampil)){
		if($r[DepartemenId]==$w[Bagian]){
		echo "<option value=$r[DepartemenId] selected>$r[NamaDepeartemen]</option>";
          }else{
		echo "<option value=$r[DepartemenId]>$r[NamaDepeartemen]</option>";
		}
          }
		echo "</select>
	</td></tr>
	<tr><td>Jabatan</td> <td>
		<select name='Jbtn'>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='Ti' ORDER BY Nama");
			while($j=_fetch_array($jbtn)){
			if($j[Jabatan_ID]==$w[Jabatan]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
			}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
			}
		}
	echo "</select>
	</td></tr>
	<tr>
		<td>Nama Lengkap</td>
		<td><input type=text name=nama_lengkap value='$w[nama_lengkap]'></td></tr>
	<tr>
		<td>Email</td>
		<td><input type=text name=email value='$w[email]'></td>
	</tr>
	<tr>
		<td>Telepon</td>
		<td><input type=text name=telepon value='$w[telepon]'></td>
	</tr>";
if ($w[aktif]=='Y'){
	echo "<tr><td>Aktif ?</td><td><input type=radio name=aktif value=Y checked>Y
			<input type=radio name=aktif value=N>N</td></tr>";
		}else{
	echo "<tr><td>Aktif ?</td>    <td><input type=radio name=aktif value=Y>Y
			<input type=radio name=aktif value=N checked>N</td></tr>";
		}
	echo"<tr><td colspan=2><center>
	<div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-AdminUser.html';\">
	</div></center>
	</td></tr>
	</thead></table>";
echo"</form>";
tutup();
}

function simpan() {
		$md 			= $_POST['md']+0;
		$id		     	= $_POST['id'];
		$username     	= $_POST['username'];
        $password     	= md5($_POST[password]);
        $Jbtn   		= $_POST['Jbtn'];   
        $Level		   	= $_POST['Level'];   
        $nama_lengkap 	= $_POST['nama_lengkap'];        
        $Bagian 		= $_POST['bagian'];        
        $email        	= $_POST['email'];
        $telepon      	= $_POST['telepon'];
        $aktif    		= $_POST['aktif'];
		$id_level		=$_POST['jabatan'];
        $CekModul		=$_POST['CekModul'];
if ($md == 0) {
if (empty($_POST[password])) {
//Update Admin
    $admin=_query("UPDATE admin SET 
			nama_lengkap	= '$nama_lengkap',     
			email			= '$email',
			id_level		= '$Level',
			Bagian			= '$Bagian',
			Jabatan			= '$Jbtn',
			telepon			= '$telepon',
			aktif			= '$aktif'                       
			WHERE id = '$id'"); 
//Update Useryapan
	$useryapan=_query("UPDATE useryapan SET 
			Nama			= '$nama_lengkap',     
			email			= '$email',
			LevelID			= '$Level',
			username		= '$username',
			aktif			= '$aktif'                       
			WHERE UserID	= '$id'");
    }else{
//Update Admin
    $admin=_query("UPDATE admin SET 
			nama_lengkap	= '$nama_lengkap', 
			password    	= '$password',
			email			= '$email',
			id_level		= '$Level',
			Bagian			= '$Bagian',
			Jabatan			= '$Jbtn',
			telepon			= '$phone',
			aktif			= '$aktif'                       
			WHERE id		= '$id'"); 
//Update Useryapan
	$useryapan=_query("UPDATE useryapan SET 
			password    	= '$password',
			Nama			= '$nama_lengkap',     
			email			= '$email',
			LevelID			= '$Level',
			Bagian			= '$Level',
			username		= '$username',
			aktif			= '$aktif'                       
			WHERE UserID	= '$id'");
  
    }
PesanOk("Update User","User Berhasil di Update ","go-AdminUser.html");
  } else {
	$ada = GetFields('admin', 'username', $username, '*');
	$ada1 = GetFields('useryapan', 'username', $username, '*');
    if (empty($ada) && empty($ada1) ) {
//masukkan Admin
$User = "INSERT INTO admin(id_level,Identitas_ID,kode_jurusan,username,password,Bagian,Jabatan,nama_lengkap,email,telepon,foto,aktif)VALUES('$Level',0,0,'$username','$password','$Bagian','$Jbtn','$nama_lengkap','$email','$telepon','','$aktif')";
$InsertUser=_query($User);	
//masukkan User
$UserYapan ="INSERT INTO useryapan(username,password,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,email,aktif,Log,SessionID)VALUES
	('$username','$password','$Level','$nama_lengkap','$_SESSION[Identitas]','$_SESSION[prodi]','$Bagian','$Jbtn','$email','$aktif','','')";
	$InsertUserYapan=_query($UserYapan);	
    PesanOk("Tambah User Baru","Data User Berhasil Di Simpan","go-AdminUser.html");
} else {      
	PesanEror("Gagal Menambah User", "Username : $username Sudah ada dalam database");
	}
  }
}
function aplodFotoUserAdmin(){
  $id = $_POST['Id'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$id;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_user/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE admin set foto='$dest' where id='$id'";
    $r = _query($s);
PesanOk("Upload Foto User","Upload Foto Berhasil","actions-AdminUser-edit-0-$id.html");	
  } else { 
PesanEror("Upload Foto User", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
}

switch($_GET[PHPIdSession]){
	default:
      defuser();
	break;  
  
	case"edit":
      edit();
	break; 

	case"update":
		simpan();
	break;

case "aplodFotoUserAdmin":
    aplodFotoUserAdmin();
  break; 

case "hapus":
 $cek=_fetch_array(_query("SELECT * FROM admin WHERE id='$_GET[id]'"));
	if ($cek['foto']!=''){
    $tabel="admin";
	$kondisi="id='$_GET[id]'";
	delete($tabel,$kondisi);
	
	$tabel1="useryapan";
	$kondisi1="username='$cek[username]'";
	delete($tabel1,$kondisi1);

	$tabel2="hakmodul";
	$kondisi2="id_level='$cek[Jabatan]'";
	delete($tabel2,$kondisi2);
	
	unlink("$cek[foto]");
	}else{
	$tabel="admin";
	$kondisi="id='$_GET[id]'";
	delete($tabel,$kondisi);
	
	$tabel1="useryapan";
	$kondisi1="username='$cek[username]'";
	delete($tabel1,$kondisi1);

	$tabel2="hakmodul";
	$kondisi2="id_level='$cek[Jabatan]'";
	delete($tabel2,$kondisi2);
	}
    PesanOk("Hapus User","Data User Berhasil Di Hapus","go-AdminUser.html");
break;
}
?>
