<?php 
defined('_FINDEX_') or die('Access Denied');
if($edit AND $buat){ 
global $TahunIni, $saiki;
?>
<div class="row">
<form class='form-horizontal' method='post' enctype='multipart/form-data'>
<div class="span8">
	<div class="widget widget-form">
		<div class="widget-header">
			<h3><i class="icon-pencil"></i>IMPORT DATA KELULUSAN</h3>
				<div class="widget-actions">
					<div class="btn-group">
					</div>					
				</div> 
		</div> 		


<div class="widget-content">
<?php 
echo"<div class='control-group'>
			<label class='control-label'>Pilih File Excel </label>
			<div class='controls'>
				<input type='file' name='import_file' class=''/>
			</div>
		</div>";
?>
</div>
	<div class='widget-toolbar'>
		<center>
		<input class='btn btn-success btn-large' type='submit' name='ImportKelulusan' value='Import Data Kelulusan'>
		</center>
	</div>

	</div> 
</div> 
			
			
<div class="span4">
	<div class="widget">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>MODUL IMPORT DATA KELULUSAN</h3>		    			
		</div>
	<div class="widget-content">
	<ul>
		<li>Menu Ini Berfungsi untuk meng-import data kelulusan mahasiswa secara massal dengan menggunakan file excel. Adapun format file excel yang akan di import harus sesuai dengan format yang telah disediakan.</li>
		<li>Format File Excel bisa di download di sini .....<a href="get-download-fileContoh-lulus.html" class="btn btn-mini pull-right"><b>Download</b></a></li>
	</ul>
	</div>
</div></div> 	
</form>
</div>  
<?php }else{ ErrorAkses(); } ?>