<?php
function defakademiktranskrip(){
buka("Administrator :: TRAnskrip Nilai");  
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$nim 		= (empty($_POST[NIM]))? '' : $_POST[NIM];
echo "<form method=post action='go-akademiktranskrip.html'>
<div class='well'><div class='row-fluid'>
<div class='span4'>
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
<div class='span8'>
<label>NIM</label>
<input type=text name=NIM value='$nim' placeholder='Masukkan NIM Mahasiswa' class='span8'>
<input type=submit class='btn btn-success pull-right span4' value=Tampilkan>
</div>
</div></div></form>";
if (! empty($nim)){
	$sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
	$qry=_query($sql)or die ();
	$ab=_num_rows($qry);
if ($ab > 0){ 
	$data=_fetch_array($qry);
	if (empty($data['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[Foto]"; }
	$PRODI=NamaProdi($data[kode_jurusan]);
	$Kons=($data[kode_jurusan]=='61101') ? 42:41; 
	$kelas=NamaKelasa($data[IDProg]);
	$konsentrasi=strtoupper(NamaKonsentrasi($data[Kurikulum_ID]));
	$namaSemester=namaSemester($semester);   
echo"<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NAMA</th><th> $data[Nama]</th>
	<th rowspan=4><img alt='$data[Nama]' src='$foto' width='100px' class='gambar pull-right'></th></tr>
	<tr><th>PROGRAM STUDI</th><th> $PRODI</th></tr>
	<tr><th>KELAS</th><th>$kelas</th></tr>
	<tr><th>KONSENTRASI</th><th>$konsentrasi</th></tr>
	</thead></table>";
echo"<legend>TRANSKRIP NILAI
	<div class='btn-group pull-right'>
	<a class='btn btn-inverse iframe' href='Trdf-transkrip-$nim-$data[kode_jurusan].html' target='CETAK TRANSKRIP NILAI'>Cetak</a>
	</div></legend>";

echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th colspan='2'><center>KODE MTK</center></th><th>MATAKULIAH</th><th>SMSTR</th><th>KREDIT</th><th>NILAI</th><th>BOBOT</th></tr></thead>";
  $sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND Jurusan_ID='$data[kode_jurusan]' AND Kurikulum_ID IN ($Kons,$data[Kurikulum_ID]) ORDER BY Semester, Matakuliah_ID";
  $no=0;
  $qry=mysql_query($sql)or die ();
  while($data=_fetch_array($qry)){
  $no++;
	$sqlr="SELECT * FROM krs WHERE NIM='$nim' AND Jadwal_ID='$data[Matakuliah_ID]' AND GradeNilai!='-'";
	$qryr= _query($sqlr);
	$data1=_fetch_array($qryr);
$boboxtsks=$data[SKS]*$data1[BobotNilai];
if ($boboxtsks!=0)
{
$kelompokMtk=GetName("matakuliah","Matakuliah_ID",$data[Matakuliah_ID],"KelompokMtk_ID");
$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");   
$ipSks	= ($boboxtsks==0)? 0: $data[SKS];
$Totsks	=$Totsks+$ipSks;
$TotSks	=$TotSks+$data[SKS];

$jmlbobot=$jmlbobot+$boboxtsks;
$bobot=$data1[BobotNilai];
  echo" <tr><td align=center>$no</td>
            <td>$kelompok</td>
            <td>$data[Kode_mtk]</td>
            <td>$data[Nama_matakuliah]</td>
			 <td>$data[Semester] </td>
            <td><center>$data[SKS] <span class='pull-right'>SKS</span></center></td>
            <td>$data1[GradeNilai]</td>
            <td>$boboxtsks</td>
		</tr>";  
}
$totalSKS=number_format($TotSks,0,',','.');
$sksDitempuh=number_format($Totsks,0,',','.');
$JumlahBBt=number_format($jmlbobot,0,',','.');	  
  }
  echo"<tfoot><tr><td colspan='5'><b>Total</b></td>
		<td><b><center>$totalSKS <span class='pull-right'>SKS</span></center></b></td>
		<td></td><td><b>$JumlahBBt</b></td></tr></tfoot></table>";
$ipk=$jmlbobot/$Totsks;
$Ipke=number_format($ipk,2,',','.');
  echo"<table class='table table-bordered table-striped'>
        <tr><th>Total Keseluruhan Kredit</th>
            <td class=cb><strong><center>$totalSKS SKS</center></td></tr>
		<tr><th>Index Prestasi Kumulatif </th>
		<td class=cb><center><strong>$Ipke</strong></center></td></tr></table>";
	}else{
ErrorMsg("Opps.. !!","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
  }
}

tutup();
}


switch($_GET[PHPIdSession]){
  default:
defakademiktranskrip();
  break;   
  }
?>
