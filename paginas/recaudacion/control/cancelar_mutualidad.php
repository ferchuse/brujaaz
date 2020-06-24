<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$fecha_cancelacion = date("Y-m-d H:i:s");
	$consulta = "UPDATE mutualidad
	
	SET estatus_mutualidad = 'Cancelado' ,
	datos_cancelacion = 'Usuario: {$_COOKIE["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion'
	
	WHERE id_mutualidad = {$_GET["id_registro"]}";
	
	$result = mysqli_query($link,$consulta) ;
	
	if($result){
		$respuesta["result"] = "success";
		$respuesta["consulta"] = $consulta;
	}
	else{
		$respuesta["result"] = mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>