<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$saldo_restante = $_POST['saldo_anterior'] + $_POST['abono_unidad'];
	
	
	$insert_abono  ="INSERT INTO abonos_unidades SET 
	fecha_abonos = NOW(),
	tarjeta = {$_POST['tarjeta']},
	id_abonos_unidades = '{$_POST["id_abonos_unidades"]}',
	id_recaudaciones = '{$_POST["id_recaudaciones"]}',
	bol_termicos_cantidad = '{$_POST["bol_termicos_cantidad"]}',
	bol_termicos_importe = '{$_POST["bol_termicos_importe"]}',
	importe_tijera = '{$_POST["importe_tijera"]}',
	total_boletos = '{$_POST["total_boletos"]}',
	saldo_anterior = '{$_POST["saldo_anterior"]}',
	saldo_restante = '$saldo_restante',
	efectivo = '{$_POST["efectivo"]}',
	abono_unidad = '{$_POST["abono_unidad"]}',
	devolucion = '{$_POST["devolucion"]}',
	total_recaudado = '{$_POST["total_recaudado"]}',
	id_usuarios = '{$_POST["id_usuarios"]}',
	id_administrador = '{$_COOKIE["id_administrador"]}'
	";
	
	$result_insert = 	mysqli_query($link,$insert_abono);
	
	if($result_insert){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		$respuesta["insert_id"] = mysqli_insert_id($link);
		$respuesta["insert"] = $insert_abono;
		
	}
	else{
		
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: $insert_abono  ".mysqli_error($link);		
	}
	
	//Actualiza saldo de tarjeta
	
	$update ="UPDATE tarjetas SET 
	estatus_tarjetas = 'Recaudada'
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
	
	$saldo_unidades_restante =  $saldo_anterior + $_POST["abono_unidad"];
	
	$insert_estado_cuenta = "INSERT INTO estado_cuenta 
	SET motivo = 'Abono #{$respuesta["insert_id"]}',
	fecha_estado_cuenta = CURDATE(),
	id_unidades =  {$id_unidades},
	abono =  {$_POST["abono_unidad"]},
	saldo = '$saldo_unidades_restante',
	saldo_anterior = '$saldo_anterior'
	
	";
	
	$result_estado = mysqli_query($link,$insert_estado_cuenta) ;
	
	if($result_estado){
		$respuesta["result_estado"] = "success";
	}
	else{
		$respuesta["result_estado"] = "Error $insert_estado_cuenta, ".mysqli_Error($link);
	}
	
	//Actualiza Saldo restante
	
	// $update_saldo = "UPDATE unidades SET saldo_unidades = '$saldo_unidades_restante' WHERE id_unidades = $id_unidades";
	
	// $result_saldo = mysqli_query($link,$update_saldo) ;
	
	// if($result_saldo){
		// $respuesta["result_saldo"] = "success";
	// }
	// else{
		// $respuesta["result_saldo"] = "Error en $update_saldo". mysqli_Error($link);
	// }
	
	//Actualiza Guias(boletaje)
	
	$update_boletaje = "UPDATE boletaje SET 
	estatus_boletaje = 'Quemado',
	tarjeta_asociada = {$_POST['tarjeta']} 
	WHERE id_unidades = $id_unidades" ;
	
	$result_boletaje = mysqli_query($link,$update_boletaje) ;
	
	if($result_saldo){
		$respuesta["result_boletaje"] = "success";
	}
	else{
		$respuesta["result_boletaje"] = "Error en $update_boletaje". mysqli_Error($link);
	}
	
	
	echo json_encode($respuesta);
	
?>