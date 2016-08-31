<?php  
session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../librari/koneksi.php";
include "../librari/lib.php";

function Defeksport(){ }

switch($_GET[PHPIdSession]){

default:
Defeksport();
break;

case "Database":
	$dir = '../backups/';
	$file = $dir.$_GET['id'];
	
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
	} 
	else 
	{
lompat_ke("go-filenotfound.html");
	}
break;

case "fileContoh":
	$dir = '../system/file/';
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
	} 
	else 
	{
lompat_ke("go-filenotfound.html",$file);
	}
break;

case "TransksiBaa":
$bhtml="<table width='130'  border='1'>

<tr>

<td>No</td>

 <td>Nama Buah</td>

 </tr>

           <tr>

               <td>1</td>

               <td>Apel</td>

           </tr>

             <tr>

         <td>2</td>

            <td>Jeruk</td>

            </tr>

 </table>";
$html = "<html><head></head><body>".$bhtml."</body></html>";
header("Cache-control: private");
header("Content-disposition: attachment; filename=coba.doc");
header("Content-type: application/msword");
echo $html;
break;
}     
        
?>
