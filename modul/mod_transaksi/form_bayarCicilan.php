<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat AND $edit){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $tglapprovel=tgl_indo($r[ApproveDate]);
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
 $Rekanan=NamaRekanan($r[RekananID]);
 $Track=NoTransaksi();
 $jenjang=$r[JenjangID];
$BayarKe=PembayaranKe($r[NoReg]);
if($jenjang=='S1'){
	$piutang="4";
	$transaksi="17";
	$bank="2";
	$tunai="1";
	$trans="17";
	$buku="'1','2'";
 }elseif($jenjang=='S2'){
	$piutang="7";
	$transaksi="18";
	$bank="8";
	$tunai="9";
	$trans="18";
	$buku="'8','9'";
 }else{
	$piutang="";
	$transaksi="";
	$bank="";
	$tunai="";
	$trans="'17','18'";
	$buku="'1','2','8','9'";
 }
 $waktu=time(); 
 $no++;
echo"<div class='row'>
<div class='span12'>
<div class='widget'>
<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'>
	<h4><i class='icon-hand-right'></i>&nbsp;&nbsp;Pembayaran Mahasiswa</h4>
</div>
<div class='pull-right'>
<h4>$r[Nama] - $r[NIM]</h4>
</div>
</div></div>
<div class='widget-content'>";
if(isset($_POST['BayarCicilan']))
{
	global $tgl_sekarang;
	$noreg 			= $_POST['NoReg'];
	$TrackID		= $_POST['TrackID'];
	$transaksi		= $_POST['transaki'];
	$payments		= $_POST['payment'];
	$piutang		= $_POST['piutang'];
	$JmlahBayar		= $_POST['JmlahBayar'];
	$nominal 		= str_replace(',','',$JmlahBayar);
    $sisa		    = $_POST['sisa'] - $nominal;
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$TglKet=tgl_indo($TglBayar);
    $jenis= $_POST['jnis'];

	$pay = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$payments', '$transaksi', '$nominal', '0', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
	$insertpay=_query($pay);

    $piut = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
        ('$TrackID', '$piutang', '$transaksi', '0', '$nominal', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
        $insertpiut=_query($piut);
    if($sisa <= 0){
        $qrsisa = _query("UPDATE keuanganmhsw SET lunas='Y' WHERE RegID ='$noreg'");  
    }
        
//tampilkan pesan
alerPrint("Pembayaran Mahasiswa","Pembayaran Mahasiswa Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-pay.html","get-prind-mhspay-$TrackID.html");
CatatLog($_SESSION[Nama],'Pembayaran Mahasiswa','Pembayaran Mahasiswa Berhasil Di Simpan');
}else{
echo"<div class='row-fluid'>
	<div class='span6'>
		<div class='widget widget-tables'>
		<div class='widget-header'>
	<h3><i class='icon-align-left'></i>&nbsp;&nbsp;History Pembayaran :: </h3>
		</div>
			<div class=''>";
if($r[RekananID]=='0' ){
			echo"<table class='table table-striped table-bordered table-highlight'>     
				<thead>
					<tr>                             
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>                             
					</tr>
				</thead><tbody>";
	$h = "SELECT * FROM transaksi WHERE AccID='$r[NoReg]' AND Transaksi IN ($trans) AND Buku IN ($buku) ORDER BY TglBayar ASC";
	$kl = _query($h);
	$nomor=1;
	while ($b = _fetch_array($kl)) {	
	$Jumlah=digit($b[Debet]);
	$tglBayar=tgl_indo($b[TglBayar]);
	$namaBiaya=BiayaMhsw($b[SubID]);
	echo"<tr>
			<td class='description'>$nomor</td>
			<td class='value'><span>$tglBayar</span></td>
			<td class='value'><span>$namaBiaya</span></td>
			<td class='value'><a href='mhsw-transaksiKeuangan-DetailTransaksiBayar-$r[NoReg]-$b[TransID].html'>Rp. <span class='pull-right'>$Jumlah</span></a></td>
		</tr>";
	$nomor++; 
	$tot=$tot + $b[Debet];
	}
$totalByr=digit($tot);
$krg=$r[TotalBiaya] - $tot ;
$kurangbyr=digit($krg);
echo"</tbody><tfoot>
<tr><td colspan='4'></td></tr>
<tr><td colspan='3'><b>Total Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$totalByr</span></b></td></tr>
<tr><td colspan='3'><b>Kekurangan Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$kurangbyr</span></b></td></tr>
</tfoot></table>";
}else{
echo"<table class='table table-striped table-bordered table-highlight'>     
				<thead>
					<tr>                             
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>                             
					</tr>
				</thead><tbody>";
	$h = "SELECT * FROM transaksi WHERE AccID='$r[NoReg]' AND Transaksi IN ($trans) AND Buku IN ($buku) ORDER BY TglBayar ASC";
	$kl = _query($h);
	$nomor=1;
	while ($b = _fetch_array($kl)) {	
	$Jumlah=digit($b[Debet]);
	$tglBayar=tgl_indo($b[TglBayar]);
	$namaBiaya= $b[SubID];
	echo"<tr>
			<td class='description'>$nomor</td>
			<td class='value'><span>$tglBayar</span></td>
			<td class='value'><span>Pembayaran Ke <b>$namaBiaya</b></span></td>
			<td class='value'><a class='ui-lightbox' href='get-prind-mhspay-$b[TransID].html?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p'>Rp. <span class='pull-right'>$Jumlah</span></a></td>
		</tr>";
	$nomor++; 
	$tot=$tot + $b[Debet];
	}
$totalByr=digit($tot);
$krg=$r[TotalBiaya] - $tot ;
$kurangbyr=digit($krg);
echo"</tbody><tfoot>
<tr><td colspan='3'><b>Total Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$totalByr</span></b></td></tr>
<tr><td colspan='3'><b>Kekurangan Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$kurangbyr</span></b></td></tr>
</tfoot></table>";
}
echo"</div></div></div>
	<div class='span6'>
		<input type=hidden name='prog' value='$r[IDProg]'>
		<input type=hidden name='rekan' value='$r[RekananID]'>
		<input type=hidden name='NoReg' value='$r[NoReg]'>
		<input type=hidden name='TrackID' value='$Track'>
		<input type=hidden name='transaki' value='$transaksi'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='piutang' value='$piutang'>
		<input type=hidden name='sisa' value='$krg'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>TRANSAKSI ID </label>
			<div class='controls'>
				<input type=text name='TrackID' value='$Track' class='span12' disabled>
			</div>
			</div>";
if($r[RekananID]=='0'){
$tahuns=substr($r[NIM],0,4);
			echo"<div class='control-group'>
				<label class='control-label'>Jenis Transaksi </label>
				<div class='controls'>
					<select name='jnis' class='span12'>
					<option value=''>- Pilih Jenis Transaksi -</option>";
						$jenist="SELECT * FROM biayamhsw WHERE TahunID='$tahuns' AND JenjangID='$jenjang' AND KelasID='$r[IDProg]' ORDER BY BiayaMhswID ASC";
							$jn=_query($jenist) or die();
							while ($j=_fetch_array($jn)){
							echo "<option value='$j[BiayaMhswID]'> $j[NamaBiaya]</option>";
							}
					echo"</select>
				</div>
			</div>";
}else{
echo"<input type=hidden name='jnis' value='$BayarKe'>";
}
	echo"<div class='control-group'>
				<label class='control-label'>Jumlah Pembayaran</label>
				<div class='controls'>
				<input type='text' name='JmlahBayar' class='span12' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" required/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal Bayar</label>
				<div class='controls'>";
			combotgl(1,31,'TglBayar',$today);
			combobln(1,12,'BlnBayar',$BulanIni);
			combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
			echo"</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Cara Pembayaran</label>
				<div class='controls'>
					<input type=radio name='payment' value='$bank'> Transfer 
					<input type=radio name='payment' value='$tunai'> Tunai
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12' required>Pembayaran ke $BayarKe  </textarea>
				</div>
			</div>
		<div class='form-actions'>
			<div class='btn-group'>
				<button type='submit' name='BayarCicilan' class='btn btn-success'>Proses</button>
				<a class='btn btn-danger' href='aksi-transaksi-pay.html'>Batal</a>
			</div>
			</div>
		</fieldset>
	</div>
</div>";
}
?>	
</div></div></div></div>
<?php }else{
ErrorAkses();
} ?>