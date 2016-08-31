$(function () {

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