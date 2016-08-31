<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('rekening', 'RekeningID', $rekid, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT REKENING";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='RekeningID' value='$w[RekeningID]'>";
  }
  else {
    $w = array();
    $w['RekeningID'] = '';
    $w['NoRekening'] = '';
    $w['Nama'] = '';
    $w['Bank'] = '';
    $w['NA'] = 'N';
    $jdl = "<i class='icon-plus'></i> TAMBAH REKENING";
	$btn = "SIMPAN";
    $hiden = "";
  }
  $na = ($w['Aktif'] == 'Y')? 'checked' : '';
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
				<label class='control-label' for='name'>Nomer Rekening</label>
			<div class='controls'>
				<input type=text name='NoRekening' value='$w[NoRekening]' class='input-xlarge'>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Atas Nama</label>
					<div class='controls'>
						<input type=text class='input-xlarge' id='Nama' name='Nama' value='$w[Nama]'>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Nama Bank</label>
				<div class='controls'>
				<input type=text class='input-xlarge' id='Bank' name='Bank' value='$w[Bank]' >
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Aktif ? </label>
				<div class='controls'>
					<input type=checkbox name='NA' value='Y' $na >
				</div>
			</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanRek'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-settingKeuangan.html';\">
</div> 
</div> 
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>