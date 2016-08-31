<?php 
defined('_FINDEX_') or die('Access Denied');
if($baca){
	$txt_file    = file_get_contents('media/files/log.txt');
	$rows        = explode("\n", $txt_file);
?>
<div class="row">
<div class="span12">
	<div id="formToc" class="widget widget-table">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>DATA LOG</h3>	
				<div class="widget-actions">
						<div class="btn-group">
						<?php if($buat AND $edit AND $hapus){?>
				          <a href="aksi-download-log.html" class="btn btn-small btn-primary"><i class='icon-download-alt'></i>Download</a>
						<?php } ?>
				        </div>					
				</div>	
		</div>
		<div class="widget-content">
		<table class="table table-striped table-bordered table-highlight" id="tablef">
		<thead>
			<tr>
				<th>No</th>
				<th>User</th>
				<th>Waktu</th>
				<th>IP</th>
				<th>Browser</th>
				<th>URL</th>
				<th>Referrer</th>
				<th>Proxy</th>
				<th>Koneksi</th>
				<th>Aksi</th>
				<th>Pesan</th>
			</tr>
		</thead>
			<tbody>
			<?php 
				array_shift($rows);
				$i=1;
				if(!empty($rows)){
					foreach($rows as $row => $data)
					{
					$row_data = explode('|', $data);
					 echo"<tr class='even gradeC'>
							<td>". $i++ . "</td>
							<td>". $row_data[0] . "</td>
							<td>". $row_data[1] . "</td>
							<td>". $row_data[2] . "</td>
							<td>". $row_data[3] . "</td>
							<td>". $row_data[4] . "</td>
							<td>". $row_data[5] . "</td>
							<td>". $row_data[6] . "</td>
							<td>". $row_data[7] . "</td>
							<td>". $row_data[8] . "</td>
							<td>". $row_data[9] . "</td>
						</tr>";
					}
				}
			?>		
			</tbody>
		</table>		
		</div>
	</div>
</div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>