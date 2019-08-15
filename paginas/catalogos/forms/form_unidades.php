<form id="form_edicion" autocomplete="off" class="was-validated">
	<div class="modal " id="modal_edicion">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edición de Unidad</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					
					<input class="d-none" name="id_unidades" id="id_unidades" value="">
					<input class="d-none" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo date("Y-m-d");?>">
					<div class="row mb-2">
						<div class="col-2">
							<label >Empresa:</label>
						</div>	 
						<div class="col-5">			
							<?php
								echo generar_select($link, "empresas", "id_empresas", "nombre_empresas");
							?>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label >No Eco:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="number" name="num_eco" id="num_eco" required>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label >Propietario:</label>
						</div>	
						<div class="col-5">			
							<?php
								echo generar_select($link, "propietarios", "id_propietarios", "nombre_propietarios");
							?>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label >Tipo Vehículo:</label>
						</div>	
						<div class="col-5">			
							<select class="form-control" id="tipo_unidad" name="tipo_unidad">
								<option value="">Seleccione</option>
								<option value="Autobús">Autobús</option>
								<option value="Camioneta">Camioneta</option>
								<option value="Sprinter">Sprinter</option>
							</select>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label >Estatus:</label>
						</div>	
						<div class="col-5">			
							<select class="form-control" id="estatus_unidades" name="estatus_unidades">
								<option value="">Seleccione</option>
								<option value="Alta">Alta</option>
								<option value="Baja">Baja</option>
								<option value="Inactivo">Inactivo</option>
							</select>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label >Derrotero:</label>
						</div>	
						<div class="col-5">			
							<?php
								echo generar_select($link, "derroteros", "id_derroteros", "nombre_derroteros");
							?>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Serie:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="serie" id="serie">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Modelo:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="modelo" id="modelo">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Poliza:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="poliza" id="poliza" required>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Aseguradora:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="aseguradora" id="aseguradora">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Vigencia:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="date" name="vigencia" id="vigencia">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Mutualidad:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="number" name="mutualidad" id="mutualidad">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Rin:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="rin" id="rin">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Tipo de Aceite:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="tipo_aceite" id="tipo_aceite">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="nombre_propietario">Asientos:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="text" name="asientos" id="asientos">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-2">
							<label for="saldo_unidades">Saldo Inicial:</label> 
						</div>	
						<div class="col-5">			
							<input class="form-control" type="number"  name="saldo_unidades" id="saldo_unidades" value="0">
						</div>
					</div>
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fas fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success " >
					<i class="fas fa-save"></i> Guardar </button>
				</div>
			</div>
		</div>
	</div>
</form>		
