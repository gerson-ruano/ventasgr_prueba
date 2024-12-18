<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-1 lg:mb-1 lg:ml-1 lg:mr-0">


    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">

        @include('livewire.components.select_filtro', [
                    'default' => 'Elegir',
                    'val_default' => 0,
                    'title' => 'Usuarios',
                    'model' => 'userid',
                    'valores' => $users
                ])
    </div>


    <!-- Fecha Desde Selector -->
    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full md:w-2/3 mb-2">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha desde</h6>
            <div class="form-control">
                <input type="text" wire:model="fromDate" class="input input-bordered text-center flatpickr"
                       @if(empty($userid))
                           placeholder="Cierre de HOY"
                       disabled
                       @else
                           placeholder="Hoy o seleccionar"
                    @endif>
            </div>
            <!-- Mensaje de error si 'fromDate' es mayor que la fecha actual -->
            @if($errors->has('fromDateError'))
                <p class="text-red-600 text-center">{{ $errors->first('fromDateError') }}</p>
            @endif
        </div>
    </div>

    <!-- Fecha Hasta Selector -->
    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full md:w-2/3 mb-2">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha hasta</h6>
            <div class="form-control">
                <input type="text" wire:model="toDate" class="input input-bordered text-center flatpickr"
                       @if(empty($fromDate))
                           placeholder="Cierre de HOY"
                       disabled
                       @else
                           placeholder="Hoy o seleccionar"
                    @endif>
            </div>
            <!-- Mensaje de error si la fecha 'Desde' es mayor que 'Hasta' -->
            @if($errors->has('toDateError'))
                <p class="text-red-600 text-center">{{ $errors->first('toDateError') }}</p>
            @endif
        </div>
    </div>


    <!-- Buttons -->
    {{--}}<div class="flex flex-wrap justify-center space-y-2 md:space-y-0 md:space-x-2">
        <button wire:click.prevent="Consultar()" class="btn btn-accent text-xs mb-1"
                @if (empty($sales)) disabled @endif>
            <i class="fas fa-paper-plane"></i> Consultar
        </button>
    </div>--}}

    <!-- Buttons PDF / EXCEL -->
    <div class="flex flex-wrap justify-center space-y-2 md:space-y-0 md:space-x-2">
        <button wire:click.prevent="Consultar()" class="btn btn-accent text-xs mb-1"
                @if (empty($sales)) disabled @endif>
            <i class="fas fa-paper-plane"></i> Consultar
        </button>

        @if($userid && $fromDate && $toDate)
            <a class="btn btn-primary"
               href="{{ url('report/box' . '/' . $userid . '/' . $fromDate . '/' . $toDate) }}"
               target="_blank"><i class="fas fa-file-pdf"></i>
                Generar PDF
            </a>

            <a class="btn btn-primary mb-3"
               href="{{ url('report-excel' . '/' . $userid . '/' . $fromDate . '/' . $toDate) }}"
               target="_blank"><i class="fas fa-file-excel"></i>
                Exportar a EXCEL
            </a>
        @endif

    </div>
</div>
