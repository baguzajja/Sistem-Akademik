<?php
function defaultAlumni(){
buka("DATA ALUMNI");
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>	<thead><tr>
<th>No</th>
<th>Angkatan</th>
<th>Nama</th>
<th>NIM</th>
<th>T. Tgl Lahir</th>
<th>Gender</th>
<th>Alamat</th>
<th>Prodi</th>
<th>Konsentrasi</th>
<th></th></tr></thead><tbody>"; 
	$sql="SELECT * FROM mahasiswa WHERE NIM!='' AND LulusUjian='Y' ORDER BY NIM DESC";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){
	$NamaProdi=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$NamaKonsentrasi=NamaKonsentrasi($r['Kurikulum_ID']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	if ($r[Kelamin]=='L'){
	$gender="Laki - Laki";
	}else{
	$gender="Perempuan";
	}
	$no++;
	$Tahun=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
	$NamaTahun=explode(" ",$Tahun);
echo"<tr>
	<td>$no</td>
	<td>$NamaTahun[2]</td>
	<td>$r[Nama]</td>
	<td>$r[NIM]</td>
	<td>$r[TempatLahir] - $TglLhr</td>
	<td>$gender</td>
	<td>$r[Alamat] - $r[Kota]</td>
	<td>$NamaProdi</td>
	<td>$NamaKonsentrasi</td>
	<td>
		<center>
			<div class='btn-group'>
		<a class='btn btn-mini' href='get-alumni-detail-$r[NIM].html'>Detail</a>

			</div>
		</center>
	</td></tr>";        
	} 
echo"</tbody></table>";
tutup();      
}

function detailAlumni(){
buka("Detail Alumni");
	$sql="SELECT * FROM mahasiswa WHERE NIM='$_GET[id]'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
	if (empty($r['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[Foto]"; }
	$NamaProdi=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$Tgllulus=Tgl_indo($r['TanggalLulus']);
	if ($r[Kelamin]=='L'){
	$gender="Laki - Laki";
	}else{
	$gender="Perempuan";
	}	
	echo"<table class='table table-striped'><thead>
	<tr><th colspan=4> DETAIL MAHASISWA <div class='btn-group pull-right'>
	<a class='btn btn-mini btn-danger' href='go-alumni.html'><i class='icon-undo'></i>Kembali</a>
	<a class='btn btn-mini btn-inverse' href='cetak-CetakBukuInduk-$r[NIM].html' target='_blank'><i class='icon-print'></i>Cetak</a>
	</div></th></tr>                               
	<tr>
	<td>NAMA LENGKAP</td>
	<td>:</td>
	<td><strong> $r[Nama]</strong></td>
	<td rowspan=3><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
	<tr>
	<td>NIM</td>
	<td>:</td>
	<td><strong>$r[NIM] </strong></td>
	</tr>
	<tr><td>PROGRAM STUDI </td><td>:</td><td><strong> $NamaProdi</strong></td></tr>
	<tr><td></td><td></td><td></td><td></td></tr>
	
	</thead></table>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='panel-content'>
				<table class='table'>
					<thead>
						<tr><th colspan='2'>DATA PRIBADI</th></tr>
					</thead>
					<tbody>
                            <tr>
							<td width='30%'><i class='icon-file'></i> Tempat & Tanggal Lahir</td>
							<td> : &nbsp;&nbsp;&nbsp; $r[TempatLahir], $TglLhr</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Agama</td>
							<td> : &nbsp;&nbsp;&nbsp;$Agama</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Alamat </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Alamat], RT: $r[RT] - RW: $r[RW]. $r[KodePos]. $r[Kota] ($r[Propinsi]-$r[Negara])</td> 	
							</tr>
							<tr>
							<td><i class='icon-file'></i> Nama SMK / SMA / MA </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[AsalSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>SURAT TANDA TAMAT BELAJAR / IJAZAH</b></td></tr>
							<tr>
							<td><i class='icon-file'></i> TAHUN</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[TahunLulus]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> NOMOR</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[NilaiSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>DI TERIMA DI STIE YAPAN </b></td></tr>
							<tr>
							<td><i class='icon-file'></i> PROGRAM STUDI</td>
							<td> : &nbsp;&nbsp;&nbsp;$NamaProdi</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> TAHUN</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[TahunLulus]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i>NO SKL</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[skl]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> TANGGAL LULUS</td>
							<td> : &nbsp;&nbsp;&nbsp;$Tgllulus</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> IPK</td>
							<td> : &nbsp;&nbsp;&nbsp$r[IPK]</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
    defaultAlumni();
  break;  
	  
  case "detail":
    detailAlumni();
  break;
}
?>
