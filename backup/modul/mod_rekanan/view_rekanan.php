<?php defined('_FINDEX_') or die('Access Denied'); ?>
<?php if($baca){ 
$pilihAll=($hapus)? "<input type='checkbox' id='checkall'>":"No";
$AksiEdit=($edit)? "<th></th>":"";
?>
<div class="row">
<div class="span12">
<form method="post" id="form">
	   <div class="widget widget-table">
					<div class="widget-header">						
						<h3>
							<i class="icon-group"></i>
							MANAGEMEN REKANAN						
						</h3>
					<div class="widget-actions">
						<div class="btn-group">
						<?php if($buat){ ?>
				          <a href="action-rekanan-edit-1.html" class="btn btn-small btn-primary"><i class="icon-plus"></i> Tambah Rekanan</a>
						<?php } ?>
						<?php if($hapus){ ?>
				          <button type="submit" name="delete" class="btn btn-small btn-danger"><i class="icon-trash"></i> Hapus</button>	
						<?php } ?>	
				        </div>
			
					</div> <!-- /.widget-actions -->
					</div> <!-- /widget-header -->
<div class="widget-content">
<table class="table table-striped table-bordered table-highlight" id="tablef">
	<thead>
		<tr>
			<th><center><?php echo $pilihAll; ?></center></th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Phone</th>
			<?php echo $AksiEdit; ?>
		</tr>
	</thead>
	<tbody>
<?php
	$db = new FQuery();  
	$db->connect(); 				
	$no=1;				
	$tampil = $db->select("rekanan","*","","NamaRekanan ASC");
	while ($r=_fetch_array($tampil)){ 
	$check ="<input type='checkbox' name='check[]' value='$r[RekananID]' rel='ck'>";
	$pilih=($hapus)? $check:$no;
	$BtnEdit=($edit)? "<td>
					<center>
						<a class='btn btn-mini btn-primary' href='actions-rekanan-edit-0-$r[RekananID].html'><i class='icon-pencil'></i> Edit</a>
					</center>
					</td>":"";
	echo "<tr>              
			<td><center>$pilih</center></td>   
			<td>$r[NamaRekanan]</td>
			<td>$r[Alamat]</td>
			<td>$r[Telepon]</td>
			$BtnEdit
		</tr>";
$no++; 
	}  
?>
	</tbody>
</table>
</div></div></form></div></div>
<?php }else{
ErrorAkses();
} ?>