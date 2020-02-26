<?php
	header("Content-Type: application/json");
	$response= array();
	include("../../conexi.php");
	$link=Conectarse();
	$myusername=$_POST['nombre_usuarios'];
	$mypassword=$_POST['pass_usuarios']; 
	
	// To protect mysqli injection (more detail about mysqli injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	/* $myusername = mysqli_real_escape_string($myusername);
	$mypassword = mysqli_real_escape_string($mypassword); */
	$sql="SELECT 
	id_usuarios,
	nombre_usuarios,
	id_recaudaciones, 
	id_administrador, 
	'recaudacion' AS tipo_usuario ,
	silent_print
	FROM usuarios
	WHERE nombre_usuarios='$myusername' 
	AND pass_usuarios='$mypassword'
	
	UNION
	
	SELECT
	id_propietarios AS id_usuarios,
	nombre_propietarios AS nombre_usuarios,
	1 AS id_recaudaciones,
	id_administrador,
	'propietario' AS tipo_usuario ,
	'0' as silent_print
	FROM
	propietarios
	WHERE usuario_propietarios='$myusername' 
	AND password_propietarios='$mypassword'
	
	";
	$result=mysqli_query($link, $sql);
	if (!$result){
		die('Error: ' . mysqli_error($link));
	}
	$count=mysqli_num_rows($result);
	
	
	// Si la consulta devuelve 1 fila inicia la sesion
	if($count==1){
		session_start();
		session_regenerate_id(true);
		$id_sesion = session_id();
    $row = mysqli_fetch_assoc($result);
    
		$id_usuarios = $row["id_usuarios"];
		$nombre_usuarios= $row["nombre_usuarios"];
		$_SESSION["id_usuarios"] = $id_usuarios or die("Error al asignar id usuarios");
		$_SESSION["nombre_usuarios"] = $nombre_usuarios or die("Error al iniciar nombre usuarios");
		$_SESSION["id_recaudaciones"] = $row["id_recaudaciones"] or die("Error al iniciar recaudaciones");
		$_SESSION["id_administrador"] = $row["id_administrador"] or die("Error al iniciar administrador");
		$_SESSION["tipo_usuario"] = $row["tipo_usuario"];
		$response["login"] = "valid"; 
		
		
		setcookie("id_usuarios", $id_usuarios,  0, "/");
		setcookie("nombre_usuarios", $nombre_usuarios,  0, "/");
		setcookie("permiso_usuarios", $row["permiso_usuarios"],  0, "/");
		setcookie("id_recaudaciones",  $row["id_recaudaciones"],  0, "/");
		setcookie("id_administrador",  $row["id_administrador"],  0, "/");
		setcookie("tipo_usuario",  $row["tipo_usuario"],  0, "/");
		setcookie("silent_print",  $row["silent_print"],  0, "/");
		
	}
	else{
		$response["login"] = "invalid";
		$response["mensaje"] = "usuarios y/o Contraseña Inválidos";
	}
	$response["query"] = $sql;
	echo json_encode($response);
?>