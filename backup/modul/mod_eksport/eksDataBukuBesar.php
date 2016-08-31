<?php
global $today,$BulanIni,$TahunIni;
$id		= $_REQUEST['md'];
$bulan	= $_REQUEST['id'];
$tahun	= $_REQUEST['do'];
if($id==11){
 $keterangan="URAIAN KAS";
 }else{ 
  $keterangan="KETERANGAN";
 }
$buku=NamaBuku($id);
$Bulan=getBulan($bulan);
$cap="<table align=center border=1px>
	<th colspan='5'>Buku Besar :: $buku &nbsp;&nbsp;<small>( $Bulan - $tahun )</th>";
$title="<tr><td><b>TANGGAL</b></td>
	<td><b> $keterangan</b></td>
	<td><b>DEBET</b></td>
	<td><b>KREDIT</b></td>
	<td><b>SALDO</b></td>
	</tr>";
$delimiter = '.';
$space	= '&nbsp;&nbsp;&nbsp;';
$info 	= get_saldo($id,$bulan,$tahun);
$saldo 	= $info;

$saldo_pecah = pecah(abs($saldo),$delimiter);
if($saldo<0)
{
    $sign = 2;	    
    $saldo_str = '('.$saldo_pecah.')';
}
else
{
	$sign 	= 1;
    $saldo_str = $saldo_pecah;
}
$saldo = abs($saldo);
$title2="<tr>
        <td></td>
        <td>Saldo Awal</td>		
        <td></td>
        <td></td>
        <td><span class='pull-right'>$saldo_str</span></td>
    </tr>";
$temp_saldo 	= $saldo;
$jumlah_debet = 0;
$jumlah_kredit = 0;
$tulis = $saldo_str;
$i = 0;

if($id==11){
	$main=_query("SELECT * FROM buku ORDER BY nama DESC");
	while($r=mysql_fetch_array($main)){
		$body.="<tr><th colspan='5'>$r[nama]</th></tr>";
		$sub=_query("SELECT * FROM transaksi WHERE Buku='$r[id]' AND TglBayar LIKE '$tahun-$bulan%' ORDER BY TglBayar,id,Debet DESC");
		while ($r=_fetch_array($sub)){ 
	$tgl			=tgl_indo($r[TglBayar]);
	$nominal_debet 	= $r[Debet];
	$nominal_kredit = $r[Kredit];
	$jumlah_debet 	+= $nominal_debet;
	$jumlah_kredit 	+= $nominal_kredit;
	
	$Debet			=digit($nominal_debet);	
	$Kredit			=digit($nominal_kredit);
	$totalDebet		=digit($jumlah_debet);
	$totalKredit 	=digit($jumlah_kredit);
	
	$temp_saldo = get_saldo_akhir($temp_saldo,$nominal_debet,$nominal_kredit,$sign);
	$tulis		=digit($temp_saldo);
	$tgle		=getBulan($bulan);
		}
	$body.="<tr>                            
		<td><center>$tgle $tahun</center></td>
		<td>Saldo Akhir $r[nama]</td>
		<td><b>Rp. <span class='pull-right'>$totalDebet</span></b></td>
		<td><b>Rp. <span class='pull-right'>$totalKredit</span></b></td>
		<td><b>Rp. <span class='pull-right'>$tulis</span></b></td>
		</tr>";			
              }
	echo "<tfoot>
		<tr>
			<td colspan='5'>&nbsp;&nbsp;&nbsp;</td>
		</tr></tfoot>";			  
         } else { 
	$buku="SELECT * FROM transaksi WHERE Buku='$id' AND TglBayar LIKE '$tahun-$bulan%' ORDER BY TglBayar,id,Debet DESC";
	$qry= _query($buku)or die ();
	while ($r=_fetch_array($qry)){ 
	$tgl			=tgl_indo($r[TglBayar]);
	$nominal_debet 	= $r[Debet];
	$nominal_kredit = $r[Kredit];
	$jumlah_debet 	+= $nominal_debet;
	$jumlah_kredit 	+= $nominal_kredit;
	
	$Debet			=digit($nominal_debet);	
	$Kredit			=digit($nominal_kredit);
	$totalDebet		=digit($jumlah_debet);
	$totalKredit 	=digit($jumlah_kredit);
	
	$temp_saldo = get_saldo_akhir($temp_saldo,$nominal_debet,$nominal_kredit,$sign);
	$tulis		=digit($temp_saldo);
  $Isiuraian=$r[Uraian];
	$i++;
	$body.="<tr>                            
		<td><center>$tgl</center></td>
		<td>$Isiuraian</td>
		<td>Rp. <span class='pull-right'>$Debet</span></td>
		<td>Rp. <span class='pull-right'>$Kredit</span></td>
		<td>Rp. <span class='pull-right'>$tulis</span></td>
		</tr>";        
		}	
	$kaki.= "<tfoot>
		<tr>
			<td colspan='2'><b>JUMLAH</b></td>
			<td><b>Rp. <span class='pull-right'>$totalDebet</span></b></td>
			<td><b>Rp. <span class='pull-right'>$totalKredit</span></b></td>
			<td><b>Rp. <span class='pull-right'>$tulis</span></b></td>
		</tr></tfoot>";		
 }  
echo $cap.$title.$title2.$body.$kaki."</table>";					
?>	
	
	
	