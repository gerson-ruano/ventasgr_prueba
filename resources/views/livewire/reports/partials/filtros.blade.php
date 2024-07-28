<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-1 lg:mb-1 lg:ml-1 lg:mr-0">


    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        @include('livewire.components.select_filtro', [
                            'default' => 0,
                            'title' => 'Elige Usuario',
                            'model' => 'userId',
                            'valores' => $users
                        ])
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
                            'title' => 'Tipo de Reporte',
                            'model' => 'reportType',
                            'valores' => $valoresVentas
                        ])
    </div>
    <div class="flex flex-col items-stretch mb-2 mr-2 ml-2 mt-1 w-full">
        <div class="w-full mt-2">
            <h6 class="text-lg font-medium">Fecha desde</h6>
            <div class="form-control">
                <input type="text" wire:model="dateFrom" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if ($reportType==0) disabled @endif>
            </div>
        </div>
        <div class="w-full mt-2">
            <h6 class="text-lg font-medium">Fecha hasta</h6>
            <div class="form-control">
                <input type="text" wire:model="dateTo" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if ($reportType==0) disabled @endif>
            </div>
        </div>

    </div>
</div>

