<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $r = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT MATAKULIAH";
	$Prodi = ($_SESSION[Jabatan]==18)? "AND Jurusan_ID='$_SESSION[prodi]'": "";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$r[Matakuliah_ID]'>";
  } else {
    $r = array();
    $r['Identitas_ID'] 		= $_SESSION[Identitas];
	$r['JenisMTK_ID']		='';
	$r['KelompokMtk_ID']	='';
	$r['StatusMtk_ID']		='';
	$r['JenisKurikulum_ID']	='';
	$r['Kurikulum_ID']		='';
	$r['Semester']			='';
	$r['Penanggungjawab']	='';
	$r['Aktif']				='';
	$r['SKS']				='';
	$r['gbpp']				='';
	$r['sap']				='';
	$Prodi = ($_SESSION[Jabatan]==18)? "AND Jurusan_ID='$_SESSION[prodi]'": "";
	$jdl = "<i class='icon-plus'></i> TAMBAH MATAKULIAH";
    $btn 					= "SIMPAN";
    $hiden 					= "";
  }
?>
<div class="row">
<div class="span12">
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
		<div class='row-fluid'>
		<div class='control-group'>
		<label class='control-label'>Institusi</label>
			<div class='controls'>
				<select name='i' id='identitas' class='span12'>
                <option value=''>- Pilih Institusi -</option>";
                $t=_query("SELECT * FROM identitas ORDER BY ID");
                while($w=_fetch_array($t)){
				$cek=($r[Identitas_ID]==$w[Identitas_ID]) ? 'selected': '';
				echo "<option value=$w[Identitas_ID] $cek>$w[Identitas_ID] - $w[Nama_Identitas]</option>";
					}
				echo "</select>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Program Studi</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'>
				<select name='jur' id='jurusan' class='span12' required>
                <option value=''>- Pilih Program Studi -</option>";
                $t=_query("SELECT * FROM jurusan ORDER BY kode_jurusan");
                while($w=_fetch_array($t)){
				$cek=($r[Jurusan_ID]==$w[kode_jurusan]) ? 'selected': '';
				echo "<option value=$w[kode_jurusan] $cek>$w[kode_jurusan] - $w[nama_jurusan]</option>";
				}
				echo "</select></div>
			<div class='span6'>
				<label class='control-label'>Kode Matakuliah</label>
				<div class='controls'>
				<input type=text name='kmk' value='$r[Kode_mtk]' class='span12' Placeholder='' required>
			</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Nama Matakuliah</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'><input type=text name='nm' class='span12' value='$r[Nama_matakuliah]' required></div>
			<div class='span6'>
				<label class='control-label'>Jenis Matakuliah</label>
				<div class='controls'>
					<select name='jmk' class='span12'>
					<option value=''>- Pilih Jenis Matakuliah -</option>";
					$tampil=_query("SELECT * FROM jenismk ORDER BY JenisMK_ID");
					while($w=_fetch_array($tampil)){
					$cek=($r[JenisMTK_ID]==$w[JenisMK_ID]) ? 'selected': '';
					echo "<option value=$w[JenisMK_ID] $cek>$w[JenisMK_ID] - $w[Nama]</option>";
					}
					echo "</select>
				</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
		<label class='control-label'>Kelompok Matakuliah</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'> <select name='klmptk' class='span12'>
                <option value=''>- Pilih Kelompok Matakuliah -</option>";
                $tampil=_query("SELECT * FROM kelompokmtk ORDER BY KelompokMtk_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[KelompokMtk_ID]==$w[KelompokMtk_ID]) ? 'selected': '';
				echo "<option value=$w[KelompokMtk_ID] $cek>  $w[Nama]</option>";
				}
				echo "</select></div>
			<div class='span6'>
				<label class='control-label'>Status Matakuliah</label>
				<div class='controls'><select name='stmk' class='span12'>
                <option value=''>- Pilih Status -</option>";
                $tampil=_query("SELECT * FROM statusmtk ORDER BY StatusMtk_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[StatusMtk_ID]==$w[StatusMtk_ID]) ? 'selected': '';
                echo "<option value=$w[StatusMtk_ID] $cek>$w[StatusMtk_ID] - $w[Nama]</option>";
				}
				echo "</select>
				</div>
			</div>
			</div>
			</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>Konsentrasi</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><select name='nkur' class='span12' required>
						<option value=''>- Pilih Nama Konsentrasi -</option>";
						$tampil=_query("SELECT * FROM kurikulum WHERE Identitas_ID='$_SESSION[Identitas]' $Prodi ORDER BY Nama ASC");
						while($w=_fetch_array($tampil)){
						$cek=($r[Kurikulum_ID]==$w[Kurikulum_ID]) ? 'selected': '';
						echo "<option value=$w[Kurikulum_ID] $cek>$w[Jurusan_ID] -  $w[Nama]</option>";
						}
				echo "</select></div>
				<div class='span6'>
					<label class='control-label'>Kurikulum</label>
					<div class='controls'><select name='jkur' class='span12' required>
                <option value=''>- Pilih Kurikulum -</option>";
                $tampil=_query("SELECT * FROM jeniskurikulum ORDER BY JenisKurikulum_ID");
                while($w=_fetch_array($tampil)){
				$cek=($r[JenisKurikulum_ID]==$w[JenisKurikulum_ID]) ? 'selected': '';
				echo "<option value=$w[JenisKurikulum_ID] $cek>$w[Nama]</option>";  
				}
				echo "</select>
					</div>
				</div>
				</div>
				</div>
		</div>

	<div class='control-group'>
			<label class='control-label'>Semester</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><input type=text name='sesi' class='span12' value='$r[Semester]'></div>
				<div class='span6'>
					<label class='control-label'>Jumlah Sks</label>
					<div class='controls'> <input type=text name='sks' class='span12' value='$r[SKS]'>
					</div>
				</div>
				</div>
				</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>Penanggung Jawab</label>
				<div class='controls'>
				<div class='row-fluid'>
				<div class='span6'><select name='pj' class='span12'>
                <option value=''>- Pilih Penanggung Jawab -</option>";
                $tampil=_query("SELECT * FROM dosen ORDER BY nama_lengkap ASC");
                while($w=_fetch_array($tampil)){
				$cek=($r[Penanggungjawab]==$w[dosen_ID]) ? 'selected': '';
				 echo "<option value=$w[dosen_ID] $cek>$w[nama_lengkap],$w[Gelar]</option>";
                 }
				echo "</select></div>
				<div class='span6'>
					<label class='control-label'>Status</label>
					<div class='controls'>";
					if ($r[Aktif]=='Y'){
					  echo "<input type=radio name='ak' value='Y' checked>Y  
							<input type=radio name='ak' value='N'> N";
					}
					else{
					  echo "<input type=radio name='ak' value='Y'>Y  
							<input type=radio name='ak' value='N' checked>N";
					}
					echo"</div>
				</div>
				</div>
				</div>
		</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>GBPP</label>
				<div class='controls'>
					<textarea id='GBPP' name='gbpp'>$r[gbpp]</textarea>
				</div>
		</div>
		<div class='control-group'>
			<label class='control-label'>SAP</label>
				<div class='controls'>
					<textarea id='SAP' name='sap'>$r[sap]</textarea>
				</div>
		</div>
<div class='form-actions'><div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanMatakuliah'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-matakuliah-all.html';\">
</div></div>		
	</fieldset>
</form>";
?>					
</div></div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>