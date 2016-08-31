<?php
$id = $_REQUEST['id'];
$prodi=GetName("jurusan","kode_jurusan",$id,"nama_jurusan");
$cap="<table align=center border=1px><th colspan='16'>DATA MAHASISWA :: PROGRAM STUDI $prodi</th>";//CAPTION OF THIS REPORT
$title="<tr><td><b>NO</b></td>
	<td><b>NIM</b></td>
	<td><b>NO REGISTER</b></td>
	<td><b>NAMA</b></td>
	<td><b>TTL</b></td>
	<td><b>TAHUN AKADEMIK</b></td>
	<td><b>KONSENTRASI</b></td>
	<td><b>KELAS</b></td>
	<td><b>JENIS KELAMIN</b></td>
	<td><b>AGAMA</b></td>
	<td><b>ALAMAT</b></td>
	<td><b>PROPINSI</b></td>
	<td><b>NEGARA</b></td>
	<td><b>TELEPHONE</b></td>
	<td><b>HANDPHONE</b></td>
	<td><b>EMAIL</b></td>
	</tr>";
$no=0;
$tmp_per_res=mysql_query("select * from mahasiswa where kode_jurusan='$id'");
while($row=mysql_fetch_array($tmp_per_res,MYSQL_BOTH)){
$tglahir=tgl_indo($row['TanggalLahir']);
$konsentrasi=NamaKonsentrasi($row['Kurikulum_ID']);
$kelas=NamaKelasa($row['IDProg']);
$Agama=NamaAgama($row['Agama']);
$kelamin = ($row['Kelamin']=='L')? 'Laki-Laki' : 'Perempuan';
$no++;
$body.="<tr><td>".$no ."</td>
		<td>".$row['NIM']."</td>
		<td>".$row['NoReg']."</td>
		<td>".$row['Nama']."</td>
		<td>".$row['TempatLahir'].",".$tglahir."</td>
		<td>".$row['Angkatan']."</td>
		<td>".$konsentrasi."</td>
		<td>".$kelas."</td>
		<td>".$kelamin."</td>
		<td>".$Agama."</td>
		<td>".$row['Alamat']."</td>
		<td>".$row['Propinsi']."</td>
		<td>".$row['Negara']."</td>
		<td>".$row['Telepon']."</td>
		<td>".$row['Handphone']."</td>
		<td>".$row['Email']."</td></tr>";
}
echo $cap.$title.$body."</table>";					
?>	
	
	
	