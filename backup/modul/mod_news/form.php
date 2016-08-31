<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('berita', 'id', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT BERITA";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[id]'>";
  } else {
    $w = array();
    $w['id']= '';
    $w['judul']= '';
    $w['isi']= '';
    $jdl = "<i class='icon-plus'></i> TAMBAH BERITA";
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
	<label class='control-label'>Judul</label>
	<div class='controls'>
		<input type='text' name='judul' value='$w[judul]' class='input-xxlarge' placeholder='Masukkan Judul Berita...' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Isi Berita</label>
	<div class='controls'>
<textarea id='isi' name='isi' row='70' required>$w[isi]</textarea>
</div>
</div> 

<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanBerita'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-news.html';\">
</div>  
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>