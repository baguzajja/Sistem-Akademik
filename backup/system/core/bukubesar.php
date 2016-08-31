<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php  
function Defbukubesar(){
global $today,$BulanIni,$TahunIni;
$id		= (empty($_REQUEST['codd']))? '1' : $_REQUEST['codd'];
$bulan	= (empty($_REQUEST['kode']))? $BulanIni : $_REQUEST['kode'];
$tahun	= (empty($_REQUEST['id']))? $TahunIni : $_REQUEST['id'];

if($id==11){
 $keterangan="URAIAN KAS";
 }else{ 
  $keterangan="KETERANGAN";
 }
buka("Keuangan :: Buku Besar");
echo "<div class='panel-content panel-tables'>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>
				<div class='input-prepend input-append'>
					<span class='add-on'>Pilih Buku</span>
					<select name='buku' onChange=\"MM_jumpMenu('parent',this,0)\">
					<option value='go-bukubesar.html'>- Pilih Buku -</option>";
						$sqlp="SELECT * FROM buku ORDER BY id";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$id){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='us-bukubesar-$d[id]-$bulan-$tahun.html' $cek> $d[nama]</option>";
						}
				echo"</select>
				</div>
				</th>
				<th>
				<div class='row-fluid'>
				<div class='span12'>
				<div class='input-prepend input-append'>
				<span class='add-on'>Bulan</span>";
				Getcombonamabln(01,12,'bulan',$bulan,$id,$tahun);
				echo"<span class='add-on'>Tahun</span>";
				Getcombothn($TahunIni-10,$TahunIni+5,'tahun',$tahun,$id,$bulan);
				echo"
				</div>
				</div>
				</div>
				</th>
			</tr>
			<tr><th></th><th></th></tr>
		</thead>
	</table>";
$buku=NamaBuku($id);
$Bulan=getBulan($bulan);
echo"<legend>Buku Besar :: $buku &nbsp;&nbsp;<small>( $Bulan - $tahun )</small>
			<div class='pull-right'>
				<div class=btn-group>
					<a class='btn' href='export-bukuBesar-$id-$bulan-$tahun.html'>Export Ke Excel</a>
				</div>
			</div>
	</legend>
	</div>";
echo"<table class='table table-bordered'><thead>
	<tr><th><center>TANGGAL</center></th><th> $keterangan</th><th width=''><center>DEBET</center></th><th width=''><center>KREDIT</center></th><th width=''><center>SALDO</center></th></tr></thead>";
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
echo"<tr>
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
	//$main=_query("SELECT * FROM buku WHERE id IN ('1','2','8','9') ORDER BY nama DESC");
echo "<tr>
			<td colspan='5'><center>FITUR DALAM PENGEMBANGAN</center></td>
	</tr>";			  
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
	echo "<tr>                            
		<td><center>$tgl</center></td>
		<td>$Isiuraian</td>
		<td>Rp. <span class='pull-right'>$Debet</span></td>
		<td>Rp. <span class='pull-right'>$Kredit</span></td>
		<td>Rp. <span class='pull-right'>$tulis</span></td>
		</tr>";        
		}	
	echo "<tfoot>
		<tr>
			<td colspan='2'><b>JUMLAH</b></td>
			<td><b>Rp. <span class='pull-right'>$totalDebet</span></b></td>
			<td><b>Rp. <span class='pull-right'>$totalKredit</span></b></td>
			<td><b>Rp. <span class='pull-right'>$tulis</span></b></td>
		</tr></tfoot>";		
 }  

	echo"</table>";
tutup();
}

switch($_GET[PHPIdSession]){

default:
Defbukubesar();
break;

}     
        
?>
