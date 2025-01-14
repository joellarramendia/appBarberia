<div class="modal fade" id="editarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editarServicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarServicioLabel">Editar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center position-relative">
                <div class="position-absolute justify-content-center" style="top: 50%; left: 50%; z-index: 5; display:none;" id="cargandoEditar">
                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <form id="editServiceForm" class="w-100">
                    @csrf
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-left" for="editName">Nombre del Servicio</label>
                                    <input type="text" class="form-control" id="editName" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editPrice">Precio del Servicio</label>
                                    <input type="number" class="form-control" id="editPrice" name="price" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editDescription">Descripción del Servicio</label>
                                    <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editDuration">Duración del Servicio (en minutos)</label>
                                    <input type="number" class="form-control" id="editDuration" name="duration" step="0.01" required>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


