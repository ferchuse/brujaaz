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
						<label for="id_unidades">Num Eco: </label>
						<?php echo generar_select($link, "unidades", "id_unidades", "num_eco", false, false, false); ?>
					</div>
					<div class="form-group">
						<label for="id_beneficiarios">BENEFICIARIO</label>
						<br>
						<?php echo generar_select($link, "beneficiarios", "id_beneficiarios", "nombre_beneficiarios",  false, false, true); ?>
					</div> 
					<div class="form-group">
						<label for="monto_reciboSalidas">MONTO</label>
						<input type="number" class="form-control" id="monto" name="monto" required step="any">
					</div> 
                    <div class="form-group">
						<label for="observaciones_reciboSalidas">OBSERVACIONES</label>
						<input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones">
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
				</div>
				
			</div>
		</div>
	</div>
</form>
