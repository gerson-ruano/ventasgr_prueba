<div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mt-1 mb-1 mr-1 ml-1">
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        <button class="btn btn-accent ml-4" wire:click="openModal">Nuevo Producto</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="py-2 px-4 text-center">No.</th>
                    <th class="py-2 px-4 text-left">Barcode</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-left">Categoria</th>
                    <th class="py-2 px-4 text-left">Precio</th>
                    <th class="py-2 px-4 text-left">Stock</th>
                    <th class="py-2 px-4 text-left">Inv Minimo</th>
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
                    <td class="py-2 px-4 text-left">{{ $product->alerts }}</td>
                    <td class="py-2 px-4 text-center">
                        <img src="{{ $product->imagen }}" alt="Imagen de {{ $product->name }}"
                            class="rounded h-20 w-20 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-info mr-2" wire:click="edit({{ $product->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline btn-danger"
                            onclick="Confirm('{{ $product->id }}','0','PRODUCTOS','{{ $product->name }}')"
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
                    <th class="py-2 px-4 text-left">Barcode</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-left">Categoria</th>
                    <th class="py-2 px-4 text-left">Precio</th>
                    <th class="py-2 px-4 text-left">Stock</th>
                    <th class="py-2 px-4 text-left">Inv Minimo</th>
                    <th class="py-2 px-4 text-center">Imagen</th>
                    <th class="py-2 px-4 text-center">Acción</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
    @include('livewire.products.form')
</div>