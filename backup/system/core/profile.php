<?php
function ProfileKaryawan(){
    $edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
    $data=_fetch_array($edit);
	$identitas=NamaIdentitas($data[Identitas_ID]);
	$Dept=NamaDepatmen($data[Bagian]);
	$Jabatn=JabatanStaff($data[Jabatan]);
	$jabatan=NamaJabatan($data[Jabatan]);
	$MaxFileSize = 500000;
	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
	echo"<form method=post enctype='multipart/form-data' action='aksi-profile-aplodFotoUserkarywan.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=3> INFORMASI USER</th></tr>                               
		<tr><td>Username</td><td><strong> $data[username]</strong></td>
		<td rowspan=3><img alt='$data[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $data[nama_lengkap]</strong></td></tr>
		<tr><td>Jabatan </td><td><strong> $Dept - $jabatan</strong></td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='Id' value='$data[id]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-profile.html'><i class='icon-undo'></i> Kembali</a> 
			</div></td>
		<td>	
		<div class='fileupload fileupload-new pull-right' data-provides='fileupload'>
			<div class='input-append'>
				<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='foto'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
				<input class='btn btn-success' type=submit name='Upload' value='Upload Foto'>
			</div>
		</div>
		</td></tr>
	</thead></table></form>";

echo"<form method=POST action='aksi-profile-UpdateKaryawan.html'>
	<input type=hidden name=id value='$data[id]'>
	<input type=hidden name=bagian value='$data[Bagian]'>
	<input type=hidden name=jabatan size=30  value='$data[Jabatan]'>
	<input type=hidden name=identitas value='$data[Identitas_ID]'>
	<input type=hidden name=username  value='$data[username]'>
	<table class='table table-bordered table-striped'><thead>   
	<tr><td class=cc>ID</td>           <td><input type=text name=id disabled=disable size=2 value='$data[id]'></td></tr>
	<tr><td class=cc>Username</td>
	<td><input type=text  value='$data[username]' disabled></td></tr>
	<tr><td class=cc>Password</td>
	<td><input type=password name=password placeholder='Biarkan kosong jika tidak diubah' ></td></tr>
	<tr><td class=cc>Departemen</td>
	<td><input type=text name=bagian value='$Dept' disabled></td></tr>
	<tr><td class=cc>Jabatan</td>
	<td>$Jabatn</td></tr>
	<tr><td class=cc>Nama Lengkap</td>
	<td><input type=text name=nama_lengkap size=30  value='$data[nama_lengkap]'></td></tr>
	<tr><td class=cc>Institusi</td>
	<td>$identitas</td></tr>";
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan', $data[kode_jurusan]);   
    echo "<tr><td class=cc>Program Studi</td>  <td>$d</td></tr> 
          <tr><td class=cc>Email</td>        <td><input type=text name=email size=30  value='$data[email]'></td></tr>
          <tr><td class=cc>Telepon</td>      <td><input type=text name=telepon size=30  value='$data[telepon]'></td></tr>";
          if ($data[aktif]=='Y'){
              echo "<tr><td class=cc>Aktif ?</td>    <td><input type=radio name=aktif value=Y checked>Y
                                                                              <input type=radio name=aktif value=N>N</td></tr>";
          }
          else{
              echo "<tr><td class=cc>Aktif ?</td>    <td><input type=radio name=aktif value=Y>Y
                                                                              <input type=radio name=aktif value=N checked>N</td></tr>";
          }
	echo"<tr><td colspan=2>
		<center>
			<input class='btn btn-success' type=submit value=Update>
			<a class='btn btn-mini btn-danger' href='go-dasboard.html'>Kembali</a>
		</center>	  
		</td></tr>
	</thead></table></form>";
}
function ProfileAdmin(){
    $edit=_query("SELECT * FROM admin WHERE username='$_SESSION[yapane]'");
    $data=_fetch_array($edit);
	$MaxFileSize = 500000;
	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
	$jabatan=NamaJabatan($data[Jabatan]);
	echo"<form method=post enctype='multipart/form-data' action='aksi-profile-aplodFotoUserAdmin.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=3> INFORMASI USER</th></tr>                               
		<tr><td>Username  </td><td><strong> $data[username]</strong></td>
		<td rowspan=3><img alt='$data[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $data[nama_lengkap]</strong></td></tr>
		<tr><td>Jabatan </td><td><strong>$jabatan</strong></td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='Id' value='$data[id]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-AdminUser.html'><i class='icon-undo'></i> Kembali</a> 
			</div></td>
		<td>	
		<div class='fileupload fileupload-new pull-right' data-provides='fileupload'>
			<div class='input-append'>
				<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='foto'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
				<input class='btn btn-success' type=submit name='Upload' value='Upload Foto'>
			</div>
		</div>
		</td></tr>
		</thead></table></form>
<form method=POST action=aksi-profile-UpdateUser.html>
	<input type=hidden name=id value='$data[id]'>
	<input type=hidden name=username value='$data[username]'>
	<table class='table table-bordered table-striped'><thead>      
	<tr><td>Username</td>     <td><input type=text name=username  value='$data[username]' disabled></td></tr>
	<tr><td>Password</td>     <td><input placeholder='Biarkan kosong jika tidak diubah' type=password name=password size=20'></td></tr>
	<tr><td>Nama Lengkap</td> <td><input type=text name=nama_lengkap size=30  value='$data[nama_lengkap]'></td></tr>
	<tr><td>Email</td>        <td><input type=text name=email size=30  value='$data[email]'></td></tr>
	<tr><td>Telepon</td>      <td><input type=text name=telepon size=30  value='$data[telepon]'></td></tr>";
		if ($data[aktif]=='Y'){
	echo "<tr><td>Aktif ?</td><td><input type=radio name=aktif value=Y checked>Y
			<input type=radio name=aktif value=N>N</td></tr>";
		}else{
	echo "<tr><td>Aktif ?</td>    <td><input type=radio name=aktif value=Y>Y
			<input type=radio name=aktif value=N checked>N</td></tr>";
		}
	echo"</form>
	<tr><td colspan=2>
	<center>
			<input class='btn btn-success' type=submit value=Update>
			<a class='btn btn-mini btn-danger' href='go-AdminUser.html'>Kembali</a>
		
	</center>
	</td></tr>
	</thead></table>";
}
function ProfileMahasiswa(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
	$e=_query("SELECT * FROM mahasiswa WHERE NIM='$_SESSION[yapane]' AND kode_jurusan='$_SESSION[prodi]'");
	$r=_fetch_array($e); 
	$MaxFileSize = 500000;
	if (empty($r['Foto'])){
	$foto = "file/no-foto.jpg";
	}else{
	$foto = "$r[Foto]";
	}
	$kelas=NamaKelasa($r[IDProg]);
	$NamaProdi=NamaProdi($r[kode_jurusan]);
	echo"<form method=post enctype='multipart/form-data' action='aksi-profile-uplodFotoMahasiswa.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=2>INFORMASI MAHASISWA </th></tr>                               
		<tr><td>NIM</td><td><strong> $r[NIM]</strong></td>
		<td rowspan=5><img alt='$r[nama_lengkap]' src='$foto' width='200px' class='gambar pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $r[Nama]</strong></td></tr>
		<tr><td>Kelas</td><td>$kelas</td></tr>
		<tr><td>Program Studi</td><td>$r[kode_jurusan] - $NamaProdi</td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='NIM' value='$r[NIM]' />
			<input type=hidden name='prodi' value='$r[kode_jurusan]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-dasboard.html'><i class='icon-undo'></i> Kembali</a> 
			</div></td>
		<td>	
		<div class='fileupload fileupload-new pull-right' data-provides='fileupload'>
			<div class='input-append'>
				<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='foto'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
				<input class='btn btn-success' type=submit name='Upload' value='Upload Foto'>
			</div>
		</div>
		</td></tr>
<script type='text/javascript'>
$(function (){
    // file input
    $('input[id=the_file]').change(function() {
        $('#choose_file').val($(this).val());
    });
});
</script>
		</thead></table></form>
		
		<ul class='nav nav-tabs'>
			<li class='active'><a href='#Akademik' data-toggle='tab'>Akademik</a></li>
			<li><a href='#Pribadi' data-toggle='tab'>Data Pribadi</a></li>
			<li><a href='#Alamat' data-toggle='tab'>Alamat</a></li>
			<li><a href='#Ortu' data-toggle='tab'>Orang Tua</a></li>
			<li><a href='#sekolah' data-toggle='tab'>Sekolah Asal</a></li>
		</ul>";	
echo"<form method=post action='aksi-profile-updmhsw.html' enctype='multipart/form-data'> 
	<div class='tab-content'>
	<div class='tab-pane active' id='Akademik'>";
echo"<table class='table table-striped'><thead>
	<tr><td>Institusi *</td>    <td class=cb>
	<input type=hidden name='cmi' value='$r[identitas_ID]' />
	
	<select name='cmi' id=cmi1 disabled>
	<option value=0 selected>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY ID");
	while($w=_fetch_array($t)){
	if ($r[identitas_ID]==$w[Identitas_ID]){
	echo "<option value=$w[Identitas_ID] selected> $w[Nama_Identitas]</option>";
	} else{            
	echo "<option value=$w[Identitas_ID]>$w[Nama_Identitas]</option>";
	}
	}
	echo "</select></td></tr>
	<tr><td>Program Studi *</td>    <td class=cb>
	<input type=hidden name='cmbj' value='$r[kode_jurusan]' />
	<select name='cmbj' id=cmbj1 disabled>
	<option value=0 selected>- Pilih Prodi -</option>";
	$tampil=_query("SELECT * FROM jurusan WHERE Identitas_ID='$r[identitas_ID]' ORDER BY jurusan_ID");
	while($w=_fetch_array($tampil)){
	if ($r[kode_jurusan]==$w[kode_jurusan]){
	echo "<option value=$w[kode_jurusan] selected>  $w[nama_jurusan]</option>";
	} else{            
	echo "<option value=$w[kode_jurusan]>  $w[nama_jurusan]</option>";
	}}
	echo "</select></td></tr>
	<tr><td>Kelas *</td>    <td class=cb>
	<input type=hidden name='cmbp' value='$r[IDProg]' />
	<select name='cmbp' id=cmbp disabled>
	<option value=0 selected>- Pilih Kelas -</option>";
	$tampil=_query("SELECT * FROM program WHERE Identitas_ID='$r[identitas_ID]' ORDER BY Identitas_ID");
	while($w=_fetch_array($tampil)){
	if ($r[IDProg]==$w[ID]){
	echo "<option value=$w[ID] selected> $w[nama_program]</option>";
	}
	else{
	echo "<option value=$w[ID]> $w[nama_program]</option>";
	}
	}                                
	echo "</select></td></tr>
	<tr><td>Status Awal *</td>    <td class=cb>
	<input type=hidden name='StatusAwal_ID' value='$r[StatusAwal_ID]' />
	<select name='StatusAwal_ID' disabled>
	<option value=0 selected>- Pilih Status Awal Mahasiswa -</option>";
	$tampil=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
	while($w=_fetch_array($tampil)){
	if ($r[StatusAwal_ID]==$w[StatusAwal_ID]){
	echo "<option value=$w[StatusAwal_ID] selected> $w[Nama]</option>";
	}
	else{
	echo "<option value=$w[StatusAwal_ID]>  $w[Nama]</option>";
	}
	}                                
	echo "</select></td></tr>
	<tr><td>Status Mahasiswa *</td>
	<input type=hidden name='StatusMhsw_ID' value='$r[StatusMhsw_ID]' />
	<td class=cb><select name='StatusMhsw_ID' disabled>
	<option value=0 selected>- Pilih Status Mahasiswa -</option>";
	$tampil=_query("SELECT * FROM statusmhsw ORDER BY StatusMhsw_ID");
	while($w=_fetch_array($tampil)){
	if ($r[StatusMhsw_ID]==$w[StatusMhsw_ID]){
	echo "<option value=$w[StatusMhsw_ID] selected> $w[Nama]</option>";
	}
	else{
	echo "<option value=$w[StatusMhsw_ID]> $w[Nama]</option>";
	}
	}                                
	echo "</select></td></tr>
	<tr><td>Penasehat Akademik *</td>
	<td class=cb><select name='pa'>
	<option value=0 selected>- Pilih Penasehat Akademik -</option>";
	$tampil=_query("SELECT * FROM dosen WHERE Identitas_ID='$r[identitas_ID]' AND jurusan_ID LIKE '%$r[kode_jurusan]%' ORDER BY dosen_ID");
	while($w=_fetch_array($tampil)){
	if ($r[pa]==$w[NIDN]){
	echo "<option value=$w[NIDN] selected>$w[nama_lengkap], $w[Gelar]</option>";
	}
	else{
	echo "<option value=$w[NIDN]>$w[nama_lengkap], $w[Gelar]</option>";
	}
	}                                
	echo "</select></td></tr>
	</thead></table>";   
echo"</div>";
echo"<div class='tab-pane' id='Pribadi'>
	<table class='table table-striped'><thead>
	<input type=hidden name=NIDN value='$r[NIDN]'>
	<tr><td colspan=2><strong>Alamat Menetap Bagi Mahasiswa Luar Daerah</strong></td></tr>
	<tr><td>Alamat</td>    <td class=cb><input type=text name=Alamat size=60 value='$r[Alamat]'></td></tr>
	<tr><td>RT</td>    <td class=cb><input type=text name=RT size=10 value='$r[RT]'>
	RW    <input type=text name=RW size=10 value='$r[RW]'></td></tr>
	<tr><td>Kota</td>    <td class=cb><input type=text name=Kota value='$r[Kota]'>
	Kodepos      <input type=text name=KodePos size=10 value='$r[KodePos]'></td></tr>
	<tr><td>Propinsi</td>    <td class=cb><input type=text name=Propinsi size=40 value='$r[Propinsi]'></td></tr>
	<tr><td>Negara</td>    <td class=cb><input type=text name=Negara value='$r[Negara]'></td></tr>
	<tr><td>Telepon</td>    <td class=cb><input type=text name=Telepon value='$r[Telepon]'></td></tr>
	</thead></table>
	</div>";		
echo"<div class='tab-pane' id='Alamat'>";
	$e=_query("SELECT * FROM mahasiswa WHERE NIM='$_SESSION[yapane]'");
	$re=_fetch_array($e);
echo"<input type=hidden name=NIM value='$re[NIM]'>
	<input type=hidden name=username size=10 value='$re[username]'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><strong>Sesuai Dengan KTP atau Identitas Resmi Lainnya..!!!</strong></td></tr>
	<tr><td>Username</td>  <td class=cb><input type=text value='$re[username]' disabled></td></tr>
	<tr><td>Password</td>  <td class=cb><input type=password name=password size=10> * Kosongkan Jika Tidak diubah</td></tr>
	<tr><td>Tempat Lahir</td>  <td class=cb><input type=text name=TempatLahir size=40 value='$re[TempatLahir]'></td></tr>
	<tr><td>Tanggal Lahir</td>    <td class=cb>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$re[TanggalLahir]",8,2);
		combotgl(1,31,'tgltl',$get_tgl2);
        $get_bln2=substr("$re[TanggalLahir]",5,2);
        combonamabln(1,12,'blntl',$get_bln2);
        $get_thn2=substr("$re[TanggalLahir]",0,4);
        combothn($TahunIni-50,$TahunIni+2,'thntl',$get_thn2);
	echo"</div>";  
echo "</td></tr>";
	if ($re[Kelamin]=='L'){
echo "<tr><td>Jenis Kelamin</td> <td class=cb> : <input type=radio name='Kelamin' value='L' checked> Laki-laki  
		<input type=radio name='Kelamin' value='P'> Perempuan</td></tr>";
	}
	else{
echo "<tr><td>Jenis Kelamin</td> <td class=cb> : <input type=radio name='Kelamin' value='L'> Laki-laki  
	<input type=radio name='Kelamin' value='P' checked> Perempuan</td></tr>";
	}
if ($re[WargaNegara]=='WNA'){
	echo "<tr><td>Warga Negara</td> <td class=cb> : <input type=radio name='WargaNegara' value='WNA' checked> Warga Negara Asing  
	<input type=radio name='WargaNegara' value='WNI'> Warga Negara Indonesia</td></tr>";
	}
	else{
echo "<tr><td>Warga Negara</td> <td class=cb> : <input type=radio name='WargaNegara' value='WNA'> Warga Negara Asing  
	<input type=radio name='WargaNegara' value='WNI' checked> Warga Negara Indonesia</td></tr>";
	}
echo"<tr><td>Jika Asing Sebutkan  <td class=cb>  <input type=text name='Kebangsaan' value='$re[Kebangsaan]'></td></tr>
	<tr><td>Agama</td>    <td class=cb>     <select name='Agama'>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM agama ORDER BY agama_ID");
	while($w=_fetch_array($tampil)){
	if ($re[Agama]==$w[agama_ID]){
echo "<option value=$w[agama_ID] selected>$w[agama_ID] - $w[nama]</option>";
	}
	else{
echo "<option value=$w[agama_ID]>$w[agama_ID] - $w[nama]</option>";
	}
	}                                
echo "</select></td></tr>
	<tr><td>Status Sipil</td>    <td class=cb><select name='StatusSipil'>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM statussipil ORDER BY StatusSipil");
	while($w=_fetch_array($tampil)){
	if ($re[StatusSipil]==$w[StatusSipil]){
	echo "<option value=$w[StatusSipil] selected>$w[StatusSipil] - $w[Nama]</option>";
	}
	else{
	echo "<option value=$w[StatusSipil]>$w[StatusSipil] - $w[Nama]</option>";
	}
	}                                
echo "</select></td></tr>
	<tr><td>Alamat</td>    <td class=cb><input type=text name='AlamatAsal' size=60 value='$re[AlamatAsal]'></td></tr>
	<tr><td>RT</td>    <td class=cb><input type=text name='RTAsal' size=5 value='$re[RTAsal]'>
	RW       <input type=text name='RWAsal' size=5 value='$re[RWAsal]'></td></tr>
	<tr><td>Kota</td>    <td class=cb><input type=text name='KotaAsal' value='$re[KotaAsal]'>
	Kodepos    <input type=text name='KodePosAsal' size=10 value='$re[KodePosAsal]'></td></tr>
	<tr><td>Propinsi</td>    <td class=cb><input type=text name='PropinsiAsal' size=40 value='$re[PropinsiAsal]'></td></tr>
	<tr><td>Negara</td>    <td class=cb><input type=text name='NegaraAsal' value='$re[NegaraAsal]'></td></tr>
	<tr><td>Telepon</td>    <td class=cb><input type=text name='TeleponAsal' value='$re[TeleponAsal]'> 
	HP <input type=text name='Handphone' value='$re[Handphone]'></td></tr>
	<tr><td>E-Mail</td>    <td class=cb><input type=text name='Email' size=30 value='$re[Email]'></td></tr>
    </thead></table>";
	
echo"</div>";	
echo"<div class='tab-pane' id='Ortu'>";	
 echo"<table class='table table-striped'><thead>
                          <tr><td colspan=2><strong>Data Ayah</strong></td></tr>
                          <tr><td>Nama</td>    <td class=cb>     <input type=text name=NamaAyah size=50 value='$re[NamaAyah]'></td></tr>
                          <tr><td>Agama</td>    <td class=cb><select name='AgamaAyah'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM agama ORDER BY agama_ID");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[AgamaAyah]==$w[agama_ID]){
                                          echo "<option value=$w[agama_ID] selected>$w[agama_ID] - $w[nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[agama_ID]>$w[agama_ID] - $w[nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Pendidikan</td>    <td class=cb><select name='PendidikanAyah'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM pendidikanortu ORDER BY Pendidikan");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[PendidikanAyah]==$w[Pendidikan]){
                                          echo "<option value=$w[Pendidikan] selected>$w[Pendidikan] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Pendidikan]>$w[Pendidikan] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Pekerjaan</td>    <td class=cb><select name='PekerjaanAyah'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM pekerjaanortu ORDER BY Pekerjaan");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[PekerjaanAyah]==$w[Pekerjaan]){
                                          echo "<option value=$w[Pekerjaan] selected>$w[Pekerjaan] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Pekerjaan]>$w[Pekerjaan] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Hidup</td>    <td class=cb><select name='HidupAyah'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM hidup ORDER BY Hidup");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[HidupAyah]==$w[Hidup]){
                                          echo "<option value=$w[Hidup] selected>$w[Hidup] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Hidup]>$w[Hidup] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td colspan=2><strong>Data Ibu</strong></td></tr>
                          <tr><td>Nama</td>    <td class=cb><input type=text name='NamaIbu' size=50 value='$re[NamaIbu]'></td></tr>
                          <tr><td>Agama</td>    <td class=cb><select name='AgamaIbu'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM agama ORDER BY agama_ID");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[AgamaIbu]==$w[agama_ID]){
                                          echo "<option value=$w[agama_ID] selected>$w[agama_ID] - $w[nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[agama_ID]>$w[agama_ID] - $w[nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Pendidikan</td>    <td class=cb><select name='PendidikanIbu'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM pendidikanortu ORDER BY Pendidikan");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[PendidikanIbu]==$w[Pendidikan]){
                                          echo "<option value=$w[Pendidikan] selected>$w[Pendidikan] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Pendidikan]>$w[Pendidikan] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Pekerjaan</td>    <td class=cb><select name='PekerjaanIbu'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM pekerjaanortu ORDER BY Pekerjaan");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[PekerjaanIbu]==$w[Pekerjaan]){
                                          echo "<option value=$w[Pekerjaan] selected>$w[Pekerjaan] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Pekerjaan]>$w[Pekerjaan] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td>Hidup</td>    <td class=cb><select name='HidupIbu'>
                                    <option value=0 selected>- Pilih Kategori -</option>";
                                    $tampil=_query("SELECT * FROM hidup ORDER BY Hidup");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[HidupIbu]==$w[Hidup]){
                                          echo "<option value=$w[Hidup] selected>$w[Hidup] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[Hidup]>$w[Hidup] - $w[Nama]</option>";
                                      }
                                 }                                
                            echo "</select></td></tr>
                          <tr><td colspan=2><strong>Alamat Orang Tua</strong></td></tr>
                          <tr><td>Alamat</td>    <td class=cb><input type=text name='AlamatOrtu' size=50 value='$re[AlamatOrtu]'></td></tr>
                          <tr><td>Kota</td>    <td class=cb><input type=text name=KotaOrtu value='$re[KotaOrtu]'>
                                  Kodepos      <input type=text name=KodePosOrtu value='$re[KodePosOrtu]'></td></tr>
                          <tr><td>Propinsi</td>    <td class=cb><input type=text name=PropinsiOrtu value='$re[PropinsiOrtu]'></td></tr>
                          <tr><td>Negara</td>  <td class=cb><input type=text name=NegaraOrtu value='$re[NegaraOrtu]'></td></tr>
                          <tr><td colspan=2><strong>Kontak</strong></td></tr>
                          <tr><td>Telepon</td>    <td class=cb><input type=text name=TeleponOrtu value='$re[TeleponOrtu]'></td></tr>
                          <tr><td>HP</td>   <td class=cb><input type=text name=HandphoneOrtu value='$re[HandphoneOrtu]'></td></tr>
                          <tr><td>E-Mail</td>    <td class=cb><input type=text name=EmailOrtu value='$re[EmailOrtu]'></td></tr>
                        </table>";
echo"</div>";
echo"<div class='tab-pane' id='sekolah'>";	
 echo"<table class='table table-striped'><thead>
                      <tr><td colspan=2><strong>Asal Sekolah Mahasiswa</strong></td></tr>
                      <tr><td>Sekolah Asal</td>    <td class=cb>      <input type=text name='AsalSekolah' size=50 value='$re[AsalSekolah]'></td></tr>
                      <tr><td>Jenis Sekolah</td>    <td class=cb><select name='JenisSekolah_ID'>
                                <option value=0 selected>- Pilih Kategori -</option>";
                                $tampil=_query("SELECT * FROM jenissekolah ORDER BY JenisSekolah_ID");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[JenisSekolah_ID]==$w[JenisSekolah_ID]){
                                          echo "<option value=$w[JenisSekolah_ID] selected>$w[JenisSekolah_ID] - $w[Nama]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[JenisSekolah_ID]>$w[JenisSekolah_ID] - $w[Nama]</option>";
                                      }
                                 }                                
                        echo "</select></td></tr>
                      <tr><td>Jurusan</td>    <td class=cb><select name='JurusanSekolah'>
                                <option value=0 selected>- Pilih Kategori -</option>";
                                $tampil=_query("SELECT * FROM jurusansekolah ORDER BY JurusanSekolah_ID");
                                      while($w=_fetch_array($tampil)){
                                      if ($re[JurusanSekolah]==$w[JurusanSekolah_ID]){
                                          echo "<option value=$w[JurusanSekolah_ID] selected> $w[Nama] - $w[NamaJurusan]</option>";
                                      }
                                      else{
                                          echo "<option value=$w[JurusanSekolah_ID]> $w[Nama] - $w[NamaJurusan]</option>";
                                      }
                                 }                                
                        echo "</select></td></tr>
                      <tr><td>Tahun Lulus</td>    <td class=cb><input type=text name='TahunLulus' value='$re[TahunLulus]'></td></tr>
                      <tr><td>Nilai Sekolah</td>    <td class=cb><input type=text name='NilaiSekolah' size=8 value='$re[NilaiSekolah]'></td></tr>
                    </table>";		
echo"</div>";	
echo"</div>";
echo"<p><center><input class='btn btn-success btn-large' type=submit value=Simpan class=tombol></center></p></form>";		
}
function ProfileDosen(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Profil Dosen");
	$e=_query("SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'");
	$r=_fetch_array($e);
	$MaxFileSize = 500000;
	if (empty($r['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[foto]"; }
	echo"<form method=post enctype='multipart/form-data' action='aksi-profile-uploadfotoDosen.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=3>INFORMASI DOSEN</th></tr>                               
		<tr><td>NIDN</td><td><strong> $r[username]</strong></td>
		<td rowspan=3><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $r[nama_lengkap], $r[Gelar]</strong></td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='DosenId' value='$r[dosen_ID]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-masterdosen.html'><i class='icon-undo'></i> Kembali</a> 
			</div></td>
		<td>	
		<div class='fileupload fileupload-new pull-right' data-provides='fileupload'>
			<div class='input-append'>
				<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='foto'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
				<input class='btn btn-success' type=submit name='Upload' value='Upload Foto'>
			</div>
		</div>
		</td></tr>
<script type='text/javascript'>
$(function (){
    // file input
    $('input[id=the_file]').change(function() {
        $('#choose_file').val($(this).val());
    });
});
</script>
		</thead></table></form>
		<ul class='nav nav-tabs'>
			<li class='active'><a href='#Pribadi' data-toggle='tab'>Data Pribadi</a></li>
			<li><a href='#Alamat' data-toggle='tab'>Alamat</a></li>
			<li><a href='#Akademik' data-toggle='tab'>Akademik</a></li>
			<li><a href='#Jabatan' data-toggle='tab'>Jabatan</a></li>
			<li><a href='#Pendidikan' data-toggle='tab'>Pendidikan</a></li>
			<li><a href='#Pekerjaan' data-toggle='tab'>Pekerjaan</a></li>
			<li><a href='#Penelitian' data-toggle='tab'>Penelitian</a></li>
		</ul>
		<div class='tab-content'>";		
	echo"<div class='tab-pane active' id='Pribadi'>
	<form method=post action='aksi-profile-updsn.html'>
		<input type=hidden name=id value='$r[dosen_ID]'>
		<input type=hidden name=username value='$r[username]'>		
				<table class='table table-striped'><thead>
				<tr><td colspan=2><h4>Bio Data Dosen</h4></td></tr>
				<tr><td class=cc width='30%'>Username</td>
				<td class=cb> <input type=text value='$r[username]' disabled></td></tr>
				<tr><td class=cc>Password</td>     <td class=cb><input type=password name=password size=20'> *) Kosongkan jika tidak diubah</td></tr>
				<tr><td class=cc>NIDN</td>    <td class=cb>        <input type=text name=NIDN value='$r[NIDN]'></td></tr>
				<tr><td class=cc>Nama Dosen</td>    <td class=cb><input type=text name='nama_lengkap' size=30 value='$r[nama_lengkap]'></td></tr>
				<tr><td class=cc>Gelar</td>    <td class=cb>      <input type=text name=Gelar value='$r[Gelar]'></td></tr>
				<tr><td class=cc>Tempat lahir</td><td class=cb> <input type=text name=TempatLahir size=30  value='$r[TempatLahir]'> </td></tr>
				<tr><td class=cc>Tanggal lahir</td>   
				<td class=cb>";  
		echo"<div class='row-fluid'>";		
		$get_tgl2=substr("$r[TanggalLahir]",8,2);
		combotgl(1,31,'tgllahir',$get_tgl2);
        $get_bln2=substr("$r[TanggalLahir]",5,2);
        combonamabln(1,12,'blnlahir',$get_bln2);
        $get_thn2=substr("$r[TanggalLahir]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thnlahir',$get_thn2);
		echo"</div>";
		
			echo "</td></tr></td></tr>
				<tr><td class=cc>Agama</td>
				<td class=cb>
				<select name='Agama'>
				<option value=0 selected>- Pilih Agama -</option>";
				$t=_query("SELECT * FROM agama ORDER BY agama_ID");
				while($w=_fetch_array($t)){
				if ($r[Agama]==$w[agama_ID]){
			echo "<option value=$w[agama_ID] selected> $w[nama]</option>";
				} else {
			echo "<option value=$w[agama_ID]>$w[nama]</option>";
				}
			}                                
			echo "</select></td></tr>
				<tr><td class=cc>Telepon</td>    <td class=cb>   <input type=text name=Telepon value='$r[Telepon]'></td></tr> 
				<tr><td class=cc>Ponsel</td>    <td class=cb>      <input type=text name=Handphone value='$r[Handphone]'></td></tr>
				<tr><td class=cc>E-Mail</td>    <td class=cb>      <input type=text name=Email value='$r[Email]'></td></tr>
				<tr><td class=cc>Identitas</td>    <td class=cb><select name='identitas'>
					<option value=0 selected>- Pilih Identitas -</option>";
					$tampil=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
					while($w=_fetch_array($tampil)){
					if ($r[Identitas_ID]==$w[Identitas_ID]){
			echo "<option value=$w[Identitas_ID] selected> $w[Nama_Identitas]</option>";
				}else{
			echo "<option value=$w[Identitas_ID]> $w[Nama_Identitas]</option>";
				} 
			}
			echo "</select></td></tr>";
				$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan', $r[jurusan_ID]);
			echo"<tr><td class=cc>Program Studi</td>    <td class=cb> $d </td></tr>";
				if ($r[Aktif]=='Y'){
			echo "<tr><td class=cc>Aktif</td> <td class=cb>  <input type=radio name='Aktif' value='Y' checked>Y  
				<input type=radio name='Aktif' value='N'> N</td></tr>";
			}else{
			echo "<tr><td class=cc>Aktif</td> <td class=cb>  <input type=radio name='Aktif' value='Y'>Y  
				<input type=radio name='Aktif' value='N' checked>N</td></tr>";
			}      
echo"<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value=Simpan ></center></td></tr>
</thead></table></div>";
//-----------
echo"<div class='tab-pane' id='Alamat'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>ALamat Lengkap</h4></td></tr>
	<tr><td class=cc>No KTP</td>    <td class=cb><input type=text name='KTP' size=30 value='$r[KTP]'></td></tr>
	<tr><td class=cc>No Telepon</td>    <td class=cb>    <input type=text value='$r[Telepon]' readonly></td></tr>
	<tr><td class=cc>No HP</td>    <td class=cb>    <input type=text value='$r[Handphone]' readonly></td></tr>
	<tr><td class=cc>Email</td>    <td class=cb>      <input type=text value='$r[Email]' readonly></td></tr>
	<tr><td class=cc>Alamat</td>    <td class=cb><textarea name='Alamat' cols=45 rows=5>$r[Alamat]</textarea></td>  </tr>
	<tr><td class=cc>Kota</td>    <td class=cb>      <input type=text name='Kota' size=30 value='$r[Kota]'></td></tr>
	<tr><td class=cc>Propinsi</td>    <td class=cb>   <input type=text name='Propinsi' size=30 value='$r[Propinsi]'></td></tr>
	<tr><td class=cc>Negara</td>    <td class=cb>     <input type=text name='Negara' value='$r[Negara]'></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</thead></table>
	</div>";
 echo"<div class='tab-pane' id='Akademik'><table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Akademik</h4></td></tr>
	<tr><td class=cc>Mulai Bekerja</td>    <td class=cb>";
	echo"<div class='row-fluid'>";		
		$get_tgl2=substr("$r[TglBekerja]",8,2);
		combotgl(1,31,'TglBekerja',$get_tgl2);
        $get_bln2=substr("$r[TglBekerja]",5,2);
        combonamabln(1,12,'BlnBekerja',$get_bln2);
        $get_thn2=substr("$r[TglBekerja]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'ThnBekerja',$get_thn2);
	echo"</div>";                    
echo "</td></tr>
	<tr><td class=cc>Status Dosen</td>    <td class=cb>       <select name='StatusDosen_ID'>
	<option value=0 selected>- Pilih Status Dosen -</option>";
	$tampil=_query("SELECT * FROM statusaktivitasdsn ORDER BY StatusAktivDsn_ID");
	while($w=_fetch_array($tampil)){
	if ($r[StatusDosen_ID]==$w[StatusAktivDsn_ID]){
echo "<option value=$w[StatusAktivDsn_ID] selected>$w[StatusAktivDsn_ID] - $w[Nama]</option>";
	}else{
echo "<option value=$w[StatusAktivDsn_ID]> $w[Nama]</option>";
	}
	}                                
echo "</select></td></tr>
	<tr><td class=cc>Status Kerja</td>    <td class=cb>      <select name='StatusKerja_ID'>
	<option value=0 selected>- Pilih Status Kerja -</option>";
	$tampil=_query("SELECT * FROM statuskerja ORDER BY StatusKerja_ID");
	while($w=_fetch_array($tampil)){
	if ($r[StatusKerja_ID]==$w[StatusKerja_ID]){
echo "<option value=$w[StatusKerja_ID] selected>$w[StatusKerja_ID] - $w[Nama]</option>";
	} else{
echo "<option value=$w[StatusKerja_ID]>$w[StatusKerja_ID] - $w[Nama]</option>";
	}
	}                                
echo "</select></td></tr>
	<tr><td class=cc>Prodi Homebase</td>    <td class=cb>      <input type=text size=10 name='Homebase' value='$r[Homebase]'>
	<tr><td class=cc>Kode Instansi Induk</td>    <td class=cb><input type=text name='InstitusiInduk' value='$r[InstitusiInduk]'></td></tr>
	<tr><td class=cc>Jenjang Penddk. Tertinggi</td>    <td class=cb>      <select name='Jenjang_ID'>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
	while($w=_fetch_array($tampil)){
	if ($r[Jenjang_ID]==$w[Jenjang_ID]){
	echo "<option value=$w[Jenjang_ID] selected>$w[Jenjang_ID] - $w[Nama]</option>";
	}else{
echo "<option value=$w[Jenjang_ID]>$w[Jenjang_ID] - $w[Nama]</option>";
	} 
	}                                
echo "</select></td></tr>
	<tr><td class=cc>Keilmuan</td>    <td class=cb><input type=text name='Keilmuan' size=50 value='$r[Keilmuan]'></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</thead></table></div>";
//----------	
echo"<div class='tab-pane' id='Jabatan'><table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Jabatan</h4></td></tr>
	<tr><td class=cc>Jabatan Akademik</td>    <td class=cb><select name='Jabatan_ID'>
		<option value=0 selected>- Pilih Kategori -</option>";
		$tampil=_query("SELECT * FROM jabatan ORDER BY Jabatan_ID");
		while($w=_fetch_array($tampil)){
		if ($r[Jabatan_ID]==$w[Jabatan_ID]){
	echo "<option value=$w[Jabatan_ID] selected>$w[Jabatan_ID] - $w[Nama]</option>";
	}else{
echo "<option value=$w[Jabatan_ID]>$w[Jabatan_ID] - $w[Nama]</option>";
	} 
	}
echo "</select></td></tr>
	<tr><td class=cc>Jabatan Dikti</td>    <td class=cb><select name='JabatanDikti_ID'>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM jabatandikti ORDER BY JabatanDikti_ID");
	while($w=_fetch_array($tampil)){
	if ($r[JabatanDikti_ID]==$w[JabatanDikti_ID]){
echo "<option value=$w[JabatanDikti_ID] selected>$w[JabatanDikti_ID] - $w[Nama]</option>";
	}else{
echo "<option value=$w[JabatanDikti_ID]>$w[JabatanDikti_ID] - $w[Nama]</option>";
	} 
	}
echo "</select></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</thead></table></form>";						
//------------
echo"</div><div class='tab-pane' id='Pendidikan'>";
echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Pendidikan</h4></td></tr>
	<tr><th>no</th><th>Gelar</th><th>Jenjang</th><th>Tanggal Lulus</th><th>Nama Perguruan Tinggi</th><th>Negara</th><th>Bidang Ilmu</th><th>Aksi</th></tr></thead>"; 
	$tampil=_query("SELECT * FROM dosenpendidikan WHERE DosenID='$_GET[id]' ORDER BY DosenPendidikanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){
	$tgl=tgl_indo($ra[TanggalIjazah]);                        
	$jenjang=get_jenjang($ra[JenjangID]);                        
	$Perting=get_Pt($ra[PerguruanTinggiID]);                        
echo "<tr><td>$no</td>
	<td>$ra[Gelar]</td>
	<td>$jenjang</td>
	<td>$tgl</td>
	<td>$Perting</td>
	<td>$ra[NamaNegara]</td>
	<td>$ra[BidangIlmu]</td>
	<td><a class='thickbox' href='get-profile-editpddkDosn-$ra[DosenPendidikanID].html'><img src=../img/edit.png></a> -
	<a href='get-profile-delpddDosn-$ra[DosenPendidikanID].html'
	onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Gelar $ra[Gelar] ?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
}
echo "</table>                           
	<form method=post action='aksi-profile-addpddDosn.html'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Tambah Pendidikan</h4></td></tr>
	<input type=hidden name=DosenID value='$r[dosen_ID]'>
	<tr><td class=cc>Gelar</td>
	<td class=cb><input type=text name=Gelar></td></tr>
	<tr><td class=cc>Jenjang</td>
	<td class=cb><select name=JenjangID>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
	while($rc=_fetch_array($tampil)){
echo "<option value=$rc[Jenjang_ID]> $rc[Nama]</option>";
	}
echo "</select></td></tr>
	<tr><td class=cc>Tanggal Lulus</td>
	<td class=cb>";        
	combotgl(1,31,'TglIjazah',Tgl);
	combobln(1,12,'BlnIjazah',Bulan);
	combotgl($thn_sekarang-50,$thn_sekarang+1,'ThnIjazah',Tahun);  
echo "</td></tr>
	<tr><td class=cc>Kode P.T</td>
	<td class=cb><input type=text name=PerguruanTinggiID></td></tr>
	<tr><td class=cc>Negara</td>
	<td class=cb><input type=text name=NamaNegara></td></tr>
	<tr><td class=cc>Bidang Ilmu</td>
	<td class=cb><input type=text name=BidangIlmu></td></tr>
	<tr><td class=cc>Program Studi</td>
	<td class=cb><input type=text name=Prodi ></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</thead></table></form>";

echo"</div><div class='tab-pane' id='Pekerjaan'>";    
echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Riwayat Pekerjaan</h4></td></tr>
	<tr><th>no</th><th>Jabatan</th><th>Nama Institusi</th><th>Alamat Institusi</th><th>Kota</th><th>Kode Pos</th><th>Telepon</th><th>Fax</th><th>Aksi</th></tr></thead>"; 
	$tampil=_query("SELECT * FROM dosenpekerjaan WHERE DosenID='$_GET[id]' ORDER BY DosenPekerjaanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){
	echo "<tr><td>$no</td>
	<td>$ra[Jabatan]</td>
	<td>$ra[Institusi]</td>
	<td>$ra[Alamat]</td>
	<td>$ra[Kota]</td>
	<td>$ra[Kodepos]</td>
	<td>$ra[Telepon]</td>
	<td>$ra[Fax]</td>
	<td>
	<a class='thickbox' href='get-profile-editpkjDosn-$ra[DosenPekerjaanID].html'><img src=../img/edit.png></a> |                                 
	<a href='get-profile-delpkjDosn-$ra[DosenPekerjaanID].html'
	onClick=\"return confirm('Anda yakin akan menghapus Pekerjaan $ra[Jabatan] $ra[nama_lengkap]?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
	}
echo "<tfoot><tr><td colspan='9'></td></tr></tfoot></table>
	<form method=post action='aksi-profile-addpkjDosn.html'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Tambah Pekerjaan </h4></td></tr>
	<input type=hidden name=dosen_ID value='$r[dosen_ID]'>
	<tr><td class=cc>Nama Institusi</td>
	<td class=cb><input type=text name=Institusi size=30></td></tr>
	<tr><td class=cc>Jabatan</td>
	<td class=cb><input type=text name=Jabatan size=30></td></tr>
	<tr><td class=cc>Alamat Institusi</td>
	<td class=cb><input type=text name=Alamat size=60></td></tr>
	<tr><td class=cc>Kota</td>
	<td class=cb><input type=text name=Kota></td></tr>
	<tr><td class=cc>Kodepos</td>
	<td class=cb><input type=text name=Kodepos></td></tr>
	<tr><td class=cc>Telepon</td>
	<td class=cb><input type=text name=Telepon></td></tr>
	<tr><td class=cc>Fax</td>
	<td class=cb><input type=text name=Fax></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</table></form>";             
echo"</div><div class='tab-pane' id='Penelitian'>";    
echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Penelitian Dosen</h4></td></tr>
	<tr><th>No</th><th>Nama Penelitian</th><th>Tanggal</th><th></th></tr></thead>"; 
	$tampil=_query("SELECT * FROM dosenpenelitian WHERE DosenID='$_GET[id]' ORDER BY DosenPenelitianID");
	$no=1;
	while ($pe=_fetch_array($tampil)){
	$tglBuat=tgl_indo($pe[TglBuat]);   
	echo "<tr>
	<td>$no</td>
	<td>$pe[NamaPenelitian]</td>
	<td>$tglBuat</td>
	<td>
	<a class='thickbox' href='get-profile-editpnlthanDosn-$pe[DosenPenelitianID].html'><img src=../img/edit.png></a> |                                 
	<a href='get-profile-delpnlthanDosn-$pe[DosenPenelitianID].html'
	onClick=\"return confirm('Anda yakin akan menghapus Penelitian $pe[NamaPenelitian] ?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
	}
echo "<tfoot><tr><td colspan='9'></td></tr></tfoot></table>
	<form method=post action='aksi-profile-addpnlthanDosn.html'>
	<input type=hidden name=id value='$r[dosen_ID]'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Tambah Penelitian </h4></td></tr>
	<input type=hidden name=dosen_ID value='$r[dosen_ID]'>
	<tr><td class=cc>Nama Penelitian</td>
	<td class=cb><input type=text name=NamaPenelitian></td></tr>
	<tr><td class=cc>Tanggal</td>
	<td class=cb>";        
	combotgl(1,31,'TglBuat',Tgl);
	combobln(1,12,'BlnBuat',Bulan);
	combotgl($thn_sekarang-50,$thn_sekarang+1,'ThnBuat',Tahun);  
echo "</td></tr>
	
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</table></form>";             
echo"</div></div>";
tutup();
}
function editpddkDosn(){
buka("Edit Pendidikan Dosen");
$pddosen=_query("SELECT * FROM dosenpendidikan WHERE DosenPendidikanID='$_GET[id]'");
$pd=_fetch_array($pddosen);
echo "<form method=post action='aksi-profile-uppddDosn.html'>
	<table class='table table-striped'><thead>
	<input type=hidden name=DosenPendidikanID value='$pd[DosenPendidikanID]'>
	<input type=hidden name=DosenID value='$pd[DosenID]'>
	<tr><td class=cc>Gelar</td>
	<td class=cb><input type=text name=Gelar value='$pd[Gelar]'></td></tr>
	<tr><td class=cc>Jenjang</td>
	<td class=cb><select name=JenjangID>
	<option value=0 selected>- Pilih Kategori -</option>";
	$tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
	while($w=_fetch_array($tampil)){
	if ($pd[JenjangID]==$w[Jenjang_ID]){
	echo "<option value=$w[Jenjang_ID] selected> $w[Nama]</option>";
	}else{
echo "<option value=$w[Jenjang_ID]> $w[Nama]</option>";
	} 
	} 
echo "</select></td></tr>
	<tr><td class=cc>Tanggal Lulus</td>
	<td class=cb>";
	echo"<div class='row-fluid'>";		
		$get_tgl2=substr("$pd[TanggalIjazah]",8,2);
		combotgl(1,31,'tgl_Ijazah',$get_tgl2);
        $get_bln2=substr("$pd[TanggalIjazah]",5,2);
        combonamabln(1,12,'bln_Ijazah',$get_bln2);
        $get_thn2=substr("$pd[TanggalIjazah]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_Ijazah',$get_thn2);
	echo"</div>";  
echo "</td></tr>
	<tr><td class=cc>Kode P.T</td>
	<td class=cb><input type=text name=PerguruanTinggiID value='$pd[PerguruanTinggiID]'></td></tr>
	<tr><td class=cc>Negara</td>
	<td class=cb><input type=text name=NamaNegara value='$pd[NamaNegara]'></td></tr>
	<tr><td class=cc>Bidang Ilmu</td>
	<td class=cb><input type=text name=BidangIlmu value='$pd[BidangIlmu]'></td></tr>
	<tr><td class=cc>Program Studi</td>
	<td class=cb><input type=text name=Prodi value='$pd[Prodi]'></td></tr>
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</thead></table></form>";
}
function editpnlthanDosn(){
buka("Edit Penelitiab Dosen");
$pndosen=_query("SELECT * FROM dosenpenelitian WHERE DosenPenelitianID='$_GET[id]'");
$p=_fetch_array($pndosen);
echo "<form method=post action='aksi-profile-uppnlthanDosn.html'>
	<table class='table table-striped'><thead>
	<input type=hidden name=DosenID value='$p[DosenID]'>
	<input type=hidden name=DosenPenelitianID value='$p[DosenPenelitianID]'>
	<tr><td class=cc>Nama Penelitian</td>
	<td class=cb><input type=text name=NamaPenelitian value='$p[NamaPenelitian]'></td></tr>
	<tr><td class=cc>Tanggal</td>
	<td class=cb>";  
		echo"<div class='row-fluid'>";		
		$get_tgl2=substr("$r[TglBuat]",8,2);
		combotgl(1,31,'tgl_Buat',$get_tgl2);
        $get_bln2=substr("$r[TglBuat]",5,2);
        combonamabln(1,12,'bln_Buat',$get_bln2);
        $get_thn2=substr("$r[TglBuat]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_Buat',$get_thn2);
		echo"</div>";
		
echo "</td></tr>
	
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Update'></center></td></tr>
	</table></form>"; 
tutup();
}
function editpkjDosn(){
$pkdosen=_query("SELECT * FROM dosenpekerjaan WHERE DosenPekerjaanID='$_GET[id]'");
$d=_fetch_array($pkdosen);
buka("Edit Pekerjaan Dosen");
echo "<form method=post action='aksi-profile-updpkjDosn.html'>
	<table class='table table-striped'><thead>
	<input type=hidden name=DosenID value='$d[DosenID]'>
	<input type=hidden name=DosenPekerjaanID value='$d[DosenPekerjaanID]'>
	<tr><td class=cc>Nama Institusi</td>
	<td class=cb><input type=text name=Institusi value='$d[Institusi]'></td></tr>
	<tr><td class=cc>Jabatan</td>
	<td class=cb><input type=text name=Jabatan value='$d[Jabatan]'></td></tr>
	<tr><td class=cc>Alamat Institusi</td>
	<td class=cb><input type=text name=Alamat value='$d[Alamat]'></td></tr>
	<tr><td class=cc>Kota</td>
	<td class=cb><input type=text name=Kota value='$d[Kota]'></td></tr>
	<tr><td class=cc>Kodepos</td>
	<td class=cb><input type=text name=Kodepos value='$d[Kodepos]'></td></tr>
	<tr><td class=cc>Telepon</td>
	<td class=cb><input type=text name=Telepon value='$d[Telepon]'></td></tr>
	<tr><td class=cc>Fax</td>
	<td class=cb><input type=text name=Fax value='$d[Fax]'></td></tr>
	<tr>
	<td colspan=2>
	<center>
		<input class='btn btn-success' type=submit value='Update'>
	<a class='btn btn-danger' href='get-profile-editmstDosen-$d[DosenID].html'>Batal</a>
	</center>
	</td></tr>
	</thead></table></form>"; 
tutup();	
}
function aplodFotoDosen(){
  $DosenId = $_POST['DosenId'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$DosenId;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_dosen/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE dosen set foto='$dest' where dosen_ID='$DosenId'";
    $r = _query($s);
PesanOk("Upload Foto Dosen","Upload Foto Berhasil","get-profile-editmstDosen-$DosenId.html");	
  } else { 
PesanEror("Upload Foto Dosen", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
}

function defaultprofile(){
buka("Edit Profile");

	$level= ceklevel($_SESSION[yapane]);
	$tbl = GetaField('level', 'id_level', $level, 'TabelUser');
	if ($tbl=='admin'){
	ProfileAdmin();
	}
	elseif ($tbl=='karyawan'){
	ProfileKaryawan();
	}
	elseif ($tbl=='dosen'){
	ProfileDosen(); 
	}
	elseif ($tbl=='mahasiswa'){
	ProfileMahasiswa();
	}
	else{
	  echo "<div class='panel-error'>
		<h1><i class='icon-warning-sign'></i></h1>
		<h2>Akses Ditolak !!</h2>
		<a href='go-dasboard.html' class='btn'>Home</a>
	</div>";
	} 
tutup();
}

switch($_GET[PHPIdSession]){
  default:
    defaultprofile();
  break;  

  case "UpdateKaryawan":
    // Apabila password tidak diubah
	 if (!empty($_POST[kode_jurusan])){
               $jur = $_POST[kode_jurusan];
               $tag=implode(',',$jur);
          }
    if (empty($_POST[password])) {
    $update=_query("UPDATE karyawan SET username= '$_POST[username]',                                          
		Jabatan				= '$_POST[jabatan]',
		Bagian				= '$_POST[bagian]',
		nama_lengkap		= '$_POST[nama_lengkap]',
		Identitas_ID		= '$_POST[identitas]',
		kode_jurusan		= '$tag',
		email				= '$_POST[email]',
		telepon				= '$_POST[telepon]',
		aktif				= '$_POST[aktif]'                                                                                   
		WHERE id			= '$_POST[id]'");
$upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',     
		email       	= '$_POST[email]',
		aktif       	= '$_POST[aktif]'                                                                                   
		WHERE username	= '$_POST[username]'");
    
    }else{
      $password=md5($_POST[password]);
      $update1=_query("UPDATE karyawan SET username    = '$_POST[username]',
			password		= '$password',
			nama_lengkap	= '$_POST[nama_lengkap]',
			Identitas_ID	= '$_POST[identitas]',
			kode_jurusan	= '$tag',
			email			= '$_POST[email]',
			telepon			= '$_POST[telepon]',
			aktif			= '$_POST[aktif]'                                                                                   
			WHERE id		= '$_POST[id]'");
    $upUseryapan=_query("UPDATE useryapan SET 
		Nama = '$_POST[nama_lengkap]',  
		password    = '$password',
		email       	= '$_POST[email]',
		aktif       	= '$_POST[aktif]'                                                                                   
		WHERE username	= '$_POST[username]'");
    }
	PesanOk("Update Profil","Data Profil Berhasil di Update ","go-profile.html");   
  break;
case "aplodFotoDosen":
  $DosenId = $_POST['DosenId'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$DosenId;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_dosen/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE dosen set foto='$dest' where dosen_ID='$DosenId'";
    $r = _query($s);
PesanOk("Upload Foto Dosen","Upload Foto Berhasil","go-profile.html");	
  } else { 
PesanEror("Upload Foto Dosen", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
break;
case "uplodFotoMahasiswa":
  $NIM = $_POST['NIM'];
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_mahasiswa/" . $NIM . '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE mahasiswa set Foto='$dest' where NIM='$NIM'";
    $r = _query($s);
	buka("Upload Foto Mahasiswa");
	SuksesMsg("Upload Foto Berhasil","");
	echo "<center><a class='btn btn-success' href='go-profile.html'><i class='icon-undo'></i> OK</a></center>";
	tutup();
  } else { 
	buka("Upload Foto Mahasiswa");
	echo ErrorMsg("Gagal Meng-Upload Foto",
	"Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload, karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");
	echo "<center><a class='btn btn-danger' href='javascript:history.back()'><i class='icon-undo'></i> Kembali</a></center>";
	tutup();
	}
break;
case "aplodFotoUserAdmin":
$id = $_POST['Id'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$id;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_user/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE admin set foto='$dest' where id='$id'";
    $r = _query($s);
PesanOk("Upload Foto User","Upload Foto Berhasil","get-AdminUser-EditAdminUser-$id.html");	
  } else { 
PesanEror("Upload Foto User", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
  break;
case "aplodFotoUserkarywan":
$id = $_POST['Id'];
  $acak           = rand(50,99);
  $nama_file_unik = $acak.$id;
  $upf = $_FILES['foto']['tmp_name'];
  $arrNama = explode('.', $_FILES['foto']['name']);
  $tipe = $_FILES['foto']['type'];
  $arrtipe = explode('/', $tipe);
  $extensi = $arrtipe[1];
  $dest = "foto_user/" . $nama_file_unik. '.' . $extensi;
  //echo $dest;
  if (move_uploaded_file($upf, $dest)) {
    $s = "UPDATE karyawan set foto='$dest' where id='$id'";
    $r = _query($s);
PesanOk("Upload Foto User","Upload Foto Berhasil","go-profile.html");	
  } else { 
PesanEror("Upload Foto User", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
  break;   
//update mahasiswa
case "updmhsw":
$kode= $_REQUEST['cmbj'];
  if (empty($_POST[password])){
  $Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]); 
  $tglls=sprintf("%02d%02d%02d",$_POST[thntlls],$_POST[blntlls],$_POST[tgltlls]); 
  _query("UPDATE mahasiswa SET username='$_POST[username]',TempatLahir='$_POST[TempatLahir]',
  TanggalLahir='$Tg',
  Kelamin='$_POST[Kelamin]',
  WargaNegara='$_POST[WargaNegara]',
  Kebangsaan='$_POST[Kebangsaan]',
  Agama='$_POST[Agama]',
  StatusSipil='$_POST[StatusSipil]',
  AlamatAsal='$_POST[AlamatAsal]',
  RTAsal='$_POST[RTAsal]',
  RWAsal='$_POST[RWAsal]',
  KotaAsal='$_POST[KotaAsal]',
  KodePosAsal='$_POST[KodePosAsal]',
  PropinsiAsal='$_POST[PropinsiAsal]',
  NegaraAsal='$_POST[NegaraAsal]',
  Handphone='$_POST[Handphone]',
  Email='$_POST[Email]',
  Alamat='$_POST[Alamat]',
  RT='$_POST[RT]',
  RW='$_POST[RW]',
  Kota='$_POST[Kota]',
  KodePos='$_POST[KodePos]',
  Propinsi='$_POST[Propinsi]',
  Negara='$_POST[Negara]',
  Telepon='$_POST[Telepon]',
  identitas_ID='$_POST[cmi]',
  IDProg='$_POST[cmbp]',
  kode_jurusan='$_POST[cmbj]',
  PenasehatAkademik='$_POST[pa]',
  StatusAwal_ID='$_POST[StatusAwal_ID]',
  StatusMhsw_ID='$_POST[StatusMhsw_ID]',
  NamaAyah='$_POST[NamaAyah]',
  AgamaAyah='$_POST[AgamaAyah]',
  PendidikanAyah='$_POST[PendidikanAyah]',
  PekerjaanAyah='$_POST[PekerjaanAyah]',
  HidupAyah='$_POST[HidupAyah]',
  NamaIbu='$_POST[NamaIbu]',
  AgamaIbu='$_POST[AgamaIbu]',
  PendidikanIbu='$_POST[PendidikanIbu]',
  PekerjaanIbu='$_POST[PekerjaanIbu]',
  HidupIbu='$_POST[HidupIbu]',
  AlamatOrtu='$_POST[AlamatOrtu]',
  KotaOrtu='$_POST[KotaOrtu]',
  KodePosOrtu='$_POST[KodePosOrtu]',
  PropinsiOrtu='$_POST[PropinsiOrtu]',
  NegaraOrtu='$_POST[NegaraOrtu]',
  TeleponOrtu='$_POST[TeleponOrtu]',
  HandphoneOrtu='$_POST[HandphoneOrtu]',
  EmailOrtu='$_POST[EmailOrtu]',
  AsalSekolah='$_POST[AsalSekolah]',
  JenisSekolah_ID='$_POST[JenisSekolah_ID]',
  JurusanSekolah='$_POST[JurusanSekolah]',
  TahunLulus='$_POST[TahunLulus]',
  NilaiSekolah='$_POST[NilaiSekolah]',  
  aktif='$_POST[Aktif]'
  WHERE NIM='$_POST[NIM]'");  
$upUseryapan=_query("UPDATE useryapan SET
	email       	= '$_POST[Email]',
	aktif       	= '$_POST[Aktif]'                                                                                   
	WHERE username	= '$_POST[NIM]'");	 
  }
  else{
  $pasws=md5($_POST[password]);
  $Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]); 
  $tglls=sprintf("%02d%02d%02d",$_POST[thntlls],$_POST[blntlls],$_POST[tgltlls]); 
  _query("UPDATE mahasiswa SET username='$_POST[username]',password='$pasws',
  TempatLahir='$_POST[TempatLahir]',
  TanggalLahir='$Tg',
  Kelamin='$_POST[Kelamin]',
  WargaNegara='$_POST[WargaNegara]',
  Kebangsaan='$_POST[Kebangsaan]',
  Agama='$_POST[Agama]',
  StatusSipil='$_POST[StatusSipil]',
  AlamatAsal='$_POST[AlamatAsal]',
  RTAsal='$_POST[RTAsal]',
  RWAsal='$_POST[RWAsal]',
  KotaAsal='$_POST[KotaAsal]',
  KodePosAsal='$_POST[KodePosAsal]',
  PropinsiAsal='$_POST[PropinsiAsal]',
  NegaraAsal='$_POST[NegaraAsal]',
  Handphone='$_POST[Handphone]',
  Email='$_POST[Email]',
  Alamat='$_POST[Alamat]',
  RT='$_POST[RT]',
  RW='$_POST[RW]',
  Kota='$_POST[Kota]',
  KodePos='$_POST[KodePos]',
  Propinsi='$_POST[Propinsi]',
  Negara='$_POST[Negara]',
  Telepon='$_POST[Telepon]',
  identitas_ID='$_POST[cmi]',
  Foto= '$nama_file',
  IDProg='$_POST[cmbp]',
  kode_jurusan='$_POST[cmbj]',
  PenasehatAkademik='$_POST[pa]',
  StatusAwal_ID='$_POST[StatusAwal_ID]',
  StatusMhsw_ID='$_POST[StatusMhsw_ID]',
  NamaAyah='$_POST[NamaAyah]',
  AgamaAyah='$_POST[AgamaAyah]',
  PendidikanAyah='$_POST[PendidikanAyah]',
  PekerjaanAyah='$_POST[PekerjaanAyah]',
  HidupAyah='$_POST[HidupAyah]',
  NamaIbu='$_POST[NamaIbu]',
  AgamaIbu='$_POST[AgamaIbu]',
  PendidikanIbu='$_POST[PendidikanIbu]',
  PekerjaanIbu='$_POST[PekerjaanIbu]',
  HidupIbu='$_POST[HidupIbu]',
  AlamatOrtu='$_POST[AlamatOrtu]',
  KotaOrtu='$_POST[KotaOrtu]',
  KodePosOrtu='$_POST[KodePosOrtu]',
  PropinsiOrtu='$_POST[PropinsiOrtu]',
  NegaraOrtu='$_POST[NegaraOrtu]',
  TeleponOrtu='$_POST[TeleponOrtu]',
  HandphoneOrtu='$_POST[HandphoneOrtu]',
  EmailOrtu='$_POST[EmailOrtu]',
  AsalSekolah='$_POST[AsalSekolah]',
  JenisSekolah_ID='$_POST[JenisSekolah_ID]',
  JurusanSekolah='$_POST[JurusanSekolah]',
  TahunLulus='$_POST[TahunLulus]',
  NilaiSekolah='$_POST[NilaiSekolah]',  
  aktif='$_POST[Aktif]'
  WHERE NIM='$_POST[NIM]'");  
$upUseryapan=_query("UPDATE useryapan SET
	password		='$pasws',
	email       	= '$_POST[Email]',
	aktif       	= '$_POST[Aktif]'                                                                                   
	WHERE username	= '$_POST[NIM]'");	
  }
   	buka("Update Data Mahasiswa");
	echo SuksesMsg("Data Mahasiswa Berhasil Di Update","");
	echo "<center><a class='btn btn-success' href='go-profile.html'><i class='icon-undo'></i> OK </a></center>";
	tutup();  
break;
case "UpdateUser":
    // Apabila password tidak diubah
    if (empty($_POST[password])) {
    $updateUser=_query("UPDATE admin SET username = '$_POST[username]',
				nama_lengkap	= '$_POST[nama_lengkap]',
				email       	= '$_POST[email]',
				telepon     	= '$_POST[telepon]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE id		= '$_POST[id]'");
    $upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',     
				email       	= '$_POST[email]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");
    }else{
      $password=md5($_POST[password]);
	$update1=_query("UPDATE admin SET username = '$_POST[username]',
				password    = '$password',
				nama_lengkap= '$_POST[nama_lengkap]',
				email       = '$_POST[email]',
				telepon     = '$_POST[telepon]',
				aktif       = '$_POST[aktif]'                                                                                   
				WHERE id    = '$_POST[id]'");
    $upUseryapan1=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',
				password    	= '$password',
				email       	= '$_POST[email]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");
    }
    PesanOk("Update Data User","Data User Berhasil Di Update","go-profile.html");    
break;
case "updsn":
	$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_file   = $_FILES['fupload']['name'];   	  
	$TanggalLahir=sprintf("%02d%02d%02d",$_POST[thnlahir],$_POST[blnlahir],$_POST[tgllahir]);
	$TglBekerja=sprintf("%02d%02d%02d",$_POST[ThnBekerja],$_POST[BlnBekerja],$_POST[TglBekerja]);

          if (!empty($_POST[kode_jurusan])){
               $jur = $_POST[kode_jurusan];
               $tag=implode(',',$jur);
          }


  // Apabila password tidak diganti
  if (empty($_POST[password])) {
    _query("UPDATE dosen SET username = '$_POST[username]',
          NIDN = '$_POST[NIDN]',
          nama_lengkap = '$_POST[nama_lengkap]',
          TempatLahir = '$_POST[TempatLahir]',
          TanggalLahir = '$TanggalLahir',
          KTP = '$_POST[KTP]',
          Agama = '$_POST[Agama]',
          Alamat = '$_POST[Alamat]',
          Email = '$_POST[Email]',
          Telepon = '$_POST[Telepon]',
          Handphone = '$_POST[Handphone]',
          Keterangan = '$_POST[Keterangan]',
          Kota = '$_POST[Kota]',
          Propinsi = '$_POST[Propinsi]',
          Negara = '$_POST[Negara]',
          Identitas_ID = '$_POST[identitas]',
          Homebase = '$_POST[Homebase]',
          Jurusan_ID = '$tag',      
          Gelar = '$_POST[Gelar]',
          Jenjang_ID = '$_POST[Jenjang_ID]',
          Keilmuan = '$_POST[Keilmuan]',
          Kelamin_ID = '$_POST[Kelamin_ID]',
          Jabatan_ID = '$_POST[Jabatan_ID]',
          JabatanDikti_ID = '$_POST[JabatanDikti_ID]',
          InstitusiInduk = '$_POST[InstitusiInduk]',
          TglBekerja= '$_POST[InstitusiInduk]',
          StatusDosen_ID = '$_POST[StatusDosen_ID]',
          StatusKerja_ID = '$_POST[StatusKerja_ID]',
          Aktif = '$_POST[Aktif]'
          WHERE dosen_ID   = '$_POST[id]'");
		  
	$upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',
				email       	= '$_POST[email]',
				Jabatan       	= '$_POST[Jabatan_ID]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");
	
	PesanOk("Update Data Dosen","Data Dosen Berhasil Update","go-profile.html");	
  }else{
	$password=md5($_POST[password]);
    _query("UPDATE dosen SET username = '$_POST[username]',
          password='$password',
          NIDN = '$_POST[NIDN]',
          nama_lengkap = '$_POST[nama_lengkap]',
          TempatLahir = '$_POST[TempatLahir]',
          TanggalLahir = '$TanggalLahir',
          KTP = '$_POST[KTP]',
          Agama = '$_POST[Agama]',
          Alamat = '$_POST[Alamat]',
          Email = '$_POST[Email]',
          Telepon = '$_POST[Telepon]',
          Handphone = '$_POST[Handphone]',
          Keterangan = '$_POST[Keterangan]',
          Kota = '$_POST[Kota]',
          Propinsi = '$_POST[Propinsi]',
          Negara = '$_POST[Negara]',
          Identitas_ID = '$_POST[identitas]',
          Homebase = '$_POST[Homebase]',
          Jurusan_ID = '$tag',      
          Gelar = '$_POST[Gelar]',
          Jenjang_ID = '$_POST[Jenjang_ID]',
          Keilmuan = '$_POST[Keilmuan]',
          Kelamin_ID = '$_POST[Kelamin_ID]',
          Jabatan_ID = '$_POST[Jabatan_ID]',
          JabatanDikti_ID = '$_POST[JabatanDikti_ID]',
          InstitusiInduk = '$_POST[InstitusiInduk]',
          TglBekerja= '$_POST[InstitusiInduk]',
          StatusDosen_ID = '$_POST[StatusDosen_ID]',
          StatusKerja_ID = '$_POST[StatusKerja_ID]',
          Aktif = '$_POST[Aktif]'
          WHERE dosen_ID   = '$_POST[id]'");
		  
	$upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',
				password    	= '$password',
				email       	= '$_POST[email]',
				Jabatan       	= '$_POST[Jabatan_ID]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");	  
	PesanOk("Update Data Dosen","Data Dosen Berhasil Update","go-profile.html");
}
  break;

//Tambah Penelitian Dosen  
case "addpnlthanDosn":
	$Tgldibuat=sprintf("%02d%02d%02d",$_POST[ThnBuat],$_POST[BlnBuat],$_POST[TglBuat]);
	$nama_tabel="dosenpenelitian";
	$values="'','$_POST[NamaPenelitian]','$_POST[dosen_ID]','$Tgldibuat'";
	insert($nama_tabel,$values);
	PesanOk("Tambah Penelitian Dosen","Data Penelitian Dosen Berhasil Disimpan","go-profile.html"); 

break;
case "editpnlthanDosn":
editpnlthanDosn();
break;

case "editpddkDosn":
editpddkDosn();
break;
//Tambah pekerjaan Dosen  
case "addpkjDosn":
	$nama_tabel="dosenpekerjaan";
	$values="'','$_POST[dosen_ID]','$_POST[Jabatan]','$_POST[Institusi]','$_POST[Alamat]','$_POST[Kota]','$_POST[Kodepos]','$_POST[Telepon]','$_POST[Fax]'";
	insert($nama_tabel,$values);
	PesanOk("Tambah Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Disimpan","go-profile.html"); 

break;

case "addpddDosn":
	$Tglijazah=sprintf("%02d%02d%02d",$_POST[ThnIjazah],$_POST[BlnIjazah],$_POST[TglIjazah]);
	$nama_tabel="dosenpendidikan";
	$values="'','$_POST[DosenID]',
			'$_POST[JenjangID]',
			'$Tglijazah',
			'$_POST[Gelar]',
			'$_POST[PerguruanTinggiID]',
			'$_POST[NamaNegara]',
			'$_POST[BidangIlmu]',
			'$_POST[Prodi]'";
	insert($nama_tabel,$values);
	PesanOk("Tambah Pendidikan Dosen","Data Pendidikan Dosen Berhasil Disimpan","go-profile.html"); 

break;

case "editpkjDosn":
editpkjDosn();
break;

case "delpkjDosn":
	$nama_tabel="dosenpekerjaan";
	$kondisi="DosenPekerjaanID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Di Hapus","go-profile.html"); 
break;

case "delpnlthanDosn":
	$nama_tabel="dosenpenelitian";
	$kondisi="DosenPenelitianID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Penelitian Dosen","Data Penelitian Dosen Berhasil Di Hapus","go-profile.html"); 

break;

case "delpddDosn":
	$nama_tabel="dosenpendidikan";
	$kondisi="DosenPendidikanID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Pendidikan Dosen","Data Pendidikan Dosen Berhasil Di Hapus","go-profile.html"); 

break;

case "uppddDosn":
	$Tglijazah=sprintf("%02d%02d%02d",$_POST[thn_Ijazah],$_POST[bln_Ijazah],$_POST[tgl_Ijazah]);
	$nama_tabel="dosenpendidikan";
	$values="DosenID='$_POST[DosenID]', 
			JenjangID='$_POST[JenjangID]', 
			TanggalIjazah='$Tglijazah',
			Gelar='$_POST[Gelar]',
			PerguruanTinggiID='$_POST[PerguruanTinggiID]',
			NamaNegara='$_POST[NamaNegara]',
			BidangIlmu='$_POST[BidangIlmu]',
			Prodi='$_POST[Prodi]'";
	$kondisi="DosenPendidikanID='$_POST[DosenPendidikanID]'";
	update($nama_tabel,$values,$kondisi);
	PesanOk("Update Pendidikan Dosen","Data Pendidikan Dosen Berhasil Di Update","get-profile.html"); 

break;

case "updpkjDosn":
	$nama_tabel="dosenpekerjaan";
	$values="DosenID='$_POST[DosenID]', 
			Jabatan='$_POST[Jabatan]', 
			Institusi='$_POST[Institusi]',
			Alamat='$_POST[Alamat]',
			Kota='$_POST[Kota]',
			Kodepos='$_POST[Kodepos]',
			Telepon='$_POST[Telepon]',
			Fax='$_POST[Fax]'";
	$kondisi="DosenPekerjaanID='$_POST[DosenPekerjaanID]'";
	update($nama_tabel,$values,$kondisi);
	PesanOk("Update Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Di Update","get-profile.html"); 

break;


case "uppnlthanDosn":
	$Tgldibuat=sprintf("%02d%02d%02d",$_POST[thn_Buat],$_POST[bln_Buat],$_POST[tgl_Buat]);
	$nama_tabel="dosenpenelitian";
	$values="NamaPenelitian ='$_POST[NamaPenelitian]', 
			DosenID='$_POST[DosenID]', 
			TglBuat ='$Tgldibuat'";
	$kondisi="DosenPenelitianID ='$_POST[DosenPenelitianID]'";
	update($nama_tabel,$values,$kondisi);
	PesanOk("Update Penelitian Dosen","Data Penelitian Dosen Berhasil Di Update","get-profile.html"); 
break;
}
?>
