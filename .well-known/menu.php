<ul class="sidebar navbar-nav d-print-none">
	<li class="nav-item active">
		<a class="nav-link" href="../../index.php">
			<i class="fas fa-fw fa-home"></i>
			<span>Inicio</span>
		</a>
	</li>
	<li class="nav-item dropdown ">
		<a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" >
			<i class="fas fa-fw fa-folder"></i>
			<span>Catálogos</span>
		</a>
		<div class="dropdown-menu " >
			<a class="dropdown-item" href="../../paginas/catalogos/beneficiarios.php">
				Beneficiarios
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/conductores.php">
				Conductores
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/derroteros.php">
				Derroteros
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/empresas.php">
				Empresas
			</a>
			<a class="dropdown-item" hidden href="../../paginas/catalogos/lugares_pago.php">
				Lugares de Pago
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/motivos_condonacion.php">
				Motivos de Condonación
			</a>
			<a class="dropdown-item " href="../../paginas/catalogos/motivos_salida.php">
				Motivos de Salida
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/motivos_abonos_unidades.php">
				Motivos de Abono General de Unidades 
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/origenes.php">
				Origenes Y Destinos
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/propietarios.php">
				Propietarios
			</a>
			<a class="dropdown-item" href="../../paginas/catalogos/recaudaciones.php">
				Recaudaciones
			</a>
			
			<a class="dropdown-item" href="../../paginas/catalogos/roles.php">
				Roles
			</a>
			
			<a class="dropdown-item" href="../../paginas/catalogos/unidades.php">
				Unidades
			</a>
			
		</div>
	</li>  
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" >
			<i class="fas fa-exchange-alt"></i>
			<span>Movimientos</span>
		</a>
		<div class="dropdown-menu" >
			<a class="dropdown-item" href="#">Recibos de Entrada</a>
			<a class="dropdown-item" href="../../paginas/movimientos/recibos_salida.php">Recibos de Salida </a>
			<a class="dropdown-item" href="#">Traspaso de Utilidad</a>
			<a class="dropdown-item" href="#">Orden de Trabajo</a>
		</div> 
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" >
			<i class="fas fw fa-dollar-sign"></i>
			<span>Recaudación</span>
		</a>
		<div class="dropdown-menu" >
			<a class="dropdown-item" href="../../paginas/recaudacion/abonos_unidades.php">Abonar Unidades</a>
			<a class="dropdown-item" href="../../paginas/recaudacion/abono_general.php">Abono General de Unidades</a>
			<a class="dropdown-item" href="../../paginas/recaudacion/tarjetas.php">Tarjetas de Unidades</a>
			<a class="dropdown-item" href="">Devolución</a>
			<a class="dropdown-item" href="404.html">Desglose de Dinero</a>
			<a class="dropdown-item" href="../../paginas/recaudacion/condonacion_tarjeta.php">Condonación de Tarjeta</a> 
			<a class="dropdown-item" href="../../paginas/recaudacion/mutualidad.php">Mutualidad</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" >
			<i class="fas fw fa-cogs"></i>
			<span>Administración</span>
		</a>
		<div class="dropdown-menu" >
			<a class="dropdown-item" href="../../paginas/administracion/usuarios.php">Accesos</a>
			
		</div>
	</li>
	
	<li class="nav-item d-none">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-fw fa-ticket-alt"></i>
		<span>Taquilla</span></a>
	</li>
	
</ul>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span >×</span>
				</button>
			</div>
			<div class="modal-body">¿Estás seguro que deseas cerrar sesión?</div>
			<div class="modal-footer">
				<button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
				<a class="btn btn-primary" href="../../paginas/login/form_login.php">Salir</a>  
			</div>
		</div>
	</div>
</div>