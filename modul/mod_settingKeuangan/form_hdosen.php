<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
 $md = $_REQUEST['md']+0;
if ($md == 0) {
    $rekid	= $_REQUEST['id'];
    $w		= GetFields('honordosen', 'HonorDosenID', $rekid, '*');
	$HonorSks = Comaa($w['HonorSks']);
	$TransportTtpMk = Comaa($w['TransportTtpMk']);
	$jdl	= "<i class='icon-pencil'></i> EDIT PENGATURAN HONOR DOSEN";
	$btn	= "UPDATE";
    $hiden = "<input type=hidden name='HonorDosenID' value='$w[HonorDosenID]'>";
  } else {
    $w = array();
    $w['HonorDosenID'] = '';
    $w['JabatanAkdm'] = '';
    $w['JabatanDikti'] = '';
	$HonorSks ='';
	$TransportTtpMk = '';
    $w['Keterangan'] = '';
	$jdl = "<i class='icon-plus'></i> TAMBAH PENGATURAN HONOR DOSEN";
	$btn = "SIMPAN";
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
				<label class='control-label'>Jabatan</label>
					<div class='controls'>
			<select name='JabatanAkdm'>
			<option value=''>- Pilih Jabatan Akademik -</option>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Nama");
			while($j=_fetch_array($jbtn)){
			if ($w[JabatanAkdm]==$j[Jabatan_ID]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
				}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
				} 
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan Dikti</label>
				<div class='controls'>
				<select name='JabatanDikti'>
			<option value=''>- Pilih Jabatan Dikti -</option>";
			$jbtnDikti=_query("SELECT * FROM jabatandikti ORDER BY Nama");
			while($jd=_fetch_array($jbtnDikti)){
			if ($w[JabatanDikti]==$jd[JabatanDikti_ID]){
			echo "<option value=$jd[JabatanDikti_ID] selected>$jd[Nama]</option>";
				}else{
			echo "<option value=$jd[JabatanDikti_ID]>$jd[Nama]</option>";
				} 
				}
			echo "</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Honor / SKS</label>
				<div class='controls'>
					<input type=text name='HonorSks' value='$HonorSks' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Transport Tatap Muka</label>
				<div class='controls'>
					<input type=text name='TransportTtpMk' value='$TransportTtpMk' onkeyup='formatNumber(this);' onchange='formatNumber(this);'>
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
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanDos'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-settingKeuangan-HonorDosen.html';\">
</div> 
</div> 
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>