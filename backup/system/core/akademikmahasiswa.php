<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php  
function Defakademikmahasiswa(){
global $buat,$baca,$tulis,$hapus;
$kode=($_SESSION[Jabatan]==18)? $_SESSION[prodi]: $_REQUEST[codd];
$disab=($_SESSION[Jabatan]==18)? "disabled": "";
if($buat){
$linkTambah="<a class='btn btn-mini btn-inverse' href='aksi-akademikmahasiswa-MahasiswaBaru.html'>Mahasiswa Baru</a>";
}
if($baca){
buka("Data Mahasiswa","$linkTambah");
echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='input-prepend input-append pull-left'>
						<span class='add-on'>Program Studi</span>
						<select name='jurusan' onChange=\"MM_jumpMenu('parent',this,0)\" $disab>
						<option value='go-akademikmahasiswa.html'>- Pilih Jurusan -</option>";
						$sqlp="select * from jurusan ORDER BY Identitas_ID";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['kode_jurusan']==$kode){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='in-akademikmahasiswa-$d[kode_jurusan].html' $cek> $d[nama_jurusan]</option>";
						}
						echo"</select> <input name='TxtKodeH' type='hidden' value='$kode'>
					</div>
					<div class='pull-right'>
					<div class=btn-group>";
if($buat){
echo"<a class='btn btn-success' href='go-akademikimportMhsw.html'>Import</a>";
echo"<a class='btn' href='eksport-dataMhsw-$kode.html'>Export</a>";
echo"<a class='btn btn-primary' href='aksi-akademikmahasiswa-CalonMahasiswa.html'>Calon Mahasiswa</a>";
}
echo"</div>
					</div>
				</th>
			</tr>
			<tr><th></th></tr>
		</thead>
	</table></div>";

echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
	<tr><th>NO</th><th>NIM</th><th>NAMA</th><th>PRODI</th><th>KELAS</th><th>STATUS </th><th>ANGKTAN</th><th>Aksi</th></tr></thead>";
	$sql="SELECT * FROM mahasiswa WHERE kode_jurusan='$kode' AND NIM!='' AND LulusUjian='N' ORDER BY NIM";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){  
	$sttus = ($r['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$jurusan=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$kelas=GetName("program","ID",$r[IDProg],"nama_program");
	$angkatan=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
	$AngkatThn = substr($angkatan, 15, 9); 
	$no++;
	echo "<tr>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>$jurusan</td>
		<td>$kelas</td>
		<td><center>$sttus</center></td>
		<td>$AngkatThn</td>
		<td>
		<center>
			<div class='btn-group'>";
if($tulis){
echo"<a class='btn btn-mini btn-inverse' href='mhsw-akademikmahasiswa-chagmstmhs-$r[NoReg]-$r[kode_jurusan].html'>Edit</a>";
}
if($hapus){
echo"<a class='btn btn-mini btn-danger' href='mhsw-akademikmahasiswa-delmstmhsw-$r[NoReg]-$r[kode_jurusan].html' onClick=\"return confirm('Apakah Anda benar-benar akan menghapus $r[NIM] - $r[Nama]?')\">Hapus</a>";
}
echo"</div></center></td></tr>";        
		}
	$jmldata = _num_rows($qry);
	echo "<tfoot><tr><td colspan='10'>
	Total Keseluruhan  <span class='badge badge-inverse'>$jmldata</span> Mahasiswa
	</td></tr></tfoot>";
	echo"</table>";
}else{
ErrorAkses();
}
tutup();
}
function MahasiswaBaru(){
global $buat,$today,$BulanIni,$TahunIni;
if($buat){
$noReg=NoRegister();
$id= $_REQUEST['codd'];
$jur= $_REQUEST['kode'];
$idp= $_REQUEST['id'];  
$kur= $_REQUEST['kur'];
buka("Mahasiswa Baru");
echo "<div class='row-fluid'><div class='panel-content panel-tables'>
	<form action='aksi-humasMhsw-addmhsw.html' method='post' class='form-horizontal'>
	<input name='NoReg' type='hidden' value='$noReg'>
	<legend>Mahasiswa Baru <small>(Yang bertanda * Harus diisi.  ID PENDATARAN : $noReg )</small><p class='pull-right'><a class='btn btn-danger' href='go-akademikmahasiswa.html'><i class='icon-undo'></i> Kembali</a></p></legend>
	<table class='table table-striped'><thead>
	<tr>
		<td width='15%'>Institusi *</td><td><select name='cmi1' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
			<option value='aksi-humasMhsw-TambahMhs.html'>-  Pilih Institusi -</option>";
			$sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
				if ($d1['Identitas_ID']==$id){$cek="selected";}else{ $cek="";} 
			echo "<option value='dis-humasMhsw-TambahMhs-$d1[Identitas_ID].html' $cek>  $d1[Nama_Identitas]</option>";
				}
			echo"</select><input name='cmi1' type='hidden' value='$id'></td>
		<td width='15%'>Program Studi *</td><td><select name='cmbj1' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
			<option value='go-akademiktahun.html'>- Pilih Prodi -</option>";
			$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$id'";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
				if ($d1['kode_jurusan']==$jur){$cek="selected";}else{ $cek="";} 
			echo "<option value='di-humasMhsw-TambahMhs-$id-$d1[kode_jurusan].html' $cek> $d1[nama_jurusan]</option>";
				}
			echo"</select><input name='cmbj1' type='hidden' value='$jur'></td>
	</tr>
	<tr>
		<td>Kelas *</td><td><select name='cmbp1' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
			<option value='aksi-humasMhsw&-TambahMhs.html'>-  Pilih Kelas -</option>";
			$sqlp="SELECT * FROM program WHERE Identitas_ID='$id' ORDER BY ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
				if ($d['ID']==$idp){$cek="selected";}else{ $cek="";} 
			echo "<option value='dir-humasMhsw-TambahMhs-$id-$jur-$d[ID].html' $cek>$d[nama_program]</option>";
				}
			echo"</select><input name='cmbp1' type='hidden' value='$idp'></td>
		<td>Konsentrasi *</td><td><select name='nkur' class='span12'>
			<option value=0 selected>- Pilih Nama Konsentrasi -</option>";
			$t=_query("SELECT * FROM kurikulum WHERE Identitas_ID='$id' AND Jurusan_ID='$jur' ORDER BY Kurikulum_ID");
			while($r=_fetch_array($t)){
			echo "<option value=$r[Kurikulum_ID]> $r[Nama]</option>";
			}
			echo "</select></td>
	</tr>
	<tr>
		<td>Nama Lengkap *</td>
		<td><input type=text name=Nama class='span12'></td>
		<td>Tahun Ajaran *</td>
		<td><select name='Angkatan' class='span12'>
			<option value=0 selected>- Pilih Tahun Ajaran -</option>";
			$t=_query("SELECT * FROM tahun WHERE Identitas_ID='$id' ORDER BY Tahun_ID DESC");
			while($r=_fetch_array($t)){
			echo "<option value=$r[Tahun_ID]> $r[Nama]</option>";
			}
			echo "</select></td>
	</tr>
	<tr>
		<td>Rekanan *</td>
		<td><select name='rekanan' class='span12'>
		<option value=0 selected>- Pilih Rekanan -</option>";
		$t=_query("SELECT * FROM rekanan ORDER BY RekananID");
		while($r=_fetch_array($t)){
		echo "<option value=$r[RekananID]>$r[NamaRekanan]</option>";
			}
echo "</select></td>
		<td>Tempat Lahir</td>
		<td><input type=text name=TempatLahir class='span12'></td>
	</tr>
	<tr>
		<td>Tanggal Lahir</td><td>";
	combotgl(1,31,'tgltl',$today);
	combonamabln(1,12,'blntl',$BulanIni);
	combothn($TahunIni-50,$TahunIni+5,'thntl',$TahunIni);
	echo "</td>";
	echo"<td>Jenis Kelamin</td>
			<td><input type=radio name='Kelamin' value='L' checked> Laki-Laki 
				<input type=radio name='Kelamin' value='P'> Perempuan</td>
	</tr>
	<tr>
		<td>Warga Negara</td>
		<td><input type=radio name='WargaNegara' value='WNA' checked> WNA
		<input type=radio name='WargaNegara' value='WNI'> WNI</td>
		<td>Jika WNA Sebutkan</td>
		<td><input type=text name=Kebangsaan class='span12'></td>
	</tr>
	<tr>
		<td>Agama</td>
		<td><select name='Agama' class='span12'>
		<option value=0 selected>- Pilih Agama -</option>";
		$t=_query("SELECT * FROM agama ORDER BY agama_ID");
		while($r=_fetch_array($t)){
		echo "<option value=$r[agama_ID]> $r[nama]</option>";
		}
	echo "</select></td>
		<td>Status Sipil</td>
		<td><select name='StatusSipil' class='span12'>
			<option value=0 selected>- Pilih Status Sipil -</option>";
			$t=_query("SELECT * FROM statussipil ORDER BY StatusSipil");
			while($r=_fetch_array($t)){
	echo "<option value=$r[StatusSipil]> $r[Nama]</option>";
                  }
          echo "</select></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><input type=text name='Alamat' class='span12'></td>
		<td></td>
		<td><input type=text name='RT' class='span6' placeholder='RT'>
			<input type=text name='RW' class='span6' placeholder='RW'></td>
	</tr>
	<tr>
		<td>Kota</td>
		<td><input type=text name='Kota' class='span12'></td>
		<td>Propinsi</td>
		<td><input type=text name='Propinsi' class='span8' >
			<input type=text name='KodePos' class='span4' placeholder='Kodepos'></td>
	</tr>
	<tr>
		<td>Negara</td>
		<td> <input type=text name='Negara' class='span12'></td>
		<td>Telepon</td>
		<td><input type=text name='Telepon' class='span6'> 
			<input type=text name='Handphone' class='span6' placeholder='HP'></td>	
	</tr>
	<tr>
		<td>Status Awal *</td>
		<td><select name='StatusAwal_ID' class='span12'>
			<option value=0 selected>- Pilih Status Awal Mahasiswa -</option>";
			$t=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
			while($r=_fetch_array($t)){
		echo "<option value=$r[StatusAwal_ID]> $r[Nama]</option>";
			}
		echo "</select></td>
            <td>Penasehat Akademik *</td>
			<td><select name='pa' class='span12'>
                  <option value=0 selected>- Pilih Penasehat Akademik -</option>";
                  $t=_query("SELECT * FROM dosen WHERE Identitas_ID='$id' AND Jurusan_ID LIKE '%$jur%' ORDER BY dosen_ID");
                  while($r=_fetch_array($t)){
                    echo "<option value=$r[NIDN]>$r[nama_lengkap], $r[Gelar]</option>";
                  }
		echo "</select></td>	
	</tr>";
echo"<tr><td colspan='4'><center>
		<div class='btn-group'>
			<button type='submit' class='btn btn-success'>Submit</button>
			<button type='reset' class='btn'>Reset</button>
		</center></div></td></tr></thead></table></form> </div></div>";
	}else{
	ErrorAkses();
	}
tutup();
}
function CalonMahasiswa(){
buka("BAAK :: Data Calon Mahasiswa");
echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='pull-left'>
					Berikut Ini Adalah Data Calon Mahasiswa :
					</div>
					<div class='pull-right'>
					<a class='btn btn-danger' href='go-akademikmahasiswa.html'>Kembali</a>
					</div>
				</th>
			</tr>
			<tr><th></th></tr>
		</thead>
	</table></div>";

echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
	<tr><th>NO</th><th>NO REGISTER</th><th>NAMA</th><th>PRODI</th><th>KELAS</th><th>ANGKTAN</th><th>Aksi</th></tr></thead>";
	$sql="SELECT * FROM mahasiswa WHERE NIM='' ORDER BY NoReg";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){  
	$jurusan=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$kelas=GetName("program","ID",$r[IDProg],"nama_program");
	$angkatan=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
	$AngkatThn = substr($angkatan, 15, 9); 
	$no++;
	echo "<tr>                            
		<td>$no</td>
		<td>$r[NoReg]</td>
		<td>$r[Nama]</td>
		<td>$jurusan</td>
		<td>$kelas</td>
		<td>$AngkatThn</td>
		<td>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='mhsw-akademikmahasiswa-chagmstmhs-$r[NoReg]-$r[kode_jurusan].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='mhsw-akademikmahasiswa-delmstmhsw-$r[NoReg]-$r[kode_jurusan].html' onClick=\"return confirm('Apakah Anda benar-benar akan menghapus Data $r[Nama]?')\">Hapus</a>
			</div>
		</center>
		</td></tr>";        
		}
	$jmldata = _num_rows($qry);
	echo "<tfoot><tr><td colspan='10'>
	Total Calon Mahasiswa  <span class='badge badge-inverse'>$jmldata</span> Mahasiswa
	</td></tr></tfoot>";
	echo"</table>";
tutup();
}

function chagmstmhs(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
buka("Administrator :: Edit Master Mahasiswa");
	$id= $_REQUEST['id'];
	$kode= $_REQUEST['codd'];
	$e=_query("SELECT * FROM mahasiswa WHERE NoReg='$id' AND kode_jurusan='$kode'");
	$r=_fetch_array($e); 
	$MaxFileSize = 500000;
	if (empty($r['Foto'])){
	$foto = "file/no-foto.jpg";
	}else{
	$foto = "$r[Foto]";
	}
	$kelas=GetName("program","ID",$r[IDProg],"nama_program");
	$jurusan=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	echo"<form method=post enctype='multipart/form-data' action='aksi-akademikmahasiswa-uplodFotoMahasiswa.html'>    
		<table class='well table table-striped'><thead>
		<tr><th colspan=2>INFORMASI MAHASISWA</th></tr>                               
		<tr><td>NIM</td><td><strong> $r[NIM]</strong></td>
		<td rowspan=5><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='pull-right'></td></tr>                    
		<tr><td>Nama Lengkap</td><td><strong> $r[Nama]</strong></td></tr>
		<tr><td>Kelas</td><td>$kelas</td></tr>
		<tr><td>Program Studi</td><td>$r[kode_jurusan] - $jurusan</td></tr>
		<tr>
			<input type=hidden name='MAX_FILE_SIZE' value='$MaxFileSize' />
			<input type=hidden name='NIM' value='$r[NIM]' />
			<input type=hidden name='prodi' value='$r[kode_jurusan]' />
		<td><div class='btn-group pull-left'>
			<a class='btn btn-danger' href='in-akademikmahasiswa-$_GET[codd].html'><i class='icon-undo'></i> Kembali</a> 
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
			<li class='active'><a href='#Akademik' data-toggle='tab'>Akademik</a></li>
			<li><a href='#Pribadi' data-toggle='tab'>Data Pribadi</a></li>
			<li><a href='#Alamat' data-toggle='tab'>Alamat</a></li>
			<li><a href='#Ortu' data-toggle='tab'>Orang Tua</a></li>
			<li><a href='#sekolah' data-toggle='tab'>Sekolah Asal</a></li>
		</ul>";	
echo"<form method=post action='aksi-akademikmahasiswa-updmhsw.html'> 
<input type=hidden name=NIM value='$r[NIM]'>
	<div class='tab-content'>
	<div class='tab-pane active' id='Akademik'>";
echo"<table class='table table-striped'><thead>
	<tr><td>Institusi *</td>    <td class=cb>
	<select name='cmi' id=cmi1>
	<option value=0 selected>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY ID");
	while($w=_fetch_array($t)){
	$cek= ($r[identitas_ID]==$w[Identitas_ID])? 'selected': '';
	echo "<option value=$w[Identitas_ID] $cek> $w[Nama_Identitas]</option>";	
	}
	echo "</select></td></tr>
	<tr><td>Program Studi *</td>    <td class=cb>
	<select name='cmbj' id=cmbj1>
	<option value=0 selected>- Pilih Prodi -</option>";
	$tampil=_query("SELECT * FROM jurusan ORDER BY jurusan_ID");
	while($w=_fetch_array($tampil)){
	$cek= ($r[kode_jurusan]==$w[kode_jurusan])? 'selected': '';
	echo "<option value=$w[kode_jurusan] $cek>  $w[nama_jurusan]</option>";
	}
	echo "</select></td></tr>
	<tr><td>Kelas *</td>    <td class=cb>
	<select name='cmbp' id=cmbp>
	<option value=0 selected>- Pilih Kelas -</option>";
	$tampil=_query("SELECT * FROM program ORDER BY ID");
	while($w=_fetch_array($tampil)){
	$cek= ($r[IDProg]==$w[ID])? 'selected': '';
	echo "<option value=$w[ID] $cek> $w[nama_program]</option>";
	}                                
	echo "</select></td></tr>

<tr><td>Konsentrasi *</td>    <td class=cb>
	<select name='kons'>
	<option value=0 selected>- Pilih Konsentrasi -</option>";
	$tampil=_query("SELECT * FROM kurikulum WHERE Kurikulum_ID NOT IN ('42') AND Jurusan_ID='$r[kode_jurusan]'");
	while($w=_fetch_array($tampil)){
	$cek= ($r[Kurikulum_ID]==$w[Kurikulum_ID])? 'selected': '';
	echo "<option value=$w[Kurikulum_ID] $cek> $w[Nama]</option>";
	}                                
	echo "</select></td></tr>

	<tr><td>Status Awal *</td>    <td class=cb><select name='StatusAwal_ID'>
	<option value=0 selected>- Pilih Status Awal Mahasiswa -</option>";
	$tampil=_query("SELECT * FROM statusawal ORDER BY StatusAwal_ID");
	while($w=_fetch_array($tampil)){
	$cek= ($r[StatusAwal_ID]==$w[StatusAwal_ID])? 'selected': '';
	echo "<option value=$w[StatusAwal_ID] $cek> $w[Nama]</option>";
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
	echo "</select></td></tr>";
					if ($r[aktif]=='Y'){
			echo "<tr><td class=cc>Aktif</td> <td class=cb>  <input type=radio name='Aktif' value='Y' checked>Y  
				<input type=radio name='Aktif' value='N'> N</td></tr>";
			}else{
			echo "<tr><td class=cc>Aktif</td> <td class=cb>  <input type=radio name='Aktif' value='Y'>Y  
				<input type=radio name='Aktif' value='N' checked>N</td></tr>";
			}      
	echo"<tr><td>Penasehat Akademik *</td>
	<td class=cb><select name='pa'>
	<option value=0 selected>- Pilih Penasehat Akademik -</option>";
	$tampil=_query("SELECT * FROM dosen WHERE Identitas_ID='$r[identitas_ID]' AND jurusan_ID LIKE '%$r[kode_jurusan]%' ORDER BY dosen_ID");
	while($w=_fetch_array($tampil)){
	if ($r[PenasehatAkademik]==$w[dosen_ID]){
	echo "<option value=$w[dosen_ID] selected>$w[nama_lengkap], $w[Gelar]</option>";
	}
	else{
	echo "<option value=$w[dosen_ID]>$w[nama_lengkap], $w[Gelar]</option>";
	}
	}                                
	echo "</select></td></tr>
	</thead></table>";   
echo"</div>";
//tab 2
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
//tab3		
echo"<div class='tab-pane' id='Alamat'>";
	$e=_query("SELECT * FROM mahasiswa WHERE NoReg='$id'");
	$re=_fetch_array($e);
	$prodi = GetFields('jurusan', 'kode_jurusan', $re[kode_jurusan], '*');
echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><strong>Sesuai Dengan KTP atau Identitas Resmi Lainnya..!!!</strong></td></tr>
	<tr><td>Username</td>  <td class=cb><input type=text name=username size=10 value='$re[username]'></td></tr>
	<tr><td>Password</td>  <td class=cb><input type=password name=password size=10> * Kosongkan Jika Tidak diubah</td></tr>
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
echo "<tr><td>Jenis Kelamin</td> <td class=cb>  <input type=radio name='Kelamin' value='L' checked> Laki-laki  
		<input type=radio name='Kelamin' value='P'> Perempuan</td></tr>";
	}
	else{
echo "<tr><td>Jenis Kelamin</td> <td class=cb>  <input type=radio name='Kelamin' value='L'> Laki-laki  
	<input type=radio name='Kelamin' value='P' checked> Perempuan</td></tr>";
	}
if ($re[WargaNegara]=='WNA'){
	echo "<tr><td>Warga Negara</td> <td class=cb>  <input type=radio name='WargaNegara' value='WNA' checked> Warga Negara Asing  
	<input type=radio name='WargaNegara' value='WNI'> Warga Negara Indonesia</td></tr>";
	}
	else{
echo "<tr><td>Warga Negara</td> <td class=cb>  <input type=radio name='WargaNegara' value='WNA'> Warga Negara Asing  
	<input type=radio name='WargaNegara' value='WNI' checked> Warga Negara Indonesia</td></tr>";
	}
echo"<tr><td>Jika Asing Sebutkan  <td class=cb>  <input type=text name='Kebangsaan' value='$re[Kebangsaan]'></td></tr>
	<tr><td>Agama</td>    <td class=cb>     <select name='Agama'>
	<option value=0 selected>- Pilih Agama -</option>";
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
	<option value=0 selected>- Pilih Status -</option>";
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
//tab4	
echo"</div>";	
echo"<div class='tab-pane' id='Ortu'>";	
 echo"<table class='table table-striped'><thead>
                          <tr><td colspan=2><strong>Data Ayah</strong></td></tr>
                          <tr><td>Nama</td>    <td class=cb>     <input type=text name=NamaAyah size=50 value='$re[NamaAyah]'></td></tr>
                          <tr><td>Agama</td><td class=cb><select name='AgamaAyah'>
                                    <option value=0 selected>- Pilih Agama -</option>";
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
                                    <option value=0 selected>- Pilih Pendidikan -</option>";
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
                                    <option value=0 selected>- Pilih Pekerjaan -</option>";
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
                                    <option value=0 selected>- -</option>";
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
                                    <option value=0 selected>- Pilih Agama -</option>";
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
                                    <option value=0 selected>- Pilih Pendidikan -</option>";
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
                                    <option value=0 selected>- Pilih Pekerjaan -</option>";
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
                                    <option value=0 selected>-   -</option>";
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
//Tab 5
echo"<div class='tab-pane' id='sekolah'>";	
if($prodi[jenjang]=='S1'){
 echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><strong>Asal Sekolah Mahasiswa</strong></td></tr>
	<tr>
		<td>Nama Sekolah</td>
		<td class=cb><input type=text name='AsalSekolah' size=50 value='$re[AsalSekolah]'></td>
	</tr>
		<tr><td>Jurusan</td>
		<td class=cb><input type=text name='JurusanSekolah' size=50 value='$re[JurusanSekolah]'></td></tr>

		<tr><td>Tahun Lulus</td><td class=cb><input type=text name='TahunLulus' value='$re[TahunLulus]'></td></tr>
		<tr><td>NOMOR STTB</td><td class=cb><input type=text name='NilaiSekolah' size=8 value='$re[NilaiSekolah]'></td></tr>
	</table>";	
}else{
 echo"<table class='table table-striped'><thead>
	<tr><td colspan=2><strong>Asal Perguruan Tinggi</strong></td></tr>
	<tr>
		<td>Nama Perguruan Tinggi</td>
		<td class=cb><input type=text name='AsalSekolah' size=50 value='$re[AsalSekolah]'></td>
	</tr>
		<tr><td>Jurusan</td>
		<td class=cb><input type=text name='JurusanSekolah' size=50 value='$re[JurusanSekolah]'></td></tr>

		<tr><td>Tahun Lulus</td><td class=cb><input type=text name='TahunLulus' value='$re[TahunLulus]'></td></tr>
		<tr><td>NOMOR IJAZAH</td><td class=cb><input type=text name='NilaiSekolah' size=8 value='$re[NilaiSekolah]'></td></tr>
	</table>";
}	
echo"</div>";
	
echo"</div>";
echo"<p><center><input class='btn btn-success btn-large' type=submit value=Simpan class=tombol></center></p></form>";			
tutup();
}
 
function CariModulMhs(){
buka("Manajemen Modul Mahasiswa");
echo"<div class='row'><p class='pull-right'><a class='btn btn-mini btn-danger' href='go-masterdosen.html'>Kembali</a></p></div>
<div class='row'>";
echo"<div class='span5'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Data Dosen</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>";
	$sql="SELECT * FROM mahasiswa WHERE NIM='$_GET[id]' ORDER BY NIM";
	$qry= _query($sql) or die ();
	$data=_fetch_array($qry);
	$id_level=$data[level_ID];
	$NIM=$data[NIM];
	$prodi=$data[kode_jurusan];
	$no++;
echo"<thead>
	<input type=hidden name=id_level value=$data[id_level]>
		<tr><th>NIM</th><th>$NIM</th></tr>
		<tr><th>Nama Lengkap</th><th>$data[nama_lengkap]</th></tr>
		<tr><th>Program Studi</th><th>$data[kode_jurusan] - $data[nama_jurusan]</th></tr>
	</thead>";

echo"</table></div></div></div>";
echo"</div>";
echo"<div class='row'>";
echo"<div class='span3'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> GROUP</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<thead><tr><th>Group</th><th>Pilih</th></tr></thead>";
	$sql="SELECT * FROM groupmodul a,modul b WHERE a.id_group=b.id_group
	ORDER BY a.id_group";
	$qry= _query($sql)  or die ();
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	echo "<form method=post action='aksi-akademikmahasiswa-InputModulMhs.html'>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level=$id_level AND id=$data[id]";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	if ($cocok==1){  $cek="checked"; } else{ $cek=""; }  
	echo "<input type=hidden name=NIM value=$NIM>
		<input type=hidden name=prodi value=$prodi>
		<input type=hidden name=id_level value=$id_level>
		<td>$data[nama]</td>           
		<td><input name=CekModul[] type=checkbox value=$data[id] $cek></td></tr>";
	}
echo"</table></div></div></div>";
echo"<div class='span8'>
	<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> Modul</div>
	<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<thead><tr><th>Modul</th><th>Modul</th><th>Keterangan</th><th>Aksi</th></tr></thead>";
	$sql="SELECT  t2.id_group AS id_group,
	t1.id AS id,
	t1.parent_id AS parent_id,
	t2.nama AS nama,
	t1.judul AS judul,
	t1.aktif AS aktif,
	t1.url AS url,
	t1.keterangan AS keterangan 
	FROM   modul t1 , groupmodul t2 
	WHERE  t1.parent_id = t2.id_group
	ORDER BY  t2.id_group";
	$qry= _query($sql) or die ();
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$id_level' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr); if ($cocok==1){  $cek="checked";}else{ $cek="";}        
	echo "<input type=hidden name=id_level value=$id_level>
		<td>$data[nama]</td>              
		<td>$data[judul]</td>
		<td>$data[keterangan]</td>
		<td><input name=CekModul[] type=checkbox value=$data[id] $cek></td>
	</tr>";
	}
echo"<tr><td colspan=4><center><input class='btn btn-success' type=submit name=submit value=Simpan></center></form></td></tr></table></div></div></div>";

echo"</div>";
tutup(); 
}
switch($_GET[PHPIdSession]){

default:
Defakademikmahasiswa();
break;

case "chagmstmhs":
chagmstmhs();
break;
  
case "CariModulMhs":
CariModulMhs();
break;

case "CalonMahasiswa":
CalonMahasiswa();
break;

case "MahasiswaBaru":
MahasiswaBaru();
break;

case "updmhsw":
$kode= $_REQUEST['cmbj'];
  if (empty($_POST[password])){
  $Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]); 
  $tglls=sprintf("%02d%02d%02d",$_POST[thntlls],$_POST[blntlls],$_POST[tgltlls]); 
 $upMahasiswa= _query("UPDATE mahasiswa SET username='$_POST[username]',
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
  IDProg='$_POST[cmbp]',
  kode_jurusan='$_POST[cmbj]',
  Kurikulum_ID='$_POST[kons]',
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
				WHERE username	= '$_POST[username]'");	
  } else {
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
  Kurikulum_ID='$_POST[kons]',
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
				password    	= '$pasws',
				email       	= '$_POST[Email]',
				aktif       	= '$_POST[Aktif]'                                                                                   
				WHERE username	= '$_POST[username]'");	 
  }
   	buka("Update Data Mahasiswa");
	echo SuksesMsg("Data Mahasiswa Berhasil Di Update","");
	echo "<center><a class='btn btn-success' href='in-akademikmahasiswa-$kode.html'><i class='icon-undo'></i> OK </a></center>";
	tutup();  
break;

case "InputModulMhs":
	$id_level =$_REQUEST['id_level'];
	$prodi = $_POST['prodi'];
	$NIM = $_POST['NIM'];
	$CekModul =$_REQUEST['CekModul'];
	$kode= $_REQUEST['codd'];
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
   	buka("Update Modul Mahasiswa");
	echo SuksesMsg("Modul Mahasiswa Berhasil Di Update","");
	echo "<center><a class='btn btn-success' href='in-akademikmahasiswa-$prodi.html'><i class='icon-undo'></i> OK </a></center>";
	tutup(); 
break;

case "delmstmhsw":
 $kode= $_REQUEST['codd'];
 $cek=_fetch_array(_query("SELECT * FROM mahasiswa WHERE NoReg='$_GET[id]'"));
 if ($cek['Foto']!=''){
 $delUser=_query("DELETE FROM useryapan WHERE username='$cek[username]'");
 $delBau=_query("DELETE FROM keuanganmhsw WHERE RegID='$cek[NoReg]'");
 $delTransaksi=_query("DELETE FROM transaksi WHERE AccID='$cek[NoReg]'");
 $delMhsw=_query("DELETE FROM mahasiswa WHERE NoReg='$_GET[id]'");
 unlink("$cek[Foto]");
  }else{
 $delUser=_query("DELETE FROM useryapan WHERE username='$cek[id]'");
 $delBau=_query("DELETE FROM keuanganmhsw WHERE RegID='$cek[NoReg]'");
 $delTransaksi=_query("DELETE FROM transaksi WHERE AccID='$cek[NoReg]'");
 $delMhsw=_query("DELETE FROM mahasiswa WHERE NoReg='$_GET[id]'");
  }
	buka("Hapus Data Mahasiswa");
	echo SuksesMsg("Data Mahasiswa Berhasil Di Hapus","");
	echo "<center><a class='btn btn-success' href='in-akademikmahasiswa-$kode.html'><i class='icon-undo'></i> OK </a></center>";
	tutup(); 
break;
  
case "addmhsw":
	$kode= $_REQUEST['cmbj1'];
	$Tg=sprintf("%02d%02d%02d",$_POST[thntl],$_POST[blntl],$_POST[tgltl]);  	
	$pass=md5($_POST[password]);
	$cek=_query("SELECT * FROM mahasiswa WHERE NoReg='$_POST[NoReg]'");
		if (_num_rows($cek)>0)
		{
		PesanEror("Proses Mahasiswa Baru", "Pendaftaran Mahasiswa Baru Gagal.No Registrasi Sudah ada. Silahkan Ulangi Lagi");
		}else{
	$a=_query("INSERT INTO mahasiswa (NoReg,
	username,
	password,
	Angkatan,
	Kurikulum_ID,
  identitas_ID,
  RekananID,
  Nama,
  StatusAwal_ID,
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
  ('$_POST[NoReg]','$_POST[username]','$pass','$_POST[Angkatan]','$_POST[nkur]','$_POST[cmi1]','$_POST[rekanan]','$_POST[Nama]','$_POST[StatusAwal_ID]','$_POST[StatusMhsw_ID]','$_POST[cmbp1]','$_POST[cmbj1]','$_POST[pa]','$_POST[Kelamin]','$_POST[WargaNegara]','$_POST[Kebangsaan]','$_POST[TempatLahir]','$Tg','$_POST[Agama]','$_POST[StatusSipil]','$_POST[Telepon]','$_POST[Handphone]','$_POST[Alamat]','$_POST[Kota]','$_POST[RT]','$_POST[RW]','$_POST[KodePos]','$_POST[Propinsi]','$_POST[Negara]')");

	$UserYapan ="INSERT INTO useryapan(username,password,LevelID,Nama,IdentitasID,kodeProdi,Bagian,Jabatan,email,aktif,Log,SessionID)VALUES
	('$_POST[username]','$pass','4','$_POST[Nama]','$_POST[cmi1]','$_POST[cmbj1]','mahasiswa','19','','N','','$_POST[NoReg]')";
	$InsertUserYapan=_query($UserYapan);
	
if($a){
	$jenjang = GetaField('jurusan', 'kode_jurusan', $_POST['cmbj1'], 'jenjang');
	$s ="INSERT INTO keuanganmhsw (KeuanganMhswID,RegID,IdentitasID,ProdiID,TahunID,JenjangID,Potongan,TotalBiaya,Aktif,SubmitOleh,TglSubmit,Keterangan)
        values('$_POST[NIM]','$_POST[NoReg]','$_POST[cmi1]','$_POST[cmbj1]','$_POST[Angkatan]','$jenjang','','','N','$_SESSION[Nama]','$tgl_sekarang','')";
	$r = _query($s);  
	}	
PesanOk2("Tambah Mahasiswa Baru","Data Mahasiswa Baru Berhasil Di Simpan. <b> ID REGISTRASI : $_POST[NoReg]</b> ","in-humasMhsw-$kode.html","cetak-CetakPendaftaran-$_POST[NoReg].html");
}
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
	echo "<center><a class='btn btn-success' href='mhsw-akademikmahasiswa-chagmstmhs-$NIM-$prodi.html'><i class='icon-undo'></i> OK</a></center>";
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
}     
        
?>
