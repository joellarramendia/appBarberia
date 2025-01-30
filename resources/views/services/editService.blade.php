<div class="modal fade" id="editarServicio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editarServicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-2xl font-semibold text-gray-800"" id="editarServicioLabel">Editar Servicio</h5>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="editName">Nombre del Servicio</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" id="editName" name="editName" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="editPrice">Precio del Servicio</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" id="editPrice" name="editPrice" required>
                        </div>                  
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">                       
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="editDescription">Descripción del Servicio</label>
                            <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" id="editDescription" name="editDescription" rows="3" required></textarea>
                        </div>                   
                       
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="editDuration">Duración del Servicio (en minutos)</label>
                            <input type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm" id="editDuration" name="editDuration" step="0.01" required>
                        </div>                      
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700" onclick="submitEditForm()">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


