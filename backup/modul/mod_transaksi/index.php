<?php defined('_FINDEX_') or die('Access Denied'); 
//Start
if($baca){
$actf=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
global $TahunIni;
?>
<div class="row">
<div class="span12">
	<div class="widget">
		<div class="widget-header">						
			<h3><i class="icon-table"></i>TRANSAKSI KEUANGAN</h3>
			<div class="widget-actions">
				<div class="btn-group">
				<a href='go-transaksi.html' class="<?php if(empty($actf) OR $actf=='maba'){echo'btn-primary';}?> btn ui-tooltip" data-placement="bottom" title="Transaksi Mahasiswa baru">Mahasiswa Baru</a>
				<a href='aksi-transaksi-pay.html' class="btn <?php if($actf=='pay'){echo'btn-primary';}?> ui-tooltip" data-placement="bottom" title="Transaksi Pembayaran Mahasiswa">Pembayaran Mahasiswa</a>
				<a href='aksi-transaksi-umum.html'class="btn <?php if($actf=='umum'){echo'btn-primary';}?> ui-tooltip" data-placement="bottom" title="Transaksi Umum">Transaksi Umum</a>
				<a href='aksi-transaksi-jurnal.html'class="btn <?php if($actf=='jurnal'){echo'btn-primary';}?> ui-tooltip" data-placement="bottom" title="Data Semua Transaksi">Jurnal Transaksi</a>
				</div>
			</div>
		</div>
<?php
switch($actf)
{
default :
echo"<form method='post' class='form-horizontal'>";
	require('view_maba.php');
echo"</form>";
break;
case "pay":
echo"<form method='post' class='form-horizontal'>";
	require('view_pay.php');
echo"</form>";
break;
case "umum":
echo"";
	require('view_umum.php');
echo"";
break;
case "jurnal":
	require('view_jurnal.php');
break;
}
?>
</div></div></div>
<?php }else{
ErrorAkses();
} ?>