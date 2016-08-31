<style type="text/css">
<!--
table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:left;
}

table.month th {
    padding:5px;
	background-color:#208bbd;
    color:#fff;
	text-align:center;
}
table.month th.head{
	background-color:#EEE;
	text-align:center;
	color:#444444;
}
.img { border:1px solid #ddd; padding: 5px; }
-->
</style>
<?php
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='50mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
HeaderKops();
	$sql="SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
if($r['foto']!=''){
		if (file_exists('media/images/foto_dosen/'.$r[foto])){
			$foto ="<img src='media/images/foto_dosen/medium_$r[foto]' style='width: 92%;' alt='$r[nama_lengkap]'>";
		} elseif (file_exists('media/images/'.$r[foto])){
			$foto ="<img src='media/images/$r[foto]' style='width: 92%;' alt='$r[nama_lengkap]'>";
		}else{
			$foto ="<img src='themes/img/avatar.jpg' alt='$r[nama_lengkap]' style='width: 92%;'>";
		}
}else{
	$foto ="<img src='themes/img/avatar.jpg' alt='$r[nama_lengkap]' style='width: 92%;'>";
}

	$NamaProdi=NamaProdi($r['jurusan_ID']);
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$StatusDosen=StatusDosen($r['StatusKerja_ID']);
	$Jabatan=NamaJabatan($r['Jabatan_ID']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	$TglGabung=Tgl_indo($r['TglBekerja']);
	if ($r[Kelamin]=='L'){
	$gender="Laki - Laki";
	}else{
	$gender="Perempuan";
	}	
echo"<table class='month' style='width: 100%;' cellspacing='5px'>
		<tr><th colspan='2'><b>BIO DATA DOSEN</b></th></tr>
		<tr>
			<td style='width: 80%;'>
				<table style='width: 100%; color:#444;' cellspacing='5px'>    
						<tr>
						<td style='width: 30%;'>NAMA LENGKAP</td>
						<td style='width: 5%; text-align: center;'>:</td>
						<td style='width: 65%;'><strong>$r[nama_lengkap] ,$r[Gelar]</strong></td>
						</tr>                    
						<tr>
						<td>NIDN</td>
						<td style='width: 5%; text-align: center;'>:</td>
						<td><strong>$r[NIDN] </strong></td>
						</tr>
						<tr>
							<td>Tempat & Tanggal Lahir </td>
							<td style='width: 5%; text-align: center;'>:</td>
							<td><strong> $r[TempatLahir], $TglLhr</strong></td>
						</tr>
						<tr>
							<td>Agama </td>
							<td style='width: 5%; text-align: center;'>:</td>
							<td><strong> $Agama</strong></td>
						</tr>
						<tr>
							<td>Alamat </td>
							<td style='width: 5%; text-align: center;'>:</td>
							<td><strong> $r[Alamat] . $r[Kota] ($r[Propinsi]-$r[Negara])</strong></td>
						</tr>
						<tr>
							<td>Tlp / Hp  </td>
							<td style='width: 5%; text-align: center;'>:</td>
							<td><strong> $r[Telepon] / $r[Handphone]</strong></td>
						</tr>
				</table>
			</td>
			<td style='width: 20%;text-align: center; valign: middle;' valign='middle'>
				$foto
			</td>
		</tr> 
</table>
<br><br>
<table class='month' style='width: 100%;' cellspacing='5px'>
<tr><td style='width: 100%;'>
				<table class='table' style='width: 100%;' cellspacing='5px'>
					<thead>
						<tr><th colspan='2'>DATA AKADEMIK</th></tr>
					</thead>
					<tbody>
                        
							<tr>
							<td style='width: 50%;'><i class='icon-file'></i> Tanggal Bergabung</td>
							<td style='width: 50%;'> : &nbsp;&nbsp;&nbsp;$TglGabung</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Jabatan</td>
							<td> : &nbsp;&nbsp;&nbsp;$Jabatan</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Prodi Homebase</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Homebase]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Status Dosen</td>
							<td> : &nbsp;&nbsp;&nbsp;$StatusDosen</td>
							</tr>
							<tr><td colspan='2'><b>RIWAYAT PENDIDIKAN DOSEN </b></td></tr>
							"; 
	$tampil=_query("SELECT * FROM dosenpendidikan WHERE DosenID='$r[dosen_ID]' ORDER BY DosenPendidikanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){
	$tgl=tgl_indo($ra[TanggalIjazah]);                        
	$jenjang=get_jenjang($ra[JenjangID]);                        
	$Perting=get_Pt($ra[PerguruanTinggiID]);                        
echo "<tr>
		<td>$no :: Jenjang : $jenjang&nbsp;&nbsp; Gelar : $ra[Gelar]</td>
		<td> : &nbsp;&nbsp;&nbsp; Lulus : $tgl - Bidang Studi : $ra[BidangIlmu] - Di : $ra[NamaNegara]</td>
	</tr>";
	$no++;
}
echo "<tr><td colspan='2'><b>RIWAYAT PEKERJAAN DOSEN </b></td></tr>
"; 
	$tampil=_query("SELECT * FROM dosenpekerjaan WHERE DosenID='$r[dosen_ID]' ORDER BY DosenPekerjaanID");
	$no=1;
	while ($ra=_fetch_array($tampil)){                        
echo "<tr>
		<td>$no :: $ra[Jabatan]&nbsp;&nbsp; di : $ra[Institusi]</td>
		<td> : &nbsp;&nbsp;&nbsp; Alamat : $ra[Alamat] - $ra[Kota]. $ra[Kodepos] Telp : $ra[Telepon] Fax : $ra[Fax]</td>
	</tr>";
	$no++;
}	
echo "<tr><td colspan='2'><b>DATA PENELITIAN DOSEN </b></td></tr>";
$tampil=_query("SELECT * FROM dosenpenelitian WHERE DosenID='$_GET[id]' ORDER BY DosenPenelitianID");
	$no=1;
	while ($pe=_fetch_array($tampil)){
	$tglBuat=tgl_indo($pe[TglBuat]); 
echo "<tr>
		<td>$no :: $pe[NamaPenelitian]</td>
		<td> : &nbsp;&nbsp;&nbsp; Tanggal :$tglBuat</td>
	</tr>";	
	$no++;
	}
echo "</tbody></table>

</td></tr>
</table>";
//$Kaprodi=_fetch_array(_query("SELECT * FROM karyawan WHERE Jabatan='18' AND kode_jurusan='$d[kode_jurusan]'"));
echo"<br><br><br>";  
FooterPdf();
echo"</page>";
?>