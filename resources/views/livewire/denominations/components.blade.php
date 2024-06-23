<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox />
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        <button class="btn btn-accent ml-4" wire:click="openModal">Nueva Denominación</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-5xl mx-auto">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-left">Tipo</th>
                    <th class="text-lg font-medium py-2 px-4 text-left">Valor</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Imagen</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coins as $index => $coin)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($coins->currentPage() - 1) * $coins->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-left">{{ $coin->type }}</td>
                    <td class="py-2 px-4 text-left">Q {{ number_format($coin->value, 2) }}</td>
                    <td class="py-2 px-4 text-center">
                        <img src="{{ $coin->imagen }}" alt="Imagen de {{ $coin->name }}"
                            class="rounded h-20 w-20 object-cover mx-auto">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-info mr-2" wire:click="edit({{ $coin->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline btn-danger"
                            onclick="Confirm('{{ $coin->id }}', '','DENOMINACIÓN','{{ $coin->type }}')"
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
                    <th class="py-2 px-4 text-left">Tipo</th>
                    <th class="py-2 px-4 text-left">Valor</th>
                    <th class="py-2 px-4 text-center">Imagen</th>
                    <th class="py-2 px-4 text-center">Acción</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $coins->links() }}
        </div>
    </div>
    @include('livewire.denominations.form')
</div>