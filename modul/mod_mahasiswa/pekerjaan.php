<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat AND $edit){ 
global $TahunIni, $saiki;
 $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id 	= $_REQUEST['id'];
    $p 		= GetFields('dosenpekerjaan', 'DosenPekerjaanID', $id, '*');
    $hiden 	= "<input type='hidden' name='DosenPekerjaanID' value='$p[DosenPekerjaanID]'>";
    $dosen 	= "<input type='hidden' name='DosenID' value='$p[DosenID]'>";
	$ds		= GetFields('dosen', 'dosen_ID', $p[DosenID], '*');
	$jdl 	= "<i class='icon-pencil'></i>EDIT PEKERJAAN DOSEN : $ds[nama_lengkap]";
	$btn	='UPDATE';
  } else {
	$id 	= $_REQUEST['id'];
	$ds		= GetFields('dosen', 'dosen_ID', $id, '*');
    $w = array();
    $w['DosenPekerjaanID']= '';
    $w['DosenID']= '';
    $w['Jabatan']= '';
    $w['Institusi']= '';
    $w['Alamat'] = '';
    $w['Kota'] = '';
    $w['Kodepos'] = '';
    $w['Telepon'] = '';
    $w['Fax'] = '';
    $jdl = "<i class='icon-plus'></i>TAMBAH PEKERJAAN DOSEN : $ds[nama_lengkap]";
    $hiden = "";
	$dosen 	= "<input type='hidden' name='DosenID' value='$id'>";
	$btn='SIMPAN';
  }
?>
<div class="row">
	<div class="span8">
<div class="widget widget-form">
<div class='widget-header'>
	<h3><?php echo $jdl;?></h3>
		<div class='widget-actions'>
			<div class='btn-group'>
				<button class='btn btn-small btn-info' onClick="history.back()"><i class="icon-undo"></i> Kembali</button>
			</div>				
		</div> 
</div> 
<?php 
echo "<div class='widget-content'>
	<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	$hiden
	$dosen
<div class='control-group'>
	<label class='control-label'>Nama Institusi</label>
	<div class='controls'>
		<input type=text name='Institusi' value='$p[Institusi]' class='input-xxlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jabatan</label>
	<div class='controls'>
		<input type=text name='Jabatan' value='$p[Jabatan]' class='input-xxlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Alamat Institusi</label>
	<div class='controls'>
		<input type=text name='Alamat' value='$p[Alamat]' class='input-xlarge'>
		<input type=text name='Kota' value='$p[Kota]' class='input-medium' placeholder='Kota'>
		<input type=text name='Kodepos' value='$p[Kodepos]' class='input-small' placeholder='Kode Pos'>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Telepon</label>
	<div class='controls'>
		<input type=text name='Telepon' value='$p[Telepon]' class='input-medium'>
		<input type=text name='Fax' value='$p[Fax]' class='input-xlarge' placeholder='Fax'>
	</div>
</div>
</div>";						
?>	
<div class='widget-toolbar'>
	<center>
		<input class='btn btn-success btn-large' type='submit' name='UpdatePekerjaan' value='<?php echo $btn; ?>'>
	</center>
</div>	
</form>				
</div>
</div></div>
<?php }else{ ErrorAkses(); } ?>