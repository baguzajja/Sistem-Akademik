<script type="text/javascript">
<!--
function startCalc()
{interval=setInterval("calc()",1)}
function calc(){
msize=document.pembelian.m.value;
lsize=document.pembelian.l.value;
xlsize=document.pembelian.xl.value;
xxlsize=document.pembelian.xxl.value;
sharga=document.pembelian.harga.value;
//formating
nharga = sharga.replace(/,/g, '');
ntotal = (msize*1)+(lsize*1) + (xlsize*1) + (xxlsize*1);

//hasil
document.pembelian.total.value=addCommas((nharga*1)*(ntotal))
}
function stopCalc(){clearInterval(interval)}
//-->
</script>
<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanPembelian']))
{
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$jumlah			= $_POST['m'] + $_POST['l'] + $_POST['xl'] + $_POST['xxl'];
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
				('$TrackID', '$debet', '$transaksi', '$nominal', '0', '','$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]','$jumlah','M', '$_POST[tanggal_catat]', '$piutang')";
				$insertd=_query($transd);	

				}
			}
			if (!empty($k))
			{
				foreach($kredt as $vald => $kredit)
				{
				$transk = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID,ProdukId, TglBayar, SubmitBy, TglSubmit, Uraian,Jumlah,Status, TanggalCatat, IDpiutang) VALUES 
				('$TrackID', '$kredit', '$transaksi', '0', '$nominal', '','$User', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]','$jumlah','M', '$_POST[tanggal_catat]', '$piutang')";
				$insertk=_query($transk);
				
				}
			}
		if($User==4){
		$InsertDetail=_query("INSERT INTO transaksijasalmamater (Notrans,userid,summ,suml,sumxl,sumxxl,Harga,TglBayar,SubmitBy) VALUES('$TrackID', '$User', '$_POST[m]', '$_POST[l]', '$_POST[xl]', '$_POST[xxl]','$harga', '$TglBayar','$_SESSION[Nama]')");
	//Update Jas Almamater
	if(!empty($_POST['m'])){
	$sisaM=GetName('jasalmamater','ukuran','m','total');
	$totalM=$sisaM + $_POST['m'];
	$updateM=_query("UPDATE jasalmamater SET 
			total		= '$totalM'
			WHERE ukuran = 'm'");
	}if(!empty($_POST['l'])){
	$sisaL=GetName('jasalmamater','ukuran','l','total');
	$totalL=$sisaL + $_POST['l'];
	$updateL=_query("UPDATE jasalmamater SET 
			total		= '$totalL'
			WHERE ukuran = 'l'");
	}if(!empty($_POST['xl'])){
	$sisaXL=GetName('jasalmamater','ukuran','xl','total');
	$totalXL=$sisaXL + $_POST['xl'];
	$updateXL=_query("UPDATE jasalmamater SET 
			total		= '$totalXL'
			WHERE ukuran = 'xl'");
	}if(!empty($_POST['xxl'])){
	$sisaXXL=GetName('jasalmamater','ukuran','xxl','total');
	$totalXXL=$sisaXXL + $_POST['xxl'];
	$updateXXL=_query("UPDATE jasalmamater SET 
			total		= '$totalXXL'
			WHERE ukuran = 'xxl'");
	}
			}else{
		$InsertDetail=_query("INSERT INTO transaksibeli (Notrans,userid,Jumlah,Harga,TglBayar,SubmitBy) VALUES('$TrackID', '$User', '$_POST[m]','$harga', '$TglBayar','$_SESSION[Nama]')");
		 }
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiBeli-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");

}else{
global $hitu;
$idInv = $_POST['barang'];
$NamaStafff=NamaStaff($idRektor);
$jbatan=JabatanIdStaff($idRektor);
echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='pembelian'>
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
						$inv="SELECT * FROM inventaris ORDER BY NamaInventaris ASC";
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
		<div class='span3'>
			<label class='control-label'>M</label>
				<div class='controls'>
					<input type=text class='span12' name='m' placeholder='Jumlah..' onFocus='startCalc();' onBlur='stopCalc();'/>
				</div>
		</div>
		<div class='span3'>
			<label class='control-label'>L</label>
				<div class='controls'>
					<input type=text class='span12' name='l' placeholder='Jumlah..' onFocus='startCalc();' onBlur='stopCalc();'/>
				</div>
		</div>
		<div class='span3'>
			<label class='control-label'>XL </label>
				<div class='controls'>
					<input type=text class='span12' name='xl' placeholder='Jumlah..' onFocus='startCalc();' onBlur='stopCalc();'/>
				</div>
		</div>
		<div class='span3'>
			<label class='control-label'>XXL </label>
				<div class='controls'>
					<input type=text class='span12' name='xxl' placeholder='Jumlah..' onFocus='startCalc();' onBlur='stopCalc();'/>
				</div>
		</div>
	</div>
</div>";
}else{
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span12'>
			<label class='control-label'>Jumlah</label>
				<div class='controls'>
					<input type='text' class='span12' name='m' placeholder='Masukkan Jumlah barang..' onFocus='startCalc();' onBlur='stopCalc();'/>
					<input type='hidden' class='span12' name='l' value='0'/>
					<input type='hidden' class='span12' name='xl' value='0'/>
					<input type='hidden' class='span12' name='xxl' value='0'/>
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
					<input type='text' class='span12' name='harga' placeholder='Harga Per Pcs' $hitu/>
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
	<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanPembelian'>
	<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
</div> 
</div>
</form></fieldset>";
 }
}else{
ErrorAkses();
} ?>