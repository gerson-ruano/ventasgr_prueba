<div>
    <!-- Header Section -->
    <div class="text-center">
        <h3 class="card-title text-center">
            <b>{{ $componentName }} | {{ $pageTitle }}</b>
        </h3>
    </div>

    <!-- Tabs Section -->
    <div class="text-center">
        <button class="btn btn-accent mb-2" wire:click="openModal">Nueva Categoría</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300">
        <table class="table ">
            <thead>
                <tr class="bg-primary-content dark:bg-gray-800">
                    <th class="text-base-800 dark:text-base-100">No.</th>
                    <th class="text-base-800 dark:text-base-100">Descripción</th>
                    <th class="text-gray-500 dark:text-base-100">Imagen</th>
                    <th class="text-gray-500 dark:text-base-100">Acción</th>
                    <th class="text-gray-500 dark:text-base-100">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <img src="{{ $category->imagen }}" alt="imagen de ejemplo" height="70" width="80"
                            class="rounded">

                    </td>
                    <td class="text-center">
                        <button class="btn btn-info" wire:click="editCategory({{ $category->id }})"><i
                                class="fas fa-edit"></i></button>
                        {{--dd($category->id)--}}
                    </td>

                    <td class="text-center">
                        <a href="javascript:void(0)"
                            onclick="Confirm('{{ $category->id }}', '{{ $category->products->count() }}','{{ $category->name }}')"
                            class="btn btn-outline" title="delete" wire:click="$refresh">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>
        {{ $categories->links() }}
    </div>
    @if($isModalOpen)
    {{--dd($isModalOpen)--}}
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-lg mx-4">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $selected_id ? 'Editar Categoría' : 'Nueva Categoría' }}
            </h2>

            <form wire:submit.prevent="{{ $selected_id ? 'updateCategory' : 'storeCategory' }}">
                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="category_name" type="text" placeholder="Ej. Cursos"
                        class="input input-bordered input-info mt-1 w-full" wire:model.lazy="name" />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                    <input type="file" wire:model="image" id="image"
                        class="file-input file-input-bordered file-input-accent w-full mt-1">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}">
                        {{ $selected_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    window.Confirm = function(id, products, categoryname) {
        if (products > 0) {
            Swal.fire({
                title: 'No se puede eliminar la categoría',
                text: 'Tiene productos existentes',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: `¿Estás seguro de eliminar la categoría "${categoryname}"?`,
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
    Livewire.on('category-added', (data) => {
        //console.log('Category Added Event Data:', data); // Verifica qué se está recibiendo
        if (data && data.name) {
            Swal.fire({
                icon: "success",
                iconColor: "#0ca152", //color verde oscuro
                title: `La categoría "${data.name}"se agregó con exito!`,
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
    Livewire.on('category-updated', (data) => {
        if (data && data.name) {
            Swal.fire({
                icon: "success",
                iconColor: "#0c4ca1", //color Azul oscuro
                title: `La categoría "${data.name}" se actualizó con exito!`,
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            console.error(
                'Los datos recibidos del evento Livewire "categoría actualizada" no tienen el formato esperado.',
                data);
        }
    });

    Livewire.on('category-deleted', (data) => {
        if (data && data.name) {
            Swal.fire({
                icon: "error",
                title: `La categoría "${data.name}" se ha eliminado!`,
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
    Livewire.on('category-not-found', (data) => {
        if (data && data.name) {
            Swal.fire({
                icon: "error",
                title: `La categoría "${data.id}" no se encuentra!`,
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