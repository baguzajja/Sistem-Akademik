<?php
//Tampilkan
global $saiki;
$trans = $_REQUEST['id'];
$d              = GetFields('transaksihnrdosen', 'Notrans', $trans, 'TglBayar,periode1,periode2,TotalHonor,potongan,Total,honorSks,honorTmuka,userid,TahunID,semester,SubmitBy');
$tglTransaksi   =tgl_indo($d['TglBayar']);
$periode1       =tgl_indo($d['periode1']);
$periode2       =tgl_indo($d['periode2']);
$TotalHonor     =digit($d['TotalHonor']);
$potongan       =digit($d['potongan']);
$Total          =digit($d['Total']);
$honorSks       =digit($d['honorSks']);
$honorTmuka     =digit($d['honorTmuka']);
$dosen = GetFields('dosen', 'dosen_ID', $d['userid'], 'Jabatan_ID,nama_lengkap,Gelar');
$NamaJabatan=JabatanStaff($dosen['Jabatan_ID']);
?>
<div class="widget-header">	
    <h3>PEMBAYARAN HONOR DOSEN </h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class="btn btn-inverse" href="get-print-transaksiDosen-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 
					
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMBAYARAN HONOR DOSEN</th>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;TANGGAL</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $tglTransaksi</td>
            <td style='width: 10%;text-align: right;'>&nbsp;&nbsp;TRANS ID&nbsp;&nbsp;</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $trans</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;NAMA</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$dosen[nama_lengkap] $dosen[Gelar]</td>
            <td style='width: 10%;text-align: right;'>&nbsp;&nbsp;JABATAN&nbsp;&nbsp;</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $NamaJabatan</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;RINCIAN </td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>
                <table cellspacing='0' style='width: 100%; border: solid 1pt #000; background: #000; font-size: 10pt; color: #FFF;'>
                    <tr>
                        <th style='width:10%; text-align: left;'>Tgl T.Muka</th>
                        <th style='width:8%; text-align: left;'>Kode </th>
                        <th style='width:29%; text-align: left;'>Nama Matakuliah </th>
                        <th style='width:8%; text-align: center;'>Sks</th>
                        <th style='width:15%; text-align: right;'>Honor/Sks</th>
                        <th style='width:15%; text-align: right;'>Transport/T.Muka</th>
                        <th style='width:15%; text-align: right;'>Honor</th>
                    </tr>
                </table>
                <table cellspacing='0' style='width: 100%; font-size: 10pt;'>";
                    $na=1;
                    $presensi="SELECT a.Tanggal,b.SKS,b.KelompokMtk_ID,b.Kode_mtk,b.Nama_matakuliah
                        FROM presensi a
                        INNER JOIN matakuliah b ON a.mtkID=b.Matakuliah_ID
                        WHERE a.DosenID='$d[userid]' 
                        AND a.TahunID='$d[TahunID]' 
                        AND a.semester='$d[semester]' 
                        AND a.Pertemuan='1' 
                        AND a.Tanggal BETWEEN '$d[periode1]' AND '$d[periode2]' 
                        ORDER BY a.Tanggal DESC";
                    $press=_query($presensi) or die();
                    while($data=_fetch_array($press))
                    {
                        $tgle=format_tanggal($data['Tanggal']);
                        $MKK=KelompokMtk($data['KelompokMtk_ID']);
                        $totalsks=$data['SKS'] * $d['honorSks'];
                        $tot=$totalsks + $d['honorTmuka'];
                        $toot=digit($tot);
                    echo "<tr style='border-bottom: dotted 0.5mm #000000;'>
                            <td style='width:10%; text-align: left;'>$tgle</td>
                            <td style='width:8%; text-align: left;'>$MKK $data[Kode_mtk]</td>
                            <td style='width:29%; text-align: left;'>$data[Nama_matakuliah]</td>
                            <td style='width:8%; text-align: center;'>$data[SKS]</td>
                            <td style='width:15%; text-align: right;'>$honorSks</td>
                            <td style='width:15%; text-align: right;'>$honorTmuka</td>
                            <td style='width:15%; text-align: right;'>$toot</td>
                          </tr>";
                $na++;
                }	
                echo"</table>
            </td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp; </td>
            <td colspan='3' style='width: 90%;'>
            <table cellspacing='0' style='width: 100%;font-size: 10pt;'>
                <tr style='border-bottom: dotted 0.5mm #000000;'>
                    <th style='width: 60%;text-align: left;'>Total Honor Dosen Periode $periode1 s/d $periode2 :</th>
                    <th style='width: 40%; text-align: right;'>$TotalHonor</th>
                </tr>
                <tr style='border-bottom: dotted 0.5mm #000000;'>
                    <th style='width: 60%;text-align: left'>Potongan :</th>
                    <th style='width: 40%; text-align: right;'>$potongan</th>
                </tr>
                <tr style='border-bottom: dotted 0.5mm #000000;'>
                    <th style='width: 60%;text-align: left'>TOTAL :</th>
                    <th style='width: 40%; text-align: right;'>$Total</th>
                </tr>
            </table>
            </td>
        </tr>
    </table><br>";
$nowws=tgl_indo($saiki);    
echo"<table cellspacing='0' style='width: 100%;font-size: 10pt;'>
        <tr>
            <td style='width: 5%;'>&nbsp;</td>
            <td style='width: 35%; text-align: center'>   
				PENERIMA
				<br><br><br><br><br><br>
				<b> ( $dosen[nama_lengkap] $dosen[Gelar] ) </b>
			</td>
            <td style='width: 30%;'>&nbsp;</td>
            <td style='width: 20%; text-align: center'> 
				 Surabaya, $nowws<br>
				BAU <br><br><br><br><br><br>
				<b> ( $d[SubmitBy] )</b>
			</td>
            <td style='width: 10%;'>&nbsp;</td>
        </tr>
    </table>";
?>
    </div>
</div> 