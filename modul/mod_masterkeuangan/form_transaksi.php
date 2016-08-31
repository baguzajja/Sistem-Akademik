<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $Bukid = $_REQUEST['id'];
    $w = GetFields('jenistransaksi', 'id', $Bukid, '*');
	$jdl	= "<i class='icon-pencil'></i> EDIT MASTER TRANSAKSI";
	$btn	= "UPDATE";
    $hiden ="<input type=hidden name='id' value='$w[id]'>";
	$Debet 	= Checkbuku('buku', 'id', 'BukuDebet', 'nama', $w[BukuDebet]);
	$Kredit = Checkbuku('buku', 'id', 'BukuKredit', 'nama', $w[BukuKredit]);
  } else {
    $w = array();
    $w['id'] = '';
    $w['Nama'] = '';
    $w['Jenis'] = '';
	$jdl = "<i class='icon-plus'></i> TAMBAH MASTER TRANSAKSI";
	$btn = "SIMPAN";
    $hiden = "";
	$Debet 	= Checkbuku('buku', 'id', 'BukuDebet', 'nama', '');
	$Kredit = Checkbuku('buku', 'id', 'BukuKredit', 'nama', '');
  }
?>
<div class="row">
<div class="span12">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><?php echo $jdl;?></h3>	
	</div>
<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	 $hiden
<fieldset>
		<div class='control-group'>
				<label class='control-label'>Nama Transaksi</label>
				<div class='controls'>
				<div class='row-fluid'>
					<input type=text name='namaTransaksi' value='$w[Nama]' class='input-xxlarge'>
				</div>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Pengaturan</label>
				<div class='controls'>
				<div class='row-fluid'>
					<b>Debet :</b> $Debet
				</div>
				</div>
				<div class='controls'>
				<div class='row-fluid'>
					<b>Kredit :</b> $Kredit
				</div>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jenis Transaksi</label>
				<div class='controls'>
				<div class='row-fluid'>
					<select name='jenis' class='input-xxlarge'>
					<option value=0 selected>- Pilih Jenis Transaksi -</option>";
					$t=_query("SELECT * FROM jenise ORDER BY id");
					while($j=_fetch_array($t)){
					$cek=($w['Jenis']==$j[id])? 'selected':'';
					echo "<option value='$j[id]' $cek> $j[nama]</option>";
					}
					echo "</select>
				</div>
				</div>
			</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanTrans'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-masterkeuangan-trans.html';\">
</div> 
</div> 
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>