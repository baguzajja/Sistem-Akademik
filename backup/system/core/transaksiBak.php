<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php
function DefTransBaak(){
$Trans= $_REQUEST['PHPIdSession'];
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi AKADEMIK</div>
		<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#TransaksiBaa' data-toggle='tab'>Transaksi Baru</a></li>
			<li><a href='aksi-transaksiBak-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
		<legend>
			<div class='input-prepend input-append'>
						<span class='add-on'>Pilih Transaksi</span>
						<select name='transaksi' onChange=\"MM_jumpMenu('parent',this,0)\" class='span5'>
						<option value='go-transaksiBak.html'>- Pilih Transaksi -</option>";
						$sqlp="select * from lapbaak ORDER BY Nama";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$Trans){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='aksi-transaksiBak-$d[id].html' $cek> $d[Nama]</option>";
						}
						echo"</select>
			</div>
		</legend>";
	FormTransakksi();	
echo"</div>";
}
function jurnalTrans(){
$Trans= $_REQUEST['id'];
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi AKADEMIK</div>
		<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiBak.html'  class='tab-page' data-toggle='tab'>Transaksi Baru</a></li>
			<li class='active'><a href='#jurnalTrans' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
		<legend>
			<div class='input-prepend input-append'>
						<span class='add-on'>Pilih Transaksi</span>
						<select name='transaksi' onChange=\"MM_jumpMenu('parent',this,0)\" class='span5'>
						<option value='aksi-transaksiBak-jurnalTrans.html'>- Pilih Transaksi -</option>";
						$sqlp="select * from lapbaak ORDER BY Nama";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$Trans){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='get-transaksiBak-jurnalTrans-$d[id].html' $cek> $d[Nama]</option>";
						}
						echo"</select>
			</div>
		</legend>";
	DetailTransaksi();	
echo"</div>";
}
function DetailTransaksi(){
$Trans= $_REQUEST['id'];
 $s = "SELECT * FROM transaksibaak WHERE Transaksi='$Trans' ORDER BY TransID DESC";
 $w = _query($s);
 $no=0;
echo"<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NO TRANSAKSI</th>
					<th>NAMA TRANSAKSI</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$tglsubmit=tgl_indo($r['Tgl']);
	$NamaTrakBaak=NamaTrakBaak($Trans);
	$no++;
	echo"<tr>
			<td>$no</td>
			<td>$r[TransID]</td>
			<td>$NamaTrakBaak</td>
			<td>
<div class='btn-group pull-right'>
<a href='get-transaksiBak-Aprove-$r[RegID].html' class='btn btn-mini btn-success'>Edit</a>
<a href='down-TransksiBaa-$r[Id].html' class='btn btn-mini'>Download</a>
<a href='get-transaksiBak-delTrans-$r[Id].html' class='btn btn-mini btn-danger' onClick=\"return confirm('Anda yakin akan Menghapus data Transaksi #$r[TransID] ?')\">Hapus</a>
</div>		
</td></tr>";
}
echo"</tbody></table>";
}
function FormTransakksi(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
$Trans= $_REQUEST['PHPIdSession'];
$namaTrack=NamaTrakBaak($Trans);
$Notrans= NoTrakBaa();
if(empty($Trans)){
echo"<div class='alert alert-info'>
	<button class='close' data-dismiss='alert'>&times;</button>
	<strong>Pilih Transaksi</strong> Untuk Melakukan Transaksi Baru, Silahkan Pilih Menu transaksi di atas.
</div>";
}elseif($Trans=='1'){
echo"<div class='row-fluid'>
	<form id='example_form' action='aksi-transaksiBak-simpanTransaksi.html' method=POST name='trans' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$Trans'>
		<input type=hidden name='namatransaksi' value='$namaTrack'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<div class='span6'>
				<input type=text value='$Notrans' class='span12' readonly>
				</div><div class='span6'>
				<input type=text value='$namaTrack' class='span12' readonly>
				</div>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Mahasiswa</label>
				<div class='controls'>
				<select name='mhsw' class='span12'>
				<option value=''>- Pilih Mahasiswa -</option>";
					$s="SELECT * FROM mahasiswa WHERE NIM!='' AND aktif='Y' AND LulusUjian='N' ORDER BY Nama, NIM DESC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[NIM]'> $d[NIM] - $d[Nama]</option>";
				}
			echo"</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Dosen</label>
				<div class='controls'>
				<select name='dsn' class='span12'>
				<option value=''>- Pilih Dosen Penguji-</option>";
					$s="SELECT * FROM dosen WHERE Aktif='Y' AND NIDN!='' ORDER BY nama_lengkap DESC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[dosen_ID]'> $d[nama_lengkap] . $d[Gelar]</option>";
				}
			echo"</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>Tanggal </label>
			<div class='controls'>
			<div class='span6'>
				<select name='hari' class='span12'>
				<option value=''>- Pilih Hari -</option>";
					$s="SELECT * FROM hari ORDER BY id ASC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[hari]'>$d[hari]</option>";
				}
			echo"</select>
			</div>
			<div class='span6'>";
				combotgl(1,31,'Tglu',$today);
				combonamabln(1,12,'Blnu',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'Thnu',$TahunIni);
				echo"</div>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'></label>
<div class='controls'>
<div class='span3'><label>Mulai Pukul</label>
<input type=text placeholder='00:00' name='mulai' class='span12'>
</div>
<div class='span3'><label>Sampai Pukul</label>
<input type=text placeholder='00:00' name='selesai' class='span12'>
</div>
<div class='span6'>
<label>Ruangan</label>
			<select name='ruang' class='span12'>
				<option value=''>- Pilih Ruangan -</option>";
					$s="SELECT * FROM ruang ORDER BY Nama DESC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[Ruang_ID]'>$d[Nama]</option>";
				}
			echo"</select>
</div>
</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='uraian' class='span12'>$namaTrack</textarea>
				</div>
			</div>
			<div class='form-actions'><center>
			<div class='btn-group'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-danger' href='go-transaksiBak.html'>Batal</a>
			</div>
			</center></div>
		</fieldset>
	</form></div>";
}elseif($Trans=='7'){
echo"<div class='row-fluid'>
	<form id='example_form' action='aksi-transaksiBak-simpanTransaksi.html' method=POST name='trans' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$Trans'>
		<input type=hidden name='namatransaksi' value='$namaTrack'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<div class='span6'>
				<input type=text value='$Notrans' class='span12' readonly>
				</div><div class='span6'>
				<input type=text value='$namaTrack' class='span12' readonly>
				</div>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Mahasiswa</label>
				<div class='controls'>
				<select name='mhsw' class='span12'>
				<option value=''>- Pilih Mahasiswa -</option>";
					$s="SELECT * FROM mahasiswa WHERE NIM!='' AND aktif='Y' AND LulusUjian='N' ORDER BY Nama DESC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[NIM]'> $d[NIM] - $d[Nama]</option>";
				}
			echo"</select>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>Tanggal </label>
			<div class='controls'>
			<div class='span6'>
				<select name='hari' class='span12'>
				<option value=''>- Pilih Hari -</option>";
					$s="SELECT * FROM hari ORDER BY id ASC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
			echo "<option value='$d[hari]'>$d[hari]</option>";
				}
			echo"</select>
			</div>
			<div class='span6'>";
				combotgl(1,31,'Tglu',$today);
				combonamabln(1,12,'Blnu',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'Thnu',$TahunIni);
				echo"</div>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='uraian' class='span12'>$namaTrack</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiBak.html'>Batal</a>
			</div>
		</fieldset>
	</form></div>";
}
}
function simpanTransaksi(){
global $tgl_sekarang;	
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$namatransaksi	= $_POST['namatransaksi'];
	$Keterangan	   	= sqling($_POST['uraian']);
	$Tglr=sprintf("%02d%02d%02d",$_POST[Thnu],$_POST[Blnu],$_POST[Tglu]);

$insert =_query("INSERT INTO transaksibaak (TransID,Transaksi,NIM,DosenID,Ruang,Tgl,Hari,Mulai,Selesai,SubmitBy,Uraian) VALUES 
	('$TrackID', '$transaksi', '$_POST[mhsw]', '$_POST[dsn]', '$_POST[ruang]', '$Tglr', '$_POST[hari]', '$_POST[mulai]', '$_POST[selesai]', '$_SESSION[Nama]','$Keterangan')");
	
PesanOk2("Transaksi $namatransaksi","$namatransaksi Berhasil Di Simpan","go-transaksiBak.html","cetak-TransBaak-$transaksi.html");
}
function delTrans(){
$jTrans = $_REQUEST['id'];
$tabel1="transaksibaak";
$kondisi1="Id='$jTrans'";
delete($tabel1,$kondisi1);
PesanOk("Hapus Data Transaksi","Data Transaksi Berhasil Di Hapus","aksi-transaksiBak-jurnalTrans.html");
}
switch($_GET[PHPIdSession]){

  default:
    DefTransBaak();
  break;  

 case "simpanTransaksi":
    simpanTransaksi();
   break;

 case "jurnalTrans":
    jurnalTrans();
   break;

case "delTrans":
    delTrans();
   break;


}
?>
