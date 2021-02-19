
// var printService = new WebSocketPrinter();

$(document).ready(function(){
	
	$('#form_filtros').on('submit', listarRegistros);
	
	
	
	
	$("#btn_modal").on('click',function(){
		$("#form_modal")[0].reset();
		$(".modal-title").text("Nuevo Desglose de Dinero");
		$("#modal_modal").modal("show");
		
		cadena_numeros();
	});
	
	//==========BOTON CUBRIR Y DESCUBRIR LOS PRECIOS DE DOCUMENTO DE BOLESTOS=======================
	$('#btn_boletos').on('click',function(){
		$('#datos_boleto').toggle();//Alternar entre ocultar y mostrar para todos los elementos
	});
	
	
	$('#btn_taquilla').on('click',function(){
		$('#imp_cadena').toggle();//Alternar entre ocultar y mostrar para todos los elementos
	});
	
	$('#form_modal').on('submit', guardarRegistro);
	$('#form_filtros').submit();
	
	
});

function guardarRegistro(event){
	console.log("guardarRegistro")
	event.preventDefault();
	let form = $(this);
	let boton = form.find(':submit');
	let icono = boton.find('.fa');
	let datos = form.serializeArray();
	datos.push({"name": "id_usuarios", "value": $("#sesion_id_usuarios").val()})
	datos.push({"name": "id_administrador", "value": $("#sesion_id_administrador").val()})
	let importe_desglose = $('#importe_desglose').val();
	console.log("importe_desglose", importe_desglose);
	console.log("datos", datos);
	if(importe_desglose != ""){
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
		
		$.ajax({
			url: 'control/fila_insert.php',
			method: 'POST',
			dataType: 'JSON',
			data:{
				tabla: 'desglose_dinero',
				valores: datos
			}
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha agregado correctamente');
				$('#modal_modal').modal('hide');
				$('#form_filtros').submit();
			}
			else{
				alertify.error('Ocurrio un error');
			}
			}).always(function(){ 
			boton.prop('disabled',false);
			icono.toggleClass('fa-save fa-spinner fa-pulse');
		});
	}
	else{
		alertify.error("Ingrese alguna cantidad");
		
		
	}
}

function listarRegistros(ev){
	ev.preventDefault();
	console.log("listarRegistros()");
	
	$.ajax({
		url: 'control/lista_desglose_dinero.php',
		data: $("#form_filtros").serialize()
		}).done(function termina_listar(respuesta){
		
		$('#registros').html(respuesta);
		
		$('.imprimir').click(imprimirTicket);
		
		
	});
}





function cadena_numeros (){
	let cantidad = [1000,500,200,100,50,20,10,5,2,1,.5,.2,.1];
	let contenedor = "";
	cantidad.forEach(function(index,element){
		contenedor += `
		<div class="form-row">
		<div class="form-group col-md-6">
		<div class="input-group">
		<div class="input-group-prepend">
		<div class="input-group-text"><i class="fas fa-dollar-sign">${index}</i></div>
		</div>
		<input type="number" class="form-control cantidad" min="0" name="${index}" data-denomi="${index}" val="">
		</div>
		</div>
		<div class="form-group col-md-6">
		<div class="input-group">
		<input type="number" min="0" class="form-control importe" value="0" readOnly>
		</div>
		</div>
		</div>
		`;
	});
	$('#imp_cadena').html(contenedor);
	
	//=========TAQUILLA ============================
	$('.cantidad').on('keyup', function(){
		//console.log("calculaImporte()");
		let importe_total = 0;
		let $fila = $(this).closest(".form-row");
		let denominacion = Number($fila.find(".cantidad").data('denomi'));
		let cantidad = Number($fila.find(".cantidad").val());
		let importe = cantidad * denominacion;
		$fila.find('.importe').val(importe);
		console.log(importe);
		
		$(".importe").each( function sumarImportes(index, item){
			importe_total += Number($(item).val());
		});
		let subtotal = importe_total.toFixed(2);
		console.log(importe_total);
		$("#importe_total").val(subtotal);
	});
	//============TOTAL DE DOCUMENTO DE BOLETOS=================
	$('#datos_boleto').on('keyup',function(){
		let num_cantidad = $('#cantidad').val();
		let num_denominacion = $('#denominacion').val();
		let total = 0;
		total += num_cantidad * num_denominacion;
		$('#total_importe').val(total);
		$('#total_boletos').val(total);
		console.log(total);
	});
	
	//============TOTAL DE DOCUMENTO DE CHEQUES=================
	$('#documento_cheque').on('keyup',function(){
		let num_cheque = $(this).val();
		console.log(num_cheque);
	});
	//===========TOTAL DE TOTALES========================
	$('#todo').on('keyup',function(){
		let total_cheque = $('#documento_cheque').val();
		let total_boletos = $('#total_importe').val();
		let sub_total = $('#importe_total').val();
		let n = "";
		
		n = Number(total_cheque) + Number(total_boletos) + Number(sub_total) ;
		console.log(n);
		$('#importe_desglose').val(n);
	}); 
}

function imprimirTicket(event){
	var id_registro = $(this).data("id_registro");
	var boton = $(this);
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "impresion/imprimir_desglose.php",
		data:{
			id_registro : id_registro
		}
		}).done(function (respuesta){
		
		$("#ticket").html(respuesta); 
		window.print();
		
		return;
		
		if($("#silent_print").val() == "SI" ){
			//Impresion LTP1 para el Usuario de Luis Manuel que recauda varias empresas
			if($("#sesion_id_usuarios").val() == "56"  || $("#sesion_id_usuarios").val() == "59" || $("#sesion_id_usuarios").val() == "61" // alexis){
				$.ajax({
					url: "http://localhost/imprimir_zitlalli.php",
					method: "POST",
					data:{
						"texto" : respuesta
					}
				});
			}
			else{
				printService.submit({
					'type': 'LABEL',
					'raw_content': respuesta
				});
			}
		}
		else{
			
		}
		
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}	