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
					<input type="text" hidden class="form-control" id="id_conductores" name="id_conductores">
					<div class="form-group">
						<label for="nombre_conductores">NOMBRE CONDUCTOR</label>
						<input type="text" class="form-control" id="nombre_conductores" name="nombre_conductores" placeholder="Nombre del conductor" required>
					</div>
					<div class="form-group">
						<label for="rfc_conductores">RFC</label>
						<input type="text" class="form-control" id="rfc_conductores" name="rfc_conductores" placeholder="RFC del conductor">
					</div> 
					<div class="form-group">
						<label for="noLicencia_conductores">TIPO LICENCIA</label>
						<input type="text" class="form-control" id="tipo_licencia" name="tipo_licencia" >
					</div>
					<div class="form-group">
						<label for="noLicencia_conductores">LICENCIA</label>
						<input type="text" class="form-control" id="noLicencia_conductores" name="noLicencia_conductores" placeholder="Licencia">
					</div>
					<div class="form-group">
						<label for="fechaVigencia_conductores">FECHA DE VIGENCIA</label>
						<input type="date" class="form-control" id="fechaVigencia_conductores" name="fechaVigencia_conductores">
					</div> 
					<div class="form-group">
						<label for="id_empresas">EMPRESA</label>
						<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas"); ?>
					</div> 
					<div class="form-group">
						<label for="curp_conductores">CURP</label>
						<input type="text" class="form-control" id="curp_conductores" name="curp_conductores" placeholder="CURP del conductor">
					</div> 
					<div class="form-group">
						<label for="acta_conductores">ACTA DE NACIMIENTO</label>
						<input type="text" class="form-control" id="acta_conductores" name="acta_conductores" placeholder="acta de nacimiento">
					</div> 
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-outline-success"><i class="fa fa-save"></i> Guardar</button>
				</div>
				
			</div>
		</div>
	</div>
</form>
