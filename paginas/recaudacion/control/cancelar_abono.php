<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	//Cancelar Abono
	
	$cancela_abono = "UPDATE abonos_unidades
	LEFT JOIN tarjetas USING(tarjeta) 
	LEFT JOIN boletaje ON boletaje.tarjeta_asociada = abonos_unidades.tarjeta 
	LEFT JOIN mutualidad ON mutualidad.tarjeta = abonos_unidades.tarjeta 
	SET
	estatus_abonos = 'Cancelado' ,
	estatus_mutualidad = 'Cancelado',
	estatus_tarjetas = 'Sin Recaudar',
	estatus_boletaje = 'Activo',
	
	abonos_unidades.datos_cancelacion='Usuario: {$_GET["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion'
	WHERE  id_abonos_unidades = {$_GET["id_registro"]}";
	
	$result_abono = mysqli_query($link,$cancela_abono) ;
	
	if($result_abono){
		$respuesta["result"] = "success";
	}
	else{
		$respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>