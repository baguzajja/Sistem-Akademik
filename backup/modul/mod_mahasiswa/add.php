<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat){ 
if(empty($_POST['simpanMaba'])) {
global $today,$BulanIni,$TahunIni,$tgl_sekarang;
$noReg=NoRegister();
$id= $_POST['institusi'];
$jur= $_POST['prodi'];
$kelas= $_POST['kelas'];  
?>
<div class="row">
<div class="span12">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><i class='icon-plus'></i> MAHASISWA BARU</h3>	
	
<div class="widget-actions">
 ID PENDATARAN :<b><?php echo $noReg; ?></b>
</div> 
</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
<input name='NoReg' type='hidden' value='$noReg'>
<fieldset>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Institusi *</label>
				<div class='controls'>
					<select name='institusi' onChange='this.form.submit()' class='span12' required>
					<option value=''>-  Pilih Institusi -</option>";
					$sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
					$qryp=_query($sqlp) or die();
					while ($d1=_fetch_array($qryp)){
					$cek=($d1['Identitas_ID']==$id)? "selected":"";
					echo "<option value='$d1[Identitas_ID]' $cek>  $d1[Nama_Identitas]</option>";
						}
					echo"</select>
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Program Studi *</label>
				<div class='controls'>
					<select name='prodi' onChange='this.form.submit()' class='span12' required>
					<option value=''>- Pilih Prodi -</option>";
					$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$id'";
					$qryp=_query($sqlp) or die();
					while ($d1=_fetch_array($qryp)){
					if ($d1['kode_jurusan']==$jur){$cek="selected";}else{ $cek="";} 
					echo "<option value='$d1[kode_jurusan]' $cek> $d1[nama_jurusan]</option>";
						}
					echo"</select>
					</div>
		</div>
	</div>
</div>
<div class='control-group'>
		<div class='row-fluid'>
				<div class='span6'>
					<label class='control-label'>Konsentrasi *</label>
					<div class='controls'>
						<select name='konsentrasi' class='span12' required>
						<option value=0 selected>- Pilih Nama Konsentrasi -</option>";
						$t=_query("SELECT * FROM kurikulum WHERE Identitas_ID='$id' AND Jurusan_ID='$jur' ORDER BY Kurikulum_ID");
						while($r=_fetch_array($t)){
						echo "<option value=$r[Kurikulum_ID]> $r[Nama]</option>";
						}
						echo "</select>
					</div>
				</div>
				<div class='span6'>
					<label class='control-label'>Kelas *</label>
					<div class='controls'>
						<select name='kelas' onChange='this.form.submit()' class='span12' required>
						<option value=''>-  Pilih Kelas -</option>";
						$sqlp="SELECT * FROM program WHERE Identitas_ID='$id' ORDER BY ID";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
							if ($d['ID']==$kelas){$cek="selected";}else{ $cek="";} 
						echo "<option value='$d[ID]' $cek>$d[nama_program]</option>";
							}
						echo"</select>
					</div>
				</div>
		</div>
</div>

<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Tahun Ajaran *</label>
				<div class='controls'>
					<select name='Angkatan' class='span12' required>
					<option value=''>- Pilih Tahun Ajaran -</option>";
					$t=_query("SELECT * FROM tahun WHERE Identitas_ID='$id' ORDER BY Nama DESC");
					while($r=_fetch_array($t)){
					echo "<option value=$r[Tahun_ID]> $r[Nama]</option>";
					}
					echo "</select>
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Rekanan </label>
				<div class='controls'>
					<select name='rekanan' class='span12'>
					<option value=''>- Pilih Rekanan -</option>";
					$t=_query("SELECT * FROM rekanan ORDER BY RekananID");
					while($r=_fetch_array($t)){
					$cek=($r['RekananID']==$_POST['rekanan'])?"selected":"";
					echo "<option value='$r[RekananID]' $cek>$r[NamaRekanan]</option>";
						}
					echo "</select>
				</div>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span12'>
			<label class='control-label'>Nama Lengkap *</label>
				<div class='controls'>
					<input type='text' name='Nama' class='span12' required>
				</div>
		</div>
	</div>
</div>

<div class='control-group'>
		<div class='row-fluid'>
				<div class='span6'>
					<label class='control-label'>Tanggal Lahir *</label>
					<div class='controls'>";
					combotgl(1,31,'tgltl',$today);
					combobln(1,12,'blntl',$BulanIni);
					combothn($TahunIni-50,$TahunIni+5,'thntl',$TahunIni);
					echo "</div>
				</div>
				<div class='span6'>
					<label class='control-label'>Tempat Lahir *</label>
					<div class='controls'>
					<input type=text name=TempatLahir class='span12'>
					</div>
				</div>
		</div>
</div>

<div class='control-group'>
<div class='row-fluid'>
	<div class='span4'>
		<label class='control-label'>Jenis Kelamin</label>
			<div class='controls'>
				<input type=radio name='Kelamin' value='L' checked> Laki-Laki 
				<input type=radio name='Kelamin' value='P'> Perempuan
			</div>
	</div>
	<div class='span4'>
		<label class='control-label'>Warga Negara</label>
			<div class='controls'>
				<input type=radio name='WargaNegara' value='WNA' checked> WNA
				<input type=radio name='WargaNegara' value='WNI'> WNI
			</div>
	</div>
	<div class='span4'>
		<label class='control-label'>Jika WNA Sebutkan</label>
			<div class='controls'>
				<input type='text' name='Kebangsaan' class='span12' value='$_POST[Kebangsaan]'>	
			</div>
	</div>
</div>
</div>

<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Agama</label>
			<div class='controls'>
				<select name='Agama' class='span12'>
					<option value=''>- Pilih Agama -</option>";
					$t=_query("SELECT * FROM agama ORDER BY agama_ID");
					while($r=_fetch_array($t)){
					echo "<option value=$r[agama_ID]> $r[nama]</option>";
					}
				echo "</select>
			</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Status Sipil</label>
			<div class='controls'>
				<select name='StatusSipil' class='span12'>
				<option value=''>- Pilih Status Sipil -</option>";
						$t=_query("SELECT * FROM statussipil ORDER BY StatusSipil");
						while($r=_fetch_array($t)){
						echo "<option value=$r[StatusSipil]> $r[Nama]</option>";
							  }
				echo "</select>
			</div>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Alamat</label>
				<div class='controls'>
					<textarea type='text' name='Alamat' class='span12' placeholder='Alamat Mahasiswa...' required>$_POST[Alamat]</textarea>
				</div>
		</div>
		<div class='span3'>
			<input type=text name='RT' class='span12' placeholder='RT...' value='$_POST[RT]'>
		</div>
		<div class='span3'>
			<input type=text name='RW' class='span12' placeholder='RW...' value='$_POST[RW]'>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Kota</label>
				<div class='controls'>
					<input type=text name='Kota' class='span12' value='$_POST[Kota]'>
				</div>
		</div>
		<div class='span3'>
			<input type=text name='Propinsi' class='span12' placeholder='Propinsi...' value='$_POST[Propinsi]'>
		</div>
		<div class='span3'>
			<input type=text name='Negara' class='span12' placeholder='Negara...' value='$_POST[Negara]'>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Telepon</label>
				<div class='controls'>
					<input type=text name='Telepon' class='span12' value='$_POST[Telepon]'> 
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Hp</label>
				<div class='controls'>
					<input type=text name='Handphone' class='span12' placeholder='HP' value='$_POST[Handphone]'>
				</div>
		</div>
	</div>
</div>

<div class='control-group'>
<div class='row-fluid'>
				<div class='span6'>
				<label class='control-label'>Status Awal *</label>
				<div class='controls'>
				<select name='StatusAwal_ID' class='span12'>
					<option value=0 selected>- Pilih Status Awal Mahasiswa -</option>";
					$t=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
					while($r=_fetch_array($t)){
					echo "<option value=$r[StatusAwal_ID]> $r[Nama]</option>";
					}
					echo "</select>
				</div>
				</div>
				<div class='span6'>
					<label class='control-label'>Penasehat Akademik </label>
					<div class='controls'>
						<select name='pa' class='span12'>
						<option value=0 selected>- Pilih Penasehat Akademik -</option>";
						$t=_query("SELECT * FROM dosen WHERE Identitas_ID='$id' AND Jurusan_ID LIKE '%$jur%' ORDER BY dosen_ID");
						while($r=_fetch_array($t)){
								echo "<option value=$r[NIDN]>$r[nama_lengkap], $r[Gelar]</option>";
							  }
					echo "</select>
					</div>
				</div>
		</div>
</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanMaba'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-mahasiswa.html';\">
</div>
</div>
</fieldset>
</form></div></div></div></div> ";
}
}else{
ErrorAkses();
} ?>