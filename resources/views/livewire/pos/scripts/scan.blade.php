{{--}}
    try {
        onScan.attachTo(document, {
        suffixKeyCodes: [13],
        onScan: function(barcode){
            console.log(barcode)
            Livewire.dispatch('scan-code', barcode)
        },
        onScanError: function(e){
            console.log(e)
        }
    })
        console.log(' Scanner Ready¡')

    } catch (e) {
        console.log('Error de lectura: ', e)
    }--}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
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
    }
</script>


