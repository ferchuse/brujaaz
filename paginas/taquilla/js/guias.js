$(document).ready(function(){
	
	listarRegistros();

	
	$("#btn_modal").on('click',function(){
		$("#form_modal")[0].reset();
		$(".modal-title").text("Nuevo Boletaje");
		$("#modal_modal").modal("show");
		
	});
	
	
	$('#form_modal').on('keypress', function (event){
		if(event.which == 13){
			return false;
		}
	});
	
	$('.cantidad').on('keyup', function (event){
		if(event.which == 13){
			$("#agregar_fila").click();
			console.log("agrega fila")
		}
	});
	$('.denominacion, .cantidad').on('keyup', function calculaImporte(){
		console.log("calculaImporte()");
		let total_boletaje = 0;
		let cantidad_boletos = 0;
		let $fila = $(this).closest(".form-row");
		let denominacion = Number($fila.find(".denominacion").val());
		let cantidad = Number($fila.find(".cantidad").val());
		let importe = cantidad * denominacion;
		
		$fila.find(".importe").val(importe);
		
		$(".importe").each( function sumarImportes(index, item){
			total_boletaje+=Number($(item).val());
		});
		$(".cantidad").each( function sumarImportes(index, item){
			cantidad_boletos+=Number($(item).val());
		});
		console.log(total_boletaje);
		
		$("#total_boletaje").val(total_boletaje);
		$("#cantidad_boletos").val(cantidad_boletos);
	});
	
	
	$('#num_eco').on('keyup', function buscarUnidad(event){
		event.preventDefault();
		
		var num_eco = $(this).val();
		if(num_eco == ''){
			alertify.error("Ingrese un Num Eco");
			return false;
		}
		console.log("Buscar Unidad", event.which )
		if(event.which == 13){
			$("#num_eco").toggleClass("cargando");
			$.ajax({
				url: '../../funciones/fila_select.php',
				method: 'GET',
				dataType: 'JSON',
				data: {
					tabla: "unidades",
					id_campo: "num_eco",
					id_valor:num_eco
				}
				}).done(function(respuesta){
				console.log("buscarUnidad", respuesta) 
				if(respuesta.num_rows == 0){
					alertify.error("No encontrado")
				}
				else{
					$.each(respuesta.data, function(name, value){
						
						$("#"+name).val(value);
						
					})
					
					
				}
				}).always(function(){
				
				$("#num_eco").toggleClass("cargando");
			});
			
		};
	});
	
	$("#agregar_fila").click(agregarFila);
	
	
	
	//=============BUSCAR DENTRO DE LA TABLA===========================
	$('#buscar_usuario').on('keyup',function filtro_buscar(){
		let indice = $(this).data("indice");
		let valor_filtro = $(this).val();
		let num_rows = buscar(valor_filtro,'tableData',indice);
    
		if(num_rows == 0){
			$('.mensaje').html(`
			<div class="alert alert-dark text-center" role="alert">
			<strong>NO se ha encontrado</strong>
			</div>
			`);
			}else{
			$('.mensaje').html("");
		}
	});
	
});

function agregarFila(event){
	console.log("agregarFila()")
	$("#boletos .form-row:first").clone(true).appendTo("#boletos")
	
}


//========funcion de listar============
function listarRegistros(){
	console.log("listarRegistros()")
	$.ajax({
		url: 'control/lista_guias.php',
		method: 'POST',
		data:{}
	}).done(
	function(respuesta){
		$("#lista_registros").html(respuesta)
		$('.imprimir').on('click',imprimirTicket)
		$(".cancelar").click(confirmaCancelacion);
		
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
			url: "control/cancelar_guia.php",
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
	console.log("imprimirTicket()");
	var id_registro = $(this).data("id_registro");
	// var url = $(this).data("url");
	var boton = $(this); 
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "impresion/imprimir_guias.php" ,
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
