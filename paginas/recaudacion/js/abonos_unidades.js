

$('#form_filtro').on('submit', function filtrar(event){
	event.preventDefault();
	
	listarRegistros();
	
});


listarRegistros();

function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-spin ');
	
	return $.ajax({
		url: 'control/lista_abonos_unidades.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#dataTable").dataTable();
		$(".imprimir").click(imprimirTicket);
		$(".cancelar").click(confirmaCancelacion);
		dame_permiso();
		
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-spin');
		
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
	
	// alertify.prompt('Confirmación', '¿Deseas Cancelar?', cancelarRegistro , function(){});
	
	alertify.prompt()
  .setting({
    'reverseButtons': true,
		'labels' :{ok:"SI", cancel:'NO'},
    'title': "Cancelar Abono" ,
    'message': "Motivo de Cancelación" ,
    'onok':cancelarRegistro,
    'oncancel': function(){
			boton.prop('disabled', false);
			
		}
	}).show();
	
	
	function cancelarRegistro(evt, motivo){
		if(motivo == ''){
			console.log("Escribe un motivo");
			alertify.error("Escribe un motivo");
			return false;
			
		}
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		return $.ajax({
			url: "control/cancelar_abono.php",
			dataType:"JSON",
			data:{
				id_registro : id_registro,
				nombre_usuarios : $("#sesion_nombre_usuarios").text(),
				motivo : motivo
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

// function confirmaCancelarIngreso(event) {
// console.log("confirmaCancelarIngreso()")
// var boton = $(this);
// var id_registro = boton.data('id_registro');
// var fila = boton.closest('tr');

// boton.prop('disabled', true);
// icono = boton.find(".fa");


// alertify.confirm()
// .setting({
// 'reverseButtons': true,
// 'labels' :{ok:"SI", cancel:'NO'},
// 'title': "Confirmar" ,
// 'message': "¿Deseas cancelar esta Entrada?" ,
// 'onok':cancelarIngreso,
// 'oncancel': function(){
// boton.prop('disabled', false);

// }
// }).show();


// function cancelarIngreso(evnt,value) {
// $.ajax({
// url: 'consultas/cancelar_ingresos.php',
// method: 'POST',
// data:{ 
// "id_registro": id_registro,
// "motivo": value

// }
// }).done(function(respuesta){
// alertify.success("Cancelado"); 
// window.location.reload();

// }).fail(function(){
// alertify.error("Ocurrió un error");

// }).always(function(){
// icono.toggleClass("fa-times fa-spinner fa-spin");
// boton.prop('disabled', false);

// });
// }
// }
