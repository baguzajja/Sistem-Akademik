<?php
function defaultInventaris(){
buka("Master Inventaris");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-inventaris-tambahInventaris.html'>Tambah Inventaris</a></p> </div>
    <table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>No</th><th>Nama</th><th>Institusi</th><th>Prodi</th><th>Jumlah</th><th>Aksi</th></tr></thead><tbody>"; 
	$sql="SELECT * FROM Inventaris ORDER BY InventarisID ";
	$qry= _query($sql) or die ();
	while ($r=_fetch_array($qry)){
	$NamaKampus=NamaKampus($r['Kampus']);
	$NamaIdentitas=NamaIdentitas($r['Institusi']);
	$no++;
echo"<tr><td>$no</td>
	<td>$r[NamaInventaris]</td>
	<td>$NamaIdentitas - $NamaKampus</td>
	<td>$r[Prodi]</td>
	<td>$r[Jmlah] $r[Satuan]</td>
	<td width='20%'>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='get-inventaris-edit-$r[InventarisID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-inventaris-HapusInventaris-$r[InventarisID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Inventaris $r[NamaInventaris] ?')\">Hapus</a>
			</div>
		</center>
	</td></tr>";        
	} 
echo"</tbody></table>";
tutup();      
}

function tambahInventaris(){
buka("Tambah Inventaris");
echo"<form action='aksi-inventaris-InputInventaris.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
    <tr><td class=cc>Institusi</td>
	<td><select name='Institusi'>
	<option value=0 selected>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
	while($w=_fetch_array($t)){
	echo "<option value=$w[Identitas_ID]> $w[Nama_Identitas]</option>";
                                }                                
	echo "</select></td></tr>
    <tr><td class=cc>Kampus </td>
	<td><select name='kampus'>
	<option value=0 selected>- Pilih Kampus -</option>";
	$t=_query("SELECT * FROM kampus ORDER BY Kampus_ID");
	while($w=_fetch_array($t)){
	echo "<option value=$w[Kampus_ID]> $w[Nama]</option>";
                                }                                
	echo "</select></td></tr>
	<tr><td class=cc>Prodi</td>
	<td>";
	$tampil=_query("SELECT * FROM jurusan ORDER BY jurusan_ID");
	while($r=_fetch_array($tampil)){
	echo "<input type=checkbox name=Jurusan_ID[] value=$r[kode_jurusan]>  $r[nama_jurusan]<br>";
	}
	echo "</td></tr>
    <tr><td class=cc>Nama Inventaris</td>
	<td><input type=text name='NamaInventaris' value='$_POST[NamaInventaris]'></td></tr>
	<tr><td class=cc>Jumlah</td>
	<td><input type=text name='Jumlah' value='$_POST[Jumlah]'></td></tr>
	<tr><td class=cc>Satuan</td>
	<td><input type=text name='Satuan' value='$_POST[Satuan]'></td></tr>
	<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<a class='btn btn-small btn-danger' href='go-inventaris.html'>Batal</a>
			</div>
	</center>
	</td></tr>
	</thead></table></form>";
tutup();
}

function editInventaris(){
buka("Edit Inventaris");
    $edit = _query("SELECT * FROM inventaris WHERE InventarisID='$_GET[id]' ORDER BY InventarisID");
    $r    = _fetch_array($edit);
echo"<form action='aksi-inventaris-UpdateInventaris.html' method='post'>
	<input type=hidden name=ID value='$r[InventarisID]'>
    <table class='table table-bordered table-striped'><thead>
    <tr><td class=cc>Institusi</td>
	<td><select name='Institusi'>
	<option value=0 selected>- Pilih Institusi -</option>";
	$t=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
	while($w=_fetch_array($t)){
		if ($r[Institusi]==$w[Identitas_ID]){
	echo "<option value=$w[Identitas_ID] selected> $w[Nama_Identitas]</option>";
				}else{
	echo "<option value=$w[Identitas_ID]> $w[Nama_Identitas]</option>";
				} 
	}                                
	echo "</select></td></tr>
    <tr><td class=cc>Kampus </td>
	<td><select name='kampus'>
	<option value=0 selected>- Pilih Kampus -</option>";
	$t=_query("SELECT * FROM kampus ORDER BY Kampus_ID");
	while($w=_fetch_array($t)){
	if ($r[Kampus]==$w[Kampus_ID]){
	echo "<option value=$w[Kampus_ID] selected> $w[Nama]</option>";
				}else{
	echo "<option value=$w[Kampus_ID]> $w[Nama]</option>";
				} 
	}                                
	echo "</select></td></tr>
	<tr><td class=cc>Prodi</td>
	<td>";
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan', $r[Prodi]);
	echo "$d";
	
	echo "</td></tr>
    <tr><td class=cc>Nama Inventaris</td>
	<td><input type=text name='NamaInventaris' value='$r[NamaInventaris]'></td></tr>
	<tr><td class=cc>Jumlah</td>
	<td><input type=text name='Jumlah' value='$r[Jmlah]'></td></tr>
	<tr><td class=cc>Satuan</td>
	<td><input type=text name='Satuan' value='$r[Satuan]'></td></tr>
	<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Update>
				<a class='btn btn-small btn-danger' href='go-inventaris.html'>Batal</a>
			</div>
	</center>
	</td></tr>
	</thead></table></form>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
    defaultInventaris();
  break;  
	  
  case "edit":
    editInventaris();
  break;

  case "tambahInventaris":
    tambahInventaris();
   break;
       
  case"InputInventaris":
  	if (!empty($_POST[Jurusan_ID])){
	$jur = $_POST[Jurusan_ID];
	$tag=implode(',',$jur);
	}
	$cek=_num_rows(_query("SELECT * FROM Inventaris WHERE NamaInventaris='$_POST[NamaInventaris]'"));
        if ($cek > 0){
	PesanEror("Tambah Data Inventaris", "Gagal Menambah Inventaris. Data Sudah ada dalam Database");
        }
        else{
        $query = "INSERT INTO inventaris (NamaInventaris,Institusi,Kampus,Prodi,Jmlah,Satuan)
			VALUES('$_POST[NamaInventaris]','$_POST[Institusi]','$_POST[kampus]','$tag','$_POST[Jumlah]','$_POST[Satuan]')";
        _query($query);
	PesanOk("Tambah Data Inventaris","Data Inventaris Berhasil Di Simpan","go-inventaris.html");	
        }	  
  break;
  
  case "UpdateInventaris":
	if (!empty($_POST[kode_jurusan])){
		$jur = $_POST[kode_jurusan];
		$tag=implode(',',$jur);
	}
    $update=_query("UPDATE inventaris SET NamaInventaris  = '$_POST[NamaInventaris]',
			Institusi		= '$_POST[Institusi]',
			Kampus			= '$_POST[kampus]',
			Prodi			= '$tag',
			Jmlah     	= '$_POST[Jumlah]',
			Satuan     	= '$_POST[Satuan]'                                                                                  
			WHERE InventarisID = '$_POST[ID]'");
	if ($update){
	PesanOk("Update Data Inventaris","Data Inventaris Berhasil Di Update","go-inventaris.html");
	} else {
	PesanEror("Update Data Inventaris", "Gagal Update Inventaris ");
	}   
  break;

  case "HapusInventaris":
       $sql="DELETE FROM inventaris WHERE InventarisID='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Inventaris","Data Inventaris Berhasil Di Hapus","go-inventaris.html");	
  break;

}
?>
