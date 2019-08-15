<?php
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Recibos de Mutualidad";
	$id= "id_mutualidad";
	$tabla = "mutualidad";
	include('../../funciones/generar_select.php');
	include('../login/login_check.php');
?>


<!DOCTYPE html>
<html lang="es_mx">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $nombre_pagina?></title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
    <?php include("../../navbar.php")?>
    <div id="wrapper" class="d-print-none">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
          <!-- Breadcrumbs-->
					<ol class="breadcrumb ">
						<li class="breadcrumb-item">
							<a href="#">Recaudación</a> 
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina?></li>
					</ol>
					
						<!--Form Filtro !-->
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button class="btn btn-primary btn-sm" type="submit">
										<i class="fas fa-search"></i> Buscar
									</button>
									<button class="btn btn-info btn-sm" onclick="window.print()" type="button">
										<i class="fas fa-print"></i> Imprimir
									</button>
								</div>
								
							</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-2">
								<label for="">Fecha Inicial:</label>
							</div>
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" value="<?php echo date("Y-m-d");?>">
							</div>  
							<div class="col-2">
								<label for="">Fecha Final:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_final" id="fecha_final" value="<?php echo date("Y-m-d");?>">
							</div> 
						</div>
						<div class="row mb-2"> 
							<div class="col-2">
								<label for="">No. Economico:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div>  
							<div class="col-2">
								<label for="">Estatus:</label>
							</div>	
							<div class="col-4">			
								<select class="form-control" name="estatus_mutualidad">
									<option value=""> Todos</option>
									<option selected>Activo</option>
									<option>Cancelado</option>
								</select>
							</div>  
						</div>
						<div class="row mb-2"> 
							<div class="col-2">
								<label for="">Usuario:</label>
							</div>	
							<div class="col-4">			
								<?php echo generar_select($link, "usuarios", "id_usuarios", "nombre_usuarios", true, false, false, 0,0)?>
							</div>  
						</div>
					</form>
					<hr>
					<div class="card mb-3 d-print-block">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina; ?>
							
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" cellspacinhg="0" id="tabla_registros">
									<thead>
										<tr>
											<th class="text-center d-print-none"></th>
											<th class="text-center">Folio</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Recaudacion</th>
											<th class="text-center">Empresa</th>
											<th class="text-center">Unidad</th>
											<th class="text-center">Conductor</th>
											<th class="text-center">Monto</th>
											<th class="text-center">Estatus</th>
											<th class="text-center">Usuario</th>
											
										</tr>
									</thead>
									<tbody id="containerLista">
										<tr>
											<td colspan="9"><h3 class="text-center">Cargando...</h3></td>
										</tr>
									</tbody>
								</table>
								<div id="mensaje"></div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- /.container-fluid -->
				
		    <!-- Sticky Footer -->
				<footer class="sticky-footer d-print-none">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright  Glifo Media 2018</span>
						</div> 
					</div>
				</footer>
				
			</div>
			<!-- /.content-wrapper -->
		</div>
		<!-- /#wrapper -->
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded d-print-none" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>		
		
		<div class="d-print-block d-none p-2 " id="ticket" >
		</div>
    <?php 
			include("../../scripts.php");
		?>
    <script src="js/mutualidad.js" ></script>
		
	</body>
</html>
