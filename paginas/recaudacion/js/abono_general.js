$(document).ready(function(){
	//=================CARGAR LA TABLA AL INICIO===================
	listarRegistros();
	
	$('#form_filtro').on('submit', function filtrar(event){
		event.preventDefault();
		
		listarRegistros();
		
	});
	
	// console.log("hoy", hoy)
	
	//===============OPEN MODAL===========
	$(".nuevo").click(function(){ 
		$("#form_modal")[0].reset();
		$(".modal-title").text("Nuevo Abono General");
		$("#modal_modal").modal("show");
		
		let id_usua = $("#id_usuarios").val();
		$("#id_u").val(id_usua);
		console.log(id_usua);
	});
	
	//=====Imprimir tabla=================
	$("#btn_imprimir").on('click',function(){
		let formato = '';
		formato += `
		<h1 class="text-center">GAAZ</h1>
		<h2 class="text-center">ABONO GENERAL A UNIDADES</h2>
		`; 
		//$("#ticket").addClass("d-print-none");
		$('#formato_imprimir').html(formato);
		window.print();
	});
	//==========GUARDAR============
	$('#form_modal').on('submit', function guardarAbono(event){
		event.preventDefault();
		let form = $(this);
		let boton = form.find(':submit');
		let icono = boton.find('.fas');
		let datos = form.serializeArray();
		
		// let dt_fecha_abono = new Date();
		
		// let fecha_abono = dt_fecha_abono.toLo
		let fecha_abono = new Date().toString('yyyy-MM-dd HH:mm:ss')
		
		datos.push({name: "fecha_abonogeneral", value: fecha_abono})
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
		$.ajax({
			url: '../catalogos/control/guardar.php',
			method: 'POST',
			dataType: 'JSON',
			data:{
				tabla: 'abono_general',
				datos: datos
			}
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha agregado correctamente');
				$('#modal_modal').modal('hide');
				listarRegistros();
				}else{
				alertify.error('Ocurrio un error');
			}
			}).always(function(){
			boton.prop('disabled',false);
			icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		});
	})
	//=========BUSCAR NUM.ECO===================
	$('#monto_abonogeneral').keyup(function calculaSaldo(){
		console.log("calculaSaldo()");
		var saldo_restante = Number($("#saldo_anterior").val()) + Number($(this).val()) 
		
		$("#saldo_restante").val(saldo_restante);
	});
	
	
	$('#num_eco').blur(function(){
		
		
	}); 
	
	$('#id_eco').keyup(function(){
		//let input = $(this); 
		let numero_unidad = $(this).val();
		
		if(numero_unidad.length <= 4){
			//input.prop('disabled',true); 
			//input.toggleClass('ui-autocomplete-loading');
			let subconsulta ='LEFT JOIN empresas USING (id_empresas)';
			let group = 'num_eco';
			console.log("numero_unidad" + " "+numero_unidad);
			$('#id_eco').addClass("cargando");
			
			
			$.ajax({
				url: '../movimientos/control/listar_orden.php',
				method: 'POST',
				dataType: 'JSON',
				data: {
					tabla: 'unidades',
					subconsulta: subconsulta,
					campo: 'num_eco',
					id_campo: numero_unidad,
					group: group
				}
				}).done(function(respuesta){
				$('#id_eco').removeClass("cargando");
				
				if(respuesta.estatus == "success"){
					let n = '';
					if(respuesta.num_rows > 0){
						$.each(respuesta.mensaje,function(index,element){
							n += `
							<div class="form-group col-md-6">
							<label for="">EMPRESA</label>
							<input type="text" class="form-control" value="${element.nombre_empresas}" readOnly>
							</div>
							<div class="form-group col-md-6">
							<label for="">Saldo Actual</label>
							<input type="text" class="form-control" id="saldo_anterior" value="${element.saldo_unidades}" readOnly>
							</div>
							<input type="text" name="id_unidades" class="form-control" value="${element.id_unidades}" hidden>
							
							`;
						});
						}else{
						n += `
						<input type="text" name="id_unidades" class="form-control" value="Numero no encontrado" readOnly>
						`;
						console.log("numero de unidad no encontrado en la BD");
					}
					$('#result_unidad').html(n);
					}else{
					console.log("estatus error");
				}
			});
			}else{
			console.log("ningun numero digitalizado");
		}
	});
	
	//=============BUSCAR DENTRO DE LA TABLA===========================
	$('#buscar_unidad').keyup(function filtro_buscar(){
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
	$('#id_empresas').change(function filtro_buscar(){
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
	$('#id_motivosAbono').change(function filtro_buscar(){
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
	$('#id_derroteros').change(function filtro_buscar(){
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
	$('#id_propietarios').change(function filtro_buscar(){
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
	//=============FIN DE BUSCAR DENTRO DE LA TABLA===========================
	
});


function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'control/lista_abono_general.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#dataTable").dataTable();
		$(".imprimir").click(imprimirTicket);
		$(".cancelar").click(confirmaCancelacion);
		
		dame_permiso();
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		
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
		url: "impresion/imprimir_abono_general.php",
		data:{
			id_registro : id_registro
		}
		}).done(function (respuesta){
		
		$("#carta").html(respuesta); 
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
			url: "control/cancelar_abono_general.php",
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