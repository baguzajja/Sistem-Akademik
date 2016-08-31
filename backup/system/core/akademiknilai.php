    <script language="javascript" type="text/javascript">
    <!--
    function MM_jumpMenu(targ,selObj,restore){// v3.0
     eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    if (restore) selObj.selectedIndex=0;
    }
    //-->
    </script>
<?php
function Defakademiknilai(){
$tAktif=TahunAktif();
	$institusi= $_SESSION['Identitas'];
	$jurusan=$_POST['jurusan'];
    $program=$_POST['program'];
    $tahun= (empty($_POST['tahun'])) ? $tAktif : $_POST['tahun'];
    $sms= $_POST['semester'];
echo"<div class='panel-header'><i class='icon-sign-blank'></i> BAAK :: Nilai Mahasiswa<p class='pull-right'><a class='btn btn-mini btn-success' href='aksi-akademiknilai-importNilai.html'>Import Nilai</a></p></div>
  <div class='panel-content'>";
echo "<form action='go-akademiknilai.html' method='post' class='form-horizontal'>
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
	<select name='jurusan' onChange='this.form.submit()' class='span12'>
	<option value=''>- Pilih Prodi -</option>";
	$sqlp="SELECT * FROM jurusan WHERE Identitas_ID='$institusi'";
	$qryp=mysql_query($sqlp)  or die();
	while ($d1=mysql_fetch_array($qryp)){
	$cek= ($d1['kode_jurusan']==$jurusan) ? 'selected' : '';
	echo "<option value='$d1[kode_jurusan]' $cek>  $d1[nama_jurusan]</option>";
	}
	echo"</select></div><div class='span3'>
	<label>KELAS </label>
	<select name='program' onChange='this.form.submit()' class='span12'>
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
$prodi=($jurusan=='61101') ? 41:42;
echo"<legend>INPUT NILAI <small>(Prodi: <b>$PRODI</b> :: Kelas: <b>$kelas</b> :: Semester: <b>$sms</b>)</small></legend>";
echo"<table class='table table-bordered table-striped'>
		<thead>
			<tr><th>No</th><th>KODE</th><th>Matakuliah</th><th><center>Input Nilai</center></th></tr></thead>";     								
	$sql="SELECT * FROM matakuliah WHERE Identitas_ID='$institusi' AND Jurusan_ID='$jurusan' AND Semester='$sms' AND Kurikulum_ID NOT IN ('$prodi') ORDER BY Kode_mtk";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$r[KelompokMtk_ID],"Nama");       	
			$no++;
			echo "<tr>                            
				<td>$no</td>
				<td><a class=s href='get-akademiknilai-inputnilai-$r[Matakuliah_ID].html'>$kelompok - $r[Kode_mtk]</a></td>
				<td>$r[Nama_matakuliah]</td> 
				<td><center><a class='btn btn-mini btn-primary' href='get-akademiknilai-inputnilai-$r[Matakuliah_ID].html'>proses</a></center></td>                    
				</tr>";        
			}
	echo"</table>";
tutup();
}

function inputnilai(){
$id=$_GET['id'];
buka("Administrator :: Input Nilai Mahasiswa");
	$d=_query("SELECT * FROM matakuliah WHERE Matakuliah_ID='$id' ORDER BY Kode_mtk");
	$r=_fetch_array($d);
$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
$sksMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"SKS");
$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$r[KelompokMtk_ID],"Nama");
echo"<legend><div class='row-fluid'>
<span class='pull-left'>Matakuliah : $kelompok $r[Kode_mtk] - $r[Nama_matakuliah]</span>
<span class='pull-right'>Semester : $r[Semester]</span>
</div></legend>";      	
echo"<legend>INPUT NILAI MAHASISWA<div class='btn-group pull-right'>
		<a class='btn btn-danger' href='go-akademiknilai.html'><i class='icon-undo'></i> Kembali</a>
		</div></legend>";
if (isset($_POST['nilai'])){
$sqls="SELECT * FROM nilai WHERE Nilai_ID='$_POST[nilai]'";
$query=_query($sqls) or die();
$w=_fetch_array($query);
$masukkanNilai=_query("UPDATE krs SET GradeNilai='$w[grade]',BobotNilai='$w[bobot]' WHERE KRS_ID= '$_POST[idKrs]'");
	InfoMsg("Nilai Mahasiswa Berhasil Disimpan ..!","");
}
echo"
<table class='table table-bordered table-striped'><thead>
	<tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Grade</th></tr></thead>";
		$sql="SELECT * FROM krs WHERE Jadwal_ID='$r[Matakuliah_ID]' ORDER BY NIM";
		$qry= _query($sql) or die ();
		while ($r1=_fetch_array($qry)){   
		$Mahasiswa=GetName("mahasiswa","NIM",$r1[NIM],"Nama");
		$nom++;
		echo "<tr> 
<form action='get-akademiknilai-inputnilai-$id.html' method='post' class='form-horizontal'>
<input type=hidden name='identitas' value='$r[Identitas_ID]'>
<input type=hidden name='jurusan' value='$r[Kode_Jurusan]'> 
		<input type=hidden name='idKrs' value='$r1[KRS_ID]'>						
			<td>$nom</td>
			<td>$r1[NIM]</td>
			<td>$Mahasiswa</td>
			<td colspan=2>
			<select name='nilai' onChange='this.form.submit()'>
			<option value=''>- Nilai -</option>";
			$sqlp="SELECT * FROM nilai";
			$qryp=_query($sqlp) or die();
			while ($d2=_fetch_array($qryp)){
			$cek=($d2['grade']==$r1['GradeNilai'])? 'selected': '';
			echo "<option value='$d2[Nilai_ID]' $cek> $d2[grade]--> $d2[NilaiMin]-$d2[NilaiMax]</option>";
			}
			echo"</select>
		</td></form></tr>";        
	}
echo"</table>";
tutup();
}

function importNilai(){
buka("BAAK :: Import Nilai Mahasiswa");
echo "<legend><div class='row-fluid'>

<div class='span5'>
<form method=post enctype='multipart/form-data' action='aksi-akademiknilai-simpanNilai.html'>
<div class='fileupload fileupload-new' data-provides='fileupload'>
						<div class='input-append input-prepend'>
							<div class='uneditable-input span3'><i class='icon-file fileupload-exists'></i> <span class='fileupload-preview'></span></div><span class='btn btn-file'><span class='fileupload-new'>Pilih file</span><span class='fileupload-exists'>Ganti</span><input type='file' name='import_file'/></span><a href='#' class='btn fileupload-exists' data-dismiss='fileupload'>Hapus</a>
						
						</div>
					</div>
</div>
<div class='span3'>
<input class='btn btn-success' type=submit name='Import' value='IMPORT DATA'>
</form>
</div>

<div class='span4'>
<div class='pull-right'>
	<a class='btn btn-danger' href='go-akademiknilai.html'><i class='icon-undo'></i> Kembali</a>

</div>
</div>
</div></legend>";
if(isset( $_POST['Import'])){
simpanNilai();
}else{
echo"<div class='alert'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Perhatian !! Tools ini Khusus Untuk Meng-Import Data Nilai</strong> <br>Perhatikan Format Excel yang Sudah di sediakan. Atau <a href='down-fileContoh-nilai.html'>Download disini</a> Untuk contoh format $Natrans
		</div>";
}
tutup();
}
function simpanNilai(){
include "../librari/excel_reader.php";
	$data = new Spreadsheet_Excel_Reader($_FILES['import_file']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);
	$sukses = 0;
	$gagal = 0;
		for ($i=2; $i<=$baris; $i++)
			{ 
				$n1 = trimed($data->val($i, 1));
				$n2 = trimed($data->val($i, 2));
				$n3 = trimed($data->val($i, 3));
				$n4 = trimed($data->val($i, 4));
				$n5 = trimed($data->val($i, 5));
			// cek data, lalu sisipkan ke dalam tabel
				$cek=_query("SELECT * FROM krs WHERE NIM='$n1' AND Tahun_ID='$n2' AND Jadwal_ID='$n3' AND semester='$n4'");
				$cekdata = _num_rows($cek);
				if($cekdata > 0) {
					while ($n=_fetch_array($cek)){
					$sqldel= _query("DELETE FROM krs WHERE KRS_ID='$n[KRS_ID]'");	
					}
				}
				$mtk = GetFields('matakuliah', 'Matakuliah_ID', $n3, '*');
				$mhs = GetFields('mahasiswa', 'NIM', $n1, '*');
				$nilai = GetFields('nilai', 'grade', $n5, '*');
				$hasil =_query("INSERT INTO krs (NIM,Tahun_ID,Jadwal_ID,SKS,semester,kelas,GradeNilai,BobotNilai) VALUES ('$n1', '$n2', '$n3','$mtk[SKS]','$n4','$mhs[IDProg]','$n5','$nilai[bobot]')");
			if ($hasil) $sukses++; else $gagal++;
			}
InfoMsgs("IMPORT NILAI MAHASISWA SELESAI","<br> Sukses : $sukses		<br>Gagal : $gagal ");	
}
switch($_GET[PHPIdSession]){

default:
Defakademiknilai();
break;   

case"inputnilai":
inputnilai();
break; 

case"importNilai":
importNilai();
break;  

case"simpanNilai":
simpanNilai();
break; 
}
?>
