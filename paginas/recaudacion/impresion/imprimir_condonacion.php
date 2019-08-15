<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM condonaciones 
	
	LEFT JOIN motivos_condonacion USING(id_motivo_condonacion)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_condonaciones= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			console_log($fila);
			$filas = $fila ;
			//TODO
			///Tarjeta Cancelada
			///Tarjeta Ya recaudada
			
		}
		
	?> 
	<legend>Condonación de Tarjeta
	</legend> 
	<div class="row mb-2">
		<div class="col-4">
			<b >Fecha:</b>
		</div>	 
		<div class="col-8">			
			<?php echo date("d/m/Y - H:i:S", strtotime($filas["fecha_condonaciones"]))?>
		</div>
	</div>
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
			<b >Tarjeta:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["tarjeta"]?>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-4">
			<b >Motivo:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["motivo_condonacion"]?>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-4">
			<b >Monto:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["monto_condonaciones"]?>
		</div>
	</div>
	<div class="row mb-2"> 
		<div class="col-12">
			<b >Observaciones:</b> 
		</div>	
		<br>
		<div class="col-12">			
			<?php echo $filas["observaciones_condonaciones"]?>
		</div>
	</div>
	
	
	<?php
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
	
	}
	
	
?>