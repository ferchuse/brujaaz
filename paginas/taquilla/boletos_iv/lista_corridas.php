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
	
	
	
	$consulta = "SELECT * FROM corridas 
	LEFT JOIN unidades USING(num_eco) 
	LEFT JOIN origenes USING(id_origenes)
	LEFT JOIN (
	SELECT id_origenes AS id_destinos, 
	nombre_origenes AS nombre_destinos 
	FROM origenes ) AS t_destinos 
	USING(id_destinos)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE unidades.id_administrador = {$_SESSION["id_administrador"]}
	";
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		
		
	?>  
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Estatus</th>
				<th>Folio</th>
				<th>Num Eco</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Origen</th>
				<th>Destino</th>
				<th>Taquillero</th>
				
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
					// console_log($fila);
					$filas = $fila ;
					echo chr(0);
					echo chr(1);
					
					
				?>
				<tr>
					<td>
						<?php if($fila["estatus_corridas"] != 'Cancelado'){?>
							
							<button class="btn btn-danger  btn-sm cancelar " title="Cancelar" data-id_registro='<?php echo $filas["id_corridas"]?>'>
								<i class="fas fa-times"></i> Cancelar
							</button>	
							<button class="btn btn-success  btn-sm btn_venta" title="Venta de Boletos" data-id_corridas="<?php echo $filas["id_corridas"]?>" data-num_eco="<?php echo $filas["num_eco"]?>" >
								<i class="fas fa-ticket-alt"></i> Venta de Boletos
							</button>
							<?php
								
							}
						?>
					</td>
					<td>
						<?php
							switch($filas["estatus_corridas"]){
								case "Activa":
								echo "<span class='badge badge-success'>".$filas["estatus_corridas"]."</span>";
								break;
								
								case "Finalizada":
								echo "<span class='badge badge-warning'>".$filas["estatus_corridas"]."</span>";
								break;
								
								case "Cancelada":
								echo "<span class='badge badge-danger'>".$filas["estatus_corridas"]."</span>";
								break;
								
							}
							
							if($filas["estatus_corridas"] == "Cancelado"){
								echo $fila["datos_cancelacion"];
								
							}
						?>
					</td>
					<td><?php echo $filas["id_corridas"]?></td>
					<td><?php echo $filas["num_eco"]?></td>
					<td><?php echo $filas["fecha_corridas"]?></td>
					<td><?php echo $filas["hora_corridas"]?></td>
					<td><?php echo $filas["origen"]?></td>
					<td><?php echo $filas["destino"]?></td>
					<td><?php echo $filas["nombre_usuarios"]?></td>
					
				</tr>
				
				<?php
					$total_saldo_unidades+= $filas["saldo_unidades"];
					$total_ingresos+= $ingresos;
					$total_cargos+= $filas["gasto_administracion"];
					$total_seguro+= $filas["seguro_derroteros"];
					
				}
			?>
			
			<tr hidden>
				<td colspan="4"> TOTALES</td>
				<td><?php echo number_format($total_saldo_unidades);?></td>
				<td><?php echo number_format($total_ingresos);?></td>
				<td><?php echo number_format($total_cargos);?></td>
				<td><?php echo number_format($ingresos)?></td>
				
			</tr>
		</tbody>
	</table>
	
	<?php
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	

?>