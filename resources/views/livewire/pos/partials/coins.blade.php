<div
    class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-2 flex-grow h-auto sm:h-30 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
    <h5 class="text-center font-bold">BILLETES</h5>
    <div
        class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-3 xl:grid-cols-4 gap-1 flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
        @foreach ($denominations as $d)
            @if ($d->value > 0)
                <div class="mt-2 mb-2 mr-2 ml-2">
                    <button wire:click.prevent="ACash({{ $d->value }})" class="btn btn-info btn-block text-xs">
                        {{$currency}} {{ number_format($d->value, 2, '.', '') }}
                    </button>
                </div>
            @endif
        @endforeach

        <!-- Botón Exacto Independiente -->
        <div class="mt-2 mb-2 mr-2 ml-2">
            <button wire:click.prevent="ACash(0)"
                class="btn btn-primary btn-block text-xs {{ $efectivo >= $totalPrice ? 'btn-disabled opacity-50' : '' }}"
                {{ $efectivo >= $totalPrice ? 'disabled' : '' }}>
                {{$currency}} Exacto
            </button>
        </div>
    </div>

</div>
