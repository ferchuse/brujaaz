<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	
	
	$consulta  ="INSERT INTO mantenimiento SET 

	fecha = '{$_POST['fecha']}',
	kilometraje = '{$_POST['kilometraje']}',
	fecha_proximo = '{$_POST['fecha_proximo']}',
	id_tipo_mantenimiento = '{$_POST['id_tipo_mantenimiento']}',
	id_unidades = '{$_POST["id_unidades"]}',
	observaciones = '{$_POST["observaciones"]}',
	id_usuarios = '{$_COOKIE["id_usuarios"]}',
	id_administrador = '{$_COOKIE["id_administrador"]}'
	";
	
	$result_insert = 	mysqli_query($link,$consulta);
	
	$respuesta["consulta"] = $consulta;
	
	if($result_insert){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		$respuesta["folio"] = mysqli_insert_id($link);
		
		
	}
	else{
		 
		$respuesta["estatus_insert"] = "error";
		$respuesta["mensaje_insert"] = "Error en insert: $consulta  ".mysqli_error($link);		
	}

	
	
	echo json_encode($respuesta);
	
?>