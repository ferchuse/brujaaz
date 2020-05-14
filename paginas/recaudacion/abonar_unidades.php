<?php
	$nombre_pagina = "abonar_unidades";
	$id= "id_abonarunidades";
	$tabla = "abonar_unidades"; 
	
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	include("../../paginas/login/login_check.php");
	$link = Conectarse();
	$_COOKIE["id_recaudaciones"];
	
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Abonar a Unidades</title>
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
            <li class="breadcrumb-item active">Abonar Unidades</li>
					</ol>
					
					<div class="row mb-2">
						<div class="col-12">
							<div class="col-12 mb-3">
								
								<button class="btn btn-info btn-sm" id="btn_generar_tarjeta">
									<i class="fas fa-copy"></i> Generar Tarjeta
								</button>
								<a href="abonos_unidades.php" class="btn btn-warning btn-sm" >
									<i class="fas fa-arrow-left"></i> Regresar
								</a>
							</div>
							
						</div>
					</div>
					
					<hr>
					
					<?php include("forms/form_abonar_unidades.php");?>
					
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
		
		<div class="d-print-block p-1 " hidden id="ticket" style="max-height: 30cm;">
			Ticket
		</div>
		
		<?php
			include("forms/form_tarjetas.php");
			include("../../scripts.php")
		?>
		<script src="../../plugins/pos_print/websocket-printer.js" > </script>
		<script src="js/abonar_unidades.js?v=<?= date("d-m-Y-H-i-s")?>"></script>
	</body>
</html>
