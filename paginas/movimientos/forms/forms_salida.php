<form class="was-validated " id="form_salida">
	<!-- The Modal -->
	<div class="modal fade" id="modal_salida">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title text-center"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<input type="text" hidden class="form-control" id="id_reciboSalidas" name="id_reciboSalidas">
					<div class="form-group">
						<label for="id_empresas">EMPRESA</label>
						<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", false, false, true, $_COOKIE["id_empresas"]); ?>
					</div>
					<div class="form-group">
						<label for="id_beneficiarios">BENEFICIARIO</label>
						<?php echo generar_select($link, "beneficiarios", "id_beneficiarios", "nombre_beneficiarios"); ?>
					</div> 
					<div class="form-group">
						<label for="id_motivosSalida">MOTIVO DE LA SALIDA</label>
						<?php echo generar_select($link, "motivos_salida", "id_motivosSalida", "nombre_motivosSalida"); ?>
					</div>
					<div class="form-group">
						<label for="saldo_reciboSalidas">SALDO</label>
						<input type="number" readonly class="form-control" id="saldo_reciboSalidas" name="saldo_reciboSalidas" required>
					</div> 
					<div class="form-group">
						<label for="monto_reciboSalidas">MONTO</label>
						<input type="number" class="form-control" id="monto_reciboSalidas" name="monto_reciboSalidas" required>
					</div> 
                    <div class="form-group">
						<label for="observaciones_reciboSalidas">OBSERVACIONES</label>
						<input type="text" class="form-control" id="observaciones_reciboSalidas" name="observaciones_reciboSalidas" placeholder="Observaciones">
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
