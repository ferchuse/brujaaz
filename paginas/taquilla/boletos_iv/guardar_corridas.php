<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$consulta_folio = "SELECT folio_corrida , CONCAT(serie_taquilla, '-', folio_corrida) AS nuevo_folio FROM taquillas WHERE id_taquilla = 1";
	
	$respuesta["consulta_folio"] = $consulta_folio;
	
	
	$result_folio = mysqli_query($link,$consulta_folio);
	
	
	if($result_folio){
		$respuesta["estatus_folio"] = "success";
		$fila_folio = mysqli_fetch_assoc($result_folio);
		
		$respuesta["fila_folio"] = $fila_folio;
		$nuevo_folio =  $fila_folio["nuevo_folio"];
		
		$respuesta["nuevo_folio"] = "$nuevo_folio";
	}
	else{
		$respuesta["estatus_folio"] = "error";
		$respuesta["mensaje_folio"] = mysqli_error($link);		
		
	}
	
	
	$insert ="INSERT INTO corridas SET 
	
	id_corridas= '{$nuevo_folio}',
	fecha_corridas= '{$_POST['fecha_corridas']}',
	hora_corridas= CURTIME(),
	id_unidades = '{$_POST['id_unidades']}',
	id_taquillas = '{$_POST['id_recaudaciones']}',
	id_usuarios = '{$_POST["id_usuarios"]}',
	origen = '{$_POST["origen"]}',
	destino = '{$_POST["destino"]}',
	num_eco = '{$_POST["num_eco"]}',
	id_empresas = '{$_POST["id_empresas"]}',
	id_administrador = '{$_COOKIE["id_administrador"]}',
	estatus_corridas = 'Activa'
	";
	
	$result = 	mysqli_query($link,$insert);
	
	if($result){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje_insert"] = "Guardado Correctamente";
		// $respuesta["insert_id"] = mysqli_insert_id($link);
		$respuesta["insert_id"] =$nuevo_folio;
		$respuesta["insert"] = $insert;
	}
	else{
		$respuesta["estatus_insert"] = "error";
		$respuesta["errnum"] = mysqli_errno($link);		
		$respuesta["mensaje_insert"] = "Error en insert: $insert  ".mysqli_error($link);		
	}
	
	
	
	$update ="UPDATE taquillas SET folio_corrida = folio_corrida + 1 
	WHERE id_taquilla = 1
	";
	
	$result = 	mysqli_query($link,$update);
	
	if($result){
		$respuesta["estatus_update"] = "success";
		$respuesta["mensaje_update"] = "Guardado Correctamente";
		
	}
	else{
		$respuesta["estatus_update"] = "error";
		// $respuesta["errnum"] = mysqli_errno($link);		
		$respuesta["mensaje_update"] = "Error en update: $update  ".mysqli_error($link);		
	}
	
	
	
	echo json_encode($respuesta);
	
?>