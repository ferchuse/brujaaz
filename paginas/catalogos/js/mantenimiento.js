$(document).ready(function(){
	
	listarRegistros();
	
	$('#nuevo').on('click',function(){
		$('#form_edicion')[0].reset();
		$('.modal-title').text('Nuevo');
		$('#modal_edicion').modal('show');
	});
	
	$('#form_edicion').on('submit',function(event){
		event.preventDefault();
		let form = $(this);
		let boton = form.find(':submit');
		let icono = boton.find('.fa');
		let datos = form.serializeArray();
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		
		$.ajax({
			url: 'control/guardar.php',
			method: 'POST',
			dataType: 'JSON',
			data:{
				tabla: 'cat_tipo_mantenimiento',
				datos: datos
			}
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha agregado correctamente');
				$('#modal_edicion').modal('hide');
				listarRegistros();
				}else{
				alertify.error('Ocurrio un error');
			}
			}).always(function(){
			boton.prop('disabled',false);
			icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		});
	})
	
	
	
	
});





function listarRegistros(){
	return $.ajax({
		url: '../../funciones/listar.php',
		method: 'POST',
		dataType: 'JSON',
		data: {
			tabla: 'cat_tipo_mantenimiento'
		}
		}).done(function(respuesta){
		if(respuesta.estatus == 'success'){
			let lista = '';
			if(respuesta.num_rows > 0){
				$.each(respuesta.mensaje,function(index,element){
					lista += `
					<tr>
					<td class="text-center">${element.tipo_mantenimiento}</td>
					<td class="text-center">
					<button class="btn btn-outline-danger eliminar" data-id_registro='${element.id_tipo_mantenimiento}'><i class="fas fa-trash-alt"></i></button>
					<button class="btn btn-outline-warning editar" data-id_registro='${element.id_tipo_mantenimiento}'><i class="fas fa-pencil-alt"></i></button>
					</td>
					</tr>
					`;
				});
				}else{
				lista = `
				<tr>
				<td colspan="4"><h3 class="text-center">No hay Beneficiarios</h3></td>
				</tr>
				`;
			}
			$('#lista_registros').html(lista);
			
			
			//=========ELIMINAR=========
			$('.eliminar').click(function(){
				let boton = $(this);
				let id_registro = boton.data('id_registro');
				var fila = boton.closest('tr');
				
				alertify.confirm('Confirmacion', '¿Deseas eliminarlo?', eliminar , function(){
				});
				
				function eliminar(){
					$.ajax({
						url: 'control/eliminar.php',
						method: 'POST',
						dataType: 'JSON',
						data: {
							tabla: 'cat_tipo_mantenimiento',
							id_campo: 'id_tipo_mantenimiento',
							campo: id_registro
						}
						}).done(function(respuesta){
						if(respuesta.estatus == 'success'){
							alertify.success('Se ha eliminado correctamente');
							fila.fadeOut(1000);
							}else{
							alertify.error('Ocurrio un error');
						}
					});
				}
				
			});
			
			/*=======LISTAR EMPRESAS=========*/
			$('.editar').click(function(){
				var boton = $(this);
				var icono = boton.find('.fas');
				var id_registro = boton.data('id_registro');
				boton.prop('disabled',true);
				icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');
				
				$.ajax({
					url: 'control/listar.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						tabla: 'cat_tipo_mantenimiento',
						id_campo: 'id_tipo_mantenimiento',
						campo: id_registro
					}
					}).done(function(respuesta){
					if(respuesta.estatus == 'success'){
						$.each(respuesta.mensaje[0],function(index,element){
							$('#'+index).val(element);
						});
						$('.modal-title').text('Editar Beneficiario');
						$('#modal_edicion').modal('show');
					}
					else{
						//console.log(respuesta.mensaje);
					}
					}).always(function(){
					boton.prop('disabled',false);
					icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');
				});
			});
		
		
		}else{
		//console.log(respuesta.mensaje);
		}
	});
}

function crearModal(){
	let modal = `
	<input type="text" hidden class="form-control" id="id_beneficiarios" name="id_beneficiarios">
	<div class="form-group">
	<label for="nombre_beneficiarios">NOMBRE</label>
	<input type="text" class="form-control" id="nombre_beneficiarios" name="nombre_beneficiarios" placeholder="Nombre del beneficiario" required>
	</div>
	`;
	return modal; 
}
