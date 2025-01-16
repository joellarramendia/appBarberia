//funcion para guardar el servicio
async function submitForm() {
    const formData = new FormData(document.getElementById("serviceForm"));

    // Validaciones
    const name = formData.get("name");
    const price = parseInt(formData.get("price"));
    const description = formData.get("description");
    const duration = parseInt(formData.get("duration"));

    if (!name || !description || price <= 0 || duration <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor, complete todos los campos correctamente.',
        });
        return;
    }

    try {
        const response = await axios.post("/api/createService", formData, {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "multipart/form-data",
            },
        });

        const newService = response.data.service;

        // Agrega el nuevo servicio al DOM
        const servicesContainer = document.querySelector(".servicios-container");
        const serviceElement = `
        <div class="servicio-content" id="service-${newService.service_id}">
            <div class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
                <div class="p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class="text-slate-800 text-xl font-semibold">${newService.name}</p>
                        <p class="text-cyan-600 text-xl font-semibold">₲${new Intl.NumberFormat('es-PY', { style: 'decimal' }).format(newService.price)}</p>
                    </div>
                    <p class="text-slate-600 leading-normal font-light">${newService.description}</p>
                    <p class="text-slate-800 text-xl font-semibold">Duración aprox ${newService.duration} minutos</p>
                    <button class="rounded-md w-full mt-2 bg-yellow-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-yellow-700 focus:shadow-none active:bg-yellow-700 hover:bg-yellow-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="openEditModal(${newService.service_id})">
                        Editar
                    </button>
                    <button class="rounded-md w-full mt-2 bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" onclick="deleteService(${newService.service_id})">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>`;

        servicesContainer.insertAdjacentHTML("beforeend", serviceElement);

        Swal.fire({
            title: "¡Éxito!",
            text: "Servicio guardado exitosamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
        });

        // Limpia el formulario
        document.getElementById("serviceForm").reset();

       $('#cargarServicio').modal('hide');

    } catch (error) {
        console.error("Error al guardar el servicio:", error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo guardar el servicio. Intente nuevamente.",
        });
    }
}


async function openEditModal(service_id) {
    try{
        const response = await axios.get(`/api/getService/${service_id}`);
        const service = response.data;

        document.getElementById("editName").value = service.name;
        document.getElementById("editPrice").value = service.price;
        document.getElementById("editDescription").value = service.description;
        document.getElementById("editDuration").value = service.duration;

        //almacena el id del servicio
        document.getElementById("editServiceForm").setAttribute('data-service-id', service_id);


        // Muestra el modal de edición
        $('#editarServicio').modal('show');

    }catch(error){
        console.error("Error al obtener el servicio", error);
    }
    
}

//funcion para editar el servicio
async function submitEditForm() {
    const service_id = document.getElementById("editServiceForm").getAttribute('data-service-id');
    console.log(service_id);
    const formData = new FormData(document.getElementById("editServiceForm"));

    // Validaciones
    const name = formData.get("name");
    const price = parseInt(formData.get("price"));
    const description = formData.get("description");
    const duration = parseInt(formData.get("duration"));

    if (!name || !description || price <= 0 || duration <= 0) {
        Swal.fire({
            title: "Error",
            text: "Por favor, complete todos los campos correctamente.",
            icon: "error",
        });
        return;
    }
    Swal.fire({
        title: "¿Deseas guardar los cambios?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Guardar",
        denyButtonText: "No guardar",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.post(`/api/updateService/${service_id}`, formData, {
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "multipart/form-data",
                    },
                });

                const data = response.data;

                if (data.success) {
                    Swal.fire("Guardado", "El servicio fue actualizado exitosamente.", "success");
                    $('#editarServicio').modal('hide');

                    // Actualiza el DOM dinámicamente
                    const serviceElement = document.getElementById(`service-${service_id}`);
                    if (serviceElement) {
                        serviceElement.querySelector(".editName").textContent = name;
                        serviceElement.querySelector(".editPrice").textContent = `₲${price.toLocaleString("es-PY")}`;
                        serviceElement.querySelector(".editDescription").textContent = description;
                        serviceElement.querySelector(".editDuration").textContent = `Duración aprox ${duration} minutos`;
                    }
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.message || "No se pudo actualizar el servicio.",
                        icon: "error",
                    });
                }
            } catch (error) {
                console.error("Error al actualizar el servicio:", error);
                Swal.fire({
                    title: "Error",
                    text: "No se pudo actualizar el servicio. Intente nuevamente.",
                    icon: "error",
                });
            }
        } else if (result.isDenied) {
            Swal.fire("Los cambios no fueron guardados", "", "info");
        }
    });
}

//funcion para eliminar el servicio
async function deleteService(service_id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then(async (result) => {
        if (result.isConfirmed) {
            document.getElementById("cargando").style.display = "block";

            try {
                const response = await axios.delete(`/api/deleteService/${service_id}`, {
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    },
                });

                const data = response.data;

                if (data.success) {
                    Swal.fire({
                        title: "Eliminado",
                        text: data.message,
                        icon: "success",
                    });
                    const serviceElement = document.getElementById(`service-${service_id}`);
                    if (serviceElement) serviceElement.remove();
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.message || "No se pudo eliminar el servicio.",
                        icon: "error",
                    });
                }
            } catch (error) {
                console.error("Error al eliminar el servicio:", error);
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error al intentar eliminar el servicio.",
                    icon: "error",
                });
            }
        }
    });
}

 