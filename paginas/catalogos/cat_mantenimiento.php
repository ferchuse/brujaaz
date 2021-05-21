<?php //include("propietario.class.php")?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<title>Catálogo de Mantenimiento</title>
		<?php include('../../styles.php');?>
	</head>
	
	<body id="page-top">
		<?php include("../../navbar.php")?>
		<div id="wrapper">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Catálogos</a>
						</li>
						<li class="breadcrumb-item active">Mantenimiento</li>
					</ol>
					
						<div class="col-12 mb-3">
							<button type="button" id="nuevo" class="btn btn-outline-success" title="Nuevo"> 
								<i class="fas fa-plus"></i>
								Nuevo
							</button>
						</div>
							
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de Mantenimiento
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th class="text-center">Tipo Mantenimiento</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody id="lista_registros">
										<tr>
											<td colspan="3"><h3 class="text-center">Cargando...</h3></td>
										</tr>
									</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
			<!-- /.container-fluid -->
			
			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright © Glifo Media 2021</span>
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
	<?php include("../../scripts.php")?>
	<?php include("forms/form_mantenimiento.php")?>
	<script src="js/mantenimiento.js"></script>
</body>

</html>
