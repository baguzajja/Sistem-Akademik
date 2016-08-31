<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanPemakaian']))
{
	$User 			= $_POST['barang'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$jumlah			= $_POST['jumlah'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$cekTransaksi=_query("SELECT * FROM jenistransaksi WHERE id='$transaksi'");
	if (_num_rows($cekTransaksi)>0)
		{
			$row			=_fetch_array($cekTransaksi);
			$NamaTransaksi	=$row['Nama'];
			$transk = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID,ProdukId, TglBayar, SubmitBy, TglSubmit, Uraian,Jumlah,Status, TanggalCatat, IDpiutang) VALUES 
					('$TrackID', ' ', '$transaksi', '0', '$nominal', '','$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]','$jumlah','K', '$_POST[tanggal_catat]', '$piutang')";
					$insertk=_query($transk);
			$InsertDetail=_query("INSERT INTO transaksipakai (Notrans,produkid,userid,Jumlah,TglBayar,SubmitBy) VALUES ('$TrackID', '$User','$_POST[Pemakai]', '$jumlah', '$TglBayar', '$_SESSION[Nama]')");
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiPakai-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");

}else{
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='pemakaian'>
	<input type=hidden name='nomor' value='$Notrans'>
	<input type=hidden name='transaksi' value='$transaksiID'>
	<input type=hidden name='tanggal_catat' value='$waktu'>
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
			<label class='control-label'>Pilih Barang *</label>
				<div class='controls'>
					<select name='barang' class='span12' required>
						<option value=''>- Pilih Barang -</option>";
						$inv="SELECT * FROM inventaris WHERE forsale='N' ORDER BY NamaInventaris ASC";
						$rktr=_query($inv) or die();
						while ($r=_fetch_array($rktr)){
							if (sisa_barang($r[InventarisID])!=null) {
							$sisa=sisa_barang($r[InventarisID]);
							} else {
							$sisa=jml_barang($r[InventarisID],'M');
							}
						echo "<option value='$r[InventarisID]'> $r[NamaInventaris] :: $sisa</option>";
						}
						echo"</select>
				</div>
		</div>
	</div>
</div>";
echo"<div class='control-group'>
	<div class='row-fluid'>
	<div class='span4'>
			<label class='control-label'>Jumlah</label>
				<div class='controls'>
					<input type='text' class='span12' name='jumlah' placeholder='Masukkan Jumlah barang..' onFocus='startCalc();' onBlur='stopCalc();' required/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Untuk </label>
				<div class='controls'>
					<input type='text' class='span12' name='Pemakai' placeholder='Dipakai Untuk ..?' required/>
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
			<label class='control-label'>Keterangan *</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12' required> </textarea>
				</div>
		</div>
	</div>
</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
<div class='btn-group'>
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanPemakaian'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
</div> 
</div>
</form></fieldset>";
 }
}else{
ErrorAkses();
} ?>