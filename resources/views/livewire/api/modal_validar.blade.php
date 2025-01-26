@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">
        <div
            class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/3 max-h-full overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $selected_id ? 'Editar Documento' : 'Validar Documento' }}
            </h2>

            <form wire:submit.prevent="{{ $selected_id ? 'buscar' : 'validates' }}">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">

                    <div class="mb-4 text-center">
                        <input type="text" wire:model.debounce.500ms="document_number" placeholder="Ingrese número de documento"
                               class="input input-bordered input-info mt-1 w-full"/>
                        @error('document_number') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{--}}<button type="button" wire:click="validates(document_number)">Validar</button>--}}


                    <!-- Resto de campos aquí -->
                </div>

                <div class="flex justify-center mt-4">
                    <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}"
                            wire:loading.attr="disabled">
                        {{ $selected_id ? 'buscar' : 'Validar' }}
                    </button>
                </div>
                <div wire:loading wire:target="{{ $selected_id ? 'store' : 'validates' }}" class="text-center mt-4">
                    <span class="text-gray-500">Procesando...</span>
                </div>
            </form>
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

    </div>
@endif
