<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	
	$datos_cancelacion = 
	"
	Usuario: {$_COOKIE["nombre_usuarios"]} <br>
	Fecha: $fecha_cancelacion <br>
	Motivo: {$_POST["motivo"]} <br>
	
	";
	
	$cancelar = "
	UPDATE corridas
	LEFT JOIN boletos USING(id_corridas)
	SET
	estatus_corridas = 'Cancelada' ,
	estatus_boletos = 'Cancelado' ,
	corridas.datos_cancelacion = '$datos_cancelacion',
	boletos.datos_cancelacion = '$datos_cancelacion'
	WHERE  id_corridas = '{$_POST["id_registro"]}';
	
	";
	
	$result = mysqli_query($link,$cancelar) ;
	
	if($result){
		$respuesta["result"] = "success";
		$respuesta["consulta"] = "$cancelar";
	}
	else{
		$respuesta["result"] = "Error en $cancelar". mysqli_Error($link);
	}
	
	
	
	echo json_encode($respuesta);
	
?>