$("input[type=checkbox]").change(function( evt){
	console.log("modal boleto", evt)
	if($(this).prop("checked")){
		
		$("#modal_boleto").modal("show")
	}
	
})