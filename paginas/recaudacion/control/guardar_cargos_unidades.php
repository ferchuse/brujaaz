<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	if($_POST["tipo_cargo"] == 'gasto_administracion'){
		
		$motivo = "Gastos Administrativos ";
	}
	else{
		$motivo = "Seguro";
	}
	
	$insert_cargo  ="	INSERT INTO cargos_unidades	SET 
	cargo = '{$_POST["cargo"]}',
	fecha_cargos = '{$_POST["fecha_cargos"]}',
	tipo_cargo = '{$_POST["tipo_cargo"]}',
	id_unidades =  '{$_POST["id_unidades"]}',
	motivo =  '{$motivo}'
	
	ON DUPLICATE KEY 	UPDATE    
	cargo = '{$_POST["cargo"]}'
	
	";
	
	$result_insert = 	mysqli_query($link,$insert_cargo);
	
	if($result_insert){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		
		$respuesta["insert"] = $insert_cargo;
		
	}
	else{
		
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: ".$insert_cargo .mysqli_error($link);		
	}
	
	
	echo json_encode($respuesta);
	
?>