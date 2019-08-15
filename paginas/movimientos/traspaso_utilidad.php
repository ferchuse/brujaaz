<?php
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Traspaso de Utilidad";
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
    <title><?php echo $nombre_pagina;?></title>
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
							<a href="#">Movimientos</a> 
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina; ?></li>
					</ol>
					 
					<form id="form_filtro" autocomplete="off">
						<div class="col-12">
							<button  type="submit" id="btn_buscar"  class="btn btn-primary" >
								<i class="fas fa-search"></i> Buscar
							</button> 
							<button type="button" class="btn btn-success" id="nuevo">
								<i class="fas fa-plus"></i> Nuevo
							</button>
						</div>
						<div class="row"> 
							<label class="col-2">Fecha Inicial:</label>
							<div class="col-2">
								<input class="form-control" name="fecha_inicial" type="date" id="fecha_inicial" value="<?php echo date("Y-m-d")?>">
							</div>
						</div>	
						<div class="form-row">
							<label class="col-2">Fecha Incial:</label>
							<div class="col-2">
								<input class="form-control" name="fecha_final" type="date" id="fecha_final" value="<?php echo date("Y-m-d")?>">
							</div>
						</div>
						<div class="form-row" hidden> 
							<label class="col-2">Num Eco:</label>
							<div class="col-2">
								<input class="form-control" name="num_eco" type="text" >
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
							
							<div class="table-responsive">
								<table class="table table-bordered" id="tabla_registros" width="100%" cellspacing="0" >
									<thead>
										<tr>
											<th class="text-center">Acciones</th>
											<th class="text-center">Folio</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Fecha Aplicación</th>
											<th class="text-center">Beneficiario</th>
											<th class="text-center">Concepto</th>
											<th class="text-center">Monto</th>
											<th class="text-center">Estatus</th>
											<th class="text-center">Usuario</th>
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
		<div class="d-print-inline d-none p-2 carta"   id="impresion">
			
		</div>
		
    <?php 
			include("../../scripts.php");
			include('forms/forms_traspaso.php');
		?>
    <script src="js/traspaso_utilidad.js"></script>
    <script src="../catalogos/js/buscar.js"></script>
	</body>
</html>
