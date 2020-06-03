<?php
	include("../../paginas/login/login_check.php");
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Abono General de Unidades";
	include('control/select_general.php');
	include('../../funciones/generar_select.php');
	
	
?>
<!DOCTYPE html>
<html lang="es_mx">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Recaudación de <?php echo $nombre_pagina;?></title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
    <?php include("../../navbar.php")?>
    <div id="wrapper" class="">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid d-print-none">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb d-print-none">
						<li class="breadcrumb-item">
							<a href="#">Recaudación</a>
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina;?></li>
					</ol>
					
					<!--Form Filtro !-->
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button  class="btn btn-primary btn-sm" >
										<i class="fas fa-search"></i> Buscar
									</button>
									
									<button type="button" class="btn btn-success btn-sm nuevo" >
										<i class="fas fa-plus"></i> Nuevo
									</button>
									<button hidden class="btn btn-info btn-sm" onclick="window.print()" type="button">
										<i class="fas fa-print"></i> Imprimir
									</button>
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
						</div>
						<div class="row mb-2"> 
							<div class="col-1">
								<label for="nombre_condonaciones">No. Economico:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div> 
							<div class="col-1">
								<label >Usuario:</label>
							</div>	
							<div class="col-2">			
								<?php echo generar_select($link, "usuarios", "id_usuarios", "nombre_usuarios", true, false, false, $_COOKIE["id_usuarios"])?>
							</div> 
						</div>
					</form>
					<hr>
					<div class="card mb-3 d-print-none " id="tableCard">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina;?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								<table class="table table-bordered" id="tableData" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th class="text-center d-print-none"></th>
											<th class="text-center">Id</th>
											<th class="text-center">Usuario</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Empresa</th>
											<th class="text-center">Unidad</th>
											<th class="text-center">Motivo</th>
											<th class="text-center">Derrotero</th>
											<th class="text-center">Monto</th>
											<th class="text-center">Concepto</th>
											<th class="text-center">Propietario</th>
											<th class="text-center">Estatus</th>
										</tr>
										<tr class="d-print-none no_exportar">
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center">
												<?php echo select_general($link, "empresas", "id_empresas", "nombre_empresas", false, false, false, 0, 4);?>
											</th>
											<th class="text-center">
												<input type="text" id="buscar_unidad" class="form-control" data-indice="5" placeholder="Buscar Unidad">
											</th>
											<th class="text-center">
												<?php echo select_general($link, "motivosAbonoUnidades", "id_motivosAbono", "nombre_motivosAbono", false, false, false, 0, 6);?>
											</th>
											<th class="text-center">
												<?php echo select_general($link, "derroteros", "id_derroteros", "nombre_derroteros", false, false, false, 0, 7);?>
											</th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center">
												<?php echo select_general($link, "propietarios", "id_propietarios", "nombre_propietarios", false, false, false, 0, 10);?>
											</th>
											<th class="text-center"></th>
										</tr>
									</thead>
									<tbody id="tabla_DB">
										<tr>
											<td colspan="11"><h3 class="text-center">Cargando...</h3></td>
										</tr>
									</tbody>
									<tr>
										<th colspan="8" >Total</th>
										<th class="text-center" id="total"></th>
										<th colspan="3" ></th>
									</tr>
								</table>
								<div class="mensaje"></div>
							</div>
						</div>
						<!--<div class="card-footer small text-muted">Ultima Modificación Ayer 12pm</div>-->
					</div>
				</div>
				<!-- /.container-fluid -->
				
				<!-- Sticky Footer -->
				<footer class="sticky-footer">
					<div class="container my-auto ">
						<div class="copyright text-center my-auto">
							<span class="d-print-none">Copyright © Glifo Media 2018</span>
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
		
		
		<div class="d-print-block p-2" id="ticket">
		</div>
		<div class="d-print-block p-2" id="carta">
		</div>
		
		
    <?php include("../../scripts.php")?>
    <?php include("forms/form_general.php");?>
		
		<script src="../../plugins/pos_print/websocket-printer.js" > </script>
    <script src="js/abono_general.js?v=<?php echo date('Y-m-d-H:i:s'); ?>"></script>
    <script src="js/buscar.js"></script>
	</body>
</html>
