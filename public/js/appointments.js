document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: '/appointments/store', // Ruta que devuelve los eventos en JSON
        eventClick: function (info) {
            // Llenar los campos del modal con la información del evento seleccionado
            document.getElementById('user').value = info.event.extendedProps.client; // Cliente
            document.getElementById('date').value = info.event.start.toISOString().split('T')[0]; // Fecha
            document.getElementById('hora').value = info.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }); // Hora de inicio
            document.getElementById('horaFin').value = info.event.end ? info.event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : ''; // Hora fin

            // Llenar servicios seleccionados
            let serviceContainer = document.getElementById('servicio');
            serviceContainer.innerHTML = ''; // Limpiar antes de agregar nuevos datos
            let services = info.event.title.split(', ');
            services.forEach(service => {
                let span = document.createElement('span');
                span.textContent = service;
                span.classList.add('bg-gray-200', 'px-2', 'py-1', 'rounded-md');
                serviceContainer.appendChild(span);
            });

            // Evento para eliminar la cita con SweetAlert2 y Axios
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
                        axios.delete(`/api/appointments/${appointment_id}`, {
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            }
                        })
                        .then(response => {
                            Swal.fire("Eliminado", response.data.message, "success");
                            info.event.remove(); // Eliminar del calendario visualmente
                            $('#cargarTurno').modal('hide'); // Cerrar el modal
                        })
                        .catch(error => {
                            Swal.fire("Error", "Hubo un problema al eliminar la cita", "error");
                        });
                    }
                });
            };

            // Mostrar el modal
            $('#cargarTurno').modal('show'); 
        }
    });

    calendar.render();
});
