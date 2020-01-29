<?php 
	session_start();
	if(count($_SESSION) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	
	$consulta = "SELECT * FROM pagos_taquilla
	WHERE id_pagos = '{$_GET["id_pagos"]}' ";
  
	
	$result = mysqli_query($link,$consulta);
	
	
	while($fila = mysqli_fetch_assoc($result)){
		
		$filas[] = $fila ;
	}
	
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay boletos venidos</div>");
			
		}
		
		
		
		$respuesta ="";
		
		$empresa = "";
		
		$respuesta.=   "\x1b"."@";
		$respuesta.= "\x1b"."E".chr(1); // Bold
		$respuesta.= "!"; //Font BIG
		$respuesta.=   "$empresa \n";
		$respuesta.=   "PAGO DE TAQUILLA \n";
		
			$respuesta.= "\x1b"."d".chr(3); // 4 Blank lines	
		$respuesta.=  "\x1b"."E".chr(0); // Not Bold
		$respuesta.= "!\x11"; //font size
		$respuesta.= "Folio: ". $filas[0]["id_pagos"];
		$respuesta.= "\x1b"."d".chr(1); 
		$respuesta.= "Fecha:". date("Y-m-d", strtotime($filas[0]["fecha_pagos"]));
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines	
		$respuesta.= "Hora:". date("H-i-s", strtotime($filas[0]["fecha_pagos"]));
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		$respuesta.= "Corridas: ". $filas[0]["corridas"];;
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		$respuesta.= "Total: $". $filas[0]["total_pagos"];;
		$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
		
			$respuesta.= "Recibe: ". $filas[0]["recibe"];;
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		
		
		$respuesta.=   "\x1b"."@"; // RESET defaults
		$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
		
		
		$respuesta.= "\x1b"."d".chr(1). "\n"; // Blank line
		$respuesta.= "VA"; // Cut
		echo base64_encode ( $respuesta );
		// echo  ( $respuesta );
		
		exit(0);
		
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>		