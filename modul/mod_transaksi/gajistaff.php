<script type="text/javascript">
<!--
function startCalc()
{interval=setInterval("calc()",1)}
function calc(){
Gp=document.staff.gaji.value;
Um=document.staff.um.value;
Hari=document.staff.hari.value;
Lembur=document.staff.lembur.value;
Jam=document.staff.jam.value;
////////////////////
totalUm =  (Um)*(Hari);
totalLm = (Lembur)*(Jam);
///////////////////
pot=document.staff.potongan.value;
//formating
npot = pot.replace(/,/g, '');
//hasil
document.staff.Total.value=addCommas(((Gp*1)+(totalUm*1)+(totalLm*1))-(npot*1))
}
function stopCalc(){clearInterval(interval)}
//-->
</script>
<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanHonorStaff']))
{
	$JenisTrack		= $_POST['jenis'];
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$nominal	= str_replace(',','',$_POST['Total']);
	$potongan	= str_replace(',','',$_POST['potongan']);
	$cekTransaksi=_query("SELECT * FROM jenistransaksi WHERE id='$transaksi'");
	if (_num_rows($cekTransaksi)>0)
		{
			$row			=_fetch_array($cekTransaksi);
			$NamaTransaksi	=$row['Nama'];
			$d				=$row['BukuDebet'];
			$k				=$row['BukuKredit'];
			$deb			= explode(',',$d);
			$kredt			= explode(',',$k);
			if (!empty($d))
			{
				foreach($deb as $vald => $debet)
				{
				$transd = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang) VALUES 
				('$TrackID', '$debet', '$transaksi', '$nominal', '0', '$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang')";
				$insertd=_query($transd);	

				}
			}
			if (!empty($k))
			{
				foreach($kredt as $vald => $kredit)
				{
				$transk = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang) VALUES 
				('$TrackID', '$kredit', '$transaksi', '0', '$nominal', '$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang')";
				$insertk=_query($transk);
				
				}
			}
		$InsertDetail=_query("INSERT INTO transaksihnrstaff (Notrans,userid,gajipokok,uangmakan,uanglembur,hari,jam,potongan,Total,TglBayar,SubmitBy) VALUES ('$TrackID', '$User', '$_POST[gaji]', '$_POST[um]', '$_POST[lembur]', '$_POST[hari]', '$_POST[jam]','$potongan','$nominal', '$TglBayar','$_SESSION[Nama]')");
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiStaff-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");

}else{
global $hitu;
$karyawan = $_POST['karyawan'];
$NamaStafff=NamaStaff($karyawan);
$jbatan=JabatanIdStaff($karyawan);
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='staff'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$transaksiID'>
		<input type=hidden name='user' value='$karyawan'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='staff'>
<fieldset>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>No Transaksi *</label>
				<div class='controls'>
					<input type=text value='$Notrans' class='span12' readonly>
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Pilih Staff *</label>
				<div class='controls'>
					<select name='karyawan' onChange='this.form.submit()' class='span12' required>
						<option value=''>- Pilih STAFF -</option>";
						$staff="SELECT * FROM karyawan WHERE Bagian NOT IN('YPN05','dosen') ORDER BY nama_lengkap DESC";
						$sq=_query($staff) or die();
						while ($s=_fetch_array($sq)){
						if ($s['id']==$karyawan){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='$s[id]' $cek> $s[nama_lengkap]</option>";
						}
						echo"</select>
				</div>
		</div>
	</div>
</div>";
if($karyawan){
		$honor="SELECT * FROM honorstaff WHERE StaffID='$karyawan'";
		$hono=_query($honor) or die();
		$jhono=_num_rows($hono);
		if (!empty($jhono)){
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[GajiPokok]);
		$UangMakan=digit($h[UangMakan]);
		$lembur=digit($h[UangLembur]);
		echo"<div class='control-group'>
				<label class='control-label'>Rincian</label>
				<div class='controls'>
				<div class='row-fluid'>
					<div class='span5'>
					<label>Gaji Pokok :</label>
					<input type=text class='span12' value='$GajiPokok' readonly>
					<input type=hidden name='gaji' id='gaji' value='$h[GajiPokok]'>
					</div>
					<div class='span7'>
					<div class='row-fluid'>
					<div class='span3'>
					<label>Uang Makan :</label>
					<input type=text class='span12' value=' Rp. $UangMakan' readonly>
					<input type=hidden name='um' id='um' value='$h[UangMakan]'>
					</div>
					<div class='span3'>
					<label>Jumlah Hari :</label>
					<input type=text class='span12' name='hari' id='hari' $hitu>
					</div>
					<div class='span3'>
					<label>Uang Lembur :</label>
					<input type=text class='span12' value=' Rp. $lembur / Jam' readonly>
					<input type=hidden name='lembur' id='lembur' value='$h[UangLembur]'>
					</div>
					<div class='span3'>
					<label>Jumlah Jam :</label>
					<input type=text class='span12' name='jam' id='jam' $hitu>
					</div>
					</div>
					</div>
				</div>	
				</div>
			</div>";
	}else{
alert("error","Pengaturan Honor Staff Belum Tersedia untuk Staff $NamaStafff. Silahkan Settup Honor terlebih dahulu");		
	}
}
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>Total Gaji</label>
				<div class='controls'>
					<input type='text' class='span12' name='Total' readonly/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Potongan</label>
				<div class='controls'>
					<input type=text name='potongan' class='span12' placeholder='Masukkan Potongan Jika Ada .....' $hitu/>
				</div>
		</div>
		<div class='span4'>
				<div class=''>";
				combotgl(1,31,'TglBayar',$today);
				combobln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span12'>
			<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'>$JudulTransaksi ..................</textarea>
				</div>
		</div>
	</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
	<div class='btn-group'>
		<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanHonorStaff'>
		<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
	</div> 
</div>
</form>
</fieldset>";
}
 }else{
ErrorAkses();
} ?>