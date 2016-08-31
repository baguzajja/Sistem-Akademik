    <script language="javascript" type="text/javascript">
    <!--
    function MM_jumpMenu(targ,selObj,restore){// v3.0
     eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    if (restore) selObj.selectedIndex=0;
    }
    //-->
    </script>
<?php 
function Deflevelakademikmhs(){
$kode= $_REQUEST['codd'];
$edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
$data=_fetch_array($edit);
buka("BAAK :: Master Mahasiswa");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-levelakademikmhs-TambahMhs.html'>Tambah Mahasiswa</a></p> </div>";
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
	<tr><th>NO</th><th>NIM</th><th>NAMA</th><th>PRODI</th><th>KELAS</th><th>STATUS </th><th>ANGKTAN</th><th>Aksi</th></tr></thead>";
	$sql="SELECT * FROM mahasiswa WHERE kode_jurusan='$data[kode_jurusan]' ORDER BY NIM";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){          	
	$no++;
	echo "<tr bgcolor=$warna>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>$r[nama_jurusan]</td>
		<td>$r[Program_ID]</td>
		<td>$r[StatusMhsw_ID]</td>
		<td>$r[Angkatan]</td>
		<td><a href='mhsw-levelakademikmhs-chagmstmhs-$r[NIM]-$r[kode_jurusan].html'><img src=../img/edit.png></a> |
		<a href=\"mhsw-levelakademikmhs-delmstmhsw-$r[NIM]-$r[kode_jurusan].html\"
		onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NIM] - $r[Nama]?')\"><img src=../img/del.jpg></a>
		</td></tr>";        
		}
	$tampil2 = _query("SELECT * FROM mahasiswa WHERE kode_jurusan='$data[kode_jurusan]'");
	$jmldata = _num_rows($tampil2);
	echo "<tfoot><tr><td colspan='10'>
	Total Keseluruhan  <span class='badge badge-inverse'>$jmldata</span> Mahasiswa
	</td></tr></tfoot>";
	echo"</table>";
tutup();
}
function chagmstmhs(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Administrator :: Edit Master Mahasiswa");
	$id= $_REQUEST['id'];
	$kode= $_REQUEST['codd'];
	$e=_query("SELECT * FROM mahasiswa WHERE NIM='$_GET[id]' AND kode_jurusan='$_GET[codd]'");
	$r=_fetch_array($e); 
	$MaxFileSize = 50000;
	if (empty($r['Foto'])){
	$foto = "file/no-foto.jpg";
	}else{
	$foto = "$r[Foto]";
	}
	echo"<form method=post enctype='multipart/form-data' action='aksi-levelakademikmhs-uplodFotoMahasiswa.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=2>INFORMASI MAHASISWA</th></tr>                               
		<tr><td>NIM</td><td><strong> $r[NIM]</strong></td>
		<td rowspan=5><img alt='$r[nama_lengkap]' src='$foto' width='250px' class='pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $r[Nama]</strong></td></tr>
		<tr><td>Kelas</td><td>$r[Program_ID]</td></tr>
		<tr><td>Program Studi</td><td>$r[kode_jurusan] - $r[nama_jurusan]</td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='NIM' value='$r[NIM]' />
			<input type=hidden name='prodi' value='$r[kode_jurusan]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='go-levelakademikmhs.html'><i class='icon-undo'></i> Kembali</a> 
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
echo"<form method=post action='aksi-levelakademikmhs-updmhsw.html' enctype='multipart/form-data'> 
	<div class='tab-content'>
	<div class='tab-pane active' id='Akademik'>";
echo"<table class='table table-striped'><thead>
	<tr><td>Institusi *</td>    <td class=cb>
	<select name='cmi' id=cmi1>
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
	<select name='cmbj' id=cmbj1>
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
	<select name='cmbp' id=cmbp>
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
	<tr><td>Status Awal *</td>    <td class=cb><select name='StatusAwal_ID'>
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
	<td class=cb><select name='StatusMhsw_ID'>
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
	$e=_query("SELECT * FROM mahasiswa WHERE NIM='$_GET[id]'");
	$re=_fetch_array($e);
echo"<input type=hidden name=NIM value='$re[NIM]'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><strong>Sesuai Dengan KTP atau Identitas Resmi Lainnya..!!!</strong></td></tr>
	<tr><td>Username</td>  <td class=cb><input type=text name=username size=10 value='$re[username]'></td></tr>
	<tr><td>Password</td>  <td class=cb><input type=text name=password size=10> * Kosongkan Jika Tidak diubah</td></tr>
	<tr><td>Tempat Lahir</td>  <td class=cb><input type=text name=TempatLahir size=40 value='$re[TempatLahir]'></td></tr>
	<tr><td>Tanggal Lahir</td>    <td class=cb>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$re[TanggalLahir]",8,2);
		combotgl(1,31,'tgltl',$get_tgl2);
        $get_bln2=substr("$re[TanggalLahir]",5,2);
        combonamabln(1,12,'blntl',$get_bln2);
        $get_thn2=substr("$re[TanggalLahir]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thntl',$get_thn2);
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
	$tampil=_query("SELECT * FROM StatusSipil ORDER BY StatusSipil");
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
                                    $tampil=_query("SELECT * FROM Pendidikanortu ORDER BY Pendidikan");
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
                                    $tampil=_query("SELECT * FROM Pendidikanortu ORDER BY Pendidikan");
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
                                $tampil=_query("SELECT * FROM jenisSekolah ORDER BY JenisSekolah_ID");
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
                                $tampil=_query("SELECT * FROM jurusanSekolah ORDER BY JurusanSekolah_ID");
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
tutup();
}
function TambahMhs(){
buka("Administrator :: Tambah Mahasiswa Baru");
$edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
$data=_fetch_array($edit);   
   echo"<form action='aksi-levelakademikmhs-addmhsw.html' method='post'>
	<legend>Mahasiswa Baru <small>(Yang bertanda * Harus diisi)</small><p class='pull-right'><a class='btn btn-danger' href='go-levelakademikmhs.html'><i class='icon-undo'></i> Kembali</a></p></legend>
	<table class='table table-striped'><thead>
		<input name=identitas type=hidden value=$data[Identitas_ID]>
		<input name=cmbj1 type=hidden value=$data[kode_jurusan]></td>
	</tr>";
	echo"<tr><td class=cc>Program *</td>  <td>  <select name='cmbp1'>
		<option value=0 selected>- Pilih Program -</option>";
		$t=_query("SELECT * FROM program WHERE Identitas_ID='$data[Identitas_ID]' ORDER BY ID");
		while($r=_fetch_array($t)){
	echo "<option value=$r[ID]>  $r[nama_program]</option>";
	}
	echo" </select></td></tr> 
	<tr><td class=cc>Konsentrasi *</td>  <td>  <select name='nkur'>
		<option value=0 selected>- Pilih Konsentrasi -</option>";
		$t=_query("SELECT * FROM kurikulum WHERE Identitas_ID='$data[Identitas_ID]' AND Jurusan_ID='$data[kode_jurusan]' ORDER BY Kurikulum_ID");
		while($r=_fetch_array($t)){
	echo "<option value=$r[Kurikulum_ID]> $r[Nama]</option>";
	}
	echo "</select></td></tr>
                           <tr><td class=cc>Nama Lengkap *</td>  <td><input type=text name=Nama size=40></td></tr>
                            <tr><td class=cc>NIM *</td>  <td><input type=text name=NIM size=16></td></tr>
                            <tr><td class=cc>Angkatan *</td>  <td><input type=text name=Angkatan size=7></td></tr>
                            <tr><td class=cc>Username *</td>  <td><input type=text name=username size=15> Username Harus NIM</td></tr>
                            <tr><td class=cc>Password *</td>  <td><input type=text name=password size=15></td></tr>
                            <tr><td class=cc>Tempat Lahir</td>  <td><input type=text name=TempatLahir size=40></td></tr>
                            <tr><td class=cc>Tanggal Lahir</td>    <td>";
                combotgl(1,31,'tgltl',Tgl);
                combobln(1,12,'blntl',Bulan);
                $t=date("Y");
                combotgl($t-50,$t+1,'thntl',Tahun); 
                              echo "</td></tr>";
                echo"<tr><td class=cc>Jenis Kelamin</td>      <td> <input type=radio name='Kelamin' value='L' checked> Laki-Laki 
                                               <input type=radio name='Kelamin' value='P'> Perempuan  </td></tr>
      <tr><td class=cc>Warga Negara</td>      <td><input type=radio name='WargaNegara' value='WNA' checked> Warga Negara Asing
                                               <input type=radio name='WargaNegara' value='WNI'> Warga Negara Indonesia  </td></tr>
                            <tr><td class=cc>Jika WNA Sebutkan</td>  <td><input type=text name=Kebangsaan size=20></td></tr>
                <tr><td class=cc>Agama</td>  <td> 
                <select name='Agama'>
                  <option value=0 selected>- Pilih Agama -</option>";
                  $t=_query("SELECT * FROM agama ORDER BY agama_ID");
                  while($r=_fetch_array($t)){
                    echo "<option value=$r[agama_ID]>  $r[nama]</option>";
                  }
          echo "</select></td></tr>
                <tr><td class=cc>Status Sipil</td>  <td>
                <select name='StatusSipil'>
                  <option value=0 selected>- Pilih Status Sipil -</option>";
                  $t=_query("SELECT * FROM statussipil ORDER BY StatusSipil");
                  while($r=_fetch_array($t)){
                    echo "<option value=$r[StatusSipil]>  $r[Nama]</option>";
                  }
          echo "</select></td></tr>
      
                            <tr><td class=cc>Alamat</td>    <td> <input type=text name='Alamat' size=60></td></tr>
                            <tr><td class=cc>RT</td>    <td> <input type=text name='RT' size=5>
                                    RW       <input type=text name='RW' size=5></td></tr>
                            <tr><td class=cc>Kota</td>    <td> <input type=text name='Kota'>
                                    Kodepos    <input type=text name='KodePos' size=10></td></tr>
                            <tr><td class=cc>Propinsi</td>    <td> <input type=text name='Propinsi' size=40 ></td></tr>
                            <tr><td class=cc>Negara</td>    <td> <input type=text name='Negara'></td></tr>
                            <tr><td class=cc>Telepon</td>   <td> <input type=text name='Telepon'> 
                                    HP <input type=text name='Handphone'></td></tr>
                <tr><td class=cc>Status Awal *</td>  <td> 
                <select name='StatusAwal_ID'>
                  <option value=0 selected>- Pilih Status Awal Mahasiswa -</option>";
                  $t=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
                  while($r=_fetch_array($t)){
                    echo "<option value=$r[StatusAwal_ID]> $r[Nama]</option>";
                  }
          echo "</select></td></tr>
                <tr><td class=cc>Penasehat Akademik *</td>  <td> 
                <select name='pa'>
                  <option value=0 selected>- Pilih Penasehat Akademik -</option>";
                  $t=_query("SELECT * FROM dosen WHERE Identitas_ID='$data[Identitas_ID]' AND Jurusan_ID LIKE '%$data[kode_jurusan]%' ORDER BY dosen_ID");
                  while($r=_fetch_array($t)){
                    echo "<option value=$r[NIDN]>$r[nama_lengkap], $r[Gelar]</option>";
                  }
          echo "</select></td></tr>";
       echo"<tr><td colspan='2'><center><input class='btn btn-success btn-large' type=submit value=Simpan class=tombol></center></td></tr></thead></table></form>";
tutup();
}
switch($_GET[PHPIdSession]){
	default:
 Deflevelakademikmhs();   
	break;

  case "chagmstmhs":
chagmstmhs();
  break;

  case "TambahMhs":
TambahMhs();  
  break;
  
	case "addmhsw":
	  $kode= $_REQUEST['cmbj1'];
if (!empty($_POST[NIM])){
  $Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]);  
   $c=_num_rows(_query("SELECT * FROM mahasiswa WHERE NIM='$_POST[NIM]'"));
        if ($c > 0){
	PesanEror("Tambah Mahasiswa","Data Mahasiswa Sudah ada dalam Database");	
           } else {
    $pass=md5($_POST[password]);
  $a=_query("INSERT INTO mahasiswa (NIM,
  username,
  password,
  Angkatan,
  Kurikulum_ID,
  identitas_ID,
  Nama,StatusAwal_ID,
  StatusMhsw_ID,
  IDProg,
  kode_jurusan,
  PenasehatAkademik,
  Kelamin,
  WargaNegara,
  Kebangsaan,
  TempatLahir,
  TanggalLahir,
  Agama,
  StatusSipil,
  Telepon,
  Handphone,
  AlamatAsal,
  KotaAsal,
  RTAsal,
  RWAsal,
  KodePosAsal,
  PropinsiAsal,
  NegaraAsal)VALUES
  ('$_POST[NIM]','$_POST[username]','$pass','$_POST[Angkatan]','$_POST[nkur]','$_POST[identitas]','$_POST[Nama]','$_POST[StatusAwal_ID]','$_POST[StatusMhsw_ID]','$_POST[cmbp1]','$_POST[cmbj1]','$_POST[pa]','$_POST[Kelamin]','$_POST[WargaNegara]','$_POST[Kebangsaan]','$_POST[TempatLahir]','$Tg','$_POST[Agama]','$_POST[StatusSipil]','$_POST[Telepon]','$_POST[Handphone]','$_POST[Alamat]','$_POST[Kota]','$_POST[RT]','$_POST[RW]','$_POST[KodePos]','$_POST[Propinsi]','$_POST[Negara]')");
	PesanOk("Tambah Mahasiswa Baru","Data Mahasiswa Berhasil di Simpan ","on-levelakademikmhs-$kode-$jur.html");    
   }
   }else {
   PesanEror("Tambah Mahasiswa","NIM Tidak Boleh Kosong");
   }
	break;
	
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
  } else {
  $pass=md5($_POST[password]);
 // move_uploaded_file($lokasi_file,"foto_mhs/$nama_file");
  $Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]); 
  $tglls=sprintf("%02d%02d%02d",$_POST[thntlls],$_POST[blntlls],$_POST[tgltlls]); 
  _query("UPDATE mahasiswa SET username='$_POST[username]',password='$pass',TempatLahir='$_POST[TempatLahir]',
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

  }
PesanOk("Update Data Mahasiswa","Data Mahasiswa Berhasil di Update ","on-levelakademikmhs-$kode-$jur.html");  
break;
	
	case "delmstmhsw":
 $kode= $_REQUEST['codd'];
 $cek=_fetch_array(_query("SELECT * FROM mahasiswa WHERE NIM='$_GET[id]'"));
 if ($cek['Foto']!=''){
 _query("DELETE FROM mahasiswa WHERE NIM='$_GET[id]'");
  unlink("$cek[Foto]");
  }else{
   _query("DELETE FROM mahasiswa WHERE NIM='$_GET[id]'");
  }
	buka("Hapus Data Mahasiswa");
	echo SuksesMsg("Data Mahasiswa Berhasil Di Hapus","");
	echo "<center><a class='btn btn-success' href='in-levelakademikmhs-$kode.html'><i class='icon-ok'></i> OK </a></center>";
	tutup(); 	
	break;
	
	case "uplodFotoMahasiswa":
  $prodi = $_POST['prodi'];
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
	echo "<center><a class='btn btn-success' href='mhsw-levelakademikmhs-chagmstmhs-$NIM-$prodi.html'><i class='icon-undo'></i> OK</a></center>";
	tutup();
  } else { 
	buka("Upload Foto Mahasiswa");
	echo ErrorMsg("Gagal Meng-Upload Foto",
	"Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload, karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");
	echo "<center><a class='btn btn-danger' href='javascript:history.back()'><i class='icon-undo'></i> Kembali</a></center>";
	tutup();
	}
}     
        
?>
