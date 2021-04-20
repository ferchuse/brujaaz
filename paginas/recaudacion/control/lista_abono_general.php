<?php 
	session_start();
	if(count($_COOKIE) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/dame_permiso.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$filas = array();
	$respuesta = array();
	$totales = array_fill (  0 ,  1 , 0 ); //Llena el array totales con 0s
	
	
	
	$consulta = "SELECT * FROM abono_general 
	LEFT JOIN unidades USING (id_unidades) 
	LEFT JOIN empresas USING (id_empresas)  
	LEFT JOIN propietarios USING (id_propietarios) 
	LEFT JOIN derroteros USING (id_derroteros) 
	LEFT JOIN motivosAbonoUnidades USING (id_motivosAbono) 
	LEFT JOIN usuarios USING (id_usuarios)
	
	WHERE 
	usuarios.id_administrador = {$_COOKIE["id_administrador"]}
	AND DATE(fecha_abonogeneral) BETWEEN '{$_GET['fecha_inicial']}'
	AND '{$_GET['fecha_final']}'";
	
	if($_GET["num_eco"] != ""){
		$consulta.=  " AND num_eco = '{$_GET['num_eco']}' ";
	}
	
	if($_GET["id_usuarios"] != ""){
		$consulta.=  " AND abono_general.id_usuarios = '{$_GET['id_usuarios']}' ";
	}
	
	$consulta.=  " ORDER BY  id_abonogeneral ";
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			// die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			$filas[] = $fila ;
		}
		
	?>
	
	
	<table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th></th>
				<th>Folio</th>
				<th>Fecha Abono</th>
				<th>Fecha Aplicacion</th>
				<th>Empresa</th>
				<th>Unidad</th>
				<th>Motivo</th>
				<th>Monto</th>
				<th>Usuario</th>
				<th>Estatus</th>
			</tr>
		</thead>
		<tbody id="tabla_DB">
			<?php 
				foreach($filas as $index=>$fila){
					if($fila["estatus_abono"] != "Cancelado"){
						$totales[0]+= $fila["monto_abonogeneral"];
						$bg = '';
						
					}
					else{
						$bg = "bg-danger text-white";
					}
					
					
				?>
				<tr class="<?= $bg;?>">
					<td class="text-center"> 
						<?php 
							if($fila["estatus_abono"] != 'Cancelado'){
								
								if(dame_permiso("abono_general.php", $link) == 'Supervisor'){ ?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_abonogeneral']?>'>
									<i class="fas fa-times"></i>
								</button>
								
								<button class="btn btn-outline-info imprimir" data-id_registro='<?php echo $fila['id_abonogeneral']?>'>
									<i class="fas fa-print"></i>
								</button>
								<?php
								}
							?>
							
							<?php
							}
							else{
								
							}
						?>
					</td>
					<td><?php echo $fila["id_abonogeneral"]?></td>
					<td><?php echo $fila["fecha_abonogeneral"]?></td>
					<td><?php echo $fila["fecha_aplicacion"]?></td>
					<td><?php echo $fila["nombre_empresas"]?></td>
					<td><?php echo $fila["num_eco"]?></td>
					<td><?php echo $fila["nombre_motivosAbono"]?></td>
					<td><?php echo $fila["monto_abonogeneral"]?></td>
					<td><?php echo $fila["nombre_usuarios"]?></td>
					<td>
						
						<?php echo $fila["estatus_abono"];
							if( $fila["estatus_abono"] == "Cancelado"){
								echo "<br>".$fila["datos_cancelacion_abono_general"];
							}	
							
							
						?></td>
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
	
	<?php
		
		
	}
	else {
		echo  "Error en ".$consulta.mysqli_Error($link);
	}
	
?>		