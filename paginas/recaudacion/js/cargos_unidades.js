


$('#form_filtro').on('submit', function filtrar(event){
	event.preventDefault();
	
	listarRegistros();
	
});


listarRegistros();

function guardarCargo(event){
	if(event.which == 13){
		
		console.log("enter")
		
		let input = $(this);
		
		input.addClass('cargando');
		
		return $.ajax({
			url: 'control/guardar_cargos_unidades.php',
			method: "post",
			dataType: "JSON",
			data: {
				id_unidades : input.data("id_unidades"),
				fecha_cargos : input.data("fecha_cargos"),
				cargo : input.val(),
				tipo_cargo : input.data("tipo_cargo")
				
			}  
			}).done(function(respuesta){
			
			if(respuesta.estatus == "success"){
				alertify.success("Actualizado")
			}else{
					alertify.error("Error")
			}
			}).always(function(){
			
			input.removeClass('cargando');
			
		});
	}
	
	
}
function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'control/lista_cargos_unidades.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#tabla_registros").dataTable();
		$(".imprimir").click(imprimirTicket);
		$(".cancelar").click(confirmaCancelacion);
		$('.cargo').on('keyup', guardarCargo);
		
		
		}).always(function(){
		
		boton.prop('disabled',false); 
		icono.toggleClass('fa-search fa-spinner fa-pulse ');
		
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
		url: "impresion/imprimir_abono_unidades.php",
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
			url: "control/cancelar_abono.php",
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
