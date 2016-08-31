<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('jeniskurikulum', 'JenisKurikulum_ID', $id, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT KURIKULUM";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[JenisKurikulum_ID]'>";
  } else {
    $w = array();
    $w['Kode']= '';
    $w['Nama']= '';
    $w['Jurusan_ID'] = '';
    $w['Aktif'] = 'N';
    $jdl = "<i class='icon-plus'></i> TAMBAH KURIKULUM";
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
		<label class='control-label'>Untuk Program Studi ?</label>
			<div class='controls'>
				<select name='jurusan' class='input-xlarge'>
				<option value=''>- Pilih Program Studi -</option>";
				$sqlp="SELECT * FROM jurusan ORDER BY nama_jurusan ASC";
				$qryp=_query($sqlp) or die();
				while ($d1=_fetch_array($qryp)){
				$cek=($d1['kode_jurusan']==$w['Jurusan_ID'])? "selected": ""; 
				echo "<option value='$d1[kode_jurusan]' $cek> $d1[nama_jurusan]</option>";
				}
			echo"</select>
			</div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Nama Kurikulum</label>
			<div class='controls'>
				<input type='text' class='input-xlarge' name='nama' value='$w[Nama]'>
			</div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Status Kurikulum</label>
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
		
<div class='form-actions'><div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanKurikulum'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-matakuliah-kurikulum.html';\">
</div></div>		
</fieldset>	
</form>";
?>					
</div></div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>