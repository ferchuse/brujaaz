<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM abonos_unidades 
	LEFT JOIN tarjetas USING(tarjeta)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN empresas ON tarjetas.id_empresas = empresas.id_empresas
	LEFT JOIN recaudaciones ON abonos_unidades.id_recaudaciones = recaudaciones.id_recaudaciones
	LEFT JOIN usuarios ON abonos_unidades.id_usuarios = usuarios.id_usuarios
	
	WHERE id_abonos_unidades= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Abono {$_GET['id_registro']} No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			console_log($fila);
			$filas = $fila ;
		}
		
		if($filas["devolucion"] > 0){?>
		
		<hr style="page-break-after: always;">
		<legend>Devolución</legend>
		
		
		<div class="row mb-2">
			<div class="col-4">
				<b >Usuario:</b>
			</div>	 
			<div class="col-8">			
				<?php echo $filas["nombre_usuarios"]?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-4">
				<b >Fecha Cuenta:</b>
			</div>	 
			<div class="col-8">			
				<?php echo $filas["fecha_tarjetas"]?><br>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-4">
				<b >Fecha:</b>
			</div>	 
			<div class="col-8">			
				<?php echo $filas["fecha_abonos"]?><br>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<b >Recaudacion:</b> 
			</div>	 
			<div class="col-6">			
				<?php echo $filas["nombre_recaudaciones"]?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-4">
				<b >Empresa:</b> 
			</div>	 
			<div class="col-8">			
				<?php echo $filas["nombre_empresas"]?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-4">
				<b >Unidad:</b> 
			</div>	 
			<div class="col-8">			
				<?php echo $filas["num_eco"]?>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-6">
				<b >Conductor:</b> 
			</div>	 
			<div class="col-6">			
				<?php echo $filas["id_conductores"]?>
			</div>
		</div>
		<div class="row mb-2"> 
			<div class="col-4">
				<b >Devolución:</b> 
			</div>	
			<br>
			<div class="col-8">			
				<?php echo $filas["devolucion"]?>
			</div>
		</div>
		
		<?php 	
		}
		
	?>
	
	<?php
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>