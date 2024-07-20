<div>
    <!-- Header Section -->
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <h4 class="font-bold text-2xl mr-2">
            {{ $componentName }}
        </h4>
        <div class="ml-4">
            {{--<label for="role_select" class="text-center block text-sm font-medium text-gray-700">Rol</label>--}}
            <select wire:model.live="role" id="role_select" name="role_select" class="select select-info w-full">
                <option value="Elegir" selected>== Seleccione el Rol ==</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error("role") <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <button class="btn btn-accent ml-4" wire:click.prevent="SyncAll">Sincronizar Todos<i
                class="fas fa-thumbs-up"></i></button>
        <button class="btn btn-warning ml-4" wire:click="Removeall">Revocar Todos <i
                class="fas fa-thumbs-down"></i></button>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-base-300 p-4 rounded-lg shadow-lg max-w-7xl mx-auto">
        <table class="table-auto w-full">
            <thead class="bg-base-300 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-2 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Permiso</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Asignar</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Roles con el Permiso</th>
                    <th class="text-lg font-medium py-2 px-4 text-center">Total Permisos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permisos as $index => $permiso)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ ($permisos->currentPage() - 1) * $permisos->perPage() + $index + 1 }}
                    </td>
                    <td class="text-center">
                        <span class="label-text ml-1">{{ $permiso->name }}</span>
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center items-center">
                            <label class="cursor-pointer label">
                                <input type="checkbox" class="checkbox checkbox-info"
                                    wire:change="syncPermiso($event.target.checked, '{{ $permiso->name }}' )"
                                    id="permiso_{{ $permiso->id }}" name="permiso_{{ $permiso->id }}"
                                    value="{{ $permiso->id }}" {{ $permiso->checked ? 'checked' : '' }}>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        @foreach ($roles as $role)
                        @if ($rolePermissionsCount[$role->id] > 0)
                        <span class="label-text ml-1">{{ $role->name }} ({{ $rolePermissionsCount[$role->id] }})</span>
                        @endif
                        @endforeach
                    </td>
                    <td class="text-center">
                        {{ $rolePermissionsCount[$role->id] ?? 0 }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-base-100 dark:bg-gray-800">
                <tr>
                    <th class="py-2 px-4 text-center">No.</th>
                    <th class="py-2 px-4 text-center">Permiso</th>
                    <th class="py-2 px-4 text-center">Asignar</th>
                    <th class="py-2 px-4 text-center">Roles con el Permiso</th>
                    <th class="py-2 px-4 text-center">Total Permisos</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            {{ $permisos->links() }}
        </div>
    </div>
</div>