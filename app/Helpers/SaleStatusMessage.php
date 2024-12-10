<?php

if (!function_exists('getSaleStatusMessage')) {
    function getSaleStatusMessage($saleNumber)
    {
        $sale = \App\Models\Sale::with('details')->find($saleNumber);

        if (!$sale) {
            return '"en proceso.."';
        }

        // Verifica el estado de la venta
        if ($sale->status === 'PENDING') {
            return '"pendiente de pago"';
        }

        // Nuevo estado: 'CANCELLED' (Cancelado)
        if ($sale->status === 'CANCELLED') {
            return '"anulada"';
        }

        // Si no es 'PENDING' ni 'CANCELLED', se considera 'pagado'
        return '"pagada"';
    }
}
