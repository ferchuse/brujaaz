<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	//Cancelar Abono
	
	$cancelar = "UPDATE mutualidad
	
	SET estatus_mutualidad = 'Cancelado' 
	
	WHERE id_mutualidad = {$_GET["id_registro"]}";
	
	$result = mysqli_query($link,$cancelar) ;
	
	if($result){
		$respuesta["result"] = "success";
	}
	else{
		$respuesta["result"] = "Error en $cancelar". mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>