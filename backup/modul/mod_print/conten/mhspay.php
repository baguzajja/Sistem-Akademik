<?php
//Tampilkan
global $saiki;
$trans          = $_REQUEST['id'];
 $s = "SELECT TglSubmit,Transaksi,Debet,Kredit,AccID,Uraian,SubmitBy FROM transaksi WHERE TransID='$trans' AND Transaksi !='19'";
 $w = _query($s);
 $d = _fetch_array($w);
$NamaTransaksi  =strtoupper(GetName("jenistransaksi","id","$d[Transaksi]","Nama"));
$tglTransaksi   =tgl_indo($d['TglSubmit']);
$jum            =($d['Debet']==0)? $d['Kredit'] : $d['Debet'];
$jumlah         =digit($jum);
$mhsw           =GetFields('mahasiswa', 'NoReg', $d['AccID'], 'Nama,NIM,kode_jurusan');
$Prodi          =NamaProdi($mhsw['kode_jurusan']);
$terbilang      =ucwords(Terbilang($jum));

    // Variable..
  $dir          = 'media/files/dataprint/';
  $nama_file    =$trans.'.txt';
  $_lf      = "\n";
  $line     = str_pad('-', 80, '-') . $_lf;
  $jenjang  = ($mhsw['kode_jurusan']=='61101')? "S2":"S1";
    // HEADER
    $t= GetFields('identitas', 'Identitas_ID', $_SESSION['Identitas'], 'Nama_Identitas,KodeHukum,Email,Website,Alamat1,Telepon,Fax,Kota');
if($mhsw['kode_jurusan']=='61101'){
    $hdr  = str_pad($t['Nama_Identitas']." ( STIE YAPAN ) SURABAYA", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad($t['KodeHukum'], 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("PROGRAM PASCASARJANA (S-2) - MAGISTER MANAJEMEN", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("Kampus :  $t[Alamat1] Ph: $t[Telepon]", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad('-', 80, '-') . $_lf.$_lf;
}else{
    $hdr  = str_pad($t['Nama_Identitas']." ( STIE YAPAN ) SURABAYA", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad($t['KodeHukum'], 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("PROGRAM SARJANA (S-1) - ". $Prodi, 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad("Kampus :  $t[Alamat1] Ph: $t[Telepon]", 80, ' ', STR_PAD_BOTH) . $_lf;
    $hdr .= str_pad('-', 80, '-'). $_lf.$_lf;
}
  $hdr .= str_pad("NAMA & NIM", 15, ' ') .str_pad(":", 2, ' ') . str_pad(strtoupper($mhsw['Nama']).' - '.$mhsw['NIM'], 63, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= str_pad("PRODI", 15,' ') .str_pad(":", 2, ' ') . str_pad($Prodi, 63, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= str_pad("TANGGAL", 15,' ') .str_pad(":", 2, ' ',STR_PAD_BOTH ) . str_pad($tglTransaksi, 34, ' ', STR_PAD_RIGHT);
  $hdr .= str_pad("REFF", 10,' ',STR_PAD_LEFT) .str_pad(":", 2, ' ') .
  str_pad($trans, 17, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= $line;

  // TITLE
  $hdr .= str_pad('URAIAN', 70) .
          str_pad('JUMLAH', 10, ' ', STR_PAD_LEFT).$_lf;

  $hdr .= $line;

   $hdr .= str_pad($d['Uraian'], 65) .
            str_pad('Rp. '.$jumlah,15, ' ', STR_PAD_LEFT).$_lf;
     $hdr .=  $_lf;
     $hdr .=  $_lf;
     $hdr .=  $_lf;
     $hdr .=  $_lf;
     $hdr .=  $_lf;
     $hdr .=  $_lf;

  $hdr .= $line;
  $hdr .= str_pad("TERBILANG", 15,' ') .str_pad(":", 2, ' ') . str_pad(strtoupper($terbilang).'RUPIAH', 63, ' ', STR_PAD_RIGHT).$_lf;
  $hdr .= $line;
  
  $hdr .=str_pad("Surabaya , " .tgl_indo($saiki), 80,' ', STR_PAD_LEFT).$_lf;
  $hdr .=  $_lf;
  $hdr .=  $_lf;
  $hdr .=  $_lf;
  $hdr .=str_pad($_SESSION['Nama'], 80,' ', STR_PAD_LEFT).$_lf;
  
    $handle = fopen($dir.$nama_file,'w+');
    fwrite($handle, $hdr);
    fclose($handle);
?>

<div class="widget-header">	
    <h3>PEMBAYARAN MAHASISWA</h3>
        <div class="btn-group pull-right" style='margin-right: 5px;margin-top: 5px;'>	
        <a class='btn btn-inverse' onClick="printFile()"><i class='icon-print'></i>Cetak </a>
        <a class='btn btn-inverse' href="get-print-mhspay-<?php echo $trans;?>.html"><i class='icon-file'></i>Pdf </a>
        </div> 
</div> 
					
<div class="widget-content">
<div id="yapan">
<?php

if($mhsw['kode_jurusan']=='61101'){
	HeaderS2();
}else{
	HeaderS1($Prodi);
}

echo"<table style='width: 100%; font-size: 4mm; cellpadding:2px;color:#000000'>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <th colspan='4' style='width: 100%; text-align:center;'>$NamaTransaksi <br></th>
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
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$mhsw[Nama]</td>
            <td style='width: 10%;'>&nbsp;&nbsp;NIM</td>
            <td style='width: 40%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp; $mhsw[NIM]</td>
        </tr>
        <tr><th colspan='4' style='width: 100%;'>&nbsp;</th></tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;URAIAN</td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$d[Uraian]</td>
        </tr>
        <tr>
            <td style='width: 10%;'>&nbsp;&nbsp;JUMLAH</td>
            <td colspan='3' style='width: 90%;border-bottom: dotted 0.5mm #000000;'>: &nbsp;&nbsp;$terbilang Rupiah</td>
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
 