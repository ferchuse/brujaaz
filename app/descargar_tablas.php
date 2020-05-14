<?php 
	header("Content-Type: application/json");
	session_start();
	// if(count($_COOKIE) == 0){
		// die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	// }
	include('../conexi.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$respuesta["comandos"]["esc"] = chr(27);
	$respuesta["comandos"]["init"] = chr(27)."@";
	$respuesta["comandos"]["gs"] = chr(29);
	// $respuesta["comandos"]["cut"] = chr(27);
	
	if(isset($_GET["id_administrador"])){
		
		$id_administrador = $_GET["id_administrador"];
	}
	else{
		$id_administrador = 2;
	}
	
	$consulta = "SELECT * FROM precios_boletos 
	LEFT JOIN origenes USING(id_origenes) 
	LEFT JOIN (
	SELECT id_origenes AS id_destinos,
	nombre_origenes AS nombre_destinos
	FROM origenes) t_destinos
	USING(id_destinos)
	WHERE precios_boletos.id_administrador = '$id_administrador'
	ORDER BY nombre_destinos
	";
	

	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros</div>");
			
		}
		
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$resultados[] = $fila ;
			
			
		}
		
		
		foreach($resultados as $registro){
			
				$respuesta["destinos"][] = $registro["nombre_destinos"];
				$respuesta["precios"][] = number_format($registro["precio"], 0);
		}
		
		
	}
	
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
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
	
		$consulta = "SELECT * FROM empresas 
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
				$respuesta["empresas"][] = $registro["nombre_empresas"];
		}
	}
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
	}
	
	
	
	
	
	echo json_encode($respuesta);
	
	
?>