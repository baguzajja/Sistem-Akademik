<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('jadwal', 'Jadwal_ID', $id, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT JADWAL KULIAH";
	$btn = "UPDATE";
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
	$jdl = "<i class='icon-plus'></i> TAMBAH JADWAL KULIAH";
	$btn = "SIMPAN";
    $hiden = "";
  }
$identitas= (empty($_POST['institusi'])) ? $w[Identitas_ID] : $_POST['institusi'];
$jurusan= (empty($_POST['jurusan'])) ? $w[Kode_Jurusan] : $_POST['jurusan'];
$program= (empty($_POST['program'])) ? $w[Program_ID] : $_POST['program'];
$semester= (empty($_POST['semester'])) ? $w[semester] : $_POST['semester'];
$kurikulume= (empty($_POST['kurikulume'])) ? $w[JenisKurikulum_ID] : $_POST['kurikulume'];
?>
<div class="row">
<div class="span12">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><?php echo $jdl;?></h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	<input type=hidden name=identitas value=$identitas>
	<input type=hidden name=jurusan value=$jurusan>
	<input type=hidden name=program value=$program>
	<input type=hidden name=semester value=$semester>
	 $hiden
<fieldset>
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
	</div>
</div>
<div class='control-group'>
	<label class='control-label'> Semester </label>
	<div class='controls'>
	<select name='semester' onChange='this.form.submit()' class='span6'>
	<option value=''>- Pilih Semester -</option>";
	echo Semester(1,8,$semester);
	echo " </select>
	</div>
</div>
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
		<label class='control-label'>Kurikulum</label>
		<div class='controls'>
		<select  name='kurikulume' onChange='this.form.submit()' class=span6>
        <option value=''>-  Pilih Kurikulum  -</option>";
		$sqlp="SELECT * FROM jeniskurikulum WHERE Jurusan_ID='$jurusan'";
		$qryp=_query($sqlp) or die();
		while ($d2=_fetch_array($qryp)){
		$cek= ($d2['JenisKurikulum_ID']==$kurikulume) ? 'selected' : '';
		echo "<option value='$d2[JenisKurikulum_ID]' $cek> $d2[Nama]</option>";
		}
		echo"</select>
	</div>
</div>
	<div class='control-group'>
	<label class='control-label'>Hari</label>
	<div class='controls'>
	<div class='row-fluid'>
	<select name='hari' class='input-xlarge'>
	<option value=0>- Pilih Hari -</option>";
	$tampil=_query("SELECT * FROM hari ORDER BY id");
	while($r=_fetch_array($tampil)){
	$cek= ($r[hari]==$w[Hari]) ? 'selected' : '';
	echo "<option value='$r[hari]' $cek>$r[hari]</option>";
	}
	echo "</select>
<input type=text name=jm class='input-medium' value='$w[Jam_Mulai]' id='Jam_Mulai' Placeholder='Jam Mulai 00:00'>
<input type=text name=js class='input-medium' value='$w[Jam_Selesai]' id='Jam_Selesai' Placeholder='Jam Selesai 00:00'>
</div>

</div></div>
	<div class='control-group'>
		<label class='control-label'>Mata Kuliah</label>
			<div class='controls'>
			<select name='mtk' class=input-xxlarge>
			<option value=''>- Pilih Matakuliah -</option>";
				$tampil=_query("SELECT t1.Matakuliah_ID,t1.Nama_matakuliah,t1.SKS 
				FROM matakuliah t1 
				WHERE t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='D' AND t1.Identitas_ID='$identitas' AND t1.Jurusan_ID='$jurusan' AND t1.Semester='$semester' AND t1.JenisKurikulum_ID='$kurikulume' ORDER BY t1.Matakuliah_ID,t1.Nama_matakuliah");
				while($r=_fetch_array($tampil)){
				$cek= ($r[Matakuliah_ID]==$w[Kode_Mtk]) ? 'selected' : '';
				echo "<option value='$r[Matakuliah_ID]' $cek> $r[Nama_matakuliah]</option>";
                      }
              echo "</select>
	</div></div>

	<div class='control-group'>
	<label class='control-label'>Ruang</label>
	<div class='controls'>
	<select name='Ruang_ID' class='input-xlarge'>
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
		<select name=dsn1 class='input-xlarge'>
              <option value=0>- Pilih Dosen I -</option>";
				$tampil = _query("SELECT t1.dosen_ID,t1.nama_lengkap,t1.Gelar 
                    FROM dosen t1 
                    WHERE t1.Identitas_ID='$identitas' AND t1.Jurusan_ID LIKE '%$jurusan%' ORDER BY t1.nama_lengkap ASC");
				while($d = _fetch_array($tampil)){
				$cek= ($d[dosen_ID]==$w[Dosen_ID]) ? 'selected' : '';
				echo "<option value=$d[dosen_ID] $cek>$d[nama_lengkap],$d[Gelar]</option>";
                  }
	echo "</select>
		<select name=dsn2 class='input-xlarge'>
              <option value=0>- Pilih Dosen II -</option>";
			$tampil = _query("SELECT * FROM dosen WHERE Identitas_ID='$identitas' AND Jurusan_ID LIKE '%$jurusan%' ORDER BY nama_lengkap ASC");
			while($ds = _fetch_array($tampil)){
			$cek= ($ds[dosen_ID]==$w[Dosen_ID2]) ? 'selected' : '';
			echo "<option value='$ds[dosen_ID]' $cek>$ds[nama_lengkap],$ds[Gelar]</option>";
			}
	echo "</select>
	</div>
</div>

<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanJadwal'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-jadwalKuliah-AllJadwal.html';\">
</div>
</div>
</fieldset></form>";
?>					
</div></div></div>		 		
</div> 
<?php }else{
ErrorAkses();
} ?>