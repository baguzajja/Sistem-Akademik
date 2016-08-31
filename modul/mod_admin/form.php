<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('admin', 'id', $id, '*');
	$jdl = "<i class='icon-pencil'></i>UPDATE DATA USER ADMIN";
    $hiden = "<input type=hidden name='id' value='$w[id]'>
			<input type=hidden name='username' value='$w[username]'>";
	$username = "<input type=text value='$w[username]' disabled>";
	$btn='UPDATE';
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
    $jdl = "<i class='icon-plus'></i>TAMBAH USER BARU";
    $hiden = "";
    $username = "<input type=text name=username />";
	$btn='SIMPAN';
	$Ppwd='Masukkan Password Min 6 Karakter';
  }
?>
<div class="row">
<div class="span8">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><?php echo $jdl;?></h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	 $hiden
<fieldset>
<div class='control-group'>
	<label class='control-label'>Nama Lengkap</label>
	<div class='controls'>
		<input type=text name=nama_lengkap value='$w[nama_lengkap]' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Username</label>
	<div class='controls'>
		$username
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Password</label>
	<div class='controls'>
		<input placeholder='$Ppwd' type=password name=password>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Level User</label>
	<div class='controls'>
		<select name='Level' required>
			<option value=''>- Pilih Level User -</option>";
			$level=_query("SELECT * FROM level ORDER BY id_level");
			while($l=_fetch_array($level)){
				$s=($l[id_level]==$w[id_level])? "selected":"";
			echo "<option value=$l[id_level] $s>$l[level]</option>";
			}
	echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Departemen</label>
	<div class='controls'>
		<select name='bagian' required>
			<option value=''>- Pilih Departemen -</option>";
			$dept=mysql_query("SELECT * FROM departemen ORDER BY DepartemenId");
				while($r=mysql_fetch_array($dept)){
				$s=($r[DepartemenId]==$w[Bagian])? "selected":"";
			echo "<option value=$r[DepartemenId] $s>$r[NamaDepeartemen]</option>";
			}
	echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jabatan</label>
	<div class='controls'>
		<select name='Jbtn' required><option value=''>- Pilih Jabatan -</option>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='Ti' ORDER BY Nama");
			while($j=_fetch_array($jbtn)){
				$s=($j[Jabatan_ID]==$w[Jabatan])? "selected":"";
				echo "<option value=$j[Jabatan_ID] $s>$j[Nama]</option>";
			}
	echo "</select>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Email</label>
	<div class='controls'>
		<input type=text name=email value='$w[email]' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Telephone</label>
	<div class='controls'>
		<input type=text name=telepon value='$w[telepon]'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls'>";
	if($w[aktif]=='Y'){
		echo"<input type=radio name=aktif value='Y' checked>Y 
			<input type=radio name=aktif value='N'>N ";
	}else{
		echo"<input type=radio name=aktif value='Y'>Y 
			<input type=radio name=aktif value='N' checked>N ";
	}
	echo"</div>
</div>  
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanAdmin'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-admin.html';\">
</div>
</fieldset></form>";
?>					
</div></div></div>
<div class="span4">
	<div class="widget widget-table toolbar-bottom">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>Photo Profile</h3>		    			
		</div>
<form class='form-horizontal' method='post' enctype='multipart/form-data'> 
	<div class="widget-content">
<?php
	$MaxFileSize = siteConfig('file_size');
if($w['foto']!=''){
		if (file_exists('media/images/foto_user/'.$w[foto])){
			$foto ="<img src='media/images/foto_user/medium_$w[foto]' width='100%' alt='$w[nama_lengkap]'>";
		} elseif (file_exists('media/images/'.$w[foto])){
			$foto ="<img src='media/images/$w[foto]' width='100%' alt='$w[nama_lengkap]'>";
		}else{
			$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$w[nama_lengkap]' width='100%'>";
		}
}else{
	$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$w[nama_lengkap]' width='100%'>";
}
echo"<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
		<input type=hidden name='Id' value='$w[id]' />
		<table class='table table-bordered table-striped'>
			<tbody>
				<tr class='even gradeC'>
					<td colspan=2 width='70%'>$foto</td>
				</tr>
				<tr class='odd gradeA'>
					<td>Ganti Photo</td>
					<td><input type='file' name='foto'/></td>
				</tr>							
			</tbody>
		</table>";
?>		
</div><div class='widget-toolbar'>
		<input class='btn btn-success' type='submit' name='Upload' value='Upload Foto'>
</div></form></div></div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>