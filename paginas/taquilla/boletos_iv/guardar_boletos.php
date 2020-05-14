<?php 
	session_start();
	if(count($_COOKIE) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	for($i = 0 ; $i < $_POST["cantidad"]; $i++){
		//Inserta detalle de boletos
		
		$insert ="INSERT INTO boletos SET 
		id_corridas = '{$_POST['id_corridas']}' ,
		tipo_boleto = '{$_POST["tipo_boleto"]}',
		id_precio = '{$_POST["id_precio"]}',
		precio_boletos = '{$_POST["precio"]}',
		id_usuarios = '{$_COOKIE["id_usuarios"]}',
		fecha_boletos = NOW()
		";
		$result_detalle = 	mysqli_query($link,$insert);
		
		if($result_detalle){
			$respuesta["result"] = "success";
			$respuesta["boletos"][] = mysqli_insert_id($link);
		}
		else{ 
			$respuesta["result"] = "error";		
			$respuesta["mensaje"] = "Error en insert: $insert  ".mysqli_error($link);		
		}		
		
	}
	
	echo json_encode($respuesta);
	
?>