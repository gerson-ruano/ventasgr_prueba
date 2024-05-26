{{--<div
    x-data="{ open: @entangle('isOpen') }"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen p-4 text-center sm:block sm:p-0">
        <!-- Modal overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <!-- Modal content -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Your modal content goes here -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                            Categorias
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Your modal content...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" @click="open = false" class="w-full px-4 py-2 mt-3 font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cerrar
                </button>
                <!-- Additional buttons -->
            </div>
        </div>
    </div>
</div>



<div>
    <!-- Botón para abrir el modal -->
    <button class="btn btn-primary" wire:click="openModal">Abrir Modal</button>

    <!-- Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>

            <div class="bg-white p-6 rounded-lg shadow-lg z-10">
                <h2 class="text-lg font-semibold mb-4">Título del Modal</h2>
                <p class="mb-4">Contenido del modal...</p>
                <button class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
            </div>
        </div>
    @endif
</div>


<div>
    <!-- Botón para abrir el modal -->
    <button class="btn btn-primary" wire:click="openModal">Abrir Modal</button>
    @if ($isOpen)
    <dialog id="my_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-center">Categorías | Agregar</h3>
            <div class="modal-action flex justify-center">
                <form method="dialog">
                    <div class="form-control">
                        <label for="category_name" class="label">Nombre:</label>
                        <input id="category_name" type="text" placeholder="Ej. Cursos"
                            class="input input-bordered input-info" wire:model.lazy="name" />
                        @error('name') <span class="text-danger">{{$message}}</span>@enderror
</div>

<div class="form-control mt-3">
    <label for="category_image" class="label">Imagen:</label>
    <input type="file" class="file-input file-input-bordered file-input-accent w-full max-w-xs" wire:model="image"
        accept="image/x-png, image/gif, image/jpg" onchange="return false;" />
    <label for="category_image" class="label">Imagen: {{$image}}</label>
    @error('image') <span class="text-danger">{{$message}}</span>@enderror
</div>

<div class="modal-footer text-center">
    <button type="button" class="btn btn-default" wire:click="closeModal">Cancelar</button>
    <button type="submit" class="btn btn-success">Guardar</button>
</div>
</form>
</div>
</div>
</dialog>
@endif
</div>--}}


@if($isOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50"></div>
        <div class="bg-white p-8 rounded-lg shadow-lg z-10 w-1/3 h-auto">
            <h2 class="text-lg font-semibold mb-4 text-center">{{ $title }}</h2>
            <div>{!! $content !!}</div>
            <div class="flex justify-end mt-4">
                <button type="button" class="btn btn-ghost mr-2" wire:click="closeModal">Cancelar</button>
            </div>
        </div>
    </div>
@endif

