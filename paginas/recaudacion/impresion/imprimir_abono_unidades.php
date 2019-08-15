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
			//TODO
			///Tarjeta Cancelada
			///Tarjeta Ya recaudada
			
		}
		
	?> 
	<legend>Abono de Unidades	</legend> 
	<div class="row mb-1">
		<div class="col-4">
			<b >Folio:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["id_abonos_unidades"]?>
		</div>
	</div> 
	<div class="row mb-1">
		<div class="col-4">
			<b >Usuario:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["nombre_usuarios"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Fecha Abono:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["fecha_abonos"]?><br>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Fecha Cuenta:</b>
		</div>	 
		<div class="col-8">			
			<?php echo $filas["fecha_tarjetas"]?><br>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-6">
			<b >Recaudacion:</b> 
		</div>	 
		<div class="col-6">			
			<?php echo $filas["nombre_recaudaciones"]?>
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
			<b >Unidad:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["num_eco"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-6">
			<b >Conductor:</b> 
		</div>	 
		<div class="col-6">			
			<?php echo $filas["id_conductores"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-4">
			<b >Cuenta:</b> 
		</div>	 
		<div class="col-8">			
			<?php echo $filas["cuenta"]?>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-5">
			<b >Condonacion:</b> 
		</div>	 
		<div class="col-7">			
			<?php echo $filas["condonacion"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-5">
			<b >Total:</b> 
		</div>	
		<br>
		<div class="col-6">			
			<?php echo $filas["cuenta"] - $filas["monto_condonaciones"];?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-5">
			<b >Termicos:</b> 
		</div>	
		<br>
		<div class="col-6">			
			<?php echo $filas["saldo_tarjetas"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Quetzal:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["bol_etiflex_importe"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Total Tijera:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["importe_tijera"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Total Boletos:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["total_boletos"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Efectivo:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["efectivo"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Total Recaudado:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["total_recaudado"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-4">
			<b >Abono Unidad:</b> 
		</div>	
		<br>
		<div class="col-8">			
			<?php echo $filas["abono_unidad"]?>
		</div>
	</div>
	<div class="row mb-1"> 
		<div class="col-5">
			<b >Devolución:</b> 
		</div>	
		<br>
		<div class="col-7">			
			<?php echo $filas["devolucion"]?>
		</div>
	</div>
	<hr>
	<?php 
		if($filas["devolucion"] > 0){?>
		
		<hr style="page-break-after: always;">
		<div id="devolucion">
			<legend>Devolución</legend>
			
			
			<div class="row mb-1">
				<div class="col-4">
					<b >Folio Abono:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["id_abonos_unidades"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Usuario:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["nombre_usuarios"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Fecha Cuenta:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_tarjetas"]?><br>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Fecha:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_abonos"]?><br>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-6">
					<b >Recaudacion:</b> 
				</div>	 
				<div class="col-6">			
					<?php echo $filas["nombre_recaudaciones"]?>
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
					<b >Unidad:</b> 
				</div>	 
				<div class="col-8">			
					<?php echo $filas["num_eco"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-6">
					<b >Conductor:</b> 
				</div>	 
				<div class="col-6">			
					<?php echo $filas["id_conductores"]?>
				</div>
			</div>
			<div class="row mb-1"> 
				<div class="col-5">
					<b >Devolución:</b> 
				</div>	
				<br>
				<div class="col-7">			
					<?php echo $filas["devolucion"]?>
				</div>
			</div>
		</div>
		
		<hr style="page-break-after: always;">
		<div id="devolucion">
			<legend>Devolución Copia</legend>
			
			<div class="row mb-1">
				<div class="col-4">
					<b >Folio Abono:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["id_abonos_unidades"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Usuario:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["nombre_usuarios"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Fecha Cuenta:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_tarjetas"]?><br>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-4">
					<b >Fecha:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_abonos"]?><br>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-6">
					<b >Recaudacion:</b> 
				</div>	 
				<div class="col-6">			
					<?php echo $filas["nombre_recaudaciones"]?>
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
					<b >Unidad:</b> 
				</div>	 
				<div class="col-8">			
					<?php echo $filas["num_eco"]?>
				</div>
			</div>
			<div class="row mb-1">
				<div class="col-6">
					<b >Conductor:</b> 
				</div>	 
				<div class="col-6">			
					<?php echo $filas["id_conductores"]?>
				</div>
			</div>
			<div class="row mb-1"> 
				<div class="col-5">
					<b >Devolución:</b> 
				</div>	
				<br>
				<div class="col-7">			
					<?php echo $filas["devolucion"]?>
				</div>
			</div>
		</div>
		<hr>
		<?php 	
		}
		
	?>
	
	<?php
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>	