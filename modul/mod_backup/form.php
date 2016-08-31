<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
$namaSistem=siteConfig('site_name'); 
$site_url=siteConfig('site_url');
$site_mail=siteConfig('site_mail');
$timezone=siteConfig('timezone');
$file_allowed=siteConfig('file_allowed');
$file_size=siteConfig('file_size');
?>
<div class="row">
<div class="span8">
<div id="validation" class="widget highlight widget-form">
	<div class="widget-header">	      				
		<h3>
			<i class="icon-save"></i>
	      	TOOLS BACKUP DATABASE					
		</h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post' enctype='multipart/form-data'>
<fieldset>
<div class='control-group'>
	<label class='control-label'>RESTORE DATABASE</label>
	<div class='controls'>
		<input type='file' name='backup_file'/>
	</div>
</div>
	<div class='form-actions'>
		<input class='btn btn-success btn-large ui-tooltip' data-placement='top' title='Klik Untuk Merestore Database' type='submit' value='RESTORE' name='Restore'>
		<input class='btn btn-primary btn-large ui-tooltip' data-placement='right' title='Klik Untuk Mem- BackUp  Database' type='submit' value='BACKUP' name='Backup'>
	</div>
</fieldset>
</form>"; 
?>					
	</div>
</div>

</div>
<div class="span4">
<form method='post' id="formD">
	<div id="formToc" class="widget widget-table">
		<div class="widget-header">
			<h3><i class="icon-hand-right"></i>DATABASE BACKUP</h3>		
			<div class="widget-actions">
				<div class="btn-group">
					<button type="submit" name="delete" class="btn btn-mini btn-danger"><i class="icon-trash"></i>Hapus</button>
				</div>				
			</div>
		</div>
		<div class="widget-content">

		<table class="table table-bordered table-striped">
			<tbody>
				<?php
				$folder = 'media/files/backups';
				if ($folder = opendir($folder)) {
					$i = 1;
					while (($f = readdir($folder)) !== false) {
						$i++;
						if ($f != '.' && $f != '..' && $f != 'index.php') {
						$check ="<input type='checkbox' name='check[]' value='$f'>";
						echo"<tr class='even gradeC'>
								<td><center>$check</center></td>
								<td>". $f ."</td>
								<td><a class='btn btn-mini pull-right' href='action-download-Database-$f.html'><i class='icon-download-alt'></i>Download</a></td>
							</tr>";
							}
					}
				}
				?>						
			</tbody>
		</table>
		</div>

	</div>
</form>
</div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>