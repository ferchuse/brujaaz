 <nav class="navbar navbar-expand navbar-dark bg-dark static-top d-print-none">
	
	<a class="navbar-brand mr-1" href="index.html">BRUJAAZ</a>
	
	<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
		<i class="fas fa-bars"></i>
	</button>
	
	<!-- Navbar Search -->
	<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Buscar" aria-label="Search" aria-describedby="basic-addon2">
			<div class="input-group-append">
				<button class="btn btn-primary" type="button">
					<i class="fas fa-search"></i>
				</button>
			</div>
		</div>
	</form>
	
	<!-- Navbar -->
	<ul class="navbar-nav ml-auto ml-md-0">
		<li class="nav-item dropdown no-arrow mx-1">
			<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"  data-toggle="dropdown" >
				<i class="fas fa-bell fa-fw"></i>
				<span class="badge badge-danger">9+</span>
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
				<a class="dropdown-item" href="#">Notificación 1</a>
				<a class="dropdown-item" href="#">Notificación 2</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Notificación 3</a>
			</div>
		</li>
		
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" >
				<i class="fas fa-user-circle fa-fw"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right" >
				<input hidden value="<?php echo $_SESSION["id_usuarios"]?>" id="id_usuarios">
				<input hidden value="<?php echo $_SESSION["id_recaudaciones"]?>" id="sesion_id_recaudaciones">
				<a class="dropdown-item" href="#"><?php echo "Usuario: ". $_SESSION["nombre_usuarios"]?></a>
				<a class="dropdown-item" href="#">Configuración</a>
				<a class="dropdown-item" href="#">Historial</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Salir</a>
			</div>
		</li>
	</ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', ()=>{
    licenciasVencidas();
});

//=======OBTENENR LICENCIAS VENCIDAS=========
let licenciasVencidas = () => {
    let fechaHoy = fecha();
    let datos = {
        tabla: 'conductores',
        campo: 'fechaVigencia_conductores',
        id_campo: fechaHoy
    }
    let http = new XMLHttpRequest();
    http.open('POST','paginas/catalogos/control/listar.php',true);
    http.send(datos);
    if(http.readyState == 4){
        console.log('bien');
    }else{
        console.log('mal');
    }
}

//========CREAR NOTIFICACIONES========
let crearNotificaciones = (mensajes) =>{

}

//========GENERAR LA FECHA=========
let fecha = () =>{
    let today = new Date();
    let dd = today.getDate();

    let mm = today.getMonth()+1; 
    const yyyy = today.getFullYear();
    if(dd<10) 
    {
        dd=`0${dd}`;
    } 

    if(mm<10) 
    {
        mm=`0${mm}`;
    } 
    return today = `${yyyy}-${mm}-${dd}`;

}
</script>