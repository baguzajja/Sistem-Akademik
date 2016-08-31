<?php
function defaultRekanan(){
buka("Master Rekanan");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-masterrekanan-tambahrekanan.html'>Tambah Rekanan</a></p> </div>
    <table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>No</th><th>Institusi</th><th>Nama</th><th>Phone</th><th>Aksi</th></tr></thead><tbody>"; 
      $sql="SELECT * FROM rekanan ORDER BY RekananID ";
      $qry= _query($sql) or die ();
      while ($r=_fetch_array($qry)){ 
      $no++;
echo"<tr><td>$no</td>
	<td>$r[Institusi]</td>
	<td>$r[NamaRekanan]</td>
	<td>$r[Telepon]</td>
	<td width='20%'>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='get-masterrekanan-edit-$r[RekananID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-masterrekanan-HapusRekanan-$r[RekananID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Rekanan $r[NamaRekanan] ?')\">Hapus</a>
			</div>
		</center>
	</td></tr>";        
	} 
echo"</tbody></table>";
tutup();      
}

function tambahrekanan(){
buka("Tambah Rekanan");
echo"<form action='aksi-masterrekanan-InputRekanan.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
    <tr><td class=cc>Nama Rekanan</td>
	<td><input type=text name='NamaRekanan' value='$_POST[NamaRekanan]'></td></tr>
    <tr><td class=cc>Nama Perusahaan</td>
	<td><input type=text name=Institusi value='$_POST[Institusi]'></td></tr>
    <tr><td class=cc>Alamat </td>
	<td><input type=text name='Alamat' value='$_POST[Alamat]'></td></tr>
    <tr><td class=cc>Kota</td>
	<td><input type=text name='Kota' value='$_POST[Kota]'></td></tr>
    <tr><td class=cc>Kode pos</td>
	<td><input type=text name='Kodepos' value='$_POST[Kodepos]'></td></tr>
    <tr><td class=cc>Telepon</td>
	<td><input type=text name='Telepon' value='$_POST[Telepon]'></td></tr>
    <tr><td class=cc>Fax</td>
	<td><input type=text name='Fax' value='$_POST[Fax]'></td></tr>
	<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<a class='btn btn-small btn-danger' href='go-masterrekanan.html'>Batal</a>
			</div>
	</center>
	</td></tr>
	</thead></table></form>";
tutup();
}

function editrekanan(){
buka("Edit Rekanan");
    $edit = _query("SELECT * FROM rekanan WHERE RekananID='$_GET[id]' ORDER BY RekananID");
    $r    = _fetch_array($edit);
echo"<form action='aksi-masterrekanan-UpdateRekanan.html' method='post'>
    <table class='table table-bordered table-striped'><thead>
    <input type=hidden name='ID' value='$r[RekananID]'>
    <tr><td class=cc>Nama Rekanan</td>
	<td><input type=text name='NamaRekanan' value='$r[NamaRekanan]'></td></tr>
    <tr><td class=cc>Nama Perusahaan</td>
	<td><input type=text name=Institusi value='$r[Institusi]'></td></tr>
    <tr><td class=cc>Alamat </td>
	<td><input type=text name='Alamat' value='$r[Alamat]'></td></tr>
    <tr><td class=cc>Kota</td>
	<td><input type=text name='Kota' value='$r[Kota]'></td></tr>
    <tr><td class=cc>Kode pos</td>
	<td><input type=text name='Kodepos' value='$r[Kodepos]'></td></tr>
    <tr><td class=cc>Telepon</td>
	<td><input type=text name='Telepon' value='$r[Telepon]'></td></tr>
    <tr><td class=cc>Fax</td>
	<td><input type=text name='Fax' value='$r[Fax]'></td></tr>
	<tr><td colspan=2>
	<center>
			<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Update>
				<a class='btn btn-small btn-danger' href='go-masterrekanan.html'>Batal</a>
			</div>
	</center>
	</td></tr>
	</thead></table></form>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
    defaultRekanan();
  break;  
	  
  case "edit":
    editrekanan();
  break;

  case "tambahrekanan":
    tambahrekanan();
   break;
       
  case"InputRekanan":
	$cek=_num_rows(_query("SELECT * FROM rekanan  WHERE NamaRekanan='$_POST[NamaRekanan]'"));
        if ($cek > 0){
	PesanEror("Tambah Data Rekanan", "Gagal Menambah Rekanan. Data Sudah ada dalam Database");
        }
        else{
        $query = "INSERT INTO rekanan(NamaRekanan,Institusi,Alamat,Kota,Kodepos,Telepon,Fax)
			VALUES('$_POST[NamaRekanan]','$_POST[Institusi]','$_POST[Alamat]','$_POST[Kota]','$_POST[Kodepos]','$_POST[Telepon]','$_POST[Fax]')";
        _query($query);
	PesanOk("Tambah Data Rekanan","Data Rekanan Berhasil Di Simpan","go-masterrekanan.html");	
        }	  
  break;
  
  case "UpdateRekanan":
    $update=_query("UPDATE rekanan SET NamaRekanan  = '$_POST[NamaRekanan]',
			Institusi		= '$_POST[Institusi]',
			Alamat			= '$_POST[Alamat]',
			Kota			= '$_POST[Kota]',
			Kodepos     	= '$_POST[Kodepos]',
			Telepon     	= '$_POST[Telepon]',
			Fax     		= '$_POST[Fax]'                                                                                  
			WHERE RekananID = '$_POST[ID]'");
	if ($update){
	PesanOk("Update Data Rekanan","Data Rekanan Berhasil Di Update","go-masterrekanan.html");
	} else {
	PesanEror("Update Data Rekanan", "Gagal Update Rekanan ");
	}   
  break;

  case "HapusRekanan":
       $sql="DELETE FROM rekanan WHERE RekananID='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Rekanan","Data Rekanan Berhasil Di Hapus","go-masterrekanan.html");	
  break;

}
?>
