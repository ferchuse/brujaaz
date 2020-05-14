<?php 
	session_start();
	if(count($_COOKIE) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$fecha_inicial = date("Y-m-01");
	
	$consulta = "##estado de cuenta
	SELECT
	id_unidades,
	num_eco,
	nombre_empresas,
	nombre_propietarios,
	estatus_unidades,
	dame_saldo('{$_GET["fecha_inicial"]}',id_unidades) as saldo_anterior,
	gasto_administracion,
	cargo_admon,
	seguro,
	suma_abono_general,
	suma_abono_unidades,
	suma_traspasos
	FROM
	unidades
	LEFT JOIN derroteros USING (id_derroteros)
	LEFT JOIN (
	SELECT 
	id_unidades,
	fecha_cargos,
	cargo AS cargo_admon
	FROM
	cargos_unidades
	WHERE
	tipo_cargo = 'gasto_administracion'
	AND fecha_cargos BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	) AS t_gasto_admon USING (id_unidades) 
	
	LEFT JOIN (
	SELECT
	id_unidades,
	fecha_cargos,
	cargo AS seguro 
	FROM
	cargos_unidades 
	WHERE
	tipo_cargo = 'seguro'
	AND fecha_cargos BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	) AS t_seguro USING (id_unidades)
	
	LEFT JOIN propietarios USING (id_propietarios)
	LEFT JOIN empresas USING (id_empresas)
	LEFT JOIN (
	SELECT
	id_unidades,
	SUM(monto_abonogeneral) AS suma_abono_general
	FROM
	abono_general
	WHERE
	estatus_abono <> 'Cancelado'
	AND DATE(fecha_aplicacion) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	GROUP BY 
	id_unidades
	) t_abono_general USING (id_unidades)
	
	LEFT JOIN (
	SELECT
	id_unidades,
	tarjeta,
	SUM(abono_unidad) AS suma_abono_unidades
	FROM
	abonos_unidades
	LEFT JOIN tarjetas USING (tarjeta)
	WHERE
	estatus_abonos <> 'Cancelado'
	AND DATE(fecha_abonos) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	
	GROUP BY id_unidades
	) t_abonos_unidades USING (id_unidades)
	LEFT JOIN (
	SELECT
	id_unidades,
	SUM(monto) AS suma_traspasos
	FROM
	traspaso_utilidad
	LEFT JOIN traspaso_utilidad_unidades USING (id_traspaso)
	WHERE
	estatus_traspaso <> 'Cancelado'
	AND DATE(fecha_aplicacion) BETWEEN '{$_GET["fecha_inicial"]}' AND '{$_GET["fecha_final"]}'
	GROUP BY id_unidades
	) traspaso_utilidad USING (id_unidades)
	";
	$consulta.="
	WHERE 1
	AND unidades.id_administrador = '{$_COOKIE["id_administrador"]}'
	"; 
	
	if($_GET["num_eco"] != ""){
		$consulta.=  " AND num_eco = '{$_GET['num_eco']}' ";
	}
	
	if($_COOKIE["tipo_usuario"] == "propietario"){
		$consulta.=  " AND id_propietarios  = '{$_COOKIE["id_usuarios"]}' ";
	}
	
	if($_GET["id_propietarios"] != ""){
		$consulta.=  " AND id_propietarios  = '{$_GET["id_propietarios"]}' ";
	}
	
	if($_GET["estatus_unidades"] != 'Todos'){
		$consulta.=  " AND estatus_unidades  = '{$_GET["estatus_unidades"]}' ";
	}
	
	if($_GET["id_empresas"] != ''){
		$consulta.=  " AND unidades.id_empresas  = '{$_GET["id_empresas"]}' ";
	}
	
	$consulta.= 
	" GROUP BY 
	id_unidades
	
	ORDER BY num_eco 
	";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
		}
	?> 
	<pre hidden>
		<?php echo $consulta;?>
	</pre>
	<legend>Estado de Cuenta</legend> 
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>Num Eco</th>
				<th>Empresa</th>
				<th>Titular</th>
				<th>Estatus</th>
				<th>Saldo Anterior</th>
				<th>Ingreso Bruto</th>
				<th>Cargos Admvos</th>
				<th>50% Admon GAAZ</th>
				<th>50% Admon Empresa</th>
				<th>Seguro Interno</th>
				<th>Traspaso Titulares</th>
				<th>Saldo Disponible</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
					// console_log($fila);
					$filas = $fila ;
					
					$ingresos = $filas["suma_abono_general"] + $filas["suma_abono_unidades"];
					$cargos =  $filas["cargo_admon"] + $filas["seguro"] + $filas["suma_traspasos"];
					$saldo_restante = $filas["saldo_anterior"] + $ingresos- $cargos;
					
					$totales[0]+= $ingresos;
					$totales[1]+= $filas["cargo_admon"];
					$totales[2]+= $filas["cargo_admon"] * .5;
					$totales[3]+= $filas["cargo_admon"] * .5;
					$totales[4]+= $filas["seguro"];
					$totales[5]+= $filas["suma_traspasos"];
					$totales[6]+= $saldo_restante ;
					
					// $q_saldo= "SELECT saldo FROM estado_cuenta 
					// WHERE id_unidades = {$filas['id_unidades']} AND fecha_estado_cuenta = {$fecha_inicial}";
					
					// $result_saldo = mysqli_query($link, $q_saldo) or die("Error $q_saldo". mysqli_error($link));
					
					
					// while($fila = mysqli_fetch_assoc($result_saldo)){
					
					// $fila_saldo[] = $fila ;
					
					// } 
					
					
				?>
				<tr>
					<td><?php echo $filas["num_eco"]?></td>
					<td><?php echo $filas["nombre_empresas"]?></td>
					<td><?php echo $filas["nombre_propietarios"]?></td>
					<td><?php echo $filas["estatus_unidades"]?></td>
					<td><?php echo $filas["saldo_anterior"]?></td>
					
					<td><?php echo $ingresos;?></td>
					<td><?php echo $filas["cargo_admon"]?></td>
					<td><?php echo $filas["cargo_admon"] *.5?></td>
					<td><?php echo $filas["cargo_admon"] *.5?></td>
					<td><?php echo $filas["seguro"]?></td>
					<td><?php echo $filas["suma_traspasos"] == '' ? 0 : $filas["suma_traspasos"]?></td>
					
					<td>
						<a href="estado_cuenta_detalle.php?id_unidades=<?php echo $filas["id_unidades"];?>&num_eco=<?php echo $filas["num_eco"];?>
						&nombre_propietarios=<?php echo $filas["nombre_propietarios"];?>
						&fecha_inicial=<?php echo $_GET["fecha_inicial"];?>
						&fecha_final=<?php echo $_GET["fecha_final"];?>
						">
							<?php echo $saldo_restante;?>
						</a>
					</td>
					
				</tr>
				
				<?php
					
					
				}
			?>
			
			<tr>
				<td colspan="5"> TOTALES</td>
				<?php
					foreach($totales as $i =>$total){
					?>
					<td class="h6"><?php echo number_format($total)?></td>
					<?php	
					}
				?>
				
			</tr>
		</tbody>
	</table>
	
	<?php
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>