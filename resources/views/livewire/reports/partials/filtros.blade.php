<div
    class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-4 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-1 lg:mb-1 lg:ml-1 lg:mr-0">


    <div class="flex flex-col items-stretch mr-2 ml-2 mt-1 w-full">
        <div class="mt-0 mb-0 mr-2 ml-2 flex flex-col items-center">
            <label for="users_select"
                   class="text-center block text-sm font-medium text-gray-700 mb-1">Users</label>
            <select wire:model.live.users" id="users_select"
                    class="select select-sm select-info w-full max-w-xs">
                <option value="0" selected>Elegir</option>
                @if($users)
                    @foreach ($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name}}</option>
                    @endforeach
                @endif
            </select>
            @error("users") <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{--}}@include('livewire.components.select_filtro', [
                    'default' => 0,
                    'title' => 'Usuarios',
                    'model' => 'userId',
                    'valores' => $users
                ])--}}
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

    <div class="text-center">
        <button wire:click="$refresh" id="" class="btn btn-accent text-xs mb-1 mr-1">
            <i class="fas fa-dollar-sign"></i>Consultar
        </button>

        <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }}"
           href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
           target="_blank">Generar PDF</a>

        <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }} mb-3"
           href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
           target="_blank">Exportar a EXCEL</a>

    </div>
</div>

