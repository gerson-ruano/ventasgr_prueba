@if($isModalOpen)
<div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
    <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-1/3 max-h-full overflow-y-auto">
        <h2 class="text-lg font-semibold mb-4 text-center">
            {{ $selected_id ? 'Editar Producto' : 'Nuevo Producto' }}
        </h2>

        <form wire:submit="{{ $selected_id ? 'update' : 'store' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="category_name" type="text" placeholder="Ej. Cursos"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="name" />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_codigo" class="block text-sm font-medium text-gray-700">Código</label>
                    <input id="category_codigo" type="text" placeholder="Ej. 1234"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="barcode" />
                    @error('barcode') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_cost" class="block text-sm font-medium text-gray-700">Costo</label>
                    <input id="category_cost" type="text" placeholder="Ej. 0.00"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="cost" />
                    @error('cost') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input id="category_precio" type="text" placeholder="Ej. 0.00"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="price" />
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input id="category_stock" type="number" placeholder="Ej. 0"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="stock" />
                    @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_alerts" class="block text-sm font-medium text-gray-700">Alertas</label>
                    <input id="category_alerts" type="number" placeholder="Ej. 10"
                        class="input input-bordered input-info mt-1 w-full" wire:model.blur="alerts" />
                    @error('alerts') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="category_select" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select wire:model.live="categoryid" id="category_select" class="select select-info w-full">
                        <option value="Elegir" disabled>Elegir</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categoryid') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                    @if ($image)
                    <div class="flex justify-center mb-2">
                        <img src="{{ $image->temporaryUrl() }}" alt="Imagen de {{ $name }}"
                            class="h-20 w-20 object-cover">
                    </div>
                    @elseif ($imageUrl)
                    <div class="flex justify-center mb-2">
                        <img src="{{ $imageUrl }}" alt="Imagen de {{ $name }}" class="h-20 w-20 object-cover">
                    </div>
                    @endif

                    <input type="file" wire:model.live="image" id="image"
                        class="file-input file-input-bordered file-input-accent w-full mt-1">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
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
