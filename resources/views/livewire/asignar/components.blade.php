<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <h4 class="font-bold text-2xl mr-2">
            {{ $componentName }}
        </h4>
        <div class="ml-4">
            <select wire:model.live="role" id="role_select" name="role_select" class="select select-info w-full">
                <option value="Elegir" selected>== Seleccione el Rol ==</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error("role") <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Selector de Módulos -->
        <div class="ml-4">
            <select wire:model.live="moduleSelected" class="select select-info w-full">
                <option value="all">Todos los Módulos</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->description }}</option>
                @endforeach
            </select>
        </div>
        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'syncAllFromModule','icon' => 'check-circle', 'title' => 'Asignar Modulo'])
        @include('livewire.components.button_add', ['color' => 'primary' ,'model' => 'SyncAll','icon' => 'universal-access', 'title' => 'Asignar Todos'])
        @include('livewire.components.button_add', ['color' => 'warning' ,'model' => 'Removeall','icon' => 'times-circle', 'title' => 'Revocar Todos'])
    </div>

    <!-- Table Section -->
    @if (count($permisos) > 0)
        <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-7xl mx-auto">
            <table class="table-auto w-full">
                <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Módulo</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Permiso</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Asignar</th>
                    {{--}}<th class="text-lg font-medium py-2 px-4 text-center">Roles con el Permiso</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($permisos as $index => $permiso)
                    @php
                        $modulo = $permiso->modules->first()->name ?? 'N/A';
                        $isChecked = $permiso->checked ?? false;
                    @endphp
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td class="py-2 px-4 text-center">
                            {{ ($permisos->currentPage() - 1) * $permisos->perPage() + $index + 1 }}
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $isChecked ? 'badge-info' : 'badge-' }}">
                                {{ ucfirst($modulo) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="label-text ml-1">{{ explode('.', $permiso->name)[1] ?? '' }}</span>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center items-center">
                                <label class="cursor-pointer label">
                                    <input type="checkbox" class="checkbox checkbox-info"
                                           wire:change="syncPermiso($event.target.checked, '{{ $permiso->name }}')"
                                           value="{{ $permiso->id }}" {{ $isChecked ? 'checked' : '' }}>
                                </label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $permisos->links() }}
            </div>
        </div>
    @else
        @include('livewire.components.no-results', ['result' => $permisos ,'name' => $componentName])
    @endif
</div>
