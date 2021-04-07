<?php 
	
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	// include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	$consulta = "
	SELECT
	id_unidades ,
	nombre_propietarios ,
	saldo_actual
	FROM
	unidades
	LEFT JOIN propietarios USING (id_propietarios)
	LEFT JOIN (SELECT
	id_unidades,
	num_eco,
	estatus_unidades,
	saldo_unidades AS saldo_inicial,
	cargo_admon,
	seguro,
	suma_traspasos,
	suma_abono_general,
	suma_abono_unidades,
	#########################SALDO
	saldo_unidades -
IF (
	ISNULL(cargo_admon),
	0,
	cargo_admon
) -
IF (ISNULL(seguro), 0, seguro) -
IF (
	ISNULL(suma_traspasos),
	0,
	suma_traspasos
) +
IF (
	ISNULL(suma_abono_general),
	0,
	suma_abono_general
) +
IF (
	ISNULL(suma_abono_unidades),
	0,
	suma_abono_unidades
) AS saldo_actual ####################################
FROM
	unidades 
LEFT JOIN derroteros USING (id_derroteros)
LEFT JOIN (
	SELECT
		id_unidades,
		SUM(cargo) AS cargo_admon
	FROM
		cargos_unidades
	WHERE
		tipo_cargo = 'gasto_administracion'
	AND fecha_cargos <= CURDATE()
	GROUP BY
		id_unidades
) AS t_gasto_admon USING (id_unidades)
LEFT JOIN (
	#Seguro
	SELECT
		id_unidades,
		SUM(cargo) AS seguro
	FROM
		cargos_unidades
	WHERE
		tipo_cargo = 'seguro'
	AND fecha_cargos <= CURDATE()
	GROUP BY
		id_unidades
) AS t_seguro USING (id_unidades)
LEFT JOIN propietarios USING (id_propietarios)
LEFT JOIN empresas USING (id_empresas)
LEFT JOIN (
	#Abonos Generales
	SELECT
		id_unidades,
		SUM(monto_abonogeneral) AS suma_abono_general
	FROM
		abono_general
	WHERE
		estatus_abono <> 'Cancelado'
	AND DATE(fecha_aplicacion) <= CURDATE()
	GROUP BY
		id_unidades
) t_abono_general USING (id_unidades)
LEFT JOIN (
	#Cargo Admon
	SELECT
		id_unidades,
		tarjeta,
		SUM(abono_unidad) AS suma_abono_unidades
	FROM
		abonos_unidades
	LEFT JOIN tarjetas USING (tarjeta)
	WHERE
		estatus_abonos <> 'Cancelado'
	AND DATE(fecha_abonos) <= CURDATE()
	GROUP BY
		id_unidades
) t_abonos_unidades USING (id_unidades)
LEFT JOIN (
	SELECT
		id_unidades,
		SUM(monto) AS suma_traspasos
	FROM
		traspaso_utilidad
	LEFT JOIN traspaso_utilidad_unidades USING (id_traspaso)
	WHERE
		estatus_traspaso <> 'Cancelado'
	AND DATE(fecha_aplicacion) <= CURDATE()
	GROUP BY
		id_unidades
) traspaso_utilidad USING (id_unidades)
WHERE
	estatus_unidades = 'Alta'
##AND unidades.id_administrador = 2
AND unidades.num_eco = '{$_GET['num_eco']}'
ORDER BY
	num_eco) as t_saldo USING (id_unidades)
	WHERE
	unidades.num_eco = '{$_GET['num_eco']}'
	AND unidades.id_administrador = '{$_COOKIE[id_administrador]}'
	LIMIT 1
	";
  
	
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
		
		$respuesta["consulta"] = "$consulta";
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en ".$consulta.mysqli_Error($link);
	}
	
	echo json_encode($respuesta);
	
?>	