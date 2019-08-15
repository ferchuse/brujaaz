<?php 
	session_start(); 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	//Cancelar Abono
	
	$cancelar_registro = "UPDATE condonaciones 
	LEFT JOIN tarjetas USING(tarjeta) 
	SET 
	condonacion = 0 ,
	estatus_condonaciones = 'Cancelado' ,
	condonaciones.datos_cancelacion='Usuario: {$_GET["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion'
	WHERE  id_condonaciones = {$_GET["id_registro"]}";
	
	$result_abono = mysqli_query($link,$cancelar_registro) ;
	
	if($result_abono){
		$respuesta["result"] = "success";
		$respuesta["query"] = $cancelar_registro;
	}
	else{
		$respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>