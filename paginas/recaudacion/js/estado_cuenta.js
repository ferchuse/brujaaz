$(document).ready(function(){
	
	// listarRegistros();
	
	
	$('#imprimir_tarjeta').on('click', imprimirTicket);
	$('#imprimir_abonos').on('click', imprimirTicket);
	
	$('.importe').on('keyup',sumarImportes);
	
	$('form').on('keypress',function( event){
		
		
	});
	
	$('.nuevo').on('click',function(){
		$('#form_edicion')[0].reset();
		$('.modal-title').text('Nueva Tarjeta');
		$('#modal_edicion').modal('show');
	});
	
	
	
	
	
	
	
	$('#form_filtro').on('submit', function filtrar(event){
		event.preventDefault();
		
		listarRegistros();
		
	});
	
	
});





function sumarImportes(){
	total_boletos = 0;
	total_recaudado = 0;
	var efectivo = Number($("#efectivo").val());
	
	$(".importe").each(function(index, element){
		
		total_boletos+= Number($(element).val());
		
	});
	
	
	$("#importe_tijera").val(total_boletos);
	$("#total_boletos").val(total_boletos); 
	$("#total_recaudado").val(total_boletos + efectivo);
	
}


function listarRegistros(){
	console.log("listarRegistros()");
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	
	
	$.ajax({
		url: 'control/lista_estado_cuenta.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		$("#tabla_registros").html(respuesta);
		
		}).always(function(){
		
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		
	});
	
}


function imprimirTicket(event){
	console.log("imprimirTicket()");
	var id_registro = $(this).data("id_registro");
	var url = $(this).data("url");
	var boton = $(this);
	var icono = boton.find(".fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "impresion/"+ url,
		data:{
			id_registro : id_registro
		}
		}).done(function (respuesta){
		
		$("#ticket").html(respuesta); 
		window.print();
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}


