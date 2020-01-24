<?php 
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	
	//Inserta detalle de boletos
	
	$consulta ="SELECT * FROM corridas 
	WHERE  
	id_administrador = '{$_SESSION['id_administrador']}' ,
	AND estatus_corridas = 'Activo'
	";
	$result = 	mysqli_query($link,$insert);
	
	if($result){
		
		if(mysqli_num_rows($result) == 0){
			
			
		}
	}
	else{ 
		$respuesta["result"] = "error";		
		$respuesta["mensaje"] = "Error en insert: $insert  ".mysqli_error($link);		
	}		
	
	
	
	echo json_encode($respuesta);
	
	?>	