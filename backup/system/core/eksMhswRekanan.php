<?php
$reknan	= $_REQUEST['id'];
$namaRekan=NamaRekanan($reknan);
$callRekan=CallRekanan($reknan);
$cap="<table align=center border=1px>
<th colspan='6'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>
DAFTAR MAHASISWA REKANAN<br>  $namaRekan ($callRekan) </th>";
$title="<tr>
	<td><b>NO</b></td>
	<td><b>NIM</b></td>
	<td><b>NAMA</b></td>
	<td><b>TOTAL BIAYA</b></td>
	<td><b>TOTAL PEMBAYARAN</b></td>
	<td><b>KEKURANGAN PEMBAYARAN</b></td>
</tr>";
$sql="SELECT * FROM mahasiswa a, keuanganmhsw b WHERE a.NoReg=b.RegID AND a.RekananID='$reknan' AND a.NIM!='' AND a.LulusUjian='N' ORDER BY a.NIM";
	$qry= _query($sql)or die ();
	while ($r=_fetch_array($qry)){
$sumbayar="SELECT SUM(Debet) AS total FROM transaksi WHERE AccID='' AND Buku IN ('1','2','8','9') AND Transaksi='17'";
$by= _query($sumbayar)or die ();
$br=_fetch_array($by);
$bayar=TotalBayar($r[NoReg]);
$TotalPaymen=digit($bayar);
$totalbya=$r[TotalBiaya];
$biayaTotal=digit($totalbya);

$kekurangan=$totalbya - $bayar;
$Totkurang=digit($kekurangan);

$allBia +=$totalbya;
$AllBiaya=digit($allBia);

$allByar +=$bayar;
$AllBayar=digit($allByar);

$allKrg +=$kekurangan;
$AllKurang=digit($allKrg);
	$no++;
$body.="<tr>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$biayaTotal</span></td>
		<td>Rp. <span class='pull-right'>$TotalPaymen</span></td>
		<td>Rp. <span class='pull-right'>$Totkurang</span></td>
		</tr>";
}			
$body2.="<tfoot><tr>
<td colspan='3'>
<center><span class='badge badge-inverse'>TOTAL</span></center></td>
<td><b>Rp. <span class='pull-right'>$AllBiaya</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllBayar</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllKurang</span></b></td>
</tr></tfoot>";

echo $cap.$title.$body.$body2."</table>";				
?>	
	
	
	