
var printService = new WebSocketPrinter();

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
	var id_pagos = $(this).data("id_pagos");
	
	$.ajax({
		url: '../taquilla/boletos_iv/imprimir_pago.php',
		
		data: {"id_pagos": id_pagos}
		}).done(function(respuesta){
		
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		alertify.success('Imprimiendo...');
		
		}).always(function(){
		
	});
	
	
}
