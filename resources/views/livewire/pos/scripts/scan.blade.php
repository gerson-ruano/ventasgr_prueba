<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('search-input');

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                const barcode = event.target.value.trim();
                //console.log('Código obtenido:', barcode);

                //Emit the event to Livewire
                window.Livewire.dispatch('scan-code', {
                    barcode
                });
                // Clear the input after sending the code
                event.target.value = '';
            }
        });
    });

    /*document.addEventListener("DOMContentLoaded", () => {
        console.log("🔄 DOM cargado. Iniciando escáner...");
        iniciarEscaner();
    });

    document.addEventListener("livewire:load", () => {
        console.log("✅ Livewire ha cargado. Iniciando escáner...");
        iniciarEscaner();
    });

    document.addEventListener("livewire:updated", () => {
        console.log("🔄 Livewire ha actualizado el DOM. Reiniciando escáner...");
        iniciarEscaner();
    });

    function iniciarEscaner() {
        if (typeof onScan === "undefined") {
            console.error("⚠️ onScan.js NO está disponible. Verifica su carga en Vite.");
            return;
        }

        onScan.attachTo(document, {
            suffixKeyCodes: [13], // Enter después del código escaneado
            onScan: function (barcode) {
                console.log("✅ Código escaneado:", barcode);
                Livewire.dispatch("scan-code", barcode);
            },
            onScanError: function (e) {
                console.warn("⚠️ Error de escaneo:", e);
            },
        });

        console.log("✅ Scanner Ready desde Vite!");
    }*/
</script>


