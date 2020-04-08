<?php
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/dame_permiso.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$tarjeta = $_GET['tarjeta'];
	
	$consulta = "SELECT * FROM tarjetas 
	
	LEFT JOIN derroteros USING(id_derroteros)
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN conductores  USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN roles USING(id_roles)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE tarjetas.id_administrador = '{$_SESSION["id_administrador"]}'
	AND  DATE(fecha_creacion) BETWEEN '{$_GET['fecha_inicial']}' AND '{$_GET['fecha_final']}'
	
	";
	if($_GET["num_eco"] != ''){
		$consulta.= " AND num_eco = '{$_GET["num_eco"]}' ";
	}
	if($_GET["tarjeta"] != ''){
		$consulta.= " AND tarjeta = '{$_GET["tarjeta"]}' ";
	}
	if($_GET["id_usuarios"] != ''){
		$consulta.= " AND tarjetas.id_usuarios = '{$_GET["id_usuarios"]}' ";
	}
	
	// console_log($consulta);
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			// echo "<pre>$consulta</pre>";
			die("<div class='alert alert-danger'>No hay registros</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas[] = $fila ;
			
		}
		
	?>
	<pre hidden >
		Id_empresas <?php echo $_SESSION["id_empresas"]?>
		Session Id <?php echo session_id()?>
		Sesiion Estatus <?php echo session_status()?>
		Consulta <?php echo $consulta?>
	</pre>
	<table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th class="text-center">Imprimir</th>
				<th class="text-center">Tarjeta</th>
				<th class="text-center">Fecha Creación	</th>
				<th class="text-center">Fecha Cuenta	</th>
				<th class="text-center">Empresa</th>
				<th class="text-center">Num Eco</th>
				<th class="text-center">Estatus</th>
				<th class="text-center">Usuario</th> 
			</tr>
		</thead>
		<tbody >
			<?php 
				foreach($filas as $index=>$fila){
				?>
				<tr>
					<td class="text-center"> 
						<?php if($fila["estatus_tarjetas"] != 'Cancelado'){?>
							<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['tarjeta']?>'>
								<i class="fas fa-times"></i>
							</button>
							<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['tarjeta']?>'>
								<i class="fas fa-print"></i>
							</button>
							<?php
							}
						?>
					</td>
					<td class="text-center"><?php echo $fila['tarjeta'];?></td>
					<td class="text-center"><?php echo $fila['fecha_creacion'];?></td>
					<td class="text-center"><?php echo $fila['fecha_tarjetas'];?></td>
					<td class="text-center"><?php echo $fila['nombre_empresas'];?></td>
					<td class="text-center"><?php echo $fila['num_eco'];?></td>
					<td class="text-center">
						
						<?php echo $fila['estatus_tarjetas'];?> <br>
						<?php if($fila["estatus_tarjetas"] == 'Cancelado'){
							echo $fila['datos_cancelacion'];
						}
						?>
						
					</td>
					<td class="text-center"><?php echo $fila['nombre_usuarios'];?></td>
					
				</tr> 
				<?
				}
			?>
			<tr>	
				<td colspan="11"><?php echo  mysqli_num_rows($result);?> Registros</td>
			</tr>
		</tbody>
	</table>
	
	
	<?php
		
		
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>			