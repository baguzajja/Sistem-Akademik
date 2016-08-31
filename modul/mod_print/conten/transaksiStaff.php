<?php
//Tampilkan
global $saiki;
$trans          = $_REQUEST['id'];
$d              = GetFields('transaksihnrstaff', 'Notrans', $trans, 'TglBayar,gajipokok,hari,uangmakan,SubmitBy,jam,uanglembur,potongan,Total,userid');
$tglTransaksi   =tgl_indo($d['TglBayar']);
$gajipokok      =digit($d['gajipokok']);
$uangmakan      =digit($d['hari'] * $d['uangmakan']);
$Uanglembur     =digit($d['jam'] * $d['uanglembur']);
$potongan       =digit($d['potongan']);
$Total          =digit($d['Total']);
$Um             =digit($d['uangmakan']);
$Ul             =digit($d['uanglembur']);

$staff = GetFields('karyawan', 'id', $d['userid'], 'Jabatan,nama_lengkap');
$NamaJabatan=JabatanStaff($staff['Jabatan']);
?>
<div class="widget-header">	
    <h3>PEMBAYARAN GAJI KARYAWAN </h3>
        <input id="printer" type="hidden" value="<?php echo siteConfig('printer_default');?>">
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class="btn btn-inverse" onClick="printHTML5Page()"><i class='icon-print'></i>Cetak </a>
        <a class="btn btn-inverse" href="get-print-transaksiStaff-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 		
<div class="widget-content">
<div id="yapan">
<?php
HeaderKops();
echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>PEMBAYARAN GAJI KARYAWAN</th>
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
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$staff[nama_lengkap]</td>
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
                        <td style='width: 50%; text-align: left' >Uang Makan</td>
                         <td style='width: 10%; text-align: left' >$d[hari] X $Um</td>
                        <td style='width: 40%; text-align: right'>$uangmakan</td>
                    </tr>
                    <tr style='border-bottom: dotted 0.5mm #000000;'>
                        <td style='width: 50%; text-align: left' >Uang Lembur</td>
                         <td style='width: 10%; text-align: left' >$d[jam] X $Ul</td>
                        <td style='width: 40%; text-align: right'>$Uanglembur</td>
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
				<b> ( $staff[nama_lengkap] ) </b>
				 
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