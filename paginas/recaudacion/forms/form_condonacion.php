
<!-- The Modal -->
<div class="modal fade" id="modal_edicion">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title text-center"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<form class="was-validated" id="form_edicion">
					<div class="row mb-2">
						<div class="col-4">
							<label>Tarjeta:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="number" name="tarjeta" id="tarjeta">
						</div>
						<div class="col-1">			
							<i class="fas fa-spinner fa-spin" hidden id="loader_tarjeta"></i>
						</div>
						<div class="col-1">			
							<button type="button" class="btn btn-info" id="btn_buscar_tarjeta">
								<i class="fas fa-search" ></i>
							</button>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-4">
							<label>Fecha:</label>
						</div>	
						<div class="col-6">			
						<input class="form-control" type="date" name="" id="fecha_tarjetas" readonly>
						</div>
					</div>
					<div class="row mb-2">
					<div class="col-4 ">
					<label>Num Eco</label>
					</div>	
					<div class="col-6">			
					<input class="form-control" type="text"  id="num_eco" readonly>
					</div>
					</div>
					<div class="row mb-2">
					<div class="col-4">
					<label>Conductor</label>
					</div>	
					<div class="col-8">			
					<?php echo generar_select($link, "conductores", "id_conductores", "nombre_conductores", false, true)?>
					</div>
					</div>
					<div class="row mb-2">
					<div class="col-4">
					<label>Motivo</label>
					</div>	
					<div class="col-6">			
					<?php echo generar_select($link, "motivos_condonacion", "id_motivo_condonacion", "motivo_condonacion", false, false, true)?>
					</div>
					</div>
					<div class="row mb-2"> 
					<div class="col-4">
					<label>Saldo Tarjeta:</label>
					</div>	
					<div class="col-6">			
					<input class="form-control" type="number" name="" id="cuenta" readonly>
					</div>
					</div>
					<div class="row mb-2">
					<div class="col-4">
					<label>Monto:</label>
					</div>	  
					<div class="col-6">			
					<input class="form-control" required type="number" name="monto_condonaciones" id="monto_condonaciones">
					</div>
					</div>
					<div class="row mb-2" hidden>
					<div class="col-4">
					<label>Saldo Unidad:</label>
					</div>	  
					<div class="col-6">			
					<input class="form-control" readonly  type="number" name="saldo_unidades" id="saldo_unidades">
					</div>
					</div>
					<div class="row mb-2">
					<div class="col-4">
					<label>Observaciones</label>
					</div>	
					<div class="col-6">			
					<textarea class="form-control" type="number" name="observaciones_condonaciones" id="observaciones_condonaciones"></textarea>
					</div>
					</div>
					</form>
					
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal">
					<i class="fa fa-times"></i> Cancelar
					</button>
					<button type="submit" id="btn_guardar" form="form_edicion" class="btn btn-outline-success">
					<i class="fa fa-save"></i> Guardar
					</button>
					</div>
					
					</div>
					</div>
					</div>
					
					
										