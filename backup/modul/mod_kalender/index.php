<?php
defined('_FINDEX_') or die('Access Denied');
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :
	 require('view_kalender.php');
	break;
	case 'Event':	 
	 require('view_event.php');
	break;
	case 'Tahun':	 
	 require('view_tahun.php');
	break;
	case 'EditTahun':	 
	 require('form_tahun.php');
	break;
	case 'EditEvent':	 
	 require('form_event.php');
	break;
}