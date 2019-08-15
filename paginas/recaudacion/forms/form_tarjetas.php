<form class="was-validated " id="form_edicion" autocomplete="off">
	<!-- The Modal -->
	<div class="modal fade" id="modal_edicion">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-center"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					
					<input type="number" hidden id="tarjeta" name="tarjeta">
					<input type="number" hidden id="id_unidades" name="id_unidades">
					<input type="text" hidden id="estatus_tarjetas" name="estatus_tarjetas" value="Sin Recaudar">
					<input type="text" hidden id="condonacion" name="condonacion" value="0">
					<input type="text" hidden id="saldo_tarjetas" name="saldo_tarjetas" value="0">
					
					<div class="form-group">
						<label for="">No Eco:</label>
						<input type="text" class="form-control" id="num_eco" name="" required  placeholder="Escribe y presiona Enter">
					</div> 
					
					<div class="form-group">
						<label for="">Empresa:</label>
						<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", false, false, true);?>
					</div>
					<div class="form-group">
						<label for="">Derrotero:</label> 
						<?php echo generar_select($link, "derroteros", "id_derroteros", "nombre_derroteros", false, false,true);?>
					</div>
					<div class="form-group">
						<label for="">Conductor</label>
						<?php echo generar_select($link, "conductores", "id_conductores", "nombre_conductores", false, false,true);?>
					</div>
					<div class="form-group">
						<label for="">Rol:</label>
						<?php echo generar_select($link, "roles", "id_roles", "nombre_roles", false, false,true);?>
					</div>
					<div class="form-group">
						<label for="nombre_conductores">Fecha de la Cuenta: </label>
						<input type="date" class="form-control supervisor" id="fecha_tarjetas" name="fecha_tarjetas"  value="<?php echo date("Y-m-d")?>" required readonly>
						<div class="invalid-feedback" >Ya existe tarjeta en esa fecha</div>
					</div>
					<div class="form-group">
						<label for="nombre_conductores">Cuenta: </label>
						<input type="number" class="form-control" id="cuenta_derroteros" name="cuenta" readonly>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
					<button type="submit" id="btn_guardar_tarjeta" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
				</div>
				
			</div>
		</div>
	</div>
</form>
