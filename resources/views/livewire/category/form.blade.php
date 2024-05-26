
{{--@include('partials.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">

                    </span>
                </span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej. cursos">
        </div>
        @error('name') <span class="text danger er">{{$message}}</span>@enderror
    </div>

    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png, image/gif, image/jpg">
            <label class="custom-file-label">Image {{$image}}</label>
            @error('image')<span class="text danger er">{{$message}}</span>@enderror
        </div>
    </div>
</div>

@include('partials.modalFooter')--}}

<form wire:submit.prevent="{{ $action }}">
    <div class="mb-4">
        <label for="category_name" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input id="category_name" type="text" wire:model.lazy="name" class="input input-bordered input-info mt-1 w-full">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Imagen</label>
        <input type="file" wire:model="image" id="image" class="file-input file-input-bordered file-input-accent w-full">
        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="flex justify-end">
        <button type="button" class="btn btn-ghost mr-2" wire:click="$emitTo('reusable-modal', 'closeModal')">Cancelar</button>
        <button type="submit" class="btn btn-success">{{ $selected_id ? 'Actualizar' : 'Guardar' }}</button>
    </div>
</form>



