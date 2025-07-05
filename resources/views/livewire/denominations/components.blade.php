<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox :placeholder="'Ingrese Valor'" :model="'search'"/>
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'openModal', 'icon' => 'plus','title' => $componentName])
    </div>

    <!-- Table Section -->
    @if (count($coins) > 0)
        <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-5xl mx-auto">
            <table class="table_custom">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coins as $index => $coin)
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td>
                            {{ ($coins->currentPage() - 1) * $coins->perPage() + $index + 1 }}</td>
                        <td>{{ $coin->type }}</td>
                        <td>Q {{ number_format($coin->value, 2) }}</td>
                        <td>
                            <img src="{{ $coin->imagen }}" alt="Imagen de {{ $coin->name }}"
                                 class="rounded-lg h-12 w-12 object-cover mx-auto">
                        </td>
                        <td>
                            <div class="flex flex-col sm:flex-row items-center justify-center">
                                <button class="btn btn-sm btn-info mr-0 sm:mr-2 mb-2 sm:mb-0"
                                        wire:click="edit({{ $coin->id }})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger"
                                        onclick="Confirm('{{ $coin->id }}','{{ $componentName }}','{{ $coin->type }}')"
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
                    <th>No.</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
                </tfoot>
            </table>
            <div class="mt-4">
                {{ $coins->links() }}
            </div>
        </div>
    @else
        <!-- Mostrar notificación cuando no hay resultados -->
        @include('livewire.components.no-results', ['result' => $coins ,'name' => $componentName])
    @endif
    @include('livewire.denominations.form')
</div>
