<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
    <div class="mb-0 mr-2 ml-2 mt-2">
        <livewire:components.searchbox :placeholder="'Ingrese Codigo'" />
    </div>
    @include('livewire.components.select_filtro', [
        'default' => 'Elegir',
        'title' => 'Tipo Pago',
        'model' => 'tipoPago',
        'valores' => $valores
    ])

    @include('livewire.components.select_filtro', [
        'default' => '0',
        'title' => 'Tipo Cliente',
        'model' => 'vendedorSeleccionado',
        'valores' => $vendedores
    ])
    
</div>