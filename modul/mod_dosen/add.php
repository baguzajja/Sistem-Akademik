<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat){ 
global $TahunIni, $saiki;
?>
<div class="row">
<div class="span12">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><i class='icon-plus'></i> TAMBAH DOSEN</h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
<fieldset>
<div class='control-group'>
	<label class='control-label'>NIDN</label>
	<div class='controls'>
		<input type='text' name='NIDN' placeholder='Nomor Induk Dosen Nasional' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Password</label>
	<div class='controls'>
		<input type='Password' name='password' placeholder='Masukkan Password' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Dosen</label>
	<div class='controls'>
		<input type='text' name='nama_lengkap' placeholder='Masukkan Nama Lengkap Dosen' class='input-xlarge' required>&nbsp;
		<input type='text' name='Gelar' placeholder='Gelar ...' class='input-medium' required>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Tempat / Tanggal Lahir</label>
	<div class='controls'>
		<input type='text' name='TempatLahir' placeholder='Masukkan Kota Kelahiran' class='input-medium'> &nbsp; &nbsp;";
		combotgl(1,31,'tgllahir',$today);
		combobln(1,12,'blnlahir',$BulanIni);
		combothn($TahunIni-100,$TahunIni+1,'thnlahir',$TahunIni);  
    echo"</div>
</div>

<div class='control-group'>
	<label class='control-label'>Agama</label>
	<div class='controls'>
		<select name='Agama'>
			<option value=''>- Pilih Agama -</option>";
			$t=_query("SELECT * FROM agama ORDER BY agama_ID");
			while($a=_fetch_array($t)){
			echo "<option value='$a[agama_ID]'> $a[nama]</option>";
			}   
			echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Telepon</label>
	<div class='controls'>
		<input type='text' name='Telepon' placeholder='Masukkan No Telp ...' class='input-medium'>&nbsp;
		<input type='text' name='Handphone' placeholder='Masukkan No Hp ...' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Email</label>
	<div class='controls'>
		<input type='text' name='Email' placeholder='Masukkan Alamat Email Valid' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Institusi</label>
	<div class='controls'>
		<select name='identitas' class='input-xxlarge'>
			<option value=''>- Pilih Institusi -</option>";
				$ins=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
				while($in=_fetch_array($ins)){
				echo "<option value=$in[Identitas_ID]> $in[Nama_Identitas]</option>";
				} 
			echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jabatan</label>
	<div class='controls'>
		<select name='Jbtn' class='input-xxlarge'>
			<option value=''>- Pilih Jabatan -</option>";
				$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Nama");
					while($j=_fetch_array($jbtn)){
					echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
				}
			echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Program Studi</label>
	<div class='controls'>";
		$tampil=_query("SELECT * FROM jurusan ORDER BY jurusan_ID");
		while($r=_fetch_array($tampil)){
		echo "<input type='checkbox' name='Jurusan_ID[]' value='$r[kode_jurusan]' >  $r[nama_jurusan]<br>";
		}		
echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls'>
		<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N 
	</div>
</div>  
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanDosen'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-dosen.html';\">
</div>
</fieldset></form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>