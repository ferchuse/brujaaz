<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/numero_a_letras.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM abono_general 
	LEFT JOIN unidades USING (id_unidades) LEFT JOIN empresas USING (id_empresas) LEFT JOIN propietarios USING (id_propietarios) LEFT JOIN derroteros USING (id_derroteros) LEFT JOIN motivosAbonoUnidades USING (id_motivosAbono) LEFT JOIN usuarios USING (id_usuarios)
	WHERE id_abonogeneral= '{$_GET['id_registro']}'";
	
	
	$result = mysqli_query($link,$consulta); 
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas = $fila ;
			
			
		}
		if($_COOKIE["silent_print"] == "SI"){ 
			
			$print.= "@";
			$print.= "!".chr(16)."ABONO GENERAL"."!".chr(0)."\n";
			$print.= "Folio: ".$filas["id_abonogeneral"]."\n";
			$print.= "Fecha: ".$filas["fecha_abonogeneral"]."\n";
			$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
			$print.= "Num Eco: ".$filas["num_eco"]."\n";
			$print.= "Motivo: ".$filas["nombre_motivosAbono"]."\n";
			$print.= "Depositante: ".$filas["depositante"]."\n";
			$print.= "Concepto: $".$filas["concepto_abonogeneral"]."\n ";
			$print.= "Bueno Por: $".$filas["monto_abonogeneral"]."\n";
			$print.= NumeroALetras::convertir($filas["monto_abonogeneral"], 'PESOS', 'CENTAVOS')."\n";
			
			
			$print.="\n\nVB";
			
			echo base64_encode($print);
			
		}
		else{
		?> 
		<div class="media_carta h5">
			<div class="row">
				<div class="col-12 text-center" >
					<img  hidden 
					src="../../img/amt.jpg" class="img-fluid">
				</div>
				<div class="col-12 text-center">
					<h4><?php echo $filas["nombre_empresas"]?></h4>
				</div>
			</div>
			
			<legend>Abono General</legend> 
			
			<div class="row">
				<div class="col-6">
					<h5>
						Unidad: <?php echo $filas["num_eco"]?><br>
						Motivo: <?php echo $filas["nombre_motivosAbono"]?><br>
					</h5>
				</div>	 
				<div class="col-6 text-right">	
					<h4>Folio: <?php echo $filas["id_abonogeneral"]?></h4>
					<h5>
						Bueno por: $  <?php echo number_format($filas["monto_abonogeneral"], 2)?><br>
						Fecha: <?php echo $filas["fecha_abonogeneral"]?><br>
						
					</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p>Recibi la cantidad de $ <?php echo NumeroALetras::convertir($filas["monto_abonogeneral"], 'PESOS', 'CENTAVOS')?></p><br>
					<p>Por concepto de: <?php echo $filas["concepto_abonogeneral"];?></p>
				</div>	 
			</div>
			
			
			<div class="row">
				<div class="col-4">
				</div>
				<div class="col-4 text-center border-top">
					<?php echo $filas["depositante"];?><br>
					Depositante
				</div>
			</div> 
			<br>
			<br>
			<div class="row">
				<div class="col-6 border-top">
					Impreso por: <?php echo $_COOKIE["nombre_usuarios"];?><br>
					Fecha Impresión: <?php echo date("Y-m-d h:i:s");?>
				</div>
				<div class="col-6 text-right">
					Creado por: <?php echo $filas["nombre_usuarios"];?><br>
					Fecha Creacion: <?php echo $filas["fecha_abonogeneral"];?><br>
				</div>
			</div> 
		</div> 
		
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<hr>
		<div class="media_carta h5">
			<div class="row">
				<div class="col-12 text-center" >
					<img  hidden 
					src="../../img/amt.jpg" class="img-fluid">
				</div>
				<div class="col-12 text-center">
					<h4><?php echo $filas["nombre_empresas"]?></h4>
				</div>
			</div>
			
			<legend>Abono General</legend> 
			
			<div class="row">
				<div class="col-6">
					<h5>
						Unidad: <?php echo $filas["num_eco"]?><br>
						Motivo: <?php echo $filas["nombre_motivosAbono"]?><br>
					</h5>
				</div>	 
				<div class="col-6 text-right">	
					<h4>Folio: <?php echo $filas["id_abonogeneral"]?></h4>
					<h5>
						Bueno por: $  <?php echo number_format($filas["monto_abonogeneral"], 2)?><br>
						Fecha: <?php echo $filas["fecha_abonogeneral"]?><br>
						
					</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p>Recibi la cantidad de $ <?php echo NumeroALetras::convertir($filas["monto_abonogeneral"], 'PESOS', 'CENTAVOS')?></p><br>
					<p>Por concepto de: <?php echo $filas["concepto_abonogeneral"];?></p>
				</div>	 
			</div>
			<div class="row">
				<div class="col-4">
				</div>
				<div class="col-4 text-center border-top">
					Depositante: <?php echo $filas["depositante"];?><br>
				</div>
			</div> 
			<br>
			<br>
			
			<div class="row">
				<div class="col-6 border-top">
					Impreso por: <?php echo $_COOKIE["nombre_usuarios"];?><br>
					Fecha Impresión: <?php echo date("Y-m-d h:i:s");?>
				</div>
				<div class="col-6 text-right">
					Creado por: <?php echo $filas["nombre_usuarios"];?><br>
					Fecha Creacion: <?php echo $filas["fecha_abonogeneral"];?><br>
				</div>
			</div> 
		</div> 
		
		
		<?php    
			
			
		}
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>																																				