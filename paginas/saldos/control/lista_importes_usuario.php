<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/dame_permiso.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$consulta = "##Importes por Usuario
	SELECT
	id_usuarios,
	nombre_usuarios,
	suma_abonos_unidades,
	suma_abonos_general,
	suma_mutualidad
	FROM
	usuarios
	LEFT JOIN (
	SELECT
	abonos_unidades.id_usuarios,
	SUM(abono_unidad) AS suma_abonos_unidades
	FROM
	abonos_unidades
	LEFT JOIN tarjetas USING(tarjeta)
	WHERE
	estatus_abonos <> 'Cancelado'
	AND date(fecha_abonos) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= " GROUP BY
	id_usuarios
	) AS t_suma_abonos_unidades USING (id_usuarios)
	
	
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(monto_abonogeneral) AS suma_abonos_general
	FROM
	abono_general
	LEFT JOIN unidades USING(id_unidades)
	WHERE
	estatus_abono <> 'Cancelado'
	AND date(fecha_abonogeneral) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	
	$consulta.=" GROUP BY
	id_usuarios
	) AS t_suma_abonos_general USING (id_usuarios)
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(monto_mutualidad) AS suma_mutualidad
	FROM
	mutualidad
	WHERE
	estatus_mutualidad <> 'Cancelado'
	AND DATE(fecha_mutualidad) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= " GROUP BY
	id_usuarios
	) AS t_suma_mutualidad USING (id_usuarios)
	WHERE usuarios.id_administrador = '{$_COOKIE["id_administrador"]}'
	
	
	";
	
	if(dame_permiso("importes_usuario.php", $link) == "Lectura" || dame_permiso("importes_usuario.php", $link) == "Escritura")
	{
		
		$consulta.=" AND id_usuarios = {$_COOKIE["id_usuarios"]}";
	}
	
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros $consulta</div>");
			
		}
		
		
		
	?>  
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>Usuario</th>
				<th>Abonos a Unidades</th>
				<th>Abonos Generales</th>
				<th>Mutualidad</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
					
					$filas = $fila ;
					$totales[0]+= $filas["suma_abonos_unidades"];
					$totales[1]+= $filas["suma_abonos_general"];
					$totales[2]+= $filas["suma_mutualidad"];
				?>
				<tr>
					<td>
						
						<?php echo $filas["nombre_usuarios"] == ''? 0 : $filas["nombre_usuarios"] ?>
						
					</td>
					
					<td>
						<a href="abonos_usuario.php?<?php 
							
							echo "id_usuarios={$filas["id_usuarios"]}
							&fecha_inicial={$_GET["fecha_inicial"]}
							&fecha_final={$_GET["fecha_final"]}
							&nombre_usuarios={$filas["nombre_usuarios"]}
							
							";
							
							?>">
							<?php echo $filas["suma_abonos_unidades"]  == '' ? 0 : $filas["suma_abonos_unidades"]?>
						</a>	
					</td>
					<td>
						<a href="abonos_general_usuario.php?<?php 
							echo "id_usuarios={$filas["id_usuarios"]}
							&fecha_inicial={$_GET["fecha_inicial"]}
							&fecha_final={$_GET["fecha_final"]}
							&nombre_usuarios={$filas["nombre_usuarios"]}
							";
							?>">
							
							<?php echo $filas["suma_abonos_general"]  == ''? 0 : $filas["suma_abonos_general"] ?>
						</a>	
					</td>
					<td>
						
						<a href="mutualidad_usuario.php?<?php 
							echo "id_usuarios={$filas["id_usuarios"]}
							&fecha_inicial={$_GET["fecha_inicial"]}
							&fecha_final={$_GET["fecha_final"]}
							&nombre_usuarios={$filas["nombre_usuarios"]}
							";
							?>">
							
						<?php echo $filas["suma_mutualidad"]  == '' ? 0 :$filas["suma_mutualidad"]?></td>
					</a>
					<td>
						<?php echo $filas["suma_abonos_unidades"] + $filas["suma_abonos_general"] + $filas["suma_mutualidad"]  ?>
					</td>
				</tr>
				
				<?php
					
					
				}
			?>
			
			
		</tbody>
		<tfoot>
			<tr class="h5">
				<td ><b> TOTALES<b></td>
					<?php
						$gran_total = 0;
						foreach($totales as $i =>$total){
							$gran_total+=$total;
						?>
						<td ><b><?php echo number_format($total)?></b></td>
						<?php	
						}
					?>
					<td ><b><?php echo number_format($gran_total)?></b></td>
					
				</tr>
				</tfoot>
			</table>
			
			<pre hidden>
				<?php echo $consulta;?>
			</pre>
			<?php
				
			}
			
			else {
				echo "Error en ".$consulta.mysqli_Error($link);
				
			}
			
			
		?>																											