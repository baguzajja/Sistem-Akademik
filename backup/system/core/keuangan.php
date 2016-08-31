<?php
function defaultKeuangan(){
buka("Bagian Administrasi Keuangan");
echo"<ul class='nav nav-tabs'>
		<li class='active'><a href='#'>Keuangan Mahasiswa</a></li>
		<li><a href='#Mhsw' data-toggle='tab'>Keuangan Rektorat</a></li>
		<li><a href='#HonorDosen' data-toggle='tab'>Keuangan Dosen</a></li>
		<li><a href='#HonorRektor' data-toggle='tab'>Keuangan Rektorat</a></li>
		<li><a href='#GajiStaff' data-toggle='tab'>Keuangan Staff</a></li>
		<li><a href='#RumahTangga' data-toggle='tab'>Keuangan Tangga</a></li>
	</ul><div class='tab-content'>";
echo"<div class='active'>";
echo"<legend>Data Keuangan Mahasiswa</legend>";
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NIM=b.KeuanganMhswID ORDER BY a.NIM DESC";
 $w = _query($s);
 $no=0;
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
		<thead>
			<tr>
				<th>No.</th>
				<th>NIM</th>
				<th>NAMA</th>
				<th>TOTAL BIAYA</th>
				<th>TOTAL BAYAR</th>
				<th>KEKURANGAN</th>
			</tr>
		</thead>
	<tbody>"; 
	while ($r = _fetch_array($w)) {
	$sttus = ($r['Aktif'] == 'Y')? '<i class="icon-ok green"></i>' : '<i class="icon-remove red"></i>';
	$no++;
echo"<tr><td>$no</td>
		<td>$r[Bank]</td>
		<td>$r[NoRekening]</td>
		<td>$r[Nama]</td>
		<td>$sttus</td>
		<td>$sttus</td>
		<td width='20%'>
		<center>
			<div class='btn-group'>
			<a class='btn btn-mini btn-inverse' href='actions-settingKeuangan-EditRekening-0-$r[RekeningID].html'>Edit</a>
			<a class='btn btn-mini btn-danger' href='get-settingKeuangan-HapusRekening-$r[RekeningID].html' onClick=\"return confirm('Anda yakin akan Menghapus data Rekening $r[NoRekening] ?')\">Hapus</a>
			</div>
		</center>
		</td>
	</tr>";        
	} 
echo"</tbody></table></div>";
echo"</div>";	
tutup();      
}
function EditRekening() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('rekening', 'RekeningID', $rekid, '*');
    $jdl = "Edit Rekening";
	$Btn = "Update";
    $norek = "<input type=hidden name='RekeningID' value='$w[RekeningID]'>
			<input type=text name='NoRekening' value='$w[NoRekening]' class='input-xlarge'>";
  }
  else {
    $w = array();
    $w['RekeningID'] = '';
    $w['NoRekening'] = '';
    $w['Nama'] = '';
    $w['Bank'] = '';
    $w['NA'] = 'N';
    $jdl = "Tambah Rekening";
	$Btn = "Simpan";
    $norek = "<input type=text name='NoRekening' value='$w[NoRekening]' class='input-xlarge'>";
  }
  $na = ($w['Aktif'] == 'Y')? 'checked' : '';
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanRekening.html' method=POST name='rekening' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>Nomer Rekening</label>
			<div class='controls'>
				$norek
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Atas Nama</label>
					<div class='controls'>
						<input type=text class='input-xlarge' id='Nama' name='Nama' value='$w[Nama]'>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Nama Bank</label>
				<div class='controls'>
				<input type=text class='input-xlarge' id='Bank' name='Bank' value='$w[Bank]' >
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Aktif ? </label>
				<div class='controls'>
					<input type=checkbox name='NA' value='Y' $na >
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Submit</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanRekening() {
  $md = $_POST['md']+0;
  $RekeningID = $_POST['RekeningID'];
  $NoRekening = $_POST['NoRekening'];
  $Nama = sqling($_POST['Nama']);
  $Bank = sqling($_POST['Bank']);
  $NA = empty($_POST['NA'])? 'N' : $_POST['NA'];
  if ($md == 0) {
    $s = "UPDATE rekening SET NoRekening='$NoRekening', Nama='$Nama', Bank='$Bank', Aktif='$NA'
      WHERE RekeningID='$RekeningID' ";
    $r = _query($s);
	PesanOk("Update Rekening","Data Rekening Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields('rekening', 'NoRekening', $NoRekening, '*');
    if (empty($ada)) {
      $s = "INSERT INTO rekening (NoRekening, KodeID, Nama, Bank, Aktif)
        values('$NoRekening', '$_SESSION[Identitas]', '$Nama', '$Bank', '$NA')";
      $r = _query($s);
	PesanOk("Tambah Rekening","Data Rekening Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Rekening", "Data No rekening Sudah ada dalama database");
	}
  }
}

function EditHonor() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('honordosen', 'HonorDosenID', $rekid, '*');
    $jdl = "Edit Pengaturan Honor Dosen";
	$Btn = "Update";
    $hiden = "<input type=hidden name='HonorDosenID' value='$w[HonorDosenID]'>
		<input type=text name='HonorDosenID' value='DOSEN-$w[HonorDosenID]' disabled>";
  }
  else {
    $w = array();
    $w['HonorDosenID'] = '';
    $w['JabatanAkdm'] = '';
    $w['JabatanDikti'] = '';
    $w['HonorSks'] = '';
    $w['TransportTtpMk'] = '';
    $w['UangTransport'] = '';
    $w['Keterangan'] = '';
    $jdl = "Tambah Pengaturan Honor Dosen";
	$Btn = "Simpan";
    $hiden = "<input type=text name='HonorDosenID' value='$w[HonorDosenID]' placeholder='Auto Generate ID' disabled>";
  }
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanHonor.html' method=POST name='honordosen' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>ID HONOR</label>
			<div class='controls'>
				$hiden
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan</label>
					<div class='controls'>
			<select name='JabatanAkdm'>
			<option value=0 selected>- Pilih Jabatan Akademik -</option>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='dosen' ORDER BY Jabatan_ID");
			while($j=_fetch_array($jbtn)){
			if ($w[JabatanAkdm]==$j[Jabatan_ID]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
				}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
				} 
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan Dikti</label>
				<div class='controls'>
				<select name='JabatanDikti'>
			<option value=0 selected>- Pilih Jabatan Dikti -</option>";
			$jbtnDikti=_query("SELECT * FROM jabatandikti ORDER BY JabatanDikti_ID");
			while($jd=_fetch_array($jbtnDikti)){
			if ($w[JabatanDikti]==$jd[JabatanDikti_ID]){
			echo "<option value=$jd[JabatanDikti_ID] selected>$jd[Nama]</option>";
				}else{
			echo "<option value=$jd[JabatanDikti_ID]>$jd[Nama]</option>";
				} 
				}
			echo "</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Honor / SKS</label>
				<div class='controls'>
					<input type=text name='HonorSks' value='$w[HonorSks]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Transport Tatap Muka</label>
				<div class='controls'>
					<input type=text name='TransportTtpMk' value='$w[TransportTtpMk]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uang Transport</label>
				<div class='controls'>
					<input type=text name='UangTransport' value='$w[UangTransport]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Submit</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanHonor() {
  $md = $_POST['md']+0;
  $HonorDosenID 	= $_POST['HonorDosenID'];
  $JabatanAkdm 		= $_POST['JabatanAkdm'];
  $JabatanDikti 	= $_POST['JabatanDikti'];
  $HonorSks			= sqling($_POST['HonorSks']);
  $TransportTtpMk	= sqling($_POST['TransportTtpMk']);
  $UangTransport	= sqling($_POST['UangTransport']);
  $Keterangan		= sqling($_POST['Keterangan']);
  if ($md == 0) {
    $s = "UPDATE honordosen SET JabatanAkdm='$JabatanAkdm', JabatanDikti='$JabatanDikti', HonorSks='$HonorSks', TransportTtpMk='$TransportTtpMk',UangTransport='$UangTransport',Keterangan='$Keterangan'
      WHERE HonorDosenID='$HonorDosenID' ";
    $r = _query($s);
	PesanOk("Update Pengaturan Honor Dosen","Data Pengaturan Honor Dosen Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields('honordosen', 'HonorDosenID', $HonorDosenID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO honordosen (HonorDosenID,JabatanAkdm,JabatanDikti,HonorSks,TransportTtpMk,UangTransport,Keterangan)
        values('$HonorDosenID', '$JabatanAkdm', '$JabatanDikti', '$HonorSks', '$TransportTtpMk','$UangTransport','$Keterangan')";
      $r = _query($s);
	PesanOk("Tambah Pengaturan Honor Dosen","Pengaturan Honor Dosen Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Pengaturan Honor Dosen", "Data No Pengaturan Honor Dosen Sudah ada dalama database");
	}
  }
}
function EditHonorRektor() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('honorrektorat', 'HonorRektorID', $rekid, '*');
    $jdl = "Edit Pengaturan Honor Rektorat";
	$Btn = "Update";
    $norek = "<input type=hidden name='HonorRektorID' value='$w[HonorRektorID]'>
		<input type=text name='HonorRektorID' value='REKTOR-$w[HonorRektorID]' disabled>";
  }
  else {
    $w = array();
    $w['HonorRektorID'] = '';
    $w['JabatanAkdm'] = '';
    $w['JabatanDikti'] = '';
    $w['GajiPokok'] = '';
    $w['TnjanganTransport'] = '';
    $w['TnjanganJabatan'] = '';
    $w['Keterangan'] = '';
    $jdl = "Tambah Pengaturan Honor Rektorat";
	$Btn = "Simpan";
    $norek = "<input type=text name='HonorRektorID' value='$w[HonorRektorID]' placeholder='Auto Generate ID' disabled>";
  }
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanHonorRektor.html' method=POST name='honorrektorat' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>ID HONOR</label>
			<div class='controls'>
				$norek
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan</label>
					<div class='controls'>
			<select name='JabatanAkdm'>
			<option value=0 selected>- Pilih Jabatan Akademik -</option>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='rektorat' ORDER BY Jabatan_ID");
			while($j=_fetch_array($jbtn)){
			if ($w[JabatanAkdm]==$j[Jabatan_ID]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
				}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
				} 
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan Dikti</label>
				<div class='controls'>
				<select name='JabatanDikti'>
			<option value=0 selected>- Pilih Jabatan Dikti -</option>";
			$jbtnDikti=_query("SELECT * FROM jabatandikti ORDER BY JabatanDikti_ID");
			while($jd=_fetch_array($jbtnDikti)){
			if ($w[JabatanDikti]==$jd[JabatanDikti_ID]){
			echo "<option value=$jd[JabatanDikti_ID] selected>$jd[Nama]</option>";
				}else{
			echo "<option value=$jd[JabatanDikti_ID]>$jd[Nama]</option>";
				} 
				}
			echo "</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Gaji Pokok</label>
				<div class='controls'>
					<input type=text name='GajiPokok' value='$w[GajiPokok]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tunjangan Transport</label>
				<div class='controls'>
					<input type=text name='TnjanganTransport' value='$w[TnjanganTransport]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tunjangan Jabatan</label>
				<div class='controls'>
					<input type=text name='TnjanganJabatan' value='$w[TnjanganJabatan]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Submit</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanHonorRektor() {
  $md = $_POST['md']+0;
  $HonorRektorID 		= $_POST['HonorRektorID'];
  $JabatanAkdm 			= $_POST['JabatanAkdm'];
  $JabatanDikti 		= $_POST['JabatanDikti'];
  $GajiPokok			= sqling($_POST['GajiPokok']);
  $TnjanganTransport	= sqling($_POST['TnjanganTransport']);
  $TnjanganJabatan		= sqling($_POST['TnjanganJabatan']);
  $Keterangan			= sqling($_POST['Keterangan']);
  if ($md == 0) {
    $s = "UPDATE  honorrektorat SET JabatanAkdm='$JabatanAkdm', JabatanDikti='$JabatanDikti', GajiPokok='$GajiPokok', TnjanganTransport='$TnjanganTransport',TnjanganJabatan='$TnjanganJabatan',Keterangan='$Keterangan'
      WHERE HonorRektorID='$HonorRektorID' ";
    $r = _query($s);
	PesanOk("Update Pengaturan Honor Rektorat","Data Pengaturan Honor Rektorat Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields(' honorrektorat', 'HonorRektorID', $HonorRektorID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO  honorrektorat (HonorRektorID,JabatanAkdm,JabatanDikti,GajiPokok,TnjanganTransport,TnjanganJabatan,Keterangan)
        values('$HonorRektorID', '$JabatanAkdm', '$JabatanDikti', '$GajiPokok', '$TnjanganTransport','$TnjanganJabatan','$Keterangan')";
      $r = _query($s);
	PesanOk("Tambah Pengaturan Honor Rektorat","Pengaturan Honor Rektorat Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Pengaturan Honor Rektorat", "Pengaturan Honor Rektorat Sudah ada dalam database");
	}
  }
}
function EditHonorStaff() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('honorstaff', 'HonorStaffID', $rekid, '*');
    $jdl = "Edit Pengaturan Gaji Staff";
	$Btn = "Update";
    $norek = "<input type=hidden name='HonorStaffID' value='$w[HonorStaffID]'>
		<input type=text name='HonorStaffID' value='STAF-$w[HonorStaffID]' disabled>";
  }
  else {
    $w = array();
    $w['HonorStaffID'] = '';
    $w['Jabatan'] = '';
    $w['GajiPokok'] = '';
    $w['UangMakan'] = '';
    $w['UangLembur'] = '';
    $w['Keterangan'] = '';
    $jdl = "Tambah Pengaturan Gaji Staff";
    $Btn = "Simpan";
    $norek = "<input type=text name='HonorStaffID' value='$w[HonorStaffID]' placeholder='Auto Generate ID' disabled>";
  }
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanHonorStaff.html' method=POST name='honorrektorat' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>ID HONOR</label>
			<div class='controls'>
				$norek
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jabatan</label>
					<div class='controls'>
			<select name='Jabatan'>
			<option value=0 selected>- Pilih Jabatan -</option>";
			$jbtn=_query("SELECT * FROM jabatan WHERE JabatanUntuk='staff' ORDER BY Jabatan_ID");
			while($j=_fetch_array($jbtn)){
			if ($w[Jabatan]==$j[Jabatan_ID]){
			echo "<option value=$j[Jabatan_ID] selected>$j[Nama]</option>";
				}else{
			echo "<option value=$j[Jabatan_ID]>$j[Nama]</option>";
				} 
				}
			echo "</select>
					</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Gaji Pokok</label>
				<div class='controls'>
					<input type=text name='GajiPokok' value='$w[GajiPokok]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uang Makan</label>
				<div class='controls'>
					<input type=text name='UangMakan' value='$w[UangMakan]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Uang Lembur</label>
				<div class='controls'>
					<input type=text name='UangLembur' value='$w[UangLembur]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>$Btn</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanHonorStaff() {
  $md = $_POST['md']+0;
  $HonorStaffID 		= $_POST['HonorStaffID'];
  $Jabatan	 			= $_POST['Jabatan'];
  $GajiPokok			= sqling($_POST['GajiPokok']);
  $UangMakan			= sqling($_POST['UangMakan']);
  $UangLembur			= sqling($_POST['UangLembur']);
  $Keterangan			= sqling($_POST['Keterangan']);
  if ($md == 0) {
    $s = "UPDATE  honorstaff SET Jabatan='$Jabatan', GajiPokok='$GajiPokok', UangMakan='$UangMakan',UangLembur='$UangLembur',Keterangan='$Keterangan'
      WHERE HonorStaffID='$HonorStaffID' ";
    $r = _query($s);
	PesanOk("Update Pengaturan Gaji Staff","Data Pengaturan Gaji Staff Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields(' honorstaff', 'HonorStaffID', $HonorStaffID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO  honorstaff (HonorStaffID,Jabatan,GajiPokok,UangMakan,UangLembur,Keterangan)
        values('$HonorStaffID', '$Jabatan','$GajiPokok', '$UangMakan','$UangLembur','$Keterangan')";
      $r = _query($s);
	PesanOk("Tambah Pengaturan Gaji Staff","Pengaturan Gaji Staff Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Pengaturan Gaji Staff", "Pengaturan Gaji Staff Sudah ada dalam database");
	}
  }
}
function EditBiayaMhsw() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('biayamhsw', 'BiayaMhswID', $rekid, '*');
    $jdl = "Edit Pengaturan Biaya Mahasiswa";
	$Btn = "Update";
    $norek = "<input type=hidden name='BiayaMhswID' value='$w[BiayaMhswID]'>
		<input type=text name='BiayaMhswID' value='BMHSW-$w[BiayaMhswID]' disabled>";
  }
  else {
    $w = array();
    $w['BiayaMhswID'] = '';
    $w['NamaBiaya'] = '';
    $w['Jumlah'] = '';
    $w['Keterangan'] = '';
    $jdl = "Tambah Pengaturan Biaya Mahasiswa";
    $Btn = "Simpan";
    $norek = "<input type=text name='BiayaMhswID' value='$w[BiayaMhswID]' placeholder='Auto Generate ID' disabled>";
  }
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanBiayaMhsw.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>ID BIAYA</label>
			<div class='controls'>
				$norek
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Nama Biaya</label>
				<div class='controls'>
					<input type=text name='NamaBiaya' value='$w[NamaBiaya]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jumlah</label>
				<div class='controls'>
					<input type=text name='Jumlah' value='$w[Jumlah]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>$Btn</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanBiayaMhsw() {
  $md = $_POST['md']+0;
  $BiayaMhswID 		= $_POST['BiayaMhswID'];
  $NamaBiaya	 	= $_POST['NamaBiaya'];
  $Jumlah			= sqling($_POST['Jumlah']);
  $Keterangan		= sqling($_POST['Keterangan']);
  if ($md == 0) {
    $s = "UPDATE  biayamhsw SET NamaBiaya='$NamaBiaya', Jumlah='$Jumlah',Keterangan='$Keterangan'
      WHERE BiayaMhswID='$BiayaMhswID' ";
    $r = _query($s);
	PesanOk("Update Pengaturan Biaya Mahasiswa","Data Pengaturan Biaya Mahasiswa Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields(' biayamhsw', 'BiayaMhswID', $BiayaMhswID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO  biayamhsw (BiayaMhswID,NamaBiaya,Jumlah,Keterangan)
        values('$BiayaMhswID', '$NamaBiaya','$Jumlah','$Keterangan')";
      $r = _query($s);
	PesanOk("Tambah Pengaturan Biaya Mahasiswa","Pengaturan Biaya Mahasiswa Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Pengaturan Biaya Mahasiswa", "Pengaturan Biaya Mahasiswa Sudah ada dalam database");
	}
  }
}
function EditRumahTangga() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['id'];
    $w = GetFields('rumahtangga', 'RumahTanggaID', $rekid, '*');
    $jdl = "Edit Pengaturan Rumah Tangga";
	$Btn = "Update";
    $norek = "<input type=hidden name='RumahTanggaID' value='$w[RumahTanggaID]'>
		<input type=text name='RumahTanggaID' value='RT-$w[RumahTanggaID]' disabled>";
  }
  else {
    $w = array();
    $w['RumahTanggaID'] = '';
    $w['Nama'] = '';
    $w['Jenis'] = '';
    $w['Keterangan'] = '';
    $jdl = "Tambah Pengaturan Rumah Tangga";
    $Btn = "Simpan";
    $norek = "<input type=text name='RumahTanggaID' value='$w[RumahTanggaID]' placeholder='Auto Generate ID' disabled>";
  }
  // Tampilkan
buka("Setting Keuangan");
	echo "<div class='panel-content'>
		<form id='example_form' action='aksi-settingKeuangan-simpanRumahTangga.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='md' value='$md'>
		<fieldset>
		<legend>$jdl</legend>
			<div class='control-group'>
				<label class='control-label' for='name'>ID BIAYA</label>
			<div class='controls'>
				$norek
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Nama</label>
				<div class='controls'>
					<input type=text name='Nama' value='$w[Nama]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Jenis</label>
				<div class='controls'>
					<input type=text name='Jenis' value='$w[Jumlah]'>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='Keterangan'>$w[Keterangan]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>$Btn</button>
				<button type='reset' class='btn'>Reset</button>
				<a class='btn btn-inverse' href='go-settingKeuangan.html'>Batal</a>
			</div>
		</fieldset>
</form>";
tutup();
}
function simpanRumahTangga() {
  $md = $_POST['md']+0;
  $RumahTanggaID 	= $_POST['RumahTanggaID'];
  $Nama	 			= $_POST['Nama'];
  $Jenis			= sqling($_POST['Jenis']);
  $Keterangan		= sqling($_POST['Keterangan']);
  if ($md == 0) {
    $s = "UPDATE  rumahtangga SET Nama='$Nama', Jenis='$Jenis',Keterangan='$Keterangan'
      WHERE RumahTanggaID='$RumahTanggaID' ";
    $r = _query($s);
	PesanOk("Update Pengaturan Rumah Tangga","Data Pengaturan Rumah Tangga Berhasil Di Update","go-settingKeuangan.html");
  }
  else {
    $ada = GetFields(' rumahtangga', 'RumahTanggaID', $RumahTanggaID, '*');
    if (empty($ada)) {
      $s = "INSERT INTO rumahtangga (RumahTanggaID,Nama,Jenis,Keterangan)
        values('$RumahTanggaID', '$Nama','$Jenis','$Keterangan')";
      $r = _query($s);
	PesanOk("Tambah Pengaturan Rumah Tangga","Pengaturan Rumah Tangga Berhasil Di Simpan","go-settingKeuangan.html");
    } else{
	PesanEror("Gagal Menambah Pengaturan Rumah Tangga", "Pengaturan Rumah Tangga Sudah ada dalam database");
	}
  }
}
switch($_GET[PHPIdSession]){

  default:
    defaultKeuangan();
  break;  
	  
  case "EditRekening":
    EditRekening();
  break;

  case "simpanRekening":
    simpanRekening();
   break;

  case "HapusRekening":
       $sql="DELETE FROM rekening WHERE RekeningID='$_GET[id]'";
       $qry=_query($sql) or die();
    PesanOk("Hapus Data Rekening","Data Rekening Berhasil Di Hapus","go-settingKeuangan.html");	
  break;
}
?>
