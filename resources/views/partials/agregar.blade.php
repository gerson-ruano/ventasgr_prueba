<!-- Modal de Crear/Editar Categoría -->
<dialog id="theModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-center">
            <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
        </h3>
        <div class="modal-action flex justify-center">
            <form wire:submit="storeCategory">
                <div class="form-control">
                    <label for="category_name" class="label">Nombre:</label>
                    <input id="category_name" type="text" placeholder="Ej. Cursos"
                        class="input input-bordered input-info" wire:model.blur="name" />
                    @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-control mt-3">
                    <label for="category_image" class="label">Imagen:</label>
                    <input type="file" class="file-input file-input-bordered file-input-accent w-full max-w-xs"
                        wire:model.live="image" accept="image/x-png, image/gif, image/jpg" />
                    @error('image') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="modal-footer text-center mt-4">
                    <button type="button" class="btn btn-default"
                        onclick="document.getElementById('theModal').close()">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<!-- Error Modal -->
<dialog id="errorModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-center text-red-600">
            Error
        </h3>
        <div class="modal-action flex justify-center">
            <ul id="errorMessages"></ul>
            <div class="modal-footer text-center mt-4">
                <button type="button" class="btn btn-default"
                    onclick="document.getElementById('errorModal').close()">Cerrar</button>
            </div>
        </div>
    </div>
</dialog>
</div>


{{--<button class="btn btn-info" onclick="my_modal_4.showModal()">Agregar</button>

<dialog id="my_modal_4" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-center">Categorías | {{$textButton}}</h3>
<div class="modal-action flex justify-center">
    <form method="dialog">
        <div class="form-control">
            <label for="category_name" class="label">Nombre:</label>
            <input id="category_name" type="text" placeholder="Ej. Cursos" class="input input-bordered input-info"
                wire:model.blur="name" />
            @error('name') <span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="form-control mt-3">
            <label for="category_image" class="label">Imagen:</label>
            <input type="file" class="file-input file-input-bordered file-input-accent w-full max-w-xs"
                wire:model.live="image" accept="image/x-png, image/gif, image/jpg" onchange="return false;" />
            <label for="category_image" class="label">Imagen: {{$image}}</label>
            @error('image') <span class="text-danger">{{$message}}</span>@enderror
        </div>

        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" onclick="my_modal_4.close()">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
</div>
</dialog>--}}



<!-- Modal de Crear Categoría -->
{{--<x-modal name="createCategory" maxWidth="lg">
    <form wire:submit="Store">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear Categoría</h2>

            <div class="mt-4">
                <x-input-label label="Nombre" wire:model.live="name" type="text" />
            </div>
            
            <div class="mt-4">
                <x-input-label label="Imagen URL" wire:model.live="image" type="text" />
            </div>
        </div>
        
        <div class="flex justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right">
            <x-primary-button type="button" wire:click="$dispatch('closeModal')">Cancelar</x-primary-button>
            <x-primary-button type="submit">Guardar</x-primary-button>
        </div>
    </form>
</x-modal>--}}