<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{

	default :
		addJs('modul/mod_'.$mod.'/script.js'); 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
		addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
		
	break;
	case 'EditJadwal':	 
		addJs(AdminPath.'/js/plugins/timepicker/jquery.ui.timepicker.min.js'); ?>
<script type="text/javascript">
$(function () {
//  TimePicker
   $('#Jam_Mulai').timepicker ({});
   $('#Jam_Selesai').timepicker ({});
});
</script>
<?php
	break;
case 'EditUjian':	 
		addJs(AdminPath.'/js/plugins/timepicker/jquery.ui.timepicker.min.js'); ?>
<script type="text/javascript">
$(function () {
//  TimePicker
   $('#UTSMulai').timepicker ({});
   $('#UTSSelesai').timepicker ({}); 
	$('#UASSelesai').timepicker ({});
   $('#UASMulai').timepicker ({});
});
</script>
<?php
	break;

}
	
?>