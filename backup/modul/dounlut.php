<?php  
defined('_FINDEX_') or die('Access Denied');
if(!empty($_SESSION['yapane']) AND !empty($_SESSION['Identitas'])){
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act){
	default:
	break;

case "Database":
	$dir = 'media/files/backups/';
	$file = $dir.$_GET['md'];
	if (file_exists($file))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	CatatLog($_SESSION[Nama],'Download BackUp','Data Back Berhasil di Download');
	} else {
	select_themes('blank','File Not Found','Maaf, Data Backup Tidak Tersedia atau sudah terhapus');
	CatatLog($_SESSION[Nama],'Download BackUp','Gagal..Data Backup Tidak Tersedia');
	}
break;
//Download Log
case "log":
	$file = 'media/files/log.txt';
	if (file_exists($file))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	CatatLog($_SESSION[Nama],'Download Log','Data Log Berhasil di Download');
	} else {
	select_themes('blank','File Not Found','Maaf, Data Log Tidak Tersedia atau sudah terhapus');
	CatatLog($_SESSION[Nama],'Download Log','Gagal..Data Log Tidak Tersedia');
	}
break;
case "fileContoh":
	$dir = 'media/files/file/';
	$id = $_GET['id'];
	$ext = '.xls';
	$file = $dir.$id.$ext;
	if (file_exists($file))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	CatatLog($_SESSION[Nama],'Download BackUp','Data Back Berhasil di Download');
	} else  {
	select_themes('blank','File Not Found','Maaf, File Tidak Tersedia atau sudah terhapus');
	CatatLog($_SESSION[Nama],'Download BackUp','Gagal..Data Backup Tidak Tersedia');
	}

break;

case "TransksiBaa":
$bhtml="";
$html = "<html><head></head><body>".$bhtml."</body></html>";
header("Cache-control: private");
header("Content-disposition: attachment; filename=coba.doc");
header("Content-type: application/msword");
echo $html;
break;
}     
}else{
htmlRedirect('./');
}          
?>
