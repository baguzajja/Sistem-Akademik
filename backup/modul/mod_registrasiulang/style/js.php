<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
default :  ?>
<script type="text/javascript">
$(function () {

	$('#Registered').dataTable( {
		sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		sPaginationType: "bootstrap",
		oLanguage: {
			"sLengthMenu": "_MENU_ per halaman"
		}
	});
	$('#UnRegistered').dataTable( {
		sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		sPaginationType: "bootstrap",
		oLanguage: {
			"sLengthMenu": "_MENU_ per halaman"
		}
	});

	$('#checkall').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
	$('#checkalls').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});

});
</script>
<?php 
	addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
	addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
	addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	addJs(AdminPath.'/js/plugins/lightbox/jquery.lightbox.js');
break; 
}
