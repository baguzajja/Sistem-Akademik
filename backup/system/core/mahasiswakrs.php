<?php
function defaultmahasiswakrs(){
$tAktif	=TahunAktif();
$tahun 		= (empty($_POST[tahun]))? $tAktif : $_POST[tahun];
$semester 	= (empty($_POST[semester]))? 1: $_POST[semester];
$nim 		= $_SESSION[yapane];
$pilihsem=Semester(1, 8,$semester );
buka("Mahasiswa :: Kartu Rencana Studi (KRS)");  
echo "<form method=post action='go-mahasiswakrs.html'>
<div class='well'><div class='row-fluid'>
<div class='span6'>
	<label>TAHUN</label>
	<select name='tahun' onChange='this.form.submit()' class='span12'>
		<option value=0>- Pilih Tahun Akademik -</option>";
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
<option value=''>- Pilih Semester -</option>
$pilihsem
</select>
</div>
</div></div></form>";
if (! empty($nim)){
  $sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
  $qry=_query($sql) or die ();
	$data=_fetch_array($qry);
	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[foto]"; }
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
		
echo"<legend>DATA KRS SEMESTER $namaSemester ( $semester )
	<div class='btn-group pull-right'>
	<a class='btn btn-success' href='adkrs-mahasiswakrs-tambah-$tahun-$data[kode_jurusan]-$data[IDProg]-$semester-$nim.html'>Tambah Matakuliah</a>
	<a class='btn btn-inverse' href='cetakK-KRS-$tahun-$semester-$nim.html' target='_blank'>Cetak</a>
	</div></legend>
	<table class='table table-bordered table-striped'>
	<thead>
	<tr><th>NO</th><th>KODE</th><th>MATAKULIAH</th><th>KREDIT</th><th>AKSI</th></tr></thead>";
	$sql="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' ORDER BY KRS_ID";
	$no=0;
	$qry=_query($sql) or die ();
	while($data2=_fetch_array($qry)){
	$no++;
	$ruang=GetName("ruang","ID",$data[Ruang_ID],"Nama");
		$namaMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$data2[Jadwal_ID],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama"); 
	echo "<tr>
		<td align=center> $no</td>          
		<td>$kelompok - $data2[Kode_Mtk]</td>
		<td>$namaMtk</td>
		<td>$sksMtk SKS</td>
		<td align=center>
		<a class='btn btn-mini btn-danger' href='get-mahasiswakrs-hapusKrs-$data2[KRS_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus KRS $namaMtk ?')\">Hapus</a>
		</td>
	</tr>";
$Tot=$Tot+$sksMtk;
}
echo "<tfoot><tr><td colspan='6'><b>Jumlah Kredit Yang Ditempuh : $Tot SKS</b></td></tr></tfoot></table>";

}else{
InfoMsg("Menu KRS Mahasiswa","Anda tidak terdaftar sebagai mahasiswa di STIE YAPAN..!");
}
tutup();
}

function TambahKrs(){
buka("Mahasiswa :: Kartu Rencana Studi (KRS)"); 
$tahun=$_GET[tahun];
$nim=$_GET[NIM];
$jurusan=$_GET[jurusan];
$program=$_GET[program];
$semester=$_GET[sms];

$data = GetFields('mahasiswa', 'NIM', $nim, '*');
$PRODI=NamaProdi($data[kode_jurusan]);
$kelas=NamaKelasa($data[IDProg]);
$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
$foto=(empty($data['foto']))? "file/no-foto.jpg": "$data[foto]";   
echo"<table class='table table-striped well'>
	<thead>
	<tr><th>NAMA </th><th>: $data[Nama]</th>
	<th rowspan=4><img alt='$data[Nama]' src='$foto' width='150px' class='gambar pull-right'></th></tr>
	<tr><th>PROGRAM STUDI</th><th>: $PRODI</th></tr>
	<tr><th>KELAS</th><th>: $kelas</th></tr>
	<tr><th>DOSEN PEMBIMBING</th><th>: $pembimbingAkademik</th></tr>
	</thead></table>";
echo"<form method=post action='aksi-mahasiswakrs-simpanKrs.html'>
	<table class='table table-bordered table-striped'><thead>
	<tr><th>NO</th><th>KODE</th>
	<th>MATAKULIAH </th><th>KREDIT</th><th>PENANGGUNG JAWAB</th><th><center>Ambil</center></th></tr>";  
	$sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND Jurusan_ID='$jurusan' AND Semester='$semester' ORDER BY Kode_mtk";
	$no=0;
	$qry=_query($sql) or die ();
	while($data=_fetch_array($qry)){
	$no++;
	$sqlr="SELECT * FROM krs WHERE Tahun_ID='$tahun' AND NIM='$nim' AND semester='$semester' AND Jadwal_ID='$data[Kode_mtk]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	if ($cocok==1){ $cek="disabled"; } else { $cek=""; } 
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$data[KelompokMtk_ID],"Nama");
		$dosen1=NamaDosen($data[Penanggungjawab]); 
echo"<input type=hidden name=NIM value=$nim>
	<input type=hidden name=tahun value=$tahun>
	<input type=hidden name=kode_jurusan value=$data[Jurusan_ID]>               
	<input type=hidden name=sks value=$data[SKS]>
	<input type=hidden name=semester value=$data[Semester]>
	<input type=hidden name=kelas value=$program>
	<tr><td>$no</td>
		<td>$kelompok - $data[Kode_mtk]</td>
		<td>$data[Nama_matakuliah]</td>
		<td>$data[SKS] SKS</td>
		<td>$dosen</td>";
echo"<td align=center bgcolor=$bg>
<center><input name=Kode_mtk[] type=checkbox value=$data[Kode_mtk] $cek></center></td></tr>";
$Tot=$Tot+$data[SKS];
	} 
echo"</thead><tfoot><tr><td colspan='6'><center><b>Total : $Tot SKS</b></center></td></tr></tfoot></table>
<center>
<div class='btn-group'>
<input type=submit value=Ambil class='btn btn-success btn-large'> 
<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-mahasiswakrs.html';\">
</div>                                          
</center>";
echo "</form>";
tutup();     
}
switch($_GET[PHPIdSession]){

  default:
    defaultmahasiswakrs();
  break;   

  case "tambah":
   TambahKrs();
  break;
        
  case "hapusKrs":
    _query("DELETE FROM krs WHERE KRS_ID='$_GET[id]'");
	PesanOk("Hapus KRS","KRS Berhasil Dihapus","go-mahasiswakrs.html");   
  break;    
    
  case "simpanKrs":
		$kdmk		= $_POST['Kode_mtk'];  
	$jumlah=count($kdmk);
	for($i=0; $i < $jumlah; ++$i){
	$cek=_num_rows(_query("SELECT * FROM krs WHERE NIM='$_POST[NIM]' AND Tahun_ID='$_POST[tahun]' AND Jadwal_ID='$kdmk[$i]'"));
	}
	if ($cek > 0){
	buka("Tambah KRS");
	echo ErrorMsg("Opps.. !!","Data Anda Sudah Ada, Program Mencoba Entrykan Data yang Sama.");
	echo "<center><a class='btn btn-danger' href='javascript:history.back()'><i class='icon-undo'></i> Kembali</a></center>";
	tutup();
        } else {       
          for($i=0; $i < $jumlah; ++$i)
          {     
         $insert= _query("INSERT INTO krs(NIM,Tahun_ID,Jadwal_ID,semester,kelas,SKS) 
				VALUES('$_POST[NIM]', '$_POST[tahun]', '$kdmk[$i]','$_POST[semester]','$_POST[kelas]', '$_POST[sks]')");	  
         }
	PesanOk("Tambah KRS","KRS Berhasil Disimpan","go-mahasiswakrs.html"); 
       }
  break;      
}
?>