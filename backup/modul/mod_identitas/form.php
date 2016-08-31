<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('identitas', 'ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT DATA IINSTITUSI";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$w[ID]'>";
  } else {
    $w = array();
    $w['ID']= '';
    $w['Identitas_ID']= '';
    $w['KodeHukum']= '';
    $w['Nama_Identitas'] = '';
    $w['TglMulai'] = '';
    $w['Alamat1'] = '';
    $w['Kota'] = '';
    $w['KodePos'] = '';
    $w['Telepon'] = '';
    $w['Fax'] = '';
    $w['Email'] = '';
    $w['Website'] = '';
    $w['NoAkta'] = '';
    $w['TglAkta'] = '';
    $w['NoSah'] = '';
    $w['TglSah'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH INSTITUSI BARU";
    $hiden = "";
	$btn = "SIMPAN";
  }
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
	<label class='control-label'>Kode Institusi</label>
	<div class='controls'>
		<input type='text' name='Kode' value='$w[Identitas_ID]' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Kode Hukum</label>
	<div class='controls'>
		<input type='text' name='KodeHukum' value='$w[KodeHukum]' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Nama Institusi</label>
	<div class='controls'>
		<input type='text' name='Nama' value='$w[Nama_Identitas]' class='input-xlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tanggal Mulai</label>
	<div class='controls'>";
		$tgl_mulai=($md == 0)?substr("$w[TglMulai]",8,2):$today;
			combotgl(1,31,'tgl_mulai',$tgl_mulai);
		$bln_mulai=($md == 0)?substr("$w[TglMulai]",5,2):$BulanIni;
			combobln(1,12,'bln_mulai',$bln_mulai);
		$thn_mulai=($md == 0)?substr("$w[TglMulai]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_mulai',$thn_mulai);
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Alamat</label>
	<div class='controls'>
		<input type='text' name='Alamat1' value='$w[Alamat1]' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Kota - Kodepos </label>
	<div class='controls'>
		<input type='text' name='Kota' value='$w[Kota]' class='input-medium' placeholder='Kota' required>
		<input type='text' name='KodePos' value='$w[KodePos]' class='input-medium'  placeholder='Kode Pos' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Phone - Fax </label>
	<div class='controls'>
		<input type='text' name='Telepon' value='$w[Telepon]' class='input-medium'  placeholder='Nomor Tlp' required>
		<input type='text' name='Fax' value='$w[Fax]' class='input-medium'  placeholder='No Fax' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Website - Email </label>
	<div class='controls'>
		<input type='text' name='Website' value='$w[Website]' class='input-medium'  placeholder='Alamat Situs' required>
		<input type='text' name='Email' value='$w[Email]' class='input-medium'  placeholder='Alamat Email' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>No Akta</label>
	<div class='controls'>
		<input type='text' name='NoAkta' value='$w[NoAkta]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tgl Akta</label>
	<div class='controls'>";
		$tgl_akta=($md == 0)?substr("$w[TglAkta]",8,2):$today;
			combotgl(1,31,'tgl_akta',$tgl_akta);
		$bln_akta=($md == 0)?substr("$w[TglAkta]",5,2):$BulanIni;
			combobln(1,12,'bln_akta',$bln_akta);
		$thn_akta=($md == 0)?substr("$w[TglAkta]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_akta',$thn_akta);
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>No Pengesahan</label>
	<div class='controls'>
		<input type='text' name='NoSah' value='$w[NoSah]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tgl Pengesahan</label>
	<div class='controls'>";
		$tgl_sah=($md == 0)?substr("$w[TglSah]",8,2):$today;
			combotgl(1,31,'tgl_sah',$tgl_sah);
		$bln_sah=($md == 0)?substr("$w[TglSah]",5,2):$BulanIni;
			combobln(1,12,'bln_sah',$bln_sah);
		$thn_sah=($md == 0)?substr("$w[TglSah]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_sah',$thn_sah);
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Status</label>
	<div class='controls row-fluid'>";
		if($w['Aktif'] == 'Y'){
			echo"<input type=radio name='NA' value='Y' checked>Y 
				<input type=radio name='NA' value='N'>N ";
		}else{
			echo"<input type=radio name='NA' value='Y'>Y 
				<input type=radio name='NA' value='N' checked>N ";
		}
	echo"</div>
</div> 
<div class='form-actions'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanIdentitas'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-identitas.html';\">
</div>  
</fieldset>
	</form>";
?>					
</div></div></div>
<div class="span4">
	<div class="widget widget-table toolbar-bottom">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i>General Information</h3>		    			
		</div>

</div></div> 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>