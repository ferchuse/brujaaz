<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$totales = array_fill (  0 ,  1 , 0 ); //Llena el array totales con 10 elementos en 0s
	
	
	
	$consulta = "SELECT *, GROUP_CONCAT(num_eco) AS unidades 
	
	FROM 
	traspaso_utilidad
	LEFT JOIN traspaso_utilidad_unidades USING(id_traspaso)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN usuarios USING(id_usuarios)
	
	WHERE usuarios.id_administrador = {$_COOKIE["id_administrador"]}
	";
	
	$consulta.=  " 
	AND  DATE(fecha_traspaso)
	BETWEEN '{$_GET['fecha_inicial']}' 
	AND '{$_GET['fecha_final']}' 
	
	GROUP BY id_traspaso
	"; 
	if($_GET["num_eco"] != ''){
		
		$consulta.=  " HAVING unidades LIKE '%{$_GET["num_eco"]}%' "; 
	}
	
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
	
	<pre hidden >
		Id_empresas <?php echo $_COOKIE["id_empresas"]?>
		Session Id <?php echo session_id()?>
		Sesiion Estatus <?php echo session_status()?>
		Consulta <?php echo $consulta?>
	</pre>
	<table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th></th>
				<th>Folio</th>
				<th>Fecha Creación </th>
				<th>Fecha Aplicación</th>
				<th>Beneficiario</th>
				<th>Concepto</th>
				<th>Unidades</th>
				<th>Monto</th>
				<th>Estatus</th>
				<th>Usuario</th>
			</thead>
			<tbody id="tabla_DB">
				<?php 
					foreach($filas as $index=>$fila){
					?>
					<tr>
						<td class="text-center"> 
							<?php if($fila["estatus_traspaso"] != 'Cancelado'){?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_traspaso']?>'>
									<i class="fas fa-times"></i>
								</button>
								<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['id_traspaso']?>'>
									<i class="fas fa-print"></i>
								</button>
								<?php
								}
							?>
						</td>
						
						<td><?php echo $fila["id_traspaso"]?></td>
						<td><?php echo $fila["fecha_traspaso"]?></td>
						<td><?php echo $fila["fecha_aplicacion"]?></td>
						<td><?php echo $fila["beneficiario"]?></td>
						<td><?php echo $fila["concepto_traspaso"]?></td>
						<td><?php echo $fila["unidades"]?></td>
						<td><?php echo $fila["monto_traspaso"]?></td>
						<td><?php echo $fila["estatus_traspaso"]?></td>
						<td><?php echo $fila["nombre_usuarios"]?></td>
						
					</tr>
					<?
						
						if($fila["estatus_traspaso"] != "Cancelado"){
							$totales[0]+= $fila["monto_traspaso"];
							
						}
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td><?php echo mysqli_num_rows($result);?> Registros</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<?php
						foreach($totales as $i =>$total){
						?>
						<td class="h6"><?php echo number_format($total)?></td>
						<?php	
						}
					?>
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