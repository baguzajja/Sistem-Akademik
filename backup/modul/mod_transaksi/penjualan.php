<script type="text/javascript">
<!--
function startCalc()
{interval=setInterval("calc()",1)}
function calc(){
sjumlah=document.penjualan.jumlah.value;
sharga=document.penjualan.harga.value;
//formating
nharga = sharga.replace(/,/g, '');

//hasil
document.penjualan.total.value=addCommas((nharga*1)*(sjumlah*1))
}
function stopCalc(){clearInterval(interval)}
//-->
</script>
<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanPenjualan']))
{
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$jumlah			= $_POST['jumlah'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$nominal	= str_replace(',','',$_POST['total']);
	$harga		= str_replace(',','',$_POST['harga']);
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
				$transd = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID,ProdukId, TglBayar, SubmitBy, TglSubmit, Uraian,Jumlah,Status, TanggalCatat, IDpiutang) VALUES 
				('$TrackID', '$debet', '$transaksi', '$nominal', '0', '','$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]','$jumlah','K', '$_POST[tanggal_catat]', '$piutang')";
				$insertd=_query($transd);	

				}
			}
			if (!empty($k))
			{
				foreach($kredt as $vald => $kredit)
				{
				$transk = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID,ProdukId, TglBayar, SubmitBy, TglSubmit, Uraian,Jumlah,Status, TanggalCatat, IDpiutang) VALUES 
				('$TrackID', '$kredit', '$transaksi', '0', '$nominal', '','$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]','$jumlah','K', '$_POST[tanggal_catat]', '$piutang')";
				$insertk=_query($transk);
				
				}
			}
		if($User==4){
		//Update Jas Almamater
		$sisa=GetName('jasalmamater','ukuran',$_POST['ukuran'],'total');
		$total=$sisa - $jumlah;
		$updateM=_query("UPDATE jasalmamater SET 
				total		= '$total'
				WHERE ukuran = '$_POST[ukuran]'");
			}
		$InsertDetail=_query("INSERT INTO transaksijual (Notrans,produkid,userid,Jumlah,Harga,ukuran,TglBayar,SubmitBy) VALUES('$TrackID', '$User','$_POST[pembeli]', '$jumlah','$harga','$_POST[ukuran]', '$TglBayar','$_SESSION[Nama]')");
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiJual-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");

}else{
global $hitu;
$idInv = $_POST['barang'];
$NamaStafff=NamaStaff($idRektor);
$jbatan=JabatanIdStaff($idRektor);
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='penjualan'>
	<input type=hidden name='nomor' value='$Notrans'>
	<input type=hidden name='transaksi' value='$transaksiID'>
	<input type=hidden name='user' value='$idInv'>
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
					<select name='barang' onChange='this.form.submit()' class='span12' required>
						<option value=''>- Pilih Barang -</option>";
						$inv="SELECT * FROM inventaris WHERE forsale='Y' ORDER BY NamaInventaris ASC";
						$rktr=_query($inv) or die();
						while ($r=_fetch_array($rktr)){
						if ($r['InventarisID']==$idInv){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='$r[InventarisID]' $cek> $r[NamaInventaris]</option>";
						}
						echo"</select>
				</div>
		</div>
	</div>
</div>";
if($idInv){
if($idInv==4){
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>JUMLAH</label>
				<div class='controls'>
					<input type=text class='span12' name='jumlah' placeholder='Jumlah..' onFocus='startCalc();' onBlur='stopCalc();' required/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>UKURAN</label>
				<div class='controls'>
					<select name='ukuran' class='span12' required>
						<option value=''>- Pilih Ukuran -</option>";
						$ukuran="SELECT * FROM jasalmamater ORDER BY id ASC";
						$Uk=_query($ukuran) or die();
						while ($u=_fetch_array($Uk)){
						$NamaUkuran=strtoupper($u['ukuran']);
						$kosong=($u['total']==0)? "disabled":"";
						echo "<option value='$u[ukuran]' $kosong>$NamaUkuran :: <i>$u[total]  </i></option>";
						}
						echo"</select>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Pembeli</label>
				<div class='controls'>
					<input type='text' class='span12' name='pembeli' placeholder='Masukkan Nama Pembeli..' required/>
				</div>
		</div>
	</div>
</div>";
}else{
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Jumlah</label>
				<div class='controls'>
					<input type='text' class='span12' name='jumlah' placeholder='Masukkan Jumlah barang..' onFocus='startCalc();' onBlur='stopCalc();' required/>
				</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Pembeli</label>
				<div class='controls'>
					<input type='text' class='span12' name='pembeli' placeholder='Masukkan Nama Pembeli ..' required/>
				</div>
		</div>
	</div>
</div>";
}
}
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>Harga</label>
				<div class='controls'>
					<input type='text' class='span12' name='harga' placeholder='Harga Jual' $hitu/>
				</div>
		</div>
		<div class='span4'>
			<label class='control-label'>Total</label>
				<div class='controls'>
					<input type=text name='total' class='span12' readonly/>
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
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanPenjualan'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
</div> 
</div>
</form></fieldset>";
 }
}else{
ErrorAkses();
} ?>