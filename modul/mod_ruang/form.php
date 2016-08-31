<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('ruang', 'ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT RUANG $w[Nama]";
	$btn = "UPDATE";
	$disable = "disabled";
    $hiden = "<input type=hidden name='Ruang_ID' value='$w[Ruang_ID]'>";
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan',$w[Kode_Jurusan]); 
  } else {
    $w = array();
    $w['Ruang_ID']= '';
    $w['Nama']= '';
    $w['Kampus_ID']= '';
    $w['Lantai'] = '';
    $w['Kode_Jurusan'] = '';
    $w['RuangKuliah'] = '';
    $w['Kapasitas'] = '';
    $w['KapasitasUjian'] = '';
    $w['Keterangan'] = '';
    $w['Aktif'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH RUANG";
    $hiden = "";
	$btn = "SIMPAN";
	$disable = "required";
	$d = GetCheckboxes('jurusan', 'kode_jurusan', 'kode_jurusan', 'nama_jurusan',''); 
  }
?>
<div class="row">
<div class="span12">
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
	<label class='control-label'> Kode Ruang </label>
	<div class='controls'>
		<input type='text' name='Ruang_ID' value='$w[Ruang_ID]' class='input-xxlarge' placeholder='Kode Ruang' $disable>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'> Nama Ruang </label>
	<div class='controls'>
		<input type='text' name='Nama' value='$w[Nama]' class='input-xxlarge' placeholder='Nama Ruang'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Untuk Program Studi</label>
	<div class='controls'>
		$d
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Di Kampus</label>
	<div class='controls'>
		<select name='Kampus_ID' class='input-xxlarge'>";
         $kamp=_query("SELECT * FROM kampus ORDER BY Kampus_ID");
			while($k=_fetch_array($kamp)){
				$s=($k[Kampus_ID]==$w[Kampus_ID])? 'selected':'';
				echo "<option value='$k[Kampus_ID]' $s>$k[Nama]</option>";
		}
    echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'> Lantai</label>
	<div class='controls'>
		<input type='text' name='Lantai' value='$w[Lantai]' class='input-xxlarge' placeholder=''>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Ruang Kuliah ? </label>
	<div class='controls row-fluid'>";
		if($w['RuangKuliah'] == 'Y'){
			echo"<input type=radio name='RuangKuliah' value='Y' checked>Y 
				<input type=radio name='RuangKuliah' value='N'>N ";
		}else{
			echo"<input type=radio name='RuangKuliah' value='Y'>Y 
				<input type=radio name='RuangKuliah' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='control-group'>
	<label class='control-label'>Kapasitas Kuliah</label>
	<div class='controls'>
		<input type='text' name='Kapasitas' value='$w[Kapasitas]' class='input-xxlarge' placeholder='Kapasitas Ruang' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Kapasitas Ujian</label>
	<div class='controls'>
		<input type='text' name='KapasitasUjian' value='$w[KapasitasUjian]' class='input-xlarge' placeholder='Kapasitas Untuk Ujian' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Keterangan</label>
	<div class='controls'>
		<textarea name='Keterangan' class='input-xlarge'  rows='5'>$w[Keterangan]</textarea>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls row-fluid'>";
		if($w['Aktif'] == 'Y'){
			echo"<input type=radio name='Aktif' value='Y' checked>Y 
				<input type=radio name='Aktif' value='N'>N ";
		}else{
			echo"<input type=radio name='Aktif' value='Y'>Y 
				<input type=radio name='Aktif' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanRuang'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-ruang.html';\">
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>