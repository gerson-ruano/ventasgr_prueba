{{--<label class="input input-bordered flex items-center gap-2 ">
    <input type="text" wire:model="search" class="grow" placeholder="Busqueda" />
    <i class="fas fa-search"></i>
</label>--}}

<label class="input input-bordered flex items-center gap-2">
    <input type="text" wire:model.debounce.300ms="search" class="grow" placeholder="Búsqueda" />
    <i class="fas fa-search"></i>
</label>