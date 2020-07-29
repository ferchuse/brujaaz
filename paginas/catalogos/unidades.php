<?php 
	include("../login/login_check.php");
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	
	$link = Conectarse();
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Catálogo de Unidades</title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
		<?php include("../../navbar.php")?>
		<div id="wrapper">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Catálogos</a>
						</li>
						<li class="breadcrumb-item active">Unidades</li>
					</ol>
					
					<div class="row mb-2">
						<div class="col-12">
							<form id="form_filtro" autocomplete="off">
								<div class="row mb-2">
									<div class="col-12">
										<div class="col-12 mb-3">
											<button class="btn btn-primary btn-sm" >
												<i class="fas fa-search"></i> Buscar
											</button>
											<button type="button" class="btn btn-success nuevo btn-sm" >
												<i class="fas fa-plus"></i> Nuevo
											</button>
											
										</div>
										
									</div>
								</div>
								
								
								<div class="row mb-2"> 
									<div class="col-1">
										<label for="">No. Economico:</label>
									</div>	
									<div class="col-3">			
										<input class="form-control" type="text" name="num_eco"  >
									</div> 
									<div class="col-1">
										<label for="">Derrotero:</label>
									</div>	
									<div class="col-3">			
										<?php echo generar_select($link, "derroteros", "id_derroteros", "nombre_derroteros", true);?>
									</div> 
									<div class="col-1">
										<label >Propietario:</label>
									</div>	
									<div class="col-3">			
										<?php
											echo generar_select($link, "propietarios", "id_propietarios", "nombre_propietarios", true);
										?>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-1">
										<label >Empresa:</label>
									</div>	
									<div class="col-3">			
										<?php
											echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", true);
										?>
									</div>
									
									<div class="col-1">
										<label >Estatus:</label>
									</div>	
									<div class="col-3">			
										<select class="form-control" name="estatus_unidades">
											<option value="">Todos</option>
											<option>Alta</option>
											<option>Baja</option>
											<option>Inactivo</option>
										</select>
									</div>
								</div>	
								
							</div>
							
						</form>
						<hr>
					</div>
				</div>
				<hr>
				
				
				
				<div class="card mb-3">
					<div class="card-header">
						<i class="fas fa-table"></i>
						Lista de Unidades
					</div>
					<div class="card-body">
						<div class="table-responsive" id="lista_registros">
							<h3 >Cargando...</h3>
						</div>
					</div>
					<div class="card-footer small text-muted"></div>
				</div>
			</div>
			<!-- /.container-fluid -->
			
			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright © Glifo Media 2018</span>
					</div>
				</div>
			</footer>
			
		</div>
		<!-- /.content-wrapper -->
	</div>
	<!-- /#wrapper -->
	
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>		
	
	
	<!-- The Modal -->
	<
	
	
	<?php include("forms/form_unidades.php")?>
	<?php include("forms/modal_historial.php")?>
	<?php include("../../scripts.php")?>
	<script>
		$(document).ready(function(){
			listarRegistros();
			
			$('#form_edicion').submit( guardarRegistro );
			$('.nuevo').click( nuevoRegistro );
			$('#num_eco').blur( buscarUnidad );
			$('#form_filtro').on('submit', function filtrar(event){
				event.preventDefault();
				
				listarRegistros();
				
			});
			
		});
		
		function buscarUnidad(){
			console.log("id_unidades", $("#id_unidades").val());
			if($("#id_unidades").val() != ""){
				
				return false;
			}
			
			$('#num_eco').addClass("cargando");
			var num_eco = $(this).val();
			
			
			$.ajax({
				url: '../../funciones/fila_select.php',
				method: 'GET',
				data: {
					tabla: "unidades",
					id_campo: "num_eco",
					id_valor: num_eco
					
				}
				}).done(function(respuesta){
				
				if(respuesta.count_rows > 0){
					alertify.error("Ya existe la unidad")
					$('#num_eco').focus();
				}
				
				}).always(function(){
				$('#num_eco').removeClass("cargando");
				
			});
		}
		
		function nuevoRegistro(event){
			
			$("#form_edicion")[0].reset();
			$('#modal_edicion').modal({ backdrop: 'static'}).modal('show').on('shown.bs.modal', function () {
				$('#form_edicion input:eq(1)').trigger("focus");
			});
		}
		function guardarRegistro(event){
			event.preventDefault();
			let datos = $(this).serializeArray();
			let boton = $(this).find(":submit");
			let icono = boton.find(".fas");
			
			boton.prop("disabled", true);
			icono.toggleClass("fa-save fa-spinner fa-spin");
			
			$.ajax({
				url: 'control/guardar_unidades_historial.php',
				dataType: 'JSON',
				method: 'POST',
				data: {
					tabla: 'unidades',
					datos: datos
				}
			}).done(
			function(respuesta){
				boton.prop("disabled", false);
				icono.toggleClass("fa-save fa-spinner fa-spin");
				
				if(respuesta.estatus == "success"){ 
					alertify.success('Se ha agregado correctamente');
					$('#form_edicion')[0].reset();
					$('#modal_edicion').modal("hide");
					listarRegistros();
					}else{
					console.log(respuesta.mensaje);
				}
			});
			
			
		}
		
		function listarRegistros() {
			console.log("listarRegistros()");
			
			let form = $("#form_filtro");
			let boton = form.find(":submit");
			let icono = boton.find('.fas');
			
			boton.prop('disabled',true);
			icono.toggleClass('fa-search fa-spinner fa-pulse ');
			
			return $.ajax({
				url: 'control/listar_unidades.php',
				method: 'GET',
				data: form.serialize()
				}).done(function(respuesta){
				
				$('#lista_registros').html(respuesta);
				// $('#tabla_registros').DataTable({
				// "language": {
				// "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
				// }
				// });
				
				$('.btn_editar').on('click', cargarRegistro);
				$('.btn_historial').on('click', mostrarHistorial);
				
				}).fail(function(jqXHR, textStatus, errorThrown){
				if (jqXHR.status === 0) {
					
					alertify.error('Falló Internet, Verifique conexión.');
					} else if (jqXHR.status == 404) {
					alertify.error('Página No encontrada');
					} else if (jqXHR.status == 500) {
					alertify.error('Error Interno Codigo 500');
					} else if (textStatus === 'parsererror') {
					alertify.error('Error de JSON.');
					} else if (textStatus === 'timeout') {
					alertify.error('Tiempo de Espera Agotado. Vuelva a intentar');
					} else if (textStatus === 'abort') {
					alertify.error('Conexion Fallida, Vuelva a intentar.');
					} else {
					alertify.error('Error desconocido: ' + jqXHR.responseText);
					
				}
				
				
				}).always(function(){
				
				boton.prop('disabled',false);
				icono.toggleClass('fa-search fa-spinner fa-pulse fa-fw');
				
			});
		}
		//FUNCION DE Cargar datos
		function cargarRegistro() {
			console.log("cargarRegistro()");
			var $boton = $(this);
			var id_registro= $(this).data("id_registro");
			
			$boton.prop("disabled", true);
			
			$.ajax({
				url: '../../funciones/fila_select.php',
				method: 'GET',
				data: {
					tabla: "unidades",
					id_campo: "id_unidades",
					id_valor: id_registro
					
				}
				}).done(function(respuesta){
				console.log("imprime registros")
				$boton.prop("disabled", false);
				
				$.each(respuesta.data, function(name , value){
					$("#form_edicion").find("#"+ name).val(value);
					
				});
				
				$("#modal_edicion").modal("show");
				// $('#lista_registros').html(respuesta);
				
			});
		}
		
		function mostrarHistorial() {
			console.log("mostrarHistorial()");
			var $boton = $(this);
			var id_registro= $(this).data("id_registro");
			
			$boton.prop("disabled", true);
			
			$.ajax({
				url: 'control/mostrar_historial.php',
				method: 'GET',
				data: {
					id_unidades: id_registro
				}
				}).done(function(respuesta){
				console.log("imprime registros")
				$boton.prop("disabled", false);
				
				
				$("#modal_historial .modal-body").html(respuesta);
				
				
				$("#modal_historial").modal("show");
				
			});
		}
		
	</script>
</body>
</html>
