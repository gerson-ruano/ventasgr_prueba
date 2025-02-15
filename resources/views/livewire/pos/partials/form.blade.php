@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-1/3">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $customer_data ? 'Editar Cliente' : 'Nuevo Cliente' }}
            </h2>

            <form wire:submit.prevent="{{ $customer_data ? 'updateCustomer' : 'saveCustomer' }}">

                <div class="flex flex-row space-x-2 w-full mb-2 items-center">
                    <div class="w-1/2">
                        @include('livewire.components.select_filtro', [
                            'default' => 'Seleccionar',
                            'val_default' => 0,
                            'title' => 'Metodo de Pago',
                            'model' => 'customer_method_page',
                            'valores' => $pagos,
                        ])
                    </div>
                    <div class="w-1/2">
                        <label for="customer_name"
                               class="block text-sm font-medium text-gray-700 text-center">Nombre</label>
                        <input id="customer_name" type="text" placeholder="Nombre del cliente"
                               class="input input-bordered input-info w-full mt-1 max-w-xs"
                               wire:model.live="customer_name">
                        @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                </div>
                <div class="flex flex-row space-x-2 w-full mb-2 items-center">
                    <div class="w-full sm:w-1/2 text-center">
                        <label for="customer_nit" class="block text-sm font-medium text-gray-700">Nit</label>
                        <input id="customer_nit" type="number" placeholder="Ingrese NIT"
                               class="input input-bordered input-info mt-1 sm:max-w-xs text-center"
                               wire:model.debounce.500ms="customer_nit">
                        @error('customer_nit') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="w-full sm:w-1/2 text-center sm:mt-0">
                        <label for="customer_address" class="block text-sm font-medium text-gray-700">Direcciòn</label>
                        <input id="customer_address" type="text" placeholder="Direcciòn del cliente"
                               class="input input-bordered input-info mt-1 sm:max-w-xs text-center"
                               wire:model.debounce.500ms="customer_address">
                        @error('customer_address') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="flex justify-center mt-4">
                    <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $customer_data ? 'btn-info' : 'btn-success' }}">
                        {{ $customer_data ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
        </div>
        </form>
    </div>
    </div>
@endif
