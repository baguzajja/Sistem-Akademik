<script type="text/javascript">
<!--
function startCalc()
{interval=setInterval("calc()",1)}
function calc(){
total=document.honorRektorat.totals.value;
pot=document.honorRektorat.potongan.value;
//formating
ntotal = total.replace(/,/g, '');
npot = pot.replace(/,/g, '');
//hasil
document.honorRektorat.nominal.value=addCommas((ntotal*1)-(npot*1))
}
function stopCalc(){clearInterval(interval)}
//-->
</script>
<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanHonorRektor']))
{
	$JenisTrack		= $_POST['jenis'];
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$piutang = (empty($_POST['piutang']))? "" : $_POST['piutang'];
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$nominal	= str_replace(',','',$_POST['nominal']);
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
		$InsertDetail=_query("INSERT INTO transaksihnrektor (Notrans,userid,gajipokok,transport,jabatan,potongan,Total,TglBayar,SubmitBy) VALUES('$TrackID', '$User', '$_POST[gajipokok]', '$_POST[transport]', '$_POST[jabatan]', '$potongan','$nominal', '$TglBayar','$_SESSION[Nama]')");
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiRektorat-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");

}else{
global $hitu;
$idRektor = $_POST['rektorat'];
$NamaStafff=NamaStaff($idRektor);
$jbatan=JabatanIdStaff($idRektor);
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='honorRektorat'>
	<input type=hidden name='nomor' value='$Notrans'>
	<input type=hidden name='transaksi' value='$transaksiID'>
	<input type=hidden name='user' value='$idRektor'>
	<input type=hidden name='tanggal_catat' value='$waktu'>
	<input type=hidden name='jenis' value='rektor'>
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
			<label class='control-label'>Pilih Rektorat *</label>
				<div class='controls'>
					<select name='rektorat' onChange='this.form.submit()' class='span12' required>
						<option value=''>- Pilih Staff Rektorat -</option>";
						$rektor="SELECT * FROM karyawan WHERE Bagian='YPN05' ORDER BY nama_lengkap DESC";
						$rktr=_query($rektor) or die();
						while ($r=_fetch_array($rktr)){
						if ($r['id']==$idRektor){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='$r[id]' $cek> $r[nama_lengkap]</option>";
						}
						echo"</select>
				</div>
		</div>
	</div>
</div>";
if($idRektor){
		$honor="SELECT * FROM honorrektorat WHERE IDRektor='$idRektor'";
		$hono=_query($honor) or die();
		$jhono=_num_rows($hono);
		if (!empty($jhono)){
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[GajiPokok]);
		$Tjbatan=digit($h[TnjanganJabatan]);
		$Ttransport=digit($h[TnjanganTransport]);
		$TotalGaji=$h[GajiPokok] + $h[TnjanganJabatan] + $h[TnjanganTransport];
		$TGaji=comaa($TotalGaji);
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>Gaji Pokok </label>
				<div class='controls'>
					<input type=text class='span12' value='Rp. $GajiPokok' placeholder='Rp. $GajiPokok' disabled>
					<input type='hidden' name='gajipokok' value='$h[GajiPokok]'/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Tunjangan Jabatan </label>
				<div class='controls'>
					<input type=text class='span12' value=' Rp. $Tjbatan' placeholder=' Rp. $Tjbatan' disabled>
					<input type='hidden' name='jabatan' value='$h[TnjanganJabatan]'/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Tunjangan Transport </label>
				<div class='controls'>
					<input type=text class='span12' value=' Rp. $Ttransport' placeholder=' Rp. $Ttransport' disabled>
					<input type='hidden' name='transport' value='$h[TnjanganTransport]'/>
				</div>
		</div>
	</div>
</div>";
	}else{
alert("error","Pengaturan Honor Rektorat Belum Tersedia untuk Staff $NamaStafff. Silahkan Settup Honor terlebih dahulu");	
	}
}
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>Total Honor</label>
				<div class='controls'>
					<input type='text' class='span12' name='nominal' value='$TGaji'/>
					<input type='hidden' name='totals' value='$TGaji'/>
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
</div>
<div class='widget-toolbar' style='text-align: center'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanHonorRektor'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
</div> 
</div>
</form></fieldset>";
 }
}else{
ErrorAkses();
} ?>