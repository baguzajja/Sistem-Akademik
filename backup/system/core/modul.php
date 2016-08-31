<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php
function defaultmodul(){
buka("Managemen Module");
$id= $_REQUEST['codd'];
echo "<div class='toolbar clearfix'>
	<div class='pull-left'>
<div class='input-prepend input-append'> 
	<span class='add-on'>Parent Modul</span>
		<select name='relasi_modul' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option value='in-modul-.html' selected>Pilih Parent Modul</option>";
			$sql=_query("SELECT * FROM modul WHERE parent_id='0' AND aktif='Y' ORDER BY menu_order");
			$no=1;
			while($data=_fetch_array($sql)){    
			if ($data['id_group']==$id){ $cek="selected"; }  else{ $cek=""; }
			echo "<option value='in-modul-$data[id].html' $cek>$data[judul]</option>";
			}
			echo"</select>
	</div>
</div>
	<div class='pull-right'>
	<div class='btn-group'>
	<a class='btn btn-success' href='action-modul-editmodul-1.html'>Tambah Modul</a>
	<a class='btn btn-primary' href='go-modul.html'>Refresh</a>
	</div>
	</div>
</div><legend></legend>";
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
	<thead>
		<tr>
			<th>No</th>
			<th>Modul</th>
			<th>Script</th>
			<th>Keterangan</th>
			<th><center>Status</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>";
	if (empty($id)){
	$AND='';
	}else{
	$AND="and parent_id='$id'";
	}
	$tampil=_query("SELECT * FROM modul WHERE aktif='Y' $AND ORDER BY menu_order");
	$no=1;
	while ($data=_fetch_array($tampil)){
	$sttus = ($data['aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
echo"<tr>
	<td> $no</td>
	<td><a href='actions-modul-editmodul-0-$data[id].html'>$data[judul]</a></td>
	<td>$data[url]</td>
	<td>$data[keterangan]</td>
	<td><center>$sttus</center></td>
	<td>
	<center>
		<div class='btn-group'>
	<a class='btn btn-mini btn-inverse' href='actions-modul-editmodul-0-$data[id].html'>Edit</a>
	<a class='btn btn-mini btn-danger' href='get-modul-HapusModul-$data[id].html' onClick=\"return confirm('Anda yakin akan Menghapus data Modul $data[nama] ?')\">Hapus</a>
		</div>
	</center>
	</td>
	</tr>";
$no++; 
	}  
echo"</tbody></table>";
tutup();
}
function editmodul(){
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('modul', 'id', $id, '*');
    $jdl = "Edit Modul";
    $hiden = "<input type=hidden name='id' value='$w[id]'>";
  } else {
    $w = array();
    $w['parent_id']= '';
    $w['id_group']= '';
    $w['judul']= '';
    $w['menu_order'] = '';
    $w['url'] = '';
    $w['keterangan'] = '';
    $w['aktif'] = '';
    $jdl = "Tambah Modul";
    $hiden = "";
  }
buka("$jdl");
echo"<form id='validate_field_types' class='form-horizontal' method='post' action='aksi-modul-UpModul.html'>
<input type=hidden name='md' value='$md'>
$hiden
<div class='control-group row-fluid'>
	<label class='control-label'>Pilih Parent </label>
	<div class='controls'>
	<select name=id_group id='id_group' class='span12'>";
if($w['parent_id']==0){
echo "<option value='0' selected>Parent Menu</option>";
$sql=_query("SELECT * FROM modul WHERE parent_id='0' AND aktif='Y' ORDER BY menu_order");
while($data=_fetch_array($sql)){
echo "<option value='$data[id]'>$data[judul]</option>";
				}
}else{
echo "<option value=''>Parent Menu</option>";                            
	$sql=_query("SELECT * FROM modul WHERE parent_id='0' AND aktif='Y' ORDER BY menu_order");
	while($data=_fetch_array($sql)){
	if($data['id'] == $w['parent_id']){
		echo "<option value='$data[id]' selected>$data[judul]</option>";
				}else{
		echo "<option value='$data[id]'>$data[judul]</option>";
				}
		}
}
	echo"</select>
	</div>
</div>
<div class='control-group row-fluid'>
	<label class='control-label'>Nama Modul</label>
	<div class='controls'>
	<input type=text name=nama_modul  id='nama_modul' placeholder='Masukkan Nama Modul' class='span12' value='$w[judul]'>
	</div>
</div>
<div class='control-group row-fluid'>
	<label class='control-label'>Urutan Menu</label>
	<div class='controls'>
	<input type=text name=menu_order  id='menu_order' placeholder='Tentukan urutan menu Modul' class='span12' value='$w[menu_order]'>
	</div>
</div>
<div class='control-group row-fluid'>
	<label class='control-label'>Nama Script</label>
	<div class='controls'>
	<input type=text name=url  id='url' placeholder='Nama Script Php' class='span12' value='$w[url]'>
	</div>
</div>

<div class='control-group row-fluid'>
	<label class='control-label'>Keterangan</label>
	<div class='controls'>
	<textarea class='span12' rows='2' cols='20' name='keterangan' id='keterangan' >$w[keterangan]</textarea>
	</div>
</div>

<div class='control-group row-fluid'>
	<label class='control-label'>Status</label>
	<div class='controls'>";
if($w['aktif'] == 'Y'){
	echo"<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N ";
}else{
	echo"<input type=radio name=aktif value='Y'>Y 
		<input type=radio name=aktif value='N' checked>N ";
}
	echo"</div>
</div>
                                 
<div class='row-fluid'>
	<center><div class='btn-group'>
		<input class='btn btn-success' type=submit value=Simpan>
		<input class='btn' type=reset value=Reset>
		<input type=button value='Batal' class='btn btn-danger' onclick=\"window.location.href='go-modul.html';\">
	</div></center>
</div>
</form>"; 
tutup();
}
function simpan() {
	$md 			= $_POST['md']+0;
	$id				= $_POST['id'];
	$nama_modul 	= $_POST['nama_modul']; 
	$url 			= $_POST['url'];   
	$menu_order		= $_POST['menu_order'];        
	$keterangan 	= $_POST['keterangan'];
	$aktif 			= empty($_POST['aktif']) ? 'N' : $_POST['aktif'];
  if ($md == 0) {
	$relasi_modul	= empty($_POST['id_group']) ? '0' : $_POST['id_group'];
	$update=_query("UPDATE modul SET
			parent_id 	= '$relasi_modul',
			judul     	= '$nama_modul',
			url       	= '$url',
			menu_order	= '$menu_order',
			keterangan	= '$keterangan',
			aktif		= '$aktif'
			WHERE id    = '$id'");
      $data=_fetch_array($update);
 PesanOk("Update Modul","Modul Berhasil di Update ","go-modul.html");
  } else {
    $ada = GetFields('modul', 'id', $id, '*');
    if (empty($ada)) {
if($aktif=='N'){
$relasi_modul	= empty($_POST['id_group']) ? '999' : $_POST['id_group'];
}else{
$relasi_modul	= empty($_POST['id_group']) ? '0' : $_POST['id_group'];
}
     $query = "INSERT INTO modul(parent_id,judul,url,menu_order,keterangan,aktif) 
		VALUES('$relasi_modul','$nama_modul','$url','$menu_order','$keterangan','$aktif')";
      _query($query);	  
	PesanOk("Tambah Modul Baru","Modul Baru Berhasil di Simpan ","go-modul.html");
    } else{
	PesanEror("Modul Gagal disimpan", "Modul Sudah ada dalam database");
	}
  }
}
switch($_GET[PHPIdSession]){

  default:
      defaultmodul();
      break;  
  
  case"editmodul":
      editmodul();
  break; 

  case"UpModul":
		simpan();
  break;

  case "HapusModul":
      $sql=_query("DELETE FROM modul WHERE id='$_GET[id]'");
 PesanOk("Hapus Modul","Modul Berhasil di Hapus ","go-modul.html");
  break;
}
?>