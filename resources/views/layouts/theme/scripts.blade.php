@livewireScripts
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Escuchar el evento `Eliminar`
    window.Confirm = function(id, products, entityName, name) {
        if (products > 0) {
            Swal.fire({
                title: 'No se puede eliminar la ${entityName}',
                text: 'Tiene productos existentes',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: `¿Estás seguro de eliminar '${name}' de ${entityName}?`,
            text: "¡No podrás revertir esto!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#a10c10",
            cancelButtonColor: "#727885",
            confirmButtonText: "Sí, eliminarla!"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteRow', {
                    id: id
                });
                /*Swal.fire({
                    //position: "top-end",
                    icon: "success",
                    title: `La categoría "${categoryname}" ha sido eliminada?`,
                    showConfirmButton: false,
                    timer: 1500
                });*/
            }
        });
    }
    // Escuchar el evento `added`
    Livewire.on('noty-added', (data) => {
        //console.log('Event Data:', data);
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "success",
                iconColor: "#0ca152", //color verde oscuro
                title: `se agrego ${data.type} "${data.name}" con exito!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría agregada" no tienen el formato esperado.',
                data);
        }
    });

    // Escuchar el evento `updated`
    Livewire.on('noty-updated', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "success",
                iconColor: "#0c4ca1", //color Azul oscuro
                title: `se actualizó ${data.type} "${data.name}" con exito!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría actualizada" no tienen el formato esperado.',
                data);
        }
    });

    //Escuchar el evento `deleted`
    Livewire.on('noty-deleted', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "error",
                title: `se eliminó ${data.type} "${data.name}" exitosamente!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría desconocida" no tienen el formato esperado.',
                data);
        }
    });

    // Escuchar el evento `not-found`
    Livewire.on('noty-not-found', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "error",
                title: `la ${data.type} con "${data.id}" no se encuentra!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría desconocida" no tienen el formato esperado.',
                data);
        }
    });

    Livewire.on('noty-error', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "error",
                title: `la ${data.type} con "${data.id}" no se encuentra!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría desconocida" no tienen el formato esperado.',
                data);
        }
    });

    //Eventos para el Menu de Modulos de Plantilla
    const detailsList = document.querySelectorAll('details');
    // Cerrar detalles cuando se hace clic fuera de ellos
    document.addEventListener('click', function(event) {
        detailsList.forEach(function(details) {
            if (details.open && !details.contains(event.target)) {
                details.open = false;
            }
        });
    });
    // Asegurarse de que solo un <details> se abre a la vez
    detailsList.forEach(function(details) {
        details.addEventListener('toggle', function() {
            if (details.open) {
                detailsList.forEach(function(otherDetails) {
                    if (otherDetails !== details && otherDetails.open) {
                        otherDetails.open = false;
                    }
                });
            }
        });
    });
});
</script>