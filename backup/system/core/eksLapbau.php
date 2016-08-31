<?php
$id		= $_REQUEST['id'];
$dari	= trimed($_REQUEST['bulan']);
$sampai	= trimed($_REQUEST['tahun']);
$laporan=NamaLaporan($id);

$dariTgl = substr($dari,6,2);
$daribln = substr($dari,4,2);
$darithn = substr($dari,0,4);

$sampaiTgl = substr($sampai,6,2);
$sampaibln = substr($sampai,4,2);
$sampaithn = substr($sampai,0,4);

$da=$darithn.'-'.$daribln.'-'.$dariTgl;
$sa=$sampaithn.'-'.$sampaibln.'-'.$sampaiTgl;

$d=tgl_indo2($da);
$s=tgl_indo2($sa);
$tgl=tgl_indo(date("Y m d")); 	
if($id==1){
$cap="<table align=center border=1px>
<th colspan='7'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR REKTORAT<br>  Periode( $d s/d $s ) </th>";
$title="<tr>
	<td><b>NO</b></td>
	<td><b>NAMA DOSEN</b></td>
	<td><b>JABATAN</b></td>
	<td><b>GAJI POKOK</b></td>
	<td><b>T. JABATAN</b></td>
	<td><b>T. TRANSPORT</b></td>
	<td><b>JUMLAH</b></td>
</tr>";
$main=_query("SELECT * FROM transaksi WHERE Transaksi ='14' AND TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY TglBayar DESC");
	$no=0;
	while($r=mysql_fetch_array($main)){
	$jbatan=JabatanIdStaff($r[AccID]);
	$NamaStafff=NamaStaff($r[AccID]);
	$NamaJabatan=JabatanStaff($jbatan);
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
$body.="<tr>                            
		<td><center>".$no."</center></td>
		<td>".$NamaStafff."</td>
		<td>".$NamaJabatan."</td>
		<td>Rp. <span class='pull-right'>".$gajiPokok."</span></td>
		<td>Rp. <span class='pull-right'>".$Tjabatan."</span></td>
		<td>Rp. <span class='pull-right'>".$Ttransport."</span></td>
		<td>Rp. <span class='pull-right'>".$total."</span></td>
		</tr>";
}			
$body2.="<tr><td colspan='6'><center><b>JUMLAH TOTAL</b></center></td>
	<td><b>Rp.  ".$jtotal." </b></td></tr></table>";
$footer.="<table align=center>
<tr><td colspan='7'></td></tr><tr><td colspan='7'></td></tr>
<tr><td colspan='6'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='6'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='7'></td></tr>
<tr><td colspan='7'></td></tr>
<tr><td colspan='6'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='6'></td><td><center>B.A.U</center></td></tr>
";
echo $cap.$title.$body.$body2.$footer."</table>";	
}elseif($id==2){
$cap="<table align=center border=1px>
<th colspan='11'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR DOSEN<br>  Periode( ".$s." s/d ".$d." ) </th>";
$title="<tr>
	<th><b>NO</b></th>
	<th><b>NAMA DOSEN</b></th>
	<th><b>JABATAN AKDM</b></th>
	<th><b>MATA KULIAH</b></th>
	<th><b>JUMLAH SKS</b></th>
	<th><b>HONOR / SKS</b></th>
	<th><b>TRANSPORT T.MUKA</b></th>
	<th><b>JUMLAH T.MUKA</b></th>
	<th><b>HONOR</b></th>
	<th><b>UANG TRANSPORT</b></th>
	<th><b>JUMLAH</b></th>
</tr>";
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
$body.="<tr>                            
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
$body2.="<tr><td colspan='10'><b>JUMLAH TOTAL</b></td>
	<td><b>Rp. <span class='pull-right'>$JumLahTotal</span></b></td></tr></table>";				
$footer.="<table align=center>
<tr><td colspan='11'></td></tr><tr><td colspan='11'></td></tr>
<tr><td colspan='10'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='10'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='11'></td></tr>
<tr><td colspan='11'></td></tr>
<tr><td colspan='10'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='10'></td><td><center>B.A.U</center></td></tr>
";
echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==3){
$cap="<table align=center border=1px>
<th colspan='9'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR STAFF<br>  Periode( ".$s." s/d ".$d." ) </th>";
$title="	<tr><th rowspan='2' valign='middle'>NO</th>
		<th rowspan='2' valign='middle'>NAMA</th>
		<th rowspan='2' valign='middle'>JABATAN</th>
		<th rowspan='2' valign='middle'>GAJI POKOK</th>
		<th colspan='2'><center>UANG LEMBUR</center></th>
		<th colspan='2'><center>UANG MAKAN</center></th>
		<th rowspan='2' valign='middle'><center>JUMLAH TOTAL</center></th>
	</tr>
	 <tr><td>KETERANGAN</td><td>JUMLAH</td><td>KETERANGAN</td><td>JUMLAH</td></tr>";
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
$body.="<tr>                            
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
$body2.="<tr><td colspan='8'><b>JUMLAH TOTAL</b></td>
	<td><b><span class='pull-right'> $JumLahTotal</span></b></td></tr></table>";

$footer.="<table align=center>
<tr><td colspan='9'></td></tr><tr><td colspan='9'></td></tr>
<tr><td colspan='8'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='8'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='9'></td></tr>
<tr><td colspan='9'></td></tr>
<tr><td colspan='8'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='8'></td><td><center>B.A.U</center></td></tr>
";				

echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==4){
$mhsws1 = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.JenjangID='S1' AND a.Angkatan='$sampai'";
$Mhsw = _query($mhsws1);
$cap="<table align=center border=1px>
<th colspan='6'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PERINCIAN PEMBAYARAN MAHASISWA S1<br>  Tahun Akademik ( $sampai ) </th>";
$title="<tr>
		<th>NO</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>TOTAL BIAYA</th>
		<th>TOTAL PEMBAYARAN</th>
		<th>SISA PEMBAYARAN</th>
	</tr>";
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
$body.="<tr>
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$TotBiaya</span></td>
		<td>Rp. <span class='pull-right'>$WesBayar</span></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
	</tr>";
$TotB=$TotB+$r[TotalBiaya];
$SemuaBiaya=digit($TotB);
$TotBy=$TotBy+$b[total];
$SemuaBayar=digit($TotBy);
$TotSis=$TotSis+$s;
$SemuaSisa=digit($TotSis);
}
$body2.="</tbody><tfoot><tr>
	<td colspan='3'><b>Total Seluruhnya : </b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBiaya</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBayar</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaSisa</span></b></td>
	</tr></tfoot></table>";

$footer.="<table align=center>
<tr><td colspan='6'></td></tr><tr><td colspan='6'></td></tr>
<tr><td colspan='5'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='5'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='6'></td></tr>
<tr><td colspan='6'></td></tr>
<tr><td colspan='5'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='5'></td><td><center>B.A.U</center></td></tr>
";				
echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==5){
$mhsws1 = "SELECT * FROM mahasiswa a,keuanganmhsw b WHERE a.NoReg=b.RegID AND b.IdentitasID='$_SESSION[Identitas]' AND b.Aktif='Y' AND b.Keterangan!='' AND b.JenjangID='S2' AND a.Angkatan='$sampai'";
$Mhsw = _query($mhsws1);
$cap="<table align=center border=1px>
<th colspan='6'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PERINCIAN PEMBAYARAN MAHASISWA S2<br>  Tahun Akademik ( $sampai ) </th>";
$title="<tr>
		<th>NO</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>TOTAL BIAYA</th>
		<th>TOTAL PEMBAYARAN</th>
		<th>SISA PEMBAYARAN</th>
	</tr>";
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
$body.="<tr>
		<td>$no</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>Rp. <span class='pull-right'>$TotBiaya</span></td>
		<td>Rp. <span class='pull-right'>$WesBayar</span></td>
		<td>Rp. <span class='pull-right'>$Sisa</span></td>
	</tr>";
$TotB=$TotB+$r[TotalBiaya];
$SemuaBiaya=digit($TotB);
$TotBy=$TotBy+$b[total];
$SemuaBayar=digit($TotBy);
$TotSis=$TotSis+$s;
$SemuaSisa=digit($TotSis);
}
$body2.="</tbody><tfoot><tr>
	<td colspan='3'><b>Total Seluruhnya : </b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBiaya</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaBayar</span></b></td>
	<td><b>Rp. <span class='pull-right'>$SemuaSisa</span></b></td>
	</tr></tfoot></table>";

$footer.="<table align=center>
<tr><td colspan='6'></td></tr><tr><td colspan='6'></td></tr>
<tr><td colspan='5'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='5'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='6'></td></tr>
<tr><td colspan='6'></td></tr>
<tr><td colspan='5'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='5'></td><td><center>B.A.U</center></td></tr>
";				
echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==6){
$cap="<table align=center border=1px>
<th colspan='4'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>LAPORAN PENDAPATAN <br>  
	( ".$s." s/d ".$d." ) </th>";
$title="<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>URAIAN</th>
		<th>JUMLAH</th>
	</tr>";
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
$body.="<tr>
		<td>$no</td>
		<td>$tglBy</td>
		<td>$r[Uraian]</td>
		<td>Rp. <span class='pull-right'>$Total</span></td>
	</tr>";
	}
}
$body2.="</tbody><tfoot><tr>
	<td colspan='3'><b>Total</b></td>
	<td><b>Rp. <span class='pull-right'>$AllTotal</span></b></td>
	</tr></tfoot></table>";
$footer.="<table align=center>
<tr><td colspan='4'></td></tr><tr><td colspan='4'></td></tr>
<tr><td colspan='3'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='3'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='4'></td></tr>
<tr><td colspan='4'></td></tr>
<tr><td colspan='3'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='3'></td><td><center>B.A.U</center></td></tr>
";				
echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==7){
$cap="<table align=center border=1px>
<th colspan='4'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>LAPORAN PENGELUARAN <br>  
	( ".$s." s/d ".$d." ) </th>";
$title="<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>URAIAN</th>
		<th>JUMLAH</th>
	</tr>";
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
$body.="<tr>
		<td>$no</td>
		<td>$tglBy</td>
		<td>$r[Uraian]</td>
		<td>Rp. <span class='pull-right'>$Total</span></td>
	</tr>";
	}
}
$body2.="</tbody><tfoot><tr>
	<td colspan='3'><b>Total</b></td>
	<td><b>Rp. <span class='pull-right'>$AllTotal</span></b></td>
	</tr></tfoot></table>";
$footer.="<table align=center>
<tr><td colspan='4'></td></tr><tr><td colspan='4'></td></tr>
<tr><td colspan='3'></td><td><center>Surabaya, $tgl </center></td></tr>
<tr><td colspan='3'></td><td><center>Pembuat</center></td></tr>
<tr><td colspan='4'></td></tr>
<tr><td colspan='4'></td></tr>
<tr><td colspan='3'></td><td><center><u>$_SESSION[Nama]</u></center></td></tr>
<tr><td colspan='3'></td><td><center>B.A.U</center></td></tr>
";				
echo $cap.$title.$body.$body2.$footer."</table>";
}else{

}				
?>	
	
	
	