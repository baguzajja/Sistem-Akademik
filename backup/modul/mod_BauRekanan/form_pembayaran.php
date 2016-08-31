<?php
global $today,$BulanIni,$TahunIni;
$Rekanan   =NamaRekanan($_GET['md']);
echo"<div class='widget'>
<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'><h4><i class='icon-hand-right'></i>&nbsp;&nbsp;Transaksi Pembayaran Mahasiswa Rekanan</h4></div>
<div class='pull-right'><h4>$Rekanan</h4></div>
</div></div>
<div class='widget-content'>";
if(isset($_POST['BayarRekanan']))
{
    global $tgl_sekarang;
    $TrackID		= $_POST['TrackID'];
	$nominal		= str_replace(',','',$_POST['JmlahBayar']);
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar       = sprintf("%02d%02d%02d",$_POST['ThnBayar'],$_POST['BlnBayar'],$_POST['TglBayar']);
	$jumlahDibayar  = round($nominal/$_POST['JmlahMhsw']);
    
    $qry = _query("SELECT * FROM mahasiswa a, keuanganmhsw b
        WHERE a.NoReg=b.RegID AND a.RekananID ='$_POST[rekan]' AND a.LulusUjian='N' AND b.lunas='N'");
	while ($r=_fetch_array($qry))
    {
         if($r['JenjangID']=='S1'){
            $piutang="4";
            $transaksi="17";
            $bank="2";
            $tunai="1";
            $buku="4";
         }elseif($r['JenjangID']=='S2'){
            $piutang="7";
            $transaksi="18";
            $bank="8";
            $tunai="9";
            $buku="7";
         }else{
            $piutang="";
            $transaksi="";
            $bank="";
            $tunai="";
            $buku="";
         }
         
        $payments=($_POST['payment']=='tunai') ? $tunai : $bank; 
        $jenis =PembayaranKe($r['RegID']);
        $pay = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
        ('$TrackID', '$payments', '$transaksi', '$jumlahDibayar', '0', '$r[RegID]', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$Keterangan', '$_POST[tanggal_catat]', '$piutang','$jenis')";
        $insertpay=_query($pay);
        // Kurangi Piutang
        $piut = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
        ('$TrackID', '$piutang', '$transaksi', '0', '$jumlahDibayar', '$r[RegID]', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$Keterangan', '$_POST[tanggal_catat]', '$piutang','$jenis')";
        $insertpiut=_query($piut);
        
        //logika total bayar
         $TotalBayar=TotalBayar($r['RegID'],$r['JenjangID']);
        if($r['TotalBiaya']!=0 && $TotalBayar >= $r['TotalBiaya']){
        $qrsisa = _query("UPDATE keuanganmhsw SET lunas='Y' WHERE RegID ='$r[RegID]'");  
        }
    }
    //Masukkan Detail Pembayaran Rekanan 
        $Rekpay = "INSERT INTO detailbayarRekanan (TransID, RekananID,qty,Total) VALUES 
        ('$TrackID', '$_POST[rekan]', '$_POST[JmlahMhsw]','$nominal' )";
        $insertRekpay=_query($Rekpay);
//tampilkan pesan
alerPrint("Pembayaran Mahasiswa","Pembayaran Mahasiswa Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","go-BauRekanan.html","get-print-rekananpay-$TrackID.html");
CatatLog($_SESSION[Nama],'Pembayaran Mahasiswa','Pembayaran Mahasiswa Berhasil Di Simpan');

}else{
 $TotalMhsRekanan       =TotalMhsRekanan($_GET['md']);
 $TotalBiayaMhsRek      =TotalBiayaMhsRekanan($_GET['md']);
 $TotalBiayaMhsRekanan  =digit($TotalBiayaMhsRek);
 $Track     =NoTransaksi();
 $waktu     =time(); 
 $waktus     =round(800002); 
echo"<div class='row-fluid'>
	<div class='widget-table span6'>
 <div class='widget-header'><h3><i class='icon-user'></i> Data Keuangan Mahasiswa Rekanan $waktus</h3></div>
<div class='widget-content'>
	<table class='table table-bordered table-striped'>     
		<tbody>
			<tr>                             
				<td colspan='2'>Total Mahasiswa</td>
				<td><b>$TotalMhsRekanan</b> Orang</td>                             
			</tr>
            <tr>                             
				<td colspan='2'>Total Biaya Mahasiswa</td>
				<td>Rp. <b>$TotalBiayaMhsRekanan</b></td>                             
			</tr>
			<tr>
				<td class='description' colspan='3'><b>HISTORY PEMBAYARAN :</b></td>
			</tr>";
$h = "SELECT * FROM transaksi WHERE AccID IN (SELECT NoReg FROM mahasiswa WHERE RekananID ='$_GET[md]' AND LulusUjian='N') AND Transaksi IN ('17','18') AND Buku IN ('1','2','8','9') GROUP BY TransID ORDER BY TglBayar ASC";
$kl = _query($h);
while ($b = _fetch_array($kl)) {
        $cek=_query("SELECT * FROM detailbayarrekanan WHERE transID='$b[TransID]' AND RekananID='$_GET[md]'");
		if (_num_rows($cek)>0)
		{
			$row=_fetch_array($cek);
            $debet=$row['Total'];
			$Jumlah= digit($debet);
			$link= "rekpay";
		}
        else
        {
            $debet=$b['Debet'];
            $Jumlah= digit($debet);
            $link= "mhspay";
        }
$tglb=explode('-',$b[TglBayar]);		
$tglBayar= $tglb[2].'-'.$tglb[1].'-'.$tglb[0];		
    echo"<tr>
			<td class='description'>$tglBayar</td>
			<td class='description'><a href='get-print-$link-$b[TransID].html?lightbox[iframe]=true&ui-lightbox[width]=75p&ui-lightbox[height]=75p' class='ui-lightbox ui-tooltip' data-placement='right' title='Detail Transaksi'>$b[TransID]</a> | $b[Uraian]</td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
		</tr>";
$TotB=$TotB+$debet;
}
$TotalBayar=digit($TotB);
$kekurngan=	$TotalBiayaMhsRek - $TotB;	
$Totalkekurngan=digit($kekurngan);
    echo"</tbody>
    <tfoot>
        <tr>
            <td colspan='2'><b>TOTAL PEMBAYARAN </b></td>
            <td class=''>Rp.  <b class='pull-right'>$TotalBayar</b></td>
        </tr>
        <tr>
            
            <td colspan='2'><b>SISA PEMBAYARAN</b></td>
            <td class=''>Rp.  <b class='pull-right'>$Totalkekurngan</b></td>
        </tr>
    </tfoot>
    </table>
</div>
	</div>
	<div class='span6 widget-form'>
	<div class='widget-content'>
		<input type=hidden name='rekan' value='$_GET[md]'>
		<input type=hidden name='TrackID' value='$Track'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='JmlahMhsw' value='$TotalMhsRekanan'>
		<fieldset>";
echo"<div class='widget-header'>
		<h3><i class='icon-list'></i>Pembayaran</h3>
	</div>";
echo"<div class='control-group'>
        <label class='control-label' for='name'>TRANSAKSI ID</label>
        <div class='controls'>
            <input type=text name='TrackID' value='$Track' class='span12' disabled>
        </div>
    </div>";        
echo"<div class='control-group'>
				<label class='control-label'>Jumlah Pembayaran</label>
				<div class='controls'>
					<input type=text name='JmlahBayar' value='$_POST[JmlahBayar]' class='span12' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" required>
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
					<input type=radio name='payment' value='transfer'> Transfer 
					<input type=radio name='payment' value='tunai'> Tunai
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12' placeholder='Masukkan keterangan .....' required></textarea>
				</div>
			</div>
			<div class='form-actions'>
			<div class='btn-group'>
				<button type='submit' name='BayarRekanan' class='btn btn-success'>Proses</button>
				<a class='btn btn-danger' href='go-BauRekanan.html'>Batal</a>
			</div>
			</div>
		</fieldset>
	</div>
	</div>
	</div>";	
}	
echo"</div></div>";