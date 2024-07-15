<label class="input input-info input-sm w-full max-w-xs flex items-center gap-2">
    <input id="search-input" type="text" minlength="1" maxlength="5" @if(isset($model)) wire:model.live="{{ $model }}"
        @endif name="busqueda" class="grow" placeholder="{{ $placeholder }}" />
    @if(isset($model))
    <i class="fas fa-search"></i>
    @else
    <i class="fas fa-barcode"></i>
    @endif
</label>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('search-input');

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            const barcode = event.target.value.trim();
            console.log('Código obtenido:', barcode);

            // Emit the event to Livewire
            window.Livewire.dispatch('scan-code', {
                barcode
            });
            // Clear the input after sending the code
            event.target.value = '';
        }
    });
});
</script>