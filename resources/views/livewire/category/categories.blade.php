<div>
    <!-- Header Section -->
    <div class="text-center">
        <h4 class="font-bold text-center">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
    </div>

    <!-- Tabs Section -->
    <div class="text-right">
        <button class="btn btn-accent mr-2 mb-2" wire:click="openModal">Nueva Categoría</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-left">Descripción</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Imagen</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-left">{{ $category->name }}</td>
                    <td class="py-2 px-4 text-center">
                        <img src="{{ $category->imagen }}" alt="Imagen de {{ $category->name }}"
                            class="rounded h-20 w-20 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-info mr-2" wire:click="editCategory({{ $category->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline btn-danger"
                            onclick="Confirm('{{ $category->id }}', '{{ $category->products->count() }}','CATEGORÍA','{{ $category->name }}')"
                            title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-base-100 dark:bg-gray-800">
                <tr>
                    <th class="py-2 px-4 text-center">No.</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-center">Imagen</th>
                    <th class="py-2 px-4 text-center">Acción</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

    @if($isModalOpen)
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
    
});
</script>