<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('kelompokmtk', 'KelompokMtk_ID', $id, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT KELOMPOK MATAKULIAH";
	$btn = "UPDATE";
    $disabled = "disabled";
	$hiden = "<input type=text class='span12' value='$w[KelompokMtk_ID]' Placeholder='Kode ID ..(A-Z)' readonly><input type=hidden name='Kode' value='$w[KelompokMtk_ID]'>";
  } else {
    $w = array();
    $w['KelompokMtk_ID']= '';
    $w['Nama']= '';
    $w['Aktif'] = 'N';
    $jdl = "<i class='icon-plus'></i> TAMBAH KELOMPOK MATAKULIAH";
    $btn = "SIMPAN";
    $hiden = "<input type=text name='Kode' class='span12' value='$w[KelompokMtk_ID]' Placeholder='Kode ID ..(A-Z)' required>";
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
<fieldset>
<div class='control-group'>
	<label class='control-label'>ID KODE MTK</label>
	<div class='controls'>
			<div class='row-fluid'>
				<div class='span4'>
					$hiden
				</div>
				<div class='span4'>
					<label class='control-label'>NAMA KODE </label>
					<div class='controls'>
						<input type='text' class='span12' name='Nama' value='$w[Nama]' Placeholder='Nama KODE ...' required>
					</div>
				</div>
				<div class='span4'>
					<label class='control-label'>STATUS</label>
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
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanKodeMtk'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-matakuliah-KodeMtk.html';\">
</div></div>		
</fieldset>	
</form>";
?>					
</div></div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>