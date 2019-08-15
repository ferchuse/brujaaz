<?php
	$nombre_pagina = "abonar_unidades";
	$id= "id_abonarunidades";
	$tabla = "abonar_unidades"; 
	
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	include("../../paginas/login/login_check.php");
	$link = Conectarse();
	$fecha_inicial = date("Y-m-01");
	
	
	// $q_saldo= "SELECT saldo FROM estado_cuenta 
	// WHERE id_unidades = {$_GET['id_unidades']} AND fecha_estado_cuenta = {$fecha_inicial}";
	
	// $result_saldo = mysqli_query($link, $q_saldo) or die("Error $q_saldo". mysqli_error($link));
	
	
	// while($fila = mysqli_fetch_assoc($result_saldo)){
	
	// $fila_saldo[] = $fila ;
	
	// }
	
	
	
	$consulta= 
	"SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_cargos) AS fecha_estado_cuenta, 
	motivo,
	cargo,
	0 AS abono,
	'' AS observaciones
	FROM
	cargos_unidades
	WHERE
	id_unidades ={$_GET['id_unidades']} 
	AND DATE(fecha_cargos) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	
	UNION
	SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_cargos) AS fecha_estado_cuenta,
	motivo,
	cargo,
	0 AS abono,
	
	'' AS observaciones
	FROM
	cargos_unidades
	WHERE
	id_unidades ={$_GET['id_unidades']}
	AND DATE(fecha_cargos) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	
	UNION
	SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_aplicacion) AS fecha_estado_cuenta,
	CONCAT(
	'Abono General #',
	id_abonogeneral
	) AS motivo,
	0 AS cargo,
	monto_abonogeneral AS abono,
	concepto_abonogeneral AS observaciones
	FROM
	abono_general
	LEFT JOIN unidades USING (id_unidades)
	WHERE
	id_unidades ={$_GET['id_unidades']} 
	AND DATE(fecha_aplicacion) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	AND estatus_abono <> 'Cancelado'
	
	UNION
	SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_abonos) AS fecha_estado_cuenta,
	CONCAT(
	'Abono #',
	id_abonos_unidades
	) AS motivo,
	0 AS cargo,
	abono_unidad AS abono,
	'' AS observaciones
	FROM
	abonos_unidades
	LEFT JOIN tarjetas USING (tarjeta)
	LEFT JOIN unidades USING (id_unidades)
	WHERE
	id_unidades ={$_GET['id_unidades']} 
	AND DATE(fecha_abonos) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	AND estatus_abonos <> 'Cancelado'
	
	UNION
	SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_aplicacion) AS fecha_estado_cuenta,
	CONCAT(
	'Retiro a Cuenta de Liquidación #',
	id_traspaso
	) AS motivo,
	monto AS cargo,
	0 AS abono,

	concepto_traspaso AS observaciones
	FROM
	traspaso_utilidad
	LEFT JOIN traspaso_utilidad_unidades USING (id_traspaso)
	WHERE
	id_unidades = {$_GET['id_unidades']}
	AND DATE(fecha_aplicacion) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	
	AND estatus_traspaso <> 'Cancelado'
	
	UNION
	SELECT
	dame_saldo('{$_GET["fecha_inicial"]}' , {$_GET['id_unidades']}) AS saldo_anterior,
	DATE(fecha_condonaciones) AS fecha_estado_cuenta,
	CONCAT(
	'Condonacion de Tarjeta #',
	tarjeta
	) AS motivo,
	0 AS cargo,
	0 AS abono,
	observaciones_condonaciones AS observaciones
	FROM
	condonaciones
	LEFT JOIN tarjetas USING (tarjeta)
	LEFT JOIN unidades USING (id_unidades)
	WHERE
	id_unidades = {$_GET['id_unidades']}
	AND DATE(fecha_condonaciones) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	
		
	ORDER BY fecha_estado_cuenta
	";
	
	
	$result_detalle = mysqli_query($link, $consulta) or die("Error en <pre>$consulta</pre>". mysqli_error($link));
	
	while($fila = mysqli_fetch_assoc($result_detalle)){
		
		$filas[] = $fila ;
		
	}
	// echo var_dump($filas);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Detalle Estado de Cuenta</title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
    <?php include("../../navbar.php")?>
    <div id="wrapper" class="">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">
					
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Saldos</a>
						</li>
            <li class="breadcrumb-item active">Estado de Cuenta de Unidad </li>
					</ol> 
					<pre hidden >
						<?php echo $consulta;?>
					</pre>
					
					<div class="row mb-2">
						<div class="col-12">
							<div class="col-12 mb-3">
								<button hidden class="btn btn-success btn-sm" >
									<i class="fas fa-search"></i> Buscar
								</button>
								<button class="btn btn-info btn-sm d-print-none" onclick="window.print()">
									<i class="fas fa-print"></i> Imprimir
								</button>
							</div>
							
						</div>
					</div>
					
					
					<form id="form_filtro" hidden autocomplete="off">
						<div class="row mb-2">
							<div class="col-2">
								<label for="nombre_condonaciones">Fecha Inicial:</label>
							</div>
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" value="<?php echo date("Y-m-01");?>">
							</div>  
							<div class="col-2">
								<label for="nombre_condonaciones">Fecha Final:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="date" name="fecha_final" id="fecha_final" value="<?php echo date("Y-m-d");?>">
							</div> 
						</div>
						<div class="row mb-2"> 
							<div class="col-2">
								<label for="nombre_condonaciones">No. Economico:</label>
							</div>	
							<div class="col-4">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div>  
						</div>
						<div class="row mb-2">
							<div class="col-2">
								<label for="">Empresa:</label>
							</div>	
							<div class="col-4">			
								<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", true)?>
							</div> 
						</div>
					</form>
					<hr>
					
					<div class="d-print-block" id="reporte_impresion">
						<legend>
							Estado de Cuenta de la Unidad <b><?php echo $_GET["num_eco"]?></b>
							Propietario <b><?php echo $_GET["nombre_propietarios"]?></b>
							Del <b><?php echo $_GET["fecha_inicial"]?></b> al <b><?php echo $_GET["fecha_final"]?></b>
						</legend>
						
						
						<div class="table-responsive d" id="tabla_registros">
							<table class="table table-bordered table-condensed">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Motivo</th>
										<th>Cargo</th>
										<th>Abono</th>
										<th>Saldo</th>
										<th>Observaciones</th>
									</tr>
								</thead>
								<tbody> 
									<tr>
										<td><?php echo $_GET["fecha_inicial"]?></td>
										<td>Saldo Anterior </td>
										<td>-</td>
										<td>-</td>
										<td><?php echo $filas[0]["saldo_anterior"];?></td>
										<td></td>
										
									</tr>
									
									<?php 
										$saldo = $filas[0]["saldo_anterior"];
										
										foreach($filas as $i=>$fila){
											$total_cargos+= $fila["cargo"];
											$total_abonos+= $fila["abono"];
											
											if($fila["cargo"] > 0){
												$saldo-= $fila["cargo"];
											}
											else{
												$saldo+= $fila["abono"];
											}
										?>
										<tr>
											<td><?php echo $fila["fecha_estado_cuenta"]?></td>
											<td><?php echo $fila["motivo"]?></td>
											<td><?php echo $fila["cargo"]?></td>
											<td><?php echo $fila["abono"];?></td>
											<td><?php echo number_format($saldo);?></td>
											<td><?php echo $fila["observaciones"]?></td>
										</tr>
										<?php
										}
									?>
									
									<tr class="h5 bg-secondary text-light">
										<td colspan="2"> TOTALES</td>
										<td><?php echo number_format($total_cargos);?></td>
										<td><?php echo  number_format($total_abonos);?></td>
										<td><?php echo  number_format($filas[0]["saldo_anterior"] + $total_abonos - $total_cargos);?></td>
									</tr>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div>
				
				
				<!-- Sticky Footer -->
				<footer class="sticky-footer">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright © Glifo Media 2018</span>
						</div>
					</div>
				</footer>
				
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /.content-wrapper -->
	</div>
	<!-- /#wrapper -->
	
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>		
	
	<div class="d-print-block  p-2 " id="ticket" >
	</div>
	
	<?php
		// include("forms/form_tarjetas.php");
		include("../../scripts.php")
	?>
	
</body>
</html>
