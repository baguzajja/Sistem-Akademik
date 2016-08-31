<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $Bukid 		= $_REQUEST['id'];
    $w 			= GetFields('buku', 'id', $Bukid, '*');
	$jdl		= "<i class='icon-pencil'></i> EDIT MASTER BUKU";
	$btn		= "UPDATE";
    $hiden 		= "<input type=hidden name='id' value='$w[id]'>";
  } else {
    $w = array();
    $w['id'] 	= '';
    $w['nama'] 	= '';
	$jdl 		= "<i class='icon-plus'></i> TAMBAH MASTER BUKU";
	$btn 		= "SIMPAN";
    $hiden 		= "";
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
				<label class='control-label'>Nama Buku</label>
				<div class='controls'>
					<input type=text name='namaBuku' value='$w[nama]'>
				</div>
			</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanBuk'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-masterkeuangan.html';\">
</div> 
</div> 
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>