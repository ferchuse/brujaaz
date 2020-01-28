<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$corridas = implode(",", $_POST["corridas"]);
	
	$insert ="INSERT INTO pagos_taquilla SET 
	fecha_pagos= NOW(),
	id_usuarios = '{$_COOKIE['id_usuarios']}',
	total_pagos = '{$_POST['total_pago']}',
	corridas = '{$corridas}'
	";
	
	$result = 	mysqli_query($link,$insert);
	
	if($result){
		$respuesta["estatus_insert"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		$respuesta["id_pagos"] = mysqli_insert_id($link);
		$respuesta["insert"] = $insert;
	}
	else{
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: $insert  ".mysqli_error($link);		
	}
	
	
	foreach($_POST["corridas"] as $i => $id_corridas){
		
		$update ="UPDATE corridas  SET 
		estatus_pago= 'PAGADA'
		WHERE id_corridas = '$id_corridas'
		";
		
		$result = 	mysqli_query($link,$update);
		
		$respuesta["update"][] = $update;
		
		if($result){
			$respuesta["estatus_update"][] = "success";
			$respuesta["mensaje_update"][] = "Guardado Correctamente";
			
		}
		else{
			$respuesta["estatus_update"][] = "error";
			$respuesta["mensaje_update"][] = "Error:".mysqli_error($link);		
		}
	}
	
	
	
	
	
	echo json_encode($respuesta);
	
?>