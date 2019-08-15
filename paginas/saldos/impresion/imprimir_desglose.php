<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$denominaciones = ["1000", "500", "200", "100", "50", "20", "10", "5", "2", "1", "0.5"];
	$consulta = "SELECT * FROM desglose_dinero 
	
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_desglose= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
	?> 
	<div >
		<legend>Desglose de Dinero </legend> 
		<div class="row mb-2">
			<div class="col-4">
				<b >Fecha:</b>
			</div>	 
			<div class="col-8">			
				<?php echo $filas["fecha_desglose"];?>
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
					<b >Denom.</b> 
				</div>	 
				<div class="col-4">			
					<b >Cantidad</b> 
				</div>
				<div class="col-4">			
					<b >Importe</b> 
				</div>
			</div>
		<?php foreach($denominaciones as $i => $denominacion){?>
			<div class="row mb-2">
				<div class="col-4">
					<b >$<?php echo $denominacion;?>:</b> 
				</div>	 
				<div class="col-4 text-right">			
					<?php echo number_format($filas[$denominacion]);?>
				</div>
				<div class="col-4 text-right">			
					<?php echo number_format($filas[$denominacion] * $denominacion);?>
				</div>
			</div>
			<?php
			}
		?>
		
			<hr>
			<div class="row mb-2">
				<div class="col-4">
					<b >IMPORTE TOTAL:</b> 
				</div>	 
				<div class="col-8 text-right">			
					<?php echo number_format($filas["importe_desglose"])?>
				</div>
			</div>
		</div>
		
		<div style="page-break-after:always;"></div>
		
		
		<?php
			
			
		}
		else {
			echo "Error en ".$consulta.mysqli_Error($link);
			
		}
		
		
	?>	