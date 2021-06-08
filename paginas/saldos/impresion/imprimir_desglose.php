<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$denominaciones = ["1000", "500", "200", "100", "50", "20", "10", "5", "2", "1", "0.5"];
	$consulta = "SELECT * FROM desglose_dinero 
	
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_desglose= '{$_GET['id_registro']}'";
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		if($_COOKIE["silent_print"] == "SI"){
			
			/*
				Hex       $1D $4C nL nH
				
				ASCII     GL  L   nL nH
				
				Decimal   27  76  nL nH
				
			*/
			// $total = $filas["cuenta"] - $filas["monto_condonaciones"];
			
			
			$print.= "@";
			$print.= "!".chr(16)."Desglose de Dinero"."!".chr(0)."\n";
			$print.= "Folio: ".$filas["id_desglose"]."\n";
			$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
			$print.= "Fecha: ".$filas["fecha_desglose"]."\n";
			
			$print.="Denom    Cantidad       Importe \n";
			
			
			
			foreach($denominaciones as $i => $denominacion){
				$print.= str_pad($denominacion, 10)." ". str_pad(number_format($filas[$denominacion]), 10, " ", STR_PAD_BOTH ). "  $" .str_pad(number_format($filas[$denominacion] * $denominacion),8," ", STR_PAD_LEFT )."\n" ;
				
				
			}
			
			$print.= "IMPORTE TOTAL:            $".number_format($filas["importe_desglose"]) ."\n";
			
			
			
			$print.="\n\nVB";
			
			
			echo base64_encode($print);
			
			
			
		}
		else{
			
			
		?> 
		<div >
			<legend>Desglose de Dinero </legend> 
			<div class="row mb-2">
				<div class="col-4">
					<b >Fecha:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["fecha_desglose"];?>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-4">
					<b >Usuario:</b>
				</div>	 
				<div class="col-8">			
					<?php echo $filas["nombre_usuarios"]?>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-4">
					<b >Denom.</b> 
				</div>	 
				<div class="col-4">			
					<b >Cantidad</b> 
				</div>
				<div class="col-4">			
					<b >Importe</b> 
				</div>
			</div>
			<?php foreach($denominaciones as $i => $denominacion){?>
				<div class="row mb-2">
					<div class="col-4">
						<b >$<?php echo $denominacion;?>:</b> 
					</div>	 
					<div class="col-4 text-right">			
						<?php echo number_format($filas[$denominacion]);?>
					</div>
					<div class="col-4 text-right">			
						<?php echo number_format($filas[$denominacion] * $denominacion);?>
					</div>
				</div>
				<?php
				}
			?>
			
			<hr>
			<div class="row mb-2">
				<div class="col-4">
					<b >IMPORTE TOTAL:</b> 
				</div>	 
				<div class="col-8 text-right">			
					<?php echo number_format($filas["importe_desglose"])?>
				</div>
			</div>
		</div>
		
		<div style="page-break-after:always;"></div>
		
		
		<?php
			
			
		}
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>	