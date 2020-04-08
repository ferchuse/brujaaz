<?php
	$nombre_pagina = "abonar_unidades";
	$id= "id_abonarunidades";
	$tabla = "abonar_unidades"; 
	
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
    <title>Estado de Cuenta</title>
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
            <li class="breadcrumb-item active">Estado de Cuenta</li>
					</ol>
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button class="btn btn-primary btn-sm" >
										<i class="fas fa-search"></i> Buscar
									</button>
									<button class="btn btn-info btn-sm" onclick="window.print()" type="button">
										<i class="fas fa-print"></i> Imprimir
									</button>
								</div>
								
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-sm-1">
								<label for="fecha_inicial">Fecha Inicial:</label>
							</div>
							<div class="col-sm-2">			
								<input class="form-control" type="date" name="fecha_inicial" id="fecha_inicial" value="<?php echo date("Y-m-01");?>">
							</div>  
							<div class="col-sm-1">
								<label for="fecha_final">Fecha Final:</label>
							</div>	
							<div class="col-sm-2">			
								<input class="form-control" type="date" name="fecha_final" id="fecha_final" value="<?php echo date("Y-m-d");?>">
							</div> 
							<div class="col-1">
								<label >Empresa:</label>
							</div>	
							<div class="col-3">			
								<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", true)?>
							</div> 
						</div>
						<div class="row mb-1"> 
							<div class="col-sm-1">
								<label for="">Num Eco:</label>
							</div>	
							<div class="col-sm-2">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div>
							<div class="col-sm-1">
								<label for="">Estatus:</label>
							</div>	
							<div class="col-sm-2">			
								<select class="form-control" name="estatus_unidades">
									<option  selected >Todos</option>
									<option  >Alta</option>
									<option >Baja</option>
									<option >Inactivo</option>
								</select>
							</div>
							<div class="col-1">
								<label >Propietario:</label>
							</div>
							<div class="col-3">			
								<?php
									echo generar_select($link, "propietarios", "id_propietarios", "nombre_propietarios", true);
								?>
							</div>
						</div>
					</form>
					<hr>
					
					<div class="table-responsive" id="tabla_registros">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>Num Eco</th>
									<th>Empresa</th>
									<th>Titular</th>
									<th>Estatus</th>
									<th>Saldo Anterior</th>
									<th>Ingreso Bruto</th>
									<th>Cargos Admvos</th>
									<th>50% Admon GAAZ</th>
									<th>50% Admon Empresa</th>
									<th>Seguro Interno</th>
									<th>Traspaso Titulares</th>
									<th>Saldo</th>
									<th>Cargos Retenidos</th>
									<th>Saldo Disponible</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="10"><h3>Presiona Buscar</h3></td>
								</tr>
							</tbody>
						</table>
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
		<script src="js/estado_cuenta.js"></script>
	</body>
</html>
