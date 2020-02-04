

var printService = new WebSocketPrinter();

var  $select_boletos = "";

$(document).ready(onLoad);

function onLoad(){
	
	listarCorridas();
	// listaBoletos();
	

	$("#form_filtros").on("submit", filtrarRegistros);
	
	$("#btn_test").on("click", imprimirPrueba);
	
	$("#btn_pagar").on("click", quienRecibe);
	
	$("#form_corridas input[name='num_eco']").on("keydown", buscarUnidad);
	// $("#form_corridas select[name='id_empresas']").on("keydown", function(event){
	
	// if(event.key == "Enter"){
	// $(this).closest("form").submit();
	
	// }
	// });
	
	
	
	$("#lista_boletos").on("click", ".cancelar", confirmaCancelacion);
	$("#lista_boletos").on("click", ".imprimir", function(){
		imprimirESCPOS($(this).data("id_registro"))
		
	});
	
	
	$("#lista_corridas").on("click", ".cancelar", confirmaCancelarCorrida);
	
	$("#lista_corridas").on("click", ".imprimir", function(){
		imprimirGuia($(this).data("id_registro"));
	});
	$("#lista_corridas").on("change", ".select", sumarCorridas);
	
		$("#lista_corridas").on("change", "#check_todos", selectTodos);
	
	$(".nuevo").on('click',function(){
		console.log("Nuevo")
		$("#form_corridas")[0].reset();
		$(".modal-title").text("Nueva Corrida");
		$("#modal_corridas").modal("show");
		
	});
	
	$('#form_corridas').on('submit', guardarCorrida);
	$('#lista_corridas').on('click', ".btn_venta", abrirTaquilla);
	
	
	$(".tipo_boleto").change(eligeBoleto );
	$(".cantidad").change(calculaImporte );
	
	
}

function selectTodos(evt){
	console.log("selectTodos()")
	$("#lista_corridas .select").prop("checked", $(this).prop("checked"));
	sumarCorridas();
}

function filtrarRegistros(evt){
	console.log("filtrarRegistros()")
	evt.preventDefault();
	
	listarCorridas();
	
}

function quienRecibe(evt){
	console.log("quienRecibe()")
	
	
	alertify.prompt()
  .setting({
    'reverseButtons': true,
		'labels' :{ok:"Aceptar", cancel:'Cancelar'},
    'title': "Quien Recibe" ,
    'message': "¿Quien Recibe el Pago?" ,
    'onok': guardarPago
	}).show();
	
	
	
}


function confirmaCancelarCorrida(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var id_registro = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.prompt()
  .setting({
    'reverseButtons': true,
		'labels' :{ok:"SI", cancel:'NO'},
		'title': "Cancelar Guia" ,
    'message': "Motivo de Cancelación" ,
    'onok':cancelarCorrida,
    'oncancel': function(){
			boton.prop('disabled', false);
			
		}
	}).show();
	
	
	function cancelarCorrida(evt, motivo){
		if(motivo == ''){
			console.log("Escribe un motivo");
			alertify.error("Escribe un motivo");
			return false;
			
		}
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		
		return $.ajax({
			url: "boletos_iv/cancelar_corrida.php",
			method:"POST",
			dataType:"JSON",
			data:{
				id_registro : id_registro,
				nombre_usuarios : $("#sesion_nombre_usuarios").text(),
				motivo : motivo
			}
			}).done(function (respuesta){
			if(respuesta.result == "success"){
				alertify.success("Cancelado");
				listarCorridas();
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

function confirmaCancelacion(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var id_registro = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.prompt()
  .setting({
    'reverseButtons': true,
		'labels' :{ok:"SI", cancel:'NO'},
		'title': "Cancelar Boleto" ,
    'message': "Motivo de Cancelación" ,
    'onok':cancelarBoleto,
    'oncancel': function(){
			boton.prop('disabled', false);
			
		}
	}).show();
	
	
	function cancelarBoleto(evt, motivo){
		if(motivo == ''){
			console.log("Escribe un motivo");
			alertify.error("Escribe un motivo");
			return false;
			
		}
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		
		return $.ajax({
			url: "boletos_iv/cancelar_boleto.php",
			method:"POST",
			dataType:"JSON",
			data:{
				id_registro : id_registro,
				nombre_usuarios : $("#sesion_nombre_usuarios").text(),
				motivo : motivo
			}
			}).done(function (respuesta){
			if(respuesta.result == "success"){
				alertify.success("Cancelado");
				listaBoletos();
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


function eligeBoleto(evt){
	console.log("eligeBoleto()")
	let $fila = $(this).closest(".row");
	let precio = $(this).find(":selected").data("precio");
	
	$fila.find(".precio").val(precio);
	
	calculaImporte(evt);
}

function calculaImporte(evnt){
	console.log("calculaImporte()", $(evnt.target));
	let $fila = $(evnt.target).closest(".row");
	let cantidad = Number($fila.find(".cantidad").val());
	let precio = Number($fila.find(".precio").val());
	let importe = cantidad * precio; 
	
	$fila.find(".importe").val(importe); 
	
}

function sumarCorridas(){
	console.log("sumarCorridas()");
	let total_pago = 0
	
	$(".select:checked").each(function(i, item){
		total_pago+= $(this).data("importe_corridas");
	})
	
	$("#total_pago").val(total_pago);
	
	$("#span_num_selected").text(total_pago);
	// $("#span_num_selected").text($(".select:checked").length);
	
	if($(".select:checked").length > 0 ){
		
		$("#btn_pagar").prop("disabled", false)
	}
	else{
		$("#btn_pagar").prop("disabled", true)
	}
	
}

function finalizarCorrida(){
	console.log("finalizarCorrida()");
	$("#imprimir_guia").prop("disabled", true);
	
	$.ajax({
		"url": "boletos_iv/finalizar_corrida.php",
		"method": "post",
		"data": {
			"id_corridas": $("#id_corridas").val()
		}
		}).done(function(){
		
		listarCorridas();
		//ir a tab corridas
		
		$("#pill_corridas").tab("show");
		
		imprimirGuia($("#id_corridas").val())
		
		}).fail(function(){
		
		
		}).always(function(){
		$("#imprimir_guia").prop("disabled", false);
		
	});
}

function imprimirGuia(id_corridas){
	console.log("imprimirGuia()", id_corridas);
	
	$.ajax({
		"url": "boletos_iv/imprimir_guias_escpos.php",
		"data": {
			"id_corridas": id_corridas
		}
		}).done(function(respuesta){
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		
	});
	
	
}



function abrirTaquilla(event){
	console.log("abrirTaquilla()");
	
	$("#id_corridas").val($(this).data("id_corridas"));
	$("#num_eco").val($(this).data("num_eco"));
	$("#pill_venta").tab("show");
	listaBoletos();
	
}
function guardarCorrida(event){
	console.log("guardarCorrida()");
	event.preventDefault();
	let form = $(this);
	let boton = form.find(':submit');
	let icono = boton.find('.fa');
	let datos = form.serialize();
	
	datos+="&id_usuarios="+ $("#id_usuarios").val();
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	$.ajax({
		url: 'boletos_iv/guardar_corridas.php',
		method: 'POST',
		dataType: 'JSON',
		data: datos
		}).done(function(respuesta){
		if(respuesta.estatus == 'success'){
			
			alertify.success('Se ha guardado correctamente');
			$('#modal_corridas').modal('hide');
			
			listarCorridas();
		}
		else{
			alertify.error('Ocurrio un error');
		}
		}).always(function(){
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse');
	});
}



function listaBoletos(){
	console.log("listaBoletos");
	$.ajax({
		"url" : "boletos_iv/lista_boletos.php",
		"data" :{"id_corridas": $("#id_corridas").val()}
		
		}).done(function (respuesta){
		$("#lista_boletos").html(respuesta);
		
		$("#imprimir_guia").on("click", finalizarCorrida);
		
		
	});
	
}

function listarCorridas(){
	console.log("listarCorridas()")
	
	let boton = $("#form_filtros").find(":submit");
	let icono = boton.find(".fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-search fa-spinner fa-spin");
	
	$.ajax({
		url: 'boletos_iv/lista_corridas.php',
		data: $("#form_filtros").serialize()
	}).done(function(respuesta){
		$("#lista_corridas").html(respuesta)
		
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-search fa-spinner fa-spin");
	});
}


$("#nueva_venta").click( nueva_venta);

function nueva_venta(){
	$("#resumen_boletos").html("");
	$("#importe_total").val(0);
	$(":checked").prop("checked", false);
	// $("#form_boletos")[0].reset();
	
}

$("#form_boletos").submit(guardarBoletos);


function guardarPago(evt, recibe){
	console.log("guardarPago()", recibe)
	
	let boton = $(this);
	let icono = boton.find('.fas');
	
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-dollar fa-spinner fa-pulse ');
	
	
	
	$.ajax({
		url: 'boletos_iv/guardar_pago.php',
		method: 'POST',
		dataType: 'JSON',
		data: $("#form_pagar_corridas").serialize() + "&recibe=" + recibe
		}).done(function(respuesta){
		if(respuesta.estatus_insert == 'success'){
			
			alertify.success('Se ha guardado correctamente');
			
			imprimirPago(respuesta.id_pagos);
			
			listarCorridas();
		}
		else{
			alertify.error(respuesta.mensaje);
		}
		}).always(function(){
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
	});
}

function guardarBoletos(event){
	event.preventDefault();
	let form = $(this);
	let boton = form.find(':submit');
	let icono = boton.find('.fa');
	
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	$.ajax({
		url: 'boletos_iv/guardar_boletos.php',
		method: 'POST',
		dataType: 'JSON',
		data: {
			"id_corridas" : $("#id_corridas").val(),
			"id_precio" : $("#id_precio").val(),
			"destino" : $("#id_precio").find(":selected").data("destino"),
			"cantidad" : $("#cantidad").val(),
			"precio" : $("#precio").val(),
			"id_usuarios" : $("#id_usuarios").val()
			
		}
		}).done(function(respuesta){
		if(respuesta.result == 'success'){
			
			alertify.success('Se ha guardado correctamente');
			// desactivaAsientosOcupados();
			$("#form_boletos")[0].reset();
			
			
			listaBoletos();
			imprimirESCPOS(respuesta.boletos);
		}
		else{
			alertify.error(respuesta.mensaje);
		}
		}).always(function(){
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
	});
}

function quitarBoleto(num_asiento){
	console.log("quitarBoleto", num_asiento);
	
	$("input[value='"+num_asiento+"']").closest("tr").remove();
	sumarImportes();
	
	if($("#resumen_boletos tr" ).length == 0){
		$("#form_boletos :submit").prop("disabled", true)
		
	}
}

function apartaBoletos(){
	console.log("apartaBoletos");
	
	$("input[type=checkbox]:checked").prop("disabled", true);
}


function agregarBoleto(num_asiento){
	
	console.log("num_asiento", num_asiento);
	console.log("select_boletos", $select_boletos);
	
	var boleto_html = 
	`<tr>
	<td class="w-10"><input class="form-control num_asiento" type="number" readonly name="num_asiento[]"  
	value='${num_asiento}'>
	</td>
	<td>
	${$select_boletos}
	</td>
	<td class="w-25"><input name="nombre_pasajero[]" required class="form-control nombre_pasajero" ></td>
	<td><input name="precio[]" class="precio form-control" readonly></td>
	<td>
	<button class="btn btn-danger quitar_boleto" type="button">
	<i class="fas fa-times"></i>
	</button>
	</td>
	
	</tr>`;
	$("#resumen_boletos").append(boleto_html);
	
	$(".quitar_boleto").click(function( evt){
		num_asiento = $(this).closest("tr").find(".num_asiento").val();
		$("#"+num_asiento).prop("checked", false);
		quitarBoleto(num_asiento);
	});
	$(".nombre_pasajero").keyup(function( evt){
		$(".nombre_pasajero").val($(this).val())
	});
	
	$(".tipo_boleto").change(function( evt){
		console.log("cambiar_tipo_boleto", evt)
		
		$(this).closest("tr").find(".precio").val($(this).find(":selected").data("precio"));
		
		sumarImportes();
	});
	
	sumarImportes();
}

function sumarImportes(){
	console.log("sumarImportes()")
	var importe_total = 0;
	$(".precio").each(function (index, item ){
		
		importe_total+= Number($(item).val());
	});
	
	$("#importe_total").val(importe_total)
	
}

function imprimirESCPOS(boletos){
	console.log("imprimirESCPOS()");
	var id_registro = $(this).data("id_registro");
	// var url = $(this).data("url");
	var boton = $(this); 
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "boletos_iv/imprimir_escpos.php" ,
		data:{
			boletos : boletos
		}
		}).done(function (respuesta){
		
		$("#ticket").html(respuesta); 
		
		
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}
function imprimirPrueba(){
	console.log("imprimirPago()");
	
	// var url = $(this).data("url");
	var boton = $(this); 
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "boletos_iv/imprimir_prueba.php" ,
		
		}).done(function (respuesta){
		
		// $("#ticket").html(respuesta); 
		
		
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}

function imprimirPago(id_pagos){
	console.log("imprimirPago()");
	var id_registro = $(this).data("id_registro");
	// var url = $(this).data("url");
	var boton = $(this); 
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "boletos_iv/imprimir_pago.php" ,
		data:{
			id_pagos : id_pagos
		}
		}).done(function (respuesta){
		
		// $("#ticket").html(respuesta); 
		
		
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}


function buscarUnidad(event){
	console.log("buscarUnidad()");
	console.log("eventkey()", event.key);
	
	let num_eco = $(event.target).val();
	$(event.target).addClass("buscando");
	if(event.key == "Enter"){
		console.log("enter()");
		$.ajax({
			url: "../catalogos/unidades/consultas/buscar_unidad.php" ,
			dataType: "JSON" ,
			data:{
				num_eco : num_eco
			}
			}).done(function (respuesta){
			if(respuesta.existe == "SI"){
				
				$("#form_corridas #id_empresas").val(respuesta.unidad.id_empresas);
				$("#form_corridas").submit();
				
			}
			else{
				
				alertify.error("Unidad no encontrada");
				$("#form_corridas input[name='num_eco']").focus();
			}
			
			}).always(function(){
			$(event.target).removeClass("buscando");
		});
	}
}


function imprimirTicket(boletos){
	console.log("imprimirTicket()");
	var id_registro = $(this).data("id_registro");
	// var url = $(this).data("url");
	var boton = $(this); 
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "boletos_iv/imprimir_boletos.php" ,
		data:{
			boletos : boletos
		}
		}).done(function (respuesta){
		
		$("#ticket").html(respuesta); 
		window.print();
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}
