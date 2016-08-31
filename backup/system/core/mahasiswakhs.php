<?php
function defmahasiswakhs(){
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$semester 	= (empty($_POST[semester]))? '' : $_POST[semester];
$nim 		= $_SESSION[yapane];
$pilihsem=Semester(1, 8,$semester );
buka("BAAK :: Kartu Hasil Studi (KHS)");  
echo "<form method=post action='go-mahasiswakhs.html'>
<div class='well'><div class='row-fluid'>
<div class='span6'>
	<label>TAHUN</label>
	<select name='tahun' onChange='this.form.submit()' class='span12'>
		<option value=0 selected>- Pilih Tahun Akademik -</option>";
		$t=_query("SELECT * FROM tahun ORDER BY Tahun_ID DESC");
		while($r=_fetch_array($t)){
		$cek=($tahun == $r['Tahun_ID'])? 'selected': '';
		echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
		}
	echo "</select>
</div>
<div class='span6'>
<label>SEMESTER</label>
<select name='semester' onChange='this.form.submit()' class='span12'>
$pilihsem
</select>
</div>
</div></div></form>";
	$sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
	$no=0;
	$qry=_query($sql) or die ();
	$data=_fetch_array($qry);
	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
	$PRODI=NamaProdi($data[kode_jurusan]);
	$kelas=NamaKelasa($data[IDProg]);
	$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
	$namaSemester=namaSemester($semester);
echo"<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NAMA $nim </th><th> $data[Nama]</th>
	<th rowspan=4><img alt='$data[Nama]' src='$foto' width='150px' class='gambar pull-right'></th></tr>
	<tr><th>PROGRAM STUDI</th><th> $PRODI</th></tr>
	<tr><th>KELAS</th><th>$kelas</th></tr>
	<tr><th>DOSEN PEMBIMBING</th><th>$pembimbingAkademik</th></tr>
	</thead></table>";
echo"<legend>DATA KHS SEMESTER $namaSemester ( $semester )
	<div class='btn-group pull-right'>
	<a class='btn btn-inverse' href='cetakK-KHS-$tahun-$semester-$nim.html' target='_blank'>Cetak</a>
	</div></legend>";
	
	echo"<table class='table table-bordered table-striped'><thead>
		<tr><th>NO</th><th>KODE</th><th>MATAKULIAH</th><th>KREDIT</th><th>NILAI</th><th>BOBOT</th><th>BOBOT*SKS</th></tr></thead>";  
  $sql="SELECT * FROM krs a,jadwal b WHERE a.Jadwal_ID=b.Jadwal_ID AND a.Tahun_ID='$tahun' AND a.NIM='$nim' AND a.semester='$semester' ORDER BY a.semester,a.kelas";
  $no=0;
  $qry=_query($sql) or die ();
  while($data=_fetch_array($qry)){
		$namaMtk=GetName("matakuliah","Kode_mtk",$data[Kode_Mtk],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$data[Kode_Mtk],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$data[Kode_Mtk],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");
		$dosen1=NamaDosen($data[Dosen_ID]);
		$dosen2=NamaDosen($data[Dosen_ID2]);  
$ipSks= ($data[GradeNilai]=='-')? 0: $sksMtk;
  $no++;
  echo"<tr>
		<td align=center> $no</td>
		<td>$kelompok - $data[Kode_Mtk]</td>
		<td>$namaMtk</td>
		<td align=center>$sksMtk SKS</td>";
		$Totsks=$Totsks+$ipSks;
		$Tot=$Tot+$sksMtk;
      echo" <td align=center>$data[GradeNilai]</td>
            <td align=center>$data[BobotNilai]</td>";
            $boboxtsks=$sksMtk*$data[BobotNilai];
            $jmlbobot=$jmlbobot+$boboxtsks;
            $ips=$jmlbobot/$Totsks;
     echo " <td align=center>$boboxtsks</td>   
            </tr>";
  }
$totalSKS=number_format($Tot,0,',','.');
$totalBOBOT=number_format($jmlbobot,0,',','.');
$Ips=number_format($ips,2,',','.');
  echo"<tr> <td colspan=3><b>Jumlah Kredit Yang di tempuh</b></td>
		<td colspan=1 align=center><b>$totalSKS SKS</b></td>
		<td colspan=2 align=right></td>
		<td colspan=1 align=center><b>$totalBOBOT</b></td></tr>";
  echo"<tfoot>
        <tr>
			<td colspan='3'> Index Prestasi (IP) Semester Sekarang </td>
			<td colspan='4'><b>$Ips</b></td>
		</tr>";
		if($ips !=''){
        $sql="SELECT t2.MaxSKS AS sks FROM master_nilai t2 WHERE (t2.ipmax >=$ips) AND (t2.ipmin <=$ips)";
        $no=0;
        $qry=_query($sql) or die;
        while($w=_fetch_array($qry)){
        echo"<tr>
				<td colspan='3'> Jumlah Kredit Yang dapat ditempuh   :</td>
				<td colspan='4'><b>$w[sks]</b></td>
			</tr>";
			}
		}
  echo" </tfoot></table>";
tutup();
}

switch($_GET[PHPIdSession]){
  default:
   defmahasiswakhs();
  break;
}
?>