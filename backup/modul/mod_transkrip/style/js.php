<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default : 
	addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
break; 
}
