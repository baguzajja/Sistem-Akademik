<?php 
defined('_FINDEX_') or die('Access Denied'); 
global $TahunIni, $saiki;
    $w = GetFields('admin', 'username', $_SESSION[yapane], '*');
	$jdl = "<i class='icon-pencil'></i>PROFILE ADMIN";
    $hiden = "<input type=hidden name='id' value='$w[id]'>
				<input type=hidden name='username' value='$w[username]'>";
	$username = "<input type=text value='$w[username]' class='input-xxlarge' disabled>";
	$btn='UPDATE';
	$Ppwd='Biarkan kosong jika tidak diubah';
?>
<div class="row">
<div class="span8">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><?php echo $jdl;?></h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post' enctype='multipart/form-data'> 
	 $hiden
<fieldset>
<div class='control-group'>
	<label class='control-label'>Nama Lengkap</label>
	<div class='controls'>
		<input type=text name=nama_lengkap value='$w[nama_lengkap]' class='input-xxlarge' required>
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
		<input placeholder='$Ppwd' type='password' name='password' class='input-xxlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Level User</label>
	<div class='controls'>
		<select name='Level' class='input-xxlarge' disabled>
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
		<select name='bagian' class='input-xxlarge' disabled>
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
		<select name='Jbtn' class='input-xxlarge' disabled><option value=''>- Pilih Jabatan -</option>";
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
		<input type='text' name='email' value='$w[email]' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Telephone</label>
	<div class='controls'>
		<input type=text name=telepon value='$w[telepon]' class='input-xxlarge'>
	</div>
</div> 
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanAdmin'>
</div>
</div>
</fieldset>";
?>					
</div></div></div>
<div class="span4">
	<div class="widget widget-table toolbar-bottom">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>Photo Profile</h3>		    			
		</div>

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
		<input class='btn btn-success' type="submit" name="UploadAdmin" value='Upload Foto'/>
</div></form></div></div> 		 		
</div> 