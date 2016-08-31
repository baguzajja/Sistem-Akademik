<?php
//Tampilkan
global $saiki;
$trans = $_REQUEST['id'];
$s="SELECT a.TglSubmit,b.Total,b.RekananID,b.qty,a.Uraian,a.SubmitBy
    FROM transaksi a, detailbayarrekanan b WHERE a.TransID=b.transID AND a.TransID='$trans'";
$hasil          = _query($s) or die();
$d              =_fetch_array($hasil);
$tglTransaksi   =tgl_indo($d['TglSubmit']);
$jumlah         =digit($d['Total']);
$rek            =GetFields('rekanan', 'RekananID', $d['RekananID'], 'NamaRekanan');
?>
<div class="widget-header">	
    <h3>PEMBAYARAN REKANAN </h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
            <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
            <a class="btn btn-inverse" href="get-print-rekananpay-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 		
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMBAYARAN REKANAN</th>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;TANGGAL</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $tglTransaksi</td>
            <td style='width: 10%;'>&nbsp;&nbsp;TRANS ID</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $trans</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;NAMA</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$rek[NamaRekanan]</td>
            <td style='width: 10%;'>&nbsp;&nbsp;UNTUK</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $d[qty] mahasiswa</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;URAIAN</td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$d[Uraian]</td>
        </tr>
    </table><br>";
$nowws=tgl_indo($saiki);
echo"<table cellspacing='0' style='width: 100%;font-size: 10pt;'>
        <tr>
            <td style='width: 10%; text-align: center' >
            &nbsp;&nbsp;<br>
            <b>JUMLAH : </b><br>
            &nbsp;&nbsp;
            </td>
            <td style='width: 50%; text-align: left' >
            -----------------------------------------<br>
            <b>Rp. $jumlah</b><br>
            -----------------------------------------
            </td>
            <td style='width: 40%; text-align: center;border-bottom: dotted 0.5mm #000000;'> 
				<b>Surabaya, $nowws</b><br><br><br><br><br>
				<b> ( $d[SubmitBy] ) </b>
			</td>
        </tr>
    </table>";
?>
    </div>
</div>