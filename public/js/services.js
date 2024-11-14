//funcion para guardar el servicio
function submitForm() {
    const formData = new FormData(document.getElementById("serviceForm"));
    // Obtenemos los valores de los campos
    const name = document.getElementById("name").value;
    const price = document.getElementById("price").value;
    const description = document.getElementById("description").value;
    const duration = document.getElementById("duration").value;

    // Validaciones
    if (!name || !price || !description || !duration) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    if (price <= 0) {
        alert("El precio debe ser mayor que 0.");
        return;
    }

    if (duration <= 0) {
        alert("La duración debe ser mayor que 0 minutos.");
        return;
    }

    fetch("/api/createService", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((service) => {
            alert("Servicio guardado exitosamente");
            window.location.reload();
            //addServiceCard(service); // Agrega la tarjeta del nuevo servicio

            // Limpia el formulario después de guardar el servicio
            document.getElementById("serviceForm").reset();
        })
        .catch((error) => console.error("Error:", error));
}


// Función para eliminar un servicio
function deleteService(service_id) {
    console.log(service_id);
    const confirmation = confirm("¿Estás seguro de que quieres eliminar este servicio?");
    if (confirmation) {
        // Mostrar spinner mientras se procesa la eliminación
        document.getElementById("cargando").style.display = "block";


        fetch(`/api/deleteService/${service_id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    document.getElementById(`service_${service_id}`).remove(); // Elimina el servicio de la interfaz

                } else {
                    alert(data.message);
                }
            })
            .catch((error) => console.error("Error:", error))
            .finally(() => {
                // Ocultar spinner después de la respuesta
                document.getElementById("cargando").style.display = "none";
            });
            window.location.reload();
    }
}



function openEditModal(service_id,) {
    // Muestra el modal de edición
    $('#editarServicio').modal('show');
}


