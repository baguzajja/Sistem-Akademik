<?php
function defaultKampus(){
buka("Manajemen Kampus");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-masterkampus-tambahKampus.html'>Tambah Kampus</a></p> </div> ";
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'><thead> 
	<tr><th>No</th><th>Kode</th><th>Nama Kampus</th><th>Alamat</th><th><center>Status</center></th><th></th></tr></thead>"; 
	$sql="SELECT t1.*,t2.Nama_Identitas FROM kampus t1, identitas t2 WHERE t1.Identitas_ID=t2.Identitas_ID ORDER BY Kampus_ID";
	$qry= _query($sql) or die ();
	while ($data=_fetch_array($qry)){
	$sttus = ($data['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$no++;
	echo"<tr>
		<td>$no</td>
		<td>$data[Kampus_ID]</td>
		<td>$data[Nama]</td>
		<td>$data[Alamat], $data[Kota]</td>
		<td><center>$sttus</center></td>
		<td width='10%'> 
		<center>
			<div class='btn-group'>
			<a class='btn btn-small btn-inverse' href='get-masterkampus-EditKampus-$data[Kampus_ID].html'>Edit</a>
			<a class='btn btn-small btn-danger' href='get-masterkampus-delKampus-$data[Kampus_ID].html' onClick=\"return confirm('Anda yakin akan Menghapus Kampus $data[Nama] ?')\">Hapus</a>
			</div>
		</center>
		</td>
		</tr>";        
	} 
echo"</table>";
tutup();
}
function tambahKampus(){
buka("Tambah Kampus");
 echo"<form name=form1 method=post action='aksi-masterkampus-InputKampus.html'>
	<table class='table table-bordered table-striped'><thead>            
	<tr><td class=cc>Kode Kampus</td>       <td class=cb><input type=text name=Kampus_ID></td></tr>                  
	<tr><td class=cc>Nama Kampus</td>       <td class=cb><input type=text name=Nama></td></tr>
	<tr><td class=cc>Institusi</td>       <td class=cb><select name=Identitas_ID>
	<option value=>Pilih Institusi</option>";
	$sql = "SELECT Identitas_ID,Nama_Identitas FROM identitas ORDER BY Identitas_ID";
	$getComboInstitusi = _query($sql) or die ();
	while($data = _fetch_array($getComboInstitusi)){
	echo "<option value='$data[Identitas_ID]'>$data[Identitas_ID] - $data[Nama_Identitas]</option>";
	}
	echo" </select></td></tr>
	<tr><td class=cc>Alamat</td>       <td class=cb><input type=text name=Alamat></td></tr>
	<tr><td class=cc>Kota</td>       <td class=cb><input type=text name=Kota></td></tr>
	<tr><td class=cc>Telepon</td>       <td class=cb><input type=text name=Telepon></td></tr>
	<tr><td class=cc>Fax</td>       <td class=cb><input type=text name=Fax></td></tr>
	<tr><td class=cc>Aktif</td>         <td class=cb><input type=radio name=Aktif value=Y> Y 
	<input type=radio name=Aktif value=N> N  </td></tr>           
	<tr><td colspan=2>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterkampus.html'>Batal</a>
				</div>
			</center>
	</td></tr>
	</thead></table></form>";
tutup();
}
function editKampus(){
buka("Edit Kampus");
    $edit=_query("SELECT * FROM kampus WHERE Kampus_ID='$_GET[id]'");
    $data=_fetch_array($edit);
    echo"<form method=POST action='aksi-masterkampus-UpdateKampus.html'>
		<input type=hidden name=codd value='$data[Kampus_ID]'>
		<table class='table table-bordered table-striped'><thead> 
		<tr><td class=cc>Kode Kampus</td>
		<td><input type=hidden name=Kampus_ID value='$data[Kampus_ID]'><strong> $data[Kampus_ID]</strong></td></tr>                  
		<tr><td class=cc>Nama Kampus</td>       <td><input type=text name=Nama value='$data[Nama]'></td></tr>
		<tr><td class=cc>Institusi</td>       <td><select name=Identitas_ID>";
		$tampil=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
		while($w=_fetch_array($tampil)){
		if ($data[Identitas_ID]==$w[Identitas_ID]){
			echo "<option value=$w[Identitas_ID] selected>$w[Identitas_ID] - $w[Nama_Identitas]</option>";
		}else{
			echo "<option value=$w[Identitas_ID]>$w[Identitas_ID] - $w[Nama_Identitas]</option>";
		}
		}
    echo "</select></td></tr>
          <tr><td class=cc>Alamat</td>       <td><input type=text name=Alamat value='$data[Alamat]'></td></tr>
          <tr><td class=cc>Kota</td>       <td><input type=text name=Kota value='$data[Kota]'></td></tr>
          <tr><td class=cc>Telepon</td>       <td><input type=text name=Telepon value='$data[Telepon]'></td></tr>
          <tr><td class=cc>Fax</td>       <td><input type=text name=Fax value='$data[Fax]'></td></tr>";          
          if ($data[Aktif]=='Y'){
              echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y checked>Y
                                                                              <input type=radio name=Aktif value=N>N</td></tr>";
          }
          else{
              echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=Aktif value=Y>Y
                                                                              <input type=radio name=Aktif value=N checked>N</td></tr>";
          }
              echo"<tr><td colspan=2>
				<center>
					<div class='btn-group'>
					<input class='btn btn-success' type=submit value=Update>
					<a class='btn btn-small btn-danger' href='go-masterkampus.html'>Batal</a>
					</div>
				</center>  
			</td></tr>
	</thead></table></form>";
tutup();
}
switch($_GET[PHPIdSession]){

  default:
    defaultKampus();
  break;  
  case"InputKampus":
        $Kampus_ID     = $_POST['Kampus_ID'];
        $Nama     = $_POST['Nama'];
        $Identitas_ID     = $_POST['Identitas_ID'];
        $Alamat     = $_POST['Alamat'];
        $Kota     = $_POST['Kota'];
        $Telepon     = $_POST['Telepon'];
        $Fax     = $_POST['Fax'];
        $Aktif     = $_POST['Aktif'];
        $cek=_num_rows(_query("SELECT * FROM kampus WHERE Kampus_ID='$Kampus_ID' AND Nama='$Nama'"));
        if ($cek > 0){
        ErrorMsgs("Opss..! ","Data Kampus Sudah Ada dalam database");
        tambahKampus();
        }else{                
        $query = "INSERT INTO kampus(Kampus_ID,Nama,Alamat,Kota,Identitas_ID,Telepon,Fax,Aktif)VALUES('$Kampus_ID','$Nama','$Alamat','$Kota','$Identitas_ID','$Telepon','$Fax','$Aktif')";
        _query($query);
		SuksesMsgs("Kampus Berhasi Di simpan ","");	
		defaultKampus();
        }	  
   
  break;

  case "EditKampus":
    editKampus();
  break;
  
  case "tambahKampus":
    tambahKampus();
  break;

  case "UpdateKampus":
    $update=_query("UPDATE kampus SET Kampus_ID  = '$_POST[Kampus_ID]',
                                          Nama  = '$_POST[Nama]',
                                          Alamat  = '$_POST[Alamat]',
                                          Kota  = '$_POST[Kota]',
                                          Identitas_ID  = '$_POST[Identitas_ID]',
                                          Telepon  = '$_POST[Telepon]',
                                          Fax  = '$_POST[Fax]',
                                          Aktif       = '$_POST[Aktif]'                                                                                   
                                    WHERE Kampus_ID          = '$_POST[codd]'");
    $data=_fetch_array($update);
	SuksesMsgs("Kampus Berhasi Di Update ","");
    defaultKampus();    
  break;

  case "delKampus":
       $sql="DELETE FROM kampus WHERE Kampus_ID='$_GET[id]'";
       $qry=_query($sql) or die();
	SuksesMsgs("Kampus Berhasi Di Hapus","");
    defaultKampus();
  break;
}
?>