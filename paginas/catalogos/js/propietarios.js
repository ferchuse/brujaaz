$(document).ready(function(){
	listarPropietarios();
	//========BOTON DE NUEVO=============
	$('#btn_modal').on('click',function(){
		$('#form_propietario')[0].reset();
		$('.modal-title').text('Nuevo Propietario');
		// $('#modal_propietario').modal('show');
		$('#modal_propietario').modal({ backdrop: 'static'}).modal('show').on('shown.bs.modal', function () {
			$('#form_propietario input:eq(1)').trigger("focus");
		});
	});
	
	//=================GUARDAR======================================
	$('#form_propietario').submit(function(event){
		event.preventDefault();
		let datos = $(this).serializeArray();
		$.ajax({
			url: '../../funciones/guardar.php',
			dataType: 'JSON',
			method: 'POST',
			data: {
				tabla: 'propietarios',
				datos: datos
			}
			}).done(function(respuesta){
			if(respuesta.estatus == "success"){
				alertify.success('Se ha agregado correctamente');
				$('#modal_propietario').modal('hide');
				listarPropietarios();
				}else{
				alertify.error("Error al guardar");
				console.log(respuesta.mensaje);
			}
		});
	});
	
	//=============BUSCAR DENTRO DE LA TABLA===========================
	$('#buscar_nombre').keyup(function filtro_buscar(){
		let indice = $(this).data("indice");
		let valor_filtro = $(this).val();
		let num_rows = buscar(valor_filtro,'dataTable',indice);
		
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


//===============FUNCION DE ENLISTAR===========================
function listarPropietarios() {
	return $.ajax({
		url: '../../funciones/listar.php',
		dataType: 'JSON',
		method: 'POST',
		data: {
			tabla: 'propietarios',
		}
    }).done(function(respuesta){
		//console.log(respuesta);
		let propietarios = "";
		if(respuesta.estatus == "success"){
			if(respuesta.num_rows > 0){
				$.each(respuesta.mensaje, function(index,element){
					propietarios += `
					<tr>
					<td class="text-center">${element.id_propietarios}</td>
					<td class="text-center">${element.nombre_propietarios}</td>
					<td class="text-center">
					<button type="button" class="btn btn-outline-danger btn_eliminar" title="Eliminar" data-id_propietarios="${element.id_propietarios}"><i class="fas fa-trash-alt"></i></button>
					<button type="button" class="btn btn-outline-warning btn_editar" title="Editar" data-id_propietarios="${element.id_propietarios}"><i class="fas fa-pencil-alt"></i></button>
					</td>
					</tr>
					`;
				});
				}else{
				propietarios += `
				<tr>
				<td colspan="3"><h3 class="text-center">No hay propietarios</h3></td>
				</tr>
				`;
			}
			//console.log(propietarios);
			$('#tabla_DB').html(propietarios);
			//=========================BOTON DE ELIMINAR==============================
			$('.btn_eliminar').on('click',function(){
				let id_campo = $(this).data('id_propietarios');
				let boton = $(this);
				var fila = boton.closest('tr');
				console.log(id_campo);
				let eliminar = function(){
					$.ajax({
						url: 'control/eliminar.php',
						method: 'POST',
						dataType: 'JSON',
						data: {
							tabla: 'propietarios',
							id_campo: id_campo,
							campo: 'id_propietarios'
						}
						}).done(function(respuesta){
						if(respuesta.estatus == "success"){
							alertify.success("Se ha eliminado correctamente");
							fila.fadeOut(1000);
							}else{
							alertify.success('Ocurrio un error al eliminar')
							//console.log(respuesta.error);
						}
					});
				}
				alertify.confirm("Confirmación","¿Deseas eliminar?",eliminar, function(){
					
				});
			});
			//============EDITAR====================================
			$('.btn_editar').on('click',function(){
				let id_campo = $(this).data('id_propietarios');
				$.ajax({
					url: '../../funciones/listar.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						tabla: 'propietarios',
						id_campo: 'id_propietarios',
						campo: id_campo
					}
					}).done(function(respuesta){
					if(respuesta.estatus == "success"){
						$.each(respuesta.mensaje[0],function(index,element){
							$('#'+index).val(element);
						});
						$('.modal-title').text('Editar propietario');
						$('#modal_propietario').modal('show');
						}else{
						console.log("error al buscar ");
					}
					
				});
			});
			}else{
			console.log("Error al cargar la tabla");
		}
	});
}	