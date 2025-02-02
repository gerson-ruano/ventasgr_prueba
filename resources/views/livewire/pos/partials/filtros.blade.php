<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-0 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        <livewire:components.searchbox :placeholder="'Ingrese Codigo Producto'" />
    </div>

    {{--<div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
    </div>--}}

    <div class="flex flex-row space-x-2 w-full mb-2">
        <div class="w-1/2">
            @include('livewire.components.select_filtro', [
                'default' => 'Elegir',
                'val_default' => 0,
                'title' => 'Estado de Pago',
                'model' => 'tipoPago',
                'valores' => $valores
            ])
        </div>

        <div class="w-1/2">
            @include('livewire.components.select_filtro', [
                'default' => 'Cliente',
                'val_default' => 0,
                'title' => 'Vendedor o Cliente',
                'model' => 'vendedorSeleccionado',
                'valores' => $vendedores,
            ])
        </div>

    </div>

    <div class="flex flex-row space-x-2 w-full mb-2">
        <div class="w-1/2">
            @include('livewire.components.select_filtro', [
                'default' => 'Elegir',
                'val_default' => 0,
                'title' => 'Tipo de Pago',
                'model' => 'tipoPago',
                'valores' => ''
            ])
        </div>

        <div class="w-1/2">
            @include('livewire.components.select_filtro', [
                'default' => 'Cliente',
                'val_default' => 0,
                'title' => 'Vendedor o Cliente',
                'model' => 'vendedorSeleccionado',
                'valores' => $vendedores,
            ])
        </div>

    </div>


</div>
