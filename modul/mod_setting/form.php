<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
$namaSistem=siteConfig('site_name'); 
$site_url=siteConfig('site_url');
$site_mail=siteConfig('site_mail');
$timezone=siteConfig('timezone');
$file_allowed=siteConfig('file_allowed');
$file_size=siteConfig('file_size');
$print_def=siteConfig('printer_default');
?>
<div class="row">
<div class="span8">
<div id="validation" class="widget highlight widget-form">
	<div class="widget-header">	      				
		<h3>
			<i class="icon-cog"></i>
	      	PENGATURAN SISTEM 					
		</h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
<fieldset>
<div class='control-group'>
	<label class='control-label'>Nama Sistem</label>
	<div class='controls'>
		<input type='text' name='site_name' placeholder='Masukkan Nama Sistem' value='$namaSistem' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Url Sistem</label>
	<div class='controls'>
	<input type=text name='url' placeholder='Masukkan Url Sistem' class='' value='$site_url' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Email</label>
	<div class='controls'>
	<input type=text name='mail' placeholder='Tentukan Email Situs' class='' value='$site_mail' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Time Zone</label>
	<div class='controls'>
	<input type=text name='timezone' placeholder='Time Zone Set' class='' value='$timezone' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Type File</label>
	<div class='controls'>
	<input type=text name='file_allowed' placeholder='Type file yg diperbolehkan' class='' value='$file_allowed' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Maks Size File</label>
	<div class='controls'>
	<input type=text name='file_size' placeholder='Maksimal File Size Upload' value='$file_size' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Printer Default</label>
	<div class='controls'>
	<input type=text name='print_def' placeholder='Printer Yang akan digunakan sistem' value='$print_def' required>
	</div>
</div>
	<div class='form-actions'>
		<input class='btn btn-success btn-large' type=submit value='Simpan' name='SimpanSetting'>
	</div>
</fieldset>
</form>"; 
?>					
	</div>
</div>

</div>
<div class="span4">
	<div id="formToc" class="widget widget-table">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>SISTEM INFORMASI</h3>		    			
		</div>
		<div class="widget-content">
		<table class="table table-bordered table-striped">
			<tbody>
				<tr class="even gradeC">
					<td>Database</td>
					<td> <?php echo FDBName; ?></td>
				</tr>
				<tr class="even gradeC">
					<td>Host</td>
					<td> <?php echo FDBHost; ?></td>
				</tr>
				<tr class="even gradeC">
					<td>Username</td>
					<td> <?php echo FDBUser; ?></td>
				</tr>
				<tr class="even gradeC">
					<td>Versi</td>
					<td> 00.2.2013</td>
				</tr>
				<tr class="even gradeC">
					<td>Develpment</td>
					<td> www.achtanaputra.com</td>
				</tr>						
			</tbody>
		</table>		
		</div>
	</div>
</div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>