<?php 
defined('_FINDEX_') or die('Access Denied');

if($edit OR $buat){ 

$tgl=tgl_indo(date("Y m d"));
$id=$_GET[id];
$r = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$jmlahMhsw=jumlahMhsw($r[Jadwal_ID]);
$mtk=GetFields("matakuliah","Matakuliah_ID",$r[Kode_Mtk],"*");
$KelompokMtk=KelompokMtk($mtk[KelompokMtk_ID]);
$Dosen1=NamaDosen($r[Dosen_ID]);
$Dosen2=NamaDosen($r[Dosen_ID2]);
?>
<div class="row">
	<div class="span8">
		<div class="widget widget-form">
			<div class="widget-header">
				<h3><i class="icon-pencil"></i>PRESENSI KULIAH</h3>

			</div> 
<div class="widget-content">
<form class='form-horizontal' method='post'>
<?php 
$pengajar=$_POST[dosen];
echo"
<input type=hidden name='TahunID' value='$r[Tahun_ID]'>
<input type=hidden name='JadwalID' value='$r[Jadwal_ID]'>
<input type=hidden name='mulai' value='$r[Jam_Mulai]'>
<input type=hidden name='selesai' value='$r[Jam_Selesai]'>
<input type=hidden name='JenisPresensi' value='kuliah'>
<input type=hidden name='semester' value='$r[semester]'>
<input type=hidden name='mtkID' value='$r[Kode_Mtk]'>
<fieldset>";
echo"<div class='control-group'>
		<label class='control-label'>Dosen Pengajar</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span6'>
				<select name='dosen' class='span12' onChange='this.form.submit()'>
					<option value=''>- Pilih Dosen Pengajar -</option>";
					$ceks=($pengajar=='lain')? "selected":"";
					$cek=($pengajar==$r['Dosen_ID'])? "selected":"";
					$cek1=($pengajar==$r['Dosen_ID2'])? "selected":"";
					if (empty($Dosen2)){
					echo "<option value='$r[Dosen_ID]' $cek> $d[nama_lengkap]</option>";
					echo "<option value='lain' $ceks> Dosen Pengganti ...</option>";
					}else{
					echo "<option value='$r[Dosen_ID]' $cek> $Dosen1</option>
						<option value='$r[Dosen_ID2]' $cek1> $Dosen2</option><option value='lain' $ceks> Dosen Pengganti ...</option>";
					}
			echo"</select></div>
			<div class='span6'>";
				if($pengajar=='lain'){
				echo"<select name='dosenPengganti' class='span12' required>";
					$t=_query("SELECT * FROM dosen ORDER BY nama_lengkap,dosen_ID ASC");
					while($w=_fetch_array($t)){
					echo "<option value=$w[dosen_ID] $cek>$w[nama_lengkap] - $w[Gelar]</option>";
						}
					echo"</select>";
				}
			echo"</div>
			</div>
			</div>
		</div>";

echo"<div class='control-group'>
				<label class='control-label'>Tanggal</label>
				<div class='controls'><div class=''>";
				combotgl(1,31,'TglPresensi',$today);
				combobln(1,12,'BlnPresensi',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnPresensi',$TahunIni);
				echo"</div></div>
			</div><div class='control-group'>
				<label class='control-label'>Presensi</label>
				<div class='controls'>
					<input type=radio name='presensi' value='1'> Hadir 
					<input type=radio name='presensi' value='0'> Tidak Hadir
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'> Mahasiswa </label>
				<div class='controls'>
					<input type=text name='mahasiswa' class='' placeholder='Jumlah Mahasiswa yang Hadir'/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class=''> </textarea>
				</div>
			</div>
		</fieldset>";
?>
</div>
	<div class='widget-toolbar'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type='submit' value='SIMPAN' name='simpanKuliah'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick="window.location.href='go-monitoring.html';">
</div>
		</center>
	</div>
</form>

	</div> 
</div> 

<div class="span4">
	<div class="widget widget-table toolbar-bottom">
		<div class="widget-header">
			<h3><i class="icon-info-sign"></i><?php echo strtoupper($mtk['Nama_matakuliah']); ?></h3>    			
		</div>
	<div class="widget-content">	
<?php 
echo"<table class='table table-bordered table-striped'>     
		<tr>                             
			<td>Kode </td>
			<td>$KelompokMtk - $mtk[Kode_mtk]</td>                             
		</tr>
		<tr>                             
			<td>HARI</td>
			<td>$r[Hari]</td>                             
		</tr>
		<tr>                             
			<td>WAKTU</td>
			<td>$r[Jam_Mulai] - $r[Jam_Selesai]</td>                             
		</tr>
		<tr>                             
			<td>JUMLAH MAHASISWA</td>
			<td>$jmlahMhsw <span class='pull-right'>Orang</span></td>                             
		</tr> 
	</table>"; ?>
</div>
</div>
</div> 	

		</div>  
<?php }else{ ErrorAkses(); } ?>