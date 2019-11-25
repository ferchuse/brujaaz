$(document).ready(function(){
	console.log("ready")
	listarRegistros();
	
	//========DAR LCIK EN BOTON DE NUEVO=============
	$('.nuevo').on('click',function(){
		console.log("nuevo")
		$('#form_edicion')[0].reset();
		$('.modal-title').text('Nueva Condonación');
		$('#modal_edicion').modal('show');
		console.log("modal")
	});
	
	
	$('#form_filtro').on('submit', function filtrar(event){
		event.preventDefault();
		
		listarRegistros();
		
	});
	
	
	$('#tarjeta').on('keyup',function(event){
		event.preventDefault();
		
		var tarjeta = $(this).val();
		
		let subconsulta = `LEFT JOIN empresas USING(id_empresas)
		LEFT JOIN conductores USING(id_conductores)
		LEFT JOIN unidades USING(id_unidades)
		WHERE tarjeta = ${tarjeta}
		
		`;
		if(event.which == 13){
			$("#tarjeta").addClass("cargando"); 
			$.ajax({
				url: '../catalogos/control/listar.php',
				method: 'POST',
				dataType: 'JSON',
				data: {
					tabla: 'tarjetas',
					subconsulta :subconsulta
				}
				}).done(function(respuesta){
				console.log(respuesta) 
				if(respuesta.num_rows == 0){
					alertify.error("No encontrado")
				}
				else{
					
					$.each(respuesta.mensaje[0], function(name, value){
						$("#"+name).val(value);
						if(name == 'estatus_tarjetas' && value == 'Recaudada'){
							alertify.error("Tarjeta Ya recaudada");
							$("#tarjeta").select();
							$("#form_edicion")[0].reset();
							return false;
						}
						
					});
					
				}
				
				}).always(function(){
				
				$("#tarjeta").removeClass("cargando"); 
			});
			
		};
	});
	
	//==========GUARDAR ============
	$('#form_edicion').on('keypress',function(event){
		if(event.which == 13){
			console.log("Enter:")
			return false;
		}
		
	});
	
	
	$('#form_edicion').on('submit',function(event){
		
		//guarda en condonaciones, 
		event.preventDefault();
		let form = $(this);
		let boton = $("#btn_guardar");
		let icono = boton.find('.fas');
		let datos = form.serialize()+"&id_usuarios="+$("#id_usuarios").val();
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
		
		$.ajax({
			url: 'control/guardar_condonacion.php',
			method: 'POST',
			dataType: 'JSON',
			data: datos
			}).done(function(respuesta){
			if(respuesta.estatus_update == 'success'){
				alertify.success('Guardado correctamente');
				$('#modal_edicion').modal('hide');
				listarRegistros();
			}
			else{
				alertify.error('Ocurrio un error');
			}
			}).always(function(){
			boton.prop('disabled',false);
			icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		});
		
		
	})
	
});





function listarRegistros(){
	console.log(" listarRegistros(")
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-spin');
	$(".card-header").addClass('cargando');
	
	return $.ajax({
		url: 'control/lista_condonaciones.php',
		data: $("#form_filtro").serialize()
    }).done(function(respuesta){
		
		$('#tabla_registros').html(respuesta);
		
		//Imprimir Ticket
		$('.imprimir').on('click', imprimirTicket);
		
		//=========ELIMINAR=========
		$('.cancelar').click(confirmaCancelacion);
		
		}).always(function(){
		
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-spin');
		$(".card-header").removeClass('cargando');
		
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
			url: "control/cancelar_condonaciones.php",
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
	var id_registro = $(this).data("id_registro");
	var boton = $(this);
	var icono = boton.find("fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-print fa-spinner fa-spin");
	
	$.ajax({
		url: "impresion/imprimir_condonacion.php",
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

