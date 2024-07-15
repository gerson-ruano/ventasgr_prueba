<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox :model="'search'" />
        </div>
        <h4 class="font-bold text-2xl">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        <button class="btn btn-accent ml-4" wire:click="openModal">Nuevo Rol</button>
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
                @include('livewire.components.no-results', ['result' => $roles ,'name' => $componentName])
                @foreach($roles as $index => $rol)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($roles->currentPage() - 1) * $roles->perPage() + $index + 1 }}</td>
                    <td class="py-2 px-4 text-center">{{ $rol->name }}</td>
                    <td class="py-2 px-4 text-center">
                        <div class="flex flex-col sm:flex-row items-center justify-center">
                            <button class="btn btn-sm btn-info mr-0 sm:mr-2 mb-2 sm:mb-0"
                                wire:click="edit({{ $rol->id }})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline btn-danger"
                                onclick="Confirm('{{ $rol->id }}','{{ $componentName }}','{{ $rol->name }}')" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
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
            {{ $roles->links() }}
        </div>
    </div>
    @include('livewire.roles.form')
</div>