<script>
	
	$(document).ready(onReady)
	
	
	function onReady(){
		console.log("onReady")
		esUsuarioCobranza();
		
	}
	
	function esUsuarioCobranza(){
		console.log("esUsuarioCobranza")
		
		$.ajax({
			"url": "../../cobranza_usuario.php",
			dataType: "json"
			}).done(function(respuesta){		
			
			console.log(respuesta.id_clientes)
			if(respuesta.id_clientes != null){
				
				consultaSaldo(respuesta.id_clientes);
			}
			
			
		});
	}
	
	
	function consultaSaldo(id_clientes){
		$.ajax({
			"url": "https://www.glifo.mx/app/contratos/consultas/consultar_saldo.php",
			dataType: "json",
			crossDomain: true,
			"data": {
				"id_clientes" : id_clientes
			}
			
			}).done(function(respuesta){
			
			if(respuesta.lista_cargos){
				
				$("#modal_cobranza").modal("show");
				
				$template = '';
				
				$.each(respuesta.lista_cargos, function(i, item){
					
					$template += `<tr>
					<td>
					${item.concepto}
				</td>
				<td>
					$ ${item.importe}
				</td>
				<td>
					<a target="_blank" href="${item.link_pago}" class="btn btn-primary"> Pagar</a>
					
				</td>
				
				
			</tr>`
			});
			console.log($template)
			
			$("#modal_cobranza").find("tbody").html($template);
			
			}
			
			
			}).fail();
			
			}
			
			
			
			
			
			
		</script>
		
		<!-- The Modal -->
		<div class="modal fade" id="modal_cobranza">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					
					<!-- Modal Header -->
					<div class="modal-header">
						<h5 class="modal-title text-center">Pagos Pendientes</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					
					<!-- Modal body -->
					<div class="modal-body">
						
						<div class="alert alert-warning">
							Estimado Cliente, usted cuenta con cargos pendientes, para asegurar la continuidad del servicio  favor de realizar su pago correspondiente
						</div>
						
						<div class="alert alert-warning">
							Los pagos en OXXO se ven reflejados en 24 horas
						</div>
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Concepto</th>
									<th>Importe</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						
						<button  data-dismiss="modal" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Enterado</button>
					</div>
					
				</div>
			</div>
		</div>
		