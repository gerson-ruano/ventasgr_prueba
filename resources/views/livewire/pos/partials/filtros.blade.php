<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 sm:mb-1 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        <livewire:components.searchbox :placeholder="'Ingrese Codigo Producto'"/>
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
                'title' => 'Vendedor',
                'model' => 'vendedorSeleccionado',
                'valores' => $vendedores,
            ])
        </div>

    </div>

    <div class="flex flex-row space-x-2 w-full mb-2 items-center">
        <div class="w-1/2">
            @include('livewire.components.select_filtro', [
                'default' => 'Efectivo',
                'val_default' => 0,
                'title' => 'Metodo de Pago',
                'model' => '',
                'valores' => $pagos,
            ])
        </div>
        <div class="w-1/2">
            <label for="category_cliente"
                   class="block text-sm font-medium text-gray-700 text-center">Nombre</label>
            <input id="category_cliente" type="text" placeholder="Nombre del cliente"
                   class="input input-bordered input-info mt-1 max-w-xs"
                   wire:model.live="cliente"
                   @if($vendedorSeleccionado != 0) disabled @endif>
            @error('cliente') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

    </div>
    <div class="flex flex-row space-x-2 w-full mb-2 items-center">
        <div class="w-full sm:w-1/2 text-center">
            <label for="category_nit" class="block text-sm font-medium text-gray-700">Nit</label>
            <input id="category_nit" type="text" placeholder="Ingrese NIT"
                   class="input input-bordered input-info mt-1 sm:max-w-xs text-center"
                   wire:model="nit">
            @error('nit') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="w-full sm:w-1/2 text-center sm:mt-0">
            <label for="category_otro" class="block text-sm font-medium text-gray-700">Otro</label>
            <input id="category_otro" type="text" placeholder="Nombre del cliente"
                   class="input input-bordered input-info mt-1 sm:max-w-xs text-center"
                   wire:model.debounce.500ms="otros">
            @error('otros') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
    </div>

</div>
