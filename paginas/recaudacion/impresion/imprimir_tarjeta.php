<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM tarjetas 
	
	LEFT JOIN derroteros USING(id_derroteros)
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN conductores  USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN roles USING(id_roles)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE tarjeta= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Abono {$_GET['id_registro']} No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			console_log($fila);
			$filas = $fila ;
			//TODO
			///Tarjeta Cancelada
			///Tarjeta Ya recaudada
			
		}
		
	?> 
	<h5 class="text-center">Tarjeta</h5> 
	
	<div class="row mb-1 d-none">
		<div class="col-12 text-center">			
			<img class="img-fluid" src="../../../img/<?php echo $filas["logo_empresas"]?>">
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >FOLIO:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["tarjeta"];?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Taquillero:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["nombre_usuarios"];?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >FECHA CUENTA:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["fecha_tarjetas"];?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Empresa:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["nombre_empresas"]?>
		</div>
	</div>
	
	<div class="row mb-1">
		<div class="col-4">
			<b >No.Eco:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["num_eco"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Conductor:</b>
		</div>	 
		<div class="col-8">			
			<?php echo  $filas["nombre_conductores"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Derrotero:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["nombre_derroteros"];?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4"> 
			<b >Rol:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["nombre_roles"]?>
		</div>
	</div>
	<hr>
	<div class="row mb-1 text-center ">
		<div class="col-6"> 
			Origen
		</div>	 
		<div class="col-6">			
			Destino
		</div>
	</div>
	<?php
		$q_roles = "SELECT
		*
		FROM
		roles_destinos
		LEFT JOIN origenes ON roles_destinos.origen = origenes.id_origenes
		LEFT JOIN (
		SELECT
		id_origenes AS id_destinos,
		nombre_origenes AS nombre_destinos
		FROM
		origenes
		) AS destinos ON roles_destinos.destino = destinos.id_destinos
		WHERE
		id_roles = {$filas['id_roles']}
		ORDER BY id_vueltas";
		
		$result_roles = mysqli_query($link, $q_roles);
		
		while($fila_roles= mysqli_fetch_assoc($result_roles)){
		?>
		<div class="row  text-center small ">
			<div class="col-6"> 
				<?php 
					if($_SESSION["id_administrador"] == '1'){
						
						echo "___________";
						}else{
						echo $fila_roles["nombre_origenes"];
						
					}
				?>
				
			</div>	 
			<div class="col-6">	
				
				<?php if($_SESSION["id_administrador"] == '1'){
					echo "___________";
					}
					else{
					echo $fila_roles["nombre_destinos"];
				}
				?>
			</div>
		</div>
		<br>
		<br>
		<?php
		}
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
	?>					