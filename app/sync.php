<?php 
	header("Content-Type: application/json");
	
	include('../conexi.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	echo json_encode($respuesta);
	
	exit();
	
	// INSERT 
	foreach ($_POST["corridas"]){
		
		$consulta = "INSERT INTO corridas
		";
		
		
		
		$result = mysqli_query($link,$consulta);
		if($result){
			
			if( mysqli_num_rows($result) == 0){
				die("<div class='alert alert-danger'>No hay registros</div>");
				
			}
		}
	}
	
	
	
	
	
	
	////TAQUILLAS
	
	$consulta = "SELECT * FROM taquillas 	";
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		$resultados = [];
		
		while($fila = mysqli_fetch_assoc($result)){
			$resultados[] = $fila ;
		}
		
		foreach($resultados as $registro){
		$respuesta["taquillas"][] = $registro;
	}
	}
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
	}
	
	
	////USUARIOS
	
	$consulta = "SELECT * FROM usuarios 
	WHERE id_administrador = '$id_administrador'
	AND estatus_usuarios = 'Alta'
	ORDER BY nombre_usuarios
	";
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		$resultados = [];
		
		while($fila = mysqli_fetch_assoc($result)){
			$resultados[] = $fila ;
		}
		
		foreach($resultados as $registro){
			$respuesta["usuarios"][] = $registro;
		}
	}
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
	}
	
	
	
	

echo json_encode($respuesta);


?>