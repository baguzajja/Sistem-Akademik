<?php
function defaultmstDosen(){
$identitas=$_SESSION['Identitas'];
buka("Master Dosen");
echo"<legend><i>Data Dosen</i>
		<span class='pull-right'>
			<div class='btn-group'>
					<a class='btn btn-success' href='aksi-masterdosen-tambahmstDosen.html'>Tambah Dosen</a>
					<a class='btn' href='go-importDosen.html' title='Import Data Dosen'>Import</a>
					<a class='btn btn-inverse' href='eksport-eksDosen-$identitas.html' title='Eksport data Dosen'>Export</a>
			</div>
		</span>
	</legend>";
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead>
	<tr><th>No</th><th>Mdl</th><th>NIDN</th><th>Nama</th><th>Gelar</th><th>Prodi</th><th>Telepon</th><th>Aktif</th><th>Aksi</th></tr>
	</thead><tbody>"; 
    $sql="SELECT * FROM dosen WHERE Identitas_ID='$identitas' ORDER BY nama_lengkap ASC";
	$qry= _query($sql)or die ();
	while ($data=_fetch_array($qry)){
	$sttus = ($data['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
    $no++;
	echo "<tr>
		<input type=hidden name=dosen_ID value='$data[dosen_ID]'>
		<td>$no</td>               
		<td align=center><a href=get-masterdosen-CariModulDosen-$data[NIDN].html><img src=../img/modul.png></a></td>
		<td>$data[NIDN]</td>
		<td>$data[nama_lengkap]</td>
		<td>$data[Gelar]</td>
		<td>$data[jurusan_ID]</td>
		<td>$data[Telepon]</td>
		<td>$sttus</td>
		<td width='10%'> 
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini' href='get-masterdosen-DetailDsn-$data[dosen_ID].html'>Detail</a>
			<a class='btn btn-mini btn-inverse' href='get-masterdosen-editmstDosen-$data[dosen_ID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-masterdosen-delmstdsn-$data[dosen_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Dosen $data[nama_lengkap] ?')\">Hapus</a>
			</div>
		</center>
		</td>
	</tr>";                 
	}
echo "</tbody></table>";
}
function CariModulDosen(){
buka("Manajemen Modul Dosen");
echo"<div class='row'><p class='pull-right'><a class='btn btn-mini btn-danger' href='go-masterdosen.html'>Kembali</a></p></div>
<div class='row'>";
echo"<div class='span5'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Data Dosen</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>";
	$sql="SELECT * FROM dosen WHERE NIDN='$_GET[id]'";
	$qry= _query($sql)or die ();
	while ($data=_fetch_array($qry)){
	$sttus = ($data['Aktif'] == 'Y')? '<span class="label label-success">Aktif</span>' : '<span class="label label-important">Tidak Aktif</span>';
	$no++;
	$jabatn=$data[Jabatan_ID];
	$jabatan=NamaJabatan($jabatn);
echo"<thead>
		<tr><th>Nama Lengkap</th><th>$data[nama_lengkap]</th></tr>
		<tr><th>Jabatan</th><th>$jabatan</th></tr>
		<tr><th>Telepon</th><th>$data[Telepon]</th></tr>
		<tr><th>Status</th><th>$sttus</th></tr>
	</thead>";
 }
echo"</table></div></div></div>";
echo"</div>";
echo"<div class='row'>";
echo"<div class='span3'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> GROUP</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<thead><tr><th>Group</th><th>Pilih</th></tr></thead>";
	$sql="SELECT * FROM modul WHERE parent_id='0' ORDER BY id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$jabatn' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$cek = ($cocok==1) ? 'checked' : '';    
	echo "<input type=hidden name=jabatan value=$jabatn>
		<td>$data[judul]</td>           
		<td><input name=CekModul[] type=checkbox value=$data[id] $cek></td></tr>";
	}
echo"</table></div></div></div>";
echo"<div class='span8 pull-right'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Modul</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
<thead><tr><th>Modul</th><th>Modul</th><th>Pilih</th></tr></thead>";
$sql="SELECT * FROM modul WHERE parent_id!='0' ORDER BY parent_id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$jabatn' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$cek = ($cocok==1) ? 'checked' : ''; 
	$namaGrup=NamaGroupMdl($data[parent_id ]);
	echo "<input type=hidden name=jabatan value=$jabatn>
		<td>$namaGrup</td>              
		<td>$data[judul]</td>
		<td><input name=CekModul[] type=checkbox value=$data[id] $cek></td>
	</tr>";
	}
echo"<tr><td colspan=4><center><input class='btn btn-success' type=submit name=submit value=Simpan></center></form></td></tr></table></div></div></div>";

echo"</div>";
tutup();
}

function tambahmstDosen(){
global $today,$BulanIni,$TahunIni;
buka("Tambah Dosen");
	echo"<form method=post action='aksi-masterdosen-addDosn.html'>
	<table class='table table-bordered table-striped'><thead>
	<tr><td class=cc>NIDN</td>    <td>
	<input type=text name=NIDN placeholder='Nomor Induk Dosen Nasional'></td></tr>
	<tr><td class=cc>Password</td>    <td>    <input type=text name=password></td></tr>
	
	<tr><td class=cc>Nama Dosen</td>
	<td><input type=text name=nama_lengkap size=30></td></tr>
	<tr><td class=cc>Gelar</td>
	<td><input type=text name=Gelar></td></tr>
	<tr><td class=cc>Tempat lahir</td>
	<td><input type=text name=TempatLahir size=30></td></tr>
	<tr><td class=cc>Tanggal lahir</td>
	<td><div class='row-fluid'>";
	
	combotgl(1,31,'tgllahir',$today);
	combonamabln(1,12,'blnlahir',$BulanIni);
	combothn($TahunIni-100,$TahunIni+1,'thnlahir',$TahunIni);  
	echo "</div></td></tr></td></tr>
	<tr><td class=cc>Agama</td>    <td>       
	<select name='Agama'>
	<option value=0 selected>- Pilih Agama -</option>";
	$t=_query("SELECT * FROM agama ORDER BY agama_ID");
	while($w=_fetch_array($t)){
	echo "<option value=$w[agama_ID]> $w[nama]</option>";
	}                                
	echo "</select></td></tr>
	<tr><td class=cc>Telepon</td>    <td>   <input type=text name=Telepon></td></tr> 
	<tr><td class=cc>Ponsel</td>    <td>      <input type=text name=Handphone></td></tr>
	<tr><td class=cc>E-Mail</td>    <td>      <input type=text name=Email></td></tr>
	<tr><td class=cc>Institusi</td>    <td><div class='row-fluid'>
	<select name='identitas' class='span8'>
	<option value=0 selected>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
	while($w=_fetch_array($t)){
	echo "<option value=$w[Identitas_ID]> $w[Nama_Identitas]</option>";
                                }                                
	echo "</div></select></td></tr>
	<tr><td>Jabatan</td> <td>
		<select name='Jbtn'>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Nama");
			while($j=_fetch_array($jbtn)){
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
		}
	echo "</select>
	</td></tr>
	<tr><td class=cc>Program Studi</td>    <td>";
	$tampil=_query("SELECT * FROM jurusan ORDER BY jurusan_ID");
	while($r=_fetch_array($tampil)){
	echo "<input type=checkbox name=Jurusan_ID[] value=$r[kode_jurusan]>  $r[nama_jurusan]<br>";
	}
	echo "</td></tr>
	<tr><td class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y> Y
	<input type=radio name=Aktif value=N> N </td></tr>
	<tr><td colspan=2>
		<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-mini btn-danger' href='go-masterdosen.html'>Batal</a>
			</div>
		</center>
	</td></tr>
	</thead></table></form>";
tutup();	
}
function editmstDosen(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Master Dosen");
	$e=_query("SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'");
	$r=_fetch_array($e);
	$MaxFileSize = 50000;
	if (empty($r['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[foto]"; }
	echo"<form method=post enctype='multipart/form-data' action='aksi-masterdosen-uploadfotoDosen.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=3>INFORMASI DOSEN</th></tr>                               
		<tr><td>NIDN</td><td><strong> $r[NIDN]</strong></td>
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
		</thead></table></form>
		<ul class='nav nav-tabs'>
			<li class='active'><a href='#Pribadi' data-toggle='tab'>Data Pribadi</a></li>
			<li><a href='#Alamat' data-toggle='tab'>Alamat</a></li>
			<li><a href='#Akademik' data-toggle='tab'>Akademik</a></li>
			<li><a href='#Pendidikan' data-toggle='tab'>Pendidikan</a></li>
			<li><a href='#Pekerjaan' data-toggle='tab'>Pekerjaan</a></li>
			<li><a href='#Penelitian' data-toggle='tab'>Penelitian</a></li>
		</ul>
		<div class='tab-content'>";		
	echo"<div class='tab-pane active' id='Pribadi'>
	<form method=post action='aksi-masterdosen-updsn.html'>
		<input type=hidden name=id value='$r[dosen_ID]'>
		 <input type=hidden name=username value='$r[username]'>		
				<table class='table table-striped'><thead>
				<tr><td colspan=2><h4>Bio Data Dosen</h4></td></tr>
				<tr><td class=cc width='30%'>Username</td>
				<td class=cb>    <input type=text value='$r[username]' disabled></td></tr>
				<tr><td class=cc>Password</td>
				<td class=cb><input type=password name=password placeholder='Kosongkan jika tidak diubah'> </td></tr>
				<tr><td class=cc>NIDN</td>
				<td class=cb><input type=text name=NIDN value='$r[NIDN]'></td></tr>
				<tr><td class=cc>Nama Dosen</td>    <td class=cb><input type=text name='nama_lengkap' size=30 value='$r[nama_lengkap]'></td></tr>
				<tr><td class=cc>Gelar</td>    <td class=cb>      <input type=text name=Gelar value='$r[Gelar]'></td></tr>
				<tr><td class=cc>Tempat lahir</td><td class=cb> <input type=text name=TempatLahir size=30  value='$r[TempatLahir]'> </td></tr>
				<tr><td class=cc>Tanggal lahir</td>   
				<td class=cb><div class='row-fluid'>";  
		$get_tgl2=substr("$r[TanggalLahir]",8,2);
		combotgl(1,31,'tgllahir',$get_tgl2);
        $get_bln2=substr("$r[TanggalLahir]",5,2);
        combonamabln(1,12,'blnlahir',$get_bln2);
        $get_thn2=substr("$r[TanggalLahir]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thnlahir',$get_thn2); 
			echo "</div></td></tr></td></tr>
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
	<tr><td class=cc>Mulai Bekerja</td>    <td class=cb><div class='row-fluid'>"; 
		$get_tgl2=substr("$r[TglBekerja]",8,2);
		combotgl(1,31,'TglBekerja',$get_tgl2);
        $get_bln2=substr("$r[TglBekerja]",5,2);
        combonamabln(1,12,'BlnBekerja',$get_bln2);
        $get_thn2=substr("$r[TglBekerja]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'ThnBekerja',$get_thn2);                           
echo "</div></td></tr>
	<tr><td>Jabatan Akademik</td> <td>
		<select name='Jbtn'>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Nama");
			while($j=_fetch_array($jbtn)){
			if($j[Jabatan_ID]==$r[Jabatan_ID]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
			}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
			}
		}
	echo "</select>
	</td></tr>
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
	<tr><td class=cc>Prodi Homebase</td>
	<td class=cb><input type=text size=10 name='Homebase' value='$r[Homebase]'></td></tr>
	
	<tr><td class=cc>Kode Instansi Induk</td>
	<td class=cb><input type=text name='InstitusiInduk' value='$r[InstitusiInduk]'></td></tr>
	
	<tr><td class=cc>SK Pengangkatan</td>
	<td class=cb><input type=text name='Skpengankatan' value='$r[Skpengankatan]'></td></tr>
	
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
echo"</form>";						
//------------
echo"<div class='tab-pane' id='Pendidikan'>";
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
	<td><a class='thickbox' href='get-masterdosen-editpddkDosn-$ra[DosenPendidikanID].html'><img src=../img/edit.png></a> -
	<a href='get-masterdosen-delpddDosn-$ra[DosenPendidikanID].html'
	onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Gelar $ra[Gelar] ?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
}
echo "</table>                           
	<form method=post action='aksi-masterdosen-addpddDosn.html'>
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
	<td class=cb><div class='row-fluid'>"; 
		combotgl(1,31,'TglIjazah',$today);
		combonamabln(1,12,'BlnIjazah',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'ThnIjazah',$TahunIni);
echo "</div></td></tr>
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
	<a class='thickbox' href='get-masterdosen-editpkjDosn-$ra[DosenPekerjaanID].html'><img src=../img/edit.png></a> |                                 
	<a href='get-masterdosen-delpkjDosn-$ra[DosenPekerjaanID].html'
	onClick=\"return confirm('Anda yakin akan menghapus Pekerjaan $ra[Jabatan] $ra[nama_lengkap]?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
	}
echo "<tfoot><tr><td colspan='9'></td></tr></tfoot></table>
	<form method=post action='aksi-masterdosen-addpkjDosn.html'>
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
	<a class='thickbox' href='get-masterdosen-editpnlthanDosn-$pe[DosenPenelitianID].html'><img src=../img/edit.png></a> |                                 
	<a href='get-masterdosen-delpnlthanDosn-$pe[DosenPenelitianID].html'
	onClick=\"return confirm('Anda yakin akan menghapus Penelitian $pe[NamaPenelitian] ?')\"><img src=../img/del.jpg></a>
	</td></tr>";
	$no++;
	}
echo "<tfoot><tr><td colspan='9'></td></tr></tfoot></table>
	<form method=post action='aksi-masterdosen-addpnlthanDosn.html'>
	<input type=hidden name=id value='$r[dosen_ID]'>
	<table class='table table-striped'><thead>
	<tr><td colspan=2><h4>Tambah Penelitian </h4></td></tr>
	<input type=hidden name=dosen_ID value='$r[dosen_ID]'>
	<tr><td class=cc>Nama Penelitian</td>
	<td class=cb><input type=text name=NamaPenelitian></td></tr>
	<tr><td class=cc>Tanggal</td>
	<td class=cb><div class='row-fluid'>";
		combotgl(1,31,'TglBuat',$today);
		combonamabln(1,12,'BlnBuat',$BulanIni);
		combothn($TahunIni-100,$TahunIni+10,'ThnBuat',$TahunIni); 
echo "</div></td></tr>
	
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Simpan'></center></td></tr>
	</table></form>";             
echo"</div></div>";
tutup();
}
function editpddkDosn(){
buka("Edit Pendidikan Dosen");
$pddosen=_query("SELECT * FROM dosenpendidikan WHERE DosenPendidikanID='$_GET[id]'");
$pd=_fetch_array($pddosen);
echo "<form method=post action='aksi-masterdosen-uppddDosn.html'>
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
	<td class=cb><div class='row-fluid'>";     
		$get_tgl2=substr("$pd[TanggalIjazah]",8,2);
		combotgl(1,31,'tgl_Ijazah',$get_tgl2);
        $get_bln2=substr("$pd[TanggalIjazah]",5,2);
        combonamabln(1,12,'bln_Ijazah',$get_bln2);
        $get_thn2=substr("$pd[TanggalIjazah]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_Ijazah',$get_thn2); 
echo "</div></td></tr>
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
echo "<form method=post action='aksi-masterdosen-uppnlthanDosn.html'>
	<table class='table table-striped'><thead>
	<input type=hidden name=DosenID value='$p[DosenID]'>
	<input type=hidden name=DosenPenelitianID value='$p[DosenPenelitianID]'>
	<tr><td class=cc>Nama Penelitian</td>
	<td class=cb><input type=text name=NamaPenelitian value='$p[NamaPenelitian]'></td></tr>
	<tr><td class=cc>Tanggal</td>
	<td class=cb><div class='row-fluid'>"; 
		$get_tgl2=substr("$r[TglBuat]",8,2);
		combotgl(1,31,'tgl_Buat',$get_tgl2);
        $get_bln2=substr("$r[TglBuat]",5,2);
        combonamabln(1,12,'bln_Buat',$get_bln2);
        $get_thn2=substr("$r[TglBuat]",0,4);
        combothn($TahunIni-100,$TahunIni+2,'thn_Buat',$get_thn2); 
echo "</div></td></tr>
	
	<tr><td colspan=2><center><input class='btn btn-success btn-large' type=submit value='Update'></center></td></tr>
	</table></form>"; 
tutup();
}
function editpkjDosn(){
$pkdosen=_query("SELECT * FROM dosenpekerjaan WHERE DosenPekerjaanID='$_GET[id]'");
$d=_fetch_array($pkdosen);
buka("Edit Pekerjaan Dosen");
echo "<form method=post action='aksi-masterdosen-updpkjDosn.html'>
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
	<a class='btn btn-danger' href='get-masterdosen-editmstDosen-$d[DosenID].html'>Batal</a>
	</center>
	</td></tr>
	</thead></table></form>"; 
tutup();	
}
function DetailDsn(){
buka("Detail Informasi Dosen");
	$sql="SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
	if (empty($r['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[foto]"; }
	$NamaProdi=NamaProdi($r['jurusan_ID']);
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$StatusDosen=StatusDosen($r['StatusKerja_ID']);
	$Jabatan=NamaJabatan($r['Jabatan_ID']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$TglGabung=Tgl_indo($r['TglBekerja']);
	if ($r[Kelamin]=='L'){
	$gender="Laki - Laki";
	}else{
	$gender="Perempuan";
	}	
	echo"<table class='table table-striped'><thead>
	<tr><th colspan=4> DETAIL DOSEN <div class='btn-group pull-right'>
	<a class='btn btn-mini btn-danger' href='go-masterdosen.html'><i class='icon-undo'></i>Kembali</a>
	<a class='btn btn-mini btn-inverse' href='cetak-CetakProfileDosen-$r[dosen_ID].html' target='_blank'><i class='icon-print'></i>Cetak</a>
	</div></th></tr>                               
	<tr>
	<td>NAMA LENGKAP</td>
	<td>:</td>
	<td><strong> $r[nama_lengkap] ,$r[Gelar]</strong></td>
	<td rowspan=3><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
	<tr>
	<td>NIDN</td>
	<td>:</td>
	<td><strong>$r[NIDN] </strong></td>
	</tr>
	<tr><td>PROGRAM STUDI </td><td>:</td><td><strong> $NamaProdi</strong></td></tr>
	<tr><td></td><td></td><td></td><td></td></tr>
	
	</thead></table>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='panel-content'>
				<table class='table'>
					<thead>
						<tr><th colspan='2'><center>DATA PRIBADI</center></th></tr>
					</thead>
					<tbody>
                            <tr>
							<td width='30%'><i class='icon-file'></i> Tempat & Tanggal Lahir</td>
							<td> : &nbsp;&nbsp;&nbsp; $r[TempatLahir], $TglLhr</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Agama</td>
							<td> : &nbsp;&nbsp;&nbsp;$Agama</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Alamat </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Alamat] . $r[Kota] ($r[Propinsi]-$r[Negara])</td> 	
							</tr>
							<tr>
							<td><i class='icon-file'></i> Tlp / Hp </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Telepon] / $r[Handphone]</td>
							</tr>
							<tr><td colspan='2'><center><b>AKADEMIK</b></center></td></tr>
							<tr>
							<td><i class='icon-file'></i> Tanggal Bergabung</td>
							<td> : &nbsp;&nbsp;&nbsp;$TglGabung</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Jabatan</td>
							<td> : &nbsp;&nbsp;&nbsp;$Jabatan</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Prodi Homebase</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Homebase]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Status Dosen</td>
							<td> : &nbsp;&nbsp;&nbsp;$StatusDosen</td>
							</tr>
							<tr><td colspan='2'><center><b>RIWAYAT PENDIDIKAN DOSEN </b></center></td></tr>
							"; 
	$tampil=_query("SELECT * FROM dosenpendidikan WHERE DosenID='$r[dosen_ID]' ORDER BY DosenPendidikanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){
	$tgl=tgl_indo($ra[TanggalIjazah]);                        
	$jenjang=get_jenjang($ra[JenjangID]);                        
	$Perting=get_Pt($ra[PerguruanTinggiID]);                        
echo "<tr>
		<td>$no :: Jenjang : $jenjang&nbsp;&nbsp; Gelar : $ra[Gelar]</td>
		<td> : &nbsp;&nbsp;&nbsp; Lulus : $tgl - Bidang Studi : $ra[BidangIlmu] - Di : $ra[NamaNegara]</td>
	</tr>";
	$no++;
}
echo "<tr><td colspan='2'><center><b>RIWAYAT PEKERJAAN DOSEN </b></center></td></tr>
"; 
	$tampil=_query("SELECT * FROM dosenpekerjaan WHERE DosenID='$r[dosen_ID]' ORDER BY DosenPekerjaanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){                        
echo "<tr>
		<td>$no :: $ra[Jabatan]&nbsp;&nbsp; di : $ra[Institusi]</td>
		<td> : &nbsp;&nbsp;&nbsp; Alamat : $ra[Alamat] - $ra[Kota]. $ra[Kodepos] Telp : $ra[Telepon] Fax : $ra[Fax]</td>
	</tr>";
	$no++;
}	
echo "<tr><td colspan='2'><center><b>DATA PENELITIAN DOSEN </b></center></td></tr>";
$tampil=_query("SELECT * FROM dosenpenelitian WHERE DosenID='$_GET[id]' ORDER BY DosenPenelitianID");
	$no=1;
	while ($pe=_fetch_array($tampil)){
	$tglBuat=tgl_indo($pe[TglBuat]); 
echo "<tr>
		<td>$no :: $pe[NamaPenelitian]</td>
		<td> : &nbsp;&nbsp;&nbsp; Tanggal :$tglBuat</td>
	</tr>";	
	$no++;
	}
echo "</tbody></table>
			</div>
		</div>
	</div>";
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
PesanOk("Upload Foto Dosen","Upload Foto Berhasil","get-masterdosen-editmstDosen-$DosenId.html");	
  } else { 
PesanEror("Upload Foto Dosen", "Gagal Upload Foto.. !! Tidak dapat meng-upload file foto.<br />
    Periksa file yg di-upload,  karena besar file dibatasi cuma: <b>$_POST[MAX_FILE_SIZE]</b> byte.");  
	}
}
switch($_GET[PHPIdSession]){

  default:
    defaultmstDosen();
  break;  

  case "tambahmstDosen":
    tambahmstDosen();
  break;
  
  case "uploadfotoDosen":
    aplodFotoDosen();
  break;  

  case "carimstDosen":
    carimstDosen();
  break;

   case "CariModulDosen":
    CariModulDosen();
  break;  
  
  case "DetailDsn":
    DetailDsn();
  break; 
  
  case"addDosn":
  $TanggalLahir=sprintf("%02d%02d%02d",$_POST[thnlahir],$_POST[blnlahir],$_POST[tgllahir]);
	if (!empty($_POST[Jurusan_ID])){
	$jur = $_POST[Jurusan_ID];
	$tag=implode(',',$jur);
	}
	$cek=_num_rows(_query("SELECT * FROM dosen WHERE NIDN='$_POST[NIDN]'"));
        if ($cek > 0){
	PesanEror("Tambah Dosen", "Opps.. !! Data NIDN Sudah ada dalam database.");
        } else {
    $pass=md5($_POST[password]);
    _query("INSERT INTO dosen(username,password,
          NIDN,
          nama_lengkap,
          TempatLahir,
          TanggalLahir,
          Agama,
          Email,
          Telepon,
          Handphone,
          Identitas_ID,
          Jurusan_ID,      
          Jabatan_ID,      
          Gelar,         
          Aktif)
          VALUES('$_POST[NIDN]','$pass',
          '$_POST[NIDN]',
          '$_POST[nama_lengkap]',
          '$_POST[TempatLahir]',
          '$TanggalLahir',
          '$_POST[Agama]',       
          '$_POST[Email]',
          '$_POST[Telepon]',
          '$_POST[Handphone]',
          '$_POST[identitas]',
          '$tag',
          '$_POST[Jbtn]',
          '$_POST[Gelar]',
          '$_POST[Aktif]')");
		  
	$UserYapan ="INSERT INTO useryapan(username,password,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,email,aktif,Log,SessionID)VALUES
	('$_POST[NIDN]','$pass','2','$_POST[nama_lengkap]','$_POST[identitas]','$tag','dosen','$_POST[Jbtn]','$_POST[Email]','Y','','')";
	$InsertUserYapan=_query($UserYapan);	
//input Modul User
	$modulDosen			= array(4,137,136);
	foreach($modulDosen as $vald => $mdl)
	{
	$sql= "INSERT INTO hakmodul(id_level,id) VALUES ('$_POST[Jbtn]','$mdl')";
	$masukMdl=_query($sql) or die ("SQL Input Modul Gagal"._error());
	}
	PesanOk("Tambah Dosen","Dosen Baru Berhasil Disimpan","go-masterdosen.html");	
	
          }
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
          Jabatan_ID = '$_POST[Jbtn]',      
          Gelar = '$_POST[Gelar]',
          Jenjang_ID = '$_POST[Jenjang_ID]',
          Keilmuan = '$_POST[Keilmuan]',
          Kelamin_ID = '$_POST[Kelamin_ID]',
          JabatanDikti_ID = '$_POST[JabatanDikti_ID]',
          InstitusiInduk = '$_POST[InstitusiInduk]',
          TglBekerja= '$TglBekerja',
          StatusDosen_ID = '$_POST[StatusDosen_ID]',
          StatusKerja_ID = '$_POST[StatusKerja_ID]',
          Skpengankatan = '$_POST[Skpengankatan]',
          Aktif = '$_POST[Aktif]'
          WHERE dosen_ID   = '$_POST[id]'");
		  
    $upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',
				email       	= '$_POST[email]',
				Jabatan       	= '$_POST[Jbtn]',
				aktif       	= '$_POST[Aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");
				
	PesanOk("Update Data Dosen","Data Dosen Berhasil Update","get-masterdosen-editmstDosen-$_POST[id].html");	
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
			Jabatan_ID = '$_POST[Jbtn]',  
          Gelar = '$_POST[Gelar]',
          Jenjang_ID = '$_POST[Jenjang_ID]',
          Keilmuan = '$_POST[Keilmuan]',
          Kelamin_ID = '$_POST[Kelamin_ID]',
          JabatanDikti_ID = '$_POST[JabatanDikti_ID]',
          InstitusiInduk = '$_POST[InstitusiInduk]',
          TglBekerja= '$_POST[InstitusiInduk]',
          StatusDosen_ID = '$_POST[StatusDosen_ID]',
          StatusKerja_ID = '$_POST[StatusKerja_ID]',
          Skpengankatan = '$_POST[Skpengankatan]',
          Aktif = '$_POST[Aktif]'
          WHERE dosen_ID   = '$_POST[id]'");
		  
	$upUseryapan=_query("UPDATE useryapan SET Nama = '$_POST[nama_lengkap]',
				password    	= '$password',
				email       	= '$_POST[email]',
				Jabatan       	= '$_POST[Jbtn]',
				aktif       	= '$_POST[aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");
				
	PesanOk("Update Data Dosen","Data Dosen Berhasil Update","get-masterdosen-editmstDosen-$_POST[id].html");
}
  break;

  case "InputModulDosen":
        $id_level =$_REQUEST['id_level'];
        $CekModul =$_REQUEST['CekModul'];
		$jum=count($CekModul);

          $sqlpil= "SELECT * FROM hakmodul WHERE id_level='$id_level'";
          $qrypil= _query($sqlpil);
          while ($datapil=_fetch_array($qrypil)){
          for($i=0; $i < $jum; ++$i){
          if ($datapil['id'] !=$CekModul[$i]){
          $sqldel= "DELETE FROM hakmodul WHERE id_level='$id_level' AND NOT id IN ('$CekModul[$i]')";   
          _query($sqldel);

          }
          }
          }
        for($i=0; $i < $jum; ++$i){
          $sqlr="SELECT * FROM hakmodul WHERE id_level='$id_level'AND id='$CekModul[$i]'";
        	$qryr= _query($sqlr);
        	$cocok= _num_rows($qryr);
        	if (! $cocok==1){
        	$sql= "INSERT INTO hakmodul(id_level,id)";
        	$sql .="VALUES ('$id_level','$CekModul[$i]')";
          _query($sql)
          or die ();
          }
          }
	PesanOk("Update Modul Dosen","Modul Dosen Berhasil Update","go-masterdosen.html");
      
  break;

  case "editmstDosen":
    editmstDosen();
  break;

  case "delmstdsn":
  $cek=_fetch_array(_query("SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'"));
	$tabel1="dosenpekerjaan";
	$kondisi1="DosenID='$_GET[id]'";
	delete($tabel1,$kondisi1);
	
	$tabel2="dosenpendidikan";
	$kondisi2="DosenID='$_GET[id]'";
	delete($tabel2,$kondisi2);
	
	$tabel3="dosenpenelitian";
	$kondisi3="DosenID='$_GET[id]'";
	delete($tabel3,$kondisi3);
	if ($cek['foto']!=''){
    $tabel="dosen";
	$kondisi="dosen_ID='$_GET[id]'";
	delete($tabel,$kondisi);
	unlink("$cek[foto]");
	
	$tabel1="useryapan";
	$kondisi1="username='$cek[username]'";
	delete($tabel1,$kondisi1);
	}else{
	$tabel="dosen";
	$kondisi="dosen_ID='$_GET[id]'";
	delete($tabel,$kondisi);
	
	$tabel1="useryapan";
	$kondisi1="username='$cek[username]'";
	delete($tabel1,$kondisi1);
	} 
	PesanOk("Hapus Dosen","Data Dosen Berhasil DiHapus","go-masterdosen.html"); 
  break;
//Tambah Penelitian Dosen  
case "addpnlthanDosn":
	$Tgldibuat=sprintf("%02d%02d%02d",$_POST[ThnBuat],$_POST[BlnBuat],$_POST[TglBuat]);
	$nama_tabel="dosenpenelitian";
	$values="'','$_POST[NamaPenelitian]','$_POST[dosen_ID]','$Tgldibuat'";
	insert($nama_tabel,$values);
	PesanOk("Tambah Penelitian Dosen","Data Penelitian Dosen Berhasil Disimpan","get-masterdosen-editmstDosen-$_POST[DosenID].html"); 

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
	PesanOk("Tambah Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Disimpan","get-masterdosen-editmstDosen-$_POST[dosen_ID].html"); 

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
	PesanOk("Tambah Pendidikan Dosen","Data Pendidikan Dosen Berhasil Disimpan","get-masterdosen-editmstDosen-$_POST[DosenID].html"); 

break;

case "editpkjDosn":
editpkjDosn();
break;

case "delpkjDosn":
	$nama_tabel="dosenpekerjaan";
	$kondisi="DosenPekerjaanID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Di Hapus","go-masterdosen.html"); 
break;

case "delpnlthanDosn":
	$nama_tabel="dosenpenelitian";
	$kondisi="DosenPenelitianID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Penelitian Dosen","Data Penelitian Dosen Berhasil Di Hapus","go-masterdosen.html"); 

break;

case "delpddDosn":
	$nama_tabel="dosenpendidikan";
	$kondisi="DosenPendidikanID='$_GET[id]'";
	delete($nama_tabel,$kondisi);
	PesanOk("Hapus Pendidikan Dosen","Data Pendidikan Dosen Berhasil Di Hapus","go-masterdosen.html"); 

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
	PesanOk("Update Pendidikan Dosen","Data Pendidikan Dosen Berhasil Di Update","get-masterdosen-editmstDosen-$_POST[DosenID].html"); 

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
	PesanOk("Update Pekerjaan Dosen","Data Pekerjaan Dosen Berhasil Di Update","get-masterdosen-editmstDosen-$_POST[DosenID].html"); 

break;


case "uppnlthanDosn":
	$Tgldibuat=sprintf("%02d%02d%02d",$_POST[thn_Buat],$_POST[bln_Buat],$_POST[tgl_Buat]);
	$nama_tabel="dosenpenelitian";
	$values="NamaPenelitian ='$_POST[NamaPenelitian]', 
			DosenID='$_POST[DosenID]', 
			TglBuat ='$Tgldibuat'";
	$kondisi="DosenPenelitianID ='$_POST[DosenPenelitianID]'";
	update($nama_tabel,$values,$kondisi);
	PesanOk("Update Penelitian Dosen","Data Penelitian Dosen Berhasil Di Update","get-masterdosen-editmstDosen-$_POST[DosenID].html"); 
break;
}
?>
