var printService = new WebSocketPrinter();


$(document).ready(function(){
	console.log("onLoad")
	listarRegistros();
	
	
	
	$('#form_filtro').on('submit', function filtrar(event){
		event.preventDefault();
		
		listarRegistros();
		
	});
	
}); 



function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'control/lista_tarjetas.php',
		data: $("#form_filtro").serialize() 
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#dataTable").dataTable();
		$(".imprimir").click(imprimirTicket);
		$(".cancelar").click(confirmaCancelacion);
		
		
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-pulse ');
		
	});
	
}



function confirmaCancelacion(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var id_registro = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.confirm('Confirmación', '¿Deseas Cancelar?', cancelarRegistro , function(){});
	
	
	function cancelarRegistro(){
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		return $.ajax({
			url: "control/cancelar_tarjeta.php",
			dataType:"JSON",
			data:{
				id_registro : id_registro,
				nombre_usuarios : $("#sesion_nombre_usuarios").text()
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


function imprimirTicket(event){
	var id_registro = $(this).data("id_registro") 
	var boton = $(this);
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	
	
	
	$.ajax({
		url: "impresion/"+url,
		data:{
			id_registro : id_registro 
		}
		}).done(function (respuesta){
		
		if($("#silent_print").val() == "SI" && url == "imprimir_tarjeta_esc.php" ){
			
			printService.submit({
				'type': 'LABEL',
				'raw_content': respuesta
			});
		}
		else{
			$("#ticket").html(respuesta); 
			setTimeout(function(){
				window.print();
			},
			500
			)
			
		}
		
		
		
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}

