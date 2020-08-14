$(document).ready(function(){
	
	
	// hoy = Date.today().toString('d-MMM-yyyy')
	// console.log("hoy", hoy)
	listarRegistros(); 
	
	
	
	$('#form_filtro').on('submit',function(event){
		event.preventDefault();
		
		listarRegistros().done();
	});
	
	
	
	
});





function listarRegistros(){
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-pulse ');
	
	
	return $.ajax({
		url: 'control/lista_mutualidad.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$('#tabla_registros').html(respuesta);
		
		$(".imprimir").click(function(){
			
			let id_registro = $(this).data("id_registro");
			
			boton.prop('disabled',true);
			icono.toggleClass('fa-print fa-spinner fa-spin ');
			imprimirTicket(id_registro).always(function(){
				
				boton.prop('disabled',false);
				icono.toggleClass('fa-print fa-spinner fa-spin');
				
			});
		});
		
		$(".cancelar").click(confirmaCancelacion);
		
		
		
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-pulse');
		$("#dataTable").dataTable();
		
	});
}


function imprimirTicket(id_registro){
	console.log("imprimirTicket()");
	
	return $.ajax({
		url: "impresion/imprimir_mutualidad.php",
		data:{
			id_registro : id_registro
		}
		}).done(function (respuesta){
		if($("#silent_print").val() == "SI" ){
			
			printService.submit({
				'type': 'LABEL',
				'raw_content': respuesta
			});
			
			// $.ajax({
				// url: "http://localhost/imprimir_zitlalli.php",
				// method: "POST",
				// data:{
					// "texto" : respuesta
				// }
			// });
		}
		else{
			$("#ticket").html(respuesta); 
			window.print();
		}
	});
}


function confirmaCancelacion(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var id_registro = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.confirm()
	.setting({
		'reverseButtons': true,
		'labels' :{ok:"SI", cancel:'NO'},
		'title': "Confirmar" ,
		'message': "¿Desea Cancelar?" ,
		'onok':cancelarRegistro,
		'oncancel': function(){
			boton.prop('disabled', false);
			
		}
	}).show();
	
	
	
	function cancelarRegistro(){
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		return $.ajax({
			url: "control/cancelar_mutualidad.php",
			dataType:"JSON",
			data:{
				id_registro : id_registro
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

