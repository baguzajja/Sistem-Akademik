<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('program', 'ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT PROGRAM KELAS $w[nama_program]";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$w[ID]'>";
  } else {
    $w = array();
    $w['ID']= '';
    $w['Program_ID']= '';
    $w['nama_program']= '';
    $w['Identitas_ID'] = '';
    $w['aktif'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH PROGRAM KELAS";
    $hiden = "";
	$btn = "SIMPAN";
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
	<label class='control-label'>Institusi</label>
	<div class='controls'>
		<select name='institusi' class='input-xxlarge'>";
         $ins=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
			while($in=_fetch_array($ins)){
				$s=($in[Identitas_ID]==$w[Identitas_ID])? 'selected':'';
				echo "<option value='$in[Identitas_ID]' $s>$in[Nama_Identitas]</option>";
		}
    echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Kode Program </label>
	<div class='controls'>
		<input type='text' name='Program_ID' value='$w[Program_ID]' class='input-xxlarge' placeholder='Kode Program Kelas' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Program</label>
	<div class='controls'>
		<input type='text' name='nama_program' value='$w[nama_program]' class='input-xxlarge' placeholder='Nama Program Kelas' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls row-fluid'>";
		if($w['aktif'] == 'Y'){
			echo"<input type=radio name='aktif' value='Y' checked>Y 
				<input type=radio name='aktif' value='N'>N ";
		}else{
			echo"<input type=radio name='aktif' value='Y'>Y 
				<input type=radio name='aktif' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanKelas'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-kelas.html';\">
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>