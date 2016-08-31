<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('inventaris', 'InventarisID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT INVENTARIS";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='InventarisID' value='$w[InventarisID]'>";
  } else {
    $w = array();
    $w['InventarisID']= '';
    $w['NamaInventaris']= '';
    $w['Institusi']= '';
    $w['Kampus'] = '';
    $w['Satuan'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH INVENTARIS";
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
	<label class='control-label'>Institusi</label>
	<div class='controls'>
		<select name='Institusi' class='input-xxlarge'>
	<option value=''>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
	while($i=_fetch_array($t)){
	$cek=($i['Identitas_ID']==$w['Institusi'])? "selected":"";
	echo "<option value='$i[Identitas_ID]' $cek> $i[Nama_Identitas]</option>";
	}                                
	echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'> Nama Inventaris </label>
	<div class='controls'>
		<input type='text' name='NamaInventaris' value='$w[NamaInventaris]' class='input-xxlarge' placeholder='Nama Inventaris'>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'> Kampus</label>
	<div class='controls'>
		<select name='Kampus' class='input-xxlarge'>
<option value=''>- Pilih Kampus -</option>";
         $kamp=_query("SELECT * FROM kampus ORDER BY Kampus_ID");
			while($k=_fetch_array($kamp)){
				$s=($k[Kampus_ID]==$w[Kampus])? 'selected':'';
				echo "<option value='$k[Kampus_ID]' $s>$k[Nama]</option>";
		}
    echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'> Satuan</label>
	<div class='controls'>
		<input type='text' name='Satuan' value='$w[Satuan]' class='input-xxlarge' placeholder=''>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Untuk Dijual ?</label>
	<div class='controls row-fluid'>";
		if($w['forsale'] == 'Y'){
			echo"<input type=radio name='forsale' value='Y' checked>Y 
				<input type=radio name='forsale' value='N'>N ";
		}else{
			echo"<input type=radio name='forsale' value='Y'>Y 
				<input type=radio name='forsale' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanInventaris'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-inventaris.html';\">
</div>  
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>