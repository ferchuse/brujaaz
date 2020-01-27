<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$boletos = implode("," ,$_GET['boletos']);
	
	$consulta = "SELECT * FROM boletos 
	LEFT JOIN usuarios ON boletos.id_usuarios = usuarios.id_usuarios
	LEFT JOIN corridas  USING(id_corridas)
	LEFT JOIN origenes  USING(id_origenes)
	LEFT JOIN precios_boletos  USING(id_precio)
	LEFT JOIN (
	SELECT id_origenes as id_destinos, nombre_origenes AS destino 
	FROM origenes
	) AS destinos
	ON precios_boletos.id_destinos = destinos.id_destinos
	
	WHERE id_boletos = '{$_GET['boletos']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro no encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$item = $fila ;
			
		}
		
		$respuesta = "";
		
		// public const ESC = "\x1b";
		// public const GS="\x1d";
		// public const NUL="\x00";
		
		// echo "GRUPO SAUCES \n"; // Company
		
		$respuesta.=   "\x1b"."@";
		$respuesta.= "\x1b"."E".chr(1); // Bold
		$respuesta.= "!";
		$respuesta.=   "GRUPO SAUCES \n";
		$respuesta.=  "\x1b"."E".chr(0); // Not Bold
		$respuesta.= "!\x10";
		$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
		
		$respuesta.=  	"Folio:". $item["id_boletos"]. "\n"."\n";
		
		$respuesta.=  "Taquillero:" . $item["nombre_usuarios"]."\n";
		$respuesta.= "\x1b"."d".chr(1); // Blank line
		$respuesta.= "Destino :". $item["destino"]."\n";
		$respuesta.= "\x1b"."d".chr(1); // Blank line
		$respuesta.= "Fecha:" . date('d-m-Y', strtotime($item["fecha_boletos"]))."\n";
		$respuesta.= "\x1b"."d".chr(1); // Blank line
		$respuesta.= "Hora:" . date('H:i:s', strtotime($item["fecha_boletos"]))."\n";
		$respuesta.= "\x1b"."d".chr(1); // Blank line
		$respuesta.= "#Eco:". $item["num_eco"]."\n";
		$respuesta.= "Precio: $ ". $item["precio_boletos"]."\n";
		$respuesta.= "\x1b"."d".chr(1); // Blank line
		$respuesta.= "aSeguro de Viajero\n"; // Blank line
	$respuesta.= "\x1b"."d".chr(1). "\n"; // Blank line
	
		
		// /* Output an example receipt */
		// echo ESC."@"; // Reset to defaults
		// echo ESC."E".chr(1); // Bold
		// echo "FOO CORP Ltd.\n"; // Company
		// echo ESC."E".chr(0); // Not Bold
		// echo ESC."d".chr(1); // Blank line
		// echo "Receipt for whatever\n"; // Print text
		// echo ESC."d".chr(4); // 4 Blank lines
		
		// /* Bar-code at the end */
		// echo ESC."a".chr(1); // Centered printing
		
		// echo ESC."d".chr(1); // Blank line
		// echo "987654321\n"; // Print number
		// $respuesta.= " \x1d"."V\x41".chr(3); // Cut
		$respuesta.= "VA"; // Cut
		
		// $respuesta = "@@aHello World
		// !aESC/POS Printer Test
		// !aGoodbye World
		// VA"; 
		
		echo base64_encode ( $respuesta );
		exit(0);
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
	/*
		GRUPO SAUCES
		
		Folio: <?php echo $item["id_boletos"]?>
		
		<b >Taquillero: </b>  <?php echo $item["nombre_usuarios"]?>
		
		<b >Destino :</b>  <?php echo $item["destino"]?>
		
		<b >Fecha:</b> <?php echo date("d-m-Y", strtotime($item["fecha_boletos"]))?>
		
		<b >Hora:</b> <?php echo date("H:i:s", strtotime($item["fecha_boletos"]))?>
		
		<b >#Eco:</b> <?php echo $item["num_eco"]?>
		
		<b >Precio:</b> $ <?php echo $item["precio_boletos"]?>
	*/
	
	
	
?>


