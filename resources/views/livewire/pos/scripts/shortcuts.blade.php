<script>


    //console.log(window.keypress);  // Debería mostrar el objeto Keypress
    //const keyboard = new (window.Keypress.Listener)();
/***
    listener.simple_combo("f6", function() {
        livewire.dispatch('savesale')
    })

    listener.simple_combo("f8", function() {
        document.getElementById('cash').value = ''
        document.getElementById('cash').focus()
    })

    listener.simple_combo("f4", function() {
        var total = parseFloat(document.getElementById('hiddenTotal').value)
        if (total > 0) {
            ConfirmVaciarCart(0, 'clearCart', 'SEGURO DE ELIMINAR EL CARRITO?')
            //console.log(total)
        } else {
            noty('AGREGA PRODUCTOS A LA VENTA')
        }
    })
**/
    function clearCash() {
        document.getElementById('cash').value = '';
        document.getElementById('cash').focus();

        Livewire.dispatch('clearChange');
    }


    function clearCart() {
        var totalPrice = parseFloat(document.getElementById('hiddenTotal').value);
        if (totalPrice > 0) {
            ConfirmVaciarCart(0, 'clearCart', 'SEGURO DE ELIMINAR EL CARRITO?');
            //console.log(total);
        } else {
            console.log('No tiene valor total');
            //noty('AGREGA PRODUCTOS A LA VENTA');
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById("clearCash")) {
            document.getElementById("clearCash").addEventListener("click", clearCash);
        }

        if (document.getElementById("clearCart")) {
            document.getElementById("clearCart").addEventListener("click", clearCart);
        }
    });
</script>
