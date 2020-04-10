<?php 
	
	include('../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	
	setcookie("silent_print",  $_POST["silent_print"],  0, "/");
	
	$query ="UPDATE usuarios 
	SET silent_print = '{$_POST["silent_print"]}' 
	WHERE id_usuarios = {$_COOKIE["id_usuarios"]}";	
	
	
	$exec_query = 	mysqli_query($link,$query);
	
	if($exec_query){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje"] = "Actualizado";
		
		$respuesta["query"] = $query;
		
    }else{
		
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en insert: $query  ".mysqli_error($link);		
	}
	
	echo json_encode($respuesta);
	
?>