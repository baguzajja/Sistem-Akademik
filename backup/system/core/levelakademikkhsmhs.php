<?php
function deflevelakademikkhs(){
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$semester 	= (empty($_POST[semester]))? '' : $_POST[semester];
$nim 		= (empty($_POST[NIM]))? '' : $_POST[NIM];
$pilihsem=Semester(1, 8,$semester );
buka("BAAK :: Kartu Hasil Studi (KHS)");  
echo "<form method=post action='go-levelakademikkhsmhs.html'>
<div class='well'><div class='row-fluid'>
<div class='span3'>
	<label>TAHUN</label>
	<select name='tahun' class='span12'>
		<option value=0 selected>- Pilih Tahun Akademik -</option>";
		$t=_query("SELECT * FROM tahun ORDER BY Tahun_ID DESC");
		while($r=_fetch_array($t)){
		$cek=($tahun == $r['Tahun_ID'])? 'selected': '';
		echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
		}
	echo "</select>
</div>
<div class='span3'>
<label>SEMESTER</label>
<select name='semester' class='span12'>
$pilihsem
</select>
</div>
<div class='span6'>
<label>NIM</label>
<input type=text name=NIM value='$nim' placeholder='Masukkan NIM Mahasiswa' class='span8'>
<input type=submit class='btn btn-success pull-right span4' value=Tampilkan>
</div>
</div></div></form>";
if (! empty($nim)){
	$sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
	$no=0;
	$qry=_query($sql) or die ();
	$ab=_num_rows($qry);
  if ($ab > 0){
$data=_fetch_array($qry);
	if (empty($data['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[Foto]"; }
	$PRODI=NamaProdi($data[kode_jurusan]);
	$kelas=NamaKelasa($data[IDProg]);
	$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
	$namaSemester=namaSemester($semester);
echo"<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NAMA</th><th> $data[Nama]</th>
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
  $sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
  $no=0;
  $qry=_query($sql) or die ();
  while($data=_fetch_array($qry)){
	$mtk = GetFields('matakuliah', 'Kode_mtk', $data[Jadwal_ID], '*');
	$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama");
	$ipSks= ($data[GradeNilai]=='-')? 0: $data[SKS];
  $no++;
  echo"<tr>
		<td align=center> $no</td>
		<td>$kelompok - $data[Jadwal_ID]</td>
		<td>$mtk[Nama_matakuliah]</td>
		<td align=center>$data[SKS] SKS</td>";
		$Totsks=$Totsks+$ipSks;
		$Tot=$Tot+$data[SKS];
      echo" <td align=center>$data[GradeNilai]</td>
            <td align=center>$data[BobotNilai]</td>";
            $boboxtsks=$data[SKS]*$data[BobotNilai];
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
  } 
  else{
ErrorMsg("Opps.. !!","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
 
  }
}else{
InfoMsg("Menu KHS Mahasiswa","Untuk Melihat data KHS, Silahkan pilih Tahun Akademik dan Masukkan NIM Mahasiswa..!");
}
tutup();
}

switch($_GET[PHPIdSession]){

  default:
deflevelakademikkhs();
  break;
   
  case "CariMahasiswa":
CariMahasiswa();
  break;  
}
?>
