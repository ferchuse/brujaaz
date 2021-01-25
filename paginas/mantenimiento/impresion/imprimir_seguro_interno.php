<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/numero_a_letras.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM seguro_interno 
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN beneficiarios USING(id_beneficiarios) 
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_seguro_interno= '{$_GET['folio']}'";
	
	
	$result = mysqli_query($link,$consulta); 
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
		
			
		}
		
	?> 
	<div class="media_carta">
		<div class="row">
			<div class="col-12 text-center" >
				<img  hidden 
				src="../../img/amt.jpg" class="img-fluid">
			</div>
			<div class="col-12 text-center">
				<h4><?php echo $filas["nombre_empresas"]?></h4>
			</div>
		</div>
		
		<legend>Recibo</legend> 
		
		<div class="row">
			<div class="col-6">
				<h5>
					Empresa: <?php echo $filas["nombre_empresas"]?><br>
					Motivo: SEGURO INTERNO<br>
				</h5>
			</div>	 
			<div class="col-6 text-right">	
				<h4>Folio: <?php echo $filas["id_seguro_interno"]?></h4>
				<h5>
					Bueno por: $  <?php echo number_format($filas["monto"], 2)?><br>
					Fecha: <?php echo $filas["fecha"]?><br>
					
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p>Recibi la cantidad de $ <?php echo NumeroALetras::convertir($filas["monto"], 'PESOS', 'CENTAVOS')?></p><br>
				<p>Observaciones: <?php echo $filas["observaciones"];?></p>
			</div>	 
		</div>
		
		
		<div class="row text-center">
			<div class="col-4 ">
			</div>
			<div class="col-4 border-bottom">
			 <?php echo $filas["nombre_beneficiarios"];?>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-4 ">
			</div>
			<div class="col-4 ">
			 Recibí
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-6 border-top">
				Impreso por: <?php echo $_COOKIE["nombre_usuarios"];?><br>
				Fecha Impresión: <?php echo date("Y-m-d h:i:s");?>
			</div>
			<div class="col-6 text-right">
				Creado por: <?php echo $filas["nombre_usuarios"];?><br>
				Fecha Creacion: <?php echo $filas["fecha"];?><br>
			</div>
		</div> 
	</div> 
	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<hr>
	
	<div class="media_carta">
		<div class="row">
			<div class="col-12 text-center" >
				<img hidden src="../../../img/amt.jpg" class="img-fluid">
			</div>
			<div class="col-12 text-center">
				<h4><?php echo $filas["nombre_empresas"]?></h4>
			</div>
		</div>
		
		<legend>Recibo COPIA</legend> 
		 
		<div class="row">
			<div class="col-6">
				<h5>
					Empresa: <?php echo $filas["nombre_empresas"]?><br>
					Motivo: SEGURO INTERNO<br>
				</h5>
			</div>	 
			<div class="col-6 text-right">	
				<h4>Folio: <?php echo $filas["id_seguro_interno"]?></h4>
				<h5>
					Bueno por: $  <?php echo number_format($filas["monto"], 2)?><br>
					Fecha: <?php echo $filas["fecha"]?><br>
					
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p>Recibi la cantidad de $ <?php echo NumeroALetras::convertir($filas["monto"], 'PESOS', 'CENTAVOS')?></p><br>
				<p>Observaciones: <?php echo $filas["observaciones"];?></p>
			</div>	 
		</div>
		<div class="row text-center">
			<div class="col-4 ">
			</div>
			<div class="col-4 border-bottom">
			 <?php echo $filas["nombre_beneficiarios"];?>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-4 ">
			</div>
			<div class="col-4 ">
			 Recibí
			</div>
		</div>
		<br>
		
		<div class="row">
			<div class="col-6 border-top">
				Impreso por: <?php echo $_COOKIE["nombre_usuarios"];?><br>
				Fecha Impresión: <?php echo date("Y-m-d h:i:s");?>
			</div>
			<div class="col-6 text-right">
				Creado por: <?php echo $filas["nombre_usuarios"];?><br>
				Fecha Creacion: <?php echo $filas["fecha"];?><br>
			</div>
		</div> 
	</div> 
	
	
	
	
	<?php    
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>																																				