<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$saldo_restante = $_POST['saldo_tarjetas'] - $_POST['monto_condonaciones'];
	
	
	$insert_condonacion  ="INSERT INTO condonaciones SET 
	fecha_condonaciones = NOW(),
	tarjeta = {$_POST['tarjeta']},
	id_motivo_condonacion = {$_POST['id_motivo_condonacion']},
	monto_condonaciones = {$_POST['monto_condonaciones']},
	saldo_restante = {$_POST['saldo_unidades']},
	observaciones_condonaciones = '{$_POST['observaciones_condonaciones']}',
	id_usuarios = '{$_POST['id_usuarios']}',
	id_administrador = '{$_SESSION['id_administrador']}'
	
	";
	
	$result_insert = 	mysqli_query($link,$insert_condonacion);
	
	if($result_insert){
		$respuesta["estatus_insert"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		$respuesta["insert_id"] = mysqli_insert_id($link);
		
	}
	else{
		
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: $insert_condonacion  ".mysqli_error($link);		
	}
	
	$respuesta["insert_condonacion"] = $insert_condonacion;
	
	//Actualiza saldo de tarjeta
	
	$update ="UPDATE tarjetas SET 
	condonacion = {$_POST['monto_condonaciones']},
	saldo_tarjetas = {$saldo_restante} 
	WHERE tarjeta = {$_POST['tarjeta']}
	";	
	
	
	$result_update = 	mysqli_query($link,$update);
	
	if($result_update){
		$respuesta["estatus_update"] = "success";
		$respuesta["mensaje_update"] = "Tarjeta Actualizada";
		$respuesta["update"] = $update;
		
	}
	else{
		
		$respuesta["estatus_update"] = "error";
		$respuesta["mensaje_update"] = "Error en update: $update  ".mysqli_error($link);		
	}
	
	
	//Obtiene saldo anterior
	$q_saldo_anterior = "SELECT id_unidades, saldo_unidades FROM tarjetas LEFT JOIN unidades USING(id_unidades ) WHERE tarjeta = '{$_POST['tarjeta']}'";
	
	$result_saldo_anterior = mysqli_query($link, $q_saldo_anterior) ;
	
	if($result_saldo_anterior){
		$respuesta["result_saldo_anterior"] ="success";
		while($fila = mysqli_fetch_assoc($result_saldo_anterior)){
			
			$saldo_anterior = $fila["saldo_unidades"];
			$id_unidades = $fila["id_unidades"];
			$respuesta["id_unidades"] = $id_unidades;
			$respuesta["saldo_anterior"] = $saldo_anterior;
		}
	}
	else{
		
		$respuesta["result_saldo_anterior"] = "Error en $q_saldo_anterior, ". mysqli_error($link);
	}
	
	//Inserta en estado de cuenta 
	

	$insert_estado_cuenta = "INSERT INTO estado_cuenta 
	SET motivo = 'Condonacion #{$respuesta["insert_id"]}',
	fecha_estado_cuenta = CURDATE(),
	id_unidades =  {$id_unidades},
	observaciones = 'Monto {$_POST['monto_condonaciones']}, Tarjeta #{$_POST['tarjeta']}',
	tipo_movimiento = 'condonacion',
	saldo = '$saldo_anterior',
	saldo_anterior = '$saldo_anterior'
	
	";
	
	$result_estado = mysqli_query($link,$insert_estado_cuenta) ;
	
	if($result_estado){
		$respuesta["result_estado"] = "success";
	}
	else{
		$respuesta["result_estado"] = "Error $insert_estado_cuenta, ".mysqli_Error($link);
	}
	
	
	echo json_encode($respuesta);
	
?>