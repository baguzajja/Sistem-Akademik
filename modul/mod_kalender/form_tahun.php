<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
$nextThn=$TahunIni+1;
$tahundepan=$TahunIni+1;
$tutup="$nextThn-$BulanIni-$today";
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('tahun', 'Tahun_ID', $id, '*');
    $jdl = "<i class='icon-pencil'></i> EDIT TAHUN AKADEMIK";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[Tahun_ID]'>";
  } else {
	$ThnID=IDtahun();
    $w = array();
    $w['Tahun_ID']= $ThnID;
    $w['Identitas_ID']= $_SESSION[Identitas];
    $w['TglBuka']= $saiki;
    $w['TglTutup'] = $tutup;
    $w['Nama'] = '';
    $w['Aktif'] = '';
    $jdl = "<i class='icon-plus'></i> TAMBAH TAHUN AKADEMIK";
	$btn = "SIMPAN";
    $hiden = "<input type=hidden name='id' value='$ThnID'>";
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
			<select name='identitas' class='input-xxlarge'>
            <option value=''>- Pilih Institusi -</option>";
    	  $sqlp="SELECT * FROM identitas ORDER BY Identitas_ID";
    	  $qryp=_query($sqlp) or die();
    	  while ($d=_fetch_array($qryp)){
			$cek = ($d['Identitas_ID']==$w['Identitas_ID']) ? 'selected' : '';
          echo "<option value='$d[Identitas_ID]' $cek>$d[Nama_Identitas]</option>";
    		}
    echo"</select></div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Nama Tahun Akademik</label>
	<div class='controls'>
	<input type=text name=nama value='$w[Nama]' class='input-xxlarge' placeholder='Contoh : TA $TahunIni/$tahundepan'>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Tanggal Buka </label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[TglBuka]",8,2);
		combotgl(1,31,'tglB',$get_tgl2);
        $get_bln2=substr("$w[TglBuka]",5,2);
        combobln(1,12,'blnB',$get_bln2);
        $get_thn2=substr("$w[TglBuka]",0,4);
        combothn($TahunIni-10,$TahunIni+10,'thnB',$get_thn2);
	echo"</div>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'>Tanggal Tutup</label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[TglTutup]",8,2);
		combotgl(1,31,'tglT',$get_tgl2);
        $get_bln2=substr("$w[TglTutup]",5,2);
        combobln(1,12,'blnT',$get_bln2);
        $get_thn2=substr("$w[TglTutup]",0,4);
        combothn($TahunIni-10,$TahunIni+10,'thnT',$get_thn2);
	echo"</div>
	</div>
	</div>

<div class='control-group row-fluid'>
	<label class='control-label'>Status</label>
	<div class='controls'>";
if($w['Aktif'] == 'Y'){
	echo"<input type=radio name=aktif value='Y' checked>Y 
		<input type=radio name=aktif value='N'>N ";
}else{
	echo"<input type=radio name=aktif value='Y'>Y 
		<input type=radio name=aktif value='N' checked>N ";
}
	echo"</div>
</div>

<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanTahun'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-kalender-Tahun.html';\">
</div>			
</div>			
</fieldset>
</form>";
?>					
</div></div></div>
 		 		
</div> 
<?php }else{
ErrorAkses();
} ?>