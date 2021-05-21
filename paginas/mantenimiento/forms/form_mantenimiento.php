<form class="was-validated " id="form_mantenimiento">
	<!-- The Modal -->
	<div class="modal fade" id="modal_mantenimiento">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title text-center"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label for="fecha_proxima">Fecha Mantenimiento</label>
						<input type="date" class="form-control" id="fecha" name="fecha" required value="<?= date("Y-m-d")?>">
					</div> 
					<div class="form-group">
						<label for="id_unidades">Num Eco: </label>
						<?php echo generar_select($link, "unidades", "id_unidades", "num_eco", false, false, true); ?>
					</div>
					<div class="form-group">
						<label for="id_tipo_mantenimiento">Tipo Mantenimiento: </label>
						<?php echo generar_select($link, "cat_tipo_mantenimiento", "id_tipo_mantenimiento", "tipo_mantenimiento",  false, false, true); ?>
					</div> 
					<div class="form-group">
						<label for="fecha_proxima">Proximo Servicio</label>
						<input type="date" class="form-control" id="fecha_proximo" name="fecha_proximo" required >
					</div> 
					<div class="form-group">
						<label for="fecha_proxima">Kilometraje</label>
						<input type="number" class="form-control" id="kilometraje" name="kilometraje" required >
					</div> 
					<div class="form-group">
						<label for="fecha_proxima">Observaciones</label>
						<textarea type="number" class="form-control" id="observaciones" name="observaciones" required ></textarea>
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
