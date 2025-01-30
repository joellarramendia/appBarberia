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

            // Mostrar el modal
            $('#cargarTurno').modal('show'); // Si usas Bootstrap 4 o 5
        }
    });

    calendar.render();
});
