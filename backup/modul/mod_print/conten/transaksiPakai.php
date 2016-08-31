<?php
//Tampilkan
global $saiki;
$trans = $_REQUEST['id'];
$d = GetFields('transaksi', 'TransID', $trans, 'TglBayar,Debet,ProdukId,SubmitBy,Uraian');
$tglTransaksi=tgl_indo($d['TglBayar']);
$Total=digit($d['Debet']);
///Detail
$b = GetFields('inventaris', 'InventarisID', $d['ProdukId'], 'NamaInventaris,Satuan');
$brg = GetFields('transaksipakai', 'Notrans', $trans, 'userid,Jumlah');
$Pembeli=$brg['userid'];
?>
<div class="widget-header">	
    <h3>PEMAKAIAN BARANG </h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class="btn btn-inverse" href="get-print-transaksiPakai-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 		
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMAKAIAN BARANG <br></th>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;TANGGAL</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $tglTransaksi</td>
            <td style='width: 10%;'>&nbsp;&nbsp;TRANS ID</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $trans</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;BARANG</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$b[NamaInventaris]</td>
            <td style='width: 10%;'>&nbsp;&nbsp;PEMAKAI</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $Pembeli</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;URAIAN</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $d[Uraian]</td>
            <td style='width: 10%;'>&nbsp;&nbsp;JUMLAH</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $brg[Jumlah] $b[Satuan]</td>
        
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