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
	
	
	
	$consulta = "SELECT * FROM pagos_taquilla 
	LEFT JOIN usuarios USING(id_usuarios)
	";
	
	
	
	
	$consulta .=	" WHERE DATE(fecha_pagos) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'";
	$consulta .=	" ORDER BY id_pagos ASC";
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		while($row = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas[] = $row ;
			
		}
		
		
		
	?>  
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Folio</th>
				<th>Fecha</th>
				<th>Importe</th>
				<th>Corridas</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
				foreach($filas as $i => $fila){
					
				?>
				<tr>
					<td>
						<button class="btn btn-info  btn-sm imprimir" title="Imprimir" data-id_pagos="<?php echo $fila["id_pagos"]?>"  >
							<i class="fas fa-print"></i> 
						</button>
					</td>
					
					<td><?php echo $fila["id_pagos"]?></td>
					<td><?php echo $fila["fecha_pagos"]?></td>
					<td class="text-right">
						$ <?php echo number_format($fila["total_pagos"], 0)?>
					</td>
					<td><?php echo $fila["corridas"]?></td>
					<td><?php echo $fila["nombre_usuarios"]?></td>
				</tr>
				
				<?php
					
					
					$total_pagos+= $fila["total_pagos"];
					
				}
			?>
			
			<tr hidden>
				<td colspan="3"> TOTALES</td>
				<td><?php echo number_format($total_saldo_unidades);?></td>
				<td><?php echo number_format($total_ingresos);?></td>
				<td><?php echo number_format($total_cargos);?></td>
				<td><?php echo number_format($ingresos)?></td>
				
			</tr>
		</tbody>
		<tfoot>
			<tr class="bg-secondary text-white">
				<td colspan="3">TOTAL:</td>
				<td class="text-right">$ <?= number_format($total_pagos,0)?></td>
				<td></td>
				<td></td>
			</tr>
		</tfoot>
	</table>
	
	<?php
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>	