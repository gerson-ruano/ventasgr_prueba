@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/3 max-h-full overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $selected_id ? 'Editar Documento' : 'Validar Documento' }}
            </h2>

            <form wire:submit.prevent="{{ $selected_id ? 'update' : 'store' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Datos de FACTURA -->
                    <div class="mb-4">
                        <label for="category_reference_code" class="block text-sm font-medium text-gray-700">Codigo Ref.</label>
                        <input id="category_reference_code" type="text" placeholder="12345931AT"
                               class="input input-bordered input-info mt-1 w-full" wire:model.debounce.500ms="reference_code" />
                        @error('reference_code') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_observation" class="block text-sm font-medium text-gray-700">Descripcion</label>
                        <input id="category_obsevation" type="text" placeholder="especificaciones de la venta"
                               class="input input-bordered input-info mt-1 w-full" wire:model.debounce.500ms="observation" />
                        @error('observation') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>


                    @foreach ($items as $index => $item)
                        <div class="mb-4">
                            <label for="product_name_{{ $index }}" class="block text-sm font-medium text-gray-700">Producto</label>
                            <input id="product_name_{{ $index }}" type="text" placeholder="Ej. Producto"
                                   class="input input-bordered input-info mt-1 w-full"
                                   wire:model.debounce.500ms="items.{{ $index }}.name" />
                            @error("items.{$index}.name") <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    @endforeach

                    <!-- Resto de campos aquí -->
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}"
                            wire:loading.attr="disabled">
                        {{ $selected_id ? 'Actualizar' : 'Validar' }}
                    </button>
                </div>
                <div wire:loading wire:target="{{ $selected_id ? 'update' : 'store' }}" class="text-center mt-4">
                    <span class="text-gray-500">Procesando...</span>
                </div>
            </form>
        </div>
        @if (session('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif
