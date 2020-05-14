<?php 
	session_start();
	if(count($_COOKIE) == 0){
		die("<div class='alert alert-danger'>Tu Sesión ha caducado, recarga la página.</div>");
	}
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	$tarjeta = $_GET['tarjeta'];
	
	
	
	
	$consulta = "SELECT
	*
	FROM
	tarjetas
	LEFT JOIN derroteros USING (id_derroteros)
	LEFT JOIN empresas USING (id_empresas)
	LEFT JOIN conductores USING (id_conductores)
	LEFT JOIN unidades USING (id_unidades)
	LEFT JOIN (
	SELECT
	id_unidades,
	SUM(cantidad_boletos) AS cantidad_boletos,
	SUM(total_boletaje) AS total_boletaje
	FROM
	boletaje
	WHERE
	estatus_boletaje = 'Activo'
	) AS boletaje_activo USING (id_unidades)
	WHERE tarjeta= '$tarjeta'
	AND tarjetas.id_administrador = '{$_COOKIE["id_administrador"]}'";
  
	 
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			//TODO
			///Tarjeta Cancelada
			///Tarjeta Ya recaudada
			
		}
		
		if($filas["estatus_tarjetas"] == 'Recaudada'){
			
			die("<div class='alert alert-danger col-6'>Tarjeta Ya recaudada</div>");
			
		}
		
	?>
	
	<div class="row mb-2">
		<div class="col-2">
			<label >Fecha:</label>
		</div>	 
		<div class="col-5">			
			<input class="form-control" readonly type="date" id="fecha_tarjetas" value="<?php echo $filas["fecha_tarjetas"];?>">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-2">
			<label >Empresa:</label> 
		</div>	 
		<div class="col-5">			
			<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", false, true, false, $filas["id_empresas"])?>
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col-2">
			<label >No.Eco:</label>
		</div>	 
		<div class="col-5">			
			<input class="form-control" type="text"  readonly value="<?php echo $filas["num_eco"]?>">
			<input hidden type="text"  id="id_unidades" value="<?php echo $filas["id_unidades"]?>">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-2">
			<label >Conductor:</label>
		</div>	 
		<div class="col-5">			
			<?php echo generar_select($link, "conductores", "id_conductores", "nombre_conductores" ,false, true, false, $filas["id_conductores"])?>
		</div>
	</div>
	<div class="row mb-2" hidden>
		<div class="col-2">
			<label >Saldo Unidad:</label>
		</div>	 
		<div class="col-5">			
			<input class="form-control" type="number" readonly name="saldo_anterior" id="saldo_anterior" value="<?php echo $filas["saldo_unidades"];?>">
		</div>
	</div>
	<?php 
		if($filas["mutualidad_cobrada"] == 0){?>
		<div class="row mb-2">
			<div class="col-2">
				<label >Mutualidad:</label>
			</div>	 
			<div class="col-3">			
				<input class="form-control" type="number"  id="monto_mutualidad" value="<?php echo  $filas["mutualidad"]?>">
			</div> 
			<div class="col-2">			
				<button type="button" id="generar_mutualidad" class="btn  btn-primary">
					<i class="fas fa-arrow-right"></i> Generar 
					<i class="fas fa-spinner fa-spin" hidden id="loader_mutualidad"></i>
				</button>		
				<button type="button"  id="imprimir_mutualidad" hidden class="btn btn-info 	">
					<i class="fas fa-print"  ></i> Imprimir 
				</button>
			</div>
		</div>
		<?
		}
	?>
	<div class="row mb-2">
		<div class="col-2">
			<label >Derrotero:</label>
		</div>	 
		<div class="col-5">			
			<?php echo generar_select($link, "derroteros", "id_derroteros", "nombre_derroteros" ,false, true, false, $filas["id_derroteros"])	?>
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-2">
			<label >Cuenta:</label>
		</div>	 
		<div class="col-2">			
			<input class="form-control" readonly type="number"  value="<?php echo $filas["cuenta_derroteros"]?>"> 
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col-2">
			<label >Condonacion:</label>
		</div>	  
		<div class="col-2">			
			<input class="form-control" readonly type="number"  id="condonacion_abonar" value="<?php echo $filas["condonacion"]?>">
		</div>
		
	</div>
	<div class="row mb-2">
		<div class="col-2"> 
			<label >Total:</label>
		</div>	 
		<div class="col-2">			
			<input class="form-control" readonly type="number"  id="saldo_tarjetas" value="<?php echo $filas["cuenta_derroteros"] - $filas["condonacion"]?>">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-2">
			<label >Boletos Térmicos:</label>
		</div>	
		<div class="col-10">
			<div class="row">
				<div class="col-2">
					<label >Folio:</label>
				</div>
				<div class="col-2 ">
					<label >Cantidad:</label>
				</div>
				<div class="col-2 ">
					<label >Importe:</label>
				</div>
			</div>
			
			<?php 
				$q_guias = "SELECT * FROM boletaje WHERE id_unidades = {$filas['id_unidades']} AND estatus_boletaje = 'Activo'";
				
				$result_guias = mysqli_query($link, $q_guias);
				
				if($result_guias){
					
					while($guia = mysqli_fetch_assoc($result_guias)){
						$total_boletos+= $guia["cantidad_boletos"];
						$total_importe+= $guia["total_boletaje"];
					?>
					
					<div class="row mb-1 ">
						<div class="col-2 ">
							<input class="form-control" type="number" readonly value="<?php echo $guia["id_boletaje"]?>">
						</div>
						<div class="col-2 ">
							<input class="form-control" type="number"  readonly value="<?php echo $guia["cantidad_boletos"]?>">
						</div>
						<div class="col-2">
							<div class="input-group">
								<div class="input-group-prepend" >
									<span class="input-group-text">$</span>
								</div>
								<input class="form-control" type="text" readonly value="<?php echo $guia["total_boletaje"]?>">
							</div>
						</div>
					</div>
					<?php	
					}
				?>
				
				<div class="row mb-1 ">
					<div class="col-2 ">
						<b> Totales: </b> 
					</div>
					<div class="col-2 ">
						<input class="form-control" type="number" name="bol_termicos_cantidad"  readonly value="<?php echo $total_boletos?>">
					</div>
					<div class="col-2">
						<div class="input-group">
							<div class="input-group-prepend" >
								<span class="input-group-text">$</span>
							</div>
							<input class="form-control" type="text" name="bol_termicos_importe" id="bol_termicos_importe" readonly value="<?php echo $total_importe?>">
						</div>
					</div>
				</div>
				<?php
				}
				
			?>
			
		</div>
	</div>
	
	<?php
		
	}
	else {
		 
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en ".$consulta.mysqli_Error($link);
		
		echo json_encode($respuesta);
	}
	
	
?>						