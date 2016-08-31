$(function () {
	$("#formD").submit(function(e){
		if (!confirm("Anda yakin akan menghapus item terpilih ? DATA YANG TERHAPUS TIDAK DAPAT DIKEMBALIKAN."))
			{
				e.preventDefault();
				return;
			} 
	});
});