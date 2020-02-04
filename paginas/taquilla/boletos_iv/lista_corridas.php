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
	
	
	function dame_permiso($url_paginas,$link){
		
		// return false;
		$consulta = "SELECT * FROM permisos LEFT JOIN paginas USING(id_paginas) 
		WHERE url_paginas = '$url_paginas' 
		AND id_usuarios = {$_COOKIE["id_usuarios"]}";
		
		
		$result = mysqli_query($link, $consulta) or die("Error dame_permiso($consulta) ". mysqli_error($link));
		
		if(mysqli_num_rows($result) > 0){
			while($fila = mysqli_fetch_assoc($result)){
				
				$respuesta= $fila["permiso"];
			}
			
			if($respuesta == "Sin Acceso"){
				return "hidden"; 
			}
			else{
				return $respuesta;
			}
			
			
		}
		else{
			
			return false;//"Pagina no existe, $url_paginas,{$_SESSION["id_usuarios"]}, $consulta";
		}
		
	}
	
	
	$consulta = "SELECT * FROM corridas 
	
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN origenes USING(id_origenes)
	LEFT JOIN (
	SELECT id_origenes AS id_destinos, 
	nombre_origenes AS nombre_destinos 
	FROM origenes ) AS t_destinos 
	USING(id_destinos)
	LEFT JOIN usuarios USING(id_usuarios)
	LEFT JOIN (SELECT id_corridas, SUM(precio_boletos) AS importe_corridas
	FROM boletos GROUP BY id_corridas
	) AS t_importes USING(id_corridas)
	WHERE corridas.id_administrador = '{$_COOKIE["id_administrador"]}'";
	
	if($_GET["id_usuarios"] != ""){
		$consulta.="
		AND date(fecha_corridas) = CURDATE()
		AND corridas.id_usuarios = '{$_GET["id_usuarios"]}'
		
		";
		
	}
	
	$consulta.="
	ORDER BY id_corridas DESC "
	;
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros 	</div> ");
			
		}
		
		
		
	?> 
	<pre hidden>
		<?php echo $consulta?>
	</pre>
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>Estatus</th>
				<th>Estatus Pago</th>
				<th>Folio</th>
				<th>Num Eco</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Importe</th>
				<th>Empresa</th>
				<th>Usuario</th>
				
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
					// console_log($fila);
					$filas = $fila ;
					
					
				?>
				<tr>
					
					
					<td>
						<?php
							switch($filas["estatus_corridas"]){
								case "Activa":
								echo "<span class='badge badge-success'>".$filas["estatus_corridas"]."</span>";
							?>
							<button class="btn btn-success  btn-sm btn_venta" title="Venta de Boletos" data-id_corridas="<?php echo $filas["id_corridas"]?>" data-num_eco="<?php echo $filas["num_eco"]?>" >
								<i class="fas fa-ticket-alt"></i> Venta de Boletos
							</button>
							
							<?php
								break;
								
								case "Finalizada":
								
								echo "<span class='badge badge-warning'>".$filas["estatus_corridas"]."</span>";
								
							?>
							<button hidden class="btn btn-info  btn-sm imprimir " title="Imprimir" data-id_registro='<?php echo $filas["id_corridas"]?>'>
								<i class="fas fa-print"></i> Imprimir Guía
							</button>	
							
							<?php
								
								
								break;
								
								case "Cancelada":
								echo "<span class='badge badge-danger'>".$filas["estatus_corridas"]."</span>";
								echo "<small>".$filas["datos_cancelacion"]."</small>";
								break;
								
							}
							
						?>
						
						
						<?php if($fila["estatus_corridas"] != 'Cancelada'){?>
							
							<button hidden class="btn btn-info imprimir" title="Imprimir"     data-id_registro='<?php echo $filas["id_corridas"]?>'>
								<i class="fas fa-print"></i>
							</button>	
							<?php
								if(dame_permiso("venta_boletos.php", $link) == 'Supervisor'){
								?>
								<button class="btn btn-danger cancelar" title="Cancelar"     data-id_registro='<?php echo $filas["id_corridas"]?>'>
									<i class="fas fa-times"></i>
								</button>	
								
								<?php
								}
							}
						?>
						
						
					</td>
					<td>
						<?php
							switch($filas["estatus_pago"]){
								case "PENDIENTE":
								if($filas["estatus_corridas"] == "Finalizada"){
									echo "<label class='badge badge-warning'> <input type='checkbox' form='form_pagar_corridas' name='corridas[]' class='select' value='{$filas["id_corridas"]}' data-importe_corridas='{$filas["importe_corridas"]}'>";
									echo $filas["estatus_pago"]."</label>";
								}
								
								break;
								
								case "PAGADA":
								
								echo "<span class='badge badge-success'>".$filas["estatus_pago"]."</span>";
								
								
							?>
							<?php
								
								
								break;
								
								case "Cancelada":
								echo "<span class='badge badge-danger'>".$filas["estatus_corridas"]."</span>";
								break;
								
							}
							
						?>
						
						
					</td>
					<td><?php echo $filas["id_corridas"]?></td>
					<td><?php echo $filas["num_eco"]?></td>
					<td><?php echo $filas["fecha_corridas"]?></td>
					<td><?php echo $filas["hora_corridas"]?></td>
					<td class="text-right">
					$ <?php echo number_format($filas["importe_corridas"], 0)?></td>
					<td><?php echo $filas["nombre_empresas"]?></td>
					<td><?php echo $filas["nombre_usuarios"]?></td>
					
					</tr>
					
					<?php
						if($fila["estatus_corridas"] != "Cancelada"){
							
							$total_corrida+= $filas["importe_corridas"];
						}
						// $total_ingresos+= $ingresos;
						// $total_cargos+= $filas["gasto_administracion"];
						// $total_seguro+= $filas["seguro_derroteros"];
						
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
					<tfoot>
					<tr class="bg-secondary text-white">
					<td colspan="6">TOTAL</td>
					<td class="text-right"><?= number_format($total_corrida,0)?></td>
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