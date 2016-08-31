<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('modul', 'id', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT MODUL";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[id]'>";
  } else {
    $w = array();
    $w['parent_id']= '';
    $w['id_group']= '';
    $w['judul']= '';
    $w['menu_order'] = '';
    $w['url'] = '';
    $w['keterangan'] = '';
    $w['class'] = '';
    $w['aktif'] = '';
	$jdl = "<i class='icon-plus'></i> TAMBAH MODUL";
	$btn = "SIMPAN";
    $hiden = "";
  }
?>
<div class="row">
<div class="span8">
<div id="validation" class="widget highlight widget-form">
	<div class="widget-header">	      				
		<h3>
			<i class="icon-pencil"></i>
	      	<?php echo $jdl;?>   					
		</h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'/>
<input type=hidden name='md' value='$md'>
$hiden
<fieldset>
<div class='control-group'>
	<label class='control-label'>Pilih Parent </label>
	<div class='controls'>
	<select name=id_group id='id_group' class=''>";
if($w['parent_id']==0){
echo "<option value='0' selected>Parent Menu</option>";
$sql=_query("SELECT * FROM modul WHERE parent_id='0' AND aktif='Y' ORDER BY menu_order");
while($data=_fetch_array($sql)){
echo "<option value='$data[id]'>$data[judul]</option>";
				}
}else{
echo "<option value=''>--------</option>";                            
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
<div class='control-group'>
	<label class='control-label'>Nama Modul</label>
	<div class='controls'>
	<input type=text name=nama_modul  id='nama_modul' placeholder='Masukkan Nama Modul' class='' value='$w[judul]' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Urutan Menu</label>
	<div class='controls'>
	<input type=text name=menu_order  id='menu_order' placeholder='Tentukan urutan menu Modul' class='' value='$w[menu_order]' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Script</label>
	<div class='controls'>
	<input type=text name=url  id='url' placeholder='Nama Script Php' class='' value='$w[url]' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Class</label>
	<div class='controls'>
	<input type=text name=class placeholder='Nama Class css' value='$w[class]'>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Keterangan</label>
	<div class='controls'>
	<textarea class='' rows='2' cols='20' name='keterangan' id='keterangan' required>$w[keterangan]</textarea>
	</div>
</div>

<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls row-fluid'>";
if($w['aktif'] == 'Y'){
	echo"<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N ";
}else{
	echo"<input type=radio name=aktif value='Y'>Y 
		<input type=radio name=aktif value='N' checked>N ";
}
	echo"</div>
</div>                     
	<div class='form-actions'>
		<input class='btn btn-success btn-large' type=submit value='$btn' name='SimpanModule'>
		<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-modul.html';\">
	</div>
</fieldset>
</form>"; 
?>					
	</div>
</div>

</div>
<div class="span4">
	<div id="formToc" class="widget widget-table">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>Informasi</h3>		    			
		</div>
		<div class="widget-content">
		<table class="table table-bordered table-striped">
			<tbody>
				<tr class="even gradeC">
					<td>Pilih Parent</td>
					<td> Tentukan Menu Induk dari Modul. Atau Kosongkan Jika Modul Dijadikan Parent</td>
				</tr>
				<tr class="even gradeC">
					<td>Nama Modul</td>
					<td> Isi dengan Nama Modul</td>
				</tr>
				<tr class="even gradeC">
					<td>Urutan Menu</td>
					<td> Isi dengan Angka Untuk Urutan Menu</td>
				</tr>
				<tr class="even gradeC">
					<td>Nama Script</td>
					<td> Isi dengan Nama Script dari Modul</td>
				</tr>
				<tr class="even gradeC">
					<td>Keterangan</td>
					<td> Uraian dan Fungsionalitas Modul</td>
				</tr>
				<tr class="even gradeC">
					<td>Status</td>
					<td> Set Status Modul</td>
				</tr>						
			</tbody>
		</table>		
		</div>
	</div>
</div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>