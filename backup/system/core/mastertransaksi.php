<?php
function defaultMasterTransaksi(){
 $s = "SELECT * FROM jenistransaksi WHERE id NOT IN('17','18','19') ORDER BY id DESC";
 $w = _query($s);
 $no=0;
echo"<div class='panel-header'><i class='icon-group'></i> Master Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-MsterKeuangan.html' class='tab-page' data-toggle='tab'>Master Buku</a></li>
			<li class='active'><a href='#MasterTransaksi' data-toggle='tab'>Master Transaksi</a></li>
		</ul>
		<br/>
		<legend>Master Transaksi <p class='pull-right'><a class='btn btn-success' href='action-mastertransaksi-editMasterTrack-1.html'>Tambah Master Transaksi</a></p></legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA TRANSAKSI</th>
					<th>JENIS TRANSAKSI</th>
					<th><center>AKSI</center></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$no++;
	if ($r['Jenis'] == '1'){
	$jenis="Penerimaan Kas";
	}elseif($r['Jenis'] == '2'){
	$jenis="Pengeluaran Kas";
	}else{
	$jenis="";
	}
	echo"<tr>
			<td width='8%'>$no</td>
			<td>$r[Nama]</td>
			<td>$jenis</td>
			<td width='20%'>
				<center>
					<div class='btn-group'>
					<a class='btn btn-mini btn-inverse' href='actions-mastertransaksi-editMasterTrack-0-$r[id].html'>Edit</a>
					<a class='btn btn-mini btn-danger' href='get-mastertransaksi-HapusTrack-$r[id].html' onClick=\"return confirm('Anda yakin akan Menghapus data Master Traksaksi $r[Nama] ?')\">Hapus</a>
					</div>
				</center>
			</td>
		</tr>";
	
}
echo"</tbody></table></div>";
}
function editMasterTrack() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $Bukid = $_REQUEST['id'];
    $w = GetFields('jenistransaksi', 'id', $Bukid, '*');
    $jdl = "Edit Master Transaksi";
    $hiden ="<div class='control-group'>
				<label class='control-label' for='name'>ID Master Transaksi</label>
				<div class='controls'>
					<input type=hidden name='id' value='$w[id]'>
					<input type=text value='$w[id]' disabled>
				</div>
			</div>";
	$btn = "Update";
	$Nama = $w[Nama];
	$Jenis = $w[Jenis];
	$Debet 	= Checkbuku('buku', 'id', 'BukuDebet', 'nama', $w[BukuDebet]);
	$Kredit = Checkbuku('buku', 'id', 'BukuKredit', 'nama', $w[BukuKredit]);
  } else {
    $w = array();
    $w['id'] = '';
    $w['Nama'] = '';
    $w['Jenis'] = '';
    $jdl = "Tambah Master Transaksi";
    $hiden = "";
    $btn = "Simpan";
	$Debet 	= Checkbuku('buku', 'id', 'BukuDebet', 'nama', '');
	$Kredit = Checkbuku('buku', 'id', 'BukuKredit', 'nama', '');

  }
  // Tampilkan
echo "<div class='panel-header'><i class='icon-group'></i> Master Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-MsterKeuangan.html' class='tab-page' data-toggle='tab'>Master Buku</a></li>
			<li class='active'><a href='#MasterTransaksi'  data-toggle='tab'>Master Transaksi</a></li>
		</ul>
		<br/>
		<form id='example_form' action='aksi-mastertransaksi-simpanMasterTrack.html' method=POST name='MsterTransaksi' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
		$hiden
			<div class='control-group'>
				<label class='control-label'>Nama Transaksi</label>
				<div class='controls'>
				<div class='row-fluid'>
					<input type=text name='namaTransaksi' value='$w[Nama]' class='span12'>
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
					<select name='jenis' class='span12'>
			<option value=0 selected>- Pilih Jenis Transaksi -</option>";
			$t=_query("SELECT * FROM jenise ORDER BY id");
			while($j=_fetch_array($t)){
			if($Jenis==$j[id]){
			echo "<option value=$j[id] selected> $j[nama]</option>";
			}else{
			echo "<option value=$j[id]> $j[nama]</option>";
				}
			}
			echo "</select>
				</div>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>$btn</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-mastertransaksi.html'>Batal</a>
			</div>
		</fieldset>
</form></div>";
}
function simpanMasterTrack() {
  $md		= $_POST['md']+0;
  $id 		= $_POST['id'];
  $Nama		= sqling($_POST['namaTransaksi']);
  $Jenis	= sqling($_POST['jenis']);
if (!empty($_POST[BukuDebet])){
	$deb = $_POST[BukuDebet];
	$debet=implode(',',$deb);
}
if (!empty($_POST[BukuKredit])){
	$kred = $_POST[BukuKredit];
	$kredit=implode(',',$kred);
}  
  if ($md == 0) {
    $s = "UPDATE  jenistransaksi SET BukuDebet='$debet',BukuKredit='$kredit',Nama='$Nama',Jenis='$Jenis' WHERE id='$id' ";
    $r = _query($s);
	PesanOk("Update Master Transaksi","Data Master Transaksi Berhasil Di Update","go-mastertransaksi.html");
  }
  else {
    $ada = GetFields('jenistransaksi', 'id', $id, '*');
    if (empty($ada)) {
      $s = "INSERT INTO jenistransaksi (BukuDebet,BukuKredit,Nama,Jenis) values
	  ('$debet','$kredit','$Nama','$Jenis')";
      $r = _query($s);
	PesanOk("Tambah Master Transaksi","Master Transaksi Berhasil Di Simpan","go-mastertransaksi.html");
    } else {
	PesanEror("Gagal Menambah Master Transaksi", "Master Transaksi Sudah ada dalam database");
	}
  }
}
switch($_GET[PHPIdSession]){

  default:
    defaultMasterTransaksi();
  break;  
	  
  case "editMasterTrack":
    editMasterTrack();
  break;
  
  case "simpanMasterTrack":
    simpanMasterTrack();
  break;
  
  case "HapusTrack":
       $sql="DELETE FROM jenistransaksi WHERE id='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Master Transaksi","Data Master Transaksi Berhasil Di Hapus","go-mastertransaksi.html");	
  break;

}
?>
