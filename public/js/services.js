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
        Swal.fire({
            title: "¡Éxito!",
            text: "Servicio guardado exitosamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
        }).then(() => {
            // Recargar la página o actualizar la lista
            window.location.reload();
        });
    } catch (error) {
        console.error("Error al guardar el servicio:", error);
        alert("No se pudo guardar el servicio. Intente nuevamente.");
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

        //almacenar el id del servicio
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
        alert("Por favor, complete todos los campos correctamente.");
        return;
    }

    try {
        const response = await axios.post(`/api/updateService/${service_id}`, formData, {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "multipart/form-data",
            },
        });
        console.log(response);
        alert("Servicio actualizado exitosamente");
        // Recargar la página o actualizar la lista
        window.location.reload();
    } catch (error) {
        console.error("Error al actualizar el servicio:", error);
        // Muestra los errores específicos devueltos por el servidor
        if (error.response && error.response.data.errors) {
            alert(JSON.stringify(error.response.data.errors));
        } else {
            alert("No se pudo actualizar el servicio. Intente nuevamente.");
        }
    }
}


// Función para eliminar un servicio
/*async function deleteService(service_id) {
    const confirmation = confirm("¿Estás seguro de que quieres eliminar este servicio?");
    if (!confirmation) return;

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
            alert(data.message);
            document.getElementById(`service_${service_id}`).remove();
            
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error("Error al eliminar el servicio:", error);
        alert("No se pudo eliminar el servicio. Intente nuevamente.");
    } finally {
        document.getElementById("cargando").style.display = "none";
        window.location.reload();
    }
}*/





/*Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });*/
