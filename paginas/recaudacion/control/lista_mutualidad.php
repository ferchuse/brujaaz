<?php
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$tarjeta = $_GET['tarjeta'];
	
	$consulta = "SELECT * FROM mutualidad 
	LEFT JOIN recaudaciones USING(id_recaudaciones)
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN usuarios USING(id_usuarios)
	LEFT JOIN unidades USING(id_unidades) 
	LEFT JOIN conductores USING(id_conductores) 
	WHERE mutualidad.id_administrador = {$_SESSION["id_administrador"]}
	";
	$consulta.=  " AND  DATE(fecha_mutualidad) BETWEEN '{$_GET['fecha_inicial']}'
	AND '{$_GET['fecha_final']}'";
	
	foreach($_GET as $name=>$value){
		$i++;
		if($value != '' && $i > 2){ //Agrega filtros saltando fechas (2)
			$consulta.= " AND  $name = '$value'";
		}
	}
	
	// if($_GET["id_usuarios"] != ''){
	// $consulta.= " AND id_usuarios = {$_GET["id_usuarios"]} ";
	// }
	// if($_GET["id_empresas"] != ''){
	$consulta.= " ORDER BY id_mutualidad DESC";
	// }
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>No hay registros</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
		
			$filas[] = $fila ;
			
		}
		
	?>
	<table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th class="text-center"></th>
				<th class="text-center">Folio</th>
				<th class="text-center">Fecha</th>
				<th class="text-center">Recaudación</th>
				<th class="text-center">Empresa</th>
				<th class="text-center">Unidad</th>
				<th class="text-center">Conductor</th>
				<th class="text-center">Monto</th>
				<th class="text-center">Usuario</th> 
				<th class="text-center">Estatus</th> 
			</tr>
		</thead>
		<tbody >
			<?php 
				$totales= 0;
				foreach($filas as $index=>$fila){
					
				?>
				<tr>
					
					<td class="text-center"> 
						<?php if($fila["estatus_mutualidad"] != "Cancelado"){
							$totales+=$fila['monto_mutualidad'];
							?>
							<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['id_mutualidad']?>'>
								<i class="fas fa-print"></i>
							</button>
							<?php
							}
						?>
					</td>
					<td class="text-center"><?php echo $fila['id_mutualidad'];?></td>
					<td class="text-center"><?php echo $fila['fecha_mutualidad'];?></td>
					<td class="text-center"><?php echo $fila['nombre_recaudaciones'];?></td>
					<td class="text-center"><?php echo $fila['nombre_empresas'];?></td>
					<td class="text-center"><?php echo $fila['num_eco'];?></td>
							<td class="text-center"><?php echo $fila['nombre_conductores'];?></td>
							<td class="text-center"><?php echo $fila['monto_mutualidad'];?></td>
							<td class="text-center"><?php echo $fila['nombre_usuarios'];?></td>
							<td class="text-center"><?php echo $fila['estatus_mutualidad'];?></td>
							
				</tr> 
				<?
				}
			?>
			<tr>	
				
				<td colspan=""><?php echo  mysqli_num_rows($result);?> Registros</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td colspan="">$<?php echo  number_format($totales);?></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	
	<pre hidden>
		<?php echo $consulta;?>
	</pre>
	<?php
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>			