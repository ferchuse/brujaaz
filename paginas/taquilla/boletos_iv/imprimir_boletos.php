<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$boletos = implode("," ,$_GET['boletos']);
	
	$consulta = "SELECT * FROM boletos 
	LEFT JOIN usuarios ON boletos.id_usuarios = usuarios.id_usuarios
	LEFT JOIN corridas  USING(id_corridas)
	LEFT JOIN origenes  USING(id_origenes)
	LEFT JOIN precios_boletos  USING(id_precio)
	LEFT JOIN (
	SELECT id_origenes as id_destinos, nombre_origenes AS destino 
	FROM origenes
	) AS destinos
	ON precios_boletos.id_destinos = destinos.id_destinos
	
	WHERE id_boletos IN($boletos)";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro no encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas[] = $fila ;
			
		}
		
	?> 
	<div class="ml-5 mt-5">
		
		<?php foreach($filas as $i => $item){?>
			<h4 class="text-center">GRUPO SAUCES</h4>
			<div class="form-row mb-2">
				<b >Folio:</b>
				<?php echo $item["id_boletos"]?>
			</div>
			<div class="form-row mb-2">
				<b >Taquillero: </b>
				<?php echo $item["nombre_usuarios"]?>
			</div>
			
			<div class="form-row mb-2">
				<div class="col-4">
					<b >Destino :</b>
				</div>	 
				<div class="col-8">			
					<?php echo $item["destino"]?>
				</div>
			</div>
			<div class="form-row mb-2">
				<div class="col-4">
					<b >Fecha:</b>
				</div>	 
				<div class="col-8">			
				<?php echo date("d-m-Y", strtotime($item["fecha_boletos"]))?>
			</div>
		</div>
		<div class="form-row mb-2">
			<div class="col-4">
				<b >Hora:</b>
			</div>	 
			<div class="col-8">			
				<?php echo date("H:i:s", strtotime($item["fecha_boletos"]))?>
			</div>
		</div>
		
		
		<div class="form-row mb-2">
			<div class="col-4">
				<b >#Eco:</b>
			</div>	 
			<div class="col-8">			
				<?php echo $item["num_eco"]?>
			</div>
		</div>
		
		<div class="form-row mb-2">
			<div class="col-4">
				<b >Precio:</b>
			</div>	 
			<div class="col-8">			
				$ <?php echo $item["precio_boletos"]?>
			</div>
		</div>
		
		<h4 class="text-center">Seguro del Viajero</h4>
		<br>
		<br>
		<br class="mb-5">
		<hr>
		<hr>
		<?php	 
		}
	?>
	
	
</div>


<?php
	
	
}
else {
	echo "Error en ".$consulta.mysqli_Error($link);
	
}


?>