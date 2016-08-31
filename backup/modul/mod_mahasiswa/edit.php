<?php 
defined('_FINDEX_') or die('Access Denied');
if($edit){ 
global $TahunIni, $saiki;
$id = $_REQUEST['id'];
$r = GetFields('mahasiswa', 'MhswID', $id, '*');
$prodi = GetFields('jurusan', 'kode_jurusan', $r[kode_jurusan], '*');
?>
<div class="row">
			<div class="span8">
				<div class="widget widget-form">
				<div class="widget-header">
					<h3><i class="icon-pencil"></i>EDIT DATA MAHASISWA</h3>
					
					<div class="widget-actions">
						<div class="btn-group">
						<a class='btn btn-small btn-danger' href="go-mahasiswa.html"><i class="icon-undo"></i> Kembali</a>
				         
				        </div>					
					</div> 
				</div> 
					
					<div class="widget-tabs">
						<ul class="nav nav-tabs">
						  <li class="active">						  	
						    <a href="#Akademik">
						    	<i class="icon-sitemap"></i> 
						    	Akademik
					    	</a>
						  </li>
						  <li>
						  	<a href="#Pribadi">
						  		<i class="icon-user"></i>
						  		Data Pribadi			  		
					  		</a>					  		
				  		</li> <li>
						  	<a href="#Ortu">
						  		<i class="icon-cogs"></i>
						  		Orang Tua				  		
					  		</a>					  		
				  		</li><li>
						  	<a href="#sekolah">
						  		<i class="icon-eye-open"></i>
						  		Sekolah Asal					  		
					  		</a>					  		
				  		</li>
						</ul>
					</div> 
					
	<div class="widget-content">
<form class='form-horizontal' method='post'>
	<input type='hidden' name='id' value='<?php echo $r['MhswID']; ?>'>
	<div class="tab-content">
<div class="tab-pane active" id="Akademik">
<?php 
echo"<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>NIM</label>
		<div class='controls'>
			<input type=text name='NIM' class='span12' value='$r[NIM]' readonly>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Institusi *</label>
		<div class='controls'>
			<select name='institusi' class='span12'>
				<option value=''>- Pilih Institusi -</option>";
					$ins=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
					while($in=_fetch_array($ins)){
					$plh=($r[identitas_ID]==$in[Identitas_ID])? 'selected':'';
					echo "<option value='$in[Identitas_ID]' $plh> $in[Nama_Identitas]</option>";
					} 
				echo" </select>
		</div>
</div></div></div>

<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Program Studi *</label>
		<div class='controls'>
			<select name='prodi' class='span12'>
				<option value=''>- Pilih Prodi -</option>";
				$tampil=_query("SELECT * FROM jurusan ORDER BY jurusan_ID");
				while($w=_fetch_array($tampil)){
				$cek= ($r[kode_jurusan]==$w[kode_jurusan])? 'selected': '';
				echo "<option value=$w[kode_jurusan] $cek>  $w[nama_jurusan]</option>";
				}
			echo "</select>
		</div>
</div></div></div>

<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Kelas *</label>
		<div class='controls'>
			<select name='kelas' class='span12'>
				<option value=''>- Pilih Kelas -</option>";
				$tampil=_query("SELECT * FROM program ORDER BY ID");
				while($w=_fetch_array($tampil)){
				$cek= ($r[IDProg]==$w[ID])? 'selected': '';
				echo "<option value=$w[ID] $cek> $w[nama_program]</option>";
				}                                
			echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Konsentrasi *</label>
		<div class='controls'>
			<select name='kons' class='span12'>
			<option value=''>- Pilih Konsentrasi -</option>";
			$tampil=_query("SELECT * FROM kurikulum WHERE Kurikulum_ID NOT IN ('42') AND Jurusan_ID='$r[kode_jurusan]'");
			while($w=_fetch_array($tampil)){
			$cek= ($r[Kurikulum_ID]==$w[Kurikulum_ID])? 'selected': '';
			echo "<option value=$w[Kurikulum_ID] $cek> $w[Nama]</option>";
			}                                
			echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'>
	<div class='span6'>
			<label class='control-label'>Status Awal *</label>
			<div class='controls'>
				<select name='StatusAwal_ID' class='span12'>
				<option value=''>- Pilih Status Awal Mahasiswa -</option>";
				$tampil=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
				while($w=_fetch_array($tampil)){
				$cek= ($r[StatusAwal_ID]==$w[StatusAwal_ID])? 'selected': '';
				echo "<option value=$w[StatusAwal_ID] $cek> $w[Nama]</option>";
				}                                
				echo "</select>
			</div>
	</div>
	<div class='span6'>
			<label class='control-label'>Status Mahasiswa  *</label>
			<div class='controls'>
				<select name='StatusMhsw_ID' class='span12'>
				<option value=''>- Pilih Status Mahasiswa -</option>";
				$tampil=_query("SELECT * FROM statusmhsw ORDER BY StatusMhsw_ID");
				while($w=_fetch_array($tampil)){
				$dek=($r[StatusMhsw_ID]==$w[StatusMhsw_ID])? 'selected':'';
				echo "<option value='$w[StatusMhsw_ID]' $dek> $w[Nama]</option>";
				}                                
				echo "</select>
			</div>
	</div>
</div></div>
<div class='control-group'><div class='row-fluid'>
	<div class='span6'>
			<label class='control-label'>Status *</label>
			<div class='controls'>";
			if($r['aktif'] == 'Y'){
					echo"<input type=radio name=Aktif value='Y' checked>Y 
						<input type=radio name=Aktif value='N'>N ";
				}else{
					echo"<input type=radio name=Aktif value='Y'>Y 
						<input type=radio name=Aktif value='N' checked>N ";
				}
			echo"</div>
	</div>
	<div class='span6'>
			<label class='control-label'>Penasehat Akademik </label>
			<div class='controls'>
				<select name='pa' class='span12'>
				<option value=''>- Pilih Penasehat Akademik -</option>";
				$tampil=_query("SELECT * FROM dosen WHERE Identitas_ID='$r[identitas_ID]' AND jurusan_ID LIKE '%$r[kode_jurusan]%' ORDER BY dosen_ID");
				while($w=_fetch_array($tampil)){
				$dek=($r[PenasehatAkademik]==$w[dosen_ID])? 'selected':'';
				echo "<option value='$w[dosen_ID]' $dek>$w[nama_lengkap], $w[Gelar]</option>";
				}                                
				echo "</select>
			</div>
	</div>
</div></div>"; 
?>
</div> 
<div class="tab-pane" id="Pribadi">
<?php 
echo"<div class='control-group'><div class='row-fluid'>
<div class='span12'>
		<label class='control-label'>Nama </label>
		<div class='controls'>
			<input type=text name='Nama' class='span12' value='$r[Nama]' required>
		</div>
</div>
</div></div>

<div class='control-group'><div class='row-fluid'>
<div class='span6'>
		<label class='control-label'>Username *</label>
		<div class='controls'>
			<input type=text name='username' class='span12' value='$r[username]' readonly>
		</div>
</div>
<div class='span6'>
		<label class='control-label'>Password *</label>
		<div class='controls'>
			<input type=password name='password' class='span12' placeholder='Kosongkan Jika Tidak diubah...'>
		</div>
</div>
</div></div>

<div class='control-group'>
		<div class='row-fluid'>
				<div class='span12'>
					<label class='control-label'>TT Lahir *</label>
					<div class='controls'><input type=text name=TempatLahir class='input-medium' value='$r[TempatLahir]' placeholder='Tempat Lahir..'>  ";
					$get_tgl2=substr("$r[TanggalLahir]",8,2);
					combotgl(1,31,'tgltl',$get_tgl2);
					$get_bln2=substr("$r[TanggalLahir]",5,2);
					combobln(1,12,'blntl',$get_bln2);
					$get_thn2=substr("$r[TanggalLahir]",0,4);
					combothn($TahunIni-100,$TahunIni+2,'thntl',$get_thn2);
					echo "</div>
				</div>
				
		</div>
</div>

<div class='control-group'>
<div class='row-fluid'>
	<div class='span6'>
		<label class='control-label'>Jenis Kelamin</label>
			<div class='controls'>";
				if ($r[Kelamin]=='L'){
				echo "<input type=radio name='Kelamin' value='L' checked> Laki-laki  
					<input type=radio name='Kelamin' value='P'> Perempuan";
					}
					else{
				echo "<input type=radio name='Kelamin' value='L'> Laki-laki  
					<input type=radio name='Kelamin' value='P' checked> Perempuan";
					}
			echo"</div>
	</div>
	<div class='span3'>";
				if ($r['WargaNegara']=='WNA'){
					echo "<input type=radio name='WargaNegara' value='WNI'> WNI
						<input type=radio name='WargaNegara' value='WNA' checked> WNA ";
					} else {
				echo "<input type=radio name='WargaNegara' value='WNI' checked> WNI
					<input type=radio name='WargaNegara' value='WNA'> WNA ";
					}
			echo"
	</div>
	<div class='span3'>
		<input type='text' name='Kebangsaan' class='span12' value='$r[Kebangsaan]' placeholder='Jika WNA Sebutkan..'>	
	</div>
</div>
</div>

<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Agama</label>
			<div class='controls'>
				<select name='Agama' class='span12'>
					<option value=''>- Pilih Agama -</option>";
					$t=_query("SELECT * FROM agama ORDER BY agama_ID");
					while($w=_fetch_array($t)){
					$cek=($r[Agama]==$w[agama_ID])? "selected":"";
					echo "<option value=$w[agama_ID] $cek> $w[nama]</option>";
					}
				echo "</select>
			</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Status Sipil</label>
			<div class='controls'>
				<select name='StatusSipil' class='span12'>
				<option value=''>- Pilih Status Sipil -</option>";
						$t=_query("SELECT * FROM statussipil ORDER BY StatusSipil");
						while($w=_fetch_array($t)){
						$cek=($r[StatusSipil]==$w[StatusSipil])? "selected":"";
						echo "<option value=$w[StatusSipil] $cek> $w[Nama]</option>";
							  }
				echo "</select>
			</div>
		</div>
	</div>
</div>

<div class='control-group'><div class='row-fluid'>
<div class='span12'>
		<label class='control-label'>Alamat </label>
		<div class='controls'>
			<input type=text name='Alamat' class='span12' value='$r[Alamat]'>
		</div>
</div>
</div></div>

<div class='control-group'><div class='row-fluid'>
<div class='span6'>
		<label class='control-label'>RT </label>
		<div class='controls'>
			<input type=text name='RT' class='span12' value='$r[RT]'>
		</div>
</div>
<div class='span6'>
		<label class='control-label'>RW </label>
		<div class='controls'>
			<input type=text name='RW' class='span12' value='$r[RW]'>
		</div>
</div>
</div></div>

<div class='control-group'><div class='row-fluid'>
<div class='span6'>
		<label class='control-label'>Kota </label>
		<div class='controls'>
			<input type=text name='Kota' class='span12' value='$r[Kota]'>
		</div>
</div>
<div class='span6'>
		<label class='control-label'>KodePos </label>
		<div class='controls'>
			<input type=text name='KodePos' class='span12' value='$r[KodePos]'>
		</div>
</div>
</div></div>

<div class='control-group'><div class='row-fluid'>
<div class='span6'>
		<label class='control-label'>Propinsi </label>
		<div class='controls'>
			<input type=text name='Propinsi' class='span12' value='$r[Propinsi]'>
		</div>
</div>
<div class='span6'>
		<label class='control-label'>Negara </label>
		<div class='controls'>
			<input type=text name='Negara' class='span12' value='$r[Negara]'>
		</div>
</div>
</div></div>

<div class='control-group'><div class='row-fluid'>
<div class='span6'>
		<label class='control-label'>Telepon / Hp </label>
		<div class='controls'>
			<input type=text name='Telepon' class='span12' value='$r[Telepon]'>
		</div>
</div>
<div class='span6'>
		<label class='control-label'>E-Mail </label>
		<div class='controls'>
			<input type=text name='Email' class='span12' value='$r[Email]'>
		</div>
</div>
</div></div>";
?>
</div> 

<div class="tab-pane" id="Ortu">
<?php 
 echo"<div class='control-group'><h4>DATA AYAH</h4></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Nama *</label>
		<div class='controls'>
			<input type=text name='NamaAyah' class='span12' value='$r[NamaAyah]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Agama *</label>
		<div class='controls'>
			<select name='AgamaAyah' class='span12'>
			<option value=''>- Pilih Agama -</option>";
			$tampil=_query("SELECT * FROM agama ORDER BY agama_ID");
			while($w=_fetch_array($tampil)){
				$cek=($r[AgamaAyah]==$w[agama_ID])? "selected":"";
				echo "<option value='$w[agama_ID]' $cek> $w[nama]</option>";
			}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Pendidikan *</label>
		<div class='controls'>
			<select name='PendidikanAyah' class='span12'>
			<option value=''>- Pilih Pendidikan -</option>";
				$tampil=_query("SELECT * FROM pendidikanortu ORDER BY Pendidikan");
				while($w=_fetch_array($tampil)){
				$cek=($r[PendidikanAyah]==$w[Pendidikan])? "selected":"";
				 echo "<option value=$w[Pendidikan] $cek>$w[Pendidikan] - $w[Nama]</option>";
				}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Pekerjaan *</label>
		<div class='controls'>
			<select name='PekerjaanAyah' class='span12'>
			<option value=''>- Pilih Pekerjaan -</option>";
				$tampil=_query("SELECT * FROM pekerjaanortu ORDER BY Pekerjaan");
				while($w=_fetch_array($tampil)){
				$cek=($r[PekerjaanAyah]==$w[Pekerjaan])? "selected":"";
				 echo "<option value=$w[Pekerjaan] $cek>$w[Nama]</option>";
				}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><h4>DATA IBU</h4></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Nama *</label>
		<div class='controls'>
			<input type=text name='NamaIbu' class='span12' value='$r[NamaIbu]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Agama *</label>
		<div class='controls'>
			<select name='AgamaIbu' class='span12'>
			<option value=''>- Pilih Agama -</option>";
			$tampil=_query("SELECT * FROM agama ORDER BY agama_ID");
			while($w=_fetch_array($tampil)){
				$cek=($r[AgamaIbu]==$w[agama_ID])? "selected":"";
				echo "<option value='$w[agama_ID]' $cek> $w[nama]</option>";
			}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Pendidikan *</label>
		<div class='controls'>
			<select name='PendidikanIbu' class='span12'>
			<option value=''>- Pilih Pendidikan -</option>";
				$tampil=_query("SELECT * FROM pendidikanortu ORDER BY Pendidikan");
				while($w=_fetch_array($tampil)){
				$cek=($r[PendidikanIbu]==$w[Pendidikan])? "selected":"";
				 echo "<option value=$w[Pendidikan] $cek> $w[Nama]</option>";
				}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Pekerjaan *</label>
		<div class='controls'>
			<select name='PekerjaanIbu' class='span12'>
			<option value=''>- Pilih Pekerjaan -</option>";
				$tampil=_query("SELECT * FROM pekerjaanortu ORDER BY Pekerjaan");
				while($w=_fetch_array($tampil)){
				$cek=($r[PekerjaanIbu]==$w[Pekerjaan])? "selected":"";
				 echo "<option value=$w[Pekerjaan] $cek>$w[Nama]</option>";
				}                                
		echo "</select>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Alamat Orang Tua </label>
		<div class='controls'>
			<input type=text name='AlamatOrtu' class='span12' value='$r[AlamatOrtu]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'>
<div class='span3'>
	<input type=text name='KotaOrtu' class='span12' value='$r[KotaOrtu]' placeholder='Kota...' >
</div>
<div class='span3'>
<input type=text name='KodePosOrtu' class='span12' value='$r[KodePosOrtu]' placeholder='Kodepos...' >
</div>
<div class='span3'>
<input type=text name='PropinsiOrtu' class='span12' value='$r[PropinsiOrtu]' placeholder='Propinsi...' >
</div>
<div class='span3'>
<input type=text name='NegaraOrtu' class='span12' value='$r[NegaraOrtu]' placeholder='Negara...' >
</div>
</div></div>
<div class='control-group'><h4>KONTAK</h4></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Telepon </label>
		<div class='controls'>
			<input type=text name='TeleponOrtu' class='span12' value='$r[TeleponOrtu]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>HP </label>
		<div class='controls'>
			<input type=text name='HandphoneOrtu' class='span12' value='$r[HandphoneOrtu]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>E-Mail </label>
		<div class='controls'>
			<input type=text name='EmailOrtu' class='span12' value='$r[EmailOrtu]'>
		</div>
</div></div></div>";
?>
</div> 
<div class="tab-pane" id="sekolah">
<?php 
if($prodi[jenjang]=='S1'){
 echo"<div class='control-group'>
<h4>SEKOLAH ASAL</h4>
</div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Nama Sekolah *</label>
		<div class='controls'>
			<input type=text name='AsalSekolah' class='span12' value='$r[AsalSekolah]'>
		</div>
</div></div></div>

<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Jurusan *</label>
		<div class='controls'>
			<input type=text name='JurusanSekolah' class='span12' value='$r[JurusanSekolah]'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Tahun Lulus *</label>
		<div class='controls'>
			<input type=text name='TahunLulus' value='$r[TahunLulus]' class='span12'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>NOMOR STTB *</label>
		<div class='controls'>
			<input type=text name='NilaiSekolah' class='span12' value='$r[NilaiSekolah]'>
		</div>
</div></div></div>";	
}else{
 echo"<div class='control-group'>
<h4>ASAL PERGURUAN TINGGI</h4>
</div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Perguruan Tinggi *</label>
		<div class='controls'>
			<input type=text name='AsalSekolah' value='$r[AsalSekolah]' class='span12' placeholder='Masukkan Nama Perguruan Tinggi'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Jurusan*</label>
		<div class='controls'>
			<input type=text name='JurusanSekolah' value='$r[JurusanSekolah]' class='span12'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>Tahun Lulus*</label>
		<div class='controls'>
			<input type=text name='TahunLulus' value='$r[TahunLulus]' class='span12'>
		</div>
</div></div></div>
<div class='control-group'><div class='row-fluid'><div class='span12'>
		<label class='control-label'>NOMOR IJAZAH*</label>
		<div class='controls'>
			<input type=text name='NilaiSekolah' value='$r[NilaiSekolah]' class='span12'>
		</div>
</div></div></div>";
}	
?>
</div> 
							
</div> 
</div>
	<div class='widget-toolbar'>
		<center>
		<input class='btn btn-success btn-large' type='submit' name='UpdateMahasiswa' value='Update Data Mahasiswa'>
		</center>
	</div>
</form>

	</div> 
</div> 
			
			
<div class="span4">
	<div class="widget widget-table toolbar-bottom">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i><?php echo strtoupper($r['Nama']); ?></h3>		    			
		</div>
<form class='form-horizontal' method='post' enctype='multipart/form-data'> 
	<div class="widget-content">
<?php
	$MaxFileSize = siteConfig('file_size');
if($r['foto']!=''){
		if (file_exists('media/images/foto_mahasiswa/'.$r[foto])){
			$foto ="<img src='media/images/foto_mahasiswa/medium_$r[foto]' width='100%' alt='$r[Nama]'>";
		} elseif (file_exists('media/images/'.$r[foto])){
			$foto ="<img src='media/images/$r[foto]' width='100%' alt='$r[Nama]'>";
		}else{
			$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$r[Nama]' width='100%'>";
		}
}else{
	$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$r[Nama]' width='100%'>";
}

	echo"<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
		<input type=hidden name='Id' value='$r[MhswID]' />
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
?>		
</div><div class='widget-toolbar'>
		<input class='btn btn-success' type='submit' name='Upload' value='Upload Foto'>
</div></form></div></div> 	

		</div>  
<?php }else{ ErrorAkses(); } ?>