<div class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
    <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-lg mx-4">
        <h2 class="text-lg font-semibold mb-4 text-center">
            <b>{{ $selected_id ? 'Editar Venta' : 'Venta' }}</b>
        </h2>

        <form wire:submit="{{ $selected_id ? 'update' : 'store' }}">

            <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full ">

                @include('livewire.components.select_filtro', [
                            'default' => 'Elegir',
                            'val_default' => "Elegir",
                            'title' => 'Estado',
                            'model' => 'selectedStatus',
                            'valores' => $valoresPago
                        ])
            </div>


            <div class="flex justify-center mt-4">
                <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}">
                    {{ $selected_id ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
