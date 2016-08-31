<?php
function defaultkaryawan(){
$link="<a class='btn btn-mini btn-success' href='action-AdminKaryawan-edit-1.html'>Tambah Staff</a>";
buka("Manajemen Admin Karyawan",$link);
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>Modul</th><th>Nama Lengkap </th><th>Jabatan</th><th>E-mail</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr></thead><tbody>"; 
	$sql="SELECT * FROM karyawan ORDER BY nama_lengkap ASC";
	$qry= _query($sql)
	or die ();
	while ($data=_fetch_array($qry)){
	$dept=NamaDepatmen($data[Bagian]);
	$Jbatan=NamaJabatan($data[Jabatan]);
	$sttus = ($data['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$no++;
	echo "<tr>              
		<td>$no</td>               
		<td><a href='actions-AdminKaryawan-edit-0-$data[id].html'>$data[nama_lengkap]</a></td>
		<td>$dept - $Jbatan</td>
		<td>$data[email]</td>
		<td>$data[telepon]</td>
		<td><center>$sttus</center></td>
		<td>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='actions-AdminKaryawan-edit-0-$data[id].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-AdminKaryawan-hapus-$data[id].html' onClick=\"return confirm('Anda yakin akan Menghapus data Staff ?')\">Hapus</a>
			</div>
		</center>
		</td></tr>";
      }
      echo "</tbody></table>";
}
function edit(){
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('karyawan', 'id', $id, '*');
	$jdl = "UPDATE DATA USER ADMIN";
    $hiden = "<input type=hidden name='id' value='$w[id]'>
			<input type=hidden name='username' value='$w[username]'>";
	$username = "<input type=text value='$w[username]' disabled>";
	$Ppwd='Biarkan kosong jika tidak diubah';
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan',$w[kode_jurusan]); 
  } else {
    $w = array();
    $w['id_level']= '';
    $w['Identitas_ID']= $_SESSION[Identitas];
    $w['kode_jurusan']= '';
    $w['username'] = '';
    $w['Bagian'] = '';
    $w['Jabatan'] = '';
    $w['nama_lengkap'] = '';
    $w['email'] = '';
    $w['telepon'] = '';
    $w['foto'] = '';
    $w['aktif'] = '';
    $jdl = "TAMBAH STAFF BARU";
    $hiden = "";
    $username = "<input type=text name=username value='$w[username]'>";
	$profile='';
	$Ppwd='Masukkan Password Min 6 Karakter';
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan',''); 
  }
buka($jdl);
if($md == 0){
	$MaxFileSize = 50000;
	$foto	= (empty($w['foto'])) ? 'file/no-foto.jpg' : $w['foto'];
	$jabatan=NamaJabatan($w[Jabatan]);
	echo"<form method=post enctype='multipart/form-data' action='aksi-AdminKaryawan-aplodFotoUserkarywan.html'>  
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
			<a class='btn btn-danger' href='go-AdminKaryawan.html'><i class='icon-undo'></i> Kembali</a> 
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
echo"<form method=POST action=aksi-AdminKaryawan-update.html>
	<input type=hidden name='md' value='$md'>
	 $hiden
	<div class='row-fluid'><table class='table table-bordered table-striped'><thead>      
	<tr>
		<td>Username</td>
		<td>$username</td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input placeholder='$Ppwd' type=password name=password class='span12'></td>
	</tr>
	<tr><td class=cc>Institusi</td>  <td> 
		<select name='identitas' class='span6'>";
            $tampil=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
            while($r=_fetch_array($tampil)){
			if($r[Identitas_ID]==$w[Identitas_ID]){
		echo "<option value=$r[Identitas_ID] selected>$r[Nama_Identitas]</option>";
				}else{
		echo "<option value=$r[Identitas_ID]>$r[Nama_Identitas]</option>";
				}
            }
		 
    echo" </select></td></tr>
	<tr><td>Level User</td> <td>
		<select name='Level' class='span6'>
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
	<tr><td class=cc>Departemen</td>   <td><select name='bagian' class='span6'>"; 
		$tampil=mysql_query("SELECT * FROM departemen ORDER BY DepartemenId");
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
		<select name='Jbtn' class='span6'>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk NOT IN ('dosen','mahasiswa','Ti') ORDER BY Nama");
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
		<td><input type=text name=nama_lengkap value='$w[nama_lengkap]' class='span6'></td></tr>
	<tr>
		<td>Email</td>
		<td><input type=text name=email value='$w[email]' class='span6'></td>
	</tr>
	<tr>
		<td>Telepon</td>
		<td><input type=text name=telepon value='$w[telepon]' class='span6'></td>
	</tr>"; 
    echo "<tr><td class=cc>Program Studi</td>  <td>$d</td></tr>"; 
if ($w[aktif]=='Y'){
	echo "<tr><td>Aktif ?</td><td><input type=radio name=aktif value=Y checked>Y
			<input type=radio name=aktif value=N>N</td></tr>";
		}else{
	echo "<tr><td>Aktif ?</td>    <td><input type=radio name=aktif value=Y>Y
			<input type=radio name=aktif value=N checked>N</td></tr>";
		}
	echo"<tr><td colspan=2 class='well'>
<center>
	<div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-AdminKaryawan.html';\">
	</div>
</center>
	</td></tr>
	</thead></table></div>";
echo"</form>";
tutup();
}

function simpan() {
		$md 			= $_POST['md']+0;
		$id		     	= $_POST['id'];
		$identitas		= $_POST['identitas'];
		if (!empty($_POST[kode_jurusan])){
		$jur = $_POST[kode_jurusan];
		$tag=implode(',',$jur);
		}
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
//Update Karywan
 $update=_query("UPDATE karyawan SET 
	username 		= '$username',                                          
	Jabatan			= '$Jbtn',
	Bagian			= '$Bagian',
	nama_lengkap	= '$nama_lengkap',
	Identitas_ID	= '$identitas',
	kode_jurusan	= '$tag',
	email			= '$email',
	telepon			= '$telepon',
	id_level		= '$Level',
	aktif			= '$aktif'                       
	WHERE id	= '$id'");
//Update Useryapan
$useryapan=_query("UPDATE useryapan SET 
			Nama			= '$nama_lengkap',     
			email			= '$email',
			Jabatan			= '$Jbtn',
			LevelID			= '$Level',
			Bagian			= '$Bagian',
			username		= '$username',
			aktif			= '$aktif'                       
			WHERE UserID	= '$id'");
}else{
//Update Karywan
$update=_query("UPDATE karyawan SET 
	username 		= '$username',                                          
	Jabatan			= '$Jbtn',
	Bagian			= '$Bagian',
	nama_lengkap	= '$nama_lengkap',
	password    	= '$password',
	Identitas_ID	= '$identitas',
	kode_jurusan	= '$tag',
	email			= '$email',
	telepon			= '$telepon',
	id_level		= '$Level',
	aktif			= '$aktif'                       
	WHERE id	= '$id'");
//Update Useryapan
	$useryapan=_query("UPDATE useryapan SET 
			password    	= '$password',
			Nama			= '$nama_lengkap',     
			email			= '$email',
			Jabatan			= '$Jbtn',
			kodeProdi		= '$tag',
			LevelID			= '$Level',
			Bagian			= '$Bagian',
			username		= '$username',
			aktif			= '$aktif'                       
			WHERE UserID	= '$id'");
    }
PesanOk("Update Karyawan","Karyawan Berhasil di Update","go-AdminKaryawan.html");
  } else {
	$ada = GetFields('karyawan', 'username', $username, '*');
	$ada1 = GetFields('useryapan', 'username', $username, '*');
    if (empty($ada) && empty($ada1) ) {
//masukkan karyawan
  $query = "INSERT INTO karyawan(id_level,username,password,Jabatan,Bagian,nama_lengkap,Identitas_ID,kode_jurusan,email,telepon,aktif)VALUES('$Level','$username','$password','$Jbtn','$Bagian','$nama_lengkap','$identitas','$tag','$email','$telepon','$aktif')";
        _query($query);
//masukkan User		
	$UserYapan ="INSERT INTO useryapan(username,password,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,email,aktif,Log,SessionID)VALUES
	('$username','$password','$Level','$nama_lengkap','$identitas','$tag','$Bagian','$Jbtn','$email','$aktif','','')";
	$InsertUserYapan=_query($UserYapan);	
    PesanOk("Tambah Karyawan Baru","Data Karyawan Berhasil Di Simpan","go-AdminKaryawan.html");
} else {      
	PesanEror("Gagal Menambah User", "Username : $username Sudah ada dalam database");
	}
  }
}

function aplodFotoUserkarywan(){
  $id = $_POST['Id'];
  $acak           = rand(50,99);
  $nama_file_unik = $acak.$id;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_user/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE karyawan set foto='$dest' where id='$id'";
    $r = _query($s);
PesanOk("Upload Foto User","Upload Foto Berhasil","get-AdminKaryawan-EditAdminKaryawan-$id.html");	
  } else { 
PesanEror("Upload Foto User", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
}
switch($_GET[PHPIdSession]){
	default:
      defaultkaryawan();
	break;  
  
	case"edit":
      edit();
	break; 

	case"update":
		simpan();
	break;

  case "aplodFotoUserkarywan":
    aplodFotoUserkarywan();
  break;

case "hapus":
$cek=_fetch_array(_query("SELECT * FROM karyawan WHERE id='$_GET[id]'"));
	if ($cek['foto']!=''){
		$sql="DELETE FROM karyawan WHERE id='$_GET[id]'";
		$qry=_query($sql) or die ("SQL ERROR"._error());
	
		$tabel1="useryapan";
		$kondisi1="username='$cek[username]'";
		delete($tabel1,$kondisi1);

		$tabel2="hakmodul";
		$kondisi2="id_level='$cek[Jabatan]'";
		delete($tabel2,$kondisi2);
		
		unlink("$cek[foto]");
	}else{
		$sql="DELETE FROM karyawan WHERE id='$_GET[id]'";
		$qry=_query($sql) or die ("SQL ERROR"._error());
		$tabel1="useryapan";
		$kondisi1="username='$cek[username]'";
		delete($tabel1,$kondisi1);
		$tabel2="hakmodul";
		$kondisi2="id_level='$cek[Jabatan]'";
		delete($tabel2,$kondisi2);
	}
	PesanOk("Hapus Data Staff","Data Staff Berhasil di Hapus ","go-AdminKaryawan.html"); 
break;

}
?>
