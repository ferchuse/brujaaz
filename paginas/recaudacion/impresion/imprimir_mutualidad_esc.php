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
		
		
		$print = "@";
		$print.= "Pago de Mutualidad".chr(10).chr(13);
		$print.= "Fecha: ".$filas["fecha_mutualidad"].chr(10).chr(13);
		$print.= "Usuario: ".$filas["nombre_usuarios"].chr(10).chr(13);
		$print.= "Empresa: ".$filas["nombre_empresas"].chr(10).chr(13);
		$print.= "Num Eco: ".$filas["num_eco"].chr(10).chr(13);
		$print.= "Monto: ".$filas["monto_mutualidad"].chr(10).chr(13);
		
		$print.=chr(10).chr(10).chr(13).chr(29).chr(86).chr(66).chr(0);
		
		echo base64_encode($print);
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>