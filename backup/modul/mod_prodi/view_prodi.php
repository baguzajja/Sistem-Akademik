<?php defined('_FINDEX_') or die('Access Denied'); ?><?php if($baca){ $pilihAll=($hapus)? "<input type='checkbox' id='checkall'>":"No";$AksiEdit=($edit)? "<th></th>":"";?><div class="row">	<div class="span12"><form method="post" id="form">	   <div class="widget widget-table">					<div class="widget-header">												<h3>							<i class="icon-sitemap"></i>							MASTER PROGRAM STUDI												</h3>					<div class="widget-actions">						<div class="btn-group">						<?php if($buat){ ?>				          <a href="action-prodi-edit-1.html" class="btn btn-small btn-primary"><i class="icon-plus"></i> Tambah Prodi</a>						<?php } ?>						<?php if($hapus){ ?>				          <button type="submit" name="delete" class="btn btn-small btn-danger"><i class="icon-trash"></i> Hapus</button>							<?php } ?>					        </div>								</div> <!-- /.widget-actions -->					</div> <!-- /widget-header --><div class="widget-content"><table class="table table-striped table-bordered table-highlight" id="tablef">	<thead>		<tr>			<th><center><?php echo $pilihAll; ?></center></th>			<th>Institusi</th>			<th>Kode Prodi</th>			<th>Program Studi</th>			<th>Jenjang</th>			<th>Status</th>			<?php echo $AksiEdit; ?>		</tr>	</thead>	<tbody><?php	$sql="SELECT t1.*,t2.Nama_Identitas AS NI FROM jurusan t1,identitas t2 WHERE t1.Identitas_ID=t2.Identitas_ID ORDER BY t1.jurusan_ID";	$qry= _query($sql) or die ();	while ($data=_fetch_array($qry)){ 	$sttus = ($data['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';	$check ="<input type='checkbox' name='check[]' value='$data[jurusan_ID]'>";	$pilih=($hapus)? $check:$no;	$BtnEdit=($edit)? "<td>						<center>							<a class='btn btn-mini btn-primary' href='actions-prodi-edit-0-$data[jurusan_ID].html'><i class='icon-pencil'></i> Edit</a>						</center>						</td>":"";	echo "<tr>                    			<td><center>$pilih</center></td> 			<td>$data[NI]</td>			<td>$data[kode_jurusan]</td>			<td>$data[nama_jurusan]</td>			<td>$data[jenjang]</td>			<td><center>$sttus</center></td>			$BtnEdit		</tr>"; $no++; 	}  ?>	</tbody></table></div></div></form></div></div><?php }else{ErrorAkses();} ?>