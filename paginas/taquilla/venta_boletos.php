<?php
	include("../../paginas/login/login_check.php");
	include('../../conexi.php');
	include('../../funciones/generar_select.php');
	$link = Conectarse();
	$nombre_pagina = "Venta de Boletos";
	//include('control/select_general.php');
	//include('../../funciones/generar_select.php');
	
	//$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	//$date_inicial = $dt_fecha_inicial->format("Y-m-d");
	$date_final = $dt_fecha_final->format("Y-m-d");
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Venta de Boletos </title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
		<?php include("../../navbar.php")?>
		<div id="wrapper" class="d-print-none">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb d-print-none">
						<li class="breadcrumb-item">
							<a href="#">Taquilla</a>
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina;?></li>
					</ol>
					
					<div class="card card-primary">
						<div class="card-body">
							
							<ul class="nav nav-pills nav-justified mb-4">
								<li class="nav-item">
									<a class="nav-link active" id="pill_corridas" data-toggle="pill" href="#tab_corridas">Corridas</a>
								</li>
								<li class="nav-item disabled">
									<a class="nav-link " id="pill_venta" data-toggle="pill" href="#tab_boletos">Venta de Boletos</a>
								</li>
								
							</ul>
							
							<div class="tab-content">
								
								
								<div class="tab-pane   active" id="tab_corridas">	
									<div class="row">
										<div class="col-12">
											<button type="button" class="btn btn-success mb-2 nuevo">
												<i class="fas fa-plus"></i> Nueva
											</button>
											<label>
												Empresa:
											<label>
											<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", true	);	?>
										</div>
									</div>
									<div class="card">
										<div class="card-header">
											<h3 >Lista de Corridas
												
												<button disabled type="button" class="btn btn-primary float-right" id="btn_pagar">
													<i class="fas fa-dollar-sign"></i> Pagar <span id="span_num_selected">0</span>
												</button>
											</h3>
										</div>
										<div class="card-body" id="lista_corridas">
											
										</div>
									</div>
								</div>
								
								<div class="tab-pane  " id="tab_boletos">
									<hr>
									<div class="row">
										<div class="form-group col-2"> 
											<label>Corrida #	</label>
											<input name="id_corridas" id="id_corridas" class="form-control" readonly value="<?php echo $_GET["id_corridas"]?>">
										</div>
										<div class="form-group col-2"> 
											<label>Num Eco:	</label>
											<input id="num_eco" name="num_eco" class="form-control"  value="<?php echo $_GET["num_eco"]?>" readonly>
										</div>
										<div class="form-group col-2"> 
											<button class="btn btn-default btn-sm mt-4" id="btn_test">
													<i class="fas fa-test"></i> Probar Impresora
												</button>
										</div>
									</div>	
									<hr>
									<form id="form_boletos" class="was-validated" autocomplete="off">
										<div class="row">
											<div class="col-1  form-group">
												<label>Cantidad:	</label>
												<input min="1" required id="cantidad" type="number" name="cantidad" value="1" class="form-control cantidad" >
											</div>
											<div class="col-3  form-group">
												<label>Destino:	</label>
												<?php include("boletos_iv/destinos.php")?>
											</div>
											<div class="col-2 form-group">
												<label>Precio:	</label>
												<input id="precio" name="precio" readonly class="form-control precio" >
											</div>
											<div class="col-2 form-group">
												<label>Importe:	</label>
												<input id="importe" name="importe" readonly class="form-control importe" >
											</div>
											<div class="col-2 form-group ">
												<button class="btn btn-success mt-4" >
													<i class="fas fa-dollar-sign"></i> Vender
												</button>
											</div>
										</div>
									</form>
									
									<div class="card card-primary mt-4 ">
										<div class="card-header text-center">
											Resumen de Ventas
										</div>
										<div class="card-body" id="lista_boletos">
											<h3 class="text-center">Cargando <i class="fas fa-spinner fa-pulse"></i></h3>
										</div>
									</div>
								</div>
								
								
								
							</div><!-- /.tab-content-->
						</div><!-- /.card-body-->
					</div><!-- /.card -->
				</div><!-- /.container-fluid -->
				
				
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
		<form id="form_pagar_corridas">
		<input type="number" id="total_pago" name="total_pago">
		</form>
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded d-print-none" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		
		<div class="d-print-block p-2" style="max-width:100mm;" hidden id="ticket" >
		</div>
		<?php include("../../scripts.php")?>
		<script src="../../plugins/pos_print/websocket-printer.js" > </script>
		<?php include("boletos_iv/form_corridas.php");?>
		
		<script src="boletos_iv/venta_boletos.js?v=<?= date("Y-m-d-H-i-s")?>"></script>
		
	</body>
</html>																												