<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM mutualidad 
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN recaudaciones USING(id_recaudaciones)
	LEFT JOIN conductores USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_mutualidad= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		
		if($_COOKIE["silent_print"] == "SI"){
			
			
			$print = "@";
			$print.= "PAGO DE MUTUALIDAD".chr(10).chr(13);
			$print.= "Fecha: ".$filas["fecha_mutualidad"].chr(10).chr(13);
			$print.= "Usuario: ".$filas["nombre_usuarios"].chr(10).chr(13);
			$print.= "Empresa: ".$filas["nombre_empresas"].chr(10).chr(13);
			$print.= "Num Eco: ".$filas["num_eco"].chr(10).chr(13);
			$print.= "Monto: ".$filas["monto_mutualidad"].chr(10).chr(13);
			
			$print.="\n\nVB";
			
			
			// $print.= "@";
			// $print.= "PAGO DE MUTUALIDAD COPIA".chr(10).chr(13);
			// $print.= "Fecha: ".$filas["fecha_mutualidad"].chr(10).chr(13);
			// $print.= "Usuario: ".$filas["nombre_usuarios"].chr(10).chr(13);
			// $print.= "Empresa: ".$filas["nombre_empresas"].chr(10).chr(13);
			// $print.= "Num Eco: ".$filas["num_eco"].chr(10).chr(13);
			// $print.= "Monto: ".$filas["monto_mutualidad"].chr(10).chr(13);
			
			// $print.="\n\nVB";
			
			echo base64_encode($print);
			
		}
		else{
			
		?> 
		<div >
			<legend>Pago de Mutualidad <?php if(isset($_GET["copia"])) echo "Copia"?></legend> 
			<div class="row mb-2">
				<div class="col-4">
					<b >Fecha:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_mutualidad"];?>
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
					<b >Empresa:</b> 
				</div>	 
				<div class="col-8">			
					<?php echo $filas["nombre_empresas"]?>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-4">
					<b >Num Eco:</b> 
				</div>	 
				<div class="col-8">			
					<?php echo $filas["num_eco"]?>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-4">
					<b >Monto:</b> 
				</div>	 
				<div class="col-8">			
					<?php echo $filas["monto_mutualidad"]?>
				</div>
			</div>
		</div>
		
		<div style="page-break-after:always;"></div>
		
		
		<?php
			
			
		}
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>