<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{

	default :
		addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
	break;
	case 'Tahun':	 
		addJs('modul/mod_'.$mod.'/script.js'); 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	break;
	case 'Event':	 
		addJs('modul/mod_'.$mod.'/script.js'); 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	break;
	case 'EditEvent': ?>
<script type="text/javascript">
$(function () {
$('#colorpicker-component').colorpicker({ format: 'hex' });
});
</script>
<?php	 
		addJs(AdminPath.'/js/plugins/colorpicker/js/bootstrap-colorpicker.js');
	break;
}
?>