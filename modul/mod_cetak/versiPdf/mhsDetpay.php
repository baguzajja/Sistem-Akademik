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
div.special { margin: auto; width:90%; padding: 5px; }
div.special table { width:100%; font-size:10px; border-collapse:collapse; }
-->
</style>
<?php
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='37mm' backbottom='0' backleft='2mm' backright='2mm' style='font-size: 10pt'>";
$ids = $_REQUEST['id'];
 global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.RegID='$ids'";
 $w = _query($s);
 $r = _fetch_array($w);
 $NREG=$r[RegID];
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
 $Kelas=NamaKelasa($r[IDProg]);
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
if($d['kode_jurusan']=='61101'){
	HeaderS2();
}else{
	HeaderS1($Prodi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px;'>
        <tr>
            <th colspan='7' style='width: 100%; text-align:center;'>DETAIL PEMBAYARAN MAHASISWA </th>
        </tr>
		<tr><th colspan='7' style='width: 100%;'>&nbsp;</th></tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NAMA</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$r[Nama]</td>

            <td style='width: 20%;'>&nbsp;</td>

			<td style='width: 15%;'> </td>
			<td style='width: 5%;></td>
			<td style='width: 20%;'></td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NIM</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;$r[NIM]</td>
            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style='; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>PRODI $Prodi</td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;Kelas</td>
			<td style='width: 5%;> : </td>
			<td style='width: 25%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp; $Kelas </td>
            <td style='width: 20%;'>&nbsp;</td>
			<td colspan='3' style='width:; border: solid 1px #EEE; background-color:#fcfcfc; text-align:center;'>JENJANG  $r[JenjangID]</td>
        </tr>
    </table><br>";
	echo"<table class='month' style='width: 100%; color:#444; border: 1px #eee;'>
	<thead>
		<tr>
			<th style='width: 5%;'>No</th>
			<th style='width: 15%;'>Tanggal</th>
			<th style='width: 60%;'>Keterangan</th>
			<th style='width: 20%;'>Jumlah Bayar</th>
		</tr>
		</thead><tbody>";
$h = "SELECT * FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi IN ($trans) AND Buku IN ($buku) ORDER BY TglBayar ASC";
$kl = _query($h);
while ($b = _fetch_array($kl)) {	
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);	
		echo"<tr>
			<td>1</td>
			<td>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td  style='text-align:right;'><span>$Jumlah</span></td>
		</tr>";
$Bayar=$b[Debet];
$TotB=$TotB+$b[Debet];
}
$TotalBayar=digit($TotB);
$kekurngan=	$r[TotalBiaya] - $TotB;	
$Totalkekurngan=digit($kekurngan);	
$tglCetak	= tgl_indo(date("Y m d"));
echo"<tfoot>
	<tr>
<td colspan='3'><b>Total Pembayaran</b></td>
<td style='text-align:right;'><b> <span>$TotalBayar</span></b></td></tr>
	<tr>
<td colspan='3'><b>Kekurangan Pembayaran</b></td>
<td style='text-align:right;'><b> <span >$Totalkekurngan</span></b></td>
	</tr>
	</tfoot>
	</tbody></table><br><br>";
echo"<table style='width: 100%; color:#333; cellpadding:2px;'>
    <tr>
      <td style='width: 30%;'></td>
      <td style='width: 30%;'></td>
      <td style='width: 40%; text-align:right'>
		Dicetak : $tglCetak
		<br>
		
		<br>
		<br>
		<br>
		<br>
		By.  $r[SubmitBy] ( BAU )
	  </td>    
    </tr>
	</table>";
FooterPdf(); 
echo"</page>";
?>