<?php
	
	function Conectarse()
	{
		
		$host="localhost";
		
		if($_SERVER["SERVER_NAME"] == "localhost"  || $_SERVER["SERVER_NAME"] == "192.168.1.81"){
			$db="brujaaz";
			$usuario="sistemas";
			$pass="Glifom3dia";
		}
		else{
			
			
			$db="brujaaz_brujaaz";
			$usuario="brujaaz_sistemas";
			$pass="Glifom3dia";
			
			
		}
		
		setlocale(LC_ALL,"es_ES");
		$set_local = "SET time_zone = '-05:00'";
		$set_names = "SET NAMES 'utf8'";
		date_default_timezone_set('America/Mexico_City');
		
    if (!($link=mysqli_connect($host,$usuario,$pass)))
		{
			die( "Error conectando a la base de datos.". mysqli_error($link));
		}
		
		if (!mysqli_select_db($link, $db))
		{
			die( "Error seleccionando la base de datos.". mysqli_error($link));
		}
		
		
		
		mysqli_query($link, "SET NAMES 'utf8'") or die("Error Cambiando charset").mysqli_error($link);
		
		
		mysqli_query($link, "SET CHARACTER SET utf8") or die("Error en charset UTF8".mysqli_error($link));
		
		
		
		return $link;
	}
?>