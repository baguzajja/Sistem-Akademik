<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('kampus', 'Kampus_ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT KAMPUS $w[Nama]";
	$btn = "UPDATE";
	$disable = "disabled";
    $hiden = "<input type=hidden name='ID' value='$w[Kampus_ID]'>";
  } else {
    $w = array();
    $w['Kampus_ID']= '';
    $w['Nama']= '';
    $w['Alamat']= '';
    $w['Kota'] = '';
    $w['Identitas_ID'] = '';
    $w['Telepon'] = '';
    $w['Fax'] = '';
    $w['Aktif'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH KAMPUS";
    $hiden = "";
    $disable = "required";
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
	<label class='control-label'>Kode Kampus </label>
	<div class='controls'>
		<input type='text' name='Kampus_ID' value='$w[Kampus_ID]' class='input-xxlarge' placeholder='Kode Kampus' $disable>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Kampus</label>
	<div class='controls'>
		<input type='text' name='Nama' value='$w[Nama]' class='input-xxlarge' placeholder='Nama Kampus' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Alamat Kampus</label>
	<div class='controls'>
		<input type='text' name='Alamat' value='$w[Alamat]' class='input-xxlarge' placeholder='Alamat Kampus' required>
		<input type='text' name='Kota' value='$w[Kota]' class='input-xlarge' placeholder='Kota' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tlp - Fax</label>
	<div class='controls'>
		<input type='text' name='Telepon' value='$w[Telepon]' class='input-xlarge' placeholder='No Telepon' required>
		<input type='text' name='Fax' value='$w[Fax]' class='input-xlarge' placeholder='Fax' required>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls row-fluid'>";
		if($w['Aktif'] == 'Y'){
			echo"<input type=radio name='Aktif' value='Y' checked>Y 
				<input type=radio name='Aktif' value='N'>N ";
		}else{
			echo"<input type=radio name='Aktif' value='Y'>Y 
				<input type=radio name='Aktif' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanKampus'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-kampus.html';\">
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>