<?php 
	header("Content-Type: application/json");
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$update ="UPDATE corridas SET
	
	estatus_corridas = 'Finalizada',
	boletos_vendidos = '{$_POST["boletos_vendidos"]}',
	total_guia = '{$_POST["total_guia"]}'
	WHERE id_corridas = '{$_POST["id_corridas"]}'
	";
	
	$result = 	mysqli_query($link,$update);
	
	if($result){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
	
	}
	else{
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en update: $update  ".mysqli_error($link);		
	}
	
	
	
	echo json_encode($respuesta);
	
?>