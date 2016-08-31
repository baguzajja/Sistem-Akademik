<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
$Jabatan=NamaJabatan($_GET[id]);
?>
<div class="row">
<form class='form-horizontal' method='post'> 
<input type='hidden' name='jabatan' value='<?php echo $_GET[id];?>'>
<div class="span4">
	<div class="widget widget-table">
		<div class="widget-header">
			<h3>GROUP MODUL :: UNTUK <?php echo strtoupper($Jabatan);?></h3>	    			
		</div>
	<div class="widget-content">
<?php
echo"<table class='table table-bordered table-striped'>
	<thead><tr><th><center>Pilih</center></th><th>Parent Module</th>
	</tr></thead><tbody>";
$sql="SELECT * FROM modul WHERE parent_id='0' ORDER BY id";
	$qry= _query($sql) or die ("SQL Error:"._error());
	while ($data=_fetch_array($qry)){
	$no++;
	echo "<tr>";
	$sqlr="SELECT * FROM hakmodul WHERE id_level='$_GET[id]' AND id='$data[id]'";
	$qryr= _query($sqlr);
	$cocok=_num_rows($qryr);
	$cek = ($cocok==1) ? 'checked' : '';    
	$cekAkses = ($cocok==1) ? 'Tutup akses parent' : 'Buka akses parent';    
	echo "<td><center><input name=CekModul[] class='ui-tooltip' data-placement='right' title='$cekAkses' type=checkbox value=$data[id] $cek></center></td>           
		<td>$data[judul] </td></tr>";
	}

echo"</tbody></table>";
?>		
</div><div class='widget-toolbar'>
		<div class='btn-group'>
			<input class='btn btn-success btn-large' type='submit' value='SIMPAN' name="SimpanAkses">
			<input type='button' value='Batal' class='btn btn-danger btn-large' onclick="window.location.href='go-akses.html';">
		</div>
</div></div></div> 
<div class="span8">
<div class="widget widget-table toolbar-bottom">
	<div class="widget-header">	      				
		<h3>SETTING HAK AKSES MODUL :: UNTUK <?php echo strtoupper($Jabatan);?></h3>	
	</div>
	<div class="widget-content">
<?php
echo"<table class='table table-bordered table-striped'>
	<thead>";
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
	echo "<td><center><input name=CekModul[] id='checkall' class='ui-tooltip' data-placement='right' title='Perbolehkan Semua Akses'  type=checkbox value=$data[id] $cek></center></td>             
        <td>$namaGrup</td>
		<td>$data[judul]</td>
		<td><center><input name='buat$data[id]' class='ui-tooltip' data-placement='top' title='Hak Buat' type='checkbox' value='$buat' $cek0></center></td>
		<td><center><input name='baca$data[id]' class='ui-tooltip' data-placement='top' title='Hak Lihat' type='checkbox' value='$baca' $cek1></center></td>
		<td><center><input name='tulis$data[id]' class='ui-tooltip' data-placement='top' title='Hak Edit' type='checkbox' value='$tulis' $cek2></center></td>
		<td><center><input name='hapus$data[id]' class='ui-tooltip' data-placement='top' title='Hak Hapus' type='checkbox' value='$hapus' $cek3></center></td>
	</tr>";
	}
echo"</table>";
?>					
</div>
	<div class='widget-toolbar'>
		<div class='btn-group'>
			<input class='btn btn-success btn-large' type='submit' value='SIMPAN' name="SimpanAkses">
			<input type='button' value='Batal' class='btn btn-danger btn-large' onclick="window.location.href='go-akses.html';">
		</div>
	</div>
</div></div>
</form>		 		
</div> 
<?php }else{
ErrorAkses();
} ?>