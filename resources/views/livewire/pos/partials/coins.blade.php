
<div
    class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-2 flex-grow h-auto card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
    <h5 class="text-center font-bold">BILLETES</h5>
    <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-3 xl:grid-cols-4 gap-1 flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
    @foreach ($denominations as $d)
    <div class="mt-2 mb-2 mr-2 ml-2">
        <button wire:click.prevent="ACash({{ $d->value }})" class="btn btn-info btn-block">
            {{ $d->value > 0 ? 'Q ' . number_format($d->value, 2, '.', '') : 'Exacto' }}
        </button>
    </div>
    @endforeach
    </div>
</div>