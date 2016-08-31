<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
$d=_query("SELECT * FROM matakuliah WHERE Matakuliah_ID='$_GET[id]' ORDER BY Kode_mtk");
$r=_fetch_array($d);
$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
$sksMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"SKS");
$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$r[KelompokMtk_ID],"Nama");

?>
<div class="row">
<div class="span12">
<div class="widget widget-table">
	<div class="widget-header">	      				
		<h3><i class='icon-plus'></i>INPUT NILAI MATAKULIAH : <?php echo"$kelompok $r[Kode_mtk] - $r[Nama_matakuliah]";?></h3>	
		<div class="widget-actions">
		<div class="btn-group">
		<a class='btn btn-danger' href='go-nilai.html'><i class='icon-undo'></i> Kembali</a>
		<a class='btn'> SEMESTER <?php echo"$r[Semester]";?> </a>
		</div>
		</div>
	</div>

<?php
echo"
<div class='widget-content'>
<table class='table table-striped table-bordered table-highlight' id='tablef'><thead>
	<tr><th>No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Grade Nilai</th></tr></thead>";
		$sql="SELECT * FROM krs WHERE Jadwal_ID='$r[Matakuliah_ID]' ORDER BY NIM";
		$qry= _query($sql) or die ();
		while ($r1=_fetch_array($qry)){   
		$Mahasiswa=GetName("mahasiswa","NIM",$r1[NIM],"Nama");
		$nom++;
		echo "<tr><form method='post'>
			<input type=hidden name='identitas' value='$r[Identitas_ID]'>
			<input type=hidden name='jurusan' value='$r[Kode_Jurusan]'> 
			<input type=hidden name='idKrs' value='$r1[KRS_ID]'>	 	
			<td width='5%'>$nom</td>
			<td>$r1[NIM]</td>
			<td>$Mahasiswa</td>
			<td width='15%'>
			<select name='nilai' onChange='this.form.submit()' class='input-medium' style='margin-bottom: 0'>
			<option value=''>- Nilai -</option>";
			$sqlp="SELECT * FROM nilai";
			$qryp=_query($sqlp) or die();
			while ($d2=_fetch_array($qryp)){
			$cek=($d2['grade']==$r1['GradeNilai'])? 'selected': '';
			echo "<option value='$d2[Nilai_ID]' $cek> $d2[grade]--> $d2[NilaiMin]-$d2[NilaiMax]</option>";
			}
			echo"</select>
		</td></tr></form>";        
	}
echo"</table></div>";
?>					
</div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>