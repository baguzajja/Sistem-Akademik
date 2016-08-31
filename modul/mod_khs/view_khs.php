<?php defined('_FINDEX_') or die('Access Denied'); 
//Start
if($baca){ 
$tAktif		=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$semester 	= (empty($_POST[semester]))? 1 : $_POST[semester];
$nim 		= ($_SESSION[levele]==4)? $_SESSION[yapane]: $_POST[NIM];
$disnim		= ($_SESSION[levele]==4)? "disabled": "";
$tampilkan	= ($_SESSION[levele]==4)? "": "<button type='submit' class='btn btn-info'>Tampilkan <i class='icon-chevron-right'></i></button>";
$pu=($_SESSION['prodi']=='61101') ? 4:8;
$pilihsem=Semester(1, $pu,$semester );
$namaSemester=namaSemester($semester);
?>
<div class="row">
<div class="span12">
<form method="post" id="form">
	<div class="widget">
		<div class="widget-header">						
			<h3><i class="icon-table"></i>KARTU HASIL STUDI (KHS)</h3>
			<div class="widget-actions">
				<h3>DATA KHS SEMESTER <?php echo "$namaSemester ( $semester )";?> <i class="icon-ok"></i></h3>
			</div> 
		</div> 
<div class="widget-toolbar">
<div class="row-fluid">
<div class="pull-left"  style="padding-top: 7px">
<?php 
echo"<div class='input-prepend input-append pull-left btn-group'>
		<span class='add-on'>TAHUN</span>
		<select name='tahun' onChange='this.form.submit()'>
			<option value=''>- Pilih Tahun Akademik -</option>";
			$t=_query("SELECT * FROM tahun ORDER BY Nama DESC");
			while($r=_fetch_array($t)){
			$cek=($tahun == $r['Tahun_ID'])? 'selected': '';
			echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
			}
		echo "</select> 
		<span class='add-on'>SEMESTER</span>
		<select name='semester' onChange='this.form.submit()'>
		$pilihsem
		</select><span class='add-on'>NIM</span>
		<input type='text' name=NIM value='$nim' placeholder='Masukkan NIM Mahasiswa' class='' required $disnim>
		$tampilkan
		<a href='go-khs.html' class='btn btn-inverse ui-tooltip' data-placement='top' title='Refresh'><i class='icon-refresh'></i></a>
	</div>";
?>
</div>
</div>
</div>
<div class="widget-content">
<?php
if (! empty($nim) AND !empty($tahun) AND !empty($semester)){
  $sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
  $qry=_query($sql) or die ();
  $ab=_num_rows($qry);
  if ($ab > 0){    
	$data=_fetch_array($qry);
if($data['Foto']!=''){
		if (file_exists('media/images/foto_mahasiswa/'.$data[Foto])){
			$foto ="<img src='media/images/foto_mahasiswa/medium_$data[Foto]' width='100%' alt='$data[Nama]'>";
		} elseif (file_exists('media/images/'.$data['Foto'])){
			$foto ="<img src='media/images/$data[Foto]' width='100%' alt='$data[Nama]'>";
		}else{
			$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$data[Nama]' width='100%'>";
		}
}else{
	$foto ="<img src=".AdminPath."/img/avatar.jpg alt='$data[Nama]' width='100%'>";
}

	$PRODI=NamaProdi($data[kode_jurusan]);
	$kelas=NamaKelasa($data[IDProg]);
	$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
	
	$konsentrasi=strtoupper(NamaKonsentrasi($data[Kurikulum_ID]));
echo"<div class='row-fluid'>
<div class='span10'>
<table class='table table-bordered table-striped'>
	<tr><td>NAMA</td><td> $data[Nama]</td></tr>
	<tr><td>PROGRAM STUDI</td><td> $PRODI</td></tr>
	<tr><td>KELAS</td><td>$kelas</td></tr>
	<tr><td>KONSENTRASI</td><td>$konsentrasi</td></tr>
</table>
<legend>DATA KHS SEMESTER $namaSemester ( $semester )
	<div class='btn-group pull-right'>";
if($buat){
echo"<a class='btn btn-inverse ui-tooltip ui-lightbox' data-placement='top' title='Cetak Khs' href='do-print-khsPrint-$tahun-$semester-$nim.html?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p'  ><i class='icon-print'></i> Cetak</a>";
}
echo"</div>
</legend>
</div> 
						
<div class='span2'>
	<div class='widget-content'>
		$foto	
	</div>
</div> 
<div class='clear'></div>
</div><div class='clear'></div>";
		
echo"<div class='widget widget-table'><div class='widget-content'>
<table class='table table-striped table-bordered table-highlight'>
<thead>
<tr><th>NO</th><th>KODE</th><th>MATAKULIAH</th><th>KREDIT</th><th>NILAI</th><th>BOBOT</th><th>BOBOT*SKS</th></tr></thead>";  
  $sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
  $no=0;
  $qry=_query($sql) or die ();
  while($data=_fetch_array($qry)){
	$mtk = GetFields('matakuliah', 'Matakuliah_ID', $data[Jadwal_ID], '*');
	$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$mtk[KelompokMtk_ID],"Nama");
	$ipSks= ($data[GradeNilai]=='-')? 0: $mtk[SKS];
  $no++;
  echo"<tr>
		<td align=center> $no</td>
		<td>$kelompok - $mtk[Kode_mtk]</td>
		<td>$mtk[Nama_matakuliah]</td>
		<td align=center>$mtk[SKS] SKS</td>";
		$Totsks=$Totsks+$ipSks;
		$Tot+=$mtk[SKS];
      echo" <td align=center>$data[GradeNilai]</td>
            <td align=center>$data[BobotNilai]</td>";
            $boboxtsks=$mtk[SKS]*$data[BobotNilai];
            $jmlbobot=$jmlbobot+$boboxtsks;
            $ips=$jmlbobot/$Totsks;
     echo " <td align=center>$boboxtsks</td>   
            </tr>";
  }
$totalSKS=number_format($Tot,0,',','.');
$totalBOBOT=number_format($jmlbobot,0,',','.');
$Ips=number_format($ips,2,',','.');
  echo"<tfoot><tr> <td colspan=3><b>Jumlah Kredit Yang di tempuh</b></td>
		<td colspan=1 align=center><b>$totalSKS SKS</b></td>
		<td colspan=2 align=right></td>
		<td colspan=1 align=center><b>$totalBOBOT</b></td></tr></tfoot>";
 echo" </table>";
echo"</div>";
echo"<div class='widget-toolbar'>
	Index Prestasi (IP) Semester Sekarang : <b>$Ips</b> 
	</div>";
echo"</div>";
	} else {
alert("error","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
  }
}else{
alert("info","Untuk Melihat data KHS, Silahkan pilih Tahun Akademik dan Masukkan NIM Mahasiswa..!");
}

?>

</div></form></div></div>
<?php }else{
ErrorAkses();
} ?>