<div class="text-center mt-1">
    <div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 mr-2 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">
        <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
            <div class="flex flex-col items-stretch ml-2 w-full md:w-2/3">
                <select id="category_index" wire:model.debounce.500ms="searchField"
                        class="select select select-info w-full">
                    <option value="">Seleccionar</option>
                    <option value="prefix">Prefijo</option>
                    <option value="number">No. Documento</option>
                    <option value="reference_code">Cod. Referencia</option>
                    <option value="names">Nombre Cliente</option>
                    <option value="identification">Identificación</option>
                </select>
                @error('index')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <input
                type="text"
                wire:model.debounce.500ms="searchTerm"
                wire:keydown.enter="index"
                class="input input-bordered w-full max-w-xs mt-0 ml-2 mr-2"
                placeholder="prefix, cliente, número, identificación o referencia">
            <button wire:click="index" class="btn btn-info">
                <i class="fas fa-exchange-alt mr-1"></i>Actualizar
            </button>
        <div class="btn-group ml-2">
        @include('livewire.components.button_add', ['color' => 'success' ,'model' => 'crear', 'icon' => 'plus', 'title' => "Agregar factura"])
        </div>
            {{--}}@include('livewire.components.button_add', ['color' => 'primary' ,'model' => 'validar', 'icon' => 'check-double', 'title' => "buscar factura"])--}}
            {{--}}@include('livewire.components.button_add', ['color' => 'info' ,'model' => 'buscar', 'icon' => 'search', 'title' => "Buscar factura"])--}}
        </div>

    </div>
    <div class="align flex-row border overflow-x-auto bg-base-200 rounded-lg shadow-lg mx-auto ml:mb-1 ml:ml-2 lg:ml-2 lg:mr-2">
        @if ($datos)
            <div class="border overflow-x-auto bg-base-200 rounded-lg shadow-lg w-full mx-auto mb-2">
                <table class="table table-xs">
                    <thead class="bg-base-200 dark:bg-gray-800">
                    <tr>
                        <th class="text-lg font-medium py-3 px-4 text-center">#</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">ID</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Documento</th>
                        <th class="text-lg font-medium py-3 px-4 text-left">Codigo de Referencia</th>
                        <th class="text-lg font-medium py-3 px-4 text-left">Cliente</th>
                        <th class="text-lg font-medium py-3 px-4 text-left">Identificación</th>
                        <th class="text-lg font-medium py-3 px-4 text-left">Fecha de Validación</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Estado</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($datos as $key => $item)
                        <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                            <td class="py-2 px-4 text-center">{{ $key+1 }}</td>
                            <td class="py-2 px-4 text-center">{{ $item['id'] }}</td>
                            <td class="py-2 px-4 text-center">{{ $item['number'] }}</td>
                            <td class="py-2 px-4 text-left">
                                    <span
                                        class="badge {{ $item['reference_code'] == null ? 'badge-warning'  : 'badge-white'}} text-uppercase">
                                        {{ $item['reference_code'] == null ? 'Sin codigo de referencia' : $item['reference_code'] }}
                                    </span>
                            </td>
                            <td class="py-2 px-4 text-left">{{ $item['api_client_name'] }}</td>
                            <td class="py-2 px-4 text-left">{{ $item['identification'] }}</td>
                            <td class="py-2 px-4 text-left">
                                    <span
                                        class="badge {{ $item['created_at'] == null ? 'badge-warning'  : 'badge-white'}} text-uppercase">
                                        {{ $item['created_at'] == null ? 'Sin fecha de Validación' : $item['created_at'] }}
                                    </span>
                            </td>
                            <td class="py-2 px-4 text-center">
                                    <span
                                        class="{{ $item['status'] == '0' ? 'bg-yellow-400' : 'bg-green-500' }} inline-block w-4 h-4 rounded-full"></span>
                            </td>
                            <td class="py-2 px-4 text-center">
                                <div class="flex flex-row items-center justify-center space-x-2">
                                    <button class="btn btn-sm btn-success" title="Validar"
                                            wire:click="validates('{{ $item['number'] }}')"
                                            @if ( $item['status'] == '1') disabled @endif>
                                        @if ($item['status'] == 1)
                                            <i class="fas fa-check-double text-green-500"></i>
                                        @else
                                            <i class="fas fa-check text-gray-500"></i>
                                        @endif
                                    </button>
                                    <button class="btn btn-sm btn-info" title="Detalles"
                                            wire:click="show('{{ $item['number'] }}')"><i
                                            class="fas fa-indent mr-1"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-4 px-4 text-center">No se encontraron resultados...</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="flex justify-center items-center mt-4 mb-2">
                    @foreach ($pagination as $link)
                        @if (isset($link['page']))
                            @if ($link['active'])
                                <span class="btn btn-sm btn-info mx-1">
                                        {{ $loop->last ? 'Última' : $link['label'] }}
                                    </span>
                            @else
                                <button wire:click="index({{ $link['page'] }})" class="btn btn-sm btn-outline btn-info mx-1">
                                    {{ $loop->last ? 'Última' : $link['label'] }}
                                </button>
                            @endif
                        @elseif ($link['label'] === '...')
                            <span class="btn btn-sm btn-disabled mx-1">...</span>
                        @endif
                    @endforeach
                </div>
                @include('livewire.api.form')
                @endif
            </div>
    </div>
</div>


