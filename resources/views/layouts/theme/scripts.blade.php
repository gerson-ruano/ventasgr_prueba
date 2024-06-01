@livewireScripts
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.Confirm = function(id, products, entityName) {
        if (products > 0) {
            Swal.fire({
                title: 'No se puede eliminar la ${entityName}',
                text: 'Tiene productos existentes',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: `¿Estás seguro de eliminar la ${entityName}?`,
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
    // Escuchar el evento `category-added`
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

    // Escuchar el evento `category-updated`
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

    //Escuchar el evento `category-updated`
    Livewire.on('noty-deleted', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "error",
                title: `se eliminó "${data.name}" exitosamente!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría desconocida" no tienen el formato esperado.',
                data);
        }
    });

    // Escuchar el evento `category-deleted`
    Livewire.on('noty-not-found', (data) => {
        if (data && data.type && data.name) {
            Swal.fire({
                icon: "error",
                title: `la "${data.id}" no se encuentra!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría desconocida" no tienen el formato esperado.',
                data);
        }
    });
});
</script>