{{--<label class="input input-bordered flex items-center gap-2">
    <input type="text" id="search-input" wire:model.live="{{ $model ?? '' }}" name="busqueda" class="grow"
placeholder="{{ $placeholder }}" />
<i class="fas fa-search"></i>
</label>--}}

<label class="input input-bordered input-sm w-full max-w-xs flex items-center gap-2">
    <input id="search-input" type="text" @if(isset($model)) wire:model.live="{{ $model }}" @endif name="busqueda"
        class="grow" placeholder="{{ $placeholder }}" />
    <i class="fas fa-search"></i>
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

{{--<script>
    document.addEventListener('livewire:init', function() {
        const input = document.getElementById('search-input');

        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const barcode = event.target.value.trim();
                console.log('Código obtenido:', barcode);

                const model = "{{ isset($model) ? $model : '' }}";
                if (model !== '') {
                    Livewire.on('scan-code', barcode);
                    console.log('Enviado por Livewire:', barcode);
                } else {
                    console.log('No fue enviado por Livewire:', barcode);
                    Livewire.on('scan-code', barcode);
                }

                event.target.value = '';
            }
        });
    });
</script>--}}