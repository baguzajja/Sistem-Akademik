<?php
function defAkses(){
global $buat,$baca,$tulis,$hapus;
if($baca){
buka("Manajemen Hak Akses");
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead><tr><th>NO</th><th>KODE</th><th>JABATAN</th><th>DEPARTEMEN</th><th><center>HAK AKSES</center></th></tr></thead><tbody>"; 
      $sql="SELECT * FROM jabatan ORDER BY Nama ASC";
      $qry= _query($sql) or die ();
      while ($r=_fetch_array($qry)){ 
	  $dept=NamaDepatmen($r[JabatanUntuk]);
      $namaJabatan=strtoupper($r[Nama]);
      $no++;
echo"<tr><td>$no</td>
	<td>$r[KodeJabatan]</td>
	<td>$namaJabatan</td>
	<td>$dept</td>
	<td width='20%'>";
if($tulis){
echo"<center>
			<div class='btn-group'>
			<a class='btn btn-mini' href='get-akses-settingAkses-$r[Jabatan_ID].html'>Hak Akses</a>
	</div></center>";
}
echo"</td></tr>";        
	} 
echo"</tbody></table>";
}else{
ErrorAkses();
}
tutup();     
}

function settingAkses(){
$Jabatan=NamaJabatan($_GET[id]);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> SETTING HAK AKSES :: $Jabatan</div>
<div class='panel-content panel-tables'>
	<table class='table table-bordered table-striped'>
	<form method=POST action='aksi-akses-update.html'>
	<input type=hidden name='jabatan' value='$_GET[id]'>
	<thead><tr><th><center>Pilih</center></th><th colspan='6'>Parent Module</th>
	</tr>";
$sql="SELECT * FROM modul WHERE parent_id='0' ORDER BY id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$_GET[id]' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$cek = ($cocok==1) ? 'checked' : '';    
	echo "<td><center><input name=CekModul[] type=checkbox value=$data[id] $cek></center></td>           
		<td colspan='6'>$data[judul] </td></tr>";
	}
echo"<tr><th><center>Pilih</center></th><th>Group</th><th>Modul</th>
	<th><center>Cread</center></th>
	<th><center>Read</center></th>
	<th><center>Update</center></th>
	<th><center>Delete</center></th>
	</tr></thead>";
	$sql="SELECT * FROM modul WHERE parent_id NOT IN ('0','999') ORDER BY parent_id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$_GET[id]' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$c=_fetch_array($qryr);
	$cek = ($cocok==1) ? 'checked' : ''; 
	$cek0 = ($c[buat]=='Y') ? 'checked' : ''; 
	$cek1 = ($c[baca]=='Y') ? 'checked' : ''; 
	$cek2 = ($c[tulis]=='Y') ? 'checked' : ''; 
	$cek3 = ($c[hapus]=='Y') ? 'checked' : ''; 
	
	$buat 	= ($cocok==1) ? $c[buat] : 'N'; 
	$baca 	= ($cocok==1) ? $c[baca] : 'N'; 
	$tulis 	= ($cocok==1) ? $c[tulis] : 'N'; 
	$hapus 	= ($cocok==1) ? $c[hapus] : 'N'; 

	$namaGrup=NamaGroupMdl($data[parent_id ]);
	echo "<td><center><input name=CekModul[] type=checkbox value=$data[id] $cek></center></td>             
        <td>$namaGrup</td>
		<td>$data[judul]</td>
		<td><center><input name='buat$data[id]' type='checkbox' value='$buat' $cek0></center></td>
		<td><center><input name='baca$data[id]' type='checkbox' value='$baca' $cek1></center></td>
		<td><center><input name='tulis$data[id]' type='checkbox' value='$tulis' $cek2></center></td>
		<td><center><input name='hapus$data[id]' type='checkbox' value='$hapus' $cek3></center></td>
	</tr>";
	}
echo"<tfoot><tr><td colspan='7'>
	<center>
	<div class='btn-group'>
			<input class='btn btn-success' type=submit value=SIMPAN>
			<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-akses.html';\">
		</div>
	</center></td></tr></tfoot>";
echo"</form></table>
	</div>";
}

function simpanAkses() {
		$id_level		=$_POST['jabatan'];
        $CekModul		=$_POST['CekModul'];
	//Update Modul	
	$jum=count($CekModul);
	$qrypil= _query("SELECT * FROM hakmodul WHERE id_level='$id_level'");
	while ($datapil=_fetch_array($qrypil)){
		for($i=0; $i < $jum; ++$i){
			if ($datapil['id'] !=$CekModul[$i]){
			$sqldel= _query("DELETE FROM hakmodul WHERE id_level='$id_level'");
			}
		}
	}
	for($i=0; $i < $jum; ++$i){
	$idn=$CekModul[$i];
	$cocok= _num_rows(_query("SELECT * FROM hakmodul WHERE id_level='$id_level' AND id='$idn'"));
	$buat = (empty($_POST['buat'.$idn])) ? 'N':'Y';
	$baca = (empty($_POST['baca'.$idn])) ? 'N':'Y';
	$tulis = (empty($_POST['tulis'.$idn])) ? 'N':'Y';
	$hapus = (empty($_POST['hapus'.$idn]))? 'N':'Y';
	if (! $cocok==1){

	$sql= "INSERT INTO hakmodul(id_level,id,buat,baca,tulis,hapus) VALUES ('$id_level','$idn','$buat','$baca','$tulis','$hapus')";
	$inputModul=_query($sql) or die ("SQL Input Modul Gagal" ._error());
		}
	}
PesanOk("Update Hak Akses","Hak Akses Berhasil di Update ","go-akses.html");
}

switch($_GET[PHPIdSession]){
	default:
      defAkses();
	break;  
  
	case"settingAkses":
      settingAkses();
	break; 

	case"update":
		simpanAkses();
	break;
}
?>
