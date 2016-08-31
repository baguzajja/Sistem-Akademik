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