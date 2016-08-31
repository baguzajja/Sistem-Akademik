<?php
switch($_GET[PHPIdSession]){

  default:
  buka("Kelas Ajar Dosen");
  echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th>PRODI</th><th>KODE</th><th>MATAKULIAH</th><th>SKS</th><th>SMSTR</th><th>KELAS</th><th>HARI</th><th>Mulai</th><th>Selesai</th><th>Dosen</th><th>Absen</th></tr></thead>";  
	$sql="SELECT * FROM view_ajar_dosen WHERE username='$_SESSION[yapane]' ORDER BY Kode_Mtk";
	$no=0;
	$qry=mysql_query($sql) or die ();
	while($data=mysql_fetch_array($qry)){
	$no++;
            
	echo"<tr><td>$no</td>
		<td>$data[nama_jurusan]</td>
		<td>$data[Kode_Mtk]</td>
		<td>$data[nama_matakuliah]</td>
		<td align=center>$data[sks]</td>
		<td align=center>$data[semester]</td>
		<td align=center>$data[Kelas]</td>
		<td>$data[Hari]</td>
		<td align=center>$data[Jam_Mulai]</td>
		<td align=center>$data[Jam_Selesai]</td>
		<td>$data[nama_lengkap], $data[gelar]</td>
		<td><a class=s href='AbDos-AbsensiDosen-$data[Tahun_ID]-$data[Kode_Jurusan]-$data[Program_ID]-$data[Kode_Mtk]-$data[Kelas].html' target='_blank'><center><img src=../img/printer.GIF></center></a>
	</td></tr>";
	}
  echo"</table>";
   tutup();
  break;

}
?>
