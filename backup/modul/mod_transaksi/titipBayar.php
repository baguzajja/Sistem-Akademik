<?php
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
echo"<div class='widget-toolbar' style='margin-bottom: 0;margin-top: 0;'>
<div class='row-fluid'>
<div class='pull-left'><h4><i class='icon-hand-right'></i>&nbsp;&nbsp;Transaksi Pembayaran Mahasiswa </h4></div>
<div class='pull-right'><h4> </h4></div>
</div></div>
<div class='widget-content'>";
if(isset($_POST['BayarPaymen']))
{
    global $tgl_sekarang;
    $prog 			= $_POST['prog'];
	$noreg 			= $_POST['NoReg'];
	$transaksi		= $_POST['transaki'];
	$payments		= $_POST['payment'];
	$piutang		= $_POST['piutang'];
	$TrackID		= $_POST['TrackID'];
	$nominal		= str_replace(',','',$_POST['JmlahBayar']);
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar       =sprintf("%02d%02d%02d",$_POST['ThnBayar'],$_POST['BlnBayar'],$_POST['TglBayar']);
	
	$jenis          = $_POST['jnis'];
    $book 			= $_POST['buku'];
	$rekan 			= $_POST['rekanan'];
	$JuMlah 		= str_replace(',','',$_POST['Total']);
	$Pot 			= str_replace(',','',$_POST['Potongan']);
	$TotalBiaya		=$JuMlah-$Pot;

if ($JuMlah == 0){
alert('error','Proses Pembayaran Mahasiswa Baru Gagal. Biaya Mahasiswa belum di Setting');
CatatLog($_SESSION[Nama],'Pembayaran Mahasiswa Baru','Proses Pembayaran Mahasiswa Baru Gagal. Biaya Mahasiswa belum di Setting');
htmlRedirect('go-transaksi.html',2);	
}else{
//Update Keuangan Mahasiswa
$s = _query("UPDATE keuanganmhsw SET Potongan='$Pot', TotalBiaya ='$TotalBiaya' WHERE RegID='$noreg'");
//Insert Piutang
    $cek=_query("SELECT Id FROM transaksi WHERE Buku='$book' AND Transaksi='19' AND AccID='$noreg'");
		if (_num_rows($cek) == 0)
		{
			$insertd=_query("INSERT INTO transaksi (TransID,Buku,Transaksi,Debet,Kredit,AccID,TglBayar,SubmitBy, TglSubmit,Uraian,TanggalCatat,IDpiutang) VALUES
            ('$TrackID','$book', '19','$TotalBiaya','0', '$noreg','$tgl_sekarang','$_SESSION[Nama]','$tgl_sekarang','Penerimaan Mahasiswa Baru NO REGISTRASI :$noreg','$_POST[tanggal_catat]', '')");
		}
//insert Payment
	$insertpay=_query("INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$payments', '$transaksi', '$nominal', '0', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')");
//Kurangi Piutang
	$insertpiut=_query("INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$piutang', '$transaksi', '0', '$nominal', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')");
//Update Mahasiswa
$s1 =_query( "UPDATE mahasiswa SET RekananID='$rekan' WHERE NoReg='$noreg'");
//tampilkan Pesan
alerPrint("Pembayaran Mahasiswa","Pembayaran Mahasiswa Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","go-transaksi.html","get-prind-mhspay-$TrackID.html");
CatatLog($_SESSION[Nama],'Pembayaran Mahasiswa','Pembayaran Mahasiswa Berhasil Di Simpan');
}

}else{
 $jenjang=$r[JenjangID];
 $thn=substr("$r[Angkatan]",3,4);
 $tglsubmit=tgl_indo($r[TglSubmit]);
 $Prodi=NamaProdi($r[ProdiID]);
 $kelas=NamaKelasa($r[IDProg]);
 $TotalB =TotalBayar($r['NoReg'],$jenjang);
 $BayarKe=PembayaranKe($r['NoReg']);
 $TotalBayar=($TotalB==0)? "....Belum Ada Pembayaran...": "Rp. ".digit($TotalB);
 if($jenjang=='S1'){
	$piutang="4";
	$transaksi="17";
	$bank="2";
	$tunai="1";
    $buku="4";
 }elseif($jenjang=='S2'){
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
 $Prodi=NamaProdi($r[ProdiID]);
 $Rekanan=NamaRekanan($r[RekananID]);
 $Track=NoTransaksi();
    $waktu=time(); 
    $dis=($r['RekananID']==0)? 'disabled':'';
 $no++;
echo"<div class='row-fluid'>
	<div class='widget-table span6'>
 <div class='widget-header'><h3><i class='icon-user'></i> Data Calon Mahasiswa</h3></div>
<div class='widget-content'>
	<table class='table table-bordered table-striped'>     
		<tbody>
			<tr>                             
				<td width='30%'>Nama</td>
				<td>$r[Nama]</td>                             
			</tr>
            <tr>                             
				<td width='30%'>No Registrasi</td>
				<td>$r[NoReg]</td>                             
			</tr>
			<tr>
				<td class='description'>Program Studi</td>
				<td class='value'><span>$r[JenjangID] - $Prodi</span></td>
			</tr>
			<tr>
				<td class='description'>Kelas </td>
				<td class='value'><span>$kelas</span></td>
			</tr>
			<tr>
				<td class='description'>Alamat</td>
				<td class='value'><span>$r[AlamatAsal] <br/> $r[KotaAsal] - $r[KodePosAsal] - $r[PropinsiAsal]</span></td>
			</tr>
			<tr>
				<td class='description'>Tlp / Hp</td>
				<td class='value'><span>$r[Telepon] / $r[Handphone]</span></td>
			</tr>
			<tr>
				<td class='description'>Rekanan</td>
				<td class='value'><span>
                <select name='rekanan' class='span12' $dis>
					<option value=''>- Tidak Ada Rekanan -</option>";
					$t=_query("SELECT * FROM rekanan ORDER BY RekananID");
					while($s=_fetch_array($t)){
					$cek=($s['RekananID']==$r['RekananID'])?"selected":"";
					echo "<option value='$s[RekananID]' $cek>$s[NamaRekanan]</option>";
						}
					echo "</select>
                </span></td>
			</tr>
			<tr>
				<td class='description'>Tanggal Submit</td>
				<td class='value'><span>$tglsubmit</span></td>
			</tr>                           
			<tr>
				<td class='description'>Disubmit Oleh </td>
				<td class='value'><span>$r[SubmitOleh]</span></td>
			</tr>";
    if($r[RekananID]=='0'){
    $TotalBiayaMhsw= TotalBiayaMhsw($thn,$r['JenjangID'],$r['IDProg']);
    $TotalValue=Comaa($TotalBiayaMhsw);
    if($TotalBiayaMhsw > 0)
        {
        $Totale=digit($TotalBiayaMhsw);
        echo"<tr>
                <td class='description'>Total Biaya </td>
                <td class='value'><span>Rp. $Totale</span>
                    <input type=hidden name='Total' value='$TotalValue'>
                    <input type=hidden name='Potongan' value='0'>
                </td>
             </tr>";
        }
        else
        {
        $pesan=alert('error','Biaya Mahasiswa Belum Di Setting');
        echo"<tr>
                <td class='description'>Total Biaya </td>
                <td class='value'><span>Rp. $pesan</span>
                    <input type=hidden name='Total' value='$TotalValue'>
                    <input type=hidden name='Potongan' value='0'>
                </td>
             </tr>";
        }
    }
    else
    {
        $Tott =($r['TotalBiaya']== 0)? '':Comaa($r['TotalBiaya']);
        $Pott =Comaa($r['Potongan']);
         echo"<tr>
                <td class='description'>Total Biaya </td>
                <td class='value'><input type=text name='Total'
                        onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" value='$Tott' class='span12' required></td>
                </tr>";
          echo"<tr>
                <td class='description'>Potongan </td>
                <td class='value'><input type=text name='Potongan' value='$Pott' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\" class='span12'></td>
                </tr>";
    }  
		echo"</tbody>
	</table>
</div>
<div class='widget-toolbar'>
<div class='input-prepend input-append pull-left btn-group'>
	<span class='add-on'>TOTAL PEMBAYARAN </span>
	<span class='add-on'>$TotalBayar </span>
</div>
</div>
	</div>
	<div class='span6 widget-form'>
	<div class='widget-content'>
		<input type=hidden name='prog' value='$r[IDProg]'>
		<input type=hidden name='NoReg' value='$r[NoReg]'>
		<input type=hidden name='TrackID' value='$Track'>
		<input type=hidden name='transaki' value='$transaksi'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='piutang' value='$piutang'>
        <input type='hidden' name='buku' value='$buku'>
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
// Jika Mahasiswa Reguler
if($r[RekananID]=='0' ){
			echo"<div class='control-group'>
			<label class='control-label'>Jenis Transaksi </label>
			<div class='controls'>
				<select name='jnis' class='span12'>
				<option value=''>- Pilih Jenis Transaksi -</option>";
					$jenist="SELECT * FROM biayamhsw WHERE TahunID='$thn' AND JenjangID='$jenjang' AND KelasID='$r[IDProg]' ORDER BY BiayaMhswID ASC";
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
					<input type=radio name='payment' value='$bank'> Transfer 
					<input type=radio name='payment' value='$tunai'> Tunai
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
				<button type='submit' name='BayarPaymen' class='btn btn-success'>Proses</button>
				<a class='btn btn-danger' href='go-transaksi.html'>Batal</a>
			</div>
			</div>
		</fieldset>
	</div>
	</div>
	</div>";	
}	
echo"</div>";