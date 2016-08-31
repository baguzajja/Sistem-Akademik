<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat AND $edit){ 
global $TahunIni, $saiki;
 $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $id 	= $_REQUEST['id'];
    $p 		= GetFields('dosenpenelitian', 'DosenPenelitianID', $id, '*');
	$ds		= GetFields('dosen', 'dosen_ID', $p['DosenID'], '*');
	$jdl 	= "<i class='icon-pencil'></i>EDIT PENELITIAN DOSEN :  $ds[nama_lengkap]";
    $hiden 	= "<input type='hidden' name='DosenPenelitianID' value='$p[DosenPenelitianID]'>";
    $dosen 	= "<input type='hidden' name='DosenID' value='$p[DosenID]'>";
	$btn	='UPDATE';
  } else {
	$id 	= $_REQUEST['id'];
	$ds		= GetFields('dosen', 'dosen_ID',$id, '*');
    $w = array();
    $w['DosenPenelitianID']= '';
    $w['NamaPenelitian']= '';
    $w['DosenID']= '';
    $w['TglBuat'] = '';
    $jdl = "<i class='icon-plus'></i>TAMBAH PENELITIAN DOSEN : $ds[nama_lengkap]";
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
echo "<div class='widget-content'>
	<form class='form-horizontal' method='post'>
	<input type=hidden name='md' value='$md'>
	$hiden
	$dosen

<div class='control-group'>
	<label class='control-label'>Nama Penelitian</label>
	<div class='controls'>
		<input type=text name='NamaPenelitian' value='$p[NamaPenelitian]' class='input-xxlarge'>
	</div>
</div>
<div class='control-group'>
	<label class='control-label'>Tanggal Penelitian</label>
	<div class='controls'>";
		$tgl_Buat=($md == 0)?substr("$p[TglBuat]",8,2):$today;
			combotgl(1,31,'tgl_Buat',$tgl_Buat);
		$bln_Buat=($md == 0)?substr("$p[TglBuat]",5,2):$BulanIni;
			combobln(1,12,'bln_Buat',$bln_Buat);
		$thn_Buat=($md == 0)?substr("$p[TglBuat]",0,4):$TahunIni;
			combothn($TahunIni-100,$TahunIni+10,'thn_Buat',$thn_Buat);
	echo"</div>
</div></div>";						
?>	
<div class='widget-toolbar'>
	<center>
		<input class='btn btn-success btn-large' type='submit' name='UpdatePenelitian' value='<?php echo $btn; ?>'>
	</center>
</div>	
</form>				
</div>
</div>				
		</div>
<?php }else{ ErrorAkses(); } ?>