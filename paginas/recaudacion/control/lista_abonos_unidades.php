<?php 
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$totales = array_fill (  0 ,  10 , 0 ); //Llena el array totales con 10 elementos en 0s
	
	
	
	$consulta = "SELECT *, abonos_unidades.datos_cancelacion AS cancelacion_abonos FROM abonos_unidades 
	
	LEFT JOIN recaudaciones USING(id_recaudaciones)
	LEFT JOIN tarjetas USING(tarjeta)
	LEFT JOIN conductores  USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN usuarios ON abonos_unidades.id_usuarios = usuarios.id_usuarios 
	LEFT JOIN empresas ON empresas.id_empresas = unidades.id_empresas
	WHERE abonos_unidades.id_administrador = {$_SESSION["id_administrador"]}
	
	AND  DATE(fecha_abonos) BETWEEN '{$_GET['fecha_inicial']}' AND '{$_GET['fecha_final']}'
	";
	
	
	if($_GET["num_eco"] != ""){
		$consulta.=  " AND num_eco = '{$_GET['num_eco']}' ";
	}
	if($_GET["id_usuarios"] != ''){
		$consulta.= " AND abonos_unidades.id_usuarios = '{$_GET["id_usuarios"]}' ";
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
	
	<pre hidden>
		Id_empresas <?php echo $_SESSION["id_empresas"]?>
		Session Id <?php echo session_id()?>
		Sesiion Estatus <?php echo session_status()?>
		Consulta <?php echo $consulta?>
	</pre>
	<table class="table table-bordered table-striped table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Imprimir</th>
				<th>Folio</th>
				<th>Fecha Creación</th>
				<th>Tarjeta</th>
				<th>Fecha Cuenta</th>
				<th>Recaudacion</th>
				<th>Empresa</th>
				<th>Unidad</th>
				<th>Conductor</th>
				<th>Cuenta</th>
				<th>Condonacion</th>
				<th>Total Cuenta</th>
				<th>Termicos</th>
				<th>Tijera</th>
				<th>Total Boletos</th>
				<th>Efectivo</th>
				<th>Total Recaudado</th>
				<th>Abono Unidad</th>
				<th>Devolución</th>
				<th>Usuario</th>
				<th>Estatus</th>
			</thead>
			<tbody id="tabla_DB">
				<?php 
					foreach($filas as $index=>$fila){
						if($fila["estatus_abonos"] != "Cancelado"){
							$total_cuenta = $fila["cuenta"] - $fila["condonacion"];
							
							$totales[0]+= $fila["cuenta"];
							$totales[1]+= $fila["condonacion"];
							$totales[2]+= $total_cuenta;
							$totales[3]+= $fila["bol_termicos_importe"];
							$totales[4]+= $fila["importe_tijera"];
							$totales[5]+= $fila["total_boletos"];
							$totales[6]+= $fila["efectivo"];
							$totales[7]+= $fila["total_recaudado"];
							$totales[8]+= $fila["abono_unidad"];
							$totales[9]+= $fila["devolucion"];
						}
						
					?>
					<tr>
						<td class="text-center"> 
							<?php if($fila["estatus_abonos"] != 'Cancelado'){?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_abonos_unidades']?>'>
									<i class="fas fa-times"></i>
								</button>
								<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['id_abonos_unidades']?>'>
									<i class="fas fa-print"></i>
								</button>
								<?php
								}
							?>
						</td>
						<td><?php echo $fila["id_abonos_unidades"]?></td>
						<td><?php echo $fila["fecha_abonos"]?></td>
						<td><?php echo $fila["tarjeta"]?></td>
						<td><?php echo $fila["fecha_tarjetas"]?></td>
						<td><?php echo $fila["nombre_recaudaciones"]?></td>
						<td><?php echo $fila["nombre_empresas"]?></td>
						<td><?php echo $fila["num_eco"]?></td>
						<td><?php echo $fila["nombre_conductores"]?></td>
						<td><?php echo $fila["cuenta"]?></td>
						<td><?php echo $fila["condonacion"]?></td>
						<td><?php echo $total_cuenta;?></td>
						<td><?php echo $fila["bol_termicos_importe"]?></td>
						<td><?php echo $fila["importe_tijera"]?></td>
						<td><?php echo $fila["total_boletos"]?></td>
						<td><?php echo $fila["efectivo"]?></td>
						<td><?php echo $fila["total_recaudado"]?></td>
						<td><?php echo $fila["abono_unidad"]?></td>
						<td><?php echo $fila["devolucion"]?></td>
						<td><?php echo $fila["nombre_usuarios"]?></td>
						<td>
							<?php 
								echo $fila["estatus_abonos"];
								if( $fila["estatus_abonos"] == "Cancelado"){
									echo "<br>".$fila["cancelacion_abonos"];
								}
							?>
						</td>
					</tr>
					<?
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td> 
					<td></td>
					<td></td>
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