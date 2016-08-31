<?php
function defaultBukuInduk(){
buka("BUKU Induk");
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>	<thead><tr>
<th>No</th>
<th>Nama</th>
<th>NIM</th>
<th>T. Tgl Lahir</th>
<th>Gender</th>
<th>Alamat</th>
<th>Prodi</th>
<th>Konsentrasi</th>
<th></th></tr></thead><tbody>"; 
	$sql="SELECT * FROM mahasiswa WHERE aktif='Y' AND NIM!='' ORDER BY NIM DESC";
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
echo"<tr>
	<td>$no</td>
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
				<a class='btn btn-mini iframe' href='detail-DetailBukuInduk-$r[NIM].html'>Detail</a>
			<a class='btn btn-mini btn-inverse iframe' href='pdf-induk-$r[NIM].html' target='_blank' title='CETAK BUKU INDUK MAHASISWA'>Cetak</a>
			</div>
		</center>
	</td>
</tr>";        
	} 
echo"</tbody></table>";
tutup();      
}


switch($_GET[PHPIdSession]){

  default:
    defaultBukuInduk();
  break;  

}
?>
