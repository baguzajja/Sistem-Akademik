<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
$nextThn=$TahunIni+1;
$tutup="$nextThn-$BulanIni-$today";
$md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id = $_REQUEST['id'];
    $w = GetFields('event', 'EventId', $id, '*');
	$jdl = "<i class='icon-pencil'></i> EDIT EVENT AKADEMIK";
	$btn = "UPDATE";
    $hiden = "<input type=hidden name='id' value='$w[EventId]'>";
  } else {
	$IDeven=IDeven();
    $w = array();
    $w['EventId']= $IDeven;
    $w['TahunID']= '';
    $w['JenisEvent']= '';
    $w['Semester'] = '';
    $w['NamaEvent'] = '';
    $w['StartDate'] = $saiki;
    $w['EndDate'] = $saiki;
    $w['warna'] = '#8fff00';
    $w['aktif'] = 'N';
	$jdl = "<i class='icon-plus'></i> TAMBAH EVENT AKADEMIK";
	$btn = "SIMPAN";
    $hiden = "<input type='hidden' name='id' value='$IDeven'>";
  }
	$tahundepan=$TahunIni+1;
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
		<label class='control-label'>Tahun Akademik</label>
			<div class='controls'>
			<select name='tahun' class='input-xxlarge'>
            <option value='0'>- Pilih Tahun Akademik -</option>";
			$sqlp="SELECT * FROM tahun ORDER BY Tahun_ID";
			$qryp=_query($sqlp) or die();
			while ($d=_fetch_array($qryp)){
			$cek= ($d['Tahun_ID']==$w['TahunID']) ? 'selected' : '';
			echo "<option value='$d[Tahun_ID]' $cek> $d[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Semester</label>
			<div class='controls'>
			<select name='semester' class='input-xxlarge'>
            <option value='0'>- Pilih Semester -</option>";
			$sqlp="SELECT * FROM evensemester ORDER BY smsterID";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
			$cek= ($d1['smsterID']==$w['Semester']) ? 'selected' : '';
			echo "<option value='$d1[smsterID]' $cek>  $d1[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Jenis Event</label>
			<div class='controls'>
			<select name='jnEven' class='input-xxlarge'>
            <option value='0'>- Pilih Jenis Event Akademik -</option>";
			$sqlp="SELECT * FROM evenjenis ORDER BY jenisID";
			$qryp=_query($sqlp) or die();
			while ($d1=_fetch_array($qryp)){
			$cek= ($d1['jenisID']==$w['JenisEvent']) ? 'selected' : '';
			echo "<option value='$d1[jenisID]' $cek>  $d1[Nama]</option>";
			}
    echo"</select></div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Nama Event</label>
	<div class='controls'>
	<input type=text name=nama value='$w[NamaEvent]' class='input-xxlarge' placeholder='Nama Agenda / Event Akademik'>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'> Tanggal Mulai </label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[StartDate]",8,2);
		combotgl(1,31,'tglS',$get_tgl2);
        $get_bln2=substr("$w[StartDate]",5,2);
        combobln(1,12,'blnS',$get_bln2);
        $get_thn2=substr("$w[StartDate]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnS',$get_thn2);
	echo"</div>
	</div>
	</div>
	<div class='control-group'>
	<label class='control-label'>Tanggal Selesai</label>
	<div class='controls'>";
	echo"<div class='row-fluid'>";
		$get_tgl2=substr("$w[EndDate]",8,2);
		combotgl(1,31,'tglE',$get_tgl2);
        $get_bln2=substr("$w[EndDate]",5,2);
        combobln(1,12,'blnE',$get_bln2);
        $get_thn2=substr("$w[EndDate]",0,4);
        combothn($TahunIni-10,$TahunIni+5,'thnE',$get_thn2);
	echo"</div>
	</div>
	</div>

<div class='control-group'>
<label class='control-label'>Warna</label>
	<div class='controls'>
		<div class='row-fluid'>
			<div class='span6'>
			<div class='color' data-color='rgb(255, 146, 180)' data-color-format='rgb' id='cp3'>
	<input type='text' class='input-medium' value='$w[warna]' name='warna' id='colorpicker-component'>
</div>
			</div>
			<div class='span4'>
				<label class='control-label'>STATUS</label>
					<div class='controls'>";
						if($w['aktif'] == 'Y'){
							echo"<input type=radio name=aktif value='Y' checked>Y 
								<input type=radio name=aktif value='N'>N ";
							}else{
							echo"<input type=radio name=aktif value='Y'>Y 
							<input type=radio name=aktif value='N' checked>N ";
							}
					echo"</div>
			</div>
		</div>
	</div>
</div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='$btn' name='simpanEvent'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-kalender-Event.html';\">
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