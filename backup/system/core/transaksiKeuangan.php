<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php
function defaulttransaksiKeuangan(){
$jabatan=$_SESSION[Jabatan];
 if ($jabatan=='14' OR $jabatan=='12'){
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND a.NIM='' AND a.LulusUjian='N' ORDER BY b.TglSubmit DESC";
$w = _query($s);
 $no=0;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan

</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#KeuanganMahasiswa' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
</ul>
		<br/>
		<legend>Data Mahasiswa Baru <small>( Berikut Ini adalah Daftar Calon Mahasiswa )</small></legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NO REGISTRASI</th>
					<th>NAMA</th>
					<th>PROGRAM STUDI</th>
					<th>TAHUN AJARAN</th>
					<th>TGL SUBMIT</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$tglsubmit=tgl_indo($r['TglSubmit']);
	$prodi=NamaProdi($r[ProdiID]);
$Tahun=GetName("tahun","Tahun_ID",$r[TahunID],"Nama");
$NamaTahun=explode(" ",$Tahun);
	$no++;
	echo"<tr>
			<td>$no</td>
			<td>$r[NoReg]</td>
			<td>$r[Nama]</td>
			<td>$r[JenjangID] - $prodi</td>
			<td>$NamaTahun[2]</td>
			<td>$tglsubmit</td>
			<td><a href='get-transaksiKeuangan-Aprove-$r[RegID].html' class='btn btn-mini btn-success'>Approve</a></td>
		</tr>";
}
echo"</tbody></table></div>";
} else {
$s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.Aktif='Y' AND b.Keterangan='Approved' AND a.LulusUjian='N'";
$w = _query($s);
$no=0;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#KeuanganMahasiswa' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
			<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
		<legend>Data Mahasiswa Baru <small>( Berikut Ini adalah Daftar Mahasiswa Baru )</small></legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NO REGISTRASI</th>
					<th>NAMA</th>
					<th>PROGRAM STUDI</th>
					<th>TAHUN AJARAN</th>
					<th>TGL APPROVE</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$tglsubmit=tgl_indo($r['ApproveDate']);
	$prodi=NamaProdi($r[ProdiID]);
	$no++;
echo"<tr>
		<td>$no</td>
		<td>$r[NoReg]</td>
		<td>$r[Nama]</td>
		<td>$r[JenjangID] - $prodi</td>
		<td>$r[TahunID]</td>
		<td>$tglsubmit</td>
		<td><a href='get-transaksiKeuangan-BayarPertama-$r[RegID].html' class='btn btn-mini btn-success'>Proses</a></td>
	</tr>";
}
echo"</tbody></table></div>";
}
}

function Aprove(){
 $no=0;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='N' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $tglsubmit=tgl_indo($r[TglSubmit]);
 $Prodi=NamaProdi($r[ProdiID]);
 $Rekanan=NamaRekanan($r[RekananID]);
  $Track=NoTransaksi();
$jenjang=$r[JenjangID];
 if($jenjang=='S1'){
$buku="4";
 }elseif($jenjang=='S2'){
$buku="7";
 }else{
$buku="";
 }
 $waktu=time(); 
 $no++;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#KeuanganMahasiswa' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
			<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
	<legend>Proses Approval Mahasiswa Baru <small>( Pastikan Semua Data2 Mhswa Benar Sebelum Di Proses )</small></legend>
	<div class='row-fluid'>
	<div class='span6'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanApprovel.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='prog' value='$r[IDProg]'>
		<input type=hidden name='rekanan' value='$r[RekananID]'>
		<input type=hidden name='NoReg' value='$r[NoReg]'>
		<input type=hidden name='nomor' value='$Track'>
		<input type=hidden name='buku' value='$buku'>
		 <input type=hidden name='tanggal_catat' value='$waktu'> 
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>NO PENDAFTARAN : </label>
			<div class='controls'>
				<b>$r[NoReg]</b>
			</div>
			</div>";
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
echo"<table class='table table-bordered table-striped'>     
	<thead>
		<tr><th colspan='2'>Rincian Biaya Prekuliahan</th></tr>
		<tr><th>Uraian</th><th>Jumlah</th></tr>
	</thead>                       
	<tbody>";
 $Biaya = "SELECT * FROM biayamhsw WHERE BiayaMhswID IN ('4','5','6','7','8','9','10','11') ORDER BY BiayaMhswID ASC";
 $by = _query($Biaya);
while($b=_fetch_array($by)){
$jmlh=$b[Jumlah];
$jumlah =digit($jmlh);
$tot+=$jmlh;
$total=digit($tot);
echo"<tr>
		<td class='description'>$b[Keterangan]
<input type=hidden name='$b[BiayaMhswID]' value='$b[Jumlah]'></td>
		<td class='value'>Rp. <span class='pull-right'>$jumlah</span></td>
	</tr>";
}
echo"</tbody>
<tfoot><tr><td><b>Total Biaya</b></td><td><b>Rp. <span class='pull-right'>$total</span></b></td></tr></tfoot>
</table>
<input type=hidden name='Total' value='$tot'>
<input type=hidden name='Potongan' value='0'>";
}else{
echo"<div class='control-group'>
				<label class='control-label'>Jumlah Biaya</label>
				<div class='controls'>
					<input type=text name='Total' value='$_POST[Total]' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\">
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Potongan</label>
				<div class='controls'>
					<input type=text name='Potongan' value='$_POST[Potongan]' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\">
				</div>
			</div>";
}
echo"<div class='control-group'>
				<label class='control-label'>NIM</label>
				<div class='controls'>
					<input type=text name='NIM' value='$_POST[NIM]'>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form>
	</div>
	<div class='span6'>
				<div class='panel'>
                    <div class='panel-header'><i class='icon-user'></i> Data Calon Mahasiswa</div>
                    <div class='panel-content panel-tables'>

                            <table class='table table-bordered table-striped'>     
                            <thead>
                            <tr>                             
                                <th>Nama</th>
                                <th>$r[Nama]</th>                             
                            </tr>
                            </thead>                       
                            <tbody>
                            <tr>
                                <td class='description'>Program Studi</td>
                                <td class='value'><span>$r[JenjangID] - $Prodi</span></td>
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
                                <td class='value'><span>$Rekanan</span></td>
                            </tr>
                            <tr>
                                <td class='description'>Tanggal Submit</td>
                                <td class='value'><span>$tglsubmit</span></td>
                            </tr>                           
                            <tr>
                                <td class='description'>Disubmit Oleh </td>
                                <td class='value'><span>$r[SubmitOleh]</span></td>
                            </tr>
                            </tbody>
                            </table>

                    </div>
                </div>
	</div>
	</div>";
echo"</div>";
}

function delTrans(){
$jTrans = $_REQUEST['id'];
$tabel1="transaksi";
$kondisi1="TransID='$jTrans'";
delete($tabel1,$kondisi1);
	$cekTransaksi=_query("SELECT * FROM transaksihnrstaff WHERE Notrans='$jTrans'");
	if (_num_rows($cekTransaksi)>0)
		{
		$tabel2="transaksihnrstaff";
		$kondisi2="Notrans='$jTrans'";
		delete($tabel2,$kondisi2);
		}
PesanOk("Hapus Data Transaksi","Data Transaksi Berhasil Di Hapus","aksi-transaksiKeuangan-jurnalTrans.html");
}
function jurnalTrans(){
$jTrans = (empty($_REQUEST['id']))? '' : $_REQUEST['id'];
$Natrans=NamaTransaksi($_REQUEST['id']);
$btn="<div class='btn-group'>
					<a class='btn btn-success' href='aksi-imporTransaksi-$jTrans.html' title='Import data Transaksi $NamaTransaksi' readonly>Import</a>
					<a class='btn' href='eksport-eksTransaksi-$jTrans.html' title='Eksport data Transaksi $NamaTransaksi'>Export</a>
			</div>";
$NamaTransaksi = (empty($_REQUEST['id']))? '' : $Natrans;
$btnImport = (empty($_REQUEST['id']))? '' : $btn;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
			<li class='active'><a href='#jurnalTrans' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
		<legend>JURNAL TRANSAKSI
		
		<div class='input-prepend input-append pull-right'>
		<span class='add-on'>Pilih Jenis Transaksi</span>
		<select name='transaksi' onChange=\"MM_jumpMenu('parent',this,0)\" class='span5'>
		<option value='aksi-transaksiKeuangan-jurnalTrans.html'>- Pilih Jenis Transaksi -</option>";
		$sqlp="select * from jenistransaksi ORDER BY id";
		$qryp=_query($sqlp) or die();
		while ($d=_fetch_array($qryp)){
		if ($d['id']==$jTrans){ $cek="selected"; }  else{ $cek=""; }
		echo "<option value='get-transaksiKeuangan-jurnalTrans-$d[id].html' $cek> $d[Nama]</option>";
		}
		echo"</select>
			</div>
		</legend>
		<legend><i>Data Transaksi $NamaTransaksi </i>";
		echo"<span class='pull-right'>$btnImport</span>";
		echo"</legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NO TRANS</th>
					<th>TANGGAL</th>
					<th>URAIAN</th>
					<th>JUMLAH</th>
					<th>SUBMIT BY</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	$tr="SELECT * FROM transaksi WHERE Transaksi='$jTrans' GROUP BY TransID ORDER BY TglBayar ASC";
	$w=_query($tr);
	while ($r = _fetch_array($w)) {
	$tglTransaksi=tgl_indo($r[TglBayar]);
	if($r['Debet']=='0'){
	$jum=$r[Kredit];
	$jumlah=digit($jum);
	}else{
	$jum=$r[Debet];
	$jumlah=digit($jum);
	}
	$no++;
echo"<tr>
		<td>$no</td>
		<td>$r[TransID]</td>
		<td>$tglTransaksi</td>
		<td>$r[Uraian]</td>
		<td>Rp. <span class='pull-right'>$jumlah</span></td>
		<td>$r[SubmitBy]</td>
		<td><center><div class='btn-group'>
		<a href='get-transaksiKeuangan-delTrans-$r[TransID].html' class='btn btn-mini btn-danger' onClick=\"return confirm('Anda yakin akan Menghapus data Transaksi #$r[TransID] ?')\">Hapus</a>
		</div></center></td>
	</tr>";
$TotB +=$jum;
$Totalk=digit($TotB);
}
echo"</tbody><tfoot><tr>
	<td colspan='4'><b>Total Seluruhnya : </b></td>
	<td><b>Rp. <span class='pull-right'>$Totalk</span></b></td>
	<td colspan='2'></td>
	</tr></tfoot></table></div>";
}
function PembayaranMhsw(){
$ID=$_GET[id];
if ($ID=='S1'){
$AND="AND b.JenjangID='S1'";
$judul="Data Pembayaran Mahasiswa S1";
}elseif ($ID=='S2'){
$AND="AND b.JenjangID='S2'";
$judul="Data Pembayaran Mahasiswa S2";
}else{
$AND="";
$judul="Data Pembayaran Semua Mahasiswa";
}
$s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.Aktif='Y' AND b.Keterangan!='' $AND";
$w = _query($s);
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li class='active'><a href='#PembayaranMahasiswa' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
			<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
		</ul>
		<br/>
		<legend>$judul
		
		<div class='btn-group pull-right'>
		<a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='btn btn-mini'>Semua Pembayaran</a>
		<a href='get-transaksiKeuangan-PembayaranMhsw-S1.html' class='btn btn-mini btn-inverse'>Pembayaran S1</a>
		<a href='get-transaksiKeuangan-PembayaranMhsw-S2.html' class='btn btn-mini btn-danger'>Pembayaran S2</a>
		</div>
		</legend>
		<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered' id='example'>
			<thead>
				<tr>
					<th>NO</th>
					<th>NIM</th>
					<th>NAMA MAHASISWA</th>
					<th>TOTAL BIAYA</th>
					<th>TOTAL BAYAR</th>
					<th>SISA BAYAR</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
	while ($r = _fetch_array($w)) {
	$TotalBiaya=$r[TotalBiaya];
	$TotBiaya=digit($TotalBiaya);
	$Ttl="SELECT SUM(Debet) AS total FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi='17' AND Buku IN ('1','2','8','9')";
	$j=_query($Ttl);
	$b=_fetch_array($j);
	$TotBayar=$b[total];
	$WesBayar=digit($TotBayar);
	$s=$TotalBiaya - $TotBayar;
	$Sisa=digit($s);
	$no++;
echo"<tr>
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$TotBiaya</span></td>
		<td>Rp. <span class='pull-right'>$WesBayar</span></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
		<td><center><div class='btn-group'>
		<a href='get-transaksiKeuangan-DetailKeuMhsw-$r[RegID].html' class='btn btn-mini'>Detail</a>
		<a href='get-transaksiKeuangan-BayarCicilan-$r[RegID].html' class='btn btn-mini btn-success'>Bayar</a>
		</div></center></td>
	</tr>";
$TotB=$TotB+$r[TotalBiaya];
$SemuaBiaya=digit($TotB);
$TotBy=$TotBy+$b[total];
$SemuaBayar=digit($TotBy);
$TotSis=$TotSis+$s;
$SemuaSisa=digit($TotSis);
}
echo"</tbody><tfoot><tr>
	<td colspan='3'><b>Total Seluruhnya : </b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBiaya</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBayar</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaSisa</span></b></td>
	<td></td>
	</tr></tfoot></table></div>";
}

function BayarPertama(){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan='Approved' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $tglapprovel=tgl_indo($r[ApproveDate]);
 $BiayaPddk=digit($r[Total]);
 $jenjang=$r[JenjangID];
$BayarKe=PembayaranKe($r[NoReg]);
 if($jenjang=='S1'){
	$piutang="4";
	$transaksi="17";
	$bank="2";
	$tunai="1";
 }elseif($jenjang=='S2'){
	$piutang="7";
	$transaksi="18";
	$bank="8";
	$tunai="9";
 }else{
	$piutang="";
	$transaksi="";
	$bank="";
	$tunai="";
 }
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
 $Rekanan=NamaRekanan($r[RekananID]);
 $Track=NoTransaksi();
$waktu=time(); 
 $no++;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li class='active'><a href='#KeuanganMahasiswa' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
</ul>
		<br/>
	<legend>Proses Pembayaran Pertama Mahasiswa <small>( Pastikan Semua Data2 Mhswa Benar Sebelum Di Proses )</small></legend>
	<div class='row-fluid'>
	<div class='span6'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanBayarPertama.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='prog' value='$r[IDProg]'>
		<input type=hidden name='rekan' value='$r[RekananID]'>
		<input type=hidden name='NoReg' value='$r[NoReg]'>
		<input type=hidden name='TrackID' value='$Track'>
		<input type=hidden name='transaki' value='$transaksi'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='piutang' value='$piutang'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>TRANSAKSI ID</label>
			<div class='controls'>
				<input type=text name='TrackID' value='$Track' class='span12' disabled>
			</div>
			</div>";
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
$tahun=substr($r[NIM],0,4);
			echo"<div class='control-group'>
				<label class='control-label'>Jenis Transaksi </label>
			<div class='controls'>
				<select name='jnis' class='span12'>
				<option value=''>- Pilih Jenis Transaksi -</option>";
					$jenist="SELECT * FROM biayamhsw WHERE TahunID='$tahun' ORDER BY BiayaMhswID ASC";
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
					<input type=text name='JmlahBayar' value='$_POST[JmlahBayar]' class='span12' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\">
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal Bayar</label>
				<div class='controls'>";
				combotgl(1,31,'TglBayar',$today);
				combonamabln(1,12,'BlnBayar',$BulanIni);
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
					<textarea name='keterangan' class='span12'>Pembayaran Mahasiswa $r[Nama], NIM:$r[NIM]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form>
	</div>
	<div class='span6'>
				<div class='panel'>
                    <div class='panel-header'><i class='icon-user'></i> Data Keuangan Mahasiswa</div>
                    <div class='panel-content panel-tables'>
						<table class='table table-bordered table-striped'>     
                            <thead>
                            <tr>                             
                                <th>Nama</th>
                                <th>$r[Nama]</th>                             
                            </tr>
							<tr>                             
                                <th>NIM</th>
                                <th>$r[NIM]</th>                             
                            </tr>
                            </thead>                       
                            <tbody>
                            <tr>
                                <td class='description'>Program Studi</td>
                                <td class='value'><span>$r[JenjangID] - $Prodi</span></td>
                            </tr>
                            <tr>
                                <td class='description'>Biaya Pendidikan</td>
                                <td class='value'><span>Rp. $BiayaPddk</span></td>
                            </tr>
                            <tr>
                                <td class='description'>Potongan</td>
                                <td class='value'><span>Rp. $Pot</span></td>
                            </tr>
                            <tr>
                                <td class='description'>Total Biaya</td>
                                <td class='value'><span><b>Rp. $TotBiaya</b></span></td>
                            </tr>
                            <tr>
                                <td class='description'>Tanggal Approval</td>
                                <td class='value'><span>$tglapprovel</span></td>
                            </tr> 
                            </tbody>
						</table>

                    </div>
                </div>
	</div>
	</div>";
echo"</div>";
}
function BayarCicilan(){
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
 }elseif($jenjang=='S2'){
	$piutang="7";
	$transaksi="18";
	$bank="8";
	$tunai="9";
 }else{
	$piutang="";
	$transaksi="";
	$bank="";
	$tunai="";
 }
 $waktu=time(); 
 $no++;
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li class='active'><a href='#PembayaranMahasiswa' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
	
		</ul>
		<br/>
	<legend>Pembayaran Mahasiswa <small>( NO TRANSAKSI: $Track )</small></legend>
	<div class='row-fluid'>
	<div class='span6'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanCicilan.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='prog' value='$r[IDProg]'>
		<input type=hidden name='rekan' value='$r[RekananID]'>
		<input type=hidden name='NoReg' value='$r[NoReg]'>
		<input type=hidden name='TrackID' value='$Track'>
		<input type=hidden name='transaki' value='$transaksi'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='piutang' value='$piutang'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>TRANSAKSI ID </label>
			<div class='controls'>
				<input type=text name='TrackID' value='$Track' class='span12' disabled>
			</div>
			</div>";
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
			echo"<div class='control-group'>
				<label class='control-label'>Jenis Transaksi </label>
				<div class='controls'>
					<select name='jnis' class='span12'>
					<option value=''>- Pilih Jenis Transaksi -</option>";
						$jenist="SELECT * FROM biayamhsw WHERE BiayaMhswID IN ('4','5','6','7','8','9','10','11') ORDER BY BiayaMhswID ASC";
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
				<input type='text' name='JmlahBayar' class='span12' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\"/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal Bayar</label>
				<div class='controls'>";
			combotgl(1,31,'TglBayar',$today);
			combonamabln(1,12,'BlnBayar',$BulanIni);
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
					<textarea name='keterangan' class='span12'>Pembayaran ke $BayarKe  Nama: $r[Nama] NIM: $r[NIM]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='aksi-transaksiKeuangan-PembayaranMhsw.html'>Batal</a>
			</div>
		</fieldset>
	</form>
	</div>
	<div class='span6'>
		<div class='panel'>
		<div class='panel-header'><i class='icon-user'></i> History Pembayaran</div>
			<div class='panel-content panel-tables'>";
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
			echo"<table class='table table-bordered table-striped'>     
				<thead>
					<tr>                             
					<th colspan='4'>$r[Nama] - $r[NIM]</th>                         
					</tr>
					<tr>                             
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>                             
					</tr>
				</thead><tbody>";
	$h = "SELECT * FROM transaksi WHERE AccID='$r[NoReg]' AND Transaksi='17' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
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
echo"<table class='table table-bordered table-striped'>     
				<thead>
					<tr>                             
					<th colspan='4'>$r[Nama] - $r[NIM]</th>                         
					</tr>
					<tr>                             
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>                             
					</tr>
				</thead><tbody>";
	$h = "SELECT * FROM transaksi WHERE AccID='$r[NoReg]' AND Transaksi='17' AND Buku!='4' ORDER BY TglBayar ASC";
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
}
echo"</div></div></div></div></div>";
}
function DetailTransaksiBayar(){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
echo"<div class='panel-header'><i class='icon-sign-blank'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li class='active'><a href='#PembayaranMahasiswa' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
</ul><br/>";
$h = "SELECT * FROM transaksi WHERE TransID='$_GET[codd]' AND Transaksi='17' AND Debet!='0'";
$kl = _query($h);	
$b = _fetch_array($kl);
$Track=$b[TransID];
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
echo"$_GET[codd]";
echo"<legend>NO TRANSAKSI: $Track <div class='btn-group pull-right'><a class='btn btn-danger' href='get-transaksiKeuangan-BayarCicilan-$_GET[id].html'><i class='icon-undo'></i>Kembali</a>
	<a class='btn btn-inverse' href='cetak-cetakTransaksi-$Track.html' target='_blank'>Cetak</a></div></legend>
	<div class='panel'><div class='row-fluid'>
	<div class='span12'>
		<div class='panel-content'><div class='span4'>
		<table class='table table-striped'>     
			<thead>
				<tr><td>Nama</td><th>: $r[Nama]</th></tr>
				<tr><td>NIM</td><th>: $r[NIM]</th></tr>
			</thead>
		</table>
		</div>
		<div class='span4 pull-right'>
		<table class='table table-striped'>     
			<thead>
				<tr><td>PROGRAM STUDI : <b class='pull-right'>$r[JenjangID] - $Prodi</b></td></tr>
				<tr><td></td></tr>
			</thead>
		</table>
		</div>
		</div>";
		
	echo"<div class='panel-content'>
		<table class='table table-bordered table-striped'><thead>
		<tr><th width='20'>No</th><th>Tanggal</th><th>Keterangan</th><th>Jumlah</th></tr></thead><tbody><tr>
			<td class='description'>1</td>
			<td class='description'>$tglBayar</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
		</tr></tbody></table></div>";
		
echo"<div class='panel-content'><div class='span4 pull-right'>
		<table class='table table-striped'>     
			<thead>
				<tr><td><center>Surabaya, $tglSubmit</center></td></tr>
				<tr><td><center>Submit By.  $b[SubmitBy] (BAU)</center></td></tr>
			</thead>
		</table>
		</div></div>";
echo"</div></div></div></div>";
}
function DetailKeuMhsw(){
global $today,$BulanIni,$TahunIni;
 $s = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.RegID='$_GET[id]'";
 $w = _query($s);
 $r = _fetch_array($w);
 $NREG=$r[RegID];
 $BiayaPddk=digit($r[Total]);
 $Pot=digit($r[Potongan]);
 $TotBiaya=digit($r[TotalBiaya]);
 $Prodi=NamaProdi($r[ProdiID]);
if($Totalkekurngan =='0'){
$status="<span class='label'>LUNAS</span>";
}else{
$status="<span class='label label-success'>AKTIF</span>";
}
echo"<div class='panel-header'><i class='icon-sign-blank'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li class='active'><a href='#PembayaranMahasiswa' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li><a href='aksi-transaksiKeuangan-KeuanganUmum.html' class='tab-page' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
</ul><br/>";
echo"<legend>DETAIL Pembayaran Mahasiswa <div class='btn-group pull-right'><a class='btn btn-danger' href='aksi-transaksiKeuangan-PembayaranMhsw.html'><i class='icon-undo'></i>Kembali</a>
	<a class='btn btn-inverse' href='cetak-DetailPembayaran-$NREG.html' target='_blank'>Cetak</a></div></legend>
	<div class='panel'><div class='row-fluid'>
	<div class='span12'>
		<div class='panel-content'><div class='span4'>
		<table class='table table-striped'>     
			<thead>
				<tr><td>Nama</td><th>: $r[Nama]</th></tr>
				<tr><td>NIM</td><th>: $r[NIM]</th></tr>
			</thead>
		</table>
		</div>
		<div class='span4 pull-right'>
		<table class='table table-striped'>     
			<thead>
		<tr><td>PROGRAM STUDI : <b class='pull-right'>$r[JenjangID] - $Prodi</b></td></tr>
		<tr><td>STATUS : <b class='pull-right'>$status</b></td></tr>
			</thead>
		</table>
		</div>
		</div>";
	
	echo"<div class='panel-content'>
		<table class='table table-bordered table-striped'><thead>
<tr><th colspan='5'>TOTAL BIAYA PENDIDIKAN</th>
<th class='badge-warning'>Rp. <span class='pull-right'>$BiayaPddk</span></th></tr>

<tr><th colspan='5'>POTONGAN BIAYA </th>
<th class=''>Rp. <span class='pull-right'> $Pot</span></th></tr>

<tr><th colspan='5'>TOTAL BIAYA </th>
<th class='badge-warning'>Rp. <span class='pull-right'>$TotBiaya</span></th></tr>

		<tr>
			<th width='20'>No</th>
			<th>Tanggal</th>
			<th>Jenis Biaya</th>
			<th>Keterangan</th>
			<th>Jumlah Bayar</th><th></th></tr>
		</thead><tbody>";

$h = "SELECT * FROM transaksi WHERE AccID='$r[RegID]' AND Transaksi='17' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
$kl = _query($h);
 $no=0;
while ($b = _fetch_array($kl)) {
 $no++;	
$Jumlah=digit($b[Debet]);
$tglBayar=tgl_indo($b[TglBayar]);
$tglSubmit=tgl_indo($b[TglSubmit]);
if($r[IDProg]=='1' AND  $r[RekananID]=='0' ){
$namaBiaya=BiayaMhsw($b[SubID]);
}else{
$namaBiaya="Pembayaran Ke <b>".$no."</b>";
}		
		echo"<tr>
			<td class='description'>$no</td>
			<td class='description'>$tglBayar</td>
			<td class='description'>$namaBiaya</td>
			<td class='value'><span>$b[Uraian]</span></td>
			<td class='value'>Rp. <span class='pull-right'>$Jumlah</span></td>
			<td class='value'></td>
		</tr>";
$Bayar=$b[Debet];
$TotB=$TotB+$b[Debet];
}
$TotalBayar=digit($TotB);
$kekurngan=	$r[TotalBiaya] - $TotB;	
$Totalkekurngan=digit($kekurngan);	
echo"<tfoot>
	<tr><td colspan='5'><b>Total Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$TotalBayar</span></b></td></tr>
	<tr><td colspan='5'><b>Kekurangan Pembayaran</b></td><td><b>Rp. <span class='pull-right'>$Totalkekurngan</span></b></td></tr>

</tfoot></tbody></table></div>";	
echo"</div></div></div></div>";
}
function KeuanganUmum(){
$Trans= $_REQUEST['id'];
echo"<div class='panel-header'><i class='icon-group'></i> TRansaksi Keuangan</div>
	<div class='panel-content list-content'>
        <ul class='nav nav-tabs'>
			<li><a href='go-transaksiKeuangan.html' class='tab-page' data-toggle='tab'>Mahasiswa Baru</a></li>
			<li><a href='aksi-transaksiKeuangan-PembayaranMhsw.html' class='tab-page' data-toggle='tab'>Pembayaran Mahasiswa</a></li>
			<li class='active'><a href='aksi-transaksiKeuangan-KeuanganUmum.html' data-toggle='tab'>Transaksi Umum</a></li>
		<li><a href='aksi-transaksiKeuangan-jurnalTrans.html' class='tab-page' data-toggle='tab'>Jurnal Transaksi</a></li>
</ul>
		<br/>
		<legend>Transaksi
			<div class='input-prepend input-append pull-right'>
						<span class='add-on'>Pilih Transaksi</span>
						<select name='transaksi' onChange=\"MM_jumpMenu('parent',this,0)\" class='span5'>
						<option value='aksi-transaksiKeuangan-KeuanganUmum.html'>- Pilih Transaksi -</option>";
						$sqlp="select * from jenistransaksi WHERE id NOT IN(17,18,19)ORDER BY id";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$Trans){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='get-transaksiKeuangan-KeuanganUmum-$d[id].html' $cek> $d[Nama]</option>";
						}
						echo"</select>
			</div>
		</legend>";
	FormTransakksi();	
echo"</div>";
}
function FormTransakksi(){
global $today,$BulanIni,$TahunIni, $tgl_sekarang;
$Trans= $_REQUEST['id'];
$code= $_REQUEST['codd'];
$Notrans= NoTransaksi();
if (!empty($Trans)){
$sql="SELECT * FROM jenistransaksi WHERE id='$Trans'";
$qry=_query($sql)or die ();
$d=_fetch_array($qry);
$transaksiID=$d[id];
$waktu=time(); 
$GajiBulan=getBulan($BulanIni);
$JudulTransaksi=$d[Nama];
$p = false;
if($Trans==7 OR $Trans==18)
{
$p = true;
}
//Bayar Honor Rektorat
if($Trans==14){
$NamaStafff=NamaStaff($code);
$jbatan=JabatanIdStaff($code);
echo"<div class='row-fluid'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanTransaksi.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$transaksiID'>
		<input type=hidden name='user' value='$code'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='rektor'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<h5>$JudulTransaksi</h5>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>No Transaksi</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span5'>
				<input type=text value='$Notrans' class='span12' readonly>
			</div>
			<div class='span7'>
				<div class='input-prepend input-append'>
						<span class='add-on'>Pilih Rektorat</span>
						<select name='rektorat' onChange=\"MM_jumpMenu('parent',this,0)\" class=''>
						<option value='get-transaksiKeuangan-KeuanganUmum-$Trans.html'>- Pilih Staff Rektorat -</option>";
						$rektor="SELECT * FROM karyawan WHERE Bagian='YPN05' ORDER BY nama_lengkap DESC";
						$rktr=_query($rektor) or die();
						while ($r=_fetch_array($rktr)){
						if ($r['id']==$code){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='mhsw-transaksiKeuangan-KeuanganUmum-$Trans-$r[id].html' $cek> $r[nama_lengkap]</option>";
						}
						echo"</select>
				</div>
			</div>
			</div>
			</div>
			</div>";
		if($code){
		$honor="SELECT * FROM honorrektorat WHERE JabatanAkdm='$jbatan'";
		$hono=_query($honor) or die();
		$jhono=_num_rows($hono);
		if (!empty($jhono)){
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[GajiPokok]);
		$Tjbatan=digit($h[TnjanganJabatan]);
		$Ttransport=digit($h[TnjanganTransport]);
		$TotalGaji=$h[GajiPokok] + $h[TnjanganJabatan] + $h[TnjanganTransport];
		$TGaji=digit($TotalGaji);
		echo"<div class='control-group'>
				<label class='control-label'>Rincian</label>
				<div class='controls'>
				<div class='row-fluid'>
					<div class='span5'>
					<label>Gaji Pokok :</label>
					<input type=text class='span12' value=' Rp. $GajiPokok' readonly>
					</div>
					<div class='span7'>
					<div class='row-fluid'>
					<div class='span6'>
					<label>Tunjangan Jabatan :</label>
					<input type=text class='span12' value=' Rp. $Tjbatan' readonly>
					</div>
					<div class='span6'>
					<label>Tunjangan Transport :</label>
					<input type=text class='span12' value=' Rp. $Ttransport' readonly>
					</div>
					</div>
					</div>
				</div>	
				</div>
			</div>";
			}else{
		echo"<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Pengaturan Honor $jbtn Belum Tersedia untuk Jabatan Staff tersebut.</strong> Silahkan Settup Honor terlebih dahulu.
			</div>";	
			}
		}
		echo"<div class='control-group'>
				<label class='control-label'>Total Honor</label>
				<div class='controls'>
				<div class='row-fluid'>
					<div class='span5'>
					<input type=text class='span12' value='Rp. $TGaji' readonly/>
					<input type=hidden name='nominal' value='$TotalGaji' class='span5'/>
					</div>
					<div class='span7'>
					<input type=text name='potongan' class='span12' placeholder='Masukkan Potongan Jika Ada .....' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\"/>
					</div>
				</div>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal</label>
				<div class='controls'><div class='span5'>";
				combotgl(1,31,'TglBayar',$today);
				combonamabln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div></div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'>$JudulTransaksi Bulan $GajiBulan - Atas Nama : $NamaStafff</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form></div>";
//Bayar Gaji Karyawan
}elseif($Trans==15){
?>
<script type="text/javascript">
function tambah()
{
	var myForm = document.GajiStaff;
	var totalUm;
	var totalLm;
	//Jumlah Gaji
	var gaji = parseInt(myForm.gaji.value);
	var potongan = parseInt(myForm.potongan.value);
	var um = parseInt(myForm.um.value);
	var hari = parseInt(myForm.hari.value);
	var lembur = parseInt(myForm.lembur.value);
	var jam = parseInt(myForm.jam.value);

	if(myForm.potongan.value == "") potongan=0;
	if(myForm.um.value == "") um=0;
	if(myForm.hari.value == "") hari=0;
	if(myForm.lembur.value == "") lembur=0;
	if(myForm.jam.value == "") jam=0;

totalUm = parseInt(myForm.um.value)*hari;
totalLm = parseInt(myForm.lembur.value)*jam;

myForm.Total.value = gaji + totalUm + totalLm - potongan;
}
</script>
<?php
$staff="SELECT * FROM karyawan WHERE id='$code'";
$stf=_query($staff) or die();
$st=_fetch_array($stf);
echo"<div class='row-fluid'>
	<form id='GajiStaff' action='aksi-transaksiKeuangan-simpanTransaksi.html' method=POST name='GajiStaff' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$transaksiID'>
		<input type=hidden name='user' value='$code'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='staff'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<h5>$JudulTransaksi</h5>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>No Transaksi</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span5'>
				<input type=text value='$Notrans' class='span12' readonly>
			</div>
			<div class='span7'>
				<div class='input-prepend input-append'>
						<span class='add-on'>Pilih Karyawan</span>
						<select name='rektorat' onChange=\"MM_jumpMenu('parent',this,0)\" class=''>
						<option value='get-transaksiKeuangan-KeuanganUmum-$Trans.html'>- Pilih STAFF -</option>";
						$staff="SELECT * FROM karyawan WHERE Bagian NOT IN('YPN05','dosen') ORDER BY nama_lengkap DESC";
						$sq=_query($staff) or die();
						while ($s=_fetch_array($sq)){
						if ($s['id']==$code){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='mhsw-transaksiKeuangan-KeuanganUmum-$Trans-$s[id].html' $cek> $s[nama_lengkap]</option>";
						}
						echo"</select>
				</div>
			</div>
			</div>
			</div>
			</div>";
		if($code){
		$honor="SELECT * FROM honorstaff WHERE StaffID='$code'";
		$hono=_query($honor) or die();
		$jhono=_num_rows($hono);
		if (!empty($jhono)){
		$h=_fetch_array($hono);
		$GajiPokok=digit($h[GajiPokok]);
		$UangMakan=digit($h[UangMakan]);
		$lembur=$h[UangLembur];
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
					<input type=text class='span12' name='hari' id='hari' onkeyup='tambah()'>
					</div>
					<div class='span3'>
					<label>Uang Lembur :</label>
					<input type=text class='span12' value=' Rp. $lembur / Jam' readonly>
					<input type=hidden name='lembur' id='lembur' value='$lembur'>
					</div>
					<div class='span3'>
					<label>Jumlah Jam :</label>
					<input type=text class='span12' name='jam' id='jam' onkeyup='tambah()'>
					</div>
					</div>
					</div>
				</div>	
				</div>
			</div>";
			}else{
		echo"<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Pengaturan Honor $jbtn Belum Tersedia untuk Jabatan Staff tersebut.</strong> Silahkan Settup Honor terlebih dahulu.
			</div>";	
			}
		}
		echo"<div class='control-group'>
				<label class='control-label'>Total Gaji</label>
				<div class='controls'>
				<div class='row-fluid'>
					<div class='span5'>
					<input type=text class='span12' name='Total' id='Total'/>
					</div>
					<div class='span7'>
					<input type=text name='potongan'  id='potongan'  class='span12' placeholder='Masukkan Potongan Jika Ada .....' onkeyup='tambah()'>
					</div>
				</div>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal</label>
				<div class='controls'><div class='span5'>";
				combotgl(1,31,'TglBayar',$today);
				combonamabln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div></div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'>$JudulTransaksi Bulan $GajiBulan - Atas Nama : $st[nama_lengkap]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form></div>";
//Bayar Honor Dosen
}elseif($Trans==16){
$dosen="SELECT * FROM dosen WHERE dosen_ID='$code'";
$stf=_query($dosen) or die();
$st=_fetch_array($stf);
echo"<div class='row-fluid'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanTransaksi.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$transaksiID'>
		<input type=hidden name='user' value='$code'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='dosen'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<h5>$JudulTransaksi Bulan : $GajiBulan $TahunIni</h5>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>No Transaksi</label>
			<div class='controls'>
			<div class='row-fluid'>
			<div class='span5'>
				<input type=text value='$Notrans' class='span12' disabled>
			</div>
			<div class='span7'>
				<div class='input-prepend input-append'>
						<span class='add-on'>Pilih Dosen</span>
						<select name='rektorat' onChange=\"MM_jumpMenu('parent',this,0)\" class=''>
						<option value='get-transaksiKeuangan-KeuanganUmum-$Trans.html'>- Pilih Dosen -</option>";
$pdosen="SELECT * FROM dosen ORDER BY nama_lengkap DESC";
$sq=_query($pdosen) or die();
while ($s=_fetch_array($sq)){
	if ($s['dosen_ID']==$code){ $cek="selected"; }  else{ $cek=""; }
	echo "<option value='mhsw-transaksiKeuangan-KeuanganUmum-$Trans-$s[dosen_ID].html' $cek> $s[nama_lengkap] $s[Gelar]</option>";
						}
echo"</select>
				</div>
			</div>
			</div>
			</div>
			</div>";
if($code){
	$honor="SELECT * FROM honordosen WHERE JabatanAkdm='$st[Jabatan_ID]'";
	$hono=_query($honor) or die();
	$jhono=_num_rows($hono);
	if (!empty($jhono)){
	
		$h=_fetch_array($hono);
		$HonorSks=digit($h[HonorSks]);
		$TranspotTTMK=digit($h[TransportTtpMk]);
		$Transport=$h[UangTransport];
		$HTransport=digit($Transport);
		echo"<div class='control-group'>
				<label class='control-label'></label>
				<div class='controls'>
				<label>Rincian Presensi Dosen : Bulan $GajiBulan $TahunIni</label>
				<table class='table table-bordered'><thead>
				<tr><td>Tanggal</td><td>Mata Kuliah</td><td>Honor/Sks</td><td>Honor T Muka</td><td>Jumlah</td></tr></thead>";
					$presensi="SELECT * FROM presensi WHERE DosenID='$code' AND Tanggal LIKE '$TahunIni-$BulanIni%'";
					$press=_query($presensi) or die();
					while($data=_fetch_array($press))
					{
					$tgle=tgl_indo($data[Tanggal]);
					$mtk=CekJadwal($data[JadwalID]);
					$kodeMtk=MatakuliahID($mtk);
					$MKK=KelompokMtk($kodeMtk);
					$sks=SksMtk($mtk);
					$totalsks=$sks * $h[HonorSks];
					$tot=$totalsks + $h[TransportTtpMk];
					$toot=digit($tot);
					$tootal1 += $tot;
					$totalHon=$tootal1+$Transport;
					$totalhonor=digit($totalHon);
					echo"<tr><td>$tgle</td>
						<td>$MKK $mtk</td>
						<td>$sks X $HonorSks</td>
						<td>Rp.<span class='pull-right'>$TranspotTTMK</span></td>
						<td>Rp.<span class='pull-right'>$toot</span></td></tr>";
					}
		echo"<tr><td colspan='4'>Tunjangan Transport</td><td>Rp.<span class='pull-right'>$HTransport</span></td></tr>
			<tr><td colspan='4'>Total Honor</td><td>Rp.<span class='pull-right'><b>$totalhonor</b></span></td></tr>
			</table>	
				</div>
			</div>";
			}else{
		echo"<div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Pengaturan Honor $jbtn Belum Tersedia untuk Jabatan Dosen tersebut.</strong> Silahkan Settup Honor Dosen terlebih dahulu.
			</div>";	
			}
		}
		echo"<div class='control-group'>
				<label class='control-label'>Total Honor</label>
				<div class='controls'>
				<div class='row-fluid'>
					<div class='span5'>
					<input type=text class='span12' placeholder='Rp. $totalhonor'/>
					<input type=hidden name='nominal' value='$totalHon' class='span5'/>
					</div>
					<div class='span7'>
					<input type=text name='potongan' class='span12' placeholder='Masukkan Potongan Jika Ada .....' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\"/>
					</div>
				</div>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal Bayar</label>
				<div class='controls'><div class='span5'>";
				combotgl(1,31,'TglBayar',$today);
				combonamabln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div></div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'>$JudulTransaksi Bulan $GajiBulan - Dosen : $st[nama_lengkap] ,$st[Gelar]</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form></div>";
}else{
echo"<div class='row-fluid'>
	<form id='example_form' action='aksi-transaksiKeuangan-simpanTransaksi.html' method=POST name='BiayaMhsw' class='form-horizontal'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$d[id]'>
		<input type=hidden name='user' value='$_SESSION[Nama]'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='umum'>
		<fieldset>
			<div class='control-group'>
				<label class='control-label' for='name'>Transaksi : </label>
			<div class='controls'>
				<h5>$JudulTransaksi</h5>
			</div>
			</div>
			<div class='control-group'>
				<label class='control-label' for='name'>No Transaksi</label>
			<div class='controls'>
				<input type=text value='$Notrans' class='span5' disabled>
			</div>
			</div>";
		if($p){
		echo"<div class='control-group'>
			<label class='control-label'>Hutang</label>
			<div class='controls'>
			<select name='piutang' class='span5'>
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
					<input type=text name='nominal' value='$_POST[nominal]' class='span5' onkeyup=\"formatNumber(this);\" onchange=\"formatNumber(this);\"/>
				</div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Tanggal</label>
				<div class='controls'><div class='span5'>";
				combotgl(1,31,'TglBayar',$today);
				combonamabln(1,12,'BlnBayar',$BulanIni);
				combothn($TahunIni-10,$TahunIni+10,'ThnBayar',$TahunIni);
				echo"</div></div>
			</div>
			<div class='control-group'>
				<label class='control-label'>Keterangan</label>
				<div class='controls'>
					<textarea name='keterangan' class='span12'>$JudulTransaksi</textarea>
				</div>
			</div>
			<div class='form-actions'>
				<button type='submit' name='Simpan' class='btn btn-success'>Proses</button>
				<a class='btn btn-inverse' href='go-transaksiKeuangan.html'>Batal</a>
			</div>
		</fieldset>
	</form></div>";
}
	}
	else
	{
	
echo"<div class='alert alert-info'>
	<button class='close' data-dismiss='alert'>&times;</button>
	<strong>Pilih Transaksi</strong> Untuk Melakukan Transaksi Baru, Silahkan Pilih Menu transaksi di atas.
</div>";
	}
}
function simpanTransaksi(){
global $tgl_sekarang;	
	$JenisTrack		= $_POST['jenis'];
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$Keterangan	   	= sqling($_POST['keterangan']);
	$piutang = (empty($_POST['piutang']))? "" : $_POST['piutang'];
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
//Jika Transaksi Umum
if ($JenisTrack=='umum'){
$linkCetak	="TransaksiUmum";
$JmlahBayar		= $_POST['nominal'];
$nominal	= str_replace(',','',$JmlahBayar);
}
//Pembayaran Honor Dosen
elseif($JenisTrack=='dosen'){
$linkCetak="cetakHoNorDosn";
	if(empty($_POST['potongan']))
	{
	$nominal 		= $_POST['nominal'];
	}
	else
	{
	$ptongan		= str_replace(',','',$_POST['potongan']);
	$nominal 		= $_POST['nominal'] - $ptongan;
	}

}
//Pembayaran Honor Rektor
elseif($JenisTrack=='rektor'){
$linkCetak		="cetakHoRektor";
	if(empty($_POST['potongan']))
	{
	$nominal 		= $_POST['nominal'];
	}
	else
	{
	$ptongan		= str_replace(',','',$_POST['potongan']);
	$nominal 		= $_POST['nominal'] - $ptongan;
	}
}
//Pembayaran Honor Staff
elseif($JenisTrack=='staff'){

$linkCetak="cetakGajiStaff";
$gaji		=$_POST['gaji'];
$um			=$_POST['um'];
$hari		=$_POST['hari'];
$lembur		=$_POST['lembur'];
$jam		=$_POST['jam'];
$uangMakan	= $um *$hari;
$uanglembur	=$lembur *$jam;
$nominal	= $_POST['Total'];

}
//Mulai Simpan Transaksi	
if (empty($nominal)) {
PesanEror("Proses $NamaTransaksi", "$NamaTransaksi Gagal.Anda Belum Memasukkan Jumlah. Silahkan Ulangi Lagi");
	}else{
	$cekTransaksi=_query("SELECT * FROM jenistransaksi WHERE id='$transaksi'");
	if (_num_rows($cekTransaksi)>0)
		{
			$row			=_fetch_array($cekTransaksi);
			$NamaTransaksi	=$row['nama'];
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
	if($transaksi=='15'){
	$det = "INSERT INTO transaksihnrstaff (Notrans,userid,gajipokok,uangmakan,uanglembur,hari,jam,potongan,Total,TglBayar) VALUES 
		('$TrackID', '$User', '$gaji', '$um', '$lembur', '$hari', '$jam','$_POST[potongan]','$nominal', '$TglBayar')";
	$detail=_query($det);
	}
PesanOk2("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan","aksi-transaksiKeuangan-KeuanganUmum.html","cetak-$linkCetak-$TrackID.html");
	}
}
function simpanApprovel(){
global $tgl_sekarang;
$BiayaDPP=$_POST['4'];
$BiayaPendaftaran=$_POST['5'];
$Spp=$_POST['6'];
$UTS=$_POST['7'];
$UAS=$_POST['8'];
$UangPengembangan=$_POST['9'];
$BimbinganTesis=$_POST['10'];
$Wisuda=$_POST['11'];
	$book 			= $_POST['buku'];
	$rekan 			= $_POST['rekanan'];
	$prog 			= $_POST['prog'];
	$noreg 			= $_POST['NoReg'];
	$TrackID 		= $_POST['nomor'];
	$Nim			= $_POST['NIM'];
	$pass			=md5(123456);
	$JuM			= $_POST['Total'];
	$JuMlah 		= str_replace(',','',$JuM);
	$Potg	   		= $_POST['Potongan'];
	$Pot 			= str_replace(',','',$Potg);
	$TotalBiaya		=$JuMlah-$Pot;
if (empty($Nim)) {
PesanEror("Proses Approval Mahasiswa Baru", "Proses Approval Mahasiswa Baru Gagal. Anda Belum Memberikan NIM. Silahkan Ulangi Lagi");
}else{
$c=_num_rows(_query("SELECT * FROM mahasiswa WHERE NIM='$_POST[NIM]'"));
	if ($c > 0){
PesanEror("Proses Approval Mahasiswa Baru", "Proses Approval Mahasiswa Baru Gagal. Data NIM Sudah Ada Dalam Database");	
}else{
$tahun=substr($_POST[NIM],0,4);
$biaya=_fetch_array(_query("SELECT SUM(Jumlah) as total FROM biayamhsw WHERE TahunID='$tahun'"));
$tot=$biaya[total];
if ($prog ==1 AND  $rekan==0){
$s = "UPDATE keuanganmhsw SET 
KeuanganMhswID='$_POST[NIM]',
Total='$tot', 
Potongan='$Pot', 
TotalBiaya ='$tot', 
Aktif='Y', 
ApproveDate='$tgl_sekarang', 
keterangan='Approved' 
WHERE RegID='$noreg'";
_query($s);

$transd = "INSERT INTO transaksi (TransID, 
Buku,
 Transaksi, 
 Debet, 
 Kredit,
 AccID, 
 TglBayar, 
 SubmitBy, 
 TglSubmit, 
 Uraian, 
 TanggalCatat,
 IDpiutang) VALUES 
	('$TrackID', 
	'$book', 
	'19',
	'$tot',
	'0', 
	'$noreg', 
	'$tgl_sekarang', 
	'$_SESSION[Nama]', 
	'$tgl_sekarang', 
	'Penerimaan Mahasiswa Baru NO REGISTRASI :$noreg', 
	'$_POST[tanggal_catat]', '')";
	$insertd=_query($transd);
}else{
$s = "UPDATE keuanganmhsw SET KeuanganMhswID='$_POST[NIM]', Total='$JuMlah', Potongan='$Pot', TotalBiaya ='$TotalBiaya', Aktif='Y', ApproveDate='$tgl_sekarang',keterangan='Approved' WHERE RegID='$noreg'";
_query($s);

$transd = "INSERT INTO transaksi (TransID, 
Buku,
 Transaksi, 
 Debet, 
 Kredit,
 AccID, 
 TglBayar, 
 SubmitBy, 
 TglSubmit, 
 Uraian, 
 TanggalCatat,
 IDpiutang) VALUES 
	('$TrackID', 
	'$book', 
	'19',
	'$TotalBiaya',
	'0', 
	'$noreg', 
	'$tgl_sekarang', 
	'$_SESSION[Nama]', 
	'$tgl_sekarang', 
	'Penerimaan Mahasiswa Baru NO REGISTRASI :$noreg', 
	'$_POST[tanggal_catat]', '')";
	$insertd=_query($transd);
}
//Update Mahasiswa
$s1 = "UPDATE mahasiswa SET NIM='$Nim',username='$Nim', password='$pass', aktif='Y' WHERE NoReg='$noreg'";
_query($s1);

//Update User
$s2 = "UPDATE useryapan SET username='$Nim', password='$pass', aktif='Y' WHERE SessionID='$noreg'";
_query($s2);
PesanOk("Proses Approval Mahasiswa Baru","Approval Mahasiswa Baru Berhasil Di Proses","go-transaksiKeuangan.html");	
}
}
}
function simpanBayarPertama() {
global $tgl_sekarang;
	$prog 			= $_POST['prog'];
	$rekan 			= $_POST['rekan'];
	$noreg 			= $_POST['NoReg'];
	$transaksi		= $_POST['transaki'];
	$payments		= $_POST['payment'];
	$piutang		= $_POST['piutang'];
	$TrackID		= $_POST['TrackID'];
	$JBayar			= $_POST['JmlahBayar'];
	$nominal		= str_replace(',','',$JBayar);
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$TglKet=tgl_indo($TglBayar);
$jenis= $_POST['jnis'];
if (empty($nominal)) {
PesanEror("Proses Pembayaran Pertama Mahasiswa", "Pembayaran Pertama Mahasiswa Gagal.Anda Belum Memasukkan Jumlah. Silahkan Ulangi Lagi");
	}else{
	$pay = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$payments', '$transaksi', '$nominal', '0', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
	$insertpay=_query($pay);

$piut = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$piutang', '$transaksi', '0', '$nominal', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
	$insertpiut=_query($piut);

	$s = "UPDATE keuanganmhsw SET Keterangan='$_POST[keterangan]' WHERE RegID='$noreg'";
_query($s);
PesanOk2("Proses Pembayaran Pertama Mahasiswa","Pembayaran Pertama Mahasiswa Berhasil Di Simpan","go-transaksiKeuangan.html","cetak-cetakTransaksi-$TrackID.html");
	}
}

function simpanCicilan() {
global $tgl_sekarang;
	$noreg 			= $_POST['NoReg'];
	$TrackID		= $_POST['TrackID'];
	$transaksi		= $_POST['transaki'];
	$payments		= $_POST['payment'];
	$piutang		= $_POST['piutang'];
	$JmlahBayar		= $_POST['JmlahBayar'];
	$nominal 		= str_replace(',','',$JmlahBayar);
	$Keterangan	   	= sqling($_POST['keterangan']);
	$TglBayar=sprintf("%02d%02d%02d",$_POST[ThnBayar],$_POST[BlnBayar],$_POST[TglBayar]);
	$TglKet=tgl_indo($TglBayar);
$jenis= $_POST['jnis'];
if (empty($nominal)) {
PesanEror("Proses Pembayaran Mahasiswa", "Pembayaran Mahasiswa Gagal.Anda Belum Memasukkan Jumlah. Silahkan Ulangi Lagi");
	}else{

	$pay = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$payments', '$transaksi', '$nominal', '0', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
	$insertpay=_query($pay);

$piut = "INSERT INTO transaksi (TransID, Buku, Transaksi, Debet, Kredit, AccID, TglBayar, SubmitBy, TglSubmit, Uraian, TanggalCatat, IDpiutang, SubID) VALUES 
	('$TrackID', '$piutang', '$transaksi', '0', '$nominal', '$noreg', '$TglBayar', '$_SESSION[Nama]', '$tgl_sekarang', '$_POST[keterangan]', '$_POST[tanggal_catat]', '$piutang','$jenis')";
	$insertpiut=_query($piut);

PesanOk2("Proses Pembayaran Pertama Mahasiswa","Pembayaran Pertama Mahasiswa Berhasil Di Simpan","aksi-transaksiKeuangan-PembayaranMhsw.html","cetak-cetakTransaksi-$TrackID.html");
	}
}
switch($_GET[PHPIdSession]){

  default:
    defaulttransaksiKeuangan();
  break;  
  
  case "Aprove":
    Aprove();
  break;

  case "simpanApprovel":
    simpanApprovel();
   break;

  case "BayarPertama":
    BayarPertama();
  break;
  
  case "PembayaranMhsw":
    PembayaranMhsw();
  break;
  
  case "KeuanganUmum":
    KeuanganUmum();
  break;

case "delTrans":
    delTrans();
  break;

case "jurnalTrans":
    jurnalTrans();
  break;
  
  case "BayarCicilan":
    BayarCicilan();
  break;

  case "DetailTransaksiBayar":
    DetailTransaksiBayar();
  break;
  
  case "DetailKeuMhsw":
    DetailKeuMhsw();
  break;
  
	case "simpanBayarPertama":
    simpanBayarPertama();
   break;
   
   case "simpanCicilan":
    simpanCicilan();
   break;
   
   case "simpanTransaksi":
    simpanTransaksi();
   break;

}
?>
