<script language="javascript" type="text/javascript">
        <!--
        function MM_jumpMenu(targ,selObj,restore){// v3.0
         eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
        }
        //-->
</script>
<?php
function defmonitoring(){
$tAktif		=TahunAktif();
$tahun		= (empty($_POST['tahun']))? $tAktif : $_POST['tahun'];
$semester	= (empty($_POST['semester']))? '0' : $_POST['semester'];
$hari		= (empty($_POST['hari']))? '0' : $_POST['hari'];

$tahunAkademik=TahunID($tahun);
echo"
<div class='panel-header'><i class='icon-sign-blank'></i> MONITORING PERKULIAHAN</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#Perkuliahan' data-toggle='tab'>Monitoring Perkuliahan</a></li>
			<li><a href='aksi-monitoring-Ujian.html' class='tab-page' data-toggle='tab'>Monitoring Ujian</a></li>
			<li><a href='aksi-monitoring-Rekap.html' class='tab-page' data-toggle='tab'>Rekapitulasi</a></li>
		</ul>
		<br/>
<form action='go-monitoring.html' method='post' class='form-horizontal'>
		<div class='row-fluid'>
		<div class='span4'>
			<b>TAHUN AKADEMIK :</b>
			<select name='tahun' onChange='this.form.submit()' class='span12'>
					<option value='0'>- Pilih Tahun Akademik -</option>";
					$thun="SELECT * FROM tahun ORDER BY ID";
					$th=_query($thun) or die();
					while ($t=_fetch_array($th)){
					if ($t['Tahun_ID']==$tahun){$cek="selected";}else{ $cek="";}
						echo "<option value='$t[Tahun_ID]' $cek> $t[Nama]</option>";
						}
					echo"</select>
		</div>
		<div class='span4'>
			<b>SEMESTER :</b>
			<select name='semester' onChange='this.form.submit()' class='span12'>
					<option value='0'>- SEMESTER -</option>";
					$sm=array('1','2','3','4','5','6','7','8');
					foreach($sm as $smst){
						if ($smst==$semester){$cek="selected";}else{ $cek="";}
						echo "<option value='$smst' $cek> Semester $smst</option>";
					}
					echo"</select>
		</div>
		<div class='span4'>
		<b>HARI :</b>
		<select name='hari' onChange='this.form.submit()' class='span12'>
	<option value=0>- Pilih Hari -</option>";
	$tampil=_query("SELECT * FROM hari ORDER BY id");
	while($r=_fetch_array($tampil)){
	$cek= ($r[hari]==$hari) ? 'selected' : '';
	echo "<option value='$r[hari]' $cek>$r[hari]</option>";
	}
	echo "</select>
		</div>
		</div>
</form>
		<legend></legend>
		<legend>Monitoring Perkuliahan <small>( SEMESTER $semester - Hari $hari    )</small></legend>
		<table class='table table-bordered table-striped'>
		<thead>
			<tr><th>NO</th>
			<th width='10%'>KODE <span class='pull-right'>MK</span></th>
			<th> MATAKULIAH</th>
			<th colspan='2'>DOSEN</th><th><center>JAM</center></th>
			<th><center>AKSI</center></th></tr>
		</thead>";
		$sql="SELECT * FROM jadwal WHERE Hari='$hari' AND Tahun_ID='$tahun' AND semester='$semester' GROUP BY Dosen_ID,Dosen_ID2";
		$qry= _query($sql)or die ();
		$no=0;
		while ($r=_fetch_array($qry)){
		$mtk=GetFields("matakuliah","Matakuliah_ID",$r[Kode_Mtk],"*");
		$MtkKelompok=KelompokMtk($mtk[KelompokMtk_ID]);
		$Dosen1=NamaDosen($r[Dosen_ID]);
		$Dosen2=NamaDosen($r[Dosen_ID2]);
		$no++;
		echo"<tr>                            
			<td>$no</td>
			<td>$MtkKelompok<span class='pull-right'>$mtk[Kode_mtk]</span></td>
			<td>$mtk[Nama_matakuliah]</td>
			<td>$Dosen1 </td>
			<td>$Dosen2</td>
			<td><center>$r[Jam_Mulai] - $r[Jam_Selesai]</center></td>
			<td><center><a href='get-monitoring-presensiKuliah-$r[Jadwal_ID].html' class='btn btn-mini btn-success'>Presensi</a></center></td>                   
		</tr>";   
}
echo"</table></div>";
}
function presensiKuliah(){
$tgl=tgl_indo(date("Y m d"));
$id=$_GET[id];
$r = GetFields('jadwal', 'Jadwal_ID', $id, '*');
$jmlahMhsw=jumlahMhsw($r[Jadwal_ID]);
$mtk=GetFields("matakuliah","Matakuliah_ID",$r[Kode_Mtk],"*");
$MtkKelompok=KelompokMtk($mtk[Matakuliah_ID]);
$Dosen1=NamaDosen($r[Dosen_ID]);
$Dosen2=NamaDosen($r[Dosen_ID2]);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> MONITORING PERKULIAHAN</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#Perkuliahan' data-toggle='tab'>Monitoring Perkuliahan</a></li>
			<li><a href='aksi-monitoring-Ujian.html' class='tab-page' data-toggle='tab'>Monitoring Ujian</a></li>
			<li><a href='aksi-monitoring-Rekap.html' class='tab-page' data-toggle='tab'>Rekapitulasi</a></li>
		</ul>
		<br/>
		<legend><center>LAPORAN PERKULIAHAN SEMESTER $r[semester].<br>Untuk Hari $r[Hari], Tanggal $tgl </center></legend>
	<div class='row-fluid'>
	<div class='span6'>
	<form id='example_form' action='aksi-monitoring-simpanPresensi.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='TahunID' value='$r[Tahun_ID]'>
		<input type=hidden name='JadwalID' value='$r[Jadwal_ID]'>
		<input type=hidden name='mulai' value='$r[Jam_Mulai]'>
		<input type=hidden name='selesai' value='$r[Jam_Selesai]'>
		<input type=hidden name='JenisPresensi' value='kuliah'>
		<input type=hidden name='semester' value='$r[semester]'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label'>Dosen Pengajar</label>
				<div class='controls'>
					<select name='dosen' class='span12'>
					<option value=''>- Pilih Dosen Pengajar -</option>";
					if (empty($Dosen2)){
					echo "<option value='$r[Dosen_ID]'> $d[nama_lengkap]</option>";
					}else{
					echo "<option value='$r[Dosen_ID]'> $Dosen1</option>
						<option value='$r[Dosen_ID2]'> $Dosen2</option>";
					}
					echo"</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Presensi</label>
				<div class='controls'>
					<input type=radio name='presensi' value='1'> Hadir 
					<input type=radio name='presensi' value='0'> Tidak Hadir
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'> Mahasiswa </label>
				<div class='controls'>
					<input type=text name='mahasiswa' class='span12' placeholder='Jumlah Mahasiswa yang Hadir'/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'> </textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='javascript:history.go(-1)'>Batal</a>
			</div>
		</fieldset>
	</form>
	</div>
	<div class='span6'>
				<div class='panel'>
                    <div class='panel-content panel-tables'>
						<table class='table table-bordered table-striped'>     
                            <thead>
							<tr>                             
                                <th>MATAKULIAH</th>
                                <th>$MtkKelompok-$mtk[Kode_Mtk] $mtk[Nama_matakuliah]</th>                             
                            </tr>
							<tr>                             
                                <th>HARI</th>
                                <th>$r[Hari]</th>                             
                            </tr>
							<tr>                             
                                <th>WAKTU</th>
                                <th>$r[Jam_Mulai] - $r[Jam_Selesai]</th>                             
                            </tr>
							<tr>                             
                                <th>JUMLAH MAHASISWA</th>
                                <th>$jmlahMhsw <span class='pull-right'>Orang</span></th>                             
                            </tr>
                            </thead>   
						</table>
                    </div>
                </div>
	</div>
	</div>
	</div>";
}
function Ujian(){
$tAktif		=TahunAktif();
$tahun	= (empty($_REQUEST['id']))? $tAktif : $_REQUEST['id'];
$id		= (empty($_REQUEST['codd']))? '0' : $_REQUEST['codd'];
$ids	= (empty($_REQUEST['kode']))? '0' : $_REQUEST['kode'];
$semester = (empty($_REQUEST['ids']))? '0' : $_REQUEST['ids'];
$tahunAkademik=TahunID($tahun);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> MONITORING UJIAN</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-monitoring.html' class='tab-page' data-toggle='tab'>Monitoring Perkuliahan</a></li>
			<li class='active'><a href='#Perkuliahan' data-toggle='tab'>Monitoring Ujian</a></li>
			<li><a href='aksi-monitoring-Rekap.html' class='tab-page' data-toggle='tab'>Rekapitulasi</a></li>
		</ul>
		<br/>
		<div class='row-fluid'>
			<div class='span4'>
			<b>TAHUN AKADEMIK :</b>
			<select name='Tahun' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
					<option value='nil-monitoring-Ujian-0-$id-$ids-$semester.html'>- Pilih Tahun Akademik -</option>";
					$thun="SELECT * FROM tahun ORDER BY ID";
					$th=_query($thun) or die();
					while ($t=_fetch_array($th)){
					if ($t['Tahun_ID']==$tahun){$cek="selected";}else{ $cek="";}
						echo "<option value='nil-monitoring-Ujian-$t[Tahun_ID]-$id-$ids-$semester.html' $cek> $t[Nama]</option>";
						}
					echo"</select>
			</div>
			<div class='span4'>
					<b>SEMESTER :</b>
					<select name='semester' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
					<option value='nil-monitoring-Ujian-$tahun-$id-$ids-0.html'>- SEMESTER -</option>";
					$sm=array('1','2','3','4','5','6','7','8');
					foreach($sm as $smst){
						if ($smst==$semester){$cek="selected";}else{ $cek="";}
						echo "<option value='nil-monitoring-Ujian-$tahun-$id-$ids-$smst.html' $cek> Semester $smst</option>";
					}
					echo"</select>
			</div>
			<div class='span4'>
					<b>JENIS UJIAN :</b>
					<select name='jenisjadwal' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
						<option value='nil-monitoring-Ujian-$tahun-$id-0-$semester.html'>- Pilih Jenis Ujian -</option>";
						$tampil=_query("SELECT * FROM jenis_ujian ORDER BY jenisjadwal");
						while($r=_fetch_array($tampil)){
						if ($r['jenisjadwal']==$ids){$cek="selected";}else{ $cek="";}
						echo "<option value='nil-monitoring-Ujian-$tahun-$id-$r[jenisjadwal]-$semester.html' $cek> $r[nama]</option>";
							}
					echo"</select>	
			</div>
		</div><legend></legend>";
	if ($ids=="UTS") {  
				$judul		= "Monitoring Ujian Tengah Semester <small>( UTS | TAHUN AKADEMIK $tahunAkademik | SEMESTER $semester )</small>";
		}elseif ($ids=="UAS") {  
                $judul		= "Monitoring Ujian Akhir Semester <small>( UAS | TAHUN AKADEMIK $tahunAkademik | SEMESTER $semester )</small>";
		}else{
				$judul		= "Monitoring Ujian  <small>( TAHUN AKADEMIK $tahunAkademik | SEMESTER $semester )</small>";
		}
	echo"<legend>$judul</legend>
		<table class='table table-bordered table-striped'><thead>
		<tr><th>NO</th><th>KODE MK</th><th> MATA KULIAH</th><th>TANGGAL</th><th>WAKTU</th><th>RUANG</th><th>AKSI</th></tr></thead>";
		$ujian=_query("SELECT * FROM jadwal WHERE Identitas_ID='$_SESSION[Identitas]' AND Tahun_ID='$tahun' AND semester='$semester' ORDER BY Jadwal_ID");
		$no=0;
		while ($s=_fetch_array($ujian)){
		$matKelompok=MatakuliahID($s[Kode_Mtk]);
		$MtkKelompok=KelompokMtk($matKelompok);
		if ($ids=="UTS") {  
				$UjianTgl		= tgl_indo($s[UTSTgl]);
				$UjianMulai		= $s[UTSMulai];
                $UjianSelesai	= $s[UTSSelesai];
                $UjianRuang		= $s[UTSRuang];
		}else {  
                $UjianTgl		= tgl_indo($s[UASTgl]);
                $UjianMulai		= $s[UASMulai];
                $UjianSelesai	= $s[UASSelesai];
                $UjianRuang		= $s[UASRuang];
		}
		$ruangan=NamaRuang($UjianRuang);
		$namaMtk=GetName("matakuliah","Kode_mtk",$s[Kode_Mtk],"Nama_matakuliah");
		$matKelompok=MatakuliahID($s[Kode_Mtk]);
		$MtkKelompok=KelompokMtk($matKelompok);
		$no++;
		echo"<tr>                            
			<td>$no</td>
			<td>$MtkKelompok<span class='pull-right'>$s[Kode_Mtk]</span></td>
			<td>$namaMtk</td>
			<td>$UjianTgl</td>
			<td>$UjianMulai - $UjianSelesai</td>
			<td>$ruangan</td>
			<td><center><a href='di-monitoring-presensiUjian-$s[Jadwal_ID]-$ids.html' class='btn btn-mini btn-success'>Presensi</a></center></td>
		</tr>";   
		}
echo"</table></div>";
}
function presensiUjian(){
$tgl=tgl_indo(date("Y m d"));
$id= $_REQUEST['codd'];
$ut= $_REQUEST['kode'];
$sql="SELECT * FROM jadwal WHERE Jadwal_ID='$id'";
$qry= _query($sql)or die ();
$r=_fetch_array($qry);
$jmlahMhsw=jumlahMhsw($r[Jadwal_ID]);
$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
$tahunAkademik=TahunID($r[Tahun_ID]);
$PRODI=NamaProdi($r[Kode_Jurusan]);
$matKelompok=MatakuliahID($r[Kode_Mtk]);
$MtkKelompok=KelompokMtk($matKelompok);
$Dosen1=NamaDosen($r[Dosen_ID]);
$Dosen2=NamaDosen($r[Dosen_ID2]);
if ($ut=="UTS") {  
	$judul			= "PROGRAM STUDI $PRODI :: UJIAN TENGAH SEMESTER <br> $tahunAkademik <br>BERITA ACARA";
	$UjianTgl		= tgl_indo($r[UTSTgl]);
	$UjianMulai		= $r[UTSMulai];
	$UjianSelesai	= $r[UTSSelesai];
	$UjianRuang		= $r[UTSRuang];
}elseif ($ut=="UAS") {  
	$judul			= "UJIAN AKHIR SEMESTER .::. PROGRAM STUDI $PRODI <br> $tahunAkademik <br>BERITA ACARA";
	$UjianTgl		= tgl_indo($r[UASTgl]);
	$UjianMulai		= $r[UASMulai];
	$UjianSelesai	= $r[UASSelesai];
	$UjianRuang		= $r[UASRuang];
	}
$ruangan=NamaRuang($UjianRuang);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> MONITORING PERKULIAHAN</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-monitoring.html' class='tab-page' data-toggle='tab'>Monitoring Perkuliahan</a></li>
			<li class='active'><a href='#Perkuliahan' data-toggle='tab'>Monitoring Ujian</a></li>
			<li><a href='aksi-monitoring-Rekap.html' class='tab-page' data-toggle='tab'>Rekapitulasi</a></li>
		</ul>
		<br/>
		<legend><center>$judul</center></legend>
	<div class='row-fluid'>
	<div class='span6'>
	<form id='example_form' action='aksi-monitoring-simpanPresensiUjian.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='TahunID' value='$r[Tahun_ID]'>
		<input type=hidden name='JadwalID' value='$r[Jadwal_ID]'>
		<input type=hidden name='DosenID' value='$r[Dosen_ID]'>
		<input type=hidden name='mulai' value='$UjianMulai'>
		<input type=hidden name='selesai' value='$UjianSelesai'>
		<input type=hidden name='JenisPresensi' value='$ut'>
		<input type=hidden name='Kode_Mtk' value='$r[Kode_Mtk]'>
		<input type=hidden name='semester' value='$r[semester]'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label'>Dosen Pengajar</label>
				<div class='controls'>
					<select name='dosen' class='span12'>
					<option value=''>- Pilih Dosen Pengajar -</option>";
					if (empty($Dosen2)){
					echo "<option value='$r[Dosen_ID]'> $d[nama_lengkap]</option>";
					}else{
					echo "<option value='$r[Dosen_ID]'> $Dosen1</option>
						<option value='$r[Dosen_ID2]'> $Dosen2</option>";
					}
					echo"</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Dosen</label>
				<div class='controls'>
					<input type=radio name='presensi' value='1'> Hadir 
					<input type=radio name='presensi' value='0'> Tidak Hadir
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'> Mahasiswa </label>
				<div class='controls'>
					<input type=text name='mahasiswa' class='span12' placeholder='Jumlah Mahasiswa yang Ikut Ujian'/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'> </textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='javascript:history.go(-1)'>Batal</a>
			</div>
		</fieldset>
	</form>
	</div>
	<div class='span6'>
				<div class='panel'>
                    <div class='panel-content panel-tables'>
						<table class='table table-bordered table-striped'>     
                            <thead>
							<tr>                             
                                <th>MATAKULIAH</th>
                                <th>$MtkKelompok-$r[Kode_Mtk] $namaMtk</th>                      
                            </tr>
							<tr>                             
                                <th>TANGGAL</th>
                                <th>$UjianTgl</th>                             
                            </tr>
							<tr>                             
                                <th>PUKUL</th>
                                <th>$UjianMulai - $UjianSelesai</th>                             
                            </tr>
							<tr>                             
                                <th>RUANG</th>
                                <th>$ruangan</th>                             
                            </tr>
							<tr>                             
                                <th>JUMLAH PESERTA UJIAN</th>
                                <th>$jmlahMhsw <span class='pull-right'>Orang</span></th>                             
                            </tr>
                            </thead>   
						</table>
                    </div>
                </div>
	</div>
	</div>
	</div>";
}
function Rekap(){
$tAktif		=TahunAktif();
$id		= (empty($_REQUEST['id']))? '0' : $_REQUEST['id'];
$tahun	= (empty($_REQUEST['codd']))? $tAktif : $_REQUEST['codd'];
$semester	= (empty($_REQUEST['kode']))? '0' : $_REQUEST['kode'];

$tahunAkademik=TahunID($tahun);
$Namadosen=NamaDosen($id);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> MONITORING UJIAN</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-monitoring.html' class='tab-page' data-toggle='tab'>Monitoring Perkuliahan</a></li>
			<li><a href='aksi-monitoring-Ujian.html' class='tab-page' data-toggle='tab'>Monitoring Ujian</a></li>
			<li class='active'><a href='#rekap' data-toggle='tab'>Rekapitulasi</a></li>
		</ul>
		<br/>
		<div class='row-fluid'>
		<div class='span4'>
			<b>TAHUN AKADEMIK :</b>
			<select name='tahun' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
					<option value='git-monitoring-Rekap-$id-0-$semester.html'>- Pilih Tahun Akademik -</option>";
					$thun="SELECT * FROM tahun ORDER BY ID";
					$th=_query($thun) or die();
					while ($t=_fetch_array($th)){
					if ($t['Tahun_ID']==$tahun){$cek="selected";}else{ $cek="";}
						echo "<option value='git-monitoring-Rekap-$id-$t[Tahun_ID]-$semester.html' $cek> $t[Nama]</option>";
						}
					echo"</select>
		</div>
		<div class='span4'>
			<b>SEMESTER :</b>
			<select name='semester' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
					<option value='git-monitoring-Rekap-$id-$tahun-0.html'>- SEMESTER -</option>";
					$sm=array('1','2','3','4','5','6','7','8');
					foreach($sm as $smst){
						if ($smst==$semester){$cek="selected";}else{ $cek="";}
						echo "<option value='git-monitoring-Rekap-$id-$tahun-$smst.html' $cek> Semester $smst</option>";
					}
					echo"</select>
		</div>
		<div class='span4'>
		<b>DOSEN :</b>
		<select name='institusi' onChange=\"MM_jumpMenu('parent',this,0)\" class='span12'>
					<option value='git-monitoring-Rekap-0-$tahun-$semester.html'>- Pilih Dosen Pengampu -</option>";
					$dosen="SELECT * FROM dosen ORDER BY dosen_ID";
					$dsn=_query($dosen) or die();
					while ($d=_fetch_array($dsn)){
					if ($d['dosen_ID']==$id){$cek="selected";}else{ $cek="";}
						echo "<option value='git-monitoring-Rekap-$d[dosen_ID]-$tahun-$semester.html' $cek> $d[nama_lengkap], $d[Gelar]</option>";
						}
					echo"</select>
		</div>
		</div><legend></legend>
		<legend>Laporan Perkuliahan <small>( $tahunAkademik - SEMESTER $semester)</small> <p class='pull-right'><span>DOSEN : $Namadosen</span></p></legend>
		<table class='table table-bordered table-striped'>
		<thead>
			<tr><th>NO</th>
			<th>HARI</th>
			<th width='10%'>KODE <span class='pull-right'>MK</span></th>
			<th> MATAKULIAH</th>
			<th><center>JAM</center></th><th>MHSW HADIR</th><th><center>PRESENSI</center></th><th>CATATAN</th></tr>
		</thead>";
		$sql="SELECT * FROM presensi a, jadwal b WHERE a.JadwalID=b.Jadwal_ID AND a.TahunID=b.Tahun_ID AND a.DosenID='$id' AND b.Tahun_ID='$tahun' AND a.semester='$semester' ORDER BY a.JadwalID";
		$qry= _query($sql)or die ();
		$no=0;
		while ($r=_fetch_array($qry)){  
		$namaMtk=GetName("matakuliah","Kode_mtk",$r[Kode_Mtk],"Nama_matakuliah");
		$matKelompok=MatakuliahID($r[Kode_Mtk]);
		$MtkKelompok=KelompokMtk($matKelompok);
		$prsensi = ($r['Pertemuan'] == '1')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
		$tgle=tgl_indo($r[Tanggal]);
		$no++;
		echo"<tr> 
			<td>$no</td>
			<td>$r[Hari] , $tgle</td>
			<td>$MtkKelompok<span class='pull-right'>$r[Kode_Mtk]</span></td>
			<td>$namaMtk</td> 
			<td><center>$r[Jam_Mulai] - $r[Jam_Selesai]</center></td>
			<td>$r[MhswHadir] Orang</td>
			<td><center>$prsensi</center></td> 
			<td>$r[Catatan]</td>
			                   
		</tr>";   
}
echo"</table></div>";
}
function simpanPresensi(){
global $tgl_sekarang;
	$presensi		= $_POST['presensi'];
	$mahasiswa		= $_POST['mahasiswa'];
	$Keterangan	   	= sqling($_POST['keterangan']);
if (empty($presensi)) {
PesanEror("Proses Presensi", "Presensi Gagal di proses.Anda Belum Memilih Prsensi dosen. Silahkan Ulangi Lagi");
}else{
$presens = "INSERT INTO presensi (JenisPresensi, TahunID, semester, JadwalID, Pertemuan, MhswHadir, DosenID, Tanggal,JamMulai,JamSelesai,Catatan) VALUES 
								('$_POST[JenisPresensi]', '$_POST[TahunID]', '$_POST[semester]','$_POST[JadwalID]', '$presensi', '$mahasiswa', '$_POST[dosen]', '$tgl_sekarang', '$_POST[mulai]', '$_POST[selesai]', '$Keterangan')";
$pre=_query($presens);	
PesanOk("Proses Presensi Dosen","Presensi Dosen Berhasil Di Simpan","go-monitoring.html");
	}
}
function simpanPresensiUjian(){
global $tgl_sekarang;
	$presensi		= $_POST['presensi'];
	$mahasiswa		= $_POST['mahasiswa'];
	$Keterangan	   	= sqling($_POST['keterangan']);
if (empty($presensi)) {
PesanEror("Proses Presensi", "Presensi Gagal di proses.Anda Belum Memilih Prsensi dosen. Silahkan Ulangi Lagi");
}else{
$presens = "INSERT INTO presensi (JenisPresensi, TahunID,semester, JadwalID, Pertemuan, MhswHadir, DosenID, Tanggal,JamMulai,JamSelesai,Catatan) VALUES 
								('$_POST[JenisPresensi]', '$_POST[TahunID]', '$_POST[semester]','$_POST[JadwalID]', '$presensi', '$mahasiswa', '$_POST[dosen]', '$tgl_sekarang', '$_POST[mulai]', '$_POST[selesai]', '$Keterangan')";
$pre=_query($presens);	
PesanOk("Proses Berita Acara","Berita Acara Berhasil Di Simpan","nil-monitoring-Ujian-$_POST[TahunID]-$_POST[Kode_Mtk]-$_POST[JenisPresensi]-$_POST[smster].html");
	}
}
//parameter

switch($_GET[PHPIdSession]){

  default:
    defmonitoring();			
  break;   

  case "Ujian":
	Ujian();     
  break;
  
  case "Rekap":
	Rekap();     
  break;

  case "presensiKuliah":
  presensiKuliah();
  break;
  
  case "presensiUjian":
  presensiUjian();
  break; 
  
  case "simpanPresensi":
  simpanPresensi();
  break;
  
  case "simpanPresensiUjian":
  simpanPresensiUjian();
  break;     
  
}
?>