<?php 
session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../librari/koneksi.php";
include "../librari/library.php";
include "../librari/fungsi_combobox.php";
include "../librari/lib.php";
if (empty($_SESSION[yapane]) AND empty($_SESSION[passwordte])){
	lompat_ke('../');
} else {
$page=$_GET[page];
CatatLog($_SESSION[Nama],$_GET[PHPIdSession]);
$judul=strtoupper(JudulSitus($page));
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
	<title><?php echo "$judul"; ?> - STIE YAPAN SURABAYA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Akademik 2013">
    <meta name="author" content="Achtanaputra.com">
	<link rel="shortcut icon" href="../favicon.ico" />
    <link href="../yapan/css/bootstrap.min.css" rel="stylesheet">
    <link href="../yapan/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="../yapan/css/yapan-bootstrap.min.css" rel="stylesheet">
    <link href="../yapan/css/yapan-bootstrap-responsive.min.css" rel="stylesheet">
    <link href="../yapan/css/font-awesome.css" rel="stylesheet">
	<link href='../yapan/css/font.css' rel='stylesheet' type='text/css'>
<link href="http://fonts.googleapis.com/css?family=Pontano+Sans" rel='stylesheet' type='text/css'> 
    <link href="../yapan/css/admin.css" rel="stylesheet">
  <link href="../yapan/css/redactor.css" rel="stylesheet">
	<link href="../yapan/css/jquery.fileupload-ui.css" rel="stylesheet">
<link rel="stylesheet" href="../yapan/js/colorbox/colorbox.css" type="text/css" media="screen" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <link rel="stylesheet" href="../yapan/js/bootstrap-colorpicker/css/colorpicker.css">
	<link href="../yapan/style/style.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="./img/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="./img/ico/apple-touch-icon-57-precomposed.png">
  </head>

<body>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="panel">
<?php 
function defdetail(){}
function Gbpp(){
$id = $_REQUEST['id'];
$w = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
echo"<div class='panel-header'>GARIS - GARIS BESAR PROGRAM PERKULIAHAN</div>
	<div class='panel-content'>
		<p>$w[gbpp]</p>
	</div>";
}
function Sap(){
$id = $_REQUEST['id'];
$w = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
echo"<div class='panel-header'>SATUAN ACARA PERKULIAHAN</div>
	<div class='panel-content'>
		<p>$w[sap]</p>
	</div>";
}
function Mtk(){
$id = $_REQUEST['id'];
$w = GetFields('matakuliah', 'Matakuliah_ID', $id, '*');
$PRODI=NamaProdi($w[Jurusan_ID]);
$KelompokMtk=KelompokMtk($w[KelompokMtk_ID]);
$NamaKonsentrasi=strtoupper(GetName("kurikulum","Kurikulum_ID",$w[Kurikulum_ID],"Nama"));
$NamaKurikulum=strtoupper(GetName("jeniskurikulum","JenisKurikulum_ID",$w[JenisKurikulum_ID],"Nama"));
$penanggungjwb=strtoupper(GetName("dosen","dosen_ID",$w[Penanggungjawab],"nama_lengkap"));
$sttus = ($w['Aktif'] == 'Y')? '<i class="icon-ok green"></i> AKTIF' : '<i class="icon-remove red"></i> NON-AKTIF';
echo"<div class='panel-header'><i class='icon-sign-blank'></i> MATAKULIAH $w[Nama_matakuliah]</div>
	<div class='panel-content panel-tables'>
		<table class='table table-bordered table-striped'>     
		<thead>
			<tr>                             
				<th width='50%'>Matakuliah</th>
				<th>$w[Nama_matakuliah]</th>                             
			</tr>
		</thead>                       
		<tbody>
			<tr>
				<td class='description'>Program Studi</td>
				<td class='value'><span>$PRODI</span></td>
			</tr>
			<tr>
				<td class='description'>Kode Matakuliah</td>
				<td class='value'><span>$w[Kode_mtk]</span></td>
			</tr>
			<tr>
				<td class='description'>Kelompok Matakuliah</td>
				<td class='value'><span>$KelompokMtk</span></td>
			</tr>
			<tr>
				<td class='description'>Kurikulum</td>
				<td class='value'><span>$NamaKurikulum</span></td>
			</tr>
			<tr>
				<td class='description'>Konsentrasi</td>
				<td class='value'><span>$NamaKonsentrasi</span></td>
			</tr>
			<tr>
				<td class='description'>Di Semester</td>
				<td class='value'><span>$w[Semester]</span></td>
			</tr>  
			<tr>
				<td class='description'>Jumlah SKS</td>
				<td class='value'><span>$w[SKS]</span></td>
			</tr>
			<tr>
				<td class='description'>Penanggung Jawab</td>
				<td class='value'><span>$penanggungjwb</span></td>
			</tr>
			<tr>
				<td class='description'>Status Matakuliah</td>
				<td class='value'><span>$sttus</span></td>
			</tr>
			<tr>
				<td class='description'>GBPP</td>
				<td class='value'><span>$w[gbpp]</span></td>
			</tr>
			<tr>
				<td class='description'>SAP</td>
				<td class='value'><span>$w[sap]</span></td>
			</tr>   
			             
		</tbody>
	</table>
</div>";
}
function DetailBukuInduk(){
$id = $_REQUEST['id'];
buka("KETERANGAN TENTANG DIRI MAHASISWA ( BUKU INDUK MAHASISWA )");
	$sql="SELECT * FROM mahasiswa WHERE NIM='$id'";
	$qry= _query($sql) or die ();
	$r=_fetch_array($qry);
	if (empty($r['Foto'])){ $foto = "file/no-foto.jpg"; }else{ $foto = "$r[Foto]"; }
	$NamaProdi=GetName("jurusan","kode_jurusan",$r[kode_jurusan],"nama_jurusan");
	$NamaKonsentrasi=NamaKonsentrasi($r['IDProg']);
	$Agama=NamaAgama($r['Agama']);
	$TglLhr=Tgl_indo($r['TanggalLahir']);
		if ($r[Kelamin]=='L'){
		$gender="Laki - Laki";
		}else{
		$gender="Perempuan";
		}	
	$prodi = GetFields('jurusan', 'kode_jurusan', $r[kode_jurusan], '*');
	echo"<table class='table table-striped'><thead>
	<tr><th colspan=4> DETAIL MAHASISWA</th></tr>                               
	<tr>
	<td>NAMA LENGKAP</td>
	<td>:</td>
	<td><strong> $r[Nama]</strong></td>
	<td rowspan=3><img alt='$r[nama_lengkap]' src='$foto' width='150px' class='gambar pull-right'></td></tr>                    
	<tr>
	<td>NIM</td>
	<td>:</td>
	<td><strong>$r[NIM] </strong></td>
	</tr>
	<tr><td>PROGRAM STUDI </td><td>:</td><td><strong> $NamaProdi</strong></td></tr>
	<tr><td></td><td></td><td></td><td></td></tr>
	
	</thead></table>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='panel-content'>
				<table class='table'>
					<thead>
						<tr><th colspan='2'>DATA PRIBADI</th></tr>
					</thead>
					<tbody>
                            <tr>
							<td width='30%'><i class='icon-file'></i> Tempat & Tanggal Lahir</td>
							<td> : &nbsp;&nbsp;&nbsp; $r[TempatLahir], $TglLhr</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Agama</td>
							<td> : &nbsp;&nbsp;&nbsp;$Agama</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> Alamat </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[Alamat], RT: $r[RT] - RW: $r[RW]. $r[KodePos]. $r[Kota] ($r[Propinsi]-$r[Negara])</td> 	
							</tr>";
if($prodi[jenjang]=='S1'){
					echo"<tr>
							<td><i class='icon-file'></i> Nama SMK / SMA / MA </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[AsalSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>SURAT TANDA TAMAT BELAJAR / IJAZAH</b></td></tr>";
}else{
echo"<tr>
							<td><i class='icon-file'></i> Nama Perguruan Tinggi </td>
							<td> : &nbsp;&nbsp;&nbsp;$r[AsalSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>IJAZAH S1 </b></td></tr>";

}
	$Tahun=GetName("tahun","Tahun_ID",$r[Angkatan],"Nama");
	$NamaTahun=explode(" ",$Tahun);
echo"<tr>
							<td><i class='icon-file'></i> TAHUN</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[TahunLulus]</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> NOMOR</td>
							<td> : &nbsp;&nbsp;&nbsp;$r[NilaiSekolah]</td>
							</tr>
							<tr><td colspan='2'><b>DI TERIMA DI STIE YAPAN </b></td></tr>
							<tr>
							<td><i class='icon-file'></i> PROGRAM STUDI</td>
							<td> : &nbsp;&nbsp;&nbsp;$NamaProdi</td>
							</tr>
							<tr>
							<td><i class='icon-file'></i> TAHUN</td>
							<td> : &nbsp;&nbsp;&nbsp; $NamaTahun[2]</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>";
tutup();
}
switch($_GET[aksi]){

  default:
	defdetail();
  break;

case "DetailBukuInduk":
	DetailBukuInduk();
  break;

case "Gbpp":
	Gbpp();
  break;

case "Sap":
	Sap();
  break;
case "Mtk":
	Mtk();
  break;
}
?>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="../yapan/js/jquery-1.7.2.min.js"></script>
<script src="../yapan/js/jquery.flot.js"></script>
<script src="../yapan/js/jquery.flot.pie.js"></script>
<script src="../yapan/js/jquery.flot.resize.js"></script>
<script src="../yapan/js/jquery.sparkline.min.js"></script>
<script src="../yapan/js/yapan.js"></script>
<script src="../yapan/js/jquery.dataTables.min.js"></script>
<script src="../yapan/js/dataTables.bootstrap.js"></script>
<script src="../yapan/js/bootstrap.js"></script>
<script src="../yapan/js/redactor.min.js"></script>
<script src="../yapan/js/jquery.validate.min.js"></script>
<script src="../yapan/js/bootstrap-fileupload.js"></script>
<script src="../yapan/js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="../yapan/js/colorbox/jquery.colorbox.js"></script>
</body>
</html>
<?php } ?>
