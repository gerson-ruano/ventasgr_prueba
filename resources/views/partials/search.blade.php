<label class="input input-sm w-full max-w-xs">
    <input id="code" type="text" placeholder="code" />
</label>

{{--<script>
document.addEventListener('DOMContentLoaded', function() {
    Livewire.on('scan-code', action => {
        document.getElementById('code').value = '';
    });
});
</script>--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('code');

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            const barcode = event.target.value.trim();
            console.log('Código escaneado:', barcode);

            // Emitir el evento a Livewire
            Livewire.on('scan-code', ( {barcode} ) => {
                // ...
            })

            //Livewire.on('scanCodes', barcode);
            // Limpiar el input después de enviar el código
            event.target.value = '';
        }
    });
});
</script>