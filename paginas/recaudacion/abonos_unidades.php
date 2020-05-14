<?php
	$nombre_pagina = "Abonos a Unidades";
	$id= "id_abonos";
	$tabla = "abonos_unidades";
	
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
		
    <title>Abonos a Unidades</title>
		<?php include("../../styles.php")?>
	</head>
	
  <body id="page-top">
		
    <?php include("../../navbar.php")?>
		
		
    <div id="wrapper" class="d-print-none">
			
      <!-- Sidebar -->
      <?php include("../../menu.php")?>
			
      <div id="content-wrapper">
				
        <div class="container-fluid">
					
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Recaudación</a>
						</li> 
            <li class="breadcrumb-item active">Abonos a Unidades</li>
					</ol>
					
					
					
					<!--Form Filtro !-->
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button class="btn btn-primary btn-sm" >
										<i class="fas fa-search"></i> Buscar
									</button>
									<a href="abonar_unidades.php" class="btn btn-success btn-sm" >
										<i class="fas fa-dollar-sign"></i> Abonar
									</a>
									
								</div>
								
							</div>
						</div>
						
						<div class="row mb-2">
							<div class="col-1">
								<label for="nombre_condonaciones">Fecha Inicial:</label>
							</div>
							<div class="col-2">			
								<input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" value="<?php echo date("Y-m-d");?>">
							</div>  
							<div class="col-1">
								<label for="nombre_condonaciones">Fecha Final:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="date" name="fecha_final" id="fecha_final" value="<?php echo date("Y-m-d");?>">
							</div> 
							<div class="col-1">
								<label >Usuario:</label>
							</div>	
							<div class="col-2">			
								<?php echo generar_select($link, "usuarios", "id_usuarios", "nombre_usuarios", true, false, false, $_COOKIE["id_usuarios"])?>
							</div> 
						</div>
						<div class="row mb-2"> 
							<div class="col-1">
								<label for="nombre_condonaciones">No. Economico:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div>  	
							<div class="col-1">
								<label for="nombre_condonaciones">Estatus:</label>
							</div>	
							<div class="col-2">			
								<select name="estatus_abonos" class="form-control">
									<option>Todos</option>
									<option>Activo</option>
									<option>Cancelado</option>
								</select>
							</div>  
						</div>
					</form>
					<hr>
					
					<hr>
					<div class="card card-primary mb-3" >
						<div class="card-header bg-info">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								<h4 class="text-center">
									Cargando...	
								</h4>
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
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		
		<div class="d-print-block p-2 " hidden id="ticket" >
		</div>
		
		
		<?php include("../../scripts.php")?>
		<script src="js/abonos_unidades.js?v=<?php echo date('Y-m-d-H:i:s'); ?>"></script>
	</body>
	
</html>																																		