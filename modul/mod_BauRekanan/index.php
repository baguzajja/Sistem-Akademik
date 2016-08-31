<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php defined('_FINDEX_') or die('Access Denied'); 
 if($baca){ 
global $today,$BulanIni,$TahunIni; 
$reknan	= (empty($_POST['rekanan']))? '' : $_POST['rekanan'];
$namaRekan=NamaRekanan($reknan);
$callRekan=CallRekanan($reknan);

$md=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($md)
{
default :
?>
<div class="row">
	<div class="span12">
<form method="post" id="form">
	   <div class="widget widget-table">
<?php
echo"<div class='widget-content'>";
echo "<div class='widget-header'>						
		<h3><i class='icon-book'></i>DATA MAHASISWA & PEMBAYARAN REKANAN</h3>
		<div class='widget-actions'>
				<div class='input-prepend input-append'>
					<span class='add-on'>Pilih Rekanan</span>
					<select name='rekanan' onChange='this.form.submit()' class='input-xxlarge'>
						<option value='0'>- Pilih Rekanan -</option>";
						$sqlp="select RekananID,NamaRekanan from rekanan ORDER BY NamaRekanan DESC";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['RekananID']==$reknan){ $cek="selected"; } else{ $cek=""; }
						echo "<option value='$d[RekananID]' $cek> $d[NamaRekanan]</option>";
						}
						echo"</select>
				</div>	
					
		</div> 
	</div>";
if(!empty($reknan)){
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<h4 style='margin-bottom: 0;margin-top: 5px;'><i class='icon-user'></i> &nbsp;&nbsp; $namaRekan &nbsp;&nbsp; ( Phone : $callRekan )</h4>
</div>
<div class='pull-right'>
<h4 style='margin-bottom: 0;margin-top: 0px;'>
<div class='btn-group'>
    <a class='btn btn-small btn-success' href='action-BauRekanan-Pembayaran-$reknan.html'><i class='icon-plus'></i> Pembayaran </a>
    <a class='btn btn-small btn-inverse' href='action-eksport-MhswRekanan-$reknan.html'><i class='icon-share'></i> Export </a>
</div>
</h4>

</div>
</div></div>";

echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
<tr><th>NO</th>
<th>NIM</th>
<th>NAMA</th>
<th>TOTAL BIAYA</th>
<th>TOTAL PEMBAYARAN</th>
<th>KEKURANGAN PEMBAYARAN</th>
</tr>
</thead>";
	$qry = _query("SELECT * FROM mahasiswa
	INNER JOIN keuanganmhsw ON mahasiswa.NIM=keuanganmhsw.KeuanganMhswID WHERE keuanganmhsw.Aktif='Y' AND mahasiswa.RekananID='$reknan' AND mahasiswa.NIM!='' AND mahasiswa.LulusUjian='N' ORDER BY mahasiswa.Nama, mahasiswa.NIM ASC");
	while ($r=_fetch_array($qry)){
	$TotBiaya=($r['TotalBiaya']== 0)? "<a href='actions-transaksi-pay-EditKeuangan-$r[RegID].html' class='ui-tooltip' data-placement='top' title='Klik Untuk Setting Biaya'>Belum Di Setting</a>":digit($r['TotalBiaya']);
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
	echo "<tr>                            
		<td>$no</td>
		<td><a href='action-BauRekanan-DetailKeuangan-$r[NoReg].html' class='ui-tooltip' data-placement='right' title='Detail Keuangan Mahasiswa'>$r[NIM]
			</a></td>
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
	
	echo "<tfoot><tr>
<td colspan='3'>
<center><span class='badge badge-inverse'>TOTAL</span></center></td>
<td><b>Rp. <span class='pull-right'>$AllBiaya</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllBayar</span></b></td>
<td><b>Rp. <span class='pull-right'>$AllKurang</span></b></td>
</tr></tfoot>";
	echo"</table>";
}else{
  echo "<div class='widget-content alert-info'>
		<center><br><br>
				<h2>Data Mahasiswa Rekanan</h2>
				<div class='error-details'>
					Untuk Melihat Data Rekanan, Silahkan Pilih Rekanan.
				</div> 
				<br>
				<br>
		</center>
		</div>";
}
echo"</div></div></form></div></div>";
break;

case "DetailKeuangan":
	require_once('detailKeuangan.php');
break;

case "Pembayaran":
echo"<form method='post' class='form-horizontal'>";
	require('form_pembayaran.php');
echo"</form>";   
break;

}

?>
<?php }else{
ErrorAkses();
} ?>