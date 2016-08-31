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
global $today,$BulanIni,$TahunIni; ?>
<div class="row">
	<div class="span12">
	   <div class="widget widget-table">
<?php
$reknan	= (empty($_POST['rekanan']))? '' : $_POST['rekanan'];
$namaRekan=NamaRekanan($reknan);
$callRekan=CallRekanan($reknan);
echo "<div class='widget-header'>						
		<h3><i class='icon-book'></i>DATA REKANAN</h3>
		<div class='widget-actions'><form method='post' id='form'>
				<div class='input-prepend input-append'>
					<span class='add-on'>Pilih Rekanan</span>
					<select name='rekanan' onChange='this.form.submit()' class='input-xxlarge'>
						<option value='0'>- Pilih Rekanan -</option>";
						$sqlp="select * from rekanan ORDER BY NamaRekanan DESC";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['RekananID']==$reknan){ $cek="selected"; } else{ $cek=""; }
						echo "<option value='$d[RekananID]' $cek> $d[NamaRekanan]</option>";
						}
						echo"</select>
				</div>	
			</form>		
		</div> 
	</div>";
echo"<div class='widget-content'>";
$md=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($md)
{
default :
if(!empty($reknan)){
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<h4 style='margin-bottom: 0;margin-top: 5px;'><i class='icon-user'></i> &nbsp;&nbsp; $namaRekan &nbsp;&nbsp; ( Phone : $callRekan )</h4>
</div>
<div class='pull-right'>

</div>
</div></div>";

echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead>
<tr><th>NO</th>
<th>NIM</th>
<th>NAMA</th>
<th><center>STATUS</center></th>
<th><center>AKSI</center></th>
</tr>
</thead>";
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
	//$WesBayar=digit($b['total']);
	//$s=$r['TotalBiaya'] - $b['total'];
	$Kurang=$r['TotalBiaya'] - $b['total'];
    if($r['TotalBiaya'] == 0){
    $status="<span class='label'>BELUM LUNAS</span>";
    }else{
    $status=($Kurang > 0) ? "<span class='label'>BELUM LUNAS</span>": "<span class='label label-success'>LUNAS</span>";
    }
	$no++;
	echo "<tr>                            
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td><center>$status</center></td>
		<td><center><a href='get-AkademikRekanan-editMhsRek-$r[MhswID].html' class='btn btn-mini'>Edit</a></center></td>
		</tr>";    
//$allBia +=$r['TotalBiaya'];
//$AllBiaya=digit($allBia);

//$allByar +=$b['total'];
//$AllBayar=digit($allByar);

//$allKrg +=$Kurang;
//$AllKurang=digit($allKrg);    
		}
	echo"</table>";
}else{
  echo "<div class='widget-content alert-info'>
		<center><br><br>
				<h2>Data Mahasiswa Rekanan</h2>
				<div class='error-details'>
					Untuk Melihat Data mahasiswa Rekanan, Silahkan Pilih Rekanan.
				</div> 
				<br>
				<br>
		</center>
		</div></div>";
}
break;
case "editMhsRek":
	require('formEditMhsRek.php');
break;
}
echo"</div>";
?>
</div></div>
<?php }else{
ErrorAkses();
} ?>