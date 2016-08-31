<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanTrans']))
{
$JenisTrack		= $_POST['jenis'];
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$piutang = (empty($_POST['piutang']))? "" : $_POST['piutang'];
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$nominal	= str_replace(',','',$_POST['nominal']);
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
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksi-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");
}else{
//tampilkan form transaksi
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name=''>
	<input type=hidden name='nomor' value='$Notrans'>
	<input type=hidden name='transaksi' value='$transaksiID'>
	<input type=hidden name='user' value='$_SESSION[Nama]'>
	<input type=hidden name='tanggal_catat' value='$waktu'>
	<input type=hidden name='jenis' value='umum'>
<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>No Transaksi</label>
			<div class='controls'>
				<input type=text value='$Notrans' class='input-xxlarge' disabled>
			</div>
			</div>";
		if($p){
		echo"<div class='control-group'>
			<label class='control-label'>Hutang</label>
			<div class='controls'>
			<select name='piutang' class='input-xxlarge'>
				<option value=''>- Pilih Hutang -</option>";
					$s="SELECT * FROM transaksi WHERE Transaksi IN (8,4,22) GROUP BY TransID ORDER BY Id DESC";
					$hasil = _query($s) or die();
					while ($d=_fetch_array($hasil)){
		echo "<option value='$d[Id]'> $d[Uraian]</option>";
					}
		echo"</select>
			</div>
			</div>";
		}else{
		echo "<input type=hidden value='' name='piutang'>";
		}
		echo"<div class='control-group'>
				<label class='control-label'>Nominal</label>
				<div class='controls'>
					<input type=text name='nominal' value='$_POST[nominal]' class='input-xxlarge' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" required/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal</label>
				<div class='controls'><div class=''>";
				combotgl(1,31,'TglBayar',$today);
				combobln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div></div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='input-xxlarge' required>$JudulTransaksi</textarea>
				</div>
			</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanTrans'>
	<input type='button' value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
</div> 
</div></form></fieldset>";
}
 }else{
ErrorAkses();
} ?>