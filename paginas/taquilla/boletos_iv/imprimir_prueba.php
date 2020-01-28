<?php 
	session_start();
	

	$filas = array();
	$respuesta = array();
	
	
	
	
	$respuesta ="";
	
	$empresa = "";
	
	$respuesta.=   "\x1b"."@";
	$respuesta.= "\x1b"."E".chr(1); // Bold
	$respuesta.= "!"; //Font BIG
	$respuesta.=   "$empresa \n";
	$respuesta.=   "PRUEBA DE IMPRESION \n";
	
	$respuesta.= "\x1b"."d".chr(3); // 4 Blank lines	
	$respuesta.=  "\x1b"."E".chr(0); // Not Bold
	$respuesta.= "!\x11"; //font size
	$respuesta.= "Fecha:". date("Y-m-d");
	$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines	
	$respuesta.= "Hora:". date("H-i-s");
	$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
	
	$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
	
	$respuesta.= "\x1b"."d".chr(1); // 4 Blank lines
	
	
	$respuesta.=   "\x1b"."@"; // RESET defaults
	$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
	
	
	$respuesta.= "\x1b"."d".chr(1). "\n"; // Blank line
	$respuesta.= "VA"; // Cut
	echo base64_encode ( $respuesta );
	// echo  ( $respuesta );
	
	exit(0);
	
	
	
?>		