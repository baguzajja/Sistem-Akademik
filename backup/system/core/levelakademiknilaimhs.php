<script language="javascript" type="text/javascript">
<!--
	function MM_jumpMenu(targ,selObj,restore){// v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
	}
//-->
</script>
<?php 
function Menuakademiknilai(){
  $edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
  $data=_fetch_array($edit);
    $idp= $_REQUEST['id'];
    $tahun= $_REQUEST['tahun'];
    $mat= $_REQUEST['ids'];  
echo "<div class='row-fluid'><div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<input name=id type=hidden value=$data[Identitas_ID]>
	<input name=jurusan type=hidden value=$data[kode_jurusan]>
		<thead>
			<tr>
				<th>
					<div class='input-prepend input-append pull-left'>
					<span class='add-on'> Kelas </span>
					<select name='program' onChange=\"MM_jumpMenu('parent',this,0)\">
					<option value='go-levelakademiknilaimhs.html'>- Pilih Program Kelas -</option>";
					$sqlp="SELECT * FROM program WHERE Identitas_ID='$data[Identitas_ID]'";
					$qryp=_query($sqlp) or die();
					while ($d2=_fetch_array($qryp)){
					  if ($d2['ID']==$idp){ $cek="selected"; } else{ $cek=""; }
				echo "<option value='us-levelakademiknilaimhs-$data[Identitas_ID]-$data[kode_jurusan]-$d2[ID].html' $cek>  $d2[nama_program]</option>";
						}
				echo"</select> <input name='program' type='hidden' value='$idp'>
					<span class='add-on'> Tahun Akademik </span>
					<select class='span3' name='tahun' onChange=\"MM_jumpMenu('parent',this,0)\">
					<option value='go-levelakademiknilaimhs.html'>- Tahun -</option>";
					$sqlp="SELECT * FROM tahun WHERE Identitas_ID='$data[Identitas_ID]' AND Jurusan_ID='$data[kode_jurusan]' AND Program_ID='$idp' ORDER BY Tahun_ID";
					$qryp=_query($sqlp)  or die();
					while ($d2=_fetch_array($qryp)){
						if ($d2['Tahun_ID']==$tahun){$cek="selected"; } else{$cek="";
						}
					echo "<option value='jadwal-levelakademiknilaimhs-$data[Identitas_ID]-$data[kode_jurusan]-$idp-$d2[Tahun_ID].html' $cek> $d2[Tahun_ID] </option>";
						}
					echo " </select><input name='tahun' type='hidden' value='$idp'>
					<span class='add-on'>Matakuliah </span>
					<select name='mat' onChange=\"MM_jumpMenu('parent',this,0)\">
					<option value='go-levelakademiknilaimhs.html'>- Pilih Matakuliah -</option>";
					$sqlp="SELECT * FROM matakuliah WHERE Identitas_ID='$data[Identitas_ID]' AND Jurusan_ID='$data[kode_jurusan]' ORDER BY Matakuliah_ID";
					$qryp=_query($sqlp)  or die();
					while ($d2=_fetch_array($qryp)){
						if ($d2['Kode_mtk']==$mat){$cek="selected"; } else{$cek="";
						}
					echo "<option value='mtk-levelakademiknilaimhs-$data[Identitas_ID]-$data[kode_jurusan]-$idp-$tahun-$d2[Kode_mtk].html' $cek>  $d2[Nama_matakuliah] </option>";
						}
					echo "</select><input name='mat' type='hidden' value='$mat'>
					</div>
				</th>
			</tr>";	
if ($_GET[PHPIdSession]=='inputnilai'){
echo"<tr><th><a class='btn btn-danger pull-right' href='mtk-levelakademiknilaimhs-$data[Identitas_ID]-$data[kode_jurusan]-$idp-$tahun-$mat.html'><i class='icon-undo'></i> Kembali</a> </th></tr>";
}
echo"<tr><th colspan=''></th></tr></thead></table></div></div>";
}
function Deflevelakademiknilai(){
  $edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
  $data=_fetch_array($edit);
    $idp= $_REQUEST['id'];
    $tahun= $_REQUEST['tahun'];
    $mat= $_REQUEST['ids'];
buka("BAAK :: Input Nilai Mahasiswa");
Menuakademiknilai();
echo"<table class='table table-bordered table-striped'>
		<thead>
			<tr><th>No</th><th>Kode MK</th><th>Matakuliah</th><th>Hari</th><th>Jam Kuliah</th><th>Kelas</th><th>Lokal</th><th>Dosen</th></tr></thead>";     								
			$sql="SELECT * FROM view_jadwal WHERE Identitas_ID='$data[Identitas_ID]' AND Kode_Jurusan='$data[kode_jurusan]' AND Program_ID='$idp' AND Tahun='$tahun' AND Kode_Mtk='$mat' ORDER BY Jadwal_ID";
			$qry= _query($sql) or die ();
			while ($r=_fetch_array($qry)){         	
			$no++;
			echo "<tr>                            
				<td>$no</td>
				<td><a class=s href='editmtk-levelakademiknilaimhs-inputnilai-$r[Identitas_ID]-$r[Kode_Jurusan]-$idp-$tahun-$mat-$r[Jadwal_ID].html'>$r[Kode_Mtk]</a></td>
				<td>$r[Nama_matakuliah]</td>
				<td>$r[Hari]</td>
				<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>
				<td>$r[Kelas]</td>
				<td>$r[NamaRuang]</td>       		         
				<td>$r[nama_lengkap],$r[Gelar]</td>                    
				</tr>";        
			}
	echo"</table>";
tutup();
}
function inputnilai(){
      $idp= $_REQUEST['id'];
      $tahun= $_REQUEST['tahun'];
      $mat= $_REQUEST['ids'];
buka("Administrator :: Input Nilai Mahasiswa");
Menuakademiknilai();
	$d=_query("SELECT * FROM view_jadwal WHERE Jadwal_ID='$_GET[idjadwal]' ORDER BY Jadwal_ID");
	$r=_fetch_array($d);     
	echo"<div class='row'><div class='span5'><table class='table table-bordered table-striped'>
	<tr><td class=cc>Kelas</td> <td colspan=2 class=cb><strong>$r[Kelas]</strong></td></tr>
	<tr><td class=cc>Dosen</td> <td colspan=2 class=cb><strong>$r[nama_lengkap], $r[Gelar]</strong></td></tr>
	</table></div></div>";      
	
	echo"<table class='table table-bordered table-striped'><thead>
		<tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Absen</th><th>Grade</th></tr></thead>";     								
		$sql="SELECT * FROM krs1 
		WHERE idjdwl='$_GET[idjadwal]' ORDER BY NIM";
		$qry= _query($sql) or die ();
		while ($r1=_fetch_array($qry)){         	
		$nom++;
		echo "<tr>                            
			<td>$nom</td>
			<td>$r1[NIM]</td>
			<td>$r1[nama_lengkap]</td>
			<td></td>
			<td colspan=2>
			<form method=GET>
			<select name='nilai' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option value=''>- Nilai -</option>";
	$sqlp="SELECT * FROM nilai WHERE Identitas_ID='$_GET[codd]' AND Kode_Jurusan='$_GET[kode]'";
	$qryp=_query($sqlp) or die();
	while ($d2=_fetch_array($qryp)){
	if ($d2['grade']==$r1['GradeNilai']){ $cek="selected";  } else { $cek="";
	}
	echo "<option value='savenilai-levelakademiknilaimhs-simpannilai-$d2[Identitas_ID]-$d2[Kode_Jurusan]-$idp-$tahun-$mat-$r1[idjdwl]-$d2[grade]-$d2[bobot]-$r1[id].html' $cek> $d2[grade]--> $d2[NilaiMin]-$d2[NilaiMax]  </option>";
	}
	echo"</select>
		<input name='nilai' type='hidden' value='$nilai'> </form></td></tr>";        
	}
echo"</table>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
Deflevelakademiknilai();
  break;   

  case"inputnilai":
inputnilai();    
  break; 
  
  case"simpannilai":
$nama_tabel="krs";
$values="GradeNilai='$_REQUEST[grade]',BobotNilai='$_REQUEST[bbt]'";
$kondisi="KRS_ID='$_REQUEST[idk]'";
$ok=update($nama_tabel,$values,$kondisi);
lompat_ke('editmtk-levelakademiknilaimhs-inputnilai-'.$_REQUEST['codd'].'-'.$_REQUEST['kode'].'-'.$_REQUEST['id'].'-'.$_REQUEST['tahun'].'-'.$_REQUEST['ids'].'-'.$_REQUEST['idjadwal'].'.html');
 break;  
}
?>
