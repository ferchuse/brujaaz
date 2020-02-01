<?php 
	session_start();
	// if(count($_SESSION) == 0){
		// die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	// }
	include('../conexi.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$consulta = "SELECT * FROM precios_boletos 
	LEFT JOIN origenes USING(id_origenes) 
	LEFT JOIN (
	SELECT id_origenes AS id_destinos,
	nombre_origenes AS nombre_destinos
	FROM origenes) t_destinos
	USING(id_destinos)
	WHERE precios_boletos.id_administrador = {$_GET["id_administrador"]}
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
	
	echo json_encode($respuesta);
	
	
?>