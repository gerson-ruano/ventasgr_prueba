<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
        <livewire:components.searchbox />
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        <button class="btn btn-accent ml-4" wire:click="openModal">Nuevo Permiso</button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-5xl mx-auto">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Descripción</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Mostrar notificación cuando no hay resultados -->
                @include('livewire.components.no-results', ['result' => $permisos ,'name' => $componentName])
                @foreach($permisos as $index => $permiso)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($permisos->currentPage() - 1) * $permisos->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-center">{{ $permiso->name }}</td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-info mr-2" wire:click="edit({{ $permiso->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline btn-danger"
                            onclick="Confirm('{{ $permiso->id }}', '','PERMISOS','{{ $permiso->name }}')"
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
                    <th class="py-2 px-4 text-center">Descripción</th>
                    <th class="py-2 px-4 text-center">Acción</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $permisos->links() }}
        </div>
    </div>
    @include('livewire.permisos.form')
    
</div>
