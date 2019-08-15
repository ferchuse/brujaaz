<form class="was-validated " id="form_boleto" autocomplete="off">
	<!-- The Modal -->
	<div class="modal fade" id="modal_boleto">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-center"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					
				
				
					<div class="form-group">
						<label for="nombre_conductores">Adulto: </label>
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
