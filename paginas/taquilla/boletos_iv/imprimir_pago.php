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
		
		$empresa = "GRUPO SAUCES";
		
		$respuesta.=   "\x1b"."@";
		$respuesta.= "\x1b"."E".chr(1); // Bold
		$respuesta.= "!";
		$respuesta.=   "$empresa \n";
		$respuesta.=   "PAGO DE TAQUILLA \n";
		$respuesta.=  "\x1b"."E".chr(0); // Not Bold
		$respuesta.= "!\x11"; //font size
		$respuesta.= "Fecha:". $guias[0]["fecha_pagos"];
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		$respuesta.= "Corridas: ". $guias[0]["corridas"];;
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		$respuesta.= "Total: ". $guias[0]["total"];;
		$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
		
		
		$respuesta.=   "\x1b"."@"; // RESET defaults
		$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
		
		
		
		$total_guia = 0;
		if(!$result_guia){
			echo "<pre>".mysqli_error($result_guia)."</pre>";
			
		}
		
		foreach($guias AS $i =>$fila){
			$importe= $fila["cantidad"] * $fila["precio_boletos"];
			$total_guia+= $importe;
			$total_boletos += $fila["cantidad"];
			
			
			$respuesta.=  $fila["cantidad"]."\x09";
			$respuesta.=  $fila["destino"]."\x09"."\x09";
			$respuesta.="$". $fila["precio_boletos"]."\x09"."\x09";
			$respuesta.= "$" .	number_format($importe,0);
			
			$respuesta.= "\x1b"."d".chr(1). "\n"; // Blank line
			
			
			
		}
		
		
		$respuesta.= "TOTAL: $". number_format($total_guia). "\n"; // Blank line
		$respuesta.= "Boletos Vendidos: ". $total_boletos ."\n"; // Blank line
		$respuesta.= "\x1b"."d".chr(1). "\n"; // Blank line
		$respuesta.= "VA"; // Cut
		echo base64_encode ( $respuesta );
		
		exit(0);
		
		
	}
	
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>		