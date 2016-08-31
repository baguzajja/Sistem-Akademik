<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('honorstaff', 'HonorStaffID', $rekid, '*');
	$UangMakan 		= Comaa($w['UangMakan']);
	$UangLembur		= Comaa($w['UangLembur']);
	$GajiPokok 		= Comaa($w['GajiPokok']);
	$jdl			= "<i class='icon-pencil'></i> EDIT PENGATURAN GAJI STAFF";
	$btn			= "UPDATE";
    $hiden 	= "<input type='hidden' name='HonorStaffID' value='$w[HonorStaffID]'>";
	$where = "";
  }
  else {
    $w = array();
    $w['HonorStaffID'] = '';
    $w['StaffID'] 	= '';
	$UangMakan 		= '';
	$UangLembur		= '';
	$GajiPokok 		= '';
    $w['Keterangan'] = '';
	$jdl = "<i class='icon-plus'></i> TAMBAH PENGATURAN GAJI STAFF";
	$btn = "SIMPAN";
    $hiden = "";
	$where = "AND id NOT IN (SELECT StaffID FROM honorstaff)";
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
				<label class='control-label'>Karyawan</label>
					<div class='controls'>
			<select name='StaffID'>
			<option value=''>- PILIH KARYAWAN -</option>";
			$jbtn=_query("SELECT * FROM karyawan WHERE Bagian NOT IN('YPN05','dosen') $where ORDER BY nama_lengkap DESC");
			while($j=_fetch_array($jbtn)){
			$cek=($w[StaffID]==$j[id])? 'selected':'';
			$namaStaffs=strtoupper($j['nama_lengkap']);
			echo "<option value='$j[id]' $cek>$namaStaffs</option>";
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Gaji Pokok</label>
				<div class='controls'>
					<input type=text name='GajiPokok' value='$GajiPokok' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uang Makan</label>
				<div class='controls'>
					<input type=text name='UangMakan' value='$UangMakan' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uang Lembur</label>
				<div class='controls'>
					<input type=text name='UangLembur' value='$UangLembur' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanGS'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-settingKeuangan-GajiStaff.html';\">
</div> 
</div> 
</fieldset>
</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>