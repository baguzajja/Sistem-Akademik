  <script language="javascript" type="text/javascript">
  <!--
  function MM_jumpMenu(targ,selObj,restore){// v3.0
   eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  //-->
  </script>
<?php
function defjadkulAkd(){
global $buat,$baca,$tulis,$hapus;
if($baca){
$jabatan 	= $_SESSION[Jabatan];
buka("BAAK :: Jadwal Kuliah stie yapan Surabaya");
$m = GetFields('mahasiswa', 'NIM', $_SESSION[yapane], '*');
	$tAktif=TahunAktif();
	$institusi= $_SESSION['Identitas'];
	$jurusan=($jabatan==18 OR $jabatan==19)? $_SESSION['prodi']:$_POST['jurusan'];
	$disjurusan=($jabatan==18 OR $jabatan==19)? "disabled":"";
	$program=($jabatan==19)? $m['IDProg']:$_POST['program'];
    $disprogram=($jabatan==19)? "disabled":"";
    $tahun= (empty($_POST['tahun'])) ? $tAktif : $_POST['tahun'];
    $sms= $_POST['semester'];
echo "<form action='go-jadkulAkd.html' method='post' class='form-horizontal'>
<div class='well'><div class='row-fluid'>
<div class='span3'>
	<label> TAHUN AKADEMIK </label>
	<select name='tahun' onChange='this.form.submit()' class='span12'>
	<option value=''>- Tahun -</option>";
	$sqlp="SELECT * FROM tahun WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d2=mysql_fetch_array($qryp)){
	$cek= ($d2['Tahun_ID']==$tahun) ? 'selected' : '';
	echo "<option value='$d2[Tahun_ID]' $cek> $d2[Nama] </option>";
	}
	echo " </select></div><div class='span3'>
	<label>PROGRAM STUDI</label>
	<select name='jurusan' onChange='this.form.submit()' class='span12' $disjurusan>
	<option value=''>- Pilih Prodi -</option>";
	$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d1=mysql_fetch_array($qryp)){
	$cek= ($d1['kode_jurusan']==$jurusan) ? 'selected' : '';
	echo "<option value='$d1[kode_jurusan]' $cek>  $d1[nama_jurusan]</option>";
	}
	echo"</select></div><div class='span3'>
	<label>KELAS </label>
	<select name='program' onChange='this.form.submit()' class='span12' $disprogram>
	<option value=''>- Pilih Kelas -</option>";
	$sqlp="SELECT * FROM program WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp) or die();
	while ($d2=mysql_fetch_array($qryp)){
	$cek= ($d2['ID']==$program) ? 'selected' : '';
	echo "<option value='$d2[ID]' $cek>  $d2[nama_program]</option>";
	}
	echo"</select> </div>
<div class='span3'>
<label>SEMESTER </label>
<select name='semester' onChange='this.form.submit()' class='span12'>
	<option value=''>- Pilih Semester -</option>";
$pu=($jurusan=='61101') ? 4:8;
echo Semester(1,$pu, $sms);
	echo " </select></div>
</div>
</div>
</form>";
$PRODI=NamaProdi($jurusan);
$kelas=NamaKelasa($program);
echo"
<div class='row-fluid'>
<legend>
	<div class='pull-left'>
	PRODI : $PRODI :: $kelas :: Semester : $sms
	</div>
	<div class='btn-group pull-right'>";
if($buat){
echo"<a class='btn btn-primary' href='action-jadkulAkd-editJadwal-1.html'>Tambah Jadwal</a>";
}
if(!empty($tahun) AND !empty($program) AND !empty($jurusan) AND !empty($sms)){
echo"<a class='btn btn-inverse iframe' title='JADWAL KULIAH - PRODI $PRODI' href='JdwalPdf-JadwalKuliah-$tahun-$program-$jurusan-$sms.html'>Cetak</a>";
}
echo"</div>
</legend>
</div><legend></legend>";
JadwalHarian("Senin",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Selasa",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Rabu",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Kamis",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Jumat",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Sabtu",$institusi,$jurusan,$program,$tahun,$sms);	
	} else { ErrorAkses(); }
tutup();
}

function JadwalHarian($hari,$institusi,$jurusan,$program,$tahun,$sms){
global $buat,$baca,$tulis,$hapus;
echo"<div class='panel'>
	<div class='panel-header'><i class='icon-sign-blank'></i> $hari</div>
	<div class='panel-content panel-tables'>
<table class='table table-bordered table-striped'>  
	<thead>
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Waktu</th>
			<th>Ruang</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>";
		$sql="SELECT * FROM jadwal WHERE Identitas_ID='$institusi' AND Kode_Jurusan='$jurusan' AND Program_ID='$program' AND Hari='$hari' AND Tahun_ID='$tahun' AND semester='$sms' ORDER BY Jadwal_ID";
		$qry= _query($sql)or die ();
		while ($r=_fetch_array($qry)){  
		$no++;
		$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
		$mtk = GetFields('matakuliah', 'Matakuliah_ID', $r[Kode_Mtk], '*');
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama");
		$dosen1=NamaDosen($r[Dosen_ID]);
		$dosen2=NamaDosen($r[Dosen_ID2]);
		$dosens=($r[Kode_Jurusan]=='61101')? $dosen1: "1-". $dosen1." <br>2-". $dosen2;
		echo "<tr>                            
			<td>$no</td>
			<td>$kelompok - $mtk[Kode_mtk]</td>
			<td>$mtk[Nama_matakuliah]</td>
			<td>$mtk[SKS]</td>
			<td>$dosens</td>
			<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>
			<td>$ruang</td>
			<td>$sttus</td>
			<td>
			<div class='btn-group pull-right'>
			<button class='btn dropdown-toggle btn-mini' data-toggle='dropdown'>
			Aksi <span class='caret'></span>
			</button>
	<ul class='dropdown-menu'>";
if($tulis){
	echo"<li><a href='actions-jadkulAkd-editJadwal-0-$r[Jadwal_ID].html'>Edit Jadwal</a></li>";
	echo"<li><a href='get-jadkulAkd-editUjian-$r[Jadwal_ID].html'>Edit Ujian</a></li>";
}
if($hapus){
			echo"<li class='divider'></li>
				<li><a href='get-jadkulAkd-hapus-$r[Jadwal_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Jadwal $r[Nama_matakuliah] ?')\">Hapus Jadwal</a></li>";
}
echo"</ul></div></td></tr>";        
	}
echo"</table></div></div>";

}
function editJadwal(){
global $today,$buat,$tulis,$BulanIni,$TahunIni, $tgl_sekarang;
if($buat OR $tulis){
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('jadwal', 'Jadwal_ID', $id, '*');
    $jdl = "Edit Modul";
    $link = "actions-jadkulAkd-editJadwal-$md-$id.html";
    $hiden = "<input type=hidden name='id' value='$w[Jadwal_ID]'>";
  } else {
    $w = array();
	$w['Identitas_ID']= $_SESSION[Identitas];
	$w['Program_ID']='';
	$w['Kode_Mtk']='';
	$w['Kode_Jurusan']='';
	$w['Ruang_ID']='';
	$w['semester']='';
	$w['Dosen_ID']='';
	$w['Dosen_ID2']='';
	$w['Hari']='';
	$w['Jam_Mulai']='';
	$w['Jam_Selesai']='';
    $jdl = "Tambah Jadwal Kuliah";
    $link = "action-jadkulAkd-editJadwal-$md.html";
    $hiden = "";
  }
$identitas= (empty($_POST['institusi'])) ? $w[Identitas_ID] : $_POST['institusi'];
$jurusan= (empty($_POST['jurusan'])) ? $w[Kode_Jurusan] : $_POST['jurusan'];
$program= (empty($_POST['program'])) ? $w[Program_ID] : $_POST['program'];
$semester= (empty($_POST['semester'])) ? $w[semester] : $_POST['semester'];
buka("BAAK :: Jadwal Kuliah Stie Yapan Surabaya");
   echo"<fieldset>
<div class='row-fluid'>
<div class='span12'>
<legend>$jdl</legend>
<form action='$link' method='post' class='form-horizontal'>
	<div class='control-group'>
		<label class='control-label'>Institusi</label>
			<div class='controls'>
			<select name='institusi' onChange='this.form.submit()' class='span6'>
			<option value=''>- Pilih Institusi -</option>";
			$sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
			$cek= ($d['Identitas_ID']==$identitas) ? 'selected' : '';
			echo "<option value='$d[Identitas_ID]' $cek> $d[Nama_Identitas]</option>";
			}
	echo"</select>
	</div></div>
	<div class='control-group'>
		<label class='control-label'>Program Studi</label>
		<div class='controls'>
		<select name='jurusan' onChange='this.form.submit()' class=span6>
        <option value=''>- Pilih Jurusan -</option>";
		$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$identitas'";
		$qryp=_query($sqlp)or die();
		while ($d1=_fetch_array($qryp)){
		$cek= ($d1['kode_jurusan']==$jurusan) ? 'selected' : '';
		echo "<option value='$d1[kode_jurusan]' $cek>  $d1[nama_jurusan]</option>";
		}
	echo"</select>
	</div></div>
	<div class='control-group'>
		<label class='control-label'>Kelas</label>
		<div class='controls'>
		<select  name='program' onChange='this.form.submit()' class=span6>
        <option value=''>- Pilih Kelas -</option>";
		$sqlp="SELECT * FROM program WHERE Identitas_ID='$identitas'";
		$qryp=_query($sqlp) or die();
		while ($d2=_fetch_array($qryp)){
		$cek= ($d2['ID']==$program) ? 'selected' : '';
		echo "<option value='$d2[ID]' $cek> $d2[nama_program]</option>";
		}
	echo"</select>
	</div></div>
	<div class='control-group'>
	<label class='control-label'> Semester </label>
	<div class='controls'>
	<select name='semester' onChange='this.form.submit()' class='span6'>
	<option value=''>- Pilih Semester -</option>";
	echo Semester(1,8,$semester);
	echo " </select>
	</div>
	</div>
</form>
<form action='aksi-jadkulAkd-simpanJadwal.html' method='post' class='form-horizontal'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name=identitas value=$identitas>
	<input type=hidden name=jurusan value=$jurusan>
	<input type=hidden name=program value=$program>
	<input type=hidden name=semester value=$semester>
	$hiden
	<div class='control-group'>
		<label class='control-label'>Tahun Akademik</label>
		<div class='controls'>
		<select name='tahun' class=span6>
		<option value=0>- Tahun -</option>";
		$tampil=_query("SELECT * FROM tahun WHERE Identitas_ID='$identitas' ORDER BY ID");
		while($r=_fetch_array($tampil)){
		$cek= ($r[Tahun_ID]==$w[Tahun_ID]) ? 'selected' : '';
		echo "<option value='$r[Tahun_ID]' $cek>$r[Nama]</option>";
		}
	echo "</select>
	</div></div>
	<div class='control-group'>
	<label class='control-label'>Hari</label>
	<div class='controls'>
	<div class='row-fluid'>
	<select name='hari' class=span6>
	<option value=0>- Pilih Hari -</option>";
	$tampil=_query("SELECT * FROM hari ORDER BY id");
	while($r=_fetch_array($tampil)){
	$cek= ($r[hari]==$w[Hari]) ? 'selected' : '';
	echo "<option value='$r[hari]' $cek>$r[hari]</option>";
	}
	echo "</select>
<input type=text name=jm class=span3 value='$w[Jam_Mulai]' Placeholder='Jam Mulai 00:00'>
<input type=text name=js class=span3 value='$w[Jam_Selesai]' Placeholder='Jam Selesai 00:00'>
</div>

</div></div>
	<div class='control-group'>
		<label class='control-label'>Mata Kuliah</label>
			<div class='controls'>
			<select name='mtk' class=span6>
			<option value=''>- Pilih Matakuliah -</option>";
				$tampil=_query("SELECT t1.Matakuliah_ID,t1.Nama_matakuliah,t1.SKS 
				FROM matakuliah t1 
				WHERE t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='D' AND t1.Identitas_ID='$identitas' AND t1.Jurusan_ID='$jurusan' AND t1.Semester='$semester' ORDER BY Matakuliah_ID");
				while($r=_fetch_array($tampil)){
				$cek= ($r[Matakuliah_ID]==$w[Kode_Mtk]) ? 'selected' : '';
				echo "<option value='$r[Matakuliah_ID]' $cek> $r[Nama_matakuliah] ($r[SKS])</option>";
                      }
              echo "</select>
	</div></div>

	<div class='control-group'>
	<label class='control-label'>Ruang</label>
	<div class='controls'>
	<select name='Ruang_ID' class='span6'>
	<option value=''>- Pilih Ruang -</option>";
	$tampil=_query("SELECT * FROM ruang WHERE Kode_Jurusan='$jurusan' ORDER BY ID");
	while($r=_fetch_array($tampil)){
	$cek= ($r[ID]==$w[Ruang_ID]) ? 'selected' : '';
	echo "<option value='$r[ID]' $cek> $r[Nama]</option>";
	}
	echo "</select>
	</div>
	</div>
<div class='control-group'>
	<label class='control-label'>Dosen </label>
	<div class='controls'>
		<select name=dsn1 class='span6'>
              <option value=0>- Pilih Dosen I -</option>";
				$tampil = _query("SELECT t1.dosen_ID,t1.nama_lengkap,t1.Gelar 
                    FROM dosen t1 
                    WHERE t1.Identitas_ID='$identitas' AND t1.Jurusan_ID LIKE '%$jurusan%' ORDER BY t1.nama_lengkap ASC");
				while($d = _fetch_array($tampil)){
				$cek= ($d[dosen_ID]==$w[Dosen_ID]) ? 'selected' : '';
				echo "<option value=$d[dosen_ID]>$d[nama_lengkap],$d[Gelar]</option>";
                  }
	echo "</select>
		<select name=dsn2 class='span6'>
              <option value=0>- Pilih Dosen II -</option>";
			$tampil = _query("SELECT * FROM dosen WHERE Identitas_ID='$identitas' AND Jurusan_ID LIKE '%$jurusan%' ORDER BY nama_lengkap ASC");
			while($ds = _fetch_array($tampil)){
			$cek= ($ds[dosen_ID]==$w[Dosen_ID2]) ? 'selected' : '';
			echo "<option value='$ds[dosen_ID]' >$ds[nama_lengkap],$ds[Gelar]</option>";
			}
	echo "</select>
	</div>
</div>
	<div class='form-actions'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-jadkulAkd.html';\">
	</div></center>
	</div>
</form>
</div></div></fieldset>"; 
}else{ ErrorAkses(); }
tutup();
}
function simpanJadwal() {
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$identitas	 	= $_POST['identitas']; 
	$jurusan		= $_POST['jurusan'];   
	$program		= $_POST['program'];        
	$semester		= $_POST['semester'];        
	$tahun		 	= $_POST['tahun'];
	$hari		 	= $_POST['hari'];
	$jm		 		= $_POST['jm'];
	$js		 		= $_POST['js'];
	$mtk			= $_POST['mtk'];
	$ruang			= $_POST['Ruang_ID'];
	$dsn1			= $_POST['dsn1'];
	$dsn2			= $_POST['dsn2'];
	
  if ($md == 0) {
$update= _query("UPDATE jadwal SET 
		Identitas_ID	= '$identitas',
		Tahun_ID		= '$tahun',
		Program_ID		= '$program',
		Kode_Mtk		= '$mtk',
		Kode_Jurusan	= '$jurusan',
		Ruang_ID        = '$ruang',
		semester		= '$semester',
		Dosen_ID        = '$dsn1',
		Dosen_ID2		= '$dsn2',
		Hari			= '$hari',
		Jam_Mulai		= '$jm',
		Jam_Selesai		= '$js' 
		WHERE Jadwal_ID      = '$id'");
PesanOk("Update Jadwal kuliah","Jadwal Berhasil Diupdate","go-jadkulAkd.html");	
  } else {
$insert= _query("INSERT INTO jadwal
(Tahun_ID,Identitas_ID,Program_ID,Kode_Mtk,Kode_Jurusan,Ruang_ID,semester,Dosen_ID,Dosen_ID2,Hari,Jam_Mulai,Jam_Selesai) 
	VALUES('$tahun','$identitas','$program','$mtk','$jurusan','$ruang','$semester','$dsn1','$dsn2','$hari','$jm','$js')");
PesanOk("Tambah Jadwal","Jadwal Baru Berhasil Disimpan","go-jadkulAkd.html");	
  }
}

function editUjian(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
if($buat OR $tulis){
buka("Administrator :: Edit Jadwal Ujian");
	$id = $_REQUEST['id'];
    $ed = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$hidden="<input type=hidden name=id value=$ed[Jadwal_ID]>";
echo"<div class='well'>
<form method=post action='aksi-jadkulAkd-simpanuts.html' class='form-horizontal'>
$hidden
<legend>Set Jadwal UTS </legend>
	<div class='control-group'><label class='control-label'>Tgl Ujian</label>
	<div class='controls'>"; 
		$get_tgl2=substr("$ed[UTSTgl]",8,2);
		combotgl(1,31,'tgluts',$get_tgl2);
        $get_bln2=substr("$ed[UTSTgl]",5,2);
        combonamabln(1,12,'blnuts',$get_bln2);
        $get_thn2=substr("$ed[UTSTgl]",0,4);
        combothn($TahunIni-2,$TahunIni+2,'thnuts',$get_thn2);
     echo"</div></div>
	<div class='control-group'><label class='control-label'>Hari Ujian</label>
	<div class='controls'>
		<select name=hariuts class='span6'>
		<option value=0>- Pilih Hari -</option>";
		$tampil=_query("SELECT * FROM hari ORDER BY id");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UTSHari]==$w[hari])? 'selected': '';
		echo "<option value='$w[hari]' $cek>$w[hari]</option>";
		}
	echo "</select></div></div>
	<div class='control-group'><label class='control-label'>Jam Ujian</label>
	<div class='controls'>
		<input type=text name=jmuts size=5 value='$ed[UTSMulai]'> s/d <input type=text name=jsuts size=5 value='$ed[UTSSelesai]'>
	</div></div>
	<div class='control-group'>
	<label class='control-label'>Ruang Ujian</label>
	<div class='controls'>
		<select name=ruat>
		<option value=0>- Pilih Ruang -</option>";
		$tampil=_query("SELECT * FROM ruang WHERE Kode_Jurusan='$ed[Kode_Jurusan]' ORDER BY ID");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UTSRuang]==$w[ID])? 'selected': '';
		echo "<option value=$w[ID] $cek> $w[Nama]</option>";
		}
	echo "</select>
	</div></div>
		<div class='form-actions'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-jadkulAkd.html';\">
	</div></center>
	</div>
</form></div>";

echo"<div class='well'><form method=post action='aksi-jadkulAkd-simpanuas.html' class='form-horizontal'>
$hidden
	<legend>Set Jadwal UAS</legend>
	<div class='control-group'><label class='control-label'>Tgl Ujian</label>
	<div class='controls'>"; 
		$get_tgl2=substr("$ed[UASTgl]",8,2);
		combotgl(1,31,'tgluas',$get_tgl2);
        $get_bln2=substr("$ed[UASTgl]",5,2);
        combonamabln(1,12,'blnuas',$get_bln2);
        $get_thn2=substr("$ed[UASTgl]",0,4);
        combothn($TahunIni-2,$TahunIni+2,'thnuas',$get_thn2);
     echo"</div></div>
	<div class='control-group'><label class='control-label'>Hari Ujian</label>
	<div class='controls'>
		<select name=hariuas class='span6'>
		<option value=0>- Pilih Hari -</option>";
		$tampil=_query("SELECT * FROM hari ORDER BY id");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UASHari]==$w[hari])? 'selected': '';
		echo "<option value='$w[hari]' $cek>$w[hari]</option>";
		}
	echo "</select></div></div>
	<div class='control-group'><label class='control-label'>Jam Ujian</label>
	<div class='controls'>
		<input type=text name=jmuas size=5 value='$ed[UASMulai]'> s/d <input type=text name=jsuas size=5 value='$ed[UASSelesai]'>
	</div></div>
	<div class='control-group'>
	<label class='control-label'>Ruang Ujian</label>
	<div class='controls'>
		<select name=ruas>
		<option value=0>- Pilih Ruang -</option>";
		$tampil=_query("SELECT * FROM ruang WHERE Kode_Jurusan='$ed[Kode_Jurusan]' ORDER BY ID");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UASRuang]==$w[ID])? 'selected': '';
		echo "<option value=$w[ID] $cek> $w[Nama]</option>";
		}
	echo "</select>
	</div></div>
	<div class='form-actions'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-jadkulAkd.html';\">
	</div></center>
	</div>
</form></div>";  
}else{ ErrorAkses(); }
tutup();
}
//parameter
switch($_GET[PHPIdSession]){

  default:
    defjadkulAkd();			
  break;   

  case "editJadwal":
	editJadwal();     
  break;

  case "simpanJadwal":
	simpanJadwal();     
  break;

  case "editUjian":
 editUjian();
  break;
//Simpan UTS
 case "simpanuts":
$tgluts=sprintf("%02d%02d%02d",$_POST[thnuts],$_POST[blnuts],$_POST[tgluts]);
$simpanuts=_query("UPDATE jadwal SET UTSTgl = '$tgluts',
                                 UTSHari 	= '$_POST[hariuts]',
                                 UTSMulai	= '$_POST[jmuts]',
                                 UTSSelesai	= '$_POST[jsuts]',
                                 UTSRuang	= '$_POST[ruat]' 
                           WHERE Jadwal_ID	= '$_POST[id]'");
PesanOk("Set Jadwal UTS","Jadwal UTS Berhasil Disimpan","go-jadkulAkd.html");
  break; 
//Simpan UAS
 case "simpanuas":
$tgluas=sprintf("%02d%02d%02d",$_POST[thnuas],$_POST[blnuas],$_POST[tgluas]);
$simpanuas=_query("UPDATE jadwal SET UASTgl = '$tgluas',
	UASHari			= '$_POST[hariuas]',
	UASMulai		= '$_POST[jmuas]',
	UASSelesai		= '$_POST[jsuas]',
	UASRuang		= '$_POST[ruas]' 
	WHERE Jadwal_ID	= '$_POST[id]'");
PesanOk("Set Jadwal UAS","Jadwal UAS Berhasil Disimpan","go-jadkulAkd.html");
	break; 
//hapus Jadwal
	case "hapus":
$id= $_REQUEST['id'];
$hapus=_query("DELETE FROM jadwal WHERE Jadwal_ID='$id'");
PesanOk("Hapus Jadwal","Jadwal Berhasil Dihapus","go-jadkulAkd.html");
	break;     
}
?>
