<?php
function defaultMasterBuku(){
 $s = "SELECT * FROM buku WHERE id!='11' ORDER BY nama DESC";
 $w = _query($s);
 $no=0;
echo"<div class='panel-header'><i class='icon-group'></i> Master Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#MasterKeuangan' data-toggle='tab'>Master Buku</a></li>
			<li><a href='go-mastertransaksi.html' class='tab-page' data-toggle='tab'>Master Transaksi</a></li>
		</ul>
		<br/>
		<legend>Master Buku <p class='pull-right'><a class='btn btn-success' href='action-MsterKeuangan-editMasterBuku-1.html'>Tambah Master Buku</a></p></legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NAMA BUKU</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$no++;
	echo"<tr>
			<td width='8%'>$no</td>
			<td>$r[nama]</td>
			<td width='20%'>
				<center>
					<div class='btn-group'>
					<a class='btn btn-mini btn-inverse' href='actions-MsterKeuangan-editMasterBuku-0-$r[id].html'>Edit</a>
					<a class='btn btn-mini btn-danger' href='get-MsterKeuangan-HapusBuku-$r[id].html' onClick=\"return confirm('Anda yakin akan Menghapus data Master Buku $r[nama] ?')\">Hapus</a>
					</div>
				</center>
			</td>
		</tr>";
}
echo"</tbody></table></div>";
}
function editMasterBuku() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $Bukid = $_REQUEST['id'];
    $w = GetFields('buku', 'id', $Bukid, '*');
    $jdl = "Edit Master BUKU";
    $hiden = "<div class='control-group'>
				<label class='control-label' for='name'>ID BUKU</label>
				<div class='controls'>
					<input type=hidden name='id' value='$w[id]'>
					<input type=text value='$w[id]' disabled>
				</div>
			</div>";
	$btn = "Update";
  }
  else {
    $w = array();
    $w['id'] = '';
    $w['nama'] = '';
    $jdl = "Tambah Master Buku";
    $hiden = "";
    $btn = "Simpan";
  }
  // Tampilkan
echo "<div class='panel-header'><i class='icon-group'></i> Master Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#MasterKeuangan' data-toggle='tab'>Master Buku</a></li>
			<li><a href='go-mastertransaksi.html' class='tab-page' data-toggle='tab'>Master Transaksi</a></li>
		</ul>
		<br/>
		<form id='example_form' action='aksi-MsterKeuangan-simpanMasterBuku.html' method=POST name='MsterBuku' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
		$hiden
			<div class='control-group'>
				<label class='control-label'>Nama Buku</label>
				<div class='controls'>
					<input type=text name='namaBuku' value='$w[nama]'>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>$btn</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-MsterKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form></div>";
}
function simpanMasterBuku() {
  $md		= $_POST['md']+0;
  $id 		= $_POST['id'];
  $Nama		= sqling($_POST['namaBuku']);
  if ($md == 0) {
    $s = "UPDATE  buku SET nama='$Nama' WHERE id='$id' ";
    $r = _query($s);
	PesanOk("Update Master Buku","Data Master BUku Berhasil Di Update","go-MsterKeuangan.html");
  }
  else {
    $ada = GetFields('buku', 'id', $id, '*');
    if (empty($ada)) {
      $s = "INSERT INTO buku (nama) values('$Nama')";
      $r = _query($s);
	PesanOk("Tambah Master Buku","Master Buku Berhasil Di Simpan","go-MsterKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Master Buku", "Master Buku Sudah ada dalam database");
	}
  }
}
switch($_GET[PHPIdSession]){

  default:
    defaultMasterBuku();
  break;  
	  
  case "editMasterBuku":
    editMasterBuku();
  break;
  
  case "simpanMasterBuku":
    simpanMasterBuku();
  break;
  
  case "HapusBuku":
       $sql="DELETE FROM buku WHERE id='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Buku","Data Buku Berhasil Di Hapus","go-MsterKeuangan.html");	
  break;

}
?>
