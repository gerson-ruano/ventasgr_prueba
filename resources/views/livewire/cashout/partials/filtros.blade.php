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
    <div class="flex flex-col items-stretch w-full md:w-1/3">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha desde</h6>
            <div class="form-control">
                <input type="text" wire:model="fromDate" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if ($userid == 0) disabled @endif>
            </div>
        </div>
    </div>

    <!-- Fecha Hasta Selector -->
    <div class="flex flex-col items-stretch w-full md:w-1/3">
        <div class="w-full">
            <h6 class="text-lg font-medium text-gray-700 text-center">Fecha hasta</h6>
            <div class="form-control">
                <input type="text" wire:model="toDate" class="input input-bordered flatpickr"
                       placeholder="Click para elegir" @if (empty($fromDate))disabled @endif>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex flex-wrap justify-center space-y-2 md:space-y-0 md:space-x-2">
        <button wire:click.prevent="Consultar()" class="btn btn-accent text-xs mb-1">
            <i class="fas fa-paper-plane"></i> Consultar
        </button>
    </div>
</div>
