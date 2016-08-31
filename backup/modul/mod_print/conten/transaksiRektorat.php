<?php
//Tampilkan
global $saiki;
$trans = $_REQUEST['id'];
$d = GetFields('transaksihnrektor', 'Notrans', $trans, 'TglBayar,gajipokok,transport,jabatan,potongan,Total,userid,SubmitBy');
$tglTransaksi=tgl_indo($d['TglBayar']);
$gajipokok=digit($d['gajipokok']);
$transport=digit($d['transport']);
$jabatan=digit($d['jabatan']);
$potongan=digit($d['potongan']);
$Total=digit($d['Total']);

$rektor = GetFields('karyawan', 'id', $d['userid'], 'Jabatan,nama_lengkap');
$NamaJabatan=JabatanStaff($rektor['Jabatan']);
?>
<div class="widget-header">	
    <h3>PEMBAYARAN HONOR REKTORAT </h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class="btn btn-inverse" href="get-print-transaksiRektorat-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 		
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMBAYARAN HONOR REKTORAT</th>
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
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$rektor[nama_lengkap]</td>
            <td style='width: 10%;text-align: right;'>&nbsp;&nbsp;JABATAN&nbsp;&nbsp;</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $NamaJabatan</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;RINCIAN </td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>
            <table cellspacing='0' style='width: 100%; font-size: 10pt;'>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width:50%; text-align: left' >Gaji Pokok</td>
                         <td style='width: 10%; text-align: left' ></td>
                        <td style='width: 40%; text-align: right'>$gajipokok</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Tunjangan Transport</td>
                         <td style='width: 10%; text-align: left' ></td>
                        <td style='width: 40%; text-align: right'>$transport</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Tunjangan Jabatan</td>
                         <td style='width: 10%; text-align: left' ></td>
                        <td style='width: 40%; text-align: right'>$jabatan</td>
                    </tr>
                     <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Potongan</td>
                        <td style='width: 10%; text-align: left' ></td>
                        <td style='width: 40%; text-align: right'>$potongan</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp; </td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>
            <table cellspacing='0' style='width: 100%;font-size: 10pt;'>
                <tr>
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
            <td style='width: 10%;'>&nbsp;</td>
            <td style='width: 20%; text-align: center'>   
				PENERIMA
				<br><br><br><br><br><br>
				<b> ( $rektor[nama_lengkap] ) </b>
				 
			</td>
            <td style='width: 40%;'>&nbsp;</td>
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