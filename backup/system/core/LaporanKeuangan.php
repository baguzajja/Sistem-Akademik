<script language="javascript" type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php  
function Deflaporan(){
global $today,$BulanIni,$TahunIni;
$id		= (empty($_REQUEST['id']))? '0' : $_REQUEST['id'];
$hari1	= (empty($_POST['hari1']))? $today : $_POST['hari1'];
$bulan1	= (empty($_POST['bulan1']))? $BulanIni-1 : $_POST['bulan1'];
$tahun1	= (empty($_POST['tahun1']))? $TahunIni : $_POST['tahun1'];

$hari2	= (empty($_POST['hari2']))? $today : $_POST['hari2'];
$bulan2	= (empty($_POST['bulan2']))? $BulanIni : $_POST['bulan2'];
$tahun2	= (empty($_POST['tahun2']))? $TahunIni : $_POST['tahun2'];

$angkatan	= (empty($_POST['Angkatan']))? '0' : $_POST['Angkatan'];

$dari	=sprintf("%02d%02d%02d",$tahun1,$bulan1,$hari1);
$sampai	=sprintf("%02d%02d%02d",$tahun2,$bulan2,$hari2);
$Bulan1=getBulan2($bulan1);
$Bulan2=getBulan2($bulan2);
buka("Laporan :: Keuangan");
echo "<div class='panel-content panel-tables'>
	<form name=form1 method=post  action='lap-LaporanKeuangan-$id.html'>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>
				<div class='input-prepend input-append'>
					<label>Laporan</label>
					<select name='buku' onChange=\"MM_jumpMenu('parent',this,0)\" class='span4'>
					<option value='lap-LaporanKeuangan-0.html'>- Pilih Jenis Laporan -</option>";
						$sqlp="SELECT * FROM lapbau ORDER BY id";
						$qryp=_query($sqlp) or die();
						while ($d=_fetch_array($qryp)){
						if ($d['id']==$id){ $cek="selected"; }  else{ $cek=""; }
						echo "<option value='lap-LaporanKeuangan-$d[id].html' $cek> $d[Nama]</option>";
						}
				echo"</select>
				</div>
				</th>
				<th>
				<div class='row-fluid'>";
if ($id==4 OR $id==5){
echo"<div class='span12'><div class='input-prepend input-append'>
<label>Tahun Akademik :</label>
<select name='Angkatan' class='span12' onChange='this.form.submit()'>
			<option value=0 selected>- Pilih Tahun Ajaran -</option>";
			$t=_query("SELECT * FROM tahun WHERE Identitas_ID='$_SESSION[Identitas]' ORDER BY Tahun_ID DESC");
			while($tt=_fetch_array($t)){
			if ($tt['Tahun_ID']==$angkatan){ $cek="selected"; }  else{ $cek=""; }
			echo "<option value='$tt[Tahun_ID]' $cek> $tt[Nama]</option>";
			}
			echo "</select>
</div></div>";
}else{
		echo"<div class='span6'><div class='input-prepend input-append'>
<label>Dari :</label>";
				Getcombotgl2(1,31,'hari1',$hari1);
				Getcombonamabln2(01,12,'bulan1',$bulan1);
				Getcombothn2($TahunIni-10,$TahunIni+5,'tahun1',$tahun1);
				echo"</div></div>
				<div class='span6'><div class='input-prepend input-append'>
<label>Sampai :</label>";
				Getcombotgl2(1,31,'hari2',$hari2);
				Getcombonamabln2(01,12,'bulan2',$bulan2);
				Getcombothn2($TahunIni-10,$TahunIni+5,'tahun2',$tahun2);
				echo"</div></div>";
}
echo"</div>
				</th>
			</tr>
			<tr><th></th><th></th></tr>
		</thead>
	</table></form>";
if ($id=='0'){
$laporan="Laporan Keuangan";
$export="";
$jdl="";
}elseif ($id==4 OR $id==5) {
$laporan=NamaLaporan($id);
$export="<a class='btn' href='export-lapBau-$id-$dari-$angkatan.html'>Export Ke Excel</a>";
$jdl="( Tahun Akademik : $angkatan )";
}else{
$laporan=NamaLaporan($id);
$export="<a class='btn' href='export-lapBau-$id-$dari-$sampai.html'>Export Ke Excel</a>";
$jdl="( Periode : $hari1 $Bulan1 $tahun1 - $hari2 $Bulan2 $tahun2 )";
}
echo"<legend>$laporan&nbsp;&nbsp;<small>$jdl</small>
			<div class='pull-right'>
				<div class=btn-group>
				$export	
				</div>
			</div>
	</legend>
	</div><div class='tab-content'>";
if($id==1){
echo"<table class='table table-bordered'>
<thead><tr>
	<th><center>NO</center></th>
	<th>NAMA DOSEN</th>
	<th width=''>JABATAN</th>
	<th width=''><center>GAJI POKOK</center></th>
	<th width=''><center>T. JABATAN</center></th>
	<th width=''><center>T. TRANSPORT</center></th>
	<th width=''><center>JUMLAH</center></th>
</tr></thead>";
	$main=_query("SELECT * FROM transaksi WHERE Transaksi ='14' AND TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY TglBayar DESC");
	$no=0;
	while($r=mysql_fetch_array($main)){
	$jbatan=JabatanIdStaff($r[AccID]);
	$NamaJabatan=JabatanStaff($jbatan);
	$NamaStafff=NamaStaff($r[AccID]);
	$honor="SELECT * FROM honorrektorat WHERE JabatanAkdm='$jbatan'";
	$hono=_query($honor) or die();
	$h= _fetch_array($hono);
	$gajiPokok=digit($h[GajiPokok ]);
	$Ttransport=digit($h[TnjanganTransport ]);
	$Tjabatan=digit($h[TnjanganJabatan ]);
	$tot=$r[Kredit];
	$jumlahTot 	+=$tot;
	$total=digit($tot);
	$jtotal=digit($jumlahTot );
	$no++;
	echo "<tr>                            
		<td><center>$no</center></td>
		<td>$NamaStafff</td>
		<td>$NamaJabatan</td>
		<td>Rp. <span class='pull-right'>$gajiPokok</span></td>
		<td>Rp. <span class='pull-right'>$Tjabatan</span></td>
		<td>Rp. <span class='pull-right'>$Ttransport</span></td>
		<td>Rp. <span class='pull-right'>$total</span></td>
		</tr>";
}			
echo"<tfoot><tr><td colspan='6'><center><b>JUMLAH TOTAL</b></center></td>
	<td><b>Rp. <span class='pull-right'>$jtotal</span></b></td></tr></tfoot></table>";		  
} elseif ($id==2){
echo"<table class='table table-bordered'>
<thead><tr>
	<th><center>NO</center></th>
	<th>NAMA DOSEN</th>
	<th><center>JABATAN AKDM</center></th>
	<th>MATA KULIAH</th>
	<th><center>JUMLAH SKS</center></th>
	<th><center>HONOR / SKS</center></th>
	<th><center>TRANSPORT T.MUKA</center></th>
	<th><center>JUMLAH T.MUKA</center></th>
	<th><center>HONOR</center></th>
	<th><center>UANG TRANSPORT</center></th>
	<th><center>JUMLAH</center></th>
</tr></thead>";
	$main=_query("SELECT * FROM transaksi WHERE Transaksi ='16' AND TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY TglBayar DESC");
	$no=0;
	while($r=_fetch_array($main)){
	$jbatan=JabatanIdDosen($r[AccID]);
	$NamaJabatan=JabatanStaff($jbatan);
	$NamaDosen=NamaDosen($r[AccID]);
	$jumlah =$r[Kredit];
	$totalHonor=digit($jumlah);
//presensi
$hadir="SELECT SUM(Pertemuan) as TotalHadir, JadwalID as jadwalID FROM presensi WHERE 
	DosenID='$r[AccID]' AND Tanggal BETWEEN '$dari' AND '$sampai' GROUP BY JadwalID";
$hdr=_query($hadir) or die();
$hr=_fetch_array($hdr);
$jumlahPresensi=$hr[TotalHadir];
$IdJdwal=$hr[jadwalID];

$mtk=CekJadwal($IdJdwal);
$kodeMtk=MatakuliahID($mtk);
$MKK=KelompokMtk($kodeMtk);
$sks=SksMtk($mtk);
//setting Honor
	$honor="SELECT * FROM honordosen WHERE JabatanAkdm='$jbatan'";
	$hono=_query($honor) or die();
	$h= _fetch_array($hono);
	$honorSks=digit($h[HonorSks]);
	$gajiPokok=digit($h[GajiPokok]);
	$TtransTM=digit($h[TransportTtpMk]);
	$Ttransport=digit($h[UangTransport]);
$totalHonorSks= $sks * $h['HonorSks'];
$totalHonoTm= $jumlahPresensi * $h['TransportTtpMk'];
$totalHr=$totalHonoTm + $totalHonorSks;
$TotalHonor=digit($totalHr);
$jtotal +=$jumlah;
$JumLahTotal=digit($jtotal);
//end setting
	$no++;
	echo "<tr>                            
		<td><center>$no</center></td>
		<td>$NamaDosen</td>
		<td>$NamaJabatan</td>
		<td>$MKK  $mtk</td>
		<td><center>$sks</center></td>
		<td> <span class='pull-right'>$honorSks</span></td>
		<td> <span class='pull-right'>$TtransTM</span></td>
		<td><center>$jumlahPresensi</center></td>
		<td> <span class='pull-right'>$TotalHonor</span></td>
		<td><span class='pull-right'>$Ttransport  </span></td>
		<td><span class='pull-right'>$totalHonor</span></td>
		</tr>";
}			
echo"<tfoot><tr><td colspan='10'><b>JUMLAH TOTAL
	<span class='pull-right'>Rp. </span></b></td>
	<td><b><span class='pull-right'>$JumLahTotal</span></b></td></tr></tfoot></table>";	
}elseif ($id==3){
echo"<table class='table table-bordered'>
<thead>
	<tr><th rowspan='2' valign='middle'>NO</th>
		<th rowspan='2' valign='middle'>NAMA</th>
		<th rowspan='2' valign='middle'>JABATAN</th>
		<th rowspan='2' valign='middle'>GAJI POKOK</th>
		<th colspan='2'><center>UANG LEMBUR</center></th>
		<th colspan='2'><center>UANG MAKAN</center></th>
		<th rowspan='2' valign='middle'><center>JUMLAH TOTAL</center></th>
	</tr>
	 <tr><td>KETERANGAN</td><td>JUMLAH</td><td>KETERANGAN</td><td>JUMLAH</td></tr>
</thead>";
	$main=_query("SELECT * FROM transaksi a, transaksihnrstaff b WHERE a.TransID=b.Notrans AND a. AccID=b.userid AND a.Transaksi ='15' AND a.TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY b.TglBayar DESC");
	$no=0;
	while($r=_fetch_array($main)){
	$jbatan=JabatanIdStaff($r[AccID]);
	$NamaJabatan=JabatanStaff($jbatan);
	$NamaStaff=NamaStaff($r[AccID]);
	$gajiPokok=digit($r[gajipokok ]);
	$lemburan=$r[jam]*$r[uanglembur];
	$UangMkan=$r[hari]*$r[uangmakan];
	$ul=digit($r[uanglembur]);
	$lembur=digit($lemburan);
	$um=digit($r[uanglembur]);
	$uangMkn=digit($UangMkan);

	$jumlah =$r[Total];
	$totalHonor=digit($jumlah);

	$JumLahTot +=$jumlah;
	$JumLahTotal=digit($JumLahTot);
	$no++;
	echo "<tr>                            
		<td><center>$no</center></td>
		<td>$NamaStaff</td>
		<td>$NamaJabatan</td>
		<td><span class='pull-right'>$gajiPokok</span></td>
		<td><center>$r[jam] jam X $um </center></td>
		<td> <span class='pull-right'>$lembur</span></td>
		<td> $r[hari] hari X $ul</td>
		<td><center>$uangMkn</center></td>
		<td> <span class='pull-right'>$totalHonor</span></td>
		</tr>";
}			
echo"<tfoot><tr><td colspan='8'><b>JUMLAH TOTAL
	<span class='pull-right'>Rp. </span></b></td>
	<td><b><span class='pull-right'>$JumLahTotal</span></b></td></tr></tfoot></table>";	
}elseif ($id==4){
$mhsws1 = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.JenjangID='S1' AND a.Angkatan='$angkatan'";
$Mhsw = _query($mhsws1);
echo"<table class='table table-bordered'>
<thead>
	<tr>
		<th>NO</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>TOTAL BIAYA</th>
		<th>TOTAL PEMBAYARAN</th>
		<th>SISA PEMBAYARAN</th>
	</tr>
</thead><tbody>";
while ($r = _fetch_array($Mhsw)) {
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
		<td><a href='get-transaksiKeuangan-DetailKeuMhsw-$r[RegID].html'>Rp. <span class='pull-right'>$WesBayar</span></a></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
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
	</tr></tfoot></table>";
}elseif ($id==5){
$mhsws1 = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.JenjangID='S2' AND a.Angkatan='$angkatan'";
$Mhsw = _query($mhsws1);
echo"<table class='table table-bordered'>
<thead>
	<tr>
		<th>NO</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>TOTAL BIAYA</th>
		<th>TOTAL PEMBAYARAN</th>
		<th>SISA PEMBAYARAN</th>
	</tr>
</thead><tbody>";
while ($r = _fetch_array($Mhsw)) {
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
		<td><a href='get-transaksiKeuangan-DetailKeuMhsw-$r[RegID].html'>Rp. <span class='pull-right'>$WesBayar</span></a></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
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
	</tr></tfoot></table>";
}elseif ($id==6){
echo"<table class='table table-bordered'>
<thead>
	<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>URAIAN</th>
		<th><center>JUMLAH</center></th>
	</tr>
</thead><tbody>";
$jnis = "SELECT * FROM jenistransaksi WHERE Jenis='1'";
$jr = _query($jnis);
while ($d=_fetch_array($jr)) {
$transaksi = "SELECT * FROM transaksi WHERE Transaksi='$d[id]' AND TglBayar BETWEEN '$dari' AND '$sampai' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
$trans = _query($transaksi);
while ($r = _fetch_array($trans)) {
	$tglBy=tgl_indo($r[TglBayar]);
	$Jumlah=$r[Debet];
	$aTotal +=$Jumlah;
	$Total=digit($Jumlah);
	$AllTotal=digit($aTotal);
	$no++;
echo"<tr>
		<td>$no</td>
		<td>$tglBy</td>
		<td>$r[Uraian]</td>
		<td>Rp. <span class='pull-right'>$Total</span></td>
	</tr>";
	}
}
echo"</tbody><tfoot><tr>
	<td colspan='3'><b>Total</b></td>
	<td><b>Rp. <span class='pull-right'>$AllTotal</span></b></td>
	</tr></tfoot></table>";
}elseif ($id==7){
echo"<table class='table table-bordered'>
<thead>
	<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>URAIAN</th>
		<th><center>JUMLAH</center></th>
	</tr>
</thead><tbody>";
$jnis = "SELECT * FROM jenistransaksi WHERE Jenis='2'";
$jr = _query($jnis);
while ($d=_fetch_array($jr)) {
$transaksi = "SELECT * FROM transaksi WHERE Transaksi='$d[id]' AND TglBayar BETWEEN '$dari' AND '$sampai' AND Buku IN ('1','2','8','9') ORDER BY TglBayar ASC";
$trans = _query($transaksi);
while ($r = _fetch_array($trans)) {
	$tglBy=tgl_indo($r[TglBayar]);
	$Jumlah=$r[Kredit];
	$aTotal +=$Jumlah;
	$Total=digit($Jumlah);
	$AllTotal=digit($aTotal);
	$no++;
echo"<tr>
		<td>$no</td>
		<td>$tglBy</td>
		<td>$r[Uraian]</td>
		<td>Rp. <span class='pull-right'>$Total</span></td>
	</tr>";
	}
}
echo"</tbody><tfoot><tr>
	<td colspan='3'><b>Total</b></td>
	<td><b>Rp. <span class='pull-right'>$AllTotal</span></b></td>
	</tr></tfoot></table>";
}
elseif ($id==8){
echo"<table class='table table-bordered'>
<tr class='panel-header'><th colspan='2'>PENERIMAAN</th></tr>
	<tr><td>Penerimaan Pembayaran Mahasiswa</td>
	<td> Rp. <span class='pull-right'>1.000.000</span></td></tr>
 <tr><td>Penerimaan Pembayaran DPP</td><td> Rp. <span class='pull-right'>1.000.000</span></td></tr>
 <tr><td>Penerimaan Pembayaran UTS dan UAS</td><td> Rp. <span class='pull-right'>1.000.000</span> </td></tr>
 <tr><td>Penerimaan Pembayaran Pengembangan</td><td> Rp. <span class='pull-right'>1.000.000</span> </td></tr>
 <tr><td>Penerimaan Pembayaran Bimbingan & Ujian Skripsi</td><td> Rp. <span class='pull-right'>1.000.000</span></td></tr>
 <tr><td>Penerimaan Pembayaran Wisuda</td><td> Rp. <span class='pull-right'>1.000.000</span> </td></tr>
 <tr>
	<td>Penerimaan Pembayaran Mahasiswa Baru</td>
	<td> Rp. <span class='pull-right'>1.000.000</span></td></tr>
<tr><td><center><b>JUMLAH PENERIMAAN</b></center></td>
<td><b>Rp. <span class='pull-right'>1.000.000</span></b></td></tr>

<tr class='panel-header'><td colspan='2'><b>BEBAN OPERASIONAL</b></td></tr>
 <tr><td>Beban Gaji Staff / Karyawan</td><td> Rp476.250.000,00 </td></tr>
 <tr><td>Beban Honor Dosen</td><td> Rp410.500.000,00 </td></tr>
 <tr><td>Beban Honor Rektorat</td><td> Rp350.500.000,00 </td></tr>
 <tr><td>Beban Promosi</td><td> Rp235.750.500,00 </td></tr>
 <tr><td>Beban Sewa Gedung Kampus</td><td> Rp54.300.000,00 </td></tr>
 <tr><td>Beban Konsumsi</td><td> Rp15.500.500,00 </td></tr>
 <tr><td>Beban ATK /Cetakan / F.Copy</td><td> Rp22.250.500,00 </td></tr>
 <tr><td>Beban Kantor</td><td> Rp37.500.000,00 </td></tr>
 <tr><td>Beban Rek.Telepon</td><td> Rp18.600.000,00 </td></tr>
 <tr><td>Beban Rek.Air / PDAM</td><td> Rp10.500.000,00 </td></tr>
 <tr><td>Beban Rek.Listrik</td><td> Rp58.750.250,00 </td></tr>
 <tr><td>Beban Transportasi</td><td> Rp48.550.350,00 </td></tr>
 <tr><td>Beban Pemeliharaan</td><td> Rp29.500.350,00 </td></tr>
 <tr><td>Beban Penyusutan Inventaris Kantor</td><td> Rp143.199.050,00 </td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>JUMLAH BEBAN OPERASIONAL</td><td> Rp1.911.651.500,00 </td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>LABA (RUGI) OPERASIONAL</td><td> Rp878.798.500,00 </td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>PENDAPATAN (BEBAN) LAIN LAIN</td><td>&nbsp;</td></tr>
 <tr><td>Pendapatan (Beban) Lain Lain</td><td> Rp(5.235.560,00)</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>JUMLAH PENDAPATAN (BEBAN) LAIN LAIN</td><td> Rp(5.235.560,00)</td></tr>
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
 <tr><td>LABA (RUGI) BERSIH TAHUN BERJALAN</td><td> Rp873.562.940,00 </td></tr>
 <tr><td>&nbsp;</td><td></td></tr>
</table>
";
}
elseif ($id==9){
echo"<table class='table table-bordered'>
  <tr class='panel-header'>
    <th colspan='2'>AKTIVA</th>
  </tr>
  <tr>
    <td>AKTIVA LANCAR</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kas Dan Setara Kas</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Piutang Pembayaran Mahasiswa</td>
    <td>1.156.908.730,00</td>
  </tr>
  <tr>
    <td>Piutang Karyawan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Persediaan Barang Cetakan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jumlah Aktiva Lancar</td>
    <td>2.158.808.730,00</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan='2'>AKTIVA TIDAK LANCAR</td>
  </tr>
  <tr>
    <td>Aktiva Tetap </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Akumulasi Penyusutan A.Tetap - Inv.Kantor</td>
    <td>2.266.054.600,00</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai Buku Aktiva Tetap</td>
    <td>1.487.411.625,00</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>JUMLAH AKTIVA</td>
    <td>3.646.220.355,00</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>KEWAJIBAN DAN EKUITAS</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>KEWAJIBAN LANCAR</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Hutang Usaha</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Hutang Pajak</td>
    <td>75.500.000,00 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jumlah Kewajiban Lancar</td>
    <td>85.350.550,00 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>EKUITAS</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Modal </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Laba ( Rugi ) Ditahan</td>
    <td>300.000.000,00</td>
  </tr>
  <tr>
    <td>Laba ( Rugi ) Bulan Ini</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jumlah Ekuitas</td>
    <td>3.560.869.805,00 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>JUMLAH KEWAJIBAN DAN EKUITAS</td>
    <td>3.646.220.355,00</td>
  </tr>
</table>
";
} else { 
echo"<div class='alert alert-info'>
	<button class='close' data-dismiss='alert'>&times;</button>
	<strong>Pilih Jenis Laporan </strong> Untuk Mellihat laporan, Silahkan Pilih Menu pilih laporan di atas.
</div>";
 }  
echo"</div>";
tutup();
}

switch($_GET[PHPIdSession]){

default:
Deflaporan();
break;

}     
        
?>
