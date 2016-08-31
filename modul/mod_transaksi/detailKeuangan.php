<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat AND $edit){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $NREG=$r[RegID];
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
 $kelas=NamaKelasa($r[IDProg]);
if($r['JenjangID']=='S1'){
		$trans="17";
		$buku="'1','2'";
}elseif($r['JenjangID']=='S2'){
		$trans="18";
		$buku="'8','9'";
}else{
		$trans="'17','18'";
		$buku="'1','2','8','9'";
}
if($Totalkekurngan =='0'){
$status="<span class='label'>LUNAS</span>";
}else{
$status="<span class='label label-success'>AKTIF</span>";
}
echo"<div class='row'>
<div class='span12'>
<div class='widget'>
<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<h4><i class='icon-hand-right'></i>&nbsp;&nbsp;Detail Keuangan Mahasiswa </h4>
</div>
<div class='pull-right'>
	<div class='btn-group'><a class='btn btn-danger' href='aksi-transaksi-pay.html'><i class='icon-undo'></i>Kembali</a>
	<a class='btn btn-inverse ui-lightbox' href='get-prind-mhsDetpay-$NREG.html?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p'><i class='icon-print'></i>Cetak</a></div>
</div>
</div></div>
<div class='widget-content'>

<div class='panel-content list-content'>";
echo"<div class='row-fluid'>
		<div class='span4'>
		<table class='table table-striped'>     
			<thead>
				<tr><td>Nama</td><th>: $r[Nama]</th></tr>
				<tr><td>NIM</td><th>: $r[NIM]</th></tr>
			</thead>
		</table>
		</div>
		<div class='span4'>
		<table class='table table-striped'>     
			<thead>
		<tr><td>PROGRAM STUDI : <b class='pull-right'>$r[JenjangID] - $Prodi</b></td></tr>
		<tr><td> KELAS : <b class='pull-right'>$kelas</b></td></tr>
			</thead>
		</table>
		</div>
		<div class='span4 pull-right'>
		<table class='table table-striped'>     
			<thead>
		<tr><td>TOTAL BIAYA : <span class='pull-right'><b class='pull-right'> $TotBiaya</b></span></td></tr>
		<tr><td>STATUS :  <span class='pull-right'><b class='pull-right'>$status</b></span></td></tr>
			</thead>
		</table>
		</div>";
	
	echo"<table class='table table-striped table-bordered'><thead>
		<tr>
			<th width='20'>No</th>
			<th>Tanggal</th>
			<th>Jenis Biaya</th>
			<th>Keterangan</th>
			<th>Jumlah Bayar</th><th></th>
		</tr>
		</thead><tbody>";

$h = "SELECT * FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi IN ($trans) AND Buku IN ($buku) ORDER BY TglBayar ASC";
$kl = _query($h);
 $no=0;
while ($b = _fetch_array($kl)) {
 $no++;	
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
$namaBiaya=BiayaMhsw($b[SubID]);
}else{
$namaBiaya="Pembayaran Ke <b>".$no."</b>";
}		
		echo"<tr>
			<td class='description'>$no</td>
			<td class='description'>$tglBayar</td>
			<td class='description'>$namaBiaya</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
			<td class='value'></td>
		</tr>";
$Bayar=$b[Debet];
$TotB=$TotB+$b[Debet];
}
$TotalBayar=digit($TotB);
$kekurngan=	$r[TotalBiaya] - $TotB;	
$Totalkekurngan=digit($kekurngan);	
echo"<tfoot>
	<tr><td colspan='5'><b>Total Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$TotalBayar</span></b></td></tr>
	<tr><td colspan='5'><b>Kekurangan Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$Totalkekurngan</span></b></td></tr>

</tfoot></tbody></table>";	
echo"</div></div>";
////////////////////////////
echo"</div>";
?>	
</div></div></div>
<?php }else{
ErrorAkses();
} ?>