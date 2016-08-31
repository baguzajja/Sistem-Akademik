<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;

addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
?>
<script type="text/javascript">
$(function () {
	$('#baru').dataTable( {
		sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		sPaginationType: "bootstrap",
		oLanguage: {
			"sLengthMenu": "_MENU_ per halaman"
		}
	});
});
<!--
function MM_jumpMenu(targ,selObj,restore){// v3.0
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
//-->
</script>