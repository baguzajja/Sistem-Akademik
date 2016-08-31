<?php  
function DefaBauRekanan(){
$reknan	= (empty($_POST['rekanan']))? '000' : $_POST['rekanan'];
$namaRekan=NamaRekanan($reknan);
$callRekan=CallRekanan($reknan);
buka("BAU :: Data Mahasiswa - Rekanan");
echo "<div class='panel-content panel-tables'>
	<form name=form1 method=post  action='go-BauRekanan.html'>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>
					<div class='input-prepend input-append pull-left'>
						<span class='add-on'>Pilih Rekanan</span>
						<select name='rekanan' onChange='this.form.submit()'>
						<option value='0'>- Pilih Rekanan -</option>";
						$sqlp="select * from rekanan ORDER BY NamaRekanan DESC";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['RekananID']==$reknan){ $cek="selected"; } else{ $cek=""; }
						echo "<option value='$d[RekananID]' $cek> $d[NamaRekanan]</option>";
						}
						echo"</select>
					</div>
					<div class='pull-right'>
					<div class=btn-group>
					<a class='btn' href='eksport-MhswRekanan-$reknan.html'>Export</a>
					</div>
					</div>
				</th>
			</tr>
			<tr>
<th>
<p class='pull-left'>Nama Rekanan : $namaRekan</p>
<p class='pull-right'>Kontak : $callRekan</p>
</th></tr>
<tr><th></th></tr>
		</thead>
	</table></form></div>";
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
<tr><th>NO</th>
<th>NIM</th>
<th>NAMA</th>
<th>TOTAL BIAYA</th>
<th>TOTAL PEMBAYARAN</th>
<th>KEKURANGAN PEMBAYARAN</th>
</tr>
</thead>";
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
	echo "<tr>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$biayaTotal</span></td>
		<td><a href='get-transaksiKeuangan-DetailKeuMhsw-$r[NoReg].html'>Rp. <span class='pull-right'>$TotalPaymen</span></a></td>
		<td>Rp. <span class='pull-right'>$Totkurang</span></td>
		</tr>";        
		}
	
	echo "<tfoot><tr>
<td colspan='3'>
<center><span class='badge badge-inverse'>TOTAL</span></center></td>
<td><b>Rp. <span class='pull-right'>$AllBiaya</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllBayar</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllKurang</span></b></td>
</tr></tfoot>";
	echo"</table>";
tutup();
}

switch($_GET[PHPIdSession]){

default:
DefaBauRekanan();
break;
}     
        
?>
