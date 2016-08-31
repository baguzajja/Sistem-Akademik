<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat AND $edit){ 
global $TahunIni, $saiki;
 $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id 	= $_REQUEST['id'];
    $p 		= GetFields('dosenpendidikan', 'DosenPendidikanID', $id, '*');
	$ds		= GetFields('dosen', 'dosen_ID', $p['DosenID'], '*');
	$jdl 	= "<i class='icon-pencil'></i>EDIT PENDIDIKAN DOSEN : $ds[nama_lengkap]";
    $hiden 	= "<input type='hidden' name='DosenPendidikanID' value='$p[DosenPendidikanID]'>";
    $dosen 	= "<input type='hidden' name='DosenID' value='$p[DosenID]'>";
	$btn	='UPDATE';
  } else {
	$id 	= $_REQUEST['id'];
	$ds		= GetFields('dosen', 'dosen_ID', $id, '*');
    $w = array();
    $w['DosenPendidikanID']= '';
    $w['DosenID']= '';
    $w['JenjangID']= '';
    $w['TanggalIjazah'] = '';
    $w['Gelar'] = '';
    $w['PerguruanTinggiID'] = '';
    $w['NamaNegara'] = '';
    $w['BidangIlmu'] = '';
    $w['Prodi'] = '';
    $jdl = "<i class='icon-plus'></i>TAMBAH PENDIDIKAN DOSEN : $ds[nama_lengkap]";
    $hiden = "";
	$dosen 	= "<input type='hidden' name='DosenID' value='$id'>";
	$btn='SIMPAN';
  }
?>
<div class="row">
	<div class="span8">
<div class="widget widget-form">
<div class='widget-header'>
	<h3><?php echo $jdl;?></h3>
		<div class='widget-actions'>
			<div class='btn-group'>
				<button class='btn btn-small btn-info' onClick="history.back()"><i class="icon-undo"></i> Kembali</button>
			</div>				
		</div> 
</div> 
<?php 
echo "
<div class='widget-content'>
	<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	$hiden
	$dosen

<div class='control-group'>
	<label class='control-label'>Gelar</label>
	<div class='controls'>
		<input type=text name='Gelar' value='$p[Gelar]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Jenjang</label>
	<div class='controls'>
		<select name='JenjangID' class='input-xlarge'>
			<option value=''>- Pilih Jenjang -</option>";
			$tampil=_query("SELECT * FROM jenjang ORDER BY Jenjang_ID");
			while($w=_fetch_array($tampil)){
			$cek=($p[JenjangID]==$w[Jenjang_ID])? 'selected':'';
			echo "<option value='$w[Jenjang_ID]' $cek> $w[Nama]</option>";
			} 
echo "</select>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tanggal Ijazah</label>
	<div class='controls'>";
		$tgl_Ijazah=($md == 0)?substr("$p[TanggalIjazah]",8,2):$today;
			combotgl(1,31,'tgl_Ijazah',$tgl_Ijazah);
		$bln_Ijazah=($md == 0)?substr("$p[TanggalIjazah]",5,2):$BulanIni;
			combobln(1,12,'bln_Ijazah',$bln_Ijazah);
		$thn_Ijazah=($md == 0)?substr("$p[TanggalIjazah]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_Ijazah',$thn_Ijazah);
	echo"</div>
</div>
<div class='control-group'>
	<label class='control-label'>Perguruan Tinggi</label>
	<div class='controls'>
		<input type=text name='PerguruanTinggiID' value='$p[PerguruanTinggiID]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Negara</label>
	<div class='controls'>
		<input type=text name='NamaNegara' value='$p[NamaNegara]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Bidang Ilmu</label>
	<div class='controls'>
		<input type=text name='BidangIlmu' value='$p[BidangIlmu]' class='input-xlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Program Studi</label>
	<div class='controls'>
		<input type=text name='Prodi' value='$p[Prodi]' class='input-xlarge'>
	</div>
</div>

</div>";						
?>	
<div class='widget-toolbar'>
	<center>
		<input class='btn btn-success btn-large' type='submit' name='UpdatePendidikan' value='<?php echo $btn; ?>'>
	</center>
</div>	
</form>				
</div>
</div></div>
<?php }else{ ErrorAkses(); } ?>