<?php
$id = $_REQUEST['id'];
$Natrans=NamaTransaksi($id);
$cap="<table align=center border=1px><th colspan='6'>DATA TRANSAKSI :: $Natrans</th>";//CAPTION OF THIS REPORT
$title="<tr>
		<th>NO</th>
		<th>NO TRANS</th>
		<th>TANGGAL</th>
		<th>URAIAN</th>
		<th>SUBMIT BY</th>
		<th>JUMLAH</th>
		</tr>";
$no=0;
	$tr="SELECT * FROM transaksi WHERE Transaksi='$id' GROUP BY TransID ORDER BY TglBayar ASC";
	$w=_query($tr);
	while ($r = _fetch_array($w)) {
	$tglTransaksi=tgl_indo($r[TglBayar]);
	if($r['Debet']=='0'){
	$jum=$r[Kredit];
	$jumlah=digit($jum);
	}else{
	$jum=$r[Debet];
	$jumlah=digit($jum);
	}
	$TotB +=$jum;
	$Totalk=digit($TotB);
	$no++;
$body.="<tr>
		<td>$no</td>
		<td>$r[TransID]</td>
		<td>$tglTransaksi</td>
		<td>$r[Uraian]</td>
		<td>$r[SubmitBy]</td>
		<td>Rp. <span class='pull-right'>$jumlah</span></td>
		</tr>";
}
$body2.="<tr>
		<td colspan='5'><b>Total Seluruhnya : </b></td>
		<td><b>Rp. <span class='pull-right'>$Totalk</span></b></td>
		</tr>";
echo $cap.$title.$body.$body2."</table>";					
?>	
	
	
	