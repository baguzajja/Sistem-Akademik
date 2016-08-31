<?php 
defined('_FINDEX_') or die('Access Denied');
$mod=$_REQUEST['page'];
$act=(isset($_REQUEST['act']))? $_REQUEST['act']:null;
switch($act)
{
	default :?>
<script type="text/javascript">
$(function () {

	$('#tablef').dataTable( {
		sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		sPaginationType: "bootstrap",
		oLanguage: {
			"sLengthMenu": "_MENU_ per halaman"
		}
	});

	$('#checkall').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
		
	$("#form").submit(function(e){
		if (!confirm("Anda yakin akan menghapus item terpilih ? DATA YANG TERHAPUS TIDAK DAPAT DIKEMBALIKAN."))
			{
				e.preventDefault();
				return;
			} 
	});
});
</script>
<?php 
		addJs(AdminPath.'/js/plugins/datatables/jquery.dataTables.js');
		addJs(AdminPath.'/js/plugins/datatables/DT_bootstrap.js');
		addJs(AdminPath.'/js/plugins/responsive-tables/responsive-tables.js');
	break;
	case 'edit':	
	addJs(AdminPath.'/js/redactor.min.js'); ?>
<script type="text/javascript">
$(function () {
//  Wysiwyg
    $('#isi').redactor();
});
</script>
<?php break; 
}