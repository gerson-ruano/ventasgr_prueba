@if($totalPrice > 0)
<div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4 flex-grow h-auto sm:w-30
    card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">

    <div class="card simple-title-task ui-sortable-handle mt-2">
        <div class="flex items-center justify-center space-x-2">
            <h1 class="ml-4 font-bold"> Q.</h1>
            <input type="number" id="cash" wire:model="efectivo" wire:keydown.enter.prevent="savesSale"
                class="input input-bordered input-info w-full max-w-xs" step="1.00">
        </div>
    </div>
    @if($totalPrice > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1">
        {{--<button id="clearCart" class="btn btn-sm btn-primary text-xs mb-1 mr-1 lg:mt-1">
            <i class="fas fa-trash"></i>Artículos (F4)
        </button>
        <button id="clearCash" class="btn btn-sm  btn-primary text-xs mb-1 mr-1">
            <i class="fas fa-dollar-sign"></i>Efectivo (F8)
        </button>
        --}}
        <button wire:click="clearCart" class="btn btn-sm btn-primary text-xs mb-1 mr-1 lg:mt-1">
            <i class="fas fa-trash"></i>Artículos (F4)
        </button>
        <button id="clearCash" class="btn btn-sm  btn-primary text-xs mb-1 mr-1">
            <i class="fas fa-dollar-sign"></i>Efectivo (F8)
        </button>

        <button wire:click="clearChange" class="btn btn-sm btn-primary text-xs mb-1">
            <i class="fas fa-backspace"></i>Limpiar (F8)
        </button>
        @endif
    </div>
</div>
@endif
