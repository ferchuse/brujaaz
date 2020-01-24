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
	
	

	
	$consulta_guia = "SELECT *, nombre_origenes as destino,
	COUNT(id_boletos) AS cantidad
	FROM	boletos 
	LEFT JOIN corridas USING(id_corridas)
	LEFT JOIN precios_boletos USING(id_precio)
	LEFT JOIN origenes ON precios_boletos.id_destinos = origenes.id_origenes
	WHERE id_corridas = '{$_GET["id_corridas"]}' 
	GROUP BY id_precio
	";
  
	
	
	$result_guia = mysqli_query($link,$consulta_guia);
	
	
	while($fila_guia = mysqli_fetch_assoc($result_guia)){
		
		$guias[] = $fila_guia ;
	}
	
	if($result_guia){
		
		if( mysqli_num_rows($result_guia) == 0){
			die("<div class='alert alert-danger'>No hay boletos venidos</div>");
			
		}
		
	?>  
	<pre hidden>
		<?php echo $consulta;?>
	</pre>
	
	
	
	<div class="row">
		
		
		<div class="col-12">
			<h4 class="text-center">GUÍA</h4>
			<h4 >Corrida: <?= $guias[0]["id_corridas"]?></h4>
			<h4 >Fecha:  <?= $guias[0]["fecha_corridas"]?></h4>
			<h4 >Num Eco: <?= $guias[0]["num_eco"]?></h4>
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Cant</th>
						<th>Destino</th>
						<th>Precio </th>
						<th>Importe </th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$total_guia = 0;
						if(!$result_guia){
							echo "<pre>".mysqli_error($result_guia)."</pre>";
							
						}
						// echo "<pre>".$consulta_guia."</pre>";
						
						foreach($guias AS $i =>$fila){
							$importe= $fila["cantidad"] * $fila["precio_boletos"];
							$total_guia+= $importe;
							
						?>
						<tr>
							
							<td><?php echo $fila["cantidad"]?></td>
							<td><?php echo $fila["destino"]?></td>
							<td><?php echo $fila["precio_boletos"]?></td>
							<td class="text-right"><?php echo number_format($importe, 2);?></td>
							
							
						</tr>
						
						<?php
							
							
						}
					?>
					
				</tbody>
				<tfoot>
					<tr >
						<td colspan="3"> TOTAL</td>
						
						<td class="text-right"><?php echo number_format($total_guia,2)?></td>
						
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