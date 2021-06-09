<form id="form_abono" autocomplete="off" class="was-validated">
	<input hidden type="date" name="id_abonos_unidades" id="id_abonos_unidades" value="">
	<input hidden type="date" name="fecha_abonos" id="fecha_abonos" value="<?php echo date("Y-m-d")?>">
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Recaudación:</label>
		</div>	 
		<div class="col-sm-4">			
			<?php
				echo generar_select($link, "recaudaciones", "id_recaudaciones", "nombre_recaudaciones", false, true, false, $_COOKIE["id_recaudaciones"]);
				// echo "recaudacion usuario". $_COOKIE["id_recaudaciones"];
			?>
			
		</div>
	</div>
	
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Tarjeta:</label> 
		</div>	 
		<div class="col-sm-3">			
			<div class="input-group mb-3">
				<input class="form-control input-sm" required type="number" name="tarjeta" id="tarjeta" placeholder="Buscar Tarjeta" autofocus>
			
				<div class="input-group-append">
					<button class="btn btn-primary" type="button" id="btn_buscar"> 	<i class="fas fa-search"></i></button>
				</div>
			</div>
			
		</div>	 
		<div class="col-sm-1" id="loader_tarjeta" hidden>			
			<i class="fas fa-spinner fa-spin"></i>
		</div> 
		<div class="col-sm-2" >			
			<button class="btn btn-info" id="imprimir_tarjeta"  data-url="../impresion/imprimir_tarjeta.php">
				<i class="fas fa-print"></i> Imprimir
			</button>
		</div>
		
	</div>
	<div id="respuesta_tarjeta">
	
	</div>
		
	<div class="row mb-2 border ">
		<div class="col-sm-2">
			<label >Boletos Tijera:</label>
		</div>	
		<div class="col-sm-2">
		<label>Cantidad:</label>
			<input class="form-control" type="number" name="cantidad_tijera" id="cantidad_tijera">
		</div>	
		<div class="col-sm-2">
			<label>Importe:</label>
			<input class="form-control" type="number" name="importe_tijera" id="importe_tijera">
		</div>
	</div>
	
	<div class="row mb-2 border ">
		<div class="col-sm-2">
			<label >Total Boletos:</label>
		</div>	
		<div class="col-sm-2">
			<input class="form-control" type="number"  readonly name="total_boletos" id="total_boletos">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Efectivo:</label>
		</div>	
		<div class="col-sm-2">
			<input class="form-control" type="number" name="efectivo" id="efectivo">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Total Recaudado:</label>
		</div>	
		<div class="col-sm-2">
			<input class="form-control" min="0" required type="number" name="total_recaudado"  readonly id="total_recaudado">
		</div>
	</div> 
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Abono Unidad:</label>
		</div>	
		<div class="col-sm-2">
			<input class="form-control" min="0" required type="number" name="abono_unidad"  readonly id="abono_unidad">
		</div>
	</div>
	<div class="row mb-2">
		<div class="col-sm-2">
			<label >Devolución:</label>
		</div>	
		<div class="col-sm-2">
			<input class="form-control" min="0" required type="number" name="devolucion"  readonly id="devolucion">
		</div>
	</div> 
	
	
	<hr>
	<div class="row mb-2">
		<div class="col-sm-12">
			<button class="btn btn-success" disabled  id="boton_guardar_abono" type="submit">  
				<i class="fas fa-save"></i> Guardar
			</button>
			<button type="button"  id="imprimir_abonos" hidden class="btn btn-info 	">
				<i class="fas fa-print"  ></i> Imprimir 
			</button>
		</div>
	</div>
</form>	 
