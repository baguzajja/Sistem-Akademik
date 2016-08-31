<?php
function defaultlevelregistrasi(){
buka("BAAK :: Registrasi Ulang Mahasiswa");  
echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
		<form  method=post  action='aksi-levelakademikregmhs-CariMahasiswa.html'>
			<tr>
				<th>
					<div class='input-prepend input-append'>
						<span class='add-on'>Tahun</span>
						<input type=text name=tahun size=5>
						<span class='add-on'>NIM</span>
						<input type=text name=NIM>
						<input type=submit class='btn btn-success' value=Tampilkan>
					</div>
				</th>
			</tr>
			<tr><th></th></tr>
		</form></thead>
	</table></div>";
tutup();
}
function CariMahasiswa(){
buka("Administrator :: Registrasi Ulang Mahasiswa");
    $edit=_query("SELECT * FROM karyawan WHERE username='$_SESSION[yapane]'");
    $data=_fetch_array($edit);  
	$sql="SELECT * FROM view_form_mhsakademik WHERE kode_jurusan='$data[kode_jurusan]' AND NIM='$_POST[NIM]'";
  $no=0;
  $qry=_query($sql)  or die ();
  $ab=_num_rows($qry);
  $data1=_fetch_array($qry);
	if (empty($data1['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data1[foto]"; }
  $no++; 
  if ($ab > 0){    
echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<thead>
	<form  method=post  action='aksi-akademikkrs-cari.html'>
	<input type=hidden name=kode_jurusan value='$data1[kode_jurusan]'>
	<tr>
		<th colspan='3'>
			<div class='input-prepend input-append'>
			<span class='add-on'>Tahun</span>
				<input type=text name=tahun value='$_POST[tahun]'>
				<span class='add-on'>NIM</span>
				<input type=text name=NIM value='$_POST[NIM]'>
				<input type=submit class='btn btn-success' value=Refresh>
			</div>
		</th>
	</tr>
	<tr><th>Nama</th><th> $data1[nama_lengkap]</th>
	<th rowspan=4><img alt='$data1[nama_lengkap]' src='$foto' width='150px' class='pull-right'></th></tr>
	<tr><th>Jurusan</th><th>$data1[kode_jurusan] - $data1[nama_jurusan]</th></tr>
	<tr><th>Kelas</th><th>$data1[nama_program]</th></tr>
	<tr><th>Pembimbing Akademik</th><th>$data1[pembimbing], $data1[Gelar]</th></tr>
	</form>
	<tr><th colspan='3'></th></tr>
	</thead></table></div>";
 echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>No</th><th>Tahun Akd</th><th>Tanggal Reg</th><th>Aktif</th><th>Registrasi</th><th>Hapus</th></tr></thead>";
	$sql="SELECT * FROM tahun t1 WHERE t1.Tahun_ID='$_POST[tahun]' AND Jurusan_ID='$data[kode_jurusan]' AND Program_ID='$data1[ID]' AND t1.Aktif='Y'";
	$no=0;
	$qry=_query($sql) or die ();
	while($data=_fetch_array($qry)){
	$no++;
	$sqlr="SELECT * FROM regmhs WHERE Tahun='$_POST[tahun]' AND NIM='$_POST[NIM]' AND aktif='Y'";
	$qryr= _query($sqlr);
	$d=_fetch_array($qryr);
	$cocok=_num_rows($qryr);
	if ($cocok==1){    
	$bg="bfbfbf";
	$Aktif='Y';
	$disable='disabled';
	}
	else{
	$bg="FFFFFF";
	$Aktif='N';
	$disable='';
	}        
echo"<form name=form1 method=post  action='aksi-levelakademikregmhs-InputRegMhs.html'>
	<input type=hidden name=NIM value='$_POST[NIM]'>  <input type=hidden name=NIM value='$_POST[NIM]'>
	<input type=hidden name=tahun value='$_POST[tahun]'>
	<input type=hidden name=Jurusan_ID value='$data1[kode_jurusan]'> <input type=hidden name=Identitas_ID value='$data[Identitas_ID]'>
	<tr><td align=center bgcolor=$bg> $no</td>
	<td bgcolor=$bg>$data[Tahun_ID]</td>";
echo "<td align=center bgcolor=$bg>";echo date("d-M-Y");
echo "</td> 
	<td align=center bgcolor=$bg>$Aktif</td>
	<td align=center bgcolor=$bg >
	<center>
	<input class='btn btn-success' type=submit value=Registrasi $disable></center></td> 
	<td align=center><a href='get-levelakademikregmhs-delregmhs-$d[ID_Reg].html'><img src=../img/del.GIF></a></td>";                      
	}  
echo"</tr></table></form>";
	}else{
echo "<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
		<thead>
		<form  method=post  action='aksi-levelakademikregmhs-CariMahasiswa.html'>
			<tr>
				<th>
					<div class='input-prepend input-append'>
						<span class='add-on'>Tahun</span>
						<input type=text name=tahun value='$_POST[tahun]'>
						<span class='add-on'>NIM</span>
						<input type=text name=NIM value='$_POST[NIM]'>
						<input type=submit class='btn btn-success' value=Tampilkan>
					</div>
				</th>
			</tr>
			<tr><th></th></tr>
		</form></thead>
	</table></div>";
echo ErrorMsg("Opps.. !!","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
 	
	}
tutup();
}
function InputRegMhs(){
$cek=mysql_num_rows(mysql_query("SELECT * FROM regmhs WHERE Tahun='$_POST[tahun]' AND NIM='$_POST[NIM]'"));
	if ($cek > 0){
	buka("Proses :: Registrasi Ulang Mahasiswa"); 
	echo ErrorMsg("Opps.. !!","Data REGISTRASI Sudah ada dalam database.");
	echo "<center><a class='btn btn-danger' href='javascript:history.back()'><i class='icon-undo'></i> Kembali</a></center>";
	tutup();
	}else{
  $tglsekarang=date("Ymd");    
  $query = "INSERT INTO regmhs(Tahun,Identitas_ID,Jurusan_ID,NIM,tgl_reg,aktif) VALUES('$_POST[tahun]','$_POST[Identitas_ID]','$_POST[Jurusan_ID]','$_POST[NIM]','$tglsekarang','Y')";
  mysql_query($query);
	buka("Proses :: Registrasi Ulang Mahasiswa"); 
	echo SuksesMsg("Registrasi Ulang Berhasil ..!!","");
	echo "<center><a class='btn btn-success' href='go-levelakademikregmhs.html'><i class='icon-undo'></i> OK</a></center>";
	tutup();  
  }  
}
function delregmhs(){
	$edit=mysql_query("DELETE FROM regmhs WHERE ID_Reg='$_GET[id]'");
	$r=mysql_fetch_array($edit);
	buka("Proses :: Hapus Data Registrasi Mahasiswa"); 
	echo SuksesMsg("Data Registrasi Ulang Berhasil Di Hapus !!","");
	echo "<center><a class='btn btn-success' href='go-levelakademikregmhs.html'><i class='icon-undo'></i> OK</a></center>";
	tutup();	
}
switch($_GET[PHPIdSession]){

  default:
defaultlevelregistrasi();   
  break;
    
  case "CariMahasiswa":
CariMahasiswa();
  break;

  case "InputRegMhs":
InputRegMhs();
  break;  
   
  case "delregmhs":
   delregmhs();  
  break;  
   
}
?>
