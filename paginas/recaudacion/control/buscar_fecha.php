<?php 
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	
	$consulta = "SELECT
	*
	FROM
	tarjetas
	LEFT JOIN unidades USING (id_unidades)
	WHERE
	fecha_tarjetas = '{$_GET['fecha_tarjetas']}'
	AND estatus_tarjetas <> 'Cancelado' 
	AND unidades.num_eco = '{$_GET['num_eco']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) > 0){
			
			$respuesta["existe"] = 1;
		}
		else{
			$respuesta["existe"] = 0;
		}
	}
	else {
		
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en ".$consulta.mysqli_Error($link);
		
	
	}
	echo json_encode($respuesta);
	
?>						