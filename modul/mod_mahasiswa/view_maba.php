<?php defined('_FINDEX_') or die('Access Denied'); ?><?php if($baca){ $pilihAll=($hapus)? "<input type='checkbox' id='checkall'>":"No";$AksiEdit=($edit)? "<th></th>":"";?><div class="row"><div class="span12"><form method="post" id="form">	<div class="widget widget-table">		<div class="widget-header">									<h3><i class="icon-group"></i>DATA CALON MAHASISWA</h3>			<div class="widget-actions">				<div class="btn-group">					<a class='btn btn-small' href="go-mahasiswa.html"><i class="icon-undo"></i> Kembali</a>					<?php if($hapus){ ?>						<button type="submit" name="delete" class="btn btn-small btn-danger" onClick="return confirm('Anda yakin akan menghapus item terpilih ? DATA YANG TERHAPUS TIDAK DAPAT DIKEMBALIKAN.')"><i class="icon-trash"></i> Hapus</button>						<?php } ?>					</div>			</div>		</div> <div class="widget-content"><table class="table table-striped table-bordered table-highlight" id="maba">	<thead>		<tr>			<th><center><?php echo $pilihAll; ?></center></th>			<th>NO REGISTER</th>			<th>NAMA</th>			<th>PRODI</th>			<th>KELAS</th>			<th>ANGKTAN</th>			<?php echo $AksiEdit; ?>		</tr>	</thead>	<tbody><?php	$qry= _query("SELECT * FROM mahasiswa WHERE NIM='' ORDER BY NoReg")or die ();	while ($r=_fetch_array($qry)){  	$jurusan=GetName("jurusan","kode_jurusan",$r['kode_jurusan'],"nama_jurusan");	$kelas=GetName("program","ID",$r['IDProg'],"nama_program");	$angkatan=GetName("tahun","Tahun_ID",$r['Angkatan'],"Nama");	$AngkatThn = substr($angkatan, 15, 9); 	$no++;	$check ="<input type='checkbox' name='check[]' value='$r[MhswID]' rel='ck'>";	$pilih=($hapus)? $check:$no;	$BtnEdit=($edit)? "<td>						<center>							<a class='btn btn-mini btn-primary' href='actions-mahasiswa-edit-0-$r[MhswID].html'><i class='icon-pencil'></i> Edit</a>						</center>					</td>":"";	echo "<tr>              			<td><center>$pilih</center></td>            			<td>$r[NoReg]</td>			<td>$r[Nama]</td>			<td>$jurusan</td>			<td>$kelas</td>			<td>$AngkatThn</td>			$BtnEdit		</tr>";$no++; 	}  ?>	</tbody></table></div></div></form></div></div><?php }else{ErrorAkses();} ?>