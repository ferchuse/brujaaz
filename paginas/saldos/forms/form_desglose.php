<form class="was-validated " id="form_modal">
	<!-- The Modal -->
	<div class="modal fade" id="modal_modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-center"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<input type="text" hidden class="form-control" id="id_desglose" name="id_desglose">
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="fecha_abonogeneral">FECHA</label>
							<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" id="fecha_desglose" name="fecha_desglose" required>
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="">Taquilla</label>
						</div>
						<div class="form-group col-md-6">
							<button type="button" class="btn btn-outline-success" id="btn_taquilla">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
					<div id="todo">
						
						<div id="imp_cadena" style="display:none;"></div>
						
						<!-- FIN SUBTOTAL DE TAQUILLA  -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="">Subtotal</label>
							</div>
							<div class="form-group col-md-6">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
									</div>
									<input type="number" min="0" class="form-control" id="importe_total" val="" readOnly>
								</div>
							</div>
						</div>
						<!-- SUBTOTAL DE TAQUILLA  -->
						<!-- DOCUMENTO DE DOLETOS -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="">Documento Boletos</label>
							</div>
							<div class="form-group col-md-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
									</div>
									<input type="number" min="0" class="form-control" id="total_boletos" val="" readOnly>
								</div>
							</div>
							<div class="form-group col-md-2">
								<button type="button" class="btn btn-outline-success" id="btn_boletos">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
						
						<div class="form-row" id="datos_boleto" style="display:none;">
							<div class="form-group col-md-4">
								<label for="">Cantidad</label>
								<input type="number" min="0" class="form-control" id="cantidad" val="">
							</div>
							<div class="form-group col-md-4">
								<label for="">Denominación</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
									</div>
									<input type="number" min="0" class="form-control" id="denominacion" val="">
								</div>
							</div>
							<div class="form-group col-md-4">
								<label for="">Importe</label>
								<input type="number" min="0" class="form-control" id="total_importe" val="0" readOnly>
							</div>
						</div>
						<!-- FIN DOCUMENTO DE DOLETOS -->
						<!-- DOCUMENTO DE CHEQUES -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="">Documento Cheques</label>
							</div>
							<div class="form-group col-md-6">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
									</div>
									<input type="number" min="0" id="documento_cheque" class="form-control" val="">
								</div>
							</div>
						</div>
						<!-- FIN DOCUMENTO DE CHEQUES -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="">Total</label>
							</div>
							<div class="form-group col-md-6">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
									</div>
									<input type="number" min="0" class="form-control" id="importe_desglose" name="importe_desglose" val="" readOnly>
								</div>
							</div>
						</div>
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