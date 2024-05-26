<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailsList = document.querySelectorAll('details');
        
        // Event listener para cerrar el details al hacer clic en cualquier parte de la página
        document.addEventListener('click', function(event) {
            detailsList.forEach(function(details) {
                if (details.open && !details.contains(event.target)) {
                    details.open = false;
                }
            });
        });

        // Event listener para gestionar el comportamiento de apertura y cierre de los detalles
        detailsList.forEach(function(details) {
            details.addEventListener('toggle', function() {
                if (details.open) {
                    detailsList.forEach(function(otherDetails) {
                        if (otherDetails !== details && otherDetails.open) {
                            otherDetails.open = false;
                        }
                    });
                }
            });
        });
    });
</script>
