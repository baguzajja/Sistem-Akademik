<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid 	= $_REQUEST['id'];
    $w 		= GetFields('biayamhsw', 'BiayaMhswID', $rekid, '*');
	$Jumlah	= Comaa($w['Jumlah']);
	$jdl 	= "<i class='icon-pencil'></i> EDIT PENGATURAN BIAYA MAHASISWA";
	$btn 	= "UPDATE";
    $hiden 	= "<input type='hidden' name='BiayaMhswID' value='$w[BiayaMhswID]'>";
  } else {
    $w					= array();
    $w['BiayaMhswID']	= '';
    $w['NamaBiaya']		= '';
	$Jumlah				='';
    $w['Keterangan']	= '';
    $w['TahunID']		= $TahunIni;
    $w['JenjangID']		= '';
    $w['KelasID']		= '';
	$jdl 				= "<i class='icon-plus'></i> TAMBAH PENGATURAN BIAYA MAHASISWA";
	$btn 				= "SIMPAN";
    $hiden 				= "";
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
		<div class='row-fluid'>
				<div class='span4'>
					<label class='control-label'>Tahun *</label>
					<div class='controls'>";
					combothn($TahunIni-12,$TahunIni+10,'tahun',$w[TahunID]);
					echo "</div>
				</div>
				<div class='span4'>
					<label class='control-label'>Jenjang *</label>
					<div class='controls'>
						<select name='jenjang' class='span12' required>
						<option value=''>-  Pilih Jenjang -</option>";
						$jenjang = array("S1" => "S1", 
										"S2" => "S2");
						foreach ($jenjang as $nw=>$nama)
						{
							$cek=($nw==$w['JenjangID'])? 'selected':'';
							echo "<option value='$nw' $cek>$nama</option>";
						}
						echo"</select>
					</div>
				</div>
<div class='span4'>
					<label class='control-label'>Kelas *</label>
					<div class='controls'>
						<select name='kelas' class='span12' required>
						<option value=''>-  Pilih Kelas -</option>";
						$sqlp="SELECT * FROM program WHERE Identitas_ID='$_SESSION[Identitas]' ORDER BY nama_program";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
							if ($d['ID']==$w['KelasID']){$cek="selected";}else{ $cek="";} 
						echo "<option value='$d[ID]' $cek>$d[nama_program]</option>";
							}
						echo"</select>
					</div>
				</div>
		</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Nama Biaya</label>
				<div class='controls'>
					<input class='span12' type=text name='NamaBiaya' value='$w[NamaBiaya]' required>
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Jumlah</label>
				<div class='controls'>
					<input class='span12' type=text name='Jumlah' value='$Jumlah' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" required>
				</div>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span12'>
			<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea class='span12' name='Keterangan'>$w[Keterangan]</textarea>
				</div>
		</div>
	</div>
</div>
<div class='form-actions'>
	<div class='btn-group'>
		<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanBM'>
		<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-settingKeuangan-Mhsw.html';\">
	</div> 
</div> 
</fieldset>
</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>