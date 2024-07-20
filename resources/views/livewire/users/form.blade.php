@if($isModalOpen)
<div class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
    <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-1/3">
        <h2 class="text-lg font-semibold mb-4 text-center">
            {{ $selected_id ? 'Editar Usuario' : 'Nuevo  Usuario' }}
        </h2>

        <form wire:submit.prevent="{{ $selected_id ? 'update' : 'store' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="nombre" type="text" placeholder="Ej. Juan"
                        class="input input-bordered input-info mt-1 w-full" wire:model="name" />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono</label>
                    <input id="telefono" type="text" placeholder="Ej. 1234 2345"
                        class="input input-bordered input-info mt-1 w-full" wire:model="phone" />
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo
                        Electronico</label>
                    <input id="correo" type="email" placeholder="Ej. admin@gmail.com"
                        class="input input-bordered input-info mt-1 w-full" wire:model="email" />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" type="password" placeholder="Ej. ********" autocomplete="off"
                        class="input input-bordered input-info mt-1 w-full" wire:model="password" />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>



                <div class="mb-4">
                    <label for="select_status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select wire:model="status" id="select_status"class="select select-info w-full">
                        <option value="Elegir" selected>Elegir</option>
                        <option value="Active" selected>Activado</option>
                        <option value="Locked" selected>Boqueado</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="select_role" class="block text-sm font-medium text-gray-700">Asignar Role</label>
                    <select wire:model="profile" id="select_role" class="select select-info w-full">
                        <option value="Elegir" selected>Elegir</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" selected>{{$role->name}}</option>
                        @endforeach
                    </select>
                    @error('profile') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
                    @if ($image)
                    <div class="flex justify-center mb-2">
                        <img src="{{ $image->temporaryUrl() }}" alt="Imagen de {{ $name }}"
                            class="h-20 w-20 object-cover">
                    </div>
                    @elseif ($imageUrl)
                    <div class="flex justify-center mb-2">
                        <img src="{{ $imageUrl }}" alt="Imagen de {{ $name }}" class="h-20 w-20 object-cover">
                    </div>
                    @endif

                    <input type="file" wire:model.live="image" id="image"
                        class="file-input file-input-bordered file-input-accent w-full mt-1">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}">
                    {{ $selected_id ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif
