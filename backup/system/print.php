<?php 
session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../librari/koneksi.php";
include "../librari/library.php";
include "../librari/fungsi_combobox.php";
include "../librari/lib.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="shortcut icon" href="../favicon.ico" />
<head>
  <title><?php JudulPrint();?></title>

  <style type="text/css">
	<?php 
	include "printer.css"; 
	?>
  </style>
</head>
<body onLoad="javascript:window.print()">
<?php
function DefaultPrint(){}
function HeaderPrint(){
  $sql="SELECT * FROM identitas WHERE Identitas_ID='$_SESSION[Identitas]'";
  $qry=_query($sql) or die ();
  $t=_fetch_array($qry);
echo"<div class='header'>
<table class='basic' width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
	<td align='right'><img class='logo' width='130pt' src='../img/logo.png'></td>
    <td>
		<h2>$t[Nama_Identitas]</h2>
		<h2>( STIE YAPAN )</h2>
		<h3>$t[KodeHukum]</h3>
		<h2>TERAKREDITASI &rdquo; B &rdquo;</h2>
		<p>E-mail : $t[Email]. Homepage : $t[Website]</p>
		
	</td>
  </tr>
</table>
	<div class='attr'>
<hr/>
		Kampus : $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota]
<hr/>
	</div>

</div>";
}
function HeaderPrints2(){
  $sql="SELECT * FROM identitas WHERE Identitas_ID='$_SESSION[Identitas]'";
  $qry=_query($sql) or die ();
  $t=_fetch_array($qry);
echo"<div class='header'>
<table class='basic' width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
	<td align='right'><img class='logo' width='130pt' src='../img/logo.png'></td>
    <td>
		<h2>$t[Nama_Identitas]</h2>
		<h2>( STIE YAPAN )</h2>
		<h2>PROGRAM PASCASARJANA (S-2)</h2>
		<h2>PROGRAM STUDI MAGISTER MANAJEMEN</h2>
		<h3>SK. Mendikbud RI No. 347/E/O/2012</h3>
		<p>E-mail : $t[Email]. Homepage : $t[Website]</p>
	</td>
  </tr>
</table>
	<div class='attr'>
<hr/>
		Kampus : $t[Alamat1] Telp: $t[Telepon] Fax : $t[Fax] .$t[Kota]
<hr/>
	</div>

</div>";
}
function DetailPembayaran(){
 HeaderPrint();
 global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $NREG=$r[RegID];
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
 $no++;
echo"<div class='panel panel-content'>
	<center><h2>DETAIL PEMBAYARAN MAHASISWA  #$r[NIM]</h2> </center>
<table width='100%'>
    <tr>
      <td width='50%' align='left'>
		<table id=tablemodul1>
			<tr>
			  <td><strong>Nama </strong></td>
			  <td><strong>:  $r[Nama]</strong></td>    
			</tr>
			<tr>
			  <td><strong>NIM </strong></td>
			  <td><strong>:  $r[NIM]</strong></td>    
			</tr>
		  </table>
	  </td>
      <td width='50%'>
		<table id=tablemodul1>
			<tr>
			  <td class=basic><strong>PROGRAM STUDI</strong></td>
			  <td class=basic><strong> $r[JenjangID] - $Prodi</strong></td>
			</tr>
		</table>
	  </td>    
    </tr>
</table>";
	echo"<center>
		<table id='tablestd'><thead>
		<tr><th width='20'>No</th><th>Tanggal</th><th>Keterangan</th><th>Jumlah Bayar</th></tr>
		</thead><tbody>";
$h = "SELECT * FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi='17' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
$kl = _query($h);
while ($b = _fetch_array($kl)) {	
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);	
		echo"<tr>
			<td>1</td>
			<td>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
		</tr>";
$Bayar=$b[Debet];
$TotB=$TotB+$b[Debet];
}
$TotalBayar=digit($TotB);
$kekurngan=	$r[TotalBiaya] - $TotB;	
$Totalkekurngan=digit($kekurngan);	
$tglCetak	= tgl_indo(date("Y m d"));
echo"<tfoot>
	<tr><td colspan='3'><b>Total Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$TotalBayar</span></b></td></tr>
	<tr><td colspan='3'><b>Kekurangan Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$Totalkekurngan</span></b></td></tr>
	</tfoot>
	</tbody></table></div></center>";
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Dicetak : $tglCetak</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>By.  $_SESSION[Nama] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";	
}
function cetakTransaksi(){

$id=$_GET[id];
$h = "SELECT * FROM transaksi WHERE TransID='$id' AND Transaksi='17' AND Debet!='0'";
$kl = _query($h);	
$b = _fetch_array($kl);
$Track=$b[TransID];
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);

$mahasiswa = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND a.NoReg='$b[AccID]'";
 $w = _query($mahasiswa);
 $r = _fetch_array($w);
if($r[kode_jurusan]=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
 $Prodi=NamaProdi($r[ProdiID]);
echo"<div class='panel panel-content'>
	<center><h2>PEMBAYARAN MAHASISWA #$_GET[id]</h2> </center><br>
		<table width='100%'>
		<tr>
		  <td width='50%' align='left'>
			<table id=tablemodul1>
				<tr>
			  <td><strong>Nama </strong></td>
			  <td><strong>:  $r[Nama]</strong></td>    
			</tr>
			<tr>
			  <td><strong>NIM </strong></td>
			  <td><strong>:  $r[NIM]</strong></td>    
			</tr>
			  </table>
		  </td>
		  <td width='50%'>
			<table id=tablemodul1>
				<tr>
				  <td class=basic><strong>PROGRAM STUDI</strong></td>
				  <td class=basic><strong> $r[JenjangID] - $Prodi</strong></td>
				</tr>
			</table>
		  </td>    
		</tr>
	</table>
</div>";
	echo"<center><div class='panel-content'>
		<table id='tablestd'><thead>
		<tr><th width='20'>No</th><th>Tanggal</th><th>Keterangan</th><th>Jumlah</th></tr></thead><tbody><tr>
			<td class='description'>1</td>
			<td class='description'>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
		</tr></tbody></table></div></center>";
		
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function TransaksiUmum(){
HeaderPrint();
global $today,$BulanIni,$TahunIni;
$trans = "SELECT * FROM transaksi WHERE TransID='$_GET[id]'";
$tr = _query($trans);	
$b = _fetch_array($tr);
$Track=$b[TransID];
if($b[Debet]=='0'){
$Jumlah=digit($b[Kredit]);
}else{
$Jumlah=digit($b[Debet]);
}
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
echo"<div class='panel panel-content'>
	<center><h3>TRANSAKSI UMUM #$_GET[id]</h3> </center><br></div>";

	
	echo"<center><div class='panel-content'>
		<table id='tablestd'><thead>
		<tr><th width='20'>No</th><th>Tanggal</th><th>Keterangan</th><th>Jumlah</th></tr></thead><tbody><tr>
			<td class='description'>1</td>
			<td class='description'>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
		</tr></tbody></table></div></center>";
		
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function cetakGajiStaff(){
HeaderPrint();
$id=$_GET[id];
global $today,$BulanIni,$TahunIni;
$trans = "SELECT * FROM transaksi WHERE TransID='$id'";
$tr = _query($trans);	
$b = _fetch_array($tr);
$Track=$b[TransID];
if($b[Debet]==0){
$Jum=$b[Kredit];
$Jumlah=digit($Jum);
}else{
$Jum=$b[Debet];
$Jumlah=digit($Jum);
}
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
$bulanGaji = getBulan(substr($b[TglBayar],5,2));
$tahunGaji = substr($b[TglBayar],0,4);

	$staff = "SELECT * FROM karyawan WHERE id='$b[AccID]'";
	$w = _query($staff);
	$r = _fetch_array($w);
	$Jabatan	=NamaJabatan($r[Jabatan]);
	$Department	=NamaDepatmen($r[Bagian]);
echo"<div class='panel panel-content'>
<center><h2>PEMBAYARAN GAJI KARYAWAN  $bulanGaji $tahunGaji</h2> </center><br>
<table class='' width='100%'>
    <tr>
      <td width='50%' align='left'>
		<table id=tablemodul1>
			<tr>
			  <td><strong>NAMA </strong></td>
			  <td><strong>:  $r[nama_lengkap]</strong></td>    
			</tr>
			<tr>
			  <td><strong>JABATAN</strong></td>
			  <td><strong>:  $Jabatan</strong></td>    
			</tr>
		</table>
	  </td>
      <td width='50%' align=right><strong>BAGIAN : $Department</strong></td>    
    </tr>
</table></div>";
echo"<center><div class='panel-content'>
	<table id='tablestd'><thead>
		<tr><th>Tanggal</th>
			<th colspan='2'>Keterangan</th>
			<th width=''>Jumlah</th>
		</tr></thead>
<tbody>
		<tr>
			<td class='description'>$tglBayar</td>
			<td colspan='2'><span>$b[Uraian]</span></td>
			<td class='value'>&nbsp;</td>
		</tr>";
		$honor="SELECT * FROM transaksihnrstaff WHERE Notrans='$id'";
		$hono=_query($honor) or die();
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[gajipokok]);
		$um=$h[uangmakan] * $h[hari];
		$uangmakane=digit($h[uangmakan]);
		$uangmakan=digit($um);
		$ulembur=$h[uanglembur] * $h[jam];
		$uanglembure=digit($h[uanglembur]);
		$uanglembur=digit($ulembur);
		$TotalGaji=$h[Total];
		$TGaji=digit($TotalGaji);
		$potong=digit($h[potongan]);
	echo"<tr>
			<td rowspan='4' class='description'>Uraian</td>
			<td colspan='2'><span>Gaji Pokok</span></td>
			<td class='value'>Rp. <span class='pull-right'>$GajiPokok</span></td>
		</tr>
		<tr>
			<td class='value'><span>Uang Makan</span></td>
			<td class='value'><center>$h[hari] Hari X Rp. $uangmakane</center></td>
			<td class='value'>Rp. <span class='pull-right'>$uangmakan</span></td>
		</tr><tr>
			<td class='value'><span>Uang Lembur</span></td>
			<td class='value'><center>$h[jam] Jam X Rp. $uanglembure</center></td>
			<td class='value'>Rp. <span class='pull-right'>$uanglembur</span></td>
		</tr>
        <tr>
			<td colspan='2'><span>Potongan</span></td>
			<td class='value'>Rp. <span class='pull-right'>$potong</span></td>
		</tr>
        <tr>
			<td class='value' colspan='3'><span>Total Gaji </span></td>
			<td class='value'><b>Rp. <span class='pull-right'>$Jumlah</span></b></td>
		</tr>
		</tbody></table></div></center>";
		
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function cetakHoRektor(){
HeaderPrint();
global $today,$BulanIni,$TahunIni;
$trans = "SELECT * FROM transaksi WHERE TransID='$_GET[id]'";
$tr = _query($trans);	
$b = _fetch_array($tr);
$Track=$b[TransID];
if($b[Debet]==0){
$Jum=$b[Kredit];
$Jumlah=digit($Jum);
}else{
$Jum=$b[Debet];
$Jumlah=digit($Jum);
}
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
$bulanGaji = getBulan(substr($b[TglBayar],5,2));
$tahunGaji = substr($b[TglBayar],0,4);

	$rektor = "SELECT * FROM karyawan WHERE id='$b[AccID]'";
	$w = _query($rektor);
	$r = _fetch_array($w);
	$Jabatan	=NamaJabatan($r[Jabatan]);
	$Department	=NamaDepatmen($r[Bagian]);
echo"<div class='panel panel-content'>
	<center><h3>PEMBAYARAN HONOR REKTORAT  $bulanGaji $tahunGaji</h3> </center><br>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'>
		<table class='basic' width='100%'>
			<tr>
			  <td><strong>NAMA </strong></td>
			  <td><strong>:  $r[nama_lengkap]</strong></td>    
			</tr>
			<tr>
			  <td><strong>USERNAME</strong></td>
			  <td><strong>:  $r[username]</strong></td>    
			</tr>
		</table>
	  </td>
      <td width='30%'></td>
      <td width='40%' align='right'><strong>BAGIAN : $Department</strong></td>    
    </tr>
	</table></div>";
	
	echo"<center><div class='panel-content'>
	<table id='tablestd'><thead>
		<tr><th width='20'>No</th><th width=''>Tanggal</th>
		  <th width=''>Keterangan</th><th width=''>Jumlah</th></tr></thead><tbody>
		<tr>
			<td class='description'>1</td>
			<td class='description'>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>&nbsp;</td>
		</tr>";
		$honor="SELECT * FROM honorrektorat WHERE JabatanAkdm='$r[Jabatan]'";
		$hono=_query($honor) or die();
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[GajiPokok]);
		$Tjbatan=digit($h[TnjanganJabatan]);
		$Ttransport=digit($h[TnjanganTransport]);
		$TotalGaji=$h[GajiPokok] + $h[TnjanganJabatan] + $h[TnjanganTransport];
		$TGaji=digit($TotalGaji);
		if ($TotalGaji==$Jum){
		$potong=0;
		}elseif($TotalGaji > $Jum){
		$pot=$TotalGaji-$Jum;
		$potong=digit($pot);
		}else{
		$potong="-";
		}
	echo"<tr>
			<td colspan='2' rowspan='4' class='description'>Uraian</td>
			<td class='value'><span>Gaji Pokok</span></td>
			<td class='value'>Rp. <span class='pull-right'>$GajiPokok</span></td>
		</tr><tr>
			<td class='value'><span>Tunjangan Jabatan</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Tjbatan</span></td>
		</tr><tr>
			<td class='value'><span>Tunjangan Transport</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Ttransport</span></td>
		</tr>
        <tr>
			<td class='value'><span>Potongan</span></td>
			<td class='value'>Rp. <span class='pull-right'>$potong</span></td>
		</tr>
        <tr>
			<td class='value' colspan='3'><span>Total Honor </span></td>
			<td class='value'><b>Rp. <span class='pull-right'>$Jumlah</span></b></td>
		</tr>
		</tbody></table></div></center>";
		
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function cetakHoNorDosn(){
HeaderPrint();
global $today,$BulanIni,$TahunIni;
$trans = "SELECT * FROM transaksi WHERE TransID='$_GET[id]'";
$tr = _query($trans);	
$b = _fetch_array($tr);
$Track=$b[TransID];
if($b[Debet]==0){
$Jum=$b[Kredit];
$Jumlah=digit($Jum);
}else{
$Jum=$b[Debet];
$Jumlah=digit($Jum);
}
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
$bulanGaji = getBulan(substr($b[TglBayar],5,2));
$tahunGaji = substr($b[TglBayar],0,4);

	$rektor = "SELECT * FROM dosen WHERE dosen_ID='$b[AccID]'";
	$w = _query($rektor);
	$r = _fetch_array($w);
	$Jabatan	=NamaJabatan($r[Jabatan_ID]);
	$Department	=NamaDepatmen($r[Bagian]);
echo"<div class='panel panel-content'>
	<center><h3>PEMBAYARAN HONOR DOSEN  $bulanGaji $tahunGaji</h3> </center><br>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'>
		<table class='basic' width='100%'>
			<tr>
			  <td><strong>NAMA </strong></td>
			  <td><strong>:  $r[nama_lengkap] $r[Gelar]</strong></td>    
			</tr>
			<tr>
			  <td><strong>NIDN</strong></td>
			  <td><strong>:  $r[NIDN]</strong></td>    
			</tr>
			<tr>
			  <td><strong>JABATAN</strong></td>
			  <td><strong>:  $Jabatan</strong></td>    
			</tr>
		</table>
	  </td>
      <td width='30%'></td>
      <td width='40%' align='right'><strong>BAGIAN : $Department</strong></td>    
    </tr>
	</table></div>";
	
	echo"<center><div class='panel-content'>
	<table id='tablestd'><thead>
		<tr><th colspan='5'>Rincian Presensi Dosen : Bulan  $bulanGaji $tahunGaji</tr>
		<tr><td>Tanggal</td><td>Mata Kuliah</td><td>Honor/Sks</td><td>Honor T Muka</td><td>Jumlah</td></tr></thead><tbody>";
	$honor="SELECT * FROM honordosen WHERE JabatanAkdm='$r[Jabatan_ID]'";
	$hono=_query($honor) or die();
		$h=_fetch_array($hono);
		$HonorSks=digit($h[HonorSks]);
		$TranspotTTMK=digit($h[TransportTtpMk]);
		$Transport=$h[UangTransport];
		$HTransport=digit($Transport);

		
	$presensi="SELECT * FROM presensi WHERE DosenID='$r[dosen_ID]' AND Tanggal LIKE '$TahunIni-$BulanIni%'";
					$press=_query($presensi) or die();
					while($data=_fetch_array($press))
					{
					$tgle=tgl_indo($data[Tanggal]);
					$mtk=CekJadwal($data[JadwalID]);
					$kodeMtk=MatakuliahID($mtk);
					$MKK=KelompokMtk($kodeMtk);
					$sks=SksMtk($mtk);
					$totalsks=$sks * $h[HonorSks];
					$tot=$totalsks + $h[TransportTtpMk];
					$toot=digit($tot);
					$tootal1 += $tot;
					$totalHon=$tootal1+$Transport;
					$totalhonor=digit($totalHon);
		if ($totalHon==$Jum){
		$potong=0;
		}elseif($totalHon > $Jum){
		$pot=$totalHon-$Jum;
		$potong=digit($pot);
		}else{
		$potong="-";
		}
					echo"<tr><td>$tgle</td>
						<td>$MKK $mtk</td>
						<td>$sks X $HonorSks</td>
						<td>Rp.<span class='pull-right'>$TranspotTTMK</span></td>
						<td>Rp.<span class='pull-right'>$toot</span></td></tr>";
					}
		echo"<tr><td colspan='4'>Tunjangan Transport</td><td>Rp.<span class='pull-right'>$HTransport</span></td></tr>
			<tr><td colspan='4'>Total Honor</td><td>Rp.<span class='pull-right'><b>$totalhonor</b></span></td></tr>
			<tr><td colspan='4'>Potongan</td><td>Rp.<span class='pull-right'><b>$potong</b></span></td></tr>
			<tr><td colspan='4'>Honor Diterima</td><td>Rp.<span class='pull-right'><b>$Jumlah</b></span></td></tr>
			</table>";
	echo"</div></center>";
		
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function AbsensiDosen(){
HeaderPrint();
global $today,$BulanIni,$TahunIni;
$sql="SELECT Nama FROM tahun WHERE ID='$_GET[tahun]' AND Program_ID='$_GET[prog]' AND Jurusan_ID='$_GET[prodi]'";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($t=mysql_fetch_array($qry)){
  $no++;
  echo"<div class='panel panel-content'>
	<center><h2>DAFTAR HADIR PERKULIAHAN # $t[Nama]</h2> </center><br></div>";
    } 
  $sql="SELECT * FROM krs1 WHERE idtahun='$_GET[tahun]' AND idprog='$_GET[prog]' AND kode_jurusan='$_GET[prodi]' AND kode_mtk='$_GET[kdmtk]' AND kelas='$_GET[kelas]'";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
echo"<table class='basic' width='100%'>
    <tr>
      <td width='40%'>
		<table class='basic' width='100%'>
			<tr>
			  <td><strong>Kelas </strong></td>
			  <td><strong>:  $data[nama_program]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Semester/ Kelas </strong></td>
			  <td><strong>:  $data[kelas]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Program Studi</strong></td>
			  <td><strong>:  $data[kode_jurusan] - $data[nama_jurusan]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Mata Kuliah</strong></td>
			  <td><strong>:  $data[kode_mtk] - $data[nama_matakuliah]</strong></td>    
			</tr>
		</table>
	  </td>
      <td width='20%'></td>
      <td width='40%' align='right'>
		<table class='basic' width='100%'>
			<tr>
			  <td><strong>Hari </strong></td>
			  <td><strong>:  $data[hari]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Waktu </strong></td>
			  <td><strong>:  $data[jam_mulai] - $data[jam_selesai]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Lokal </strong></td>
			  <td><strong>: $data[Ruang_ID]</strong></td>    
			</tr>
			<tr>
			  <td><strong>Dosen </strong></td>
			  <td><strong>: $data[dosen] , $data[gelar]</strong></td>    
			</tr>
		</table>
	  </td>    
    </tr>
	</table>";
echo"<center><div class='panel-content'>
	<table id='tablestd'>
      <tr bgcolor='#CCCCCC'>
        <th rowspan='4' class=basic>No</th>
        <th rowspan='4' class=basic>NIM</th>
        <th rowspan='4' class=basic>Nama Mahasiswa</th>
        <th colspan='16' class=basic>Pertemuan Ke</th>
        <th rowspan='4' class=basic>Abs</th>
      </tr>
      <tr bgcolor='#CCCCCC'>
        <th class=basic>01</th>
        <th class=basic>02</th>
        <th class=basic>03</th>
        <th class=basic>04</th>
        <th class=basic>05</th>
        <th class=basic>06</th>
        <th class=basic>07</th>
        <th class=basic>08</th>
        <th class=basic>09</th>
        <th class=basic>10</th>
        <th class=basic>11</th>
        <th class=basic>12</th>
        <th class=basic>13</th>
        <th class=basic>14</th>
        <th class=basic>15</th>
        <th class=basic>16</th>
      </tr>
      <tr bgcolor='#CCCCCC'>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
        <th class=basic>Tgl</th>
      </tr>
      <tr bgcolor='#CCCCCC'>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
        <th class=basic>&nbsp;</th>
      </tr>";
  $sql="SELECT * FROM krs1 WHERE idtahun='$_GET[tahun]' AND idprog='$_GET[prog]' AND kode_jurusan='$_GET[prodi]' AND kode_mtk='$_GET[kdmtk]' AND kelas='$_GET[kelas]' ORDER BY NIM";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($d=mysql_fetch_array($qry)){
  $no++;
echo"<tr valign='top'>
        <td class=basic>$no </td>
        <td class=basic><span class='style4'>$d[NIM]</span></td>
        <td class=basic>$d[nama_lengkap]</td>
        <td align=center>$d[hdr_1]</td>
        <td align=center>$d[hdr_2]</td>
        <td align=center>$d[hdr_3]</td>
        <td align=center>$d[hdr_4]</td>
        <td align=center>$d[hdr_5]</td>
        <td align=center>$d[hdr_6]</td>
        <td align=center>$d[hdr_7]</td>
        <td align=center>$d[hdr_8]</td>
        <td align=center>$d[hdr_9]</td>
        <td align=center>$d[hdr_10]</td>
        <td align=center>$d[hdr_11]</td>
        <td align=center>$d[hdr_12]</td>
        <td align=center>$d[hdr_13]</td>
        <td align=center>$d[hdr_14]</td>
        <td align=center>$d[hdr_15]</td> 
        <td align=center>$d[hdr_16]</td>
        <td class=basic><span class='style4'></span></td>
	</tr>";    
  }
echo"</table></div></center>";
} 
}
function KRS(){

$tahun=$_GET[tahun];
$semester=$_GET[sms];
$nim=$_GET[NIM];
$TglSkrang	= tgl_indo(date("Y m d"));
	$sql="SELECT * FROM mahasiswa WHERE NIM='$nim'";
	$qry=mysql_query($sql) or die ();
	$data=mysql_fetch_array($qry);
if($data[kode_jurusan]=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
	$namaSemester=namaSemester($semester);
	$pembimbingAkademik=NamaDosen($data[PenasehatAkademik]);
	$prodi=NamaProdi($data[kode_jurusan]);
	$NamaTahun=GetName("tahun","Tahun_ID",$_GET[tahun],"Nama");

 echo"<div class='panel panel-content'>
	<center><h2>KARTU HASIL STUDI (KHS)</h2></center>
<table class='' width='100%'>
    <tr>
      <td width='50%' align='left'>
<table id=tablemodul1>
	<tr>
      <td class=basic><strong>Nama</strong></td>
      <td class=basic><strong> $data[Nama] </td>
      </tr>
    <tr>
      <td class=basic><strong>NIM</strong></td>
      <td class=basic><strong> $data[NIM]</td>
    </tr>
    <tr>
      <td class=basic><strong>Program Studi</strong></td>
      <td class=basic><strong> $data[kode_jurusan] - $prodi</strong></td>
    </tr>
  </table>
	  </td>
      <td width='50%'>
<table id=tablemodul1>
    <tr>
      <td class=basic><strong>Semester</strong></td>
      <td class=basic><strong> $namaSemester ( $semester )</strong></td>
    </tr>
	  <tr>
      <td class=basic><strong>Tahun Akademik</strong></td>
      <td class=basic><strong> $NamaTahun</td>
    </tr>
  </table>
	  </td>    
    </tr>
</table>";
echo"<table id=tablestd>
<thead>
	<tr><th>NO</th><th>KODE</th><th>MATAKULIAH</th><th>KREDIT</th>
	</tr></thead>";
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
		<td>$kelompok - $data2[Jadwal_ID]</td>
		<td>$namaMtk</td>
		<td>$sksMtk SKS</td>
	</tr>";
$Tot=$Tot+$sksMtk;
}
echo"<tfoot>
		<tr>
			<td valign=top colspan=3><b>Total Keseluruhan SKS Ambil</b></td>
			<td valign=top><b>$Tot SKS</b></td>
		</tr>
	</tfoot></table>";
  
echo"</div>";
$Kaprodi=GetName("karyawan","Jabatan",18,"nama_lengkap");
echo"<table class='' width='100%'>
    <tr>
      <td width='60%' align='left'>
<table id=>
  <tr>
    <td><center><strong>Mengetahui, </strong></center></td>
  </tr>
	<tr>
    <td> <center><strong>( Dosen Wali )</center></td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
	<tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td> <center><strong>(  $pembimbingAkademik )</center></td>
  </tr>
</table>
	  </td>
      <td width='40%' align='center'>
		<table id=''>
		  <tr>
			<td><strong></strong></td>
		  </tr>
		  <tr>
			<td><center><strong>Surabaya, $TglSkrang</strong></center></td>
		  </tr>
			<tr>
			<td> <center><strong>( KA. PRODI )</center></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
			<tr>
			<td>&nbsp;</td>
		  </tr>

		  <tr>
			<td> <center><strong>(  $Kaprodi )</center></td>
		  </tr>
		</table>
	  </td>    
    </tr>
	</table>";
}


function JadwalHarian($hari,$institusi,$jurusan,$program,$tahun,$sms){
echo"<table id=tablemodul1>
	<thead>
		<tr><td colspan=7><b>Hari $hari</b></td></tr> 
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Matakuliah</th>
			<th>SKS</th>
			<th>Dosen</th>
			<th>Waktu</th>
			<th>Ruang</th>
		</tr>
	</thead>";
		$sql="SELECT * FROM jadwal WHERE Identitas_ID='$institusi' AND Kode_Jurusan='$jurusan' AND Program_ID='$program' AND Hari='$hari' AND Tahun_ID='$tahun' AND semester='$sms' ORDER BY Jadwal_ID";
		$qry= _query($sql)or die ();
		while ($r=_fetch_array($qry)){  
		$no++;
		$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$ruang=GetName("ruang","ID",$r[Ruang_ID],"Nama");
		$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
		$sksMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"SKS");
		$kelompokMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"KelompokMtk_ID");
		$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");
		$dosen1=NamaDosen($r[Dosen_ID]);
		$dosen2=NamaDosen($r[Dosen_ID2]); 
		echo "<tr>                            
			<td>$no</td>
			<td>$kelompok - $r[Kode_Mtk]</td>
			<td valign='middle'>$namaMtk</td>
			<td>$sksMtk</td>
			<td>1- $dosen1 <br>2- $dosen2</td>
			<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>
			<td>$ruang</td>                  
		</tr>";        
	}
echo"</table>";
}
function JadwalKuliah(){
$institusi	=$_GET[identitas];
$jurusan	=$_GET[jurusan];
$program	=$_GET[program];
$tahun		=$_GET[tahun];
$sms		=$_GET[semester];
$TglSkrang	= tgl_indo(date("Y m d"));
$PRODI=NamaProdi($jurusan);
$kelas=NamaKelasa($program);
$semest=namaSemester($sms);
$TA=TahunID($tahun);
if($jurusan=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
echo"<div class='panel panel-content'>
	<center><h2>JADWAL KULIAH</h2>
	<h2>SEMESTER $semest $TA</h2>
	<h2>PROGRAM STUDI $PRODI</h2>
	<h2>KELAS $kelas</h2>
	<h2>SEMESTER $sms</h2></center>";
JadwalHarian("Senin",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Selasa",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Rabu",$institusi,$jurusan,$program,$tahun,$sms);	
JadwalHarian("Kamis",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Jumat",$institusi,$jurusan,$program,$tahun,$sms);		
JadwalHarian("Sabtu",$institusi,$jurusan,$program,$tahun,$sms);	
echo"</div>";	
$Puket1=GetName("karyawan","Jabatan",20,"nama_lengkap");
echo"<table class='' width='100%'>
    <tr>
      <td width='60%' align='left'>
	  </td>
      <td width='40%' align='center'>
<table id=>
  <tr>
    <td><center><strong><h3>Surabaya, $TglSkrang,<br>( Pembantu Ketua I )</h3></strong></center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <center><h3>( $Puket1 )</h3></center></td>
  </tr>
</table>
	  </td>    
    </tr>
	</table>";
}
function JadwalUjian(){
HeaderPrint();
echo"<div class='panel panel-content'>
	<center><h2>JADWAL UJIAN</h2> </center><br>";
echo"<table id=tablestd>";  
  $sql="SELECT * FROM view_form_mhsakademik WHERE NIM='$_GET[NIM]'";
  $no=1;
  $qry=mysql_query($sql)
  or die ();
  while($data=mysql_fetch_array($qry)){
  	if (empty($data['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$data[Foto]"; }
  $no++;
echo"<tr>
      <td class=basic><strong>Tahun</strong></td>
      <td class=basic><strong>$_GET[tahun] </td>
      <td rowspan=6 valign=top><img alt='$data[nama_lengkap]' src='$foto' height=130/></td></tr>
    <tr>
      <td class=basic><strong>NIM</strong></td>
      <td class=basic><strong>$data[NIM]</td>
    </tr>
    <tr>
      <td class=basic><strong>NAMA</strong></td>
      <td class=basic><strong>$data[nama_lengkap]</td>
    </tr>
    <tr>
      <td class=basic><strong>Program Studi</strong></td>
      <td class=basic><strong> $data[kode_jurusan] - $data[nama_jurusan]</strong></td>
    </tr>
    <tr>
      <td class=basic><strong>Kelas</strong></td>
      <td class=basic><strong>$data[nama_program]</strong></td>
    </tr>
  </table>";
    $edit=mysql_query("SELECT * FROM jenis_ujian WHERE jenisjadwal='$_GET[ujian]'");
    $r=mysql_fetch_array($edit);
echo"<table id=tablemodul1>
	<tr><td colspan=10 align=center bgcolor=#C0DCC0><strong>Kartu $r[nama]</strong></td></tr>
	<tr bgcolor='#CCCCCC'>
        <th class=basic>No</th>
        <th class=basic>Kode <br>Matakuliah</th>
        <th class=basic>Nama <br>Matakuliah</th>
        <th class=basic>SKS</th>
        <th class=basic>Sem</th>
        <th class=basic>Ruang</th>
        <th class=basic>Tgl</th>
        <th class=basic>Jam <br>Mulai</th>
        <th class=basic>Jam <br>Selesai</th>
	</tr>";	
  $sql="SELECT * FROM krs1 WHERE tahun='$_GET[tahun]' AND NIM='$_GET[NIM]' ORDER BY semester,kelas";
  $no=0;
  $qry=mysql_query($sql)
  or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
              if ($_GET[ujian]=="UTS")
              {  
                  $UjianTgl   = tgl_indo($data[UTSTgl]);
                  $UjianMulai = $data[UTSMulai];
                  $UjianSelesai = $data[UTSSelesai];
                  $UjianRuang = $data[UTSRuang];
              }else if ($_GET[ujian]=="UAS")
              {  
                  $UjianTgl   = tgl_indo($data[UASTgl]);
                  $UjianMulai = $data[UASMulai];
                  $UjianSelesai = $data[UASSelesai];
                  $UjianRuang = $data[UASRuang];
              }
echo"<tr valign=top>
        <td class=basic>$no</td>
        <td class=basic>$data[kode_mtk]</td>
        <td class=basic><span class=style4>$data[nama_matakuliah]</span></td>
        <td class=basic><span class=style4>$data[sks]</span></td>
        <td class=basic><span class=style4>$data[semester]</span></td>
        <td class=basic><span class=style4>$UjianRuang</span></td>
        <td class=basic><span class=style4>$UjianTgl</span></td>
        <td class=basic><span class=style4>$UjianMulai</span></td>
        <td class=basic><span class=style4>$UjianSelesai</span></td>
      </tr>";
$Tot=$Tot+$data[sks];
$totalsks=number_format($Tot,0,',','.');
  }
echo"</table>
    <table id=tablestd> 
      <tr>
        <td valign=top class=basic>Total Keseluruhan SKS Ambil</td>
        <td valign=top class=basic> $totalsks</td>
      </tr>
	  </table>";
  }
echo"</div>";
}
function TotalSks($id,$kode,$konsentrasi){
$T11 = "0";
if($konsentrasi=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ('41') AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}elseif($konsentrasi=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ($konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}else{
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Aktif='Y' AND t1.Kurikulum_ID IN ('41',$konsentrasi) AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$T11=$T11+$r[SKS];
	}
}
return $T11;
}

function MatakuliahPerSemester($semester,$id,$kode,$kons){
echo"<table id=tablestd><thead>
<tr><td colspan=7><h4>Semester $semester</h4></td></tr>

		<tr>
			<th>NO</th><th>KODE MTK</th><th>NAMA MTK</th><th>JENIS</th><th>STATUS</th><th>SMSTR</th><th>SKS</th>
		</tr>
		</thead>                        
		<tbody>";
if($kons=='41'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ('41') AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
}elseif($kons=='40'){
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ($kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
} else {
$sql="SELECT t1.*,t2.Nama AS NamaSMk,t3.Nama AS NamaJMK FROM matakuliah t1 left join statusmtk t2 ON t1.StatusMtk_ID = t2.StatusMtk_ID, jenismk t3 WHERE t1.JenisMTK_ID=t3.JenisMK_ID AND t1.Identitas_ID='$id' AND t1.Jurusan_ID='$kode' AND t1.Semester LIKE '%$semester%' AND t1.Kurikulum_ID IN ('41',$kons) AND t1.Aktif='Y' AND t1.StatusMtk_ID='A' AND t1.JenisMTK_ID!='B' GROUP BY t1.Matakuliah_ID ORDER BY t1.Matakuliah_ID,t1.Semester";
}
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){ 
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$KelompokMtk=KelompokMtk($r[KelompokMtk_ID]);
	$n11++;
	echo "<tr>                            
		<td>$n11</td>
		<td>$KelompokMtk - $r[Kode_mtk] </td>
		<td>$r[Nama_matakuliah]</td>  
		<td>$r[NamaJMK]</td>
		<td>$r[NamaSMk]</td>
		<td>$r[Semester]</td>     		         
		<td>$r[SKS]</td>";
	$T11=$T11+$r[SKS];
	$jt11=number_format($T11,0,',','.');
	$jumlah11="<span class='badge badge-info'>$jt11</span><b> SKS</b>";
	echo "</tr>";        
	}
    echo "<tfoot><tr>                            
		<td colspan=6 ><b>Total :</b></td>
		<td colspan=1><b>$jumlah11</b></td>
		</tr></tfoot>";
	echo "</tbody></table>";
}
function Matakuliah(){
global $tgl_sekarang;
$id= $_SESSION['Identitas'];
$kode= $_GET[cod];
$kons= $_GET[id];
if($kode=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$kons,"Nama"));
$d = GetFields('jurusan', 'kode_jurusan', $kode, '*');
echo"<div class='panel panel-content'>
<center><h2>DAFTAR MATAKULIAH - PROGRAM STUDI $d[nama_jurusan] <br> KONSENTRASI $NamaKonsentrasi</h2> 
</center>";
$jumlahsemester= ($kode=='61101')? '4': '8';
for ($num = 1; $num <= $jumlahsemester; $num++){
MatakuliahPerSemester($num,$id,$kode,$kons);
}

$Ttot=TotalSks($id,$kode,$kons);
	$jumlasemua="<span class='badge badge-success'>$Ttot</span><b> SKS</b>";
echo"<table class='' width='100%'>
    <tr>
      <td width='60%' align='left'>
		<table id=tablestd width='100%'>
			<tr>
				<td width='40%'><strong>TOTAL KREDIT :</strong></td>
				<td width='60%'><strong>$jumlasemua </strong></td>
			</tr>
		</table>
	  </td>
      <td width='40%' align='right'></td>    
    </tr>
	</table>";   
}
function Transkrip(){
global $tgl_sekarang,$TahunIni,$BulanIni;
$id=$_GET[NIM];
$prodi=$_GET[prodi];
$getNim=substr($id,-3);
$getBr=getBulanRomawi($BulanIni);
if($prodi=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
echo"<div class='panel panel-content'>
	<center><h2>TRANSKRIP SEMENTARA</h2> <table id=tablemodul1>
			<tr>
				<td><strong>NO :</strong></td>
				<td><strong>T &nbsp; &nbsp; &nbsp; &nbsp; - $getNim/STY-TS/$getBr/$TahunIni  </strong></td>
				
			</tr>
		</table></center>";
$w = GetFields('mahasiswa', 'NIM', $id, '*');
$tglLahir=tgl_indo($w[TanggalLahir]);
$PRODI=NamaProdi($prodi);
$konsentrasi=strtoupper(NamaKonsentrasi($w[Kurikulum_ID]));
echo"<table width='100%' align='center'>
    <tr>
      <td width='50%'>
		<table id=tablemodul1 align='left'>
			<tr>
				<td width='40%'><strong>NAMA</strong></td>
				<td width='60%'><strong>$w[Nama]  </strong></td>
				
			</tr>
			<tr>
				<td width='40%'><strong>NIM</strong></td>
				<td width='60%'><strong>$w[NIM]</strong></td>
			
			</tr>
			<tr>
				<td width='40%'><strong>TTL</strong></td>
				<td width='60%'><strong>$w[TempatLahir], $tglLahir</strong></td>
			</tr>
		</table>
	  </td>
      <td width='50%'>
<table id=tablemodul1 align='right'>
			<tr>
				<td width='40%'><strong>PROGRAM STUDI</strong></td>
				<td width='60%'><strong>$PRODI </td>
			</tr>
			<tr>
				<td width='40%'><strong>KONSENTRASI</strong></td>
				<td width='60%'><strong>$konsentrasi</strong></td>
			</tr>
		</table>
	  </td>    
    </tr>
	</table>";
echo"<table id=tablestd width='100%'>
      <tr bgcolor='#CCCCCC'>
        <th width='5%' align='center'>No</th>
        <th width='10%' align='center'>Kode MK</th>
        <th align='center'> Mata Kuliah</th>
        <th width='5%' align='center'>SMSTR</th>
        <th width='5%' align='center'>SKS</th>
        <th width='5%' align='center'>Nilai</th>
        <th width='5%' align='center'>Bobot</th>
      </tr>";
 $sql="SELECT * FROM matakuliah WHERE Identitas_ID='$_SESSION[Identitas]' AND Jurusan_ID='$w[kode_jurusan]' AND Kurikulum_ID IN ('41',$w[Kurikulum_ID]) ORDER BY Kode_mtk";
  $no=0;
  $qry=mysql_query($sql) or die ();
  while($data=mysql_fetch_array($qry)){
  $no++;
	$sqlr="SELECT * FROM krs WHERE NIM='$id' AND Jadwal_ID='$data[Kode_mtk]'";
	$qryr= mysql_query($sqlr);
	$data1=mysql_fetch_array($qryr);
$kelompokMtk=GetName("matakuliah","Kode_mtk",$data[Kode_mtk],"KelompokMtk_ID");
$kelompok=GetName("kelompokmtk","KelompokMtk_ID",$kelompokMtk,"Nama");   
$ipSks= ($boboxtsks==0)? 0: $data[SKS];

$boboxtsks=$data[SKS]*$data1[BobotNilai];
$Totsks=$Totsks+$ipSks;

$TotSks=$TotSks+$data[SKS];

$jmlbobot=$jmlbobot+$boboxtsks;
$bobot=$data1[BobotNilai];


echo"<tr valign='top'>
        <td class=basic>$no</td>
        <td class=basic>$kelompok - $data[Kode_mtk]</td>
        <td class=basic><span class=style4>$data[Nama_matakuliah]</span></td>
         <td>$data[Semester] </td>
        <td class=basic><span class=style4>$data[SKS]</span></td>
        <td class=basic><span class=style4>$data1[GradeNilai]</span></td>
        <td class=basic><span class=style4>$boboxtsks</span></td></tr>";
  }
$totalSKS=number_format($TotSks,0,',','.');
$ipk=$jmlbobot/$Totsks;
$Ipke=number_format($ipk,2,',','.');
$JumlahBBt=number_format($jmlbobot,0,',','.');	
echo"<tr><td colspan='6'>&nbsp;&nbsp;</td></tr>
<tfoot>
<tr>
	<td colspan='4'><center><b>Total Keseluruhan Kredit</b></center></td>
	<td><center><b>$totalSKS</b></center></td>
	<td></td>
	<td><center><b>$JumlahBBt</b></center></td>
</tr>
<tr>
	<td colspan='4'><center><b>Indeks Prestasi Kumulatif (IPK)</b></center></td>
	<td colspan='3'><center><b align='right'>$Ipke</b></center></td>
</tr>
</tfoot>";
echo"</table>";
$Puket1=GetName("karyawan","Jabatan",20,"nama_lengkap");
$TglSkrang	= tgl_indo(date("Y m d"));
echo"<table class='' width='100%'>
    <tr>
      <td width='60%' align='left'></td>
      <td width='40%' align='right'>
		<table width='100%'>
			<tr>
				<td>
				<center><b><br/><br/>Surabaya, $TglSkrang<br/> Pembantu Ketua I</b></center>
				<br/><br/>
				
				<center><b>$Puket1</b></center>
				</td>
			</tr>
		</table> 
	  </td>    
    </tr>
	</table>";
echo"</div>";
}
function CetakProfileDosen(){
HeaderPrint();
	$sql="SELECT * FROM dosen WHERE dosen_ID='$_GET[id]'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
	if (empty($r['foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[foto]"; }
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
echo"<div class='panel panel-content'>
	<center><h2>KETERANGAN TENTANG DOSEN<br/>(BUKU INDUK DOSEN)</h2> <br/><br/>
	
	<br/>";	

	echo"<table id=tablestd cellpadding='10' cellspacing=20>
	<thead>
	<tr><th colspan=4> DETAIL DOSEN </th></tr>                               
	<tr>
	<td>NAMA LENGKAP</td>
	<td>:</td>
	<td><strong> $r[nama_lengkap] ,$r[Gelar]</strong></td>
	<td rowspan=3><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
	<tr>
	<td>NIDN</td>
	<td>:</td>
	<td><strong>$r[NIDN] </strong></td>
	</tr>
	<tr><td>PROGRAM STUDI </td><td>:</td><td><strong> $NamaProdi</strong></td></tr>
	</thead></table>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='panel-content'>
				<table id=tablestd cellpadding='10' cellspacing=20>
					<thead>
						<tr><th colspan='2'><center>DATA PRIBADI</center></th></tr>
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
							<td> : &nbsp;&nbsp;&nbsp;$r[Alamat] . $r[Kota] ($r[Propinsi]-$r[Negara])</td> 	
							</tr>
							<tr>
							<td><i class='icon-file'></i> Tlp / Hp </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Telepon] / $r[Handphone]</td>
							</tr>
							<tr><td colspan='2'><center><b>AKADEMIK</b></center></td></tr>
							<tr>
							<td><i class='icon-file'></i> Tanggal Bergabung</td>
							<td> : &nbsp;&nbsp;&nbsp;$TglGabung</td>
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
							<tr><td colspan='2'><center><b>RIWAYAT PENDIDIKAN DOSEN </b></center></td></tr>
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
echo "<tr><td colspan='2'><center><b>RIWAYAT PEKERJAAN DOSEN </b></center></td></tr>
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
echo "<tr><td colspan='2'><center><b>DATA PENELITIAN DOSEN </b></center></td></tr>";
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
			</div>
		</div>
	</div>";
echo"</center></div>";
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
		<table align='right'>     
			<thead>
				<tr><td><center>Dicetak Tgl, $TglSkrang</center></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td><center> $_SESSION[Nama] - (BA.AK)</center></td></tr>
			</thead>
		</table>
	  </td>    
    </tr>
	</table></div>";

}
function CetakKalender(){
include "../librari/calender.php";
//HeaderPrint();
$tahun		=	$_GET['tahun'];
$semester	= 	$_GET['sms'];
$NamaSemester=GetName("evensemester","smsterID",$semester,"Nama");
$NamaTahun=GetName("tahun","Tahun_ID",$tahun,"Nama");
echo"<div class='panel panel-content'>
<center><h2>KALENDER $NamaTahun <br/>Semester $NamaSemester </h2></center>
	<table id='tablemodul1' width='100%'>
    <tr>
<td width='70%'><center>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' GROUP BY MONTH(EndDate),YEAR(EndDate) ORDER BY YEAR(EndDate),MONTH(EndDate) ASC";
$qryd= _query($sql)or die ();
$ab=_num_rows($qryd);
$col = 2;
echo "<table class='basic' width='100%'><tr>";
$cnt = 0;
	for($i=1;$i<=$ab;$i++)
	{
  if ($cnt >= $col) {
     echo "</tr><tr>";
      $cnt = 0;
  }
echo"<td width='50%' align='center'>";
	$d=_fetch_array($qryd);
	$bln=substr("$d[EndDate]",5,2);
	$thn=substr("$d[EndDate]",0,4);
	$namaBulan=getBulan3($bln);
	$calendar = new SimpleCalendar($namaBulan,$thn);
	$calendar->setStartOfWeek('Monday');
	$calendar->setDate($d[EndDate]);

	$query = "SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' ORDER BY StartDate,EventId";
	$result = _query($query) or die('cannot get results!');
	$no=0;
	while ($r=_fetch_array($result)){
	$no++;
	$calendar->addDailyHtml( $r[warna], $r[StartDate], $r[EndDate]);
	}
$calendar->show(true);
echo"</td>";
 $cnt++;
	}
echo "</tr></table>
</center>
</td>
<td width='30%' valign='top'>
<h2>Kegiatan Akademik</h2>
<table class='table' width='100%'>";
	$sqld="SELECT * FROM evenjenis ORDER BY jenisID";
	$qryd= _query($sqld)or die ();
	while ($d=_fetch_array($qryd)){
echo"<thead>
	<tr><th colspan='2'>$d[Nama]</th></tr>
</thead><tbody>";
$sql="SELECT * FROM event WHERE TahunID='$tahun' AND Semester='$semester' AND JenisEvent='$d[jenisID]' ORDER BY StartDate,EventId";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){       	
	$no++;
	echo "
	<tr>
		<td bgcolor='$r[warna]'>&nbsp;&nbsp;</td>
		<td><i class='icon-file'><b>$r[NamaEvent]</b></td></tr>";        
	}
}
echo"</tbody></table>
	  </td>    
    </tr>
	</table></div>";
}
function CetakBukuInduk(){
	$sql="SELECT * FROM mahasiswa WHERE NIM='$_GET[id]'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
if($r[kode_jurusan]=='61101'){
HeaderPrints2();
}else{
HeaderPrint();
}
	if (empty($r['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[Foto]"; }
	$NamaProdi=NamaProdi($r['kode_jurusan']);
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
	if ($r[Kelamin]=='L'){
	$gender="Laki - Laki";
	}else{
	$gender="Perempuan";
	}
	$TglSkrang	= tgl_indo(date("Y m d"));
	$prodi = GetFields('jurusan', 'kode_jurusan', $r[kode_jurusan], '*');
echo"<div class='panel panel-content'>
	<center><h2>KETERANGAN TENTANG DIRI MAHASISWA<br/>(BUKU INDUK MAHASISWA)</h2>
	<table>
	<tr><td class=box><img alt='$r[Nama]' src='$foto' height=150/></td></tr>
	</table>";
echo"<table id=tablestd cellpadding='10' cellspacing=20>
	<tr>
      <td class=basic><strong>01</strong></td>
      <td class=basic><strong>Nama Lengkap Mahasiswa</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[Nama] </td>
	</tr>
    <tr>
      <td class=basic><strong>02</strong></td>
      <td class=basic><strong>NIM</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[NIM]</td>
    </tr>
    <tr>
      <td class=basic><strong>03</strong></td>
      <td class=basic><strong>Jenis Kelamin</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$gender</td>
    </tr>
    <tr>
      <td class=basic><strong>04</strong></td>
	  <td class=basic><strong>Tempat Tgl Lahir</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[TempatLahir], $TglLhr</strong></td>
    </tr>
    <tr>
      <td class=basic><strong>05</strong></td>
      <td class=basic><strong>Agama</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$Agama</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>06</strong></td>
      <td class=basic><strong>Alamat Mahasiswa</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[Alamat], RT: $r[RT] - RW: $r[RW]. $r[KodePos]. $r[Kota] ($r[Propinsi]-$r[Negara])</strong></td>
    </tr>";
if($prodi[jenjang]=='S1'){
					echo"	<tr>
	  <td class=basic><strong>07</strong></td>
      <td class=basic><strong>Nama SMK / SMA / MA</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>08</strong></td><td class=basic colspan='2'><strong>SURAT TANDA TAMAT BELAJAR / IJAZAH</strong></td></tr>";
}else{
echo"<tr>
	  <td class=basic><strong>07</strong></td>
      <td class=basic><strong>Nama Perguruan Tinggi</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[AsalSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>08</strong></td><td class=basic colspan='2'><strong>IJAZAH S1</strong></td></tr>";

}
$Tahun=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
$NamaTahun=explode(" ",$Tahun);
echo"<tr>
	  <td class=basic><strong>A</strong></td>
      <td class=basic><strong>TAHUN</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[TahunLulus]</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>B</strong></td>
      <td class=basic><strong>NOMOR</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$r[NilaiSekolah]</strong></td>
    </tr>
	<tr><td class=basic><strong>09</strong></td><td class=basic colspan='2'><strong>DITERIMA DI STIE YAPAN</strong></td><tr>
	<tr>
	  <td class=basic><strong>A</strong></td>
      <td class=basic><strong>PROGRAM STUDI</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$NamaProdi</strong></td>
    </tr>
	<tr>
	  <td class=basic><strong>B</strong></td>
      <td class=basic><strong>TAHUN</strong></td>
      <td class=basic><strong>:&nbsp;&nbsp;$NamaTahun</strong></td>
    </tr>
  </table>";
echo"</center></div>";
echo"<div class='panel panel-content'>
	<table class='basic' width='100%'>
    <tr>
      <td width='30%'></td>
      <td width='30%'></td>
      <td width='40%'>
	
	  </td>    
    </tr>
	</table></div>";
}
function CetakPendaftaran(){
HeaderPrint();
$id=$_GET[id];
$w = GetFields('mahasiswa', 'NoReg', $id, '*');
$AGAMA=GetName("agama","agama_ID",$w[Agama],"nama");
$NamaTahun=GetName("tahun","Tahun_ID",$w[Angkatan],"Nama");
$TglSkrang	= tgl_indo(date("Y m d"));
$TglLahir=tgl_indo($w[TanggalLahir]);
$gender=($w[Kelamin]=='L')? 'Laki-Laki':'Perempuan';
$PRODI=NamaProdi($w[kode_jurusan]);
$konsentrasi=strtoupper(NamaKonsentrasi($w[Kurikulum_ID]));
echo"<div class='panel panel-content'>
	<center><h2>PENDAFTARAN MAHASISWA BARU</h2> 
	<table id=tablemodul1>
			<tr>
				<td><strong>NO REGISTRASI :</strong></td>
				<td><strong>  $id </strong></td>
				<td><strong>  $NamaTahun </strong></td>
				
			</tr>
		</table></center>";
echo"<table id=tablestd width=70%>
	<tr>
		<td width=4% align='center'><strong>1 </strong></td>
		<td width=40% align='left'><strong>NAMA CALON MAHASISWA </strong></td>
		<td width=56% align='left'><strong>$w[Nama]</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>2 </strong></td>
		<td width=40% align='left'><strong>JENIS KELAMIN </strong></td>
		<td width=56% align='left'><strong>$gender</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>3 </strong></td>
		<td width=40% align='left'><strong>TANGGAL LAHIR </strong></td>
		<td width=56% align='left'><strong>$TglLahir</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>4 </strong></td>
		<td width=40% align='left'><strong>TEMPAT LAHIR </strong></td>
		<td width=56% align='left'><strong>$w[TempatLahir]</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>5 </strong></td>
		<td width=40% align='left'><strong>AGAMA </strong></td>
		<td width=56% align='left'><strong>$AGAMA</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>6 </strong></td>
		<td width=40% align='left'><strong>ALAMAT TINGGAL </strong></td>
		<td width=56% align='left'><strong>$w[Alamat] ,RT : $w[RT]- RW : $w[RW] ,$w[Kota].$w[KodePos] - $w[Propinsi].  $w[Negara]</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>7 </strong></td>
		<td width=40% align='left'><strong>TLP / HP </strong></td>
		<td width=56% align='left'><strong>$w[Telepon] / $w[Handphone]</strong></td>
	</tr>
	<tr>
		<td width=4% align='center'><strong>8 </strong></td>
		<td width=40% align='left'><strong>PROGRAM STUDI</strong></td>
		<td width=56% align='left'><strong>$PRODI $konsentrasi</strong></td>
	</tr>
</table>";
echo"</div>";
echo"<table class='' width='100%'>
    <tr>
      <td width='50%' align='left'>
<table id=>
  <tr>
    <td><center><strong><u>PETUGAS PENDAFTAR</u></strong><center></td>
  </tr>
	<tr>
    <td> <center><strong>( HUMAS )</strong></center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <center><strong>( $_SESSION[Nama] )</center></td>
  </tr>
</table>
	  </td>
      <td width='50%' align='right'>
<table id=>
  <tr>
    <td><center><strong><u>Surabaya, $TglSkrang,</u></strong><center></td>
  </tr>
	<tr>
    <td> <center><strong>( Calon Mahasiswa )</strong></center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <center><strong>( $w[Nama] )</center></td>
  </tr>
</table>
	  </td>    
    </tr>
	</table>";
}
function TransBaak(){
HeaderPrint();
$id=$_GET[id];
$TglSkrang	= tgl_indo(date("Y m d"));
if($id=='1'){
$judul="";
echo"<center><h2><u>BERITA ACARA UJIAN SKRIPSI</u></h2></center>";
echo"<br><center>
	<table width=100%>
	<tr><td width=10%></td>
		<td colspan=3><p>Sebagai Tindak Lanjut SK : <br>
	Tanggal : ...........................Tentang Ujian Skripsi Mahasiswa STIEYAPAN<br>
	Program Studi ...................... Dengan Program STRATA 1, Pada Hari ini.....
	</p></td>
		<td width=10%></td>
	</tr>
	<tr><td width=10%></td>
		<td width=20%><h3>Nama Mahasiswa</h3></td>
		<td width=5%>:</td>
		<td width=60%>Nama </td>
		<td width=10%></td>
	</tr>
	<tr><td width=10%></td>
		<td width=2%><h3>Nama Mahasiswa</h3></td>
		<td width=5%>:</td>
		<td width=60%>Nama </td>
		<td width=10%></td>
	</tr>
	</table>
</center>";
}elseif($id=='2'){
$judul="PANITIA UJIAN SKRIPSI PROGRAM SARJANA (STRATA 1) <br><br>
<u>NILAI UJIAN SKRIPSI</u><br>
<u>PROGRAM SARJANA (STRATA 1)</u>
";
}elseif($id=='7'){
$judul="SURAT PERNYATAAN <br>
<u> MENGIKUTI YUDISIUM / WISUDA</u>
";
echo"$judul";
}
}
function JudulPrint(){
if ($_GET[Action]=='cetakTransaksi'){
	echo"CETAK TRANSAKSI";
}elseif($_GET[Action]=='DetailPembayaran'){
	echo"DETAIL PEMBAYARAN";
}elseif($_GET[Action]=='AbsensiDosen'){
	echo"ABSENSI DOSEN";
}elseif($_GET[Action]=='KRS'){
	echo"CETAK KRS";
}elseif($_GET[Action]=='JadwalUjian'){
	echo"CETAK JADWAL UJIAN";
}elseif($_GET[Action]=='KHS'){
	echo"CETAK KHS";
}elseif($_GET[Action]=='Transkrip'){
	echo"TRANSKRIP NILAI";
}elseif($_GET[Action]=='Matakuliah'){
	echo"DAFTAR MATA KULIAH";
}elseif($_GET[Action]=='cetakHoRektor'){
	echo"CETAK HONOR REKTORAT";
}elseif($_GET[Action]=='cetakHostaff'){
	echo"CETAK HONOR STAFF";
}elseif($_GET[Action]=='cetakHoNorDosn'){
	echo"CETAK HONOR DOSEN";
}elseif($_GET[Action]=='CetakPendaftaran'){
	echo"CETAK PENDAFTARAN";
}elseif($_GET[Action]=='CetakBukuInduk'){
	echo"CETAK BUKU INDUK MAHASISWA";
}elseif($_GET[Action]=='CetakProfileDosen'){
	echo"CETAK BUKU INDUK DOSEN";
}elseif($_GET[Action]=='TransaksiUmum'){
	echo"CETAK TRANSAKSI";
}elseif($_GET[Action]=='TransBaak'){
	echo"CETAK TRANSAKSI AKADEMIK";
}elseif($_GET[Action]=='JadwalKuliah'){
	echo"CETAK JADWAL KULIAH";
}elseif($_GET[Action]=='CetakKalender'){
	echo"CETAK KALENDER AKADEMIK";
}elseif($_GET[Action]=='cetakGajiStaff'){
	echo"CETAK GAJI STAFF";
}
}
switch($_GET[Action]){

  default:
    DefaultPrint();
  break;  
  case "cetakTransaksi":
    cetakTransaksi();
  break;
  
  case "TransaksiUmum":
    TransaksiUmum();
  break;
  
  case "cetakHoRektor":
    cetakHoRektor();
  break; 
  
  case "cetakHoNorDosn":
    cetakHoNorDosn();
  break; 

case "cetakGajiStaff":
    cetakGajiStaff();
  break; 
  
  case "DetailPembayaran":
    DetailPembayaran();
  break;
  
  case "AbsensiDosen":
    AbsensiDosen();
  break;

  case "KRS":
    KRS();
  break;

  case "KHS":
    KHS();
  break;

  case "JadwalKuliah":
    JadwalKuliah();
  break;

case "JadwalUjian":
    JadwalUjian();
  break;

  case "Transkrip":
    Transkrip();
  break;

  case "Matakuliah":
    Matakuliah();
  break;

  case "CetakPendaftaran":
    CetakPendaftaran();
  break;
  
  case "CetakBukuInduk":
    CetakBukuInduk();
  break;

case "CetakKalender":
    CetakKalender();
  break;

  case "CetakProfileDosen":
    CetakProfileDosen();
  break;

case "TransBaak":
    TransBaak();
  break;

}
?>
</body>
</html>