<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox />
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        <button class="btn btn-accent ml-4" wire:click="openModal">Nueva Categoría</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-5xl mx-auto">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-left">Descripcion</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Imagen</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                {{--dd($categories)--}}
                <!-- Mostrar notificación cuando no hay resultados -->
                @include('livewire.components.no-results', ['result' => $categories ,'name' => $componentName])

                @foreach($categories as $index => $category)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-left">{{ $category->name }}</td>
                    <td class="py-2 px-4 text-center">
                        <img src="{{ $category->imagen }}" alt="Imagen de {{ $category->name }}"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-sm btn-info mr-2" wire:click="edit({{ $category->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline btn-danger"
                            onclick="Confirm('{{ $category->id }}','{{ $componentName }}','{{ $category->name }}','{{ $category->products->count() }}','PRODUCTOS', )"
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
    @include('livewire.category.form')
</div>