<?php 
	session_start(); 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	//Cancelar Abono
	
	$cancela_abono = "UPDATE tarjetas 
	LEFT JOIN mutualidad USING(tarjeta) 
	LEFT JOIN condonaciones USING(tarjeta) 
	SET 
	condonacion = 0 ,
	estatus_condonaciones = 'Cancelado' ,
	estatus_tarjetas = 'Cancelado' ,
	estatus_mutualidad = 'Cancelado',
	tarjetas.datos_cancelacion='Usuario: {$_GET["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion'
	WHERE  tarjeta = {$_GET["id_registro"]}";
	
	$result_abono = mysqli_query($link,$cancela_abono) ;
	
	if($result_abono){
		$respuesta["result"] = "success";
	}
	else{
		$respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>