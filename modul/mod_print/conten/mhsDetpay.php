<?php
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
$ids = $_REQUEST['id'];
?>
<div class="widget-header">	 
    <h3>DETAIL PEMBAYARAN MAHASISWA</h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class='btn btn-inverse' onClick="printFile()"><i class='icon-print'></i>Cetak </a>
        <a class='btn btn-inverse' href="get-print-mhsDetpay-<?php echo $ids;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
 
</div> 
					
<div class="widget-content">
    <div id="yapan">
<?php
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
if($r['kode_jurusan']=='61101'){
	HeaderS2();
}else{
	HeaderS1($Prodi);
}
echo"<table style='width: 100%; font-weight: bold;color:#213699; cellpadding:2px;'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>DETAIL PEMBAYARAN MAHASISWA </th>
        </tr>
		<tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NAMA</td>
			<td colspan='3' style='width: 90%; border: solid 1px #EEE; background-color:#fcfcfc;'>: &nbsp;&nbsp;$r[Nama]</td>
        </tr>
        <tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;NIM</td>
			<td style='width: 40%; border: solid 1px #EEE; background-color:#fcfcfc;'>: &nbsp;&nbsp;$r[NIM]</td>
            <td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;PRODI</td>
			<td style='width: 40%; border: solid 1px #EEE; background-color:#fcfcfc;'>: &nbsp;&nbsp;$Prodi</td>
        </tr>
		<tr>
			<td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;Kelas</td>
			<td style='width: 40%; border: solid 1px #EEE; background-color:#fcfcfc;'>: &nbsp;&nbsp;$Kelas</td>
            <td style='width: 10%; border: solid 1px #EEE; background-color:#fcfcfc;'>&nbsp;&nbsp;JENJANG</td>
			<td style='width: 40%; border: solid 1px #EEE; background-color:#fcfcfc;'>: &nbsp;&nbsp;$r[JenjangID]</td>
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
$no =0;
while ($b = _fetch_array($kl)) {	
$no++;
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);	
		echo"<tr>
			<td>$no</td>
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
	</tbody></table><br>";
echo"<table style='width: 100%; color:#333; cellpadding:2px;'>
    <tr>
      <td style='width: 30%;'></td>
      <td style='width: 30%;'></td>
      <td style='width: 40%; text-align:right'>
		Surabaya ,  $tglCetak
		<br>
		
		<br>
		<br>
		<br>
		<br>
	  </td>    
    </tr>
	</table>";
 
    // Variable..
  $dir          = 'media/files/dataprint/';
  $nama_file    =$ids.'.txt';
  $_lf      = "\n";
  $line     = str_pad('-', 80, '-') . $_lf;
    // HEADER
 $t= GetFields('identitas', 'Identitas_ID', $_SESSION['Identitas'], 'Nama_Identitas,KodeHukum,Email,Website,Alamat1,Telepon,Fax,Kota');
if($r['kode_jurusan']=='61101'){
    $hdr  = str_pad($t['Nama_Identitas']." ( STIE YAPAN ) SURABAYA", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad($t['KodeHukum'], 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("PROGRAM PASCASARJANA (S-2) - MAGISTER MANAJEMEN", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("Kampus :  $t[Alamat1] Ph: $t[Telepon]", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad('-', 80, '-') . $_lf.$_lf;
}else{
    $hdr  = str_pad($t['Nama_Identitas']." ( STIE YAPAN ) SURABAYA", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad($t['KodeHukum'], 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("PROGRAM SARJANA (S-1) - ". $Prodi, 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("Kampus :  $t[Alamat1] Ph: $t[Telepon]", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad('-', 80, '-'). $_lf.$_lf;
}
  $hdr .= str_pad("NAMA & NIM", 15, ' ') .str_pad(":", 2, ' ') . str_pad(strtoupper($r['Nama']).' - '.$r['NIM'], 63, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= str_pad("PRODI", 15,' ') .str_pad(":", 2, ' ') . str_pad($Prodi.'('.$r['JenjangID'].')', 63, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= str_pad("KELAS", 15,' ') .str_pad(":", 2, ' ',STR_PAD_BOTH ) . str_pad($Kelas, 28, ' ', STR_PAD_RIGHT);
  $hdr .= str_pad("TOTAL BIAYA", 13,' ') .str_pad(":", 2) .
  str_pad('Rp. '.$TotBiaya, 20, ' ',STR_PAD_LEFT).$_lf;
  $hdr .= $line;
 
  // TITLE
  $hdr .= str_pad('NO', 10) .
          str_pad('TANGGAL', 20, ' ', STR_PAD_RIGHT).
          str_pad('URAIAN', 30, ' ', STR_PAD_RIGHT).
          str_pad('JUMLAH', 20, ' ', STR_PAD_LEFT).$_lf;

  $hdr .= $line;
$hs = "SELECT Debet,TglSubmit,TglBayar,Uraian FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi IN ($trans) AND Buku IN ($buku) ORDER BY TglBayar ASC";
$kls = _query($hs);
$no =1;
while ($s = _fetch_array($kls)) {	
$tglSubmit=tgl_indo($s['TglSubmit']);	
//Tampilkan
    $hdr .= str_pad($no, 10) .
            str_pad(tgl_indo($s['TglBayar']),20, ' ', STR_PAD_RIGHT).
            str_pad($s['Uraian'],30, ' ', STR_PAD_RIGHT).
            str_pad('Rp. '.digit($s['Debet']),20, ' ', STR_PAD_LEFT).$_lf;
//End           
$no++;
}
 
  $hdr .= $line;
  $hdr .= str_pad("TOTAL BAYAR", 25,' ') .str_pad(":", 2, ' ') . str_pad('Rp. '.$TotalBayar, 53, ' ', STR_PAD_LEFT).$_lf;
  $hdr .= $line;
  $hdr .= str_pad("KEKURANGAN", 25,' ') .str_pad(":", 2, ' ') . str_pad('Rp. '.$Totalkekurngan, 53, ' ', STR_PAD_LEFT).$_lf;
  $hdr .= $line; 
   
  $hdr .=str_pad("Surabaya , " .tgl_indo($saiki), 80,' ', STR_PAD_LEFT).$_lf;
  $hdr .=  $_lf;
  $hdr .=  $_lf;
  $hdr .=  $_lf;
  $hdr .=str_pad($_SESSION['Nama'], 80,' ', STR_PAD_LEFT).$_lf;
  
    $handle = fopen($dir.$nama_file,'w+');
    fwrite($handle, $hdr);
    fclose($handle);
   
?>
    </div>
</div> 