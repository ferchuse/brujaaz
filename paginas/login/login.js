$(document).ready(function(){
	$("#form_login").submit(function(event){
		event.preventDefault();
		let boton = $(this).find(':submit');
		boton.prop("disabled", true);
		boton.text('Cargando...');
		$.ajax({
			url: "login.php", 
			method: "POST",
			dataType: 'JSON', 
			data: $("#form_login").serialize()
			}).done(function(response){
			
			if(response.estatus_usuarios == "Baja"){
				alert("Cuenta suspendida por falta de pago");
				return false;
			}
			
			if(response.login == "valid"){
				alertify.success("Acceso Correcto");
				
				if($("#retorno").val() == ''){
					location.href="../principal/index.php";
					
				}
				else{
					location.href="/paginas/recaudacion/estado_cuenta.php";
				}
				
				}else{ 
				alertify.error('Acceso Incorrecto');
				// $('#form_login')[0].reset();
			}
			}).always(function(){
			boton.text('Iniciar Sesión');
			boton.prop("disabled", false);
		});
	});
});