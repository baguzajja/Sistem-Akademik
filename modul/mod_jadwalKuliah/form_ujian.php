<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){ 
global $TahunIni, $saiki;
$id = $_REQUEST['id'];
$ed = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$hidden="<input type=hidden name=id value=$ed[Jadwal_ID]>";
?>
<div class="row">
<form class='form-horizontal' method='post'>
<div class="span6">
<div class="widget widget-form">
	<div class="widget-header">	      				
		<h3><i class='icon-pencil'></i> EDIT JADWAL UAS</h3>	
	</div>
	<div class="widget-content">
<?php
echo"
	 $hidden
<fieldset>
<div class='control-group'><label class='control-label'>Tgl Ujian</label>
	<div class='controls'>"; 
		$get_tgl2=substr("$ed[UASTgl]",8,2);
		combotgl(1,31,'tgluas',$get_tgl2);
        $get_bln2=substr("$ed[UASTgl]",5,2);
        combobln(1,12,'blnuas',$get_bln2);
        $get_thn2=substr("$ed[UASTgl]",0,4);
        combothn($TahunIni-2,$TahunIni+2,'thnuas',$get_thn2);
     echo"</div></div>
	<div class='control-group'><label class='control-label'>Hari Ujian</label>
	<div class='controls'>
		<select name=hariuas class='input-xlarge'>
		<option value=0>- Pilih Hari -</option>";
		$tampil=_query("SELECT * FROM hari ORDER BY id");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UASHari]==$w[hari])? 'selected': '';
		echo "<option value='$w[hari]' $cek>$w[hari]</option>";
		}
	echo "</select></div></div>
	<div class='control-group'><label class='control-label'>Jam Ujian</label>
	<div class='controls'>
		<input type='text' name='jmuas' value='$ed[UASMulai]' class='input-medium' id='UASMulai'> s/d <input type=text name='jsuas' value='$ed[UASSelesai]' class='input-medium' id='UASSelesai'>
	</div></div>
	<div class='control-group'>
	<label class='control-label'>Ruang Ujian</label>
	<div class='controls'>
		<select name=ruas class='input-xlarge'>
		<option value=0>- Pilih Ruang -</option>";
		$tampil=_query("SELECT * FROM ruang WHERE Kode_Jurusan='$ed[Kode_Jurusan]' ORDER BY ID");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UASRuang]==$w[ID])? 'selected': '';
		echo "<option value=$w[ID] $cek> $w[Nama]</option>";
		}
	echo "</select>
	</div></div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN UAS' name='simpanUas'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-jadwalKuliah-AllJadwal.html';\">
</div></div>
</fieldset>";
?>					
</div></div></div>
<div class="span6">
	<div class="widget widget-form">
		<div class="widget-header">
			<h3><i class='icon-pencil'></i> EDIT JADWAL UTS</h3>		    			
		</div>
	<div class="widget-content">
<?php 
echo"<div class='control-group'><label class='control-label'>Tgl Ujian</label>
	<div class='controls'>"; 
		$get_tgl2=substr("$ed[UTSTgl]",8,2);
		combotgl(1,31,'tgluts',$get_tgl2);
        $get_bln2=substr("$ed[UTSTgl]",5,2);
        combobln(1,12,'blnuts',$get_bln2);
        $get_thn2=substr("$ed[UTSTgl]",0,4);
        combothn($TahunIni-2,$TahunIni+2,'thnuts',$get_thn2);
     echo"</div></div>
	<div class='control-group'><label class='control-label'>Hari Ujian</label>
	<div class='controls'>
		<select name=hariuts class='input-xlarge'>
		<option value=0>- Pilih Hari -</option>";
		$tampil=_query("SELECT * FROM hari ORDER BY id");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UTSHari]==$w[hari])? 'selected': '';
		echo "<option value='$w[hari]' $cek>$w[hari]</option>";
		}
	echo "</select></div></div>
	<div class='control-group'><label class='control-label'>Jam Ujian</label>
	<div class='controls'>
		<input type=text name=jmuts class='input-medium' value='$ed[UTSMulai]' id='UTSMulai'> s/d 
		<input type=text name=jsuts class='input-medium' value='$ed[UTSSelesai]' id='UTSSelesai'>
	</div></div>
	<div class='control-group'>
	<label class='control-label'>Ruang Ujian</label>
	<div class='controls'>
		<select name=ruat class='input-xlarge'>
		<option value=0>- Pilih Ruang -</option>";
		$tampil=_query("SELECT * FROM ruang WHERE Kode_Jurusan='$ed[Kode_Jurusan]' ORDER BY ID");
		while($w=_fetch_array($tampil)){
		$cek=($ed[UTSRuang]==$w[ID])? 'selected': '';
		echo "<option value=$w[ID] $cek> $w[Nama]</option>";
		}
	echo "</select>
	</div></div>
<div class='form-actions'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN UTS' name='simpanUts'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-jadwalKuliah-AllJadwal.html';\">
</div></div>";
?>
	</div>
</div></div> 		 		
</form></div> 
<?php }else{
ErrorAkses();
} ?>