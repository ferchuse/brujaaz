<?php
	$nombre_pagina = "Orden de trabajo";
	
?>

<?php
	include('../../conexi.php');
	$link = Conectarse();
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
    <title>Recaudación de <?php echo $nombre_pagina;?></title>
        <?php include('../../styles.php')?>
	</head>
	<body id="page-top">
    <?php include("../../navbar.php")?>
    <div id="wrapper" class="">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb d-print-none">
						<li class="breadcrumb-item">
							<a href="#">Movimientos</a>
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina;?></li>
					</ol>
					
					<div class="form-inline d-print-none" id="form_buscador">
                        <div class="form-group mx-sm-3 mb-2">
							<label for="" class="col-sm col-form-label">No.Eco:</label>
							<input type="number" class="form-control" value="" id="no_eco" min="0">
							<button type="button" id="btn_buscar" title="Buscar No.Eco" class="btn btn-outline-dark"><i class="fas fa-search"></i></button>
						</div>
					</div>
					<div class="card mb-3 d-print-none" id="tableCard">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina;?>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="tableData" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th class="text-center">No.Eco</th>
											<th class="text-center">Operador</th>
											<th class="text-center">VTO</th>
											<th class="text-center">Num Licencia</th>
											<th class="text-center">Vigencia Licencia</th>
											<th class="text-center">RFC</th>
											<th class="text-center">Dias de trabajo</th>
											<th class="text-center d-print-none"></th>
										</tr>
									</thead>
									<tbody id="tabla_DB">
										<!--<tr>
											<td colspan="8"><h3 class="text-center">Cargando...</h3></td>
										</tr>-->
									</tbody>
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
		
		<div class="d-print-inline d-none p-2 carta" hidden id="imprimir">
		</div>
    <?php include("../../scripts.php")?>
    <script src="js/orden_trabajo.js"></script>
    <script src="js/buscar.js"></script>
	</body>
</html>