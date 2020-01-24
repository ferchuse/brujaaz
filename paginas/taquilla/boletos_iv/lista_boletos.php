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
	
	
	
	$consulta_boletos = "SELECT *, nombre_origenes as destino FROM boletos 
	LEFT JOIN precios_boletos USING(id_precio)
	LEFT JOIN origenes ON precios_boletos.id_destinos = origenes.id_origenes
	WHERE id_corridas = {$_GET["id_corridas"]}
	ORDER BY id_boletos DESC
	";
	
	$consulta_guia = "SELECT *,
	COUNT(id_boletos) AS cantidad
	FROM boletos 
	LEFT JOIN precios_boletos USING(id_precio)
	WHERE id_corridas = {$_GET["id_corridas"]}
	GROUP BY id_precio
	";
  
	
	$result_boletos = mysqli_query($link,$consulta_boletos);
	$result_guia = mysqli_query($link,$consulta_guia);
	
	
	while($fila_guia = mysqli_fetch_assoc($result_guia)){
		
		$guias[] = $fila_guia ;
	}
	
	if($result_boletos){
		
		if( mysqli_num_rows($result_boletos) == 0){
			die("<div class='alert alert-danger'>No hay boletos venidos</div>");
			
		}
		
	?>  
	<pre hidden>
		<?php echo $consulta;?>
	</pre>
	
	
	
	<div class="row">
		<div class="col-6">
			<h4 class="text-center">BOLETOS VENDIDOS</h4>
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th></th>
						<th>Folio</th>
						<th>Destino</th>
						<th>Precio</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						
						while($fila = mysqli_fetch_assoc($result_boletos)){
							// console_log($fila);
							$filas = $fila ;
							
						?>
						<tr>
							<td>
								<?php if($fila["estatus_boletos"] != 'Cancelado'){?>
									
									<a target="_blank" class="btn btn-info imprimir " title="Imprimir" href="impresion/imprimir_boletos.php?boletos[]=<?php echo $filas["id_boletos"]?>" data-id_registro='<?php echo $filas["id_corridas"]?>'>
										<i class="fas fa-print"></i>
									</a>	
									
									<?php
										
									}
								?>
							</td>
							<td><?php echo $filas["id_boletos"]?></td>
							<td><?php echo $filas["destino"]?></td>
							<td>$<?php echo number_format($filas["precio_boletos"])?></td>
							
						</tr>
						
						<?php
							$total_saldo_unidades+= $filas["saldo_unidades"];
							$total_ingresos+= $ingresos;
							$total_cargos+= $filas["gasto_administracion"];
							$total_seguro+= $filas["seguro_derroteros"];
							
						}
					?>
					
				</tbody>
				<tfoot>
					<tr hidden>
						<td colspan="4"> TOTALES</td>
						<td><?php echo number_format($total_saldo_unidades);?></td>
						<td><?php echo number_format($total_ingresos);?></td>
						<td><?php echo number_format($total_cargos);?></td>
						<td><?php echo number_format($ingresos)?></td>
					</tr>
				</tfoot>
			</table>
			
		</div>
		
		<div class="col-6">
			<h4 class="text-center">GUÍA</h4>
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Cantidad</th>
						<th>Destino</th>
						<th>Precio </th>
						<th>Importe </th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$total_guia = 0;
						echo "<pre>".$consulta_guia."</pre>";
						
						foreach($guias AS $i =>$fila){
							$importe= $fila["cantidad"] * $fila["precio_boletos"];
							$total_guia+= $importe;
							
						?>
						<tr>
							
							<td><?php echo $fila["cantidad"]?></td>
							<td><?php echo $fila["destino"]?></td>
							<td><?php echo $fila["precio_boletos"]?></td>
							<td><?php echo $importe;?></td>
							
							
						</tr>
						
						<?php
							
							
						}
					?>
					
				</tbody>
				<tfoot>
					<tr >
						<td colspan="4"> TOTAL</td>
						
						<td><?php echo number_format($total_guia)?></td>
						
					</tr>
				</tfoot>
			</table>
			
		</div>
	</div>
	
	<?php
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>	