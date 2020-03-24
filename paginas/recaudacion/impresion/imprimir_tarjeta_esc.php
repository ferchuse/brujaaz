<?php 
	include('../../../conexi.php');
	
	$link = Conectarse();
	$filas = array();
	
	
	
	$consulta = "SELECT * FROM tarjetas 
	
	LEFT JOIN derroteros USING(id_derroteros)
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN conductores  USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN roles USING(id_roles)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE tarjeta= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Abono {$_GET['id_registro']} No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		
		
		$print = "@";
		$print.= "TARJETA"."\n";
		$print.= "FOLIO: ".$filas["tarjeta"]."\n";
		$print.= "FECHA CUENTA: ".$filas["fecha_tarjetas"]."\n";
		$print.= "USUARIO: ".$filas["nombre_usuarios"]."\n";
		$print.= "EMPRESA: ".$filas["nombre_empresas"]."\n";
		$print.= "NUM ECO: ".$filas["num_eco"]."\n";
		$print.= "CONDUCTOR: ".$filas["nombre_conductores"]."\n";
		$print.= "DERROTERO: ".$filas["nombre_derroteros"]."\n";
		$print.= "ROL: ".$filas["nombre_roles"]."\n\n";
		$print.= "  ORIGEN ".chr(9). "DESTINO \n";
		
		
		
		
		
		
		$q_roles = "SELECT
		*
		FROM
		roles_destinos
		LEFT JOIN origenes ON roles_destinos.origen = origenes.id_origenes
		LEFT JOIN (
		SELECT
		id_origenes AS id_destinos,
		nombre_origenes AS nombre_destinos
		FROM
		origenes
		) AS destinos ON roles_destinos.destino = destinos.id_destinos
		WHERE
		id_roles = {$filas['id_roles']}
		ORDER BY id_vueltas";
		
		$result_roles = mysqli_query($link, $q_roles);
		
		while($fila_roles= mysqli_fetch_assoc($result_roles)){
			
			if($_COOKIE["id_administrador"] == '1'){
				
				$print.= "___________".CHR(9);
			}
			else{
				$print.= $fila_roles["nombre_origenes"].CHR(9);
				
			}	
			if($_COOKIE["id_administrador"] == '1'){
				$print.= "___________ \n";
			}
			else{
				$print.= $fila_roles["nombre_destinos"]."\n";
			}
			
			
		}
		
		
		
		$print.=chr(10).chr(10).chr(13).chr(29).chr(86).chr(66).chr(0);
		
		// echo ($print);
		echo base64_encode($print);
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>					