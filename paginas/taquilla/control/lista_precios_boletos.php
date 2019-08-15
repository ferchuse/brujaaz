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
	
	
	
	$consulta = "SELECT * FROM precios_boletos 
	LEFT JOIN origenes USING(id_origenes) 
	LEFT JOIN (
		SELECT id_origenes AS id_destinos,
		nombre_origenes AS nombre_destinos
		FROM origenes) t_destinos
		USING(id_destinos)
	WHERE precios_boletos.id_administrador = {$_SESSION["id_administrador"]}
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
				<th>Origen</th>
				<th>Destino</th>
				<th>Tipo de Boleto</th>
				<th>Precio</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
				
					$filas = $fila ;
					
				?>
				<tr>
					<td>
						<button class="btn btn-warning editar " title="Editar" data-id_registro='<?php echo $filas["id_precio"]?>'>
							<i class="fas fa-edit"></i>
						</button>
					</td>
					<td><?php echo $filas["nombre_origenes"]?></td>
					<td><?php echo $filas["nombre_destinos"]?></td>
					<td><?php echo $filas["tipo_precio"]?></td>
					<td><?php echo $filas["precio"]?></td>
					
				</tr>
				
				<?php
					
				}
			?>
			
		</tbody>
	</table>
	
	<?php
		
	}
	
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
	}
	
	
?>