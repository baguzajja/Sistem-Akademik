<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
 if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('kurikulum', 'Kurikulum_ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT KONSENTRASI";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[Kurikulum_ID]'>";
  } else {
    $w = array();
    $w['Kode']= '';
    $w['Nama']= '';
    $w['Identitas_ID'] = $_SESSION[Identitas];
    $w['Jurusan_ID'] = '';
    $w['Sesi'] = '';
    $w['JmlSesi'] = '';
    $w['Aktif'] = 'N';
    $jdl = "<i class='icon-plus'></i> TAMBAH KONSENTRASI";
    $btn = "SIMPAN";
    $hiden = "";
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
<div class='control-group'>
	<label class='control-label'>Program Studi</label>
	<div class='controls'>
			<div class='row-fluid'>
				<div class='span4'>
						<select name='jurusan' class='span12' required>
						<option value=''>- Pilih Program Studi -</option>";
						$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$w[Identitas_ID]'";
						$qryp=_query($sqlp) or die();
						while ($d1=_fetch_array($qryp)){
						if ($d1['kode_jurusan']==$w['Jurusan_ID']){ $cek="selected"; } else{ $cek=""; }
						echo "<option value='$d1[kode_jurusan]' $cek> $d1[nama_jurusan]</option>";
						}
					echo"</select>
				</div>
				<div class='span8'>
					<label class='control-label'>Institusi</label>
					<div class='controls'>
					<select name='identitas' class='span12' required>
					<option value=''>- Pilih Institusi -</option>";
					$sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
					$qryp=_query($sqlp) or die();
					while ($d=_fetch_array($qryp)){
					if ($d['Identitas_ID']==$w['Identitas_ID']){ $cek="selected"; } else{ $cek=""; }
					echo "<option value='$d[Identitas_ID]' $cek>$d[Nama_Identitas]</option>";
					}
					echo "</select></div>
				</div>
			</div>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Kode Konsentrasi</label>
	<div class='controls'>
			<div class='row-fluid'>
				<div class='span4'>
					<input type=text name='Kode' class='span12' value='$w[Kode]' Placeholder='Kode Konsentrasi ..' required>
				</div>
				<div class='span8'>
					<label class='control-label'>Nama Konsentrasi</label>
					<div class='controls'>
						<input type='text' class='span12' name='Nama' value='$w[Nama]' Placeholder='Nama Konsentrasi ...' required>
					</div>
				</div>
			</div>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Sesi</label>
	<div class='controls'>
			<div class='row-fluid'>
				<div class='span4'>
					<input type='text' name='Sesi' value='$w[Sesi]' class='span12' Placeholder='Kode Konsentrasi ..'>
				</div>
				<div class='span4'>
					<label class='control-label'>Jumlah Sesi/ Tahun</label>
					<div class='controls'>
						<input type='text' class='span12' name='JmlSesi' value='$w[JmlSesi]' Placeholder='Jumlah Sesi ...'>
					</div>
				</div>
				<div class='span4'>
					<label class='control-label'>Status</label>
					<div class='controls'>";
							if($w['Aktif'] == 'Y'){
								echo"<input type=radio name=Aktif value='Y' checked>Y 
									<input type=radio name=Aktif value='N'>N ";
							}else{
								echo"<input type=radio name=Aktif value='Y'>Y 
									<input type=radio name=Aktif value='N' checked>N ";
							}
					echo"</div>
				</div>
			</div>
	</div>
</div>	
<div class='form-actions'><div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanKonsentrasi'>
	<input type='button' value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-matakuliah-konsentrasi.html';\">
</div></div>		
</fieldset>	
</form>";
?>					
</div></div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>