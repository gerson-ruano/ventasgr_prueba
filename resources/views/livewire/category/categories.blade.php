<div>
    <!-- Header Section -->
    <div class="text-center">
        <h3 class="card-title text-center">
            <b>{{ $componentName }} | {{ $pageTitle }}</b>
        </h3>
    </div>

    <!-- Tabs Section -->
    <div class="text-center">
        <button class="btn btn-info mb-2" wire:click="openModal">Nueva Categoría</button>
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
                        <button class="btn btn-accent" wire:click="editCategory({{ $category->id }})"><i
                                class="fas fa-edit"></i></button>
                        {{--<button class="btn btn-outline"
                            wire:click="deleteConfirmation('{{ $category->id }}',
                        '{{ $category->products->count() }}')">
                        <i class="fas fa-trash-alt"></i>
                        </button>--}}

                        <a href="javascript:void(0)"
                            onclick="Confirm('{{ $category->id }}', '{{ $category->products->count() }}')"
                            class="btn btn-dark" title="delete">
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
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-1/3 h-1/3">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $selected_id ? 'Editar Categoría' : 'Nueva Categoría' }}</h2>

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
                    <button type="button" class="btn btn-ghost mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $selected_id ? 'btn-success' : 'btn-info' }}">
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
    window.Confirm = function(id, products) {
        if (products > 0) {
            Swal.fire({
                title: 'No se puede eliminar la categoría',
                text: 'Tiene productos existentes',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarla!"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('categories', 'deleteRow', id);
                Swal.close()

            }
        });
    }
});
</script>
