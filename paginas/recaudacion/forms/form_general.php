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
					<input type="text" hidden class="form-control" id="id_abonogeneral" name="id_abonogeneral">
					<input type="text" hidden class="form-control" id="id_u" val="" name="id_usuarios">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="fecha_aplicacion">FECHA APLICACIÓN</label>
							<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" id="fecha_aplicacion" name="fecha_aplicacion" required>
						</div>
						<div class="form-group col-md-6">
							<label for="">NUM.ECO</label>
							<input type="number" NAME="abono_num_eco" required class="form-control" id="id_eco" min="0" placeholder="Buscar Num.Eco">
						</div>
					</div> 
					<div class="form-row" id="result_unidad">
						<div class="form-group col-md-6">
							<label for="">EMPRESA</label>
						</div> 
						<div class="form-group col-md-6">
							<label for="">Saldo Actual</label> 
						</div>
					</div> 
					<div class="form-row">
						
						<div class="form-group col-md-12">
							<label for="id_motivosAbono">MOTIVO</label>
							<?php echo generar_select($link, "motivosAbonoUnidades", "id_motivosAbono", "nombre_motivosAbono",false,false,true);?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="">DEPOSITANTE</label>
							<input class="form-control" id="depositante" name="depositante" required>
						</div>
						
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="monto_abonogeneral">MONTO</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
								</div>
								<input type="number" required class="form-control" id="monto_abonogeneral" name="monto_abonogeneral" min="0">
							</div>
						</div>
						<div class="form-group col-6">
							<label for="monto_abonogeneral">SALDO</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
								</div>
								<input type="number" required class="form-control" id="saldo_restante" name="saldo_restante" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="concepto_abonogeneral">CONCEPTO</label>
						<textarea name="concepto_abonogeneral" required id="concepto_abonogeneral" class="form-control" style="resize: none;" cols="30" rows="10"></textarea>
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