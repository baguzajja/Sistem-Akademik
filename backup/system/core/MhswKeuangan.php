<?php
function defMhswKeuangan(){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.KeuanganMhswID='$_SESSION[yapane]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $NREG=$r[RegID];
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
$Prodi=GetName("jurusan","kode_jurusan",$r[ProdiID],"nama_jurusan");
if($Totalkekurngan ==0){
$status="<span class='label'>LUNAS</span>";
}else{
$status="<span class='label label-success'>AKTIF</span>";
}
echo"<div class='panel-header'><i class='icon-sign-blank'></i>Mahasiswa :: Keuangan</div><div class='panel-content'>";
echo"<legend>DETAIL Pembayaran Mahasiswa </legend>
	<div class='row-fluid'>
	<div class='span12'>
		<div class='panel-content'><div class='span4'>
		<table class='table table-striped'>     
			<thead>
				<tr><td>Nama</td><th>: $r[Nama]</th></tr>
				<tr><td>NIM</td><th>: $r[NIM]</th></tr>
			</thead>
		</table>
		</div>
		<div class='span4 pull-right'>
		<table class='table table-striped'>     
			<thead>
		<tr><td>PROGRAM STUDI : <b class='pull-right'>$r[JenjangID] - $Prodi</b></td></tr>
		<tr><td>STATUS : <b class='pull-right'>$status</b></td></tr>
			</thead>
		</table>
		</div>
		</div>";
	
	echo"<div class='panel-content'>
		<table class='table table-bordered table-striped'><thead>
<tr><th colspan='5'>TOTAL BIAYA PENDIDIKAN</th>
<th class='badge-warning'>Rp. <span class='pull-right'>$BiayaPddk</span></th></tr>

<tr><th colspan='5'>POTONGAN BIAYA </th>
<th class=''>Rp. <span class='pull-right'> $Pot</span></th></tr>

<tr><th colspan='5'>TOTAL BIAYA </th>
<th class='badge-warning'>Rp. <span class='pull-right'>$TotBiaya</span></th></tr>

		<tr>
			<th width='20'>No</th>
			<th>Tanggal</th>
			<th>Jenis Biaya</th>
			<th>Keterangan</th>
			<th>Jumlah Bayar</th><th></th></tr>
		</thead><tbody>";

$h = "SELECT * FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi='17' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
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
$namaBiaya="Pembayaran Ke <b>".$b[SubID]."</b>";
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

</tfoot></tbody></table></div>";	
echo"</div></div></div>";
}

switch($_GET[PHPIdSession]){

  default:
    defMhswKeuangan();
  break;  

}
?>
