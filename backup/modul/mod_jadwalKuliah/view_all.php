<?php defined('_FINDEX_') or die('Access Denied'); ?><?php if($baca){ $institusi	=$_SESSION['Identitas'];$Wherejurusan	=($_SESSION['Jabatan']==18)? "AND Kode_Jurusan='$_SESSION[prodi]'" : '';$pilihAll	=($hapus)? "<input type='checkbox' id='checkall'>":"No";$AksiEdit	=($edit)? "<th></th>":"";?><div class="row"><div class="span12"><form method="post" id="form">	   <div class="widget widget-table">			<div class="widget-header">										<h3><i class="icon-calendar"></i>DAFTAR SEMUA JADWAL KULIAH</h3>											<div class="widget-actions">						<div class="btn-group">						<a class='btn btn-small' href="go-jadwalKuliah.html"><i class="icon-undo"></i> Kembali</a>						<?php if($buat){ ?>				          <a href="action-jadwalKuliah-EditJadwal-1.html" class="btn btn-small btn-success"><i class="icon-plus"></i> Tambah</a>						<?php } ?>						<?php if($hapus){ ?>				          <button type="submit" name="delete" class="btn btn-small btn-danger"><i class="icon-trash"></i> Hapus</button>							<?php } ?>				        </div>					</div>			</div> <div class="widget-content"><table class="table table-striped table-bordered table-highlight" id="tablef">	<thead>		<tr>			<th><center><?php echo $pilihAll; ?></center></th>			<th>TA</th>			<th>Prodi</th>			<th><center>Semester</center></th>			<th>Hari</th>			<th>Kode</th>			<th>Matakuliah</th>			<th>SKS</th>			<th>Waktu</th>			<th>Ruang</th>						<?php echo $AksiEdit; ?>		</tr>	</thead>	<tbody><?php	$sql="SELECT * FROM jadwal WHERE Identitas_ID='$institusi' $Wherejurusan ORDER BY Kode_Jurusan, Hari, Tahun_ID, semester";		$qry= _query($sql)or die ();		while ($r=_fetch_array($qry)){  		$no++;		$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';		$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");		$mtk = GetFields('matakuliah', 'Matakuliah_ID', $r[Kode_Mtk], '*');		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama");		$prodi=NamaProdi($r[Kode_Jurusan]);		$dosen1=NamaDosen($r[Dosen_ID]);		$dosen2=NamaDosen($r[Dosen_ID2]);		$dosens=($r[Kode_Jurusan]=='61101')? $dosen1: "1-". $dosen1." <br>2-". $dosen2;		$check ="<input type='checkbox' name='check[]' value='$r[Jadwal_ID]' rel='ck'>";		$pilih=($hapus)? $check:$no;		$BtnEdit=($edit)? "<td>			<div class='btn-group pull-right'>				<button class='btn dropdown-toggle btn-mini' data-toggle='dropdown'>				Aksi <span class='caret'></span>				</button>				<ul class='dropdown-menu'>					<li><a href='actions-jadwalKuliah-EditJadwal-0-$r[Jadwal_ID].html'>Edit Jadwal</a></li>					<li><a href='actions-jadwalKuliah-EditUjian-0-$r[Jadwal_ID].html'>Edit Ujian</a></li>				</ul>			</div></td>":"";		echo "<tr>                            				<td><center>$pilih</center></td>				<td>$r[Tahun_ID]</td>				<td>$prodi</td>				<td><center>$r[semester]</center></td>				<td><center>$r[Hari]</center></td>				<td>$kelompok - $mtk[Kode_mtk]</td>				<td>$mtk[Nama_matakuliah]</td>				<td>$mtk[SKS]</td>				<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>				<td>$ruang</td>								$BtnEdit			</tr>";        $no++; }?>	</tbody></table></div></div></form></div></div><?php }else{ErrorAkses();} ?>