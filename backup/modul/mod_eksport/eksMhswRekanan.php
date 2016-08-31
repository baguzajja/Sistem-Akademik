<?php
$reknan	= $_REQUEST['md'];
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
$qry = _query("SELECT * FROM mahasiswa
	INNER JOIN keuanganmhsw ON mahasiswa.NIM=keuanganmhsw.KeuanganMhswID WHERE keuanganmhsw.Aktif='Y' AND mahasiswa.RekananID='$reknan' AND mahasiswa.NIM!='' AND mahasiswa.LulusUjian='N' ORDER BY mahasiswa.Nama, mahasiswa.NIM ASC");
	while ($r=_fetch_array($qry)){
	$TotBiaya=digit($r['TotalBiaya']);
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
	$j=_query("SELECT SUM(Debet) AS total FROM transaksi WHERE AccID='$r[NoReg]' AND Transaksi IN($trans) AND Buku IN ($buku)");
	$b=_fetch_array($j);
	$WesBayar=digit($b['total']);
	$s=$r['TotalBiaya'] - $b['total'];
	$Kurang=$r['TotalBiaya'] - $b['total'];
	$Sisa=digit($Kurang);
	$no++;
$body.="<tr>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$TotBiaya</span></td>
		<td>Rp. <span class='pull-right'>$WesBayar</span></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
		</tr>";   

$allBia +=$r['TotalBiaya'];
$AllBiaya=digit($allBia);

$allByar +=$b['total'];
$AllBayar=digit($allByar);

$allKrg +=$Kurang;
$AllKurang=digit($allKrg); 

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
	
	
	