<?php
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Tarjetas";
	$id= "tarjeta";
	$tabla = "tarjetas";
	include('../../funciones/generar_select.php');
	
	include("../../paginas/login/login_check.php");
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
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Recaudación</a> 
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina?></li>
					</ol>
					<div class="row mb-2 d-none">
						<div class="col-12">
							<button type="button" class="btn btn-outline-success nuevo" id="">
								<i class="fas fa-plus"></i> Nueva
							</button>
						</div>
					</div>
					
						
					<!--Form Filtro !-->
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button class="btn btn-primary btn-sm" >
										<i class="fas fa-search"></i> Buscar
									</button>
								</div>
								
							</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-1">
								<label for="nombre_condonaciones">Fecha Inicial:</label>
							</div>
							<div class="col-3">			
								<input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" value="<?php echo date("Y-m-d");?>">
							</div>  
							<div class="col-1">
								<label >Fecha Final:</label>
							</div>	
							<div class="col-3">			
								<input class="form-control" type="date" name="fecha_final" id="fecha_final" value="<?php echo date("Y-m-d");?>">
							</div> 
							<div class="col-1">
								<label >Usuario:</label>
							</div>	
							<div class="col-3">			
								<?php echo generar_select($link, "usuarios", "id_usuarios", "nombre_usuarios", true, false, false, $_COOKIE["id_usuarios"])?>
							</div> 
						</div>
						<div class="row mb-2"> 
							<div class="col-1">
								<label >No. Eco:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div> 
							<div class="col-1">
								<label for="nombre_condonaciones">Tarjeta:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="text" name="tarjeta"  >
							</div>  
						</div>
					</form>
					<hr>
					
					
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina; ?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								<table class="table table-bordered table-condensed datatable"  cellspacing="0" >
									<thead>
										<tr>	
											<th class="text-center">Acciones</th>
											<th class="text-center">Folio</th>
											<th class="text-center">Fecha</th>
											<th hidden class="text-center">Empresa</th>
											<th class="text-center">Unidad</th>
											<th class="text-center">Conductor</th>
											<th class="text-center">Derrotero</th>
											<th class="text-center">Estatus</th>
											<th hidden class="text-center">Usuario</th>
										</tr>
									</thead>	
									<thead>
										<tr>	
											<th class="text-center"></th>
											<th class="text-center"><input class="form-control buscar" data-indice="1"></th>
											<th class="text-center"></th>
											<th hidden class="text-center"></th>
											<th class="text-center"><input class="form-control buscar" data-indice="4"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
										</tr>
									</thead>
									<tbody id="containerLista">
										<tr>
											<td colspan="8"><h3 class="text-center">Cargando...</h3></td>
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
				<footer class="sticky-footer">
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
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>	
		<div class="d-print-block  p-2 " hidden id="ticket" >
		</div>
		
    <?php 
			include("../../scripts.php");
			include("forms/form_tarjetas.php");
		?>
		<script src="../../plugins/pos_print/websocket-printer.js" > </script>
    <script src="js/tarjetas.js?v=<?= date("d-m-Y-h-i-s")?>"></script>
    <script src="js/buscar.js"></script>
	</body>
</html>
