<?php
function defaultregistrasi(){
buka("BAAK :: Registrasi Ulang Mahasiswa"); 
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$nim 		= (empty($_POST[NIM]))? '' : $_POST[NIM];
echo "<form method=post action='go-registrasimahasiswa.html'>
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
 if (! empty($nim) AND !empty($tahun)){
$sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
  $no=0;
  $qry=_query($sql) or die ();
  $ab=_num_rows($qry);
  if ($ab > 0){  
$data=_fetch_array($qry);
	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
	$jurusan=$data[kode_jurusan];
	$Identitas=$data[identitas_ID];
	$NIM=$data[NIM];
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
 echo"<table class='table table-bordered table-striped'><thead>
	<tr><th>No</th><th>Tahun Akademik</th><th>Tanggal Registrasi</th><th>Status</th><th>Registrasi</th></tr></thead>";
	$sql="SELECT * FROM tahun t1 WHERE t1.Tahun_ID='$tahun' AND t1.Aktif='Y'";
	$no=0;
	$qry=_query($sql) or die ();
	while($data=_fetch_array($qry)){
	$no++;
	$sqlr="SELECT * FROM regmhs WHERE Tahun='$tahun' AND NIM='$nim' AND aktif='Y'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$d=_fetch_array($qryr);
	if ($cocok > 0){    
	$bg="bfbfbf";
	$Aktif='Y';
	$tahun=$d[Tahun];
	$disable='disabled';
	$tanggal=tgl_indo($d[tgl_reg]);
	}
	else{
	$bg="FFFFFF";
	$Aktif='N';
	$tahun=$data[Tahun_ID];
	$disable='';
	$tanggal=date("d-M-Y");
	}      
$sttus = ($Aktif == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';  
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
echo"<form name=form1 method=post  action='aksi-registrasimahasiswa-InputRegMhs.html'>
	<input type=hidden name=NIM value='$nim'>  
	<input type=hidden name=tahun value='$tahun'>
	<input type=hidden name=Jurusan value='$jurusan'> 
	<input type=hidden name=Identitas value='$Identitas'> 
	<tr><td align=center bgcolor=$bg> $no</td>
	<td bgcolor=$bg>$NamaTahun</td>
	<td align=center bgcolor=$bg>$tanggal</td> 
	<td align=center bgcolor=$bg>$sttus</td>
	<td align=center bgcolor=$bg >
<center>
<div class='btn-group'>$d[ID_Reg]
	<input class='btn btn-success' type=submit value=Registrasi $disable>
	<input type=button value='Hapus' class='btn btn-danger' onclick=\"window.location.href='get-registrasimahasiswa-delregmhs-$d[ID_Reg].html';\">
</div>	
</center>

	</td>";                      
	}  
echo"</tr></table></form>";
}else{
ErrorMsg("Opps.. !!","Tidak Ditemukan data Mahasiswa dengan NIM <b>$_POST[NIM]</b>");
 
  }
}else{
InfoMsg("Menu Registrasi Ulang Mahasiswa","Masukkan NIM Mahasiswa Untuk melakukan Proses Registrasi Ulang..!");
}
tutup();
}

function InputRegMhs(){
$cek=_num_rows(_query("SELECT * FROM regmhs WHERE Tahun='$_POST[tahun]' AND NIM='$_POST[NIM]'"));
	if ($cek > 0){
	buka("Proses :: Registrasi Ulang Mahasiswa"); 
	echo ErrorMsg("Opps.. !!","Data REGISTRASI Sudah ada dalam database.");
	echo "<center><a class='btn btn-danger' href='javascript:history.back()'><i class='icon-undo'></i> Kembali</a></center>";
	tutup();
	}else{
$tglsekarang=date("Ymd");    
$insert= _query("INSERT INTO regmhs(Tahun,Identitas_ID,Jurusan_ID,NIM,tgl_reg,aktif) VALUES('$_POST[tahun]','$_POST[Identitas]','$_POST[Jurusan]','$_POST[NIM]','$tglsekarang','Y')");
PesanOk("Registrasi Ulang Mahasiswa","Registrasi Ulang Mahasiswa Berhasil Diproses","go-registrasimahasiswa.html");
  }  
}
function delregmhs(){
$id= $_REQUEST['id'];
$hapus=_query("DELETE FROM regmhs WHERE ID_Reg='$id'");
PesanOk("Hapus Data Registrasi","Data Registrasi Berhasil Dihapus","go-registrasimahasiswa.html");	
}
switch($_GET[PHPIdSession]){

  default:
defaultregistrasi(); 
  break;

  case "InputRegMhs":
InputRegMhs();	
  break;  

  case "delregmhs":
delregmhs(); 
  break;  
}
?>
