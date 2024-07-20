<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        <livewire:components.searchbox :placeholder="'Ingrese Codigo'" />
    </div>

    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        @include('livewire.components.select_filtro', [
            'default' => 0,
            'title' => 'Tipo Pago',
            'model' => 'tipoPago',
            'valores' => $valores
        ])
    </div>

    <div class="flex flex-col items-stretch mb-2 mr-2 ml-2 mt-1 w-full">
        @include('livewire.components.select_filtro', [
            'default' => 0,
            'title' => 'Tipo Cliente',
            'model' => 'vendedorSeleccionado',
            'valores' => $vendedores
        ])
    </div>
</div>
