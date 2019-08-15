<form class="was-validated " id="form_edicion">
    <!-- The Modal -->
    <div class="modal fade" id="modal_edicion">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-center"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" hidden class="form-control" id="id_origenes" name="id_origenes">
                    <div class="form-group">
                        <label for="nombre_origenes">NOMBRE ORIGENES</label>
                        <input type="text" class="form-control" id="nombre_origenes" name="nombre_origenes"
                               placeholder="Nombre del origen" required>
                    </div>
                   
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i
                                class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-outline-success"><i class="fa fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
