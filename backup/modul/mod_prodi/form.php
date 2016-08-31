<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('jurusan', 'jurusan_ID', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT PROGRAM STUDI $w[nama_jurusan]";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='ID' value='$w[jurusan_ID]'>";
  } else {
    $w = array();
    $w['jurusan_ID']= '';
    $w['Identitas_ID']= '';
    $w['kode_jurusan']= '';
    $w['nama_jurusan'] = '';
    $w['jenjang'] = '';
    $w['Akreditasi'] = '';
    $w['NoSKDikti'] = '';
    $w['TglSKDikti'] = '';
    $w['NoSKBAN'] = '';
    $w['TglSKBAN'] = '';
    $w['Aktif'] = 'N';
    $jdl = "<i class='icon-plus'></i> TAMBAH PROGRAM STUDI";
    $hiden = "";
	$btn = "SIMPAN";
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
	<label class='control-label'>Institusi</label>
	<div class='controls'>
		<select name='institusi' class='input-xxlarge'>";
         $ins=_query("SELECT * FROM identitas ORDER BY Identitas_ID");
			while($in=_fetch_array($ins)){
				$s=($in[Identitas_ID]==$w[Identitas_ID])? 'selected':'';
				echo "<option value='$in[Identitas_ID]' $s>$in[Nama_Identitas]</option>";
		}
    echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Program Studi</label>
	<div class='controls'>
		<input type='text' name='kode_jurusan' value='$w[kode_jurusan]' class='input-medium' placeholder='Kode Prodi' required>
		<input type='text' name='nama_jurusan' value='$w[nama_jurusan]' class='input-xlarge' placeholder='Nama Program Studi' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jenjang</label>
	<div class='controls'><select name='jenjang' >";
        $jenjang=_query("SELECT * FROM jenjang ORDER BY Nama ASC");
        while($d=_fetch_array($jenjang)){
			$cek=($w[jenjang]==$d[Nama])? 'selected':'';
			echo "<option value='$d[Nama]' $cek>$d[Nama]</option>";
			}
    echo "</select></div>
</div>
<div class='control-group'>
	<label class='control-label'>No SK Dikti</label>
	<div class='controls'>
		<input type='text' name='NoSKDikti' value='$w[NoSKDikti]' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tgl SK Dikti</label>
	<div class='controls'>";
		$tgl_SKDikti=($md == 0)?substr("$w[TglSKDikti]",8,2):$today;
			combotgl(1,31,'tgl_SKDikti',$tgl_SKDikti);
		$bln_SKDikti=($md == 0)?substr("$w[TglSKDikti]",5,2):$BulanIni;
			combobln(1,12,'bln_SKDikti',$bln_SKDikti);
		$thn_SKDikti=($md == 0)?substr("$w[TglSKDikti]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_SKDikti',$thn_SKDikti);
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>No SK BAN</label>
	<div class='controls'>
		<input type='text' name='NoSKBAN' value='$w[NoSKBAN]' class='input-xxlarge' required>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tgl SK BAN</label>
	<div class='controls'>";
		$tgl_SKBAN=($md == 0)?substr("$w[TglSKBAN]",8,2):$today;
			combotgl(1,31,'tgl_SKBAN',$tgl_SKBAN);
		$bln_SKBAN=($md == 0)?substr("$w[TglSKBAN]",5,2):$BulanIni;
			combobln(1,12,'bln_SKBAN',$bln_SKBAN);
		$thn_SKBAN=($md == 0)?substr("$w[TglSKBAN]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_SKBAN',$thn_SKBAN);
    echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Website - Email </label>
	<div class='controls'><select name='Akreditasi'>";
        $akrde=_query("SELECT * FROM statusakreditasi ORDER BY statusakreditasi_ID");
        while($a=_fetch_array($akrde)){
			$des=($w[Akreditasi]==$a[statusakreditasi_ID])? 'selected':'';
			echo "<option value='$a[statusakreditasi_ID]' $des>$a[nama]</option>";
			}
    echo "</select>
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
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanProdi'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='go-prodi.html';\">
</div>  
</fieldset>
	</form>";
?>					
</div></div></div></div> 
<?php }else{
ErrorAkses();
} ?>