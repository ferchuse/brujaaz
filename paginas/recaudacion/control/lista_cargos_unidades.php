<?php 
	session_start();
	
	if(count($_COOKIE) == 0) {
		die("Sesión caducada, recargue para accesar");
		
	}
	
	
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$totales = array_fill (  0 ,  3 , 0 ); //Llena el array totales con 10 elementos en 0s
	
	
	$fecha_from_mes = substr($_GET['mes_cargos'], 0, 4) ."-". substr($_GET['mes_cargos'], 4, 2). "-01";
	
	$consulta = "
	SELECT
	id_unidades,
	t_gasto_admon.fecha_cargos,
	num_eco,
	nombre_empresas,
	estatus_unidades,
	nombre_derroteros,
	gasto_administrativo,
	seguro
	FROM
	unidades
	LEFT JOIN empresas USING (id_empresas)
	LEFT JOIN derroteros USING (id_derroteros)
	LEFT JOIN (
	SELECT 
	id_unidades,
	fecha_cargos,
	cargo AS gasto_administrativo
	FROM
	cargos_unidades
	WHERE
	tipo_cargo = 'gasto_administracion'
	AND EXTRACT(YEAR_MONTH FROM fecha_cargos) = '{$_GET['mes_cargos']}'
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
	AND EXTRACT(YEAR_MONTH FROM fecha_cargos) =  '{$_GET['mes_cargos']}'
	) AS t_seguro USING (id_unidades)
	WHERE unidades.id_administrador ='{$_COOKIE["id_administrador"]}'
	
	
	";
	
	
	if($_GET["estatus_unidades"] != ""){
		$consulta.=  " AND estatus_unidades = '{$_GET['estatus_unidades']}' ";
		
	}
	if($_GET["num_eco"] != ""){
		$consulta.=  " AND num_eco = '{$_GET['num_eco']}' ";
		
	} 
	
	$consulta.=  "  ORDER BY num_eco "; 
	
?>
<pre hidden>
	fecha <?php echo $fecha_from_mes;?>
	id_administrador <?php echo $_COOKIE["id_administrador"];?>
	Session Id <?php echo session_id();?><br>
	Sesiion Estatus <?php echo (session_status());?><br>
	is  null <?php print_r (is_null($_COOKIE));?><br>
	is  set <?php print_r (isset($_COOKIE));?><br>
	empty<?php print_r(empty($_COOKIE));?><br>
	count<?php print_r(count($_COOKIE));?><br>
	size<?php print_r(sizeof($_COOKIE));?><br>
	Consulta <?php echo $consulta;?>
</pre>
<?php
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			
			die("<div class='alert alert-danger'>No hay registros</div");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas[] = $fila ;
		}
	?>
	
	<pre hidden >
		Id_empresas <?php echo $_COOKIE?>
		Session Id <?php echo session_id()?>
		Sesiion Estatus <?php echo session_status()?>
		Consulta <?php echo $consulta?>
		Consulta <?php echo $consulta?>
	</pre>
	<table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				
				<th>Num Eco</th>
				<th>Empresa</th>
				<th>Estatus</th>
				<th>Derrotero</th>
				<th>Gasto Administrativo</th>
				<th>Seguro Interno</th>
				
			</thead>
			<tbody id="tabla_DB">
				<?php 
					foreach($filas as $index=>$fila){
						
						
					?>
					<tr>
						
						<td><?php echo $fila["num_eco"]?></td>
						<td><?php echo $fila["nombre_empresas"]?></td>
						<td><?php echo $fila["estatus_unidades"]?></td>
						<td><?php echo $fila["nombre_derroteros"]?></td>
						<td>
							<input class="form-control cargo"
							data-id_unidades="<?php echo $fila["id_unidades"]?>"  
							data-fecha_cargos="<?php echo $fila["fecha_cargos"] == '' ? $fecha_from_mes : $fila["fecha_cargos"];?>" 
							data-tipo_cargo="gasto_administracion" 
							name="gasto_administrativo[]" 
							value="<?php echo $fila["gasto_administrativo"]?>">
						</td>
						<td>
							<input class="form-control cargo"
							data-id_unidades="<?php echo $fila["id_unidades"]?>"  
							data-fecha_cargos="<?php echo $fila["fecha_cargos"] == '' ? $fecha_from_mes : $fila["fecha_cargos"];?>" 
							data-tipo_cargo="seguro" 
							name="seguro[]" 
						value="<?php echo $fila["seguro"]?>">
					</td>
						
						
					</tr>
					<?
					}
				?>
			</tbody>
			<tfoot>
				<tr><td colspan="6">Registros <?php echo mysqli_num_rows($result)?></td></tr>
			</tfoot>
		</table>
	</div>
	
	<?php
		
		
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>		