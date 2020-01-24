<form class="was-validated " id="form_corridas" autocomplete="off">
	<!-- The Modal -->
	<div class="modal fade" id="modal_corridas">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-center"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body --> 
				<div class="modal-body">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">Num Eco:</label>
							<input type="number" class="form-control" name="num_eco" required autofocus="true">
							
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="fecha_abonogeneral">Taquilla:</label>
							<input class="form-control" name="taquilla" value="Indios Verdes" readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">Fecha:</label>
							<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" id="fecha_corridas" name="fecha_corridas" required readonly>
						</div>
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">Hora:</label>
							<input type="time" class="form-control" value="<?php echo date("H:i:s");?>" id="hora_corridas" name="hora_corridas" required readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">Origen:</label>
							<input class="form-control" name="origen" value="Indios Verdes" readonly>
						</div>
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">Destino:</label>
							<input class="form-control" name="destino" value="Sauces" readonly>
						</div>
					</div>			
				</div>
			
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
				</div>
				
			</div>
		</div>
	</div>
</form>												