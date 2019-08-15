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
	
	$consulta = "SELECT *, condonaciones.datos_cancelacion AS datos_cancelacion_condonaciones FROM condonaciones 
	LEFT JOIN motivos_condonacion USING(id_motivo_condonacion)
	LEFT JOIN usuarios USING(id_usuarios)
	LEFT JOIN tarjetas USING(tarjeta)
	LEFT JOIN conductores USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN empresas ON empresas.id_empresas = tarjetas.id_empresas
	WHERE tarjetas.id_administrador = {$_SESSION["id_administrador"]}
	AND  DATE(fecha_condonaciones) BETWEEN '{$_GET['fecha_inicial']}' AND '{$_GET['fecha_final']}'
	
	";
	if($_GET["num_eco"] != ''){
		$consulta.= " AND num_eco = {$_GET["num_eco"]} ";
		
	}
	
	// console_log($consulta);
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			// echo "<pre>$consulta</pre>";
			die("<div class='alert alert-danger'>No hay registros</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
		
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
				<th class="text-center"></th>
				<th class="text-center">Folio</th>
				<th class="text-center">Fecha</th>
				<th class="text-center">Fecha Cuenta	</th>
				<th class="text-center">Tarjeta</th>
				<th class="text-center">Empresa</th>
				<th class="text-center">Unidad</th>
				<th class="text-center">Conductor</th>
				<th class="text-center">Motivo</th>
				<th class="text-center">Monto</th>
				<th class="text-center">Observaciones</th>
				<th class="text-center">Usuario</th> 
				<th class="text-center">Estatus</th> 
			</tr>
		</thead>
		<tbody >
			<?php 
				foreach($filas as $index=>$fila){
				?>
				<tr>
					<td class="text-center"> 
						<?php if($fila["estatus_condonaciones"] != "Cancelado"){
							$totales+=$fila['monto_condonaciones'];
						?>
						<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_condonaciones']?>'>
							<i class="fas fa-times"></i>
						</button>
						<button class="btn btn-info imprimir" data-id_registro='<?php echo $fila['id_condonaciones']?>'>
							<i class="fas fa-print"></i>
						</button>
						<?php
						}
						?>
						
					</td>
					<td class="text-center"><?php echo $fila['id_condonaciones'];?></td>
					<td class="text-center"><?php echo $fila['fecha_condonaciones'];?></td>
					<td class="text-center"><?php echo $fila['fecha_tarjetas'];?></td>
					<td class="text-center"><?php echo $fila['tarjeta'];?></td>
					<td class="text-center"><?php echo $fila['nombre_empresas'];?></td>
					<td class="text-center"><?php echo $fila['num_eco'];?></td>
					<td class="text-center"><?php echo $fila['nombre_conductores'];?></td>
					<td class="text-center"><?php echo $fila['motivo_condonacion'];?></td>
					<td class="text-center"><?php echo $fila['monto_condonaciones'];?></td>
					<td class="text-center"><?php echo $fila['observaciones_condonaciones'];?></td>
					<td class="text-center"><?php echo $fila['nombre_usuarios'];?></td>
					<td class="text-center">
						<?php 
							echo $fila['estatus_condonaciones'];
							if( $fila["estatus_condonaciones"] == "Cancelado"){
								echo "<br>".$fila["datos_cancelacion_condonaciones"];
							}
						?>
					</td>
					
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
				<td></td>
				<td></td>
				<td colspan="">$<?php echo  number_format($totales);?></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	
	
	<?php
		
		
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>			