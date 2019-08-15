<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
			
	$consulta = "SELECT * FROM boletaje LEFT JOIN boletaje_detalle  USING(id_boletaje)
	LEFT JOIN usuarios USING(id_usuarios) 
	WHERE id_boletaje= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
	?> 
	<div>
		<legend>GUIA</legend> 
		<div class="row mb-2">
			<div class="col-4">
				<b >Fecha:</b>
			</div>	 
			<div class="col-8">			
				<?php echo date("d/m/Y - H:i:s", strtotime($filas["fecha_mutualidad"]))?>
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
		
		<div class="form-row">
			<div class="col-4">
				Denominación
			</div>
			<div class="col-4">
				Cantidad
			</div>
			<div class="col-4">
				Importe
			</div>
		</div>
		
		<?php foreach($filas as $i => $item){ ?>
			
			<div class="form-row">
				<div class="col-4">
					<?php echo $item["denominacion"]?>
				</div>
				<div class="col-4">
					<?php echo $item["cantidad"]?>
				</div>
				<div class="col-4">
					<?php echo $item["importe"]?> 
				</div>
			</div>
			<?php	 
			}
			?>
			
			
			<div class="form-row">
				<div class="col-4">
					BOLETOS: <?php echo $filas[0]["cantidad_boletos"]?>
				</div>
				<div class="col-4">
					IMPORTE TOTAL<?php echo $item["importe_total"]?>
				</div>
			
			</div>
			
	</div>
	
	
	<?php
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>