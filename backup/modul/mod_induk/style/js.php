<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default : ?>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
</script>
<?php 
	addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
break; 
}
