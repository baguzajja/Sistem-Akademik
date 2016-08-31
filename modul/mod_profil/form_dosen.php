<?php 
defined('_FINDEX_') or die('Access Denied');
if($edit){ 
global $TahunIni, $saiki;
$id = $_REQUEST['id'];
$r = GetFields('dosen', 'username', $_SESSION[yapane], '*');
$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan', $r[jurusan_ID]);
?>
<div class="row">
			<div class="span8">
				<div class="widget widget-form">
				<div class="widget-header">
					<h3><i class="icon-pencil"></i>PROFIL DOSEN</h3>
					
					<div class="widget-actions">
										
					</div> 
				</div> 
					
					<div class="widget-tabs">
						<ul class="nav nav-tabs">
						  <li class="active">						  	
						    <a href="#pribadi">
						    	<i class="icon-user"></i> 
						    	Data Pribadi
					    	</a>
						  </li>
						  <li>
						  	<a href="#akademik">
						  		<i class="icon-sitemap"></i>
						  		Akademik			  		
					  		</a>					  		
				  		</li> <li>
						  	<a href="#pendidikan">
						  		<i class="icon-book"></i>
						  		Pendidikan				  		
					  		</a>					  		
				  		</li><li>
						  	<a href="#pekerjaan">
						  		<i class="icon-cogs"></i>
						  		Pekerjaan				  		
					  		</a>					  		
				  		</li><li>
						  	<a href="#penelitian">
						  		<i class="icon-eye-open"></i>
						  		Penelitian					  		
					  		</a>					  		
				  		</li>
						</ul>
						
					</div> 
					
	<div class="widget-content">
<form class='form-horizontal' method='post'>
		<input type='hidden' name='id' value='<?php echo $r[dosen_ID]; ?>'>
		 <input type='hidden' name='username' value='<?php echo $r[username]; ?>'>
		<div class="tab-content">

<?php echo"<div class='tab-pane active' id='pribadi'>
<div class='control-group'>
	<label class='control-label'>Nama Lengkap</label>
	<div class='controls'>
		<input type='text' name='nama_lengkap' value='$r[nama_lengkap]' class='input-xlarge' required>
		<input type='text' name='Gelar' value='$r[Gelar]' class='input-medium' placeholder='Gelar ..' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Username</label>
	<div class='controls'>
		<input type=text value='$r[username]' disabled>
		<input type=password name='password' placeholder='Password Kosongkan jika tidak diubah'> 
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>NIDN</label>
	<div class='controls'>
		<input type='text' name='NIDN' value='$r[NIDN]' class='input-xlarge' readonly>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>NO KTP</label>
	<div class='controls'>
		<input type=text name='KTP' size=30 value='$r[KTP]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tempat / Tgl Lahir</label>
	<div class='controls'>
		<input type='text' name='TempatLahir' value='$r[TempatLahir]' placeholder='Masukkan Kota Kelahiran' class='input-medium'> &nbsp; &nbsp;";
		$get_tgl2=substr("$r[TanggalLahir]",8,2);
		combotgl(1,31,'tgllahir',$get_tgl2);
        $get_bln2=substr("$r[TanggalLahir]",5,2);
        combobln(1,12,'blnlahir',$get_bln2);
        $get_thn2=substr("$r[TanggalLahir]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thnlahir',$get_thn2); 
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Agama</label>
	<div class='controls'>
		<select name='Agama'>
			<option value=''>- Pilih Agama -</option>";
			$t=_query("SELECT * FROM agama ORDER BY agama_ID");
			while($a=_fetch_array($t)){
			$plh=($r[Agama]==$a[agama_ID])? 'selected':'';
			echo "<option value='$a[agama_ID]' $plh> $a[nama]</option>";
			}   
		echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Telepon</label>
	<div class='controls'>
		<input type='text' name='Telepon' value='$r[Telepon]' placeholder='Masukkan No Telp ...' class='input-medium'>&nbsp;
		<input type='text' name='Handphone' value='$r[Handphone]' placeholder='Masukkan No Hp ...' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Email</label>
	<div class='controls'>
		<input type='text' name='Email' value='$r[Email]' placeholder='Masukkan Alamat Email Valid' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Alamat</label>
	<div class='controls'> 
	<textarea name='Alamat' class='input-xxlarge'>$r[Alamat]</textarea>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'></label>
	<div class='controls'> 
	 <input type=text name='Kota' class='input-small' placeholder='Kota...' value='$r[Kota]'>
	<input type=text name='Propinsi' class='input-medium' placeholder='Provinsi...' value='$r[Propinsi]'>
<input type=text name='Negara' class='input-xlarge' placeholder='Negara...' value='$r[Negara]'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Program Studi</label>
	<div class='controls'>$d</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls'>";
	if($r['Aktif'] == 'Y'){
		echo"<input type=radio name=Aktif value='Y' checked readonly>Y 
			<input type=radio name=Aktif value='N' readonly>N ";
	}else{
		echo"<input type=radio name=Aktif value='Y' readonly>Y 
			<input type=radio name=Aktif value='N' checked readonly>N ";
	}
	echo"</div></div></div> ";
//Tab akademik
 echo"<div class='tab-pane' id='akademik'><div class='control-group'>
	<label class='control-label'>Institusi</label>
	<div class='controls'>
		<select name='identitas' class='input-xxlarge' readonly>
			<option value=''>- Pilih Institusi -</option>";
				$ins=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
				while($in=_fetch_array($ins)){
				$plh=($r[Identitas_ID]==$in[Identitas_ID])? 'selected':'';
				echo "<option value='$in[Identitas_ID]' $plh> $in[Nama_Identitas]</option>";
				} 
			echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Mulai Bekerja</label>
	<div class='controls'>"; 
		$get_tgl2=substr("$r[TglBekerja]",8,2);
		combotgl(1,31,'TglBekerja',$get_tgl2);
        $get_bln2=substr("$r[TglBekerja]",5,2);
        combobln(1,12,'BlnBekerja',$get_bln2);
        $get_thn2=substr("$r[TglBekerja]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'ThnBekerja',$get_thn2);                           
echo "</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jabatan Akademik</label>
	<div class='controls'>
		<select name='Jbtn' class='input-xxlarge' readonly>
			<option value=''>- Pilih Jabatan -</option>";
				$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Nama");
					while($j=_fetch_array($jbtn)){
					$cek=($j[Jabatan_ID]==$r[Jabatan_ID]) ? 'selected':'';
					echo "<option value='$j[Jabatan_ID]' $cek>$j[Nama]</option>";
				}
			echo" </select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jabatan Dikti</label>
	<div class='controls'>
		<select name='JabatanDikti_ID' readonly>
		<option value=''>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM jabatandikti ORDER BY JabatanDikti_ID");
	while($w=_fetch_array($tampil)){
	$cek=($r[JabatanDikti_ID]==$w[JabatanDikti_ID])? 'selected':'';
	echo "<option value=$w[JabatanDikti_ID] $cek>$w[JabatanDikti_ID] - $w[Nama]</option>"; 
	}
echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status Dosen</label>
	<div class='controls'>
		<select name='StatusDosen_ID' readonly>
	<option value=''>- Pilih Status Dosen -</option>";
	$tampil=_query("SELECT * FROM statusaktivitasdsn ORDER BY StatusAktivDsn_ID");
	while($w=_fetch_array($tampil)){
	$rb=($r[StatusDosen_ID]==$w[StatusAktivDsn_ID])? 'selected':'';
	echo "<option value='$w[StatusAktivDsn_ID]' $rb>$w[StatusAktivDsn_ID] - $w[Nama]</option>";
	}                                
echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status Kerja</label>
	<div class='controls'>
	<select name='StatusKerja_ID' readonly>
		<option value=''>- Pilih Status Kerja -</option>";
		$tampil=_query("SELECT * FROM statuskerja ORDER BY StatusKerja_ID");
		while($w=_fetch_array($tampil)){
		$hf=($r[StatusKerja_ID]==$w[StatusKerja_ID])? 'selected':'';
		echo "<option value='$w[StatusKerja_ID]' $hf>$w[StatusKerja_ID] - $w[Nama]</option>";
		}                                
echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Prodi Homebase</label>
	<div class='controls'>
		<input type='text' name='Homebase' value='$r[Homebase]' readonly>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>SK Pengangkatan</label>
	<div class='controls'>
		<input type='text' name='Skpengankatan' value='$r[Skpengankatan]' readonly>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Pendidikan Terakhir</label>
	<div class='controls'>
	<select name='Jenjang_ID' readonly>
		<option value=''>- Pilih Jenjang -</option>";
		$tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
		while($w=_fetch_array($tampil)){
		$fit=($r[Jenjang_ID]==$w[Jenjang_ID])? 'selected':'';
		echo "<option value='$w[Jenjang_ID]' $fit>$w[Nama]</option>";
		}                                
	echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Keilmuan</label>
	<div class='controls'>
	<input type='text' name='Keilmuan' value='$r[Keilmuan]' readonly>
	</div>
</div></div>"; 
echo"<div class='tab-pane' id='pendidikan'>
<table class='table table-striped'>
<thead>
	<tr>
	<th>No</th><th>Gelar</th><th>Jenjang</th><th>Tanggal Lulus</th><th>Perguruan Tinggi</th><th>Negara</th><th>Bidang Ilmu</th></tr>
</thead>
<tbody>";
	$tampil=_query("SELECT * FROM dosenpendidikan WHERE DosenID='$id' ORDER BY DosenPendidikanID");
	$no=1;
	if(_num_rows($tampil) > 0){
	while ($ra=_fetch_array($tampil)){
	$tgl=tgl_indo($ra[TanggalIjazah]);                        
	$jenjang=get_jenjang($ra[JenjangID]);                           
echo "<tr>
		<td>$no</td>
		<td>$ra[Gelar]</td>
		<td>$jenjang</td>
		<td>$tgl</td>
		<td>$ra[PerguruanTinggiID]</td>
		<td>$ra[NamaNegara]</td>
		<td>$ra[BidangIlmu]</td>
	</tr>";
	$no++;
}
}else{
	echo "<tr><td colspan='7'><center>Belum Ada Data ...!!</center></td></tr>";
}
echo"</tbody>
	</table>
</div>";
echo"<div class='tab-pane' id='pekerjaan'>
<table class='table table-striped'>
<thead>
	<tr><th>No</th><th>Jabatan</th><th>Institusi</th><th>Alamat</th><th>Telepon</th>
</tr>
</thead><tbody>";
	$tampil=_query("SELECT * FROM dosenpekerjaan WHERE DosenID='$id' ORDER BY DosenPekerjaanID");
	$no=1;
if(_num_rows($tampil) > 0){
	while ($ra=_fetch_array($tampil)){
	echo "<tr><td>$no</td>
			<td>$ra[Jabatan]</td>
			<td>$ra[Institusi]</td>
			<td>$ra[Alamat]</td>
			<td>$ra[Telepon]</td></tr>";
	$no++;
	} 
}else{
	echo "<tr><td colspan='5'><center>Belum Ada Data ...!!</center></td></tr>";
}
echo"		</tbody>
	</table>
</div> ";
/// Tab penelitian
echo"<div class='tab-pane' id='penelitian'>
	<table class='table table-striped'>
		<thead>
			<tr><th>No</th><th>Nama Penelitian</th><th>Tanggal</th><th></th></tr>
		</thead>
		<tbody>";
	$tampil=_query("SELECT * FROM dosenpenelitian WHERE DosenID='$_GET[id]' ORDER BY DosenPenelitianID");
	$no=1;
if(_num_rows($tampil) > 0){
	while ($pe=_fetch_array($tampil)){
	$tglBuat=tgl_indo($pe[TglBuat]);   
	echo "<tr>
			<td>$no</td>
			<td>$pe[NamaPenelitian]</td>
			<td>$tglBuat</td>
			<td>
			<center>
			<a class='btn btn-mini btn-primary' href='actions-dosen-penelitian-0-$pe[DosenPenelitianID].html'><i class='icon-pencil'></i> Edit</a>
			<a class='btn btn-mini btn-danger' href='actions-dosen-delpenelitian-$id-$pe[DosenPenelitianID].html' onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Data Penelitian $pe[NamaPenelitian] ?')\"><i class='icon-trash'></i> Hapus</a>
			</center>
			</td></tr>";
	$no++;
	}
}else{
	echo "<tr><td colspan='4'><center>Belum Ada Data ...!!</center></td></tr>";
}
echo"</tbody>
	</table>
</div>";
echo"</div> 
</div>
	<div class='widget-toolbar'>
		<center>
		<input class='btn btn-success btn-large' type='submit' name='UpdateDsn' value='Update'>
		</center>
	</div>
</form>

	</div> 
</div>";
$juduuu=strtoupper($r['nama_lengkap']);

echo"<div class='span4'>
	<div class='widget widget-table toolbar-bottom'>
		<div class='widget-header'>
			<h3><i class='icon-info-sign'></i> $juduuu </h3>		    			
		</div>
<form class='form-horizontal' method='post' enctype='multipart/form-data'> 
	<div class='widget-content'>";
	$MaxFileSize = siteConfig('file_size');
if($r['foto']!=''){
		if (file_exists('media/images/foto_dosen/'.$r[foto])){
			$foto ="<img src='media/images/foto_dosen/medium_$r[foto]' width='100%' alt='$r[nama_lengkap]'>";
		} elseif (file_exists('media/images/'.$r[foto])){
			$foto ="<img src='media/images/$r[foto]' width='100%' alt='$r[nama_lengkap]'>";
		}else{
			$foto ="<img src='themes/img/avatar.jpg' alt='$r[nama_lengkap]' width='100%'>";
		}
}else{
	$foto ="<img src='themes/img/avatar.jpg' alt='$r[nama_lengkap]' width='100%'>";
}
	echo"<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
		<input type=hidden name='Id' value='$r[dosen_ID]' />
		<table class='table table-bordered table-striped'>
			<tbody>
				<tr class='even gradeC'>
					<td colspan=2 width='70%'>$foto</td>
				</tr>
				<tr class='odd gradeA'>
					<td>Ganti Photo</td>
					<td><input type='file' name='foto'/></td>
				</tr>							
			</tbody>
		</table>";
echo"</div><div class='widget-toolbar'>
		<input class='btn btn-success' type='submit' name='UploadDsn' value='Upload Foto'>
</div></form></div></div> 	

		</div> ";
}else{ ErrorAkses(); } ?>