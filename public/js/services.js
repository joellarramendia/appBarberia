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
        <div class="servicio-content  m-2" id="service-${newService.service_id}" onclick="toggleSelection(${newService.service_id}, '${newService.name}', '${newService.duration}')">
            <div class="relative flex flex-col my-2 bg-white shadow-sm border border-slate-200 rounded-lg w-80">
                <div class="p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <p class=" edtiName text-slate-800 text-xl font-semibold">${ucwords(newService.name)}</p>
                        <p class=" editPrice text-cyan-600 text-xl font-semibold">₲${new Intl.NumberFormat('es-PY', { style: 'decimal' }).format(newService.price)}</p>
                    </div>
                    <p class=" editDescription text-slate-600 leading-normal font-light">${ucwords(newService.description)}</p>
                    <p class=" editDuration text-slate-800 text-xl font-semibold">Duración aprox ${newService.duration} minutos</p>
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
//funcion para convertir la primera letra en mayuscula
function ucwords(str) {
    return str.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}


//funcion para abrir el modal de edicion
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
    let name = ucwords(formData.get("editName"));
    const price = parseInt(formData.get("editPrice"));
    let description = ucwords(formData.get("editDescription"));
    const duration = parseInt(formData.get("editDuration"));


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
        showCancelButton: false,
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


//funcion para seleccionar los servicios
let selectedServices = [];
function toggleSelection(service_id, service_name, service_duration) {
    const serviceContainer = document.getElementById('service-' + service_id);
    serviceContainer.classList.toggle('selected');

    if (serviceContainer.classList.contains('selected')) {
        selectedServices.push({ id: service_id, name: service_name, duration: parseInt(service_duration) || 0 }); // Añade el servicio seleccionado
    } else {
        selectedServices = selectedServices.filter(service => service.id !== service_id); // Elimina el servicio deseleccionado
    }

    updateSelectedServices();
    updateEndTime(); // Recalcula la hora de fin
}

//funcion para actualizar los servicios seleccionados
function updateSelectedServices() {
    const selectedServicesList = document.getElementById('servicio');
    selectedServicesList.innerHTML = ''; // Limpia la lista de servicios seleccionados

    selectedServices.forEach(service => {
        // Crea un contenedor para el servicio
        const serviceContainer = document.createElement('div');
        serviceContainer.classList.add('bg-cyan-200', 'p-2', 'rounded-md', 'flex', 'items-center', 'gap-2');

        // Crea el texto con el nombre del servicio
        const serviceText = document.createElement('span');
        serviceText.textContent = ucwords(service.name);

        // Crea el botón de quitar
        const removeButton = document.createElement('button');
        removeButton.textContent = 'x';
        removeButton.classList.add('bg-red-600', 'text-white', 'py-1', 'px-2', 'rounded-md', 'hover:bg-red-700', 'focus:outline-none');
        removeButton.onclick = () => removeService(service.id); // Llama a la función para quitar el servicio

        // Agrega el texto y el botón al contenedor
        serviceContainer.appendChild(serviceText);
        serviceContainer.appendChild(removeButton);

        // Agrega el contenedor al listado de servicios seleccionados
        selectedServicesList.appendChild(serviceContainer);
    });
}

//funcion para quitar el servicio
function removeService(service_id) {
    const serviceContainer = document.getElementById('service-' + service_id);

    // Elimina el servicio del arreglo de servicios seleccionados
    if (serviceContainer.classList.contains('selected')) {
        serviceContainer.classList.remove('selected'); // Remueve la clase 'selected'
        selectedServices = selectedServices.filter(service => service.id !== service_id); // Elimina el servicio de la lista
        console.log(selectedServices);

        // Actualiza la lista de servicios seleccionados en el modal
        updateSelectedServices();
        updateEndTime(); // Recalcula la hora de fin
    }
}

// Llama a la función cuando se abra el modal para que se muestren los servicios seleccionados
$('#cargarTurno').on('show.bs.modal', function () {
    updateSelectedServices(); // Actualiza la lista de servicios seleccionados
});


function getSelectedServices() {
    return selectedServices;
}


//funcion para crear el turno
async function createAppointment(event) {
    event.preventDefault();

    const servicios = getSelectedServices().map(service => service.id);
    let today = new Date().toISOString().split("T")[0]; // Obtiene la fecha actual en formato YYYY-MM-DD
    let startDate = document.getElementById("date").value;
    let startTime = document.getElementById("hora").value;
    let endTime = document.getElementById("horaFin").value;


    if (servicios.length === 0) {
        Swal.fire("Debe seleccionar al menos un servicio.", "", "warning");
        return;
    }

    // Validar que la fecha seleccionada no sea anterior a hoy
    if (!startDate || startDate < today) {
        Swal.fire("Error", "Debe seleccionar una fecha válida.", "warning");
        return;
    }


    let userId = document.getElementById("user").getAttribute("data-id");
    if (!userId) {
        Swal.fire("Error", "No se pudo obtener el ID del usuario.", "error");
        return;
    }

    if (!startDate) {
        Swal.fire("Error", "Debe seleccionar la fecha en la que irá.", "warning");
        return;
    }

    if (!startTime) {
        Swal.fire("Error", "Debe seleccionar la hora a la que irá.", "warning");
        return;
    }

    try {
        const availabilityResponse = await axios.post("/api/appointments/checkAvailability", {
            start_date: startDate,
            time: startTime,
            timeEnd: endTime
        });

        if (!availabilityResponse.data.available) {
            Swal.fire("Error", "El horario seleccionado ya está ocupado. Elija otro.", "error");
            return;
        }
    } catch (error) {
        console.error("Error al verificar disponibilidad:", error);
        Swal.fire("Error", "No se pudo verificar la disponibilidad.", "error");
        return;
    }

    const appointmentData = {
        user_id: userId,
        start_date: startDate,
        time: startTime,
        timeEnd: endTime,
        status: "earring",
        services: servicios,
    };

    try {
        const response = await axios.post("/api/createAppointment", appointmentData, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            }
        });

        if (response.data.error) {
            Swal.fire("Error", response.data.error, "error");
        } else {
            Swal.fire("Turno creado exitosamente", "", "success").then(() => location.reload());
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
        Swal.fire("Error", "Hubo un problema al crear el turno.", "error");
    }
}

//funcion para limitar la hora de inicio
document.getElementById("hora").addEventListener("input", function () {
    let selectedTime = this.value;
    if (selectedTime < "08:00" || selectedTime > "20:00") {
        Swal.fire("Error", "Seleccione un horario entre 08:00 y 20:00.", "warning");
        this.value = ""; // Borra la selección incorrecta
    }
});


//funcion para actualizar la hora de fin
document.getElementById('hora').addEventListener('input', updateEndTime);
function updateEndTime() {
    const startTime = document.getElementById('hora').value;
    if (!startTime) return; // Si no hay hora seleccionada, no hacer nada

    // Calcula el total de minutos de los servicios seleccionados
    let totalMinutes = selectedServices.length 
        ? selectedServices.reduce((sum, service) => sum + (parseInt(service.duration) || 0), 0) 
        : 0; // Si no hay servicios, totalMinutes será 0
        
    console.log(totalMinutes)

    const [hours, minutes] = startTime.split(':').map(Number); // Convertir la hora en números

    // Verifica si los valores obtenidos son válidos
    if (isNaN(hours) || isNaN(minutes)) {
        document.getElementById('horaFin').value = ""; // Evitar NaN:NaN
        return;
    }

    const endDate = new Date();
    endDate.setHours(hours);
    endDate.setMinutes(minutes + totalMinutes); // Sumar los minutos totales

    // Formatea la nueva hora en HH:MM
    const endHours = String(endDate.getHours()).padStart(2, '0');
    const endMinutes = String(endDate.getMinutes()).padStart(2, '0');

    document.getElementById('horaFin').value = `${endHours}:${endMinutes}`;
}


