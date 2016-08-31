<?php
function defProg(){
buka("Manajemen Kelas");
echo"<div class='row'><p class='pull-right'><a class='btn btn-success' href='aksi-masterprogram-tambahprogram.html'>Tambah Kelas</a></p> </div>"; 
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
    <thead>
    <tr><th>No</th><th>Institusi</th><th>Kode</th><th>Nama Kelas</th><th width='10%'><center>Status</center></th><th></th></tr></thead>";											
		$sql="SELECT t1.*,t2.Nama_Identitas FROM program t1, identitas t2 WHERE t1.Identitas_ID=t2.Identitas_ID ORDER BY t1.ID";
		$qry= _query($sql) or die ();
		while ($r=_fetch_array($qry)){ 
		$sttus = ($r['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$no++;
		echo "<tr>                            
			<td>$no</td>
			<td>$r[Nama_Identitas]</td>
			<td>$r[Program_ID]</td>
			<td>$r[nama_program]</td>
			<td><center>$sttus</center></td>
			<td width='10%'> 
				<center>
					<div class='btn-group'>
					<a class='btn btn-small btn-inverse' href='get-masterprogram-editprogram-$r[ID].html'>Edit</a>
					<a class='btn btn-small btn-danger' href='get-masterprogram-delprog-$r[ID].html' onClick=\"return confirm('Anda yakin akan Menghapus data $r[Program_ID] - $r[nama_program] ?')\">Hapus</a>
					</div>
				</center>
			</td>
			</tr>";        
		} 
   echo" </table>";
tutup();
}

function tambahprogram(){
buka("Tambah Kelas");
echo"<form action='aksi-masterprogram-InputProg.html' method='post'>
    <table class='table table-bordered table-striped'><thead>            
    <tr><td class=cc>Institusi </td>   <td><select name=cmi id=cmi>
        <option value=>Pilih Institusi</option>";
		$s = "SELECT * FROM identitas ORDER BY Identitas_ID";
		$g = _query($s) or die ();
		while($r = _fetch_array($g)){
echo "<option value='$r[Identitas_ID]'>$r[Nama_Identitas]</option>";
		}
echo"</select></td></tr>    
    <tr><td class=cc>Kode</td><td><input type=text name=Program_ID size=10></td></tr>                  
    <tr><td class=cc>Nama Program </td><td><input type=text name=nama_program></td></tr>
    <tr><td class=cc>Aktif </td><td><input type=radio name=aktif value=Y> Y <input type=radio name=aktif value=N> N  </td></tr>           
    <tr><td colspan=2>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Simpan>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterprogram.html'>Batal</a>
				</div>
			</center>
    </td></tr></thead></table></form>";
tutup();
}

function editprogram(){
buka("Edit Kelas");
$e=_query("SELECT * FROM program WHERE ID='$_GET[id]'");
$d=_fetch_array($e);
echo"<form action='aksi-masterprogram-UpdateProg.html' method='post'>
    <table class='table table-bordered table-striped'><thead>            
	<input type=hidden name=ID value='$d[ID]'>
    <tr><td class=cc>Institusi </td>   <td><select name=cmi id=cmi>
        <option value=0>Pilih Institusi</option>";
$tampil=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
while($w=_fetch_array($tampil)){
            if ($d[Identitas_ID]==$w[Identitas_ID]){
              echo "<option value=$w[Identitas_ID] selected>$w[Nama_Identitas]</option>";
            }
            else{
              echo "<option value=$w[Identitas_ID]>$w[Nama_Identitas]</option>";
            }
          }
echo "</select></td></tr>

<tr><td class=cc>Kode </td>       <td><input type=text name=Program_ID value='$d[Program_ID]'  size=10></td></tr>                  
<tr><td class=cc>Nama Program </td>       <td><input type=text name=nama_program  value='$d[nama_program]'></td></tr>";
          if ($d[aktif]=='Y'){
              echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=aktif value=Y checked>Y
                                                                              <input type=radio name=aktif value=N>N</td></tr>";
          }
          else{
              echo "<tr><td class=cc>Aktif</td>    <td><input type=radio name=aktif value=Y>Y
                                                                              <input type=radio name=aktif value=N checked>N</td></tr>";
          }
echo"<tr><td colspan=2>
			<center>
				<div class='btn-group'>
				<input class='btn btn-success' type=submit value=Update>
				<input class='btn' type=reset value=Reset>
				<a class='btn btn-small btn-danger' href='go-masterprogram.html'>Batal</a>
				</div>
			</center>
</td></tr></thead></table></form>";
}
switch($_GET[PHPIdSession]){
 // Semua content pada program terdapat pada folder form file form_program.php //
  default:
    defProg();
  break;  

  case "tambahprogram":
    tambahprogram();     
  break;

  case "editprogram":
    editprogram();     
  break;
  
  case"InputProg":
        $Program_ID     = $_POST['Program_ID'];
        $nama_program     = $_POST['nama_program'];
        $cmi     = $_POST['cmi'];
        $aktif     = $_POST['aktif'];
        $cek=_num_rows(_query("SELECT * FROM program WHERE Program_ID='$Program_ID'"));
        if ($cek > 0){
        ErrorMsgs("Opss..! ","Data Sudah Ada dalam database");
		tambahprogram();
        }
        else{        
        $query = "INSERT INTO program(Program_ID,nama_program,Identitas_ID,aktif)VALUES('$Program_ID','$nama_program','$cmi','$aktif')";
        _query($query);
		SuksesMsgs("Kelas Berhasi Di simpan ","");
		defProg();
        }	  
    
  break;

  case "UpdateProg":
    $update=_query("UPDATE program SET Program_ID  = '$_POST[Program_ID]',
                                          nama_program  = '$_POST[nama_program]',
                                          Identitas_ID  = '$_POST[cmi]',
                                          aktif       = '$_POST[aktif]'                                                                                   
                                    WHERE ID          = '$_POST[ID]'");
    $data=_fetch_array($update);
	SuksesMsgs("Kelas Berhasi Di Update ","");
    defProg();    
  break;
  
  case "delprog";
	$sql="DELETE FROM program WHERE ID='$_GET[id]'";
	$qry=_query($sql) or die();
	SuksesMsgs("Kelas Berhasi Di Hapus ","");
    defProg();
  break;
}
?>
