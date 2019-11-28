<?php
	$nombre_pagina = "Condonacion de Tarjetas";
	$id= "id_condonaciones";
	$tabla = "con";
	
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	include("../../paginas/login/login_check.php");
	
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
		
    <title>Condonacion de Tarjetas</title>
		
    <?php include("../../styles.php")?> 
		
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
            <li class="breadcrumb-item active">Condonación de Tarjeta</li>
					</ol>
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									
									<button class="btn btn-primary" >
										<i class="fas fa-search"></i> Buscar
									</button>
									<button type="button" class="btn btn-success nuevo" id="" > 
										<i class="fas fa-plus"></i> Nueva
									</button>
								</div>
								
							</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-2">
								<label for="nombre_condonaciones">Fecha Inicial:</label>
							</div>
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_inicial" value="<?php echo date("Y-m-d");?>">
							</div>  
							<div class="col-2">
								<label for="nombre_condonaciones">Fecha Final:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_final"  value="<?php echo date("Y-m-d");?>">
							</div> 
						</div>
						<div class="row mb-2"> 
							<div class="col-2">
								<label for="nombre_condonaciones">No. Economico:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="text" name="num_eco" >
							</div>  
						</div>
					</form>
					<div class="card mb-3 d-print-none">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina; ?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								<table class="table table-bordered" id="datatable" width="100%" cellspacing="0" >
									<thead>
										<tr>
											<th class="text-center"></th>
											<th class="text-center">Folio</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Fecha Cuenta	</th>
											<th class="text-center">Tarjeta</th>
											<th class="text-center">Empresa</th>
											<th class="text-center">Unidad</th>
											<th class="text-center">Conductor</th>
											<th class="text-center">Motivo</th>
											<th class="text-center">Monto</th>
											<th class="text-center">Observaciones</th>
											<th class="text-center">Usuario</th> 
										</tr>
									</thead>
									<tbody id="containerLista">
										<tr>
											<td colspan="11"><h3 class="text-center">Cargando...</h3></td>
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
							<span>Copyright © Glifo Media 2018</span>
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
		
		<div class="d-print-block  p-2 " id="ticket" >
		</div>
		<?php include("forms/form_condonacion.php")?>  
		<?php include("../../scripts.php")?> 
		<script src="js/condonacion_tarjeta.js?v=<?= date("d-m-y-H-i-s")?>"></script>
	</body>
	
</html>
