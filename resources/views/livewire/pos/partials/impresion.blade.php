{{--<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">--}}
@php
$totalProduct = count($cart);
//dd($cart);
@endphp

@if($itemsQuantity > 0) 
<!-- Impresion Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 flex-grow h-auto sm:w-30 card 
        bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">

    <div class="card simple-title-task ui-sortable-handle mt-2">
        <div class="flex items-center justify-center space-x-2">

            <div class="d-flex align-items-center mb-1">
                @if($vendedorSeleccionado != 0)
                <h6>Nombre: {{$vendedorSeleccionado}}</h6>
                @else
            </div>
            <div class="d-flex align-items-center mb-1">
                <h6 class="mb-0">Nombre:</h6>
                <h6 class="text-primary mb-0" style="margin-left: 10px;"> C/F</h6>
            </div>
            @endif
            @if($tipoPago != 0)
            <h6>Pago: {{$tipoPago}}</h6>
            @else
            <div class="d-flex align-items-center">
                <h6 class="text-center mb-0">Pago:</h6>
                <h6 class="text-danger mb-0" style="margin-left: 10px;">INGRESAR PAGO!!</h6>
            </div>
            @endif

        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 mt-1">
        <div class="text-right">
            @if($efectivo == 0 || is_null($efectivo))
            <h6 class="text-danger">INGRESAR! EFECTIVO</h6>
            @else
            <h6>Efectivo: Q {{number_format($efectivo, 2)}}</h6>
            @endif
            @if($totalPrice > 0)
            <h6 class="">Total: Q {{ number_format($totalPrice, 2) }}</h6>
            <input type="hidden" id="hiddenTotal" value="{{$totalPrice}}">
            @if($change > 0)
            <h6 class="">Cambio: Q {{ number_format($change, 2) }}</h6>
            @elseif($change == 0)
            <h6 class="text-muted">SIN CAMBIO</h6>
            @else
            <h6 class="text-danger">Falta Q {{ number_format(-$change, 2) }}</h6>
            @endif
            <h6 class="">Productos: {{ $totalProduct }}</h6>
            <h6 class="">Artículos: {{ $itemsQuantity }}</h6>
            @else
            <h6 class="text-muted">No hay productos en la venta</h6>
            @endif
        </div>
    </div>

    <div class="grid flex-grow grid-cols-1 sm:grid-cols-2  place-items-center">
        <button wire:click="saveSale" class="btn btn-info d-print-none mr-1 mb-1">Finalizar Venta</button>

        <button wire:click="revisarVenta" class="btn btn-accent d-print-none mb-1" @if ($tipoPago==0 || $efectivo <
            $totalPrice) disabled @endif>Detalles Venta</button>
    </div>

</div>
@endif