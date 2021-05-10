<?php
	header("Content-Type: application/json");
	include ("conexi.php");
	$link = Conectarse();
	$respuesta = Array();
	
	
	$consulta = "SELECT * FROM usuarios 
	WHERE  id_usuarios = {$_COOKIE["id_usuarios"]}";
	
	
	$result = mysqli_query($link, $consulta) or die("Error dame_permiso($consulta) ". mysqli_error($link));
	
	if(mysqli_num_rows($result) > 0){
		while($fila = mysqli_fetch_assoc($result)){
			
			$respuesta = $fila;
		}		
	}
	else{
		
	}
	
	
	
	
	
	echo json_encode($respuesta);
?>