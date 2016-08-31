<script type="text/javascript">
<!--
function startCalc()
{interval=setInterval("calc()",1)}
function calc(){
total=document.dosen.totals.value;
pot=document.dosen.potongan.value;
//formating
npot = pot.replace(/,/g, '');
ntotal = total.replace(/,/g, '');
//hasil
document.dosen.nominal.value=addCommas((ntotal*1)-(npot*1))
}
function stopCalc(){clearInterval(interval)}
//-->
</script>
<?php 
defined('_FINDEX_') or die('Access Denied');
if($buat OR $edit){
if(isset($_POST['simpanHonorDosen']))
{
	$JenisTrack		= $_POST['jenis'];
	$User 			= $_POST['user'];
	$TrackID		= $_POST['nomor'];
	$transaksi		= $_POST['transaksi'];
	$Keterangan	   	= sqling($_POST['keterangan']);
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
		$InsertDetail=_query("INSERT INTO transaksihnrdosen (Notrans,userid,TahunID,semester,TotalSks,TatapMuka,honorSks,honorTmuka,periode1,periode2,TotalHonor,potongan,Total,TglBayar,SubmitBy) VALUES ('$TrackID', '$User', '$_POST[tahun]','$_POST[semester]','$_POST[SksTotal]','$_POST[TatapMuka]','$_POST[honorSks]', '$_POST[honorTmuka]', '$_POST[periode1]','$_POST[periode2]', '$_POST[TotalHonor]', '$potongan','$nominal', '$TglBayar','$_SESSION[Nama]')");
		}
//tampilkan pesan
alerPrint("Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan. ID TRANSAKSI : <b>$TrackID</b>","aksi-transaksi-umum.html","get-prind-transaksiDosen-$TrackID.html");
CatatLog($_SESSION[Nama],"Transaksi $NamaTransaksi","$NamaTransaksi Berhasil Di Simpan");
}else{
global $hitu;
$dosen = $_POST['dosen'];
$jabatanDsn=GetName("dosen","dosen_ID",$dosen,"Jabatan_ID");

$tAktif		=TahunAktif();
$tahun		= (empty($_POST['tahun']))? $tAktif : $_POST['tahun'];
$semester	= (empty($_POST['semester']))? '' : $_POST['semester'];

$Pdari	= (empty($_POST['Pdari']))? $today : $_POST['Pdari'];
$Bdari	= (empty($_POST['Bdari']))? $BulanIni-1 : $_POST['Bdari'];
$Tdari	= (empty($_POST['Tdari']))? $TahunIni : $_POST['Tdari'];
///
$Psampai	= (empty($_POST['Psampai']))? $today : $_POST['Psampai'];
$Bsampai	= (empty($_POST['Bsampai']))? $BulanIni : $_POST['Bsampai'];
$Tsampai	= (empty($_POST['Tsampai']))? $TahunIni : $_POST['Tsampai'];

echo"<div class='widget-content'>
<form method='post' class='form-horizontal' name='dosen'>
		<input type=hidden name='nomor' value='$Notrans'>
		<input type=hidden name='transaksi' value='$transaksiID'>
		<input type=hidden name='user' value='$dosen'>
		<input type=hidden name='tanggal_catat' value='$waktu'>
		<input type=hidden name='jenis' value='dosen'>
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
			<label class='control-label'>Pilih Dosen *</label>
				<div class='controls'>
					<select name='dosen' onChange='this.form.submit()' class='span12' required>
						<option value=''>- Pilih Dosen -</option>";
						$pdosen="SELECT * FROM dosen ORDER BY nama_lengkap ASC";
						$sq=_query($pdosen) or die();
						while ($s=_fetch_array($sq)){
						$namaDosen=strtoupper($s['nama_lengkap']);
							if ($s['dosen_ID']==$dosen){ $cek="selected"; }  else{ $cek=""; }
							echo "<option value='$s[dosen_ID]' $cek> $namaDosen $s[Gelar]</option>";
												}
						echo"</select>
				</div>
		</div>
	</div>
</div>";
if($dosen){
	$honor="SELECT * FROM honordosen WHERE JabatanAkdm='$jabatanDsn'";
	$hono=_query($honor) or die();
	$jhono=_num_rows($hono);
	if (!empty($jhono)){
		$h=_fetch_array($hono);
		$HonorSks=digit($h[HonorSks]);
		$TranspotTTMK=digit($h[TransportTtpMk]);

echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Tahun Akademik *</label>
				<div class='controls'>
					<select name='tahun' onChange='this.form.submit()' class='span12'>
						<option value=''>- Tahun Akademik -</option>";
						$t=_query("SELECT * FROM tahun ORDER BY Nama DESC");
						while($r=_fetch_array($t)){
						$cek=($tahun == $r['Tahun_ID'])? 'selected': '';
						echo "<option value=$r[Tahun_ID] $cek> $r[Nama]</option>";
						}
					echo "</select> </div>
		</div>
		<div class='span6'>
			<label class='control-label'>Semester</label>
				<div class='controls'>
					<select name='semester' onChange='this.form.submit()' class='span12'>
					<option value=''>- SEMESTER -</option>";
					$sm=array('1','2','3','4','5','6','7','8');
					foreach($sm as $smst){
						if ($smst==$semester){$cek="selected";}else{ $cek="";}
						echo "<option value='$smst' $cek> Semester $smst</option>";
					}
			echo"</select></div>
		</div>
	</div>
</div>
<div class='control-group'>
	<div class='row-fluid'>
		<div class='span6'>
			<label class='control-label'>Periode *</label>
				<div class='controls'>";
				Getcombotgl2(1,31,'Pdari',$Pdari);
				Getcombonamabln2(1,12,'Bdari',$Bdari);
				Getcombothn2($TahunIni-10,$TahunIni+10,'Tdari',$Tdari);
				echo"</div>
		</div>
		<div class='span6'>
			<label class='control-label'>Sampai Dengan</label>
				<div class='controls'>";
				Getcombotgl2(1,31,'Psampai',$Psampai);
				Getcombonamabln2(1,12,'Bsampai',$Bsampai);
				Getcombothn2($TahunIni-10,$TahunIni+10,'Tsampai',$Tsampai);
				echo"</div>
		</div>
	</div>
</div>

<input type=hidden name='periode1' value='$Tdari-$Bdari-$Pdari'/>
<input type=hidden name='periode2' value='$Tsampai-$Bsampai-$Psampai'/>
<input type=hidden name='honorSks' value='$h[HonorSks]'/>
<input type=hidden name='honorTmuka' value='$h[TransportTtpMk]'/>
<div class='control-group'>
				<label class='control-label'>Presensi</label>
				<div class='controls'>
				<label>Presensi Dosen Periode : <b>$Pdari-$Bdari-$Tdari s/d $Psampai-$Bsampai-$Tsampai </b></label>
				<table class='table table-bordered'><thead>
				<tr><td>Tanggal</td><td>Mata Kuliah</td><td>Honor/Sks</td><td>Honor T Muka</td><td>Jumlah</td></tr></thead>";
					$presensi="SELECT * FROM presensi 
						INNER JOIN matakuliah ON presensi.mtkID=matakuliah.Matakuliah_ID
						WHERE presensi.DosenID='$dosen' 
						AND presensi.TahunID='$tahun' 
						AND presensi.semester='$semester' 
						AND presensi.Pertemuan='1' 
						AND presensi.Tanggal BETWEEN '$Tdari-$Bdari-$Pdari' AND '$Tsampai-$Bsampai-$Psampai' 
						ORDER BY presensi.Tanggal DESC";
					$press=_query($presensi) or die();
					while($data=_fetch_array($press))
					{
					$tgle=tgl_indo($data[Tanggal]);
					$MKK=KelompokMtk($data['KelompokMtk_ID']);
					$totalsks=$data[SKS] * $h[HonorSks];
					$tot=$totalsks + $h[TransportTtpMk];
					$toot=digit($tot);
					echo"<tr><td>$tgle</td>
						<td>$MKK $data[Kode_mtk] | $data[Nama_matakuliah]</td>
						<td>$data[SKS] X $HonorSks</td>
						<td>Rp.<span class='pull-right'>$TranspotTTMK</span></td>
						<td>Rp.<span class='pull-right'>$toot</span></td></tr>";
					$SksTotal += $data['SKS'];
					$TatapMuka += $data['Pertemuan'];
					$tootal1 += $tot;
					$totalhonor=digit($tootal1);
					$totalhonors=comaa($tootal1);
					}
		echo"<tr>
				<td colspan='4'><input type=hidden name='SksTotal' value='$SksTotal'/>
								<input type=hidden name='TatapMuka' value='$TatapMuka'/>
				Total Honor</td>
				<td>Rp.<span class='pull-right'><b>$totalhonor</b></span></td>
			</tr>
			</table>
				</div>
			</div>";
	}else{
alert("error","Pengaturan Honor Dosen Belum Tersedia. Silahkan Settup Honor terlebih dahulu");		
	}
}
echo"<div class='control-group'>
	<div class='row-fluid'>
		<div class='span4'>
			<label class='control-label'>Total Honor</label>
				<div class='controls'>
					<input type='text' class='span12' name='nominal' value='$totalhonors' readonly/>
					<input type=hidden name='totals' value='$totalhonors' class=''/>
					<input type=hidden name='TotalHonor' value='$tootal1' class=''/>
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
					<textarea name='keterangan' class='span12'>$JudulTransaksi </textarea>
				</div>
		</div>
	</div>
</div>
<div class='widget-toolbar' style='text-align: center'>
	<div class='btn-group'>
		<input class='btn btn-success btn-large' type=submit value='SIMPAN' name='simpanHonorDosen'>
		<input type=button value='Batal' class='btn btn-danger btn-large' onclick=\"window.location.href='aksi-transaksi-umum.html';\">
	</div> 
</div>
</form>
</fieldset></div>";
}
 }else{
ErrorAkses();
} ?>