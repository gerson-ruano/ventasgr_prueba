<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-1 lg:mb-1 lg:ml-1 lg:mr-0">


    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">

        @include('livewire.components.select_filtro', [
                    'default' => 'Todos',
                    'val_default' => 0,
                    'title' => 'Usuarios',
                    'model' => 'userId',
                    'valores' => $users
                ])
    </div>

    <div class="flex flex-col items-stretch mb-2 mr-2 ml-2 mt-1 w-full">
        @include('livewire.components.select_filtro', [
                            'default' => 'Elegir',
                            'val_default' => 0,
                            'title' => 'Tipo de Reporte',
                            'model' => 'reportType',
                            'valores' => $valoresReporte
                        ])
    </div>
    <!-- Fecha Desde Selector -->
    <div class="flex flex-col items-stretch w-full md:w-1/3">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha desde</h6>
            <div class="form-control">
                <input type="text" wire:model="dateFrom" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if ($reportType == 0) disabled @endif>
            </div>
        </div>
    </div>

    <!-- Fecha Hasta Selector -->
    <div class="flex flex-col items-stretch w-full md:w-1/3">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha hasta</h6>
            <div class="form-control">
                <input type="text" wire:model="dateTo" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if ($reportType == 0) disabled @endif>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        @include('livewire.components.select_filtro', [
                    'default' => 'Todos',
                    'val_default' => 0,
                    'title' => 'Tipo Pago',
                    'model' => 'selectTipoEstado',
                    'valores' => $valoresPago
                ])
    </div>

    <!-- Buttons -->
    <div class="flex flex-wrap justify-center space-y-2 md:space-y-0 md:space-x-2">
        <button wire:click="$refresh" class="btn btn-accent text-xs mb-1">
            <i class="fas fa-paper-plane"></i> Consultar
        </button>

        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }}"
           href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
           target="_blank"><i class="fas fa-file-pdf"></i>
            Generar PDF
        </a>

        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }} mb-3"
           href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
           target="_blank"><i class="fas fa-file-excel"></i>
            Exportar a EXCEL
        </a>
    </div>
</div>

