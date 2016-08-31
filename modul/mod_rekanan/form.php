<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('rekanan', 'RekananID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT DATA REKANAN";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$w[RekananID]'>"; 
  } else {
    $w = array();
    $w['RekananID']= '';
    $w['NamaRekanan']= '';
    $w['Institusi'] = '';
    $w['Alamat'] = '';
    $w['Kota'] = '';
    $w['Kodepos'] = '';
    $w['Telepon'] = '';
    $w['telepon'] = '';
    $w['Fax'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH REKANAN";
    $hiden = "";
	$btn = "SIMPAN";
  }
?>
<div class="row">
<div class="span8">
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
	<label class='control-label'>Nama Lengkap</label>
	<div class='controls'>
		<input type=text name='NamaRekanan' value='$w[NamaRekanan]' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Perusahaan</label>
	<div class='controls'>
		<input type=text name='Institusi' value='$w[Institusi]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Alamat</label>
	<div class='controls'>
		<input type=text name='Alamat' value='$w[Alamat]' class='input-xxlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'></label>
	<div class='controls'>
		<input type=text name='Kota' value='$w[Kota]' placeholder='Kota' class='input-medium'>
		<input type=text name='Kodepos' value='$w[Kodepos]' placeholder='Kode Pos' class='input-medium'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Telephone</label>
	<div class='controls'>
		<input type=text name='Telepon' value='$w[Telepon]' placeholder='Telepon' class='input-medium'>
		<input type=text name='Fax' value='$w[Fax]' placeholder='Fax' class='input-medium'>
	</div>
</div>

<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanRekanan'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-rekanan.html';\">
</div>
</fieldset></form>";
?>					
</div></div></div>
<div class="span4">
	<div class="widget">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>MODUL REKANAN</h3>		    			
		</div>
	<div class="widget-content">
	<ul>
		<li>Menu Ini Berfungsi untuk mengelola data Rekanan.</li>
		<li>Menambah Rekanan Baru.</li>
		<li>Meng Edit Data Rekanan.</li>
		<li>Meng Hapus Data Rekanan.</li>
	</ul>
	</div>
</div></div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>