<?php
$identitas = $_REQUEST['id'];
$cap="<table align=center border=1px><th colspan='10'>DATA DOSEN STIE YAPAN - SURABAYA</th>";//CAPTION OF THIS REPORT
$title="<tr><td><b>NO</b></td>
	<td><b>NIDN</b></td>
	<td><b>NAMA</b></td>
	<td><b>TTL</b></td>
	<td><b>ALAMAT</b></td>
	<td><b>TELEPHONE</b></td>
	<td><b>HANDPHONE</b></td>
	<td><b>EMAIL</b></td>
	<td><b>JABATAN</b></td>
	<td><b>SK PENGANGKATAN</b></td>
	</tr>";
$no=0;
$tmp_per_res=mysql_query("SELECT * FROM dosen WHERE Identitas_ID='$identitas' ORDER BY nama_lengkap ASC");
while($row=mysql_fetch_array($tmp_per_res,MYSQL_BOTH)){
$tglahir=tgl_indo($row['TanggalLahir']);
$gelar=$row['Gelar'];
$jabatan=NamaJabatan($row['Jabatan_ID']);
$no++;
$body.="<tr><td>".$no ."</td>
		<td>".$row['NIDN']."</td>
		<td>".$row['nama_lengkap'].",".$gelar."</td>
		<td>".$row['TempatLahir'].",".$tglahir."</td>
		<td>".$row['Alamat'].".".$row['Kota']."-".$row['Propinsi']."</td>
		<td>".$row['Telepon']."</td>
		<td>".$row['Handphone']."</td>
		<td>".$row['Email']."</td>
		<td>".$jabatan."</td>
		<td>".$row['Skpengankatan']."</td>
</tr>";
}
echo $cap.$title.$body."</table>";					
?>	
	
	
	