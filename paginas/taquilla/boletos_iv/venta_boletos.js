

var  $select_boletos = "";

$(document).ready(onLoad);

function onLoad(){
	
	listaBoletos();
	
	
	listarCorridas();
	
	$("#lista_boletos").on("click", ".imprimir", function(){
		imprimirTicket([$(this.data("id_registro"))])
		
	});
	
	$("#lista_corridas").on("click", ".imprimir", function(){
		imprimirGuia([$(this.data("id_corridas"))])
		
	});
	
	
	
	$(".nuevo").on('click',function(){
		console.log("Nuevo")
		$("#form_corridas")[0].reset();
		$(".modal-title").text("Nueva Corrida");
		$("#modal_corridas").modal("show");
		
	});
	
	$('#form_corridas').on('submit', guardarCorrida);
	$('#lista_corridas').on('click', ".btn_venta", abrirTaquilla);
	
	
	$(".tipo_boleto").change( function eligeBoleto( evt){
		console.log("eligeBoleto()")
		
		$(this).closest(".row").find(".precio").val($(this).find(":selected").data("precio"));
		
		sumarImportes();
	});
	
	
	
	
	
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
console.log("imprimirGuia()");

$.ajax({
	"url": "boletos_iv/imprimir_guias.php",
	"data": {
		"id_corridas": id_corridas
	}
	}).done(function(respuesta){
	
	$("#ticket").html(respuesta); 
	window.print();
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
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
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
	$.ajax({
		url: 'boletos_iv/lista_corridas.php',
		data:{}
	}).done(
	function(respuesta){
		$("#lista_corridas").html(respuesta)
		// $('.imprimir').on('click',imprimirTicket)
		// $(".cancelar").click(confirmaCancelacion);
		
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
			"precio" : $("#precio").val(),
			"id_usuarios" : $("#id_usuarios").val()
			
		}
		}).done(function(respuesta){
		if(respuesta.result == 'success'){
			
			alertify.success('Se ha guardado correctamente');
			// desactivaAsientosOcupados();
			$("#form_boletos")[0].reset();
			
			
			listaBoletos();
			imprimirTicket(respuesta.boletos);
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


