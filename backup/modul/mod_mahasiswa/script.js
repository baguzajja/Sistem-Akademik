$(function () {

	$('#checkall').click(function(){
		$(this).parents('form:eq(0)').find(':checkbox').attr('checked', this.checked);
	});
		
	
});
function MM_jumpMenu(targ,selObj,restore){
 eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
if (restore) selObj.selectedIndex=0;
}

