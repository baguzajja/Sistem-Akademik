<?php
function defaultmahasiswatranskrip(){
buka("Mahasiswa :: Daftar Matakuliah Yang Telah Diambil");
$sql="SELECT * FROM view_form_mhsakademik WHERE NIM='$_SESSION[yapane]'";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  $ab=mysql_num_rows($qry);
  $data=mysql_fetch_array($qry);
  if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
  $no++;
  echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<thead>
	<tr><th colspan='2'></th></tr>
	<tr><th>Nama</th><th> $data[nama_lengkap]</th>
	<th rowspan=4><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='pull-right'></th></tr>
	<tr><th>Jurusan</th><th>$data[kode_jurusan] - $data[nama_jurusan]</th></tr>
	<tr><th>Kelas</th><th>$data[nama_program]</th></tr>
	<tr><th>Pembimbing Akademik</th><th>$data[pembimbing], $data[Gelar]</th></tr>
	
	<tr><th colspan='3'>
	<div class='btn-group pull-right'>
	<a class='btn btn-inverse' href='cetaktrans-Transkrip-$_SESSION[yapane]-$data[kode_jurusan].html' target='_blank'>Cetak</a>
	</div>
	</th></tr>
	</thead></table></div>";

echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th>Kode Mtk</th><th>Nama Mtk</th><th>SKS</th><th>Sem</th><th>Nilai</th><th>Bobot</th></tr></thead>";
	$Mtk="SELECT * FROM matakuliah WHERE Jurusan_ID='$data[kode_jurusan]' ORDER BY Kode_mtk";
	$no=0;
	$Dmtk=mysql_query($Mtk) or die ();
	while($re=mysql_fetch_array($Dmtk)){
	$no++;
	$sqlr="SELECT * FROM view_ipk WHERE NIM='$data[NIM]' AND kode_mtk='$re[Kode_mtk]'";
	$qryr= mysql_query($sqlr) or die ();
	$de=mysql_fetch_array($qryr);
echo"<tr valign='top'>
        <td class=basic>$no</td>
        <td class=basic>$re[Kode_mtk]</td>
        <td class=basic><span class=style4>$re[Nama_matakuliah]</span></td>
        <td class=basic><span class=style4>$re[SKS]</span></td>
        <td class=basic><span class=style4>$re[Semester]</span></td>
        <td class=basic><span class=style4> $de[GradeNilai] </span></td>
        <td class=basic><span class=style4> $de[BobotNilai] </span></td>
	</tr>";    
	$jmlbobot=$jmlbobot+$de['BobotNilai'];
	$Tot=$Tot+$re['SKS']; 
	$ipk=$jmlbobot/$Tot;
	$totalsks=number_format($Tot,0,',','.');
	$Bobote=number_format($jmlbobot,0,',','.');
	$Ipkne=number_format($ipk,2,',','.');
  }
	
echo"</table>";
echo"<table class='table table-bordered table-striped'>
	<tr><th>Total Keselruhan SKS</th><td class=cb><strong>$totalsks</strong></td></tr>";
echo"<tr><th>Index Prestasi Kumulatif </th>
	<td class=cb><strong>$Ipkne</strong></td></tr></table>";
	
tutup();
}
switch($_GET[PHPIdSession]){
  default:
defaultmahasiswatranskrip();
  break;   

  }
?>
