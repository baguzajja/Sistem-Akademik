<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default : ?>
<script type="text/javascript">
$(function () {

	$('#checkall').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
});
function MM_jumpMenu(targ,selObj,restore){
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}
</script>
<?php 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	break;
	case 'edit':	 
		addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
	break;

case 'maba':?>
<script type="text/javascript">
$(function () {
	$('#maba').dataTable( {
		sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		sPaginationType: "bootstrap",
		oLanguage: {
			"sLengthMenu": "_MENU_ per halaman"
		}
	});
	$('#checkall').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
});
</script>
<?php 	 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
break;
case 'add':
	addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
break;

}
	
?>