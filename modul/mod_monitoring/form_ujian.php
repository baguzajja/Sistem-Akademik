<?php 
defined('_FINDEX_') or die('Access Denied');
if($edit OR $buat){ 
$tgl=tgl_indo(date("Y m d"));
$id= $_REQUEST['md'];
$ut= $_REQUEST['id'];
$sql="SELECT * FROM jadwal WHERE Jadwal_ID='$id'";
$qry= _query($sql)or die ();
$r=_fetch_array($qry);
$jmlahMhsw=jumlahMhsw($r[Jadwal_ID]);

$mtk = GetFields('matakuliah', 'Matakuliah_ID', $r[Kode_Mtk], '*');
$NamaMtk=strtoupper($mtk['Nama_matakuliah']);
$KelompokMtk=KelompokMtk($mtk[KelompokMtk_ID]);

$tahunAkademik=TahunID($r[Tahun_ID]);
$PRODI=NamaProdi($r[Kode_Jurusan]);

$Dosen1=NamaDosen($r[Dosen_ID]);
$Dosen2=NamaDosen($r[Dosen_ID2]);
if ($ut=="UTS") {  
	$judul			= "PRESENSI UTS :: PROGRAM STUDI $PRODI :: $tahunAkademik";
	$UjianTgl		= tgl_indo($r[UTSTgl]);
	$UjianMulai		= $r[UTSMulai];
	$UjianSelesai	= $r[UTSSelesai];
	$UjianRuang		= $r[UTSRuang];
}elseif ($ut=="UAS") {  
	$judul			= "PRESENSI UAS :: PROGRAM STUDI $PRODI :: $tahunAkademik";
	$UjianTgl		= tgl_indo($r[UASTgl]);
	$UjianMulai		= $r[UASMulai];
	$UjianSelesai	= $r[UASSelesai];
	$UjianRuang		= $r[UASRuang];
	}
$ruangan=NamaRuang($UjianRuang);
?>
<div class="row">
	<div class="span8">
		<div class="widget widget-form">
			<div class="widget-header">
				<h3><i class="icon-pencil"></i><?php echo"$judul";?></h3>
			</div> 
<div class="widget-content">
<form class='form-horizontal' method='post'>
<?php 
echo"
<input type=hidden name='TahunID' value='$r[Tahun_ID]'>
		<input type=hidden name='JadwalID' value='$r[Jadwal_ID]'>
		<input type=hidden name='DosenID' value='$r[Dosen_ID]'>
		<input type=hidden name='mulai' value='$UjianMulai'>
		<input type=hidden name='selesai' value='$UjianSelesai'>
		<input type=hidden name='JenisPresensi' value='$ut'>
		<input type=hidden name='mtkID' value='$r[Kode_Mtk]'>
		<input type=hidden name='semester' value='$r[semester]'>
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
				<label class='control-label'>Dosen</label>
				<div class='controls'>
					<input type=radio name='presensi' value='1'> Hadir 
					<input type=radio name='presensi' value='0'> Tidak Hadir
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'> Mahasiswa </label>
				<div class='controls'>
					<input type=text name='mahasiswa' class='' placeholder='Jumlah Mahasiswa yang Ikut Ujian'/>
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
	<input class='btn btn-success btn-large' type='submit' value='SIMPAN' name='simpanUjian'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick="window.location.href='aksi-monitoring-ujian.html';">
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