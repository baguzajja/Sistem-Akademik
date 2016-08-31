<?php
defined('_FINDEX_') or die('Access Denied');
$id = $_REQUEST['id'];
$w = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
?>
<div class="widget highlight">
	<div class="widget-header">	
		<h3>SATUAN ACARA PERKULIAHAN</h3>			
	</div> 
					
	<div class="widget-content">
		<?php echo "$w[sap]"; ?>
	</div> 
</div>