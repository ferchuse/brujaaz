$(document).ready(function(){
  

		
	$('#lista_pagos').on('click', '.imprimir', imprimirPago );
	
	$('#form_filtros').on('submit',listarPagos);
	
	
	$('#form_filtros').submit();
	
});


function listarPagos(event){
	event.preventDefault();
	console.log("listaPagos()");
	
	$.ajax({
		url: 'pagos_taquilla/lista_pagos.php',
		data: $("#form_filtros").serialize()
		}).done(function(respuesta){
		$("#lista_pagos").html(respuesta);
	});
}

function imprimirPago(){
	
	$.ajax({
		url: '../pagos_taquilla/imprimir_pago.php',
		
		data: {}
		}).done(function(respuesta){
		
		
		alertify.error('Ocurrio un error');
		
		}).always(function(){
		
	});
	
	
}
