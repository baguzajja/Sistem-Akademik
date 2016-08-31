<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('honorrektorat', 'HonorRektorID', $rekid, '*');
	$jdl	= "<i class='icon-pencil'></i> EDIT PENGATURAN HONOR REKTORAT";
	$GajiPokok = Comaa($w['GajiPokok']);
	$TnjanganTransport = Comaa($w['TnjanganTransport']);
	$TnjanganJabatan = Comaa($w['TnjanganJabatan']);
	$btn	= "UPDATE";
    $hiden = "<input type=hidden name='HonorRektorID' value='$w[HonorRektorID]'>";
	$where = "";
  }
  else {
    $w = array();
    $w['HonorRektorID'] = '';
    $w['IDRektor'] = '';
    $GajiPokok = '';
    $TnjanganTransport = '';
    $TnjanganJabatan = '';
    $w['Keterangan'] = '';
	$jdl = "<i class='icon-plus'></i> TAMBAH PENGATURAN HONOR REKTORAT";
	$btn = "SIMPAN";
	$where = "AND id NOT IN (SELECT IDRektor FROM honorrektorat)";
    $hiden = "";
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
				<label class='control-label'>Staff Rektorat</label>
					<div class='controls'>
			<select name='StaffRektor' class='input-xxlarge'>
			<option value=''>- Pilih Staff Rektorat -</option>";
			$jbtn=_query("SELECT * FROM karyawan WHERE Bagian='YPN05' $where ORDER BY nama_lengkap");
			while($j=_fetch_array($jbtn)){
			$cek=($w[IDRektor]==$j[id]) ? "selected":"";
			echo "<option value='$j[id]' $cek>$j[nama_lengkap]</option>";
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Gaji Pokok</label>
				<div class='controls'>
					<input type=text name='GajiPokok' class='input-xxlarge' value='$GajiPokok' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tunjangan Transport</label>
				<div class='controls'>
					<input type=text name='TnjanganTransport' class='input-xxlarge' value='$TnjanganTransport' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tunjangan Jabatan</label>
				<div class='controls'>
					<input type=text name='TnjanganJabatan' class='input-xxlarge' value='$TnjanganJabatan' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan' class='input-xxlarge'>$w[Keterangan]</textarea>
				</div>
			</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanHR'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-settingKeuangan-HonorRektor.html';\">
</div> 
</div> 
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>