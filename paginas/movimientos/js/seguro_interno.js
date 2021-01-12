$(document).ready( function(){ 
	
	listarRegistros();
	
	$('#form_filtro').on('submit', function filtrar(event){
		event.preventDefault();
		
		listarRegistros();
		
	});
	
	
	$('#nuevo').on('click',function(){
		$('#form_salida')[0].reset();
		$('.modal-title').text('Nuevo Recibo');
		$('#modal_salida').modal('show');
	}); 
	
	$('#form_salida').on('submit', guardarRegistro );
	
	
});





function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fa');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'consultas/lista_seguro_interno.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#dataTable").dataTable();
		$(".imprimir").click(imprimirTicket);
		$(".cancelar").click(confirmaCancelacion);
		
		
		}).always(function(){  
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-pulse fa-fw');
		
	});
}



function guardarRegistro(event){
	event.preventDefault();
	let form = $(this);
	let boton = form.find(':submit');
	let icono = boton.find('.fa');
	let datos = form.serializeArray();
	
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	$.ajax({
		url: 'consultas/guardar_seguro_interno.php',
		method: 'POST',
		dataType: 'JSON',
		data: datos
		}).done(function(respuesta){
		if(respuesta.estatus == 'success'){
			alertify.success('Se ha agregado correctamente');
			$('#modal_salida').modal('hide');
			listarRegistros();
		}
		else{
			alertify.error('Ocurrio un error');
		}
		}).always(function(){
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse');
	});
}





function imprimirTicket(event){
	var folio = $(this).data("id_registro");
	var boton = $(this);
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "impresion/imprimir_seguro_interno.php",
		data:{
			folio : folio
		}
		}).done(function (respuesta){
		
		$("#impresion").html(respuesta);
		window.print();
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}			





function confirmaCancelacion(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var folio = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.confirm('Confirmación', '¿Deseas Cancelar?', cancelarRegistro , function(){});
	
	
	function cancelarRegistro(){
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		return $.ajax({ 
			url: "consultas/cancelar_seguro_interno.php",
			dataType:"JSON",
			data:{
				folio : folio
			}
			}).done(function (respuesta){
			if(respuesta.result == "success"){
				alertify.success("Cancelado");
				listarRegistros();
			}
			else{
				alertify.error(respuesta.result);
			}
			
			}).always(function(){
			boton.prop("disabled", false);
			icono.toggleClass("fa-times fa-spinner fa-spin");
			
		});
	}
}		