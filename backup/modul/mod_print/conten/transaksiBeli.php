<?php
//Tampilkan
global $tgl_sekarang;
$trans = $_REQUEST['id'];
$d = GetFields('transaksi', 'TransID', $trans, 'TglBayar,Kredit,Jumlah,ProdukId,SubmitBy,Uraian');
$tglTransaksi=tgl_indo($d['TglBayar']);
$Total=digit($d['Kredit']);
///Detail
$b = GetFields('inventaris', 'InventarisID', $d['ProdukId'], 'NamaInventaris,Satuan');
if($d['ProdukId']==4){
$brg = GetFields('transaksijasalmamater', 'Notrans', $trans, 'Harga,summ,suml,sumxl,sumxxl');
$harga=digit($brg['summ']*$brg['Harga']);
}else{
$brg = GetFields('transaksibeli', 'Notrans', $trans, 'Harga,summ,suml,sumxl,sumxxl');
$harga=digit($brg['summ']*$brg['Harga']);
}
?>
<div class="widget-header">	
    <h3>PEMBELIAN</h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class="btn btn-inverse" href="get-print-transaksiBeli-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 		
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMBELIAN BARANG</th>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;TANGGAL</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $tglTransaksi</td>
            <td style='width: 10%;text-align: right;'>&nbsp;&nbsp;TRANS ID&nbsp;&nbsp;</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $trans</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;BARANG</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$b[NamaInventaris]</td>
            <td style='width: 10%;text-align: right;'>&nbsp;&nbsp;KET&nbsp;&nbsp;</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $d[Uraian]</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;RINCIAN </td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>
            <table cellspacing='0' style='width: 100%; font-size: 10pt;'>";
             
            if($d['ProdukId']==4){
                echo"<tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Ukuran M</td>
                         <td style='width: 10%; text-align: left' >$brg[summ] $b[Satuan]</td>
                        <td style='width: 40%; text-align: right'>$harga</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Ukuran L</td>
                         <td style='width: 10%; text-align: left' >$brg[suml] $b[Satuan]</td>
                        <td style='width: 40%; text-align: right'>$harga</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Ukuran XL</td>
                         <td style='width: 10%; text-align: left' >$brg[sumxl] $b[Satuan]</td>
                        <td style='width: 40%; text-align: right'>$harga</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Ukuran XXL</td>
                         <td style='width: 10%; text-align: left' >$brg[sumxxl] $b[Satuan]</td>
                        <td style='width: 40%; text-align: right'>$harga</td>
                    </tr>";
                }else{
                echo"<tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Pembelian $b[NamaInventaris]</td>
                         <td style='width: 10%; text-align: left' >$brg[Jumlah] $b[Satuan]</td>
                        <td style='width: 40%; text-align: right'>$harga</td>
                    </tr>";
                }
 
echo"</table>
            </td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp; </td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>
            <table cellspacing='0' style='width: 100%;font-size: 10pt;'>
                <tr>
                    <th style='width: 50%;text-align: left'>TOTAL :</th>
                    <th style='width: 10%; text-align: left;'>$d[Jumlah] $b[Satuan]</th>
                    <th style='width: 40%; text-align: right;'>$Total</th>
                </tr>
            </table>
            </td>
        </tr>
    </table><br>";
$nowws=tgl_indo($saiki); 
echo"<table cellspacing='0' style='width: 100%;font-size: 10pt;'>
        <tr>
            <td style='width: 10%;'>&nbsp;</td>
            <td style='width: 20%; text-align: center'>   
				MENGETAHUI
				<br><br><br><br><br><br>
				<b> ( ---------------------- ) </b>
			</td>
            <td style='width: 40%;'>&nbsp;</td>
            <td style='width: 20%; text-align: center'> 
				 Surabaya, $nowws<br>
				<br><br><br><br><br><br>
				<b> ( $d[SubmitBy] )</b>
			</td>
            <td style='width: 10%;'>&nbsp;</td>
        </tr>
    </table>";
?>
    </div>
</div> 