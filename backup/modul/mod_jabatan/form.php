<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('jabatan', 'Jabatan_ID', $rekid, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT DATA JABATAN";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='Jabatan_ID' value='$w[Jabatan_ID]'>";
  }
  else {
    $w = array();
    $w['KodeJabatan'] = '';
    $w['Nama'] = '';
    $w['JabatanUntuk'] = '';
    $w['NA'] = 'Y';
	$jdl = "<i class='icon-plus'></i> TAMBAH JABATAN";
	$btn = "SIMPAN";
	$hiden = "";
  }
   $na = ($w['NA'] == 'Y')? 'checked' : '';
?>
<div class="row">
<div class="span8">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><?php echo $jdl;?></h3>	
	</div>
	<div class="widget-content">
<?php
echo"<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	 $hiden
<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Kode Jabatan</label>
				<div class='controls'>
				<input type=text name='KodeJabatan' value='$w[KodeJabatan]'>
				</div>
			</div>
			
			<div class='control-group'>
				<label class='control-label'>Nama Jabatan</label>
				<div class='controls'>
					<input type=text name='Nama' value='$w[Nama]'>
				</div>
			</div>
<div class='control-group'>
	<label class='control-label'>Jabatan Untuk ?</label>
	<div class='controls'>
		<select name='bagian'>
		<option value=''>- Pilih Departemen -</option>"; 
		$tampil=_query("SELECT * FROM departemen ORDER BY DepartemenId");
		while($d=_fetch_array($tampil)){
		$cek=($w[JabatanUntuk]==$d[DepartemenId])? 'selected':'';
		echo "<option value='$d[DepartemenId]' $cek>$d[NamaDepeartemen]</option>";
        }
		echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Aktif ? </label>
	<div class='controls'>
		<input type='checkbox' name='NA' value='Y' $na>
	</div>
</div>
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanJabatan'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-jabatan.html';\">
</div>			
</fieldset>
</form>";
?>					
</div></div></div>
<div class="span4">
	<div class="widget">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>MODUL JABATAN</h3>		    			
		</div>
	<div class="widget-content">
	<ul>
		<li>Menu Ini Berfungsi untuk mengelola data Jabatan.</li>
		<li>Menambah Jabatan Baru.</li>
		<li>Meng Edit Data Jabatan.</li>
		<li>Meng Hapus Data Jabatan.</li>
	</ul>
	</div>
</div></div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>