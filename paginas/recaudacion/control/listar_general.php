<?php 
    include('../../../conexi.php');
    $link = Conectarse();
    $lista = array();
    $respuesta = array();
    $tabla = $_POST['tabla'];
    
    
    
    if(isset($_POST['id_campo'])){
        $subconsulta = $_POST['subconsulta'];
        $campo = $_POST['campo'];
        $id_campo = $_POST['id_campo'];
        $consulta = "SELECT * FROM $tabla $subconsulta WHERE $campo=$id_campo";
    }elseif(isset($_POST['fecha_inicio'])){
        $subconsulta = $_POST['subconsulta'];
        $campo = $_POST['campo'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
        $consulta = "SELECT * FROM $tabla $subconsulta WHERE DATE($campo) BETWEEN '$fecha_inicio' AND '$fecha_final'";
    }elseif(isset($_POST['fecha'])){
        $subconsulta = $_POST['subconsulta'];
        $campo = $_POST['campo'];
        $fecha = $_POST['fecha'];
        $consulta = "SELECT * FROM $tabla $subconsulta WHERE $campo='$fecha'";
    }

    $query = mysqli_query($link,$consulta);
    if($query){
        $respuesta['num_rows'] = mysqli_num_rows($query);
            while($row = mysqli_fetch_assoc($query)){
                $lista[] = $row;
            }
            $respuesta['estatus'] = 'success';
            $respuesta['mensaje'] = $lista;
            $respuesta['query'] = $consulta;
    }else {
        $respuesta["estatus"] = "error";
        $respuesta["mensaje"] = "Error en ".$consulta.mysqli_error($link);
    }

    echo json_encode($respuesta);
?>