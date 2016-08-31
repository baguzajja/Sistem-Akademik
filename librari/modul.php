<?php
defined('_FINDEX_') or die('Access Denied');

//get variable $page from parameter url -> page
if(isset($_REQUEST['page']))
$app = $_REQUEST['page']; 

if(!empty($app)){
	if(!file_exists("modul/mod_$app/index.php"))
	{	
		function loadAdminApps() {
			$page=$_REQUEST['page']; 
			baseApps($page);
			CatatLog($_SESSION[Nama],'Akses Modul','Modul Tidak Tersedia');
		}
		function loadJudul() {
			$judul="NOT FOUND";
			return $judul;
		}
		function loadAdminJs() {}
		function loadAdminCss() {}
	}
	else {			

		function loadAdminApps() {
			$page=$_REQUEST['page']; 
			baseSystem($page);
			baseApps($page);
			$judulModul= oneQuery('modul','url',"'$page'",'judul');
			CatatLog($_SESSION['Nama'],'Akses Modul',$judulModul);
		}
		function loadAdminJs() {
			$page=$_REQUEST['page']; 
			baseAppJs($page);
		}
		function loadAdminCss() {
			$page=$_REQUEST['page']; 
			baseAppCss($page);
		}
		function loadJudul() {
			$page=$_REQUEST['page']; 
			$judul=strtoupper(JudulSitus($page));
		return $judul;
		}
	}
}
else {
	function loadAdminApps() {
		require(AdminPath."/dasboard.php");	
		CatatLog($_SESSION[Nama],'Akses Modul','Dasboard');
	}
	function loadJudul() {
		$judul="HOME ";
		return $judul;
	}
	function loadAdminJs() {}
	function loadAdminCss() {}
}

?>