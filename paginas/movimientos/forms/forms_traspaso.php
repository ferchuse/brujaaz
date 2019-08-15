<form class="was-validated " id="form_edicion" autocomplete="off">
	<!-- The Modal -->
	<div class="modal fade" id="modal_edicion">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title text-center"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					<input type="text" hidden id="id_traspaso_utilidad" name="id_traspaso_utilidad">
					
					<div class="row form-group">
						<div class=" col-4">
							<label for="">Fecha Aplicación</label>
						</div>	
						<div class="col-4">
							<input type="date" class="form-control" id="fecha_aplicacion" name="fecha_aplicacion" required value="<?php echo date("Y-m-d");?>">
						</div> 
					</div>
					<div class="row form-group" hidden>
						<div class="col-4">
							<label for="">Tipo de Saldo:</label>
						</div>
						<div class=" col-4">
							<label><input type="radio"  id="saldo_corriente" name="tipo_saldo" checked > Corriente</label>
							<label><input type="radio"  id="saldo_periodo" name="tipo_saldo" > Por Periodo</label>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-4">
							<label for="">Referencia Bancaria</label>
						</div>
						<div class="col-4">
							<input type="text" class="form-control" id="referencia_bancaria" name="referencia_bancaria" >
						</div>
					</div>
					<div class="form-group row" hidden>
						<div class=" col-4">
							<label for="">Saldo a la Fecha:</label>
						</div>
						<div class=" col-4">
							<input type="date" class="form-control" id="fecha_saldo" name="fecha_saldo" value="<?php echo date("Y-m-d");?>">
						</div>
					</div>
					
					<Legend>Unidades 
						<button class="btn btn-success" type="button" id="btn_agregar"><i class="fas fa-plus"></i></button>
					</Legend>
					<div class="form-row" >
						<div class="col-2">
							<b for="">Num Eco:</b>
						</div>
						<div class="col-4">
							<b for="">Propietario:</b>
						</div>
						<div class="col-2"> 
							<b for="">Saldo:</b>
						</div>
						<div class="col-2">
							<b for="">Monto:</b>
						</div>
						<div class="col-2">
							<b for="">Saldo Restante:</b> 
						</div>
					</div>	
					<div id="unidades">
						<div class="form-row">
							<div class="form-group col-2">
								<input type="text" hidden class="form-control id_unidades" name="id_unidades[]"  >
								<input type="text" class="form-control num_eco" name="num_eco[]" required >
							</div>
							<div class="form-group col-4">
								<input type="text" class="form-control nombre_propietarios" name="propietario[]" readonly >
							</div>
							<div class="form-group col-2">
								<input type="text" class="form-control saldo_actual" name="saldo_anterior[]" readonly>
							</div>
							<div class="form-group col-2">
								<input type="number" class="form-control monto" name="monto[]" required >
							</div>
							<div class="form-group col-2">
								<input type="number" class="form-control saldo_restante" name="saldo_restante[]" readonly>
							</div>
						</div>	
					</div>	
					
					<div class="form-group row">
						<div class=" col-4">
							<label for="">Monto Total:</label>
							
						</div>
						<div class="col-4">
							<input type="number" class="form-control " id="monto_traspaso" name="monto_traspaso" readonly value="0" >
						</div>
					</div>
					<div class="row form-group" >
						<div class="col-4">
							<label for="">Tipo de Beneficiario:</label>
						</div>
						<div class=" col-4">
							<label><input type="radio" checked  name="tipo_benef" value="Externo"> Externo</label>
							<label><input type="radio"  name="tipo_benef" value="Unidades"> Unidades</label>
						</div>
					</div>
					
					<div class="form-group col-6" id="externo">
						<label for="">BENEFICIARIO</label> 
						<?php echo generar_select($link, "beneficiarios", "nombre_beneficiarios", "nombre_beneficiarios", false, false, false, 0, 0, 'beneficiario'); ?>
					</div> 
					
					<div class="form-group col-6" id="propietarios" hidden>
						<label for="">BENEFICIARIO</label>
						<?php echo generar_select($link, "propietarios", "nombre_propietarios", "nombre_propietarios" , false, false, false, 0, 0, 'beneficiario'); ?>
					</div> 
					
					<div class="form-group">
						<label for="concepto_traspaso">Concepto</label>
						<input type="text" class="form-control" id="concepto_traspaso" name="concepto_traspaso" >
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
