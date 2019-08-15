$(document).ready(function(){
	//=================CARGAR LA TABLA AL INICIO===================
	listar();
	//===============OPEN MODAL===========
	$("#btn_modal").on('click',function(){
		$("#form_modal")[0].reset();
		$(".modal-title").text("Nuevo Desglose de Dinero");
		$("#modal_modal").modal("show");
		
		// console.log(id_usua);
		cadena_numeros();
	});
	
	//==========BOTON CUBRIR Y DESCUBRIR LOS PRECIOS DE DOCUMENTO DE BOLESTOS=======================
	$('#btn_boletos').on('click',function(){
		$('#datos_boleto').toggle();//Alternar entre ocultar y mostrar para todos los elementos
	});
	$('#btn_taquilla').on('click',function(){
		$('#imp_cadena').toggle();//Alternar entre ocultar y mostrar para todos los elementos
	});
	//==========GUARDAR============
	$('#form_modal').on('submit', guardarRegistro);
	
	
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
				listar();
				}else{
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

function listar(){
	let subconsulta ='LEFT JOIN usuarios USING (id_usuarios)';
	let fecha_hoy = Date.today();
	let fecha = fecha_hoy.toString('yyyy-MM-dd');
	console.log(fecha);
	return $.ajax({
		url: '../../funciones/listar.php',
		method: 'POST',
		dataType: 'JSON',
		data: {
			tabla: 'desglose_dinero',
			subconsulta: subconsulta,
			campo: 'fecha_desglose',
			fecha: fecha
		}
		}).done(function(respuesta){
		resultado(respuesta);
	});
}
//=========CREACION DE td PARA LA TABLA ===========================
function resultado(respuesta){
	if(respuesta.estatus == 'success'){
		let contenedor = '';
		let totalMonto = 0;
		if(respuesta.num_rows > 0){
			$.each(respuesta.mensaje,function(index,element){
				contenedor += `
				<tr>
				<td class="text-center d-print-none">
				<button class="btn btn-outline-primary imprimir " title="Imprimir" data-id_registro='${element.id_desglose}'>
					<i class="fas fa-print"></i></button>
				</td>
				<td class="text-center">${element.id_desglose}</td>
				<td class="text-center">${element.nombre_usuarios}</td>
				<td class="text-center">${element.fecha_desglose}</td>
				<td class="text-center">${"$"+element.importe_desglose}</td>
				</tr>
				`;
				totalMonto += Number(element.importe_desglose);
				
			});
			let resultado = totalMonto.toFixed(2);
			$("#total").text("$"+resultado);
			console.log(resultado);
			//console.log(totalMonto+" "+"num");
			//let num = [2,4,6,8,10];
			//let suma = num.reduce((a,b) => a+b);
			//console.log(num);
			
			}else{
			contenedor = `
			<tr>
			<td colspan="7"><h3 class="text-center">No hay Desglose de Dinero</h3></td>
			</tr>
			`;
			$("#total").text(" ");
		}
		$('#tabla_DB').html(contenedor);
		
		
		//=========IMPRIMIR=========
		$('.imprimir').click(imprimirTicket);
		
	}
	else{
		console.log("Error al cargar la tabla");
	}
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
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-print fa-spinner fa-spin");
		
	});
}