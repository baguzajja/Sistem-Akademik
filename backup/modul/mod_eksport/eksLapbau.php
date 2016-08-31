<?php
$id		= $_REQUEST['md'];
if($id==2){
$thnAkdm	= trimed($_REQUEST['id']);
$semester	= trimed($_REQUEST['do']);
$tahun		= trimed($_REQUEST['di']);
$bulan		= trimed($_REQUEST['ke']);

$Bulan=getBulan($bulan);
$tahunAkademik=TahunID($thnAkdm);

}else{
$dari	= trimed($_REQUEST['id']);
$sampai	= trimed($_REQUEST['do']);
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
}
$tgl=tgl_indo(date("Y m d")); 	
if($id==1){
$cap="<table align=center border=1px>
<th colspan='8'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR REKTORAT BULAN <br>  Periode( $d s/d $s ) </th>";
$title="<tr>
	<td><b>NO</b></td>
	<td><b>NAMA REKTOR</b></td>
	<td><b>JABATAN</b></td>
	<td><b>GAJI POKOK</b></td>
	<td><b>T. JABATAN</b></td>
	<td><b>T. TRANSPORT</b></td>
	<td><b>POTONGAN</b></td>
	<td><b>TOTAL</b></td>
</tr>";
	$no=0;
	$main=_query("SELECT * FROM transaksihnrektor WHERE TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY TglBayar DESC");
	while($r=_fetch_array($main)){
	$k = GetFields('karyawan', 'id', $r[userid], '*');
	$NamaJabatan=GetName("jabatan","Jabatan_ID",$k[Jabatan],"Nama");
	$NamaRektor=strtoupper($k['nama_lengkap']);
	$gajiPokok=digit($r['gajipokok']);
	$Ttransport=digit($r['transport']);
	$Tjabatan=digit($r['jabatan']);
	$Potongan=digit($r['potongan']);
	$tot=$r[Total];
	$jumlahTot 	+=$tot;
	$total=digit($tot);
	$jtotal=digit($jumlahTot);
	$no++;
$body.="<tr>                            
		<td><center>$no</center></td>
		<td>$NamaRektor</td>
		<td>$NamaJabatan</td>
		<td>Rp. <span class='pull-right'>$gajiPokok</span></td>
		<td>Rp. <span class='pull-right'>$Tjabatan</span></td>
		<td>Rp. <span class='pull-right'>$Ttransport</span></td>
		<td>Rp. <span class='pull-right'>$Potongan</span></td>
		<td>Rp. <span class='pull-right'>$total</span></td>
		</tr>";
}			
$body2.="<tr><td colspan='7'><center><b>JUMLAH TOTAL</b></center></td>
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
<th colspan='11'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR DOSEN  BULAN $Bulan $tahun<br> SEMESTER $semester $tahunAkademik</th>";
$title="<tr>
    <th rowspan='2'><center>NO</center></th>
    <th colspan='2'><center>DOSEN </center></th>
    <th colspan='3'><center>MATA KULIAH</center></th>
    <th colspan='4'><center>PRESENSI</center></th>
    <th rowspan='2'><center>JUMLAH</center></th>
  </tr>
  <tr>
    <th>Nama</th>
    <th>Jabatan</th>
    <th>Kode </th>
    <th>Nama Matakuliah </th>
    <th>Sks</th>
    <th>Tgl T.Muka</th>
    <th>Honor/Sks</th>
    <th>Transport/T.Muka</th>
    <th>Honor</th>
  </tr>";
	$main=_query("SELECT * FROM transaksihnrdosen WHERE TahunID='$thnAkdm' AND semester='$semester' AND TglBayar LIKE '$tahun-$bulan%' ORDER BY userid DESC");
	$no=1;
	while($r=_fetch_array($main)){
	$jbatan=JabatanIdDosen($r[userid]);
	$NamaJabatan=JabatanStaff($jbatan);
	$NamaDosen=NamaDosen($r[userid]);

	$honorSks=digit($r[honorSks]);
	$honorTmuka=digit($r[honorTmuka]);
	$totalHonor=digit($r[TotalHonor]);
	$potong=digit($r[potongan]);
	$totalall=digit($r[Total]);
	
//Presensi
	$na=1;
	$presensi="SELECT * FROM presensi 
		INNER JOIN matakuliah ON presensi.mtkID=matakuliah.Matakuliah_ID
		WHERE presensi.DosenID='$r[userid]' 
		AND presensi.TahunID='$r[TahunID]' 
		AND presensi.semester='$r[semester]' 
		AND presensi.Pertemuan='1' 
		AND presensi.Tanggal BETWEEN '$r[periode1]' AND '$r[periode2]' 
		ORDER BY presensi.Tanggal DESC";
	$press=_query($presensi) or die();
	while($data=_fetch_array($press))
	{
		$tgle=format_tanggal($data[Tanggal]);
		$MKK=KelompokMtk($data['KelompokMtk_ID']);
		$totalsks=$data[SKS] * $r[honorSks];
		$tot=$totalsks + $r[honorTmuka];
		$toot=digit($tot);
	$nomere=($na==1)? $no:"";
	$namae=($na==1)? $NamaDosen:"";
	$jabatane=($na==1)? $NamaJabatan:"";
	$totalalle=($na==$r['TatapMuka'])? "Rp. <span class='pull-right'>$totalall</span>":"";
$body.="<tr>
    <td><center>$nomere</center></td>
    <td>$namae</td>
    <td>$jabatane</td>
    <td>$MKK $data[Kode_mtk]</td>
    <td>$data[Nama_matakuliah]</td>
    <td><center>$data[SKS]</center></td>
    <td>$tgle</td>
    <td>Rp. <span class='pull-right'>$honorSks</span></td>
    <td>Rp. <span class='pull-right'>$honorTmuka</span></td>
    <td>Rp. <span class='pull-right'>$toot</span></td>
    <td>$totalalle</td>
  </tr>";
$na++;
}
$totals+=$r[Total];
$JumLahTotal=digit($totals);
$no++;
}			
$body2.="<tfoot>
	<tr>
		<td colspan='11'><b><center>JUMLAH TOTAL</center></b></td>
		<td><b>Rp. <span class='pull-right'>$JumLahTotal</span></b></td>
	</tr>
	</tfoot></table>";	
$PuketII=_fetch_array(_query("SELECT * FROM karyawan WHERE Jabatan='21' LIMIT 0,1"));			
$footer.="<table align=center>
<tr><td colspan='11'></td></tr>
<tr><td colspan='11'></td></tr>
<tr>
	<td colspan='7'></td>
	<td colspan='4'><center>Surabaya, $tgl </center></td>
</tr>
<tr>
	<td colspan='4'><center>Mengetahui, </center></td>
	<td colspan='3'></td>
	<td colspan='4'><center>Pembuat</center></td>
</tr>

<tr><td colspan='11'></td></tr>
<tr><td colspan='11'></td></tr>

<tr>
	<td colspan='4'><center><u>$PuketII[nama_lengkap]</u></center></td>
	<td colspan='3'></td>
	<td colspan='4'><center><u>$_SESSION[Nama]</u></center></td>
</tr>
<tr>
	<td colspan='4'><center>PUKET II</center></td>
	<td colspan='3'></td>
	<td colspan='4'><center>B.A.U</center></td>
</tr>";
echo $cap.$title.$body.$body2.$footer."</table>";
}elseif($id==3){
$cap="<table align=center border=1px>
<th colspan='10'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>PEMBAYARAN HONOR STAFF<br>  Periode( ".$s." s/d ".$d." ) </th>";
$title="<tr>
		<th><center>NO</center></th>
		<th>NAMA</th>
		<th>JABATAN</th>
		<th>GAJI POKOK</th>
		<th colspan='2'><center>UANG MAKAN</center></th>
		<th colspan='2'><center>UANG LEMBUR</center></th>
		<th>POTONGAN</th>
		<th><center>JUMLAH</center></th>
	</tr>";
$no=0;
	$main=_query("SELECT * FROM transaksihnrstaff WHERE TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY TglBayar DESC");
	while($r=_fetch_array($main)){
	$k = GetFields('karyawan', 'id', $r[userid], '*');
	$NamaJabatan=GetName("jabatan","Jabatan_ID",$k[Jabatan],"Nama");
	$NamaRektor=strtoupper($k['nama_lengkap']);
	$gajiPokok=digit($r['gajipokok']);
	$uangmakan=digit($r['uangmakan']);
	$uanglembur=digit($r['uanglembur']);
	$Potongan=digit($r['potongan']);
	$tot=$r[Total];
	$jumlahTot 	+=$tot;
	$total=digit($tot);
	$jtotal=digit($jumlahTot);
	$no++;
$body.="<tr>                            
		<td><center>$no</center></td>
		<td>$NamaRektor</td>
		<td>$NamaJabatan</td>
		<td>Rp. <span class='pull-right'>$gajiPokok</span></td>
		<td>$r[hari] <span class='pull-right'>Hari</span></td>
		<td>Rp. <span class='pull-right'>$uangmakan</span></td>
		<td>$r[jam] <span class='pull-right'>Jam</span></td>
		<td>Rp. <span class='pull-right'>$uanglembur</span></td>
		<td>Rp. <span class='pull-right'>$Potongan</span></td>
		<td>Rp. <span class='pull-right'>$total</span></td>
		</tr>";
}			
$body2.="<tfoot><tr><td colspan='9'><b>TOTAL</b></td>
	<td><b>Rp. <span class='pull-right'>$jtotal</span></b></td></tr></tfoot></table>";

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
$cap="<table align=center border=1px>
<th colspan='8'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>LAPORAN PEMBAYARAN MAHASISWA S1<br>  ( ".$s." s/d ".$d." ) </th>";
$title="<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>REKANAN</th>
		<th>KETERANGAN</th>
		<th>JUMLAH</th>
		<th>PAYMENT</th>
	</tr>";
$no=1;
$Mhsw = _query("SELECT * FROM transaksi INNER JOIN mahasiswa 
ON transaksi.AccID = mahasiswa.NoReg WHERE transaksi.Transaksi='17' AND transaksi.Buku IN ('1','2') AND transaksi.TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY transaksi.TglBayar ASC");
while ($r = _fetch_array($Mhsw)) { 
	$tgle=format_tanggal($r['TglBayar']);
	$JumlahBayar=digit($r['Debet']);
	$namaRekanan=GetName("rekanan","RekananID",$r['RekananID'],"NamaRekanan");
	$jenis=($r['RekananID']=='' OR $r['RekananID']=='0')? "REGULER": $namaRekanan;
	$Payment=($r['Buku']=='1')? "TUNAI": "TRANSFER";
$body.="<tr>
		<td>$no</td>
		<td>$tgle</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>$jenis</td>
		<td>$r[Uraian]</td>
		<td><span class='pull-right'>$JumlahBayar</span></td>
		<td>$Payment</td>
	</tr>";
$total +=$r['Debet'];
$jtotal=digit($total);
$no++;
}
$body2.="</tbody><tfoot><tr>
	<td colspan='6'><b>TOTAL : </b></td>
	<td><b><span class='pull-right'>$jtotal</span></b></td>
	<td></td>
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
$cap="<table align=center border=1px>
<th colspan='8'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>LAPORAN PEMBAYARAN MAHASISWA S2<br>  ( ".$s." s/d ".$d." ) </th>";
$title="<tr>
		<th>NO</th>
		<th>TANGGAL</th>
		<th>NIM</th>
		<th>NAMA MAHASISWA</th>
		<th>REKANAN</th>
		<th>KETERANGAN</th>
		<th>JUMLAH</th>
		<th>PAYMENT</th>
	</tr>";
$no=1;
$Mhsw = _query("SELECT * FROM transaksi INNER JOIN mahasiswa 
ON transaksi.AccID = mahasiswa.NoReg WHERE transaksi.Transaksi='17' AND transaksi.Buku IN ('8','9') AND transaksi.TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY transaksi.TglBayar ASC");
while ($r = _fetch_array($Mhsw)) { 
	$tgle=format_tanggal($r['TglBayar']);
	$JumlahBayar=digit($r['Debet']);
	$namaRekanan=GetName("rekanan","RekananID",$r['RekananID'],"NamaRekanan");
	$jenis=($r['RekananID']=='' OR $r['RekananID']=='0')? "REGULER": $namaRekanan;
	$Payment=($r['Buku']=='9')? "TUNAI": "TRANSFER";
$body.="<tr>
		<td>$no</td>
		<td>$tgle</td>
		<td>$r[NIM]</td>
		<td>$r[Nama]</td>
		<td>$jenis</td>
		<td>$r[Uraian]</td>
		<td><span class='pull-right'>$JumlahBayar</span></td>
		<td>$Payment</td>
	</tr>";
$total +=$r['Debet'];
$jtotal=digit($total);
$no++;
}
$body2.="</tbody><tfoot><tr>
	<td colspan='6'><b>TOTAL : </b></td>
	<td><b><span class='pull-right'>$jtotal</span></b></td>
	<td></td>
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
}elseif($id==10){
$cap="<table align=center border=1px>
<th colspan='6'>SEKOLAH TINGGI ILMU EKONOMI YAPAN SURABAYA <br>LAPORAN PENJUALAN JAS ALMAMATER <br>  
	( ".$s." s/d ".$d." ) </th>";
$title="<tr>
	<th><center>NO</center></th>
	<th>TANGGAL</th>
	<th>NAMA</th>
	<th><center>UKURAN</center></th>
	<th><center>JUMLAH</center></th>
	<th><center>KETERANGAN</center></th>
	</tr><tbody>";
	$main=_query("SELECT * FROM transaksi INNER JOIN transaksijual 
ON transaksi.TransID = transaksijual.Notrans WHERE transaksijual.produkid='4' AND transaksijual.TglBayar BETWEEN '$dari' AND '$sampai' ORDER BY transaksijual.TglBayar DESC");
	while($r=_fetch_array($main)){
	$tot=$r['Jumlah'] * $r['Harga'];
	$harga=digit($tot);
	$tgla=tgl_indo($r['TglBayar']);
	$ukuran=strtoupper($r['ukuran']);
	$ket=($r[Debet]=='0')? "$r[Uraian]":"Rp. <span class='pull-right'>$harga</span>";
	$no++;
	$body.="<tr>                            
		<td><center>$no</center></td>
		<td>$tgla</td>
		<td>$r[userid]</td>
		<td><center>$ukuran</center></td>
		<td><center>$r[Jumlah]</center></td>
		<td>$ket</td>
		</tr>";
$jumlahTot 	+=$tot;
$jtotal=digit($jumlahTot);
}

$body2.="</tbody><tfoot><tr>
	<td colspan='5'><b>Total</b></td>
	<td><b>Rp. <span class='pull-right'>$jtotal</span></b></td>
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
}				
?>	
	
	
	