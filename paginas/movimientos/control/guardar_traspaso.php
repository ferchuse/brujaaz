<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$saldo_restante = $_POST['saldo_tarjetas'] - $_POST['monto_condonaciones'];
	
	
	$insert_traspaso  ="INSERT INTO traspaso_utilidad SET 
	fecha_traspaso = CURTIME(),	
	fecha_aplicacion = '{$_POST['fecha_aplicacion']}',
	referencia_bancaria = '{$_POST['referencia_bancaria']}',
	concepto_traspaso = '{$_POST["concepto_traspaso"]}',
	monto_traspaso = '{$_POST["monto_traspaso"]}',
	beneficiario = '{$_POST["beneficiario"]}',
	id_usuarios = '{$_POST["id_usuarios"]}'
	";
	
	$result_insert = 	mysqli_query($link,$insert_traspaso);
	
	if($result_insert){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		$respuesta["insert_id"] = mysqli_insert_id($link);
		$respuesta["insert"] = $insert_traspaso;
		
	}
	else{
		 
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: $insert_traspaso  ".mysqli_error($link);		
	}
	
	//Por cada unidad inserta monto, estado de cuenta y actualiza saldo
	
	
	foreach($_POST["id_unidades"] as $i => $item){
		
		$insert_monto_unidades ="INSERT into traspaso_utilidad_unidades SET 
		id_traspaso = '{$respuesta["insert_id"]}',
		monto = '{$_POST['monto'][$i]}',
		saldo_anterior = '{$_POST['saldo_anterior'][$i]}',
		saldo_restante = '{$_POST['saldo_restante'][$i]}',
		id_unidades = '{$_POST['id_unidades'][$i]}'
		";	
		
		$result_monto_unidades = 	mysqli_query($link,$insert_monto_unidades);
		
		if($result_monto_unidades){
			$respuesta["result_monto_unidades"] = "success";
			
		}
		else{
			
			$respuesta["result_monto_unidades"] = "error";
			$respuesta["insert_monto_unidades"] = "Error en: $insert_monto_unidades  ".mysqli_error($link);		
		}
		
		
		 
		
		//Inserta en estado de cuenta 
		
		
		$insert_estado_cuenta = "INSERT INTO estado_cuenta 
		SET motivo = 'Retiro a Cuenta de Liquidación #{$respuesta["insert_id"]}',
		fecha_estado_cuenta = '{$_POST['fecha_aplicacion']}',
		id_unidades =  '{$_POST['id_unidades'][$i]}',
		cargo =  '{$_POST['monto'][$i]}',
		saldo = '{$_POST['saldo_restante'][$i]}',
		saldo_anterior = '{$_POST['saldo_anterior'][$i]}',
		tipo_movimiento = 'traspaso',
		observaciones = '{$_POST['concepto']}'
		";
		
		$result_estado = mysqli_query($link,$insert_estado_cuenta) ;
		
		if($result_estado){
			$respuesta["result_estado"] = "success";
		}
		else{
			$respuesta["result_estado"] = "Error $insert_estado_cuenta, ".mysqli_Error($link);
		}
		
		
		
	}
	
	echo json_encode($respuesta);
	
?>