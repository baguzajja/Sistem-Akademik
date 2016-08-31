<?php
defined('_FINDEX_') or die('Access Denied');

$id = $_REQUEST['id'];
$TglSkrang	= tgl_indo(date("Y m d"));
$r			= GetFields('mahasiswa', 'NIM',$id, '*');
$Nama		=strtoupper($r['Nama']);
$NamaProdi	=strtoupper(NamaProdi($r['kode_jurusan']));
$konsenta	=strtoupper(NamaKonsentrasi($r['Kurikulum_ID']));
$TempatLahir=strtoupper($r['TempatLahir']);
$TglLhr		=strtoupper(Tgl_indo($r['TanggalLahir']));
$TglLulus	=strtoupper(Tgl_indo($r['TanggalLulus']));
$JJg		=GetName("keuanganmhsw","KeuanganMhswID",$r['NIM'],"JenjangID");
$Jenjang	=($JJg=='S1')? 'STRATA SATU (S1)':'STRATA DUA (S2)';
if($r['kode_jurusan']=='62201'){
$Gelar="SARJANA EKONOMI ( SE )";
}elseif($r['kode_jurusan']=='61201'){
$Gelar="MANAJEMEN ( SE )";
}elseif($r['kode_jurusan']=='61101'){
$Gelar="MAGISTER MANAJEMEN ( SE )";
}
$Ketua		=GetName("karyawan","Jabatan",6,"nama_lengkap");
$Puket1		=GetName("karyawan","Jabatan",20,"nama_lengkap");
$burek		=do_crypt($id);
//Format NIM
$jum	=strlen($r['NIM']);
$aa		=$jum - 6;
$n1		=substr($r['NIM'],0,4);
$n2		=substr($r['NIM'],4,2);
$n3		=substr($r['NIM'],6,$aa);
$Fnim	=$n1.'.'.$n2.'.'.$n3;
//BarCode
require_once('librari/QRCode.php');
$qr =new QRCode;
$qr->nickName($burek); 
?>
<table style="width:100%">  
	<tr>
		<td style="width:90%;text-align:right;"><h4>NO : T11-10034/STY-01134/XII/2013</h4></td>
		<td style="width:10%"></td>
	</tr>
</table>                          
<table style="width:100%">                            
	<tr>
		<td style="width:15%"></td>
		<td style="width:70%">
<table style="width:100%">                            
	<tr>
		<td colspan="3" style="width:100%;text-align:center;">
		<br>
		<h2>DEPARTEMEN PENDIDIKAN NASIONAL</h2></td>
	</tr>                    
	<tr>
		<td colspan="3" style="width:100%;text-align:center;font-size: 30pt"><h1>SEKOLAH TINGGI ILMU EKONOMI YAPAN</h1></td>
	</tr>
	<tr>
		<td colspan="3" style="width:100%;text-align:center;font-size: 20pt">
		<h3>SK Mendiknas RI No.127/D/0/2001</h3>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="width:100%;text-align:center;font-size: 20pt">
		<h1>TERAKREDITASI : B</h1>
		<br>
		<br>
		<br>
		</td>
	</tr>
	<tr style="padding-bottom:10pt">
		<td colspan="3" style="width:100%;text-align:center;font-size: 20pt;font-weight: bold;cellpadding:15px;">
		<h4>( SK Nomor : 003/BAN-PT/Ak-XI/S1/XII/2008, Tanggal 19 Desember 2008 )</h4>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="width:100%;text-align:center;font-weight: bold;cellpadding:5px;">
		</td>
	</tr>
	<tr>
		<td colspan="3" style="width:100%;">
		
		<table style="width:100%;cellpadding:2px; font-size: 12px;">                            
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">Menyatakan bahwa</td>
				<td style="width:1%">:</td>
				<td style="width:39%;text-align:left;">
				<b><?php echo $Nama;?></b>
				</td>
				<td style="width:12%">Tahun Masuk </td>
				<td style="width:20%">: <b><?php echo $n1;?></b></td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">NIM</td>
				<td style="width:1%">:</td>
				<td style="width:39%;text-align:left;">
				<b><?php echo $Fnim;?></b>
				</td>
				<td style="width:12%">Tanggal Lulus </td>
				<td style="width:20%">: <b><?php echo $TglLulus;?></b></td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">Tempat dan Tanggal Lahir</td>
				<td style="width:1%">:</td>
				<td colspan="3" style="width:69%;text-align:left;">
				<b><?php echo $TempatLahir;?>, <?php echo $TglLhr;?></b>
				</td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">Program Pendidikan</td>
				<td style="width:1%">:</td>
				<td colspan="3" style="width:69%;text-align:left;">
				<b><?php echo $Jenjang;?></b>
				</td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">Jurusan</td>
				<td style="width:1%">:</td>
				<td colspan="3" style="width:69%;text-align:left;">
				<b><?php echo $NamaProdi;?></b>
				</td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td style="width:23%">Konsentrasi</td>
				<td style="width:1%">:</td>
				<td colspan="3" style="width:69%;text-align:left;">
				<b><?php echo $konsenta;?></b>
				</td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td colspan="4" style="width:95%;text-align:left;">
				<span></span>
				Ijasah ini diserahkan setelah yang bersangkutan memenuhi semua persyaratan yang ditentukan dan kepadanya dilimpahkan segala wewenang dan hak yang berhubungan dengan ijasah yang dimilikinya, serta berhak memakai gelar akademik :
				</td>
			</tr>
			<tr>
				<td style="width:5%"></td>
				<td colspan="4" style="width:90%;text-align:center;">
				<br>
				<p style="font-size: 20px;"> <?php echo $Gelar;?></p>
				
				</td>
				<td style="width:5%"></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
		
		</td>
		<td style="width:15%"></td>
	</tr>
</table>
<table style="width:100%">                            
	<tr>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		Di Tandasahkan Tanggal : <?php echo $TglSkrang;?>		</td>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		Surabaya, <?php echo $TglSkrang;?>		</td>
		<td style="width:14%"></td>
		<td style="width:10%"></td>
	</tr>
	<tr>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		Ketua,		</td>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		Pembantu Ketua I		</td>
		<td style="width:14%"></td>
		<td style="width:10%"></td>
	</tr>
	<tr>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		<br>
		<br>
		<br>
		<br>
		 <?php echo $Ketua;?> 		</td>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">
		<br>
		<br>
		<br>
		 <?php echo $Puket1;?> 		</td>
		<td rowspan="2" style="width:14%"><?php $qr->display(130);?></td>
		<td style="width:10%"></td>
	</tr>
	<tr>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">&nbsp; </td>
		<td style="width:8%"></td>
		<td style="width:30%;text-align:center;">&nbsp; </td>
		<td style="width:10%"></td>
	</tr>
</table>
<table style="width:100%;text-align:center;" id='linkPrint'>                            
	<tr>
		<td>
<a href="javascript:void()" class='btn btn-large' onClick="window.print();return false">
   <i class='icon-print'></i>Cetak </a></td>
	</tr>
</table>
