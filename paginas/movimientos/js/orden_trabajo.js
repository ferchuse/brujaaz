$(document).ready(function(){
    //=========BUSCAR NUM.ECO===================
    $('#btn_buscar').on('click',function(){
        let boton = $(this);
        let icono = boton.find("fas");
        let numero_unidad = $('#no_eco').val();
        let subconsulta ='LEFT JOIN tarjetas USING (id_unidades) LEFT JOIN conductores USING (id_conductores)';
        let group = 'nombre_conductores';
        boton.prop("disabled", true);
	    icono.toggleClass("fa-print fa-spinner fa-spin");
        console.log("numero_unidad" + " "+ numero_unidad);
        $.ajax({
            url: 'control/listar_orden.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
                tabla: 'unidades',
                subconsulta: subconsulta,
                campo: 'num_eco',
                id_campo: numero_unidad,
                group: group
            }
        }).done(function(respuesta){
            resultado(respuesta,numero_unidad);
        }).always(function(){
            boton.prop("disabled", false);
            icono.toggleClass("fa-print fa-spinner fa-spin");
        });
    });


});

function resultado(respuesta,numero_unidad){
    if(respuesta.estatus == 'success'){
        let contenedor = '';
        if(respuesta.num_rows > 0){
            $.each(respuesta.mensaje,function(index,element){
                contenedor += `
                    <tr>
                        <td class="text-center">${element.num_eco}</td>
                        <td class="text-center">${element.nombre_conductores}</td>
                        <td class="text-center">----</td>
                        <td class="text-center">${element.noLicencia_conductores}</td>
                        <td class="text-center">${element.fechaVigencia_conductores}</td>
                        <td class="text-center">${element.rfc_conductores}</td>
                        <td class="text-center">
                            <div class="check">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="c1" data-v="30">
                                    <label class="form-check-label" for="exampleRadios1">
                                        30
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="c2" data-v="60">
                                    <label class="form-check-label" for="exampleRadios2">
                                        60
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="c3" data-v="90">
                                    <label class="form-check-label" for="exampleRadios3">
                                        90
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td class="text-center d-print-none">
                            <button class="btn btn-outline-primary imprimir " title="Imprimir" value="" data-id_unidades='${element.id_unidades}'><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                `;                 
            });
        }else{
            contenedor = `
                <tr>
                    <td colspan="8"><h3 class="text-center">No hay Ninguna Unidad con ese No.Eco ${numero_unidad}</h3></td>
                </tr>
            `;
        }
        $('#tabla_DB').html(contenedor);
        
        //==========FECHA MEDIANTE CHECKBOX=========================
        $('#c1').on('click',im
            
            //$('.imprimir').val(fechaParse);
            //let fecha = new Date();
            //console.log(fecha);
            //console.log(fecha.getDay());
            //console.log(fecha.getDate());
            //console.log(fecha.getMonth());
            //console.log(fecha.getFullYear());
        );

        $('#c2').on('click',im);

        $('#c3').on('click',im);

        //=========IMPRIMIR=========
        $('.imprimir').on('click',function(){
            let subconsulta ='LEFT JOIN tarjetas USING (id_unidades) LEFT JOIN conductores USING (id_conductores)';
            let group = 'nombre_conductores';
            let boton = $(this);
            let icono = boton.find("fas");
            let id_unidades = boton.data('id_unidades');

            let num_eco = boton.val();
            let nn = Number(num_eco);
            let fechaVencimiento = Date.today().add({days: nn});
            let fechaParse = fechaVencimiento.toString('yyyy-MM-dd');
            console.log(fechaParse);
            boton.prop("disabled", true);
	        icono.toggleClass("fa-print fa-spinner fa-spin");
            //console.log(fecha_tarbajo);
            if(num_eco != ""){
                $.ajax({
                    url: 'impresion/imprimir_orden.php',
                    method: 'POST',
                    dataType: 'HTML',
                    data: {
                        num_eco: num_eco,
                        fecha_trabajo: fechaParse,
                        tabla: 'unidades',
                        subconsulta: subconsulta,
                        id_campo: id_unidades,
                        campo: 'id_unidades',
                        group: group
                    }
                }).done(function(respuesta){
                    $('#imprimir').html(respuesta);
                    window.print();
                }).always(function(){
                    boton.prop("disabled", false);
                    icono.toggleClass("fa-print fa-spinner fa-spin");
                });
            }else{
                alertify.error("Elige un dia de Trabajo");
                boton.prop("disabled", false);
            }
        });

    }else{
        console.log("Error al cargar la tabla");
    }
}

function im(){
    let valor_check = $(this).data("v");
    console.log("valor de ckeck es "+" "+valor_check);
    $('.imprimir').val(valor_check);
}