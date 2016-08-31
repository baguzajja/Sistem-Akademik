<style type="text/css">
<!--
table.month{
	width: 100%; 
    border:1px solid #ccc;
    margin-bottom:10px;
    border-collapse:collapse;
}
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }

table.month td{
    border:1px solid #ddd;
    color:#333;
    padding:3px;
    text-align:left;
}

table.month th {
    padding:5px;
	background-color:#208bbd;
    color:#fff;
	text-align:center;
}

    table.page_header {width: 100%; border: none; background-color: #208bbd; color:#fff; border-bottom: solid 1mm #086d8e; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #208bbd; color:#fff; border-top: solid 1mm #086d8e; padding: 2mm}
   div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
-->
</style>
<?php
//Tampilkan
global $tgl_sekarang;
echo"<page backtop='0mm' backbottom='0' backleft='2mm' backright='2mm' orientation='L' backcolor='#edf6f9' style='font-size: 12pt'>";
$trans = $_REQUEST['id'];

$d = GetFields('transaksihnrdosen', 'Notrans', $trans, '*');
$tglTransaksi=tgl_indo($d[TglBayar]);
$periode1=tgl_indo($d[periode1]);
$periode2=tgl_indo($d[periode2]);
$TotalHonor=digit($d['TotalHonor']);
$potongan=digit($d['potongan']);
$Total=digit($d['Total']);
$honorSks=digit($d['honorSks']);
$honorTmuka=digit($d['honorTmuka']);

$dosen = GetFields('dosen', 'dosen_ID', $d['userid'], '*');
$NamaJabatan=JabatanStaff($dosen['Jabatan_ID']);
echo"<table style='width: 100%;border: none;' cellspacing='2mm' cellpadding='0'>
        <tr>
            <td style='width: 100%'>
                <div class='zone' style='height: 28mm;position: relative;font-size: 5mm;'>
                    
					<div style='position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; '>
                        <i>PEMBAYARAN HONOR DOSEN - ID : $trans</i><br><br><br><br>
						<span><i>Tanggal : $tglTransaksi</i></span><br>
						<span><i> Nama : $dosen[nama_lengkap] $dosen[Gelar]</i></span><br>
						<span><i> Jabatan : $NamaJabatan</i></span>
                    </div>
                    <img src='themes/img/logo.png' alt='logo' style='margin-top: 2mm; margin-left: 2mm; width: 10%'/>
                  
                </div>
            </td>
        </tr>
        <tr>
        <td style='width: 100%'>";
echo"<table cellspacing='0' style='width: 100%; border: solid 1px #208bbd; background: #208bbd; font-size: 10pt; color: #FFF;'>
        <tr>
			<th style='width:10%; text-align: left; border-right: solid 1px #FFF'>Tgl T.Muka</th>
			<th style='width:8%; text-align: left;  border-right: solid 1px #FFF'>Kode </th>
			<th style='width:29%; text-align: left;  border-right: solid 1px #FFF'>Nama Matakuliah </th>
			<th style='width:8%; text-align: center; border-right: solid 1px #FFF'>Sks</th>
			<th style='width:15%; text-align: right; border-right: solid 1px #FFF'>Honor/Sks</th>
			<th style='width:15%; text-align: right; border-right: solid 1px #FFF'>Transport/T.Muka</th>
			<th style='width:15%; text-align: right;'>Honor</th>
        </tr>
    </table>";
echo"<table cellspacing='0' style='width: 100%; border: solid 1px #FFF; background: #F7F7F7; font-size: 10pt;'>";
	$na=1;
	$presensi="SELECT * FROM presensi 
		INNER JOIN matakuliah ON presensi.mtkID=matakuliah.Matakuliah_ID
		WHERE presensi.DosenID='$d[userid]' 
		AND presensi.TahunID='$d[TahunID]' 
		AND presensi.semester='$d[semester]' 
		AND presensi.Pertemuan='1' 
		AND presensi.Tanggal BETWEEN '$d[periode1]' AND '$d[periode2]' 
		ORDER BY presensi.Tanggal DESC";
	$press=_query($presensi) or die();
	while($data=_fetch_array($press))
	{
		$tgle=format_tanggal($data[Tanggal]);
		$MKK=KelompokMtk($data['KelompokMtk_ID']);
		$totalsks=$data[SKS] * $d[honorSks];
		$tot=$totalsks + $d[honorTmuka];
		$toot=digit($tot);
	echo "<tr>
		<td style='width:10%; text-align: left;border: solid 1px #FFF'>$tgle</td>
		<td style='width:8%; text-align: left;border: solid 1px #FFF'>$MKK $data[Kode_mtk]</td>
		<td style='width:29%; text-align: left;border: solid 1px #FFF'>$data[Nama_matakuliah]</td>
		<td style='width:8%; text-align: center;border: solid 1px #FFF'>$data[SKS]</td>
		<td style='width:15%; text-align: right;border: solid 1px #FFF'>$honorSks</td>
		<td style='width:15%; text-align: right;border: solid 1px #FFF'>$honorTmuka</td>
		<td style='width:15%; text-align: right;border: solid 1px #FFF'>$toot</td>
	  </tr>";
$na++;
}	
echo"</table>";
echo"<table cellspacing='0' style='width: 100%; border: solid 1px #FFF; background: #F7F7F7; font-size: 10pt;'>
        <tr>
            <td style='width:70%; text-align: left' >Total Honor Dosen Periode $periode1 s/d $periode2</td>
            <td style='width: 30%; text-align: right'><b>$TotalHonor</b></td>
        </tr>
		<tr>
            <td style='width: 70%; text-align: left'>Potongan</td>
            <td style='width: 30%; text-align: right'>$potongan</td>
        </tr>
    </table>";

echo"<table cellspacing='0' style='width: 100%; border: solid 1px #FFF; background: #FFF; text-align: center; font-size: 10pt; color: #333;'>
        <tr>
            <th style='width: 60%; text-align: left;'>TOTAL :</th>
            <th style='width: 40%; text-align: right;'>$Total</th>
        </tr>
    </table>";
echo"</td></tr>";

echo"<tr>
		<td style='width: 100%;'>
	<table cellspacing='0' style='width: 100%; border: solid 1px #F7F7F7;font-size: 10pt;'>
        <tr>
            <td style='width: 60%; text-align: left' > 
			<p style='text-align: left'> <br>&nbsp;&nbsp;<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DOSEN
				<br><br><br><br><br><br>
				<b> ( $dosen[nama_lengkap] $dosen[Gelar] ) </b>
				</p>
			</td>
            <td style='width: 40%; text-align: right'> 
				<p style='text-align: right'> <br><i>Surabaya, $tglTransaksi</i><br>
				BAU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<br><br><br><br><br><br>
				<b> ( $d[SubmitBy] )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
				</p>
			</td>
        </tr>
    </table>
            </td>
        </tr></table>";
FooterPdf(); 
echo"</page>";
?>