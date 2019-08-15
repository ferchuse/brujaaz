<?php 
	
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	// include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$consulta = "
	SELECT
	derroteros.cuenta_derroteros,
	unidades.id_empresas,
	unidades.id_derroteros ,
	unidades.id_derroteros AS id_roles,
	unidades.id_unidades,
	
	IF (
	ISNULL((
	SELECT
	fecha_tarjetas
	FROM
	tarjetas
	WHERE
	tarjetas.id_unidades = unidades.id_unidades
	AND estatus_tarjetas <> 'Cancelada' 
	ORDER BY
	fecha_tarjetas DESC
	LIMIT 1
	)) ,
	CURDATE(),
	DATE_ADD(
	fecha_tarjetas,
	INTERVAL 1 DAY
	)
	) AS fecha_tarjetas
	FROM
	unidades
	LEFT JOIN empresas USING (id_empresas)
	LEFT JOIN derroteros ON derroteros.id_derroteros = unidades.id_derroteros
	LEFT JOIN tarjetas USING (id_unidades)
	WHERE
	num_eco = '{$_GET['num_eco']}'
	
	";
  
	$respuesta["consulta"] = "$consulta";
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			$respuesta["num_rows"] = 0;
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			//console_log($fila);
			$filas = $fila ;
			
		}
		$respuesta["filas"] = $filas;
		
	}
	else {
		
		
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en ".$consulta.mysqli_Error($link);
	}
	
	echo json_encode($respuesta);
	
?>	