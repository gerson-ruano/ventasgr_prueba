<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-4 mb-1 mr-1 ml-1">
        <div class="mr-2">
            <livewire:components.searchbox :model="'search'"/>
        </div>
        <h4 class="font-bold text-2xl mr-2">
            {{ $componentName }} | {{ $pageTitle }}
        </h4>
        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'openModal', 'icon' => 'plus', 'title' => $componentName])
    </div>
    <!-- Table Section -->
    @if (count($companies) > 0)
        <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-5xl mx-auto">
            <table class="table_custom">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>NIT</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $index => $company)
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td>
                            {{ ($companies->currentPage() - 1) * $companies->perPage() + $index + 1 }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->address }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->phone }}</td>
                        <td>{{ $company->nit }}</td>
                        <td>
                            <img src="{{ $company->imagen }}" alt="Imagen de {{ $company->name }}"
                                 class="rounded-lg h-12 w-12 object-cover mx-auto">
                        </td>
                        <td>
                            <div class="flex flex-col sm:flex-row items-center justify-center">
                                <button class="btn btn-sm btn-info mr-0 sm:mr-2 mb-2 sm:mb-0"
                                        wire:click="edit({{ $company->id }})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger"
                                        onclick="Confirm('{{ $company->id }}','{{ $componentName }}','{{ $company->name }}','COMPAÑIAS')"
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
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>NIT</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
                </tfoot>
            </table>

            <div class="mt-4">
                {{ $companies->links() }}
            </div>
        </div>
    @else
        @include('livewire.components.no-results', ['result' => $companies ,'name' => $componentName])
    @endif
    @include('livewire.companies.form')
</div>
