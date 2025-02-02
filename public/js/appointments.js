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

            // Llenar servicios seleccionados
            let serviceContainer = document.getElementById('servicio');
            serviceContainer.innerHTML = ''; // Limpiar antes de agregar nuevos datos
            let services = info.event.extendedProps.services.split(', ');
            services.forEach(service => {
                let span = document.createElement('span');
                span.textContent = ucwords(service);
                span.classList.add('bg-gray-200', 'px-2', 'py-1', 'rounded-md');
                serviceContainer.appendChild(span);
            });

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

    window.calendar = calendar;
    calendar.render();
});


function ucwords(str) {
    return str.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}
