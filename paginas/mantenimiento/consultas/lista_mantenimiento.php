<?php 
	
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$totales = array_fill (  0 ,  1 , 0 ); //Llena el array totales con 10 elementos en 0s
	
	
	
	$consulta = "SELECT * FROM mantenimiento
	
	LEFT JOIN cat_tipo_mantenimiento USING(id_tipo_mantenimiento) 
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE usuarios.id_administrador = {$_COOKIE["id_administrador"]}
	";
	
	$consulta.=  " 
	AND  DATE(fecha)
	BETWEEN '{$_GET['fecha_inicial']}' 
	AND '{$_GET['fecha_final']}'"; 
	
	$consulta.=  " ORDER BY id_mantenimiento"; 
	
	
	
	$result = mysqli_query($link,$consulta);
	
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas[] = $fila ;
		}
	?>
	
	<pre hidden>
		Id_empresas <?php echo $_COOKIE["id_empresas"]?>
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
				<th class="text-center">Num Eco</th>
				<th class="text-center">Tipo de Servicio</th>
				<th class="text-center">Kilometraje</th>
				<th class="text-center">Proximo Servicio</th>
				<th class="text-center">Observaciones</th>
				<th class="text-center">Usuario</th>
			</thead>
			<tbody id="tabla_DB">
				<?php 
					foreach($filas as $index=>$fila){
					?>
					<tr>
						<td class="text-center"> 
							<?php if($fila["estatus"] != 'Cancelado'){?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_seguro_interno']?>'>
									<i class="fas fa-times"></i>
								</button>
								<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['id_seguro_interno']?>'>
									<i class="fas fa-print"></i>
								</button>
								<?php
								}
								else{ ?>
								<span class="badge badge-danger small">
									
									<?php echo $fila['estatus']?>
									<?php echo $fila['datos_cancelacion']?>
								</span>
								<?php
								}
							?>
						</td>
						<td><?php echo $fila["id_mantenimiento"]?></td>
						<td><?php echo $fila["fecha"]?></td>
						<td><?php echo $fila["num_eco"]?></td>
						<td><?php echo $fila["tipo_mantenimiento"]?></td>
						<td><?php echo $fila["kilometraje"]?></td>
						<td><?php echo $fila["fecha_proximo"]?></td>
						<td><?php echo $fila["observaciones"]?></td>
						<td><?php echo $fila["nombre_usuarios"]?></td>
						
					</tr>
					<?php
						
						if($fila["estatus"] != "Cancelado"){
							$totales[0]+= $fila["monto"];
							
						}
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td><?php echo count($filas); ?> Registros</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	<?php
		
		
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>	