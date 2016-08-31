<?php
defined('_FINDEX_') or die('Access Denied');
$id = $_REQUEST['id'];

	$sql="SELECT * FROM mahasiswa WHERE NIM='$id'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
if($r['foto']!=''){
		if (file_exists('media/images/foto_mahasiswa/'.$r[foto])){
			$foto ="<img src='media/images/foto_mahasiswa/medium_$r[foto]' width='70%' alt='$r[Nama]'>";
		} elseif (file_exists('media/images/'.$r[foto])){
			$foto ="<img src='media/images/$r[foto]' width='70%' alt='$r[Nama]'>";
		}else{
			$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' width='70%'>";
		}
}else{
	$foto ="<img src='themes/img/avatar.jpg' alt='$r[Nama]' width='70%'>";
}

	
	$NamaProdi=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$gender=($r[Kelamin]=='L') ? "Laki - Laki": "Perempuan";
	$prodi = GetFields('jurusan', 'kode_jurusan', $r['kode_jurusan'], '*');
echo"<div class='widget widget-table'>
	<div class='widget-header'>	
		<h3><i class='icon-user'></i> KETERANGAN TENTANG DIRI MAHASISWA ( BUKU INDUK MAHASISWA )</h3>			
	</div> 	
	<div class='widget-content'>";
echo"<div class='row-fluid'>
	<div class='span8'>
		<table class='table table-striped table-bordered table-highlight responsive'>                            
		<tr>
		<td>NAMA LENGKAP</td>
		<td>:</td>
		<td><strong> $r[Nama]</strong></td>
		</tr>                    
		<tr>
		<td>NIM</td>
		<td>:</td>
		<td><strong>$r[NIM] </strong></td>
		</tr>
		<tr><td>PROGRAM STUDI </td><td>:</td><td><strong> $NamaProdi</strong></td></tr>
			<tr>
				<td width='30%'><i class='icon-file'></i> Tempat & Tanggal Lahir</td>
				<td>:</td><td>$r[TempatLahir], $TglLhr</td>
			</tr>
			<tr>
				<td><i class='icon-file'></i> Agama</td>
				<td>:</td><td>$Agama</td>
			</tr>
			<tr>
				<td><i class='icon-file'></i> Alamat </td>
				<td>:</td><td>$r[Alamat], RT: $r[RT] - RW: $r[RW]. $r[KodePos]. $r[Kota] ($r[Propinsi]-$r[Negara])</td> 	
			</tr>
		</table>
	</div>
	<div class='span4'>
		<center>$foto</center>
	</div>
</div>";
echo"<table class='table table-striped table-bordered table-highlight responsive'>
					<thead>
						<tr><th colspan='2'>DATA PRIBADI</th></tr>
					</thead>
					<tbody> ";
if($prodi[jenjang]=='S1'){
					echo"<tr>
							<td><i class='icon-file'></i> Nama SMK / SMA / MA </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[AsalSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>SURAT TANDA TAMAT BELAJAR / IJAZAH</b></td></tr>";
}else{
echo"<tr>
							<td><i class='icon-file'></i> Nama Perguruan Tinggi </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[AsalSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>IJAZAH S1 </b></td></tr>";

}
	$Tahun=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
	$NamaTahun=explode(" ",$Tahun);
echo"<tr>
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
							<td> : &nbsp;&nbsp;&nbsp; $NamaTahun[2]</td>
							</tr>
					</tbody>
				</table>
	</div> 
</div>";
?>
