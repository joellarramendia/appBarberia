document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

     let calendar = new FullCalendar.Calendar(calendarEl, {
         locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        events: '/appointments/store', // Ruta que devuelve los eventos en JSON
        eventDisplay: 'block', 
        eventTimeFormat: { // Formato de la hora en FullCalendar
            hour: '2-digit',
            minute: '2-digit',
            hour12: false // Forzar formato 24 horas
        },
        eventClick: function (info) {
            // Llenar los campos del modal con la información del evento seleccionado
            document.getElementById('user').value = info.event.extendedProps.client; // Cliente
            document.getElementById('date').value = info.event.start.toISOString().split('T')[0]; // Fecha
            document.getElementById('hora').value = info.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }); // Hora de inicio
            document.getElementById('horaFin').value = info.event.end ? info.event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : ''; // Hora fin

            // Mostrar los servicios seleccionados en el modal
            let services = info.event.extendedProps.services.split(', ');
            selectedServices = services.map(service => ({ id: service, name: service }));
            updateSelectedServices(false); // Actualizar la lista de servicios seleccionados

            // Evento para eliminar la cita 
            document.getElementById('btnEliminar').onclick = function () {
                let appointment_id = info.event.id;
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/api/deleteAppointments/${appointment_id}`, {
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            }
                        })
                        .then(response => {
                            Swal.fire("Eliminado", response.data.message, "success");
                            info.event.remove(); // Eliminar del calendario visualmente
                            $('#mostrarTurno').modal('hide'); // Cerrar el modal
                        })
                        .catch(error => {
                            Swal.fire("Error", "Hubo un problema al eliminar la cita", "error");
                        });
                    }
                });
            };

            //evento para confirmar la cita
            document.addEventListener("click", function (event) {
                if (event.target && event.target.id === "btnConfirmar") {
                    let appointment_id = info.event.id;
                    console.log(appointment_id);
                    console.log(document.getElementById(`appointment-${appointment_id}`));
            
                    axios.post(`/api/appointments/${appointment_id}/confirm`, {}, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        }
                    })
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cita Confirmada',
                            text: response.data.message,
                            confirmButtonText: 'OK',
                            timer: 2000
                        });
            
                        // Actualizar el estado de la cita en la interfaz sin recargar
                        //document.getElementById(`appointment-${appointment_id}`).classList.add('bg-green-500');
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al confirmar la cita.',
                            confirmButtonText: 'Cerrar'
                        });
                        console.error("Error:", error);
                    });
                }
            });

            // Mostrar el modal
            $('#mostrarTurno').modal('show'); 
        }
    });



    window.calendar = calendar;
    calendar.render();

     //Escucha eventos en el canal "appointments" y actualiza el calendario en tiempo real
     window.Echo.channel('appointments')
     .listen('.nueva-cita', (data) => {
         console.log("Nueva cita recibida:", data.appointment);

         calendar.addEvent({
             id: data.appointment.appointment_id,
             title: data.appointment.user.name, 
             start: data.appointment.start_date + 'T' + data.appointment.time,
             end: data.appointment.start_date + 'T' + data.appointment.timeEnd,
             extendedProps: {
                 client: data.appointment.user.name,
                 services: data.appointment.services.map(service => service.name).join(', '),
             }
         });

         console.log("Cita agregada al calendario");
     });
    
});


function ucwords(str) {
    return str.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}



//funcion para seleccionar los servicios
window.selectedServices = window.selectedServices || []; // Asegura que la variable global existe
function toggleSelection(service_id, service_name, service_duration) {
    const serviceContainer = document.getElementById('service-' + service_id);
    serviceContainer.classList.toggle('selected');

    if (serviceContainer.classList.contains('selected')) {
        window.selectedServices.push({ id: service_id, name: service_name, duration: parseInt(service_duration) || 0 }); // Añade el servicio seleccionado
    } else {
        window.selectedServices = window.selectedServices.filter(service => service.id !== service_id);
    }

    updateSelectedServices(true);
    updateEndTime(); // Recalcula la hora de fin
}


// Escucha el evento de eliminación de servicio solo una vez
document.addEventListener('serviceDeleted', (event) => {
    const service_id = event.detail;

    // Asegurar que el servicio eliminado no esté en la lista de seleccionados
    window.selectedServices = window.selectedServices.filter(service => service.id !== service_id);

    // Actualiza la UI del modal
    updateSelectedServices(true);
    updateEndTime();
});

// Función para actualizar los servicios seleccionados
function updateSelectedServices(showRemoveButton = true) {
    console.log("🔄 Actualizando servicios seleccionados:", window.selectedServices);
    const selectedServicesList = document.getElementById('servicio');
    selectedServicesList.innerHTML = ''; // Limpia la lista de servicios seleccionados

    window.selectedServices.forEach(service => {
        // Crea un contenedor para el servicio
        const serviceContainer = document.createElement('div');
        serviceContainer.classList.add('bg-cyan-200', 'p-2', 'rounded-md', 'flex', 'items-center', 'gap-2');

        // Crea el texto con el nombre del servicio
        const serviceText = document.createElement('span');
        serviceText.textContent = ucwords(service.name); // Nombre del servicio con la primera letra en mayúscula

        // Agrega el texto al contenedor
        serviceContainer.appendChild(serviceText);

        // Si showRemoveButton es true, agregar el botón de quitar
        if (showRemoveButton === true) {
            const removeButton = document.createElement('button');
            removeButton.textContent = 'x';
            removeButton.classList.add('bg-red-600', 'text-white', 'py-1', 'px-2', 'rounded-md', 'hover:bg-red-700', 'focus:outline-none');
            removeButton.onclick = () => removeService(service.id); // Llama a la función para quitar el servicio

            // Agrega el botón al contenedor
            serviceContainer.appendChild(removeButton);
        }

        // Agrega el contenedor al listado de servicios seleccionados
        selectedServicesList.appendChild(serviceContainer);
    });
}


// Escuchar el evento `serviceUpdated` para actualizar el modal de agendamiento
document.addEventListener("serviceUpdated", (event) => {
    const updatedService = event.detail;

    let selectedService = window.selectedServices.find(service => service.id === parseInt(updatedService.id));

    if (selectedService) {
        // Actualizar los datos del servicio en la lista de seleccionados
        selectedService.name = updatedService.name;
        selectedService.price = updatedService.price;
        selectedService.description = updatedService.description;
        selectedService.duration = updatedService.duration;

        // Actualiza la interfaz del modal de agendamiento
        updateSelectedServices(true);
    } else {
        console.log("No se encontró el servicio en la lista de seleccionados.");
    }
});



//funcion para quitar el servicio
function removeService(service_id) {
    const serviceContainer = document.getElementById('service-' + service_id);

    // Elimina el servicio del arreglo de servicios seleccionados
    if (serviceContainer.classList.contains('selected')) {
        serviceContainer.classList.remove('selected'); // Remueve la clase 'selected'
        window.selectedServices = window.selectedServices.filter(service => service.id !== service_id); // Elimina el servicio de la lista
        console.log(selectedServices);

        // Actualiza la lista de servicios seleccionados en el modal
        updateSelectedServices(true);
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
            Swal.fire("Turno creado exitosamente", "", "success");
            if (window.calendar) {
                window.calendar.addEvent({
                    id: response.data.appointment_id,
                    title: response.data.user_name,
                    start: `${startDate}T${startTime}`,
                    end: `${startDate}T${endTime}`,
                    extendedProps: {
                        client: response.data.user_name,
                        services: servicios.join(', ')
                    }
                });

                window.calendar.refetchEvents();
            }

            // Cerrar modal y limpiar formulario
            $('#cargarTurno').modal('hide');
            document.getElementById("date").value = "";
            document.getElementById("hora").value = "";
            document.getElementById("horaFin").value = "";
        
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
