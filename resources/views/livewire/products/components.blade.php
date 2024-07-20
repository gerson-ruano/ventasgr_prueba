<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox :model="'search'" />
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'openModal', 'title' => $componentName])
    </div>

    <!-- Table Section -->
    @if (count($products) > 0)
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-7xl mx-auto">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="py-2 px-4 text-center">No.</th>
                    <th class="py-2 px-4 text-left">Barcode</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-left">Categoria</th>
                    <th class="py-2 px-4 text-left">Precio</th>
                    <th class="py-2 px-4 text-left">Stock</th>
                    <th class="py-2 px-4 text-center">Inv Minimo</th>
                    <th class="py-2 px-4 text-center">Imagen</th>
                    <th class="py-2 px-4 text-center">Acción</th>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-left">{{ $product->barcode }}</td>
                    <td class="py-2 px-4 text-left">{{ $product->name }}</td>
                    <td class="py-2 px-4 text-left">{{ $product->category->name }}</td>
                    <td class="py-2 px-4 text-left">{{ $product->price }}</td>
                    <td class="py-2 px-4 text-left">{{ $product->stock }}</td>
                    <td class="py-2 px-4 text-center">{{ $product->alerts }}</td>
                    <td class="py-2 px-4 text-center">
                        <img src="{{ $product->imagen }}" alt="Imagen de {{ $product->name }}"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <div class="flex flex-col sm:flex-row items-center justify-center">
                            <button class="btn btn-sm btn-info mr-0 sm:mr-2 mb-2 sm:mb-0"
                                wire:click="edit({{ $product->id }})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline btn-danger"
                                onclick="Confirm('{{ $product->id }}','{{ $componentName}}','{{ $product->name }}')"
                                title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-base-100 dark:bg-gray-800">
                <tr>
                    <th class="py-2 px-4 text-center">No.</th>
                    <th class="py-2 px-4 text-left">Barcode</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-left">Categoria</th>
                    <th class="py-2 px-4 text-left">Precio</th>
                    <th class="py-2 px-4 text-left">Stock</th>
                    <th class="py-2 px-4 text-center">Inv Minimo</th>
                    <th class="py-2 px-4 text-center">Imagen</th>
                    <th class="py-2 px-4 text-center">Acción</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
    @else
        <!-- Mostrar notificación cuando no hay resultados -->
        @include('livewire.components.no-results', ['result' => $products ,'name' => $componentName])
    @endif
    @include('livewire.products.form')
</div>
