@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-1/3">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $customer_data ? 'Editar Cliente' : 'Nuevo Cliente' }}
            </h2>

            <form wire:submit.prevent="{{ $customer_data ? 'updateCustomer' : 'saveCustomer' }}">

                <div class="flex flex-col sm:flex-row sm:space-x-2 w-full mb-2 items-center">
                    <div class="w-full sm:w-1/2 mb-2 sm:mb-0">
                        @include('livewire.components.select_filtro', [
                            'default' => 'Seleccionar',
                            'val_default' => 0,
                            'title' => 'Metodo de Pago',
                            'model' => 'customer_method_page',
                            'valores' => $pagos,
                        ])
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label for="customer_name"
                               class="block text-sm font-medium text-gray-700 text-center">Nombre</label>
                        <input id="customer_name" type="text" placeholder="Nombre del cliente"
                               class="input input-bordered input-info w-full mt-1"
                               wire:model.live="customer_name">
                        @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row sm:space-x-2 w-full mb-2 items-center">
                    <div class="w-full sm:w-1/2 mb-2 sm:mb-0">
                        <label for="customer_nit"
                               class="block text-sm font-medium text-gray-700 text-center">NIT</label>
                        <input id="customer_nit" type="text" placeholder="Ingrese NIT"
                               class="input input-bordered input-info w-full mt-1"
                               wire:model.live="customer_nit">
                        @error('customer_nit') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    <div class="w-full sm:w-1/2">
                        <label for="customer_address"
                               class="block text-sm font-medium text-gray-700 text-center">Dirección</label>
                        <input id="customer_adress" type="text" placeholder="Dirección del cliente"
                               class="input input-bordered input-info w-full mt-1"
                               wire:model.live="customer_address">
                        @error('customer_address') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>
                @if ($customer_method_page > 1 && $customer_method_page < 4 )
                    <div class="w-full text-center mt-2">
                        <label for="ref_page" class="block text-sm font-medium text-gray-700">Referencia de
                            Pago</label>
                        <input id="ref_page" type="text" placeholder="referencia de pago"
                               class="input input-bordered input-info w-full mt-1 sm:max-w-xs"
                               wire:model="customer_ref_page">
                        @error('customer_ref_page') <span
                            class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                @endif

                <div class="flex justify-center mt-4 flex-wrap gap-2">
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
