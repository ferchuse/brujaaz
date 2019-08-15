<?php
	include("../../paginas/login/login_check.php");
	include('../../conexi.php');
	include('../../funciones/generar_select.php');
	$link = Conectarse();
	$nombre_pagina = "Guias";
	//include('control/select_general.php');
	//include('../../funciones/generar_select.php');
	
	//$dt_fecha_inicial = new DateTime("first day of this month");
	$dt_fecha_final = new DateTime("last day of this month");
	
	//$date_inicial = $dt_fecha_inicial->format("Y-m-d");
	$date_final = $dt_fecha_final->format("Y-m-d");
	
?>
<!DOCTYPE html>
<html lang="es_mx">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Guias </title>
		<?php include('../../styles.php')?>
		<link href="../../css/corrida.less" type="text/css"  rel="stylesheet/less" >
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
							<div class="row">
								<div class="col-sm-4">
									<div class="plane">
										
										<ol class="cabin fuselage">
											<?php 
												$asientos = 43;
												$filas_asientos = ceil($asientos /4);
												
												$num_asiento = 1;
												for($i = 1; $i <= $filas_asientos; $i++){
												?>
												<li class="fila_asientos">
													<ol class="seats" type="1">
														<?php
															for($j = 1; $j<= 4; $j++){ ?>
															<li class="seat">
																
																<input type="checkbox" id="<?php echo $num_asiento ;?>" />
																<label for="<?php echo $num_asiento ;?>" ><?php echo $num_asiento ;?> 
																</label>
															</li>
															<?php
																$num_asiento++;
																if($num_asiento > $asientos){break;}
															}
														?>
														
													</ol>
												</li>
												<?php
												}
											?>
										</ol>
										
									</div>
								</div>
								<div class="col-sm-8">
									<form id="form_asientos" autocomplete="off">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Num Asiento</th>
													<th>Tipo de Boleto</th>
													<th>Nombre </th>
													<th>Precio</th>
												</tr>
											</thead>
											<tbody id="resumen_boletos">
												
											</tbody>
										</table>
										<div class="row">
											<div class="col-12 ">
												<div class="form-group float-right" >
													<label class="h3">TOTAL: </label>
													<input id="importe_total" readonly class="form-control h3">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<button class="btn btn-lg btn-success float-right" >
													<i class="fas fa-check"></i> Finalizar Compra
												</button>
											</div>
										</div>
									</form>
								</div>
								
								
								</div>
								
									</div>
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
		
		<div class="d-print-block p-2" hidden id="ticket">
		</div>
		<?php include("../../scripts.php")?>
		<?php include("forms/form_corrida.php");?>
		<?php include("forms/form_boletos.php");?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
		<script src="js/corrida.js"></script>
		
	</body>
</html>					