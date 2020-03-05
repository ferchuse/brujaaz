$(document).ready(function () {

    
    listarRegistros();

    //========DAR LCIK EN BOTON DE NUEVO=============
    $('.nuevo').on('click', function () {
        $('#form_edicion')[0].reset();
        $('.modal-title').text('Nuevo Origen');
        $('#modal_edicion').modal('show');
    });

    //==========GUARDAR NUEVA EMPRESA============
    $('#form_edicion').on('submit', function (event) {
        event.preventDefault();
        let form = $(this);
        let boton = form.find(':submit');
        let icono = boton.find('.fa');
        let datos = form.serializeArray();

        boton.prop('disabled', true);
        icono.toggleClass('fa-save fa-spinner fa-pulse ');

        $.ajax({
            url: '../../funciones/guardar.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
                tabla: 'origenes',
                datos: datos
            }
        }).done(function (respuesta) {
            if (respuesta.estatus == 'success') {
                alertify.success('Se ha agregado correctamente');
                $('#modal_edicion').modal('hide');
                listarRegistros();
            } else {
                alertify.error('Ocurrio un error');
            }
        }).always(function () {
            boton.prop('disabled', false);
            icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
        });
    })

    //=========BUSCAR EMPRESA=========
    $("#id_origenes").keyup(function filtro_buscar() {
        var indice = $(this).data("indice");
        var valor_filtro = $(this).val();
        var num_rows = buscar(valor_filtro, 'tabla_origenes', indice);
        if (num_rows == 0) {
            $('#mensaje').html("<div class='alert alert-dark text-center' role='alert'><strong>No se ha encontrado.</strong></div>");
        } else {
            $('#mensaje').html('');
        }
    });
    //=========BUSCAR EMPRESA=========
    $("#nombre_origenes").keyup(function filtro_buscar() {
        var indice = $(this).data("indice");
        var valor_filtro = $(this).val();
        var num_rows = buscar(valor_filtro, 'tabla_origenes', indice);
        if (num_rows == 0) {
            $('#mensaje').html("<div class='alert alert-dark text-center' role='alert'><strong>No se ha encontrado.</strong></div>");
        } else {
            $('#mensaje').html('');
        }
    });


});


function listarRegistros() {
    let subconsulta = '';

    return $.ajax({
        url: '../../funciones/listar.php',
        method: 'POST',
        dataType: 'JSON',
        data: {
            tabla: 'origenes',
            subconsulta: subconsulta
        }
    }).done(function (respuesta) {
        if (respuesta.estatus == 'success') {
            let origenes = '';
            if (respuesta.num_rows > 0) {
                $.each(respuesta.mensaje, function (index, element) {
                    origenes += `
                        <tr>
                           <td class="text-center">${element.nombre_origenes}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-danger eliminar" data-id_origenes='${element.id_origenes}'><i class="fas fa-trash-alt"></i></button>
                                <button class="btn btn-outline-warning editar" data-id_origenes='${element.id_origenes}'><i class="fas fa-pencil-alt"></i></button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                origenes = `
                <tr>
                    <td colspan="8"><h3 class="text-center">No hay Origenes</h3></td>
                </tr>
                `;
            }
            $('#containerLista').html(origenes);


            //=========ELIMINAR=========
            $('.eliminar').click(function () {
                let boton = $(this);
                let id_origenes = boton.data('id_origenes');
                var fila = boton.closest('tr');

                alertify.confirm('Confirmacion', '¿Deseas eliminarlo?', eliminar, function () {
                });

                function eliminar() {
                    $.ajax({
                        url: '../../funciones/fila_delete.php',
                        method: 'POST',
                        dataType: 'JSON',
                        data: {
                            tabla: 'origenes',
                            id_campo: 'id_origenes',
                            id_valor: id_origenes
                        }
                    }).done(function (respuesta) {
                        if (respuesta.estatus == 'success') {
                            alertify.success('Se ha eliminado correctamente');
                            fila.fadeOut(1000);
                        } else {
                            alertify.error('Ocurrio un error');
                        }
                    });
                }

            });

            /*=======LISTAR EMPRESAS=========*/
            $('.editar').click(function () {
                var boton = $(this);
                var icono = boton.find('.fas');
                var id_origenes = boton.data('id_origenes');
                boton.prop('disabled', true);
                icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');

                $.ajax({
                    url: '../../funciones/listar.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        tabla: 'origenes',
                        id_campo: id_origenes,
                        campo: 'id_origenes'
                    }
                }).done(function (respuesta) {
                    if (respuesta.estatus == 'success') {
                        $.each(respuesta.mensaje[0], function (index, element) {
                            $('#' + index).val(element);
                        });
                        $('.modal-title').text('Editar Conductor');
                        $('#modal_edicion').modal('show');
                    } else {
                        //console.log(respuesta.mensaje);
                    }
                }).always(function () {
                    boton.prop('disabled', false);
                    icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');
                });
            });


        } else {
            //console.log(respuesta.mensaje);
        }
    });
}

