{{--<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">--}}

@php
    $totalProduct = count($cart);
@endphp

@if($itemsQuantity > 0)
    <!-- Impresion Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-2 flex-grow h-auto sm:w-30 card
        bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">

        <div class="flex items-center space-x-2 text-xs leading-tight py-4">
            <label id="salenumber" name="salenumber" class="font-medium">Venta No.</label>
            <h5 class="text-md font-bold">{{ $nextSaleNumber }}</h5>
        </div>

        <div class="text-xs leading-tight card simple-title-task ui-sortable-handle">
            <div class="flex items-center justify-center space-x-1">
                <!-- Sección de Vendedor -->
                <div class="d-flex align-items-center mb-1 mr-2">
                    @if($vendedorSeleccionado != 0)
                        <div class="flex items-center space-x-2">
                            <label id="namevendedor" name="namevendedor" class="font-medium">Nombre:</label>
                            <h6 class="font-bold"> {{getNameSeller($vendedorSeleccionado)}}</h6>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <h6>Nombre:</h6>
                            <h6 class="text-blue-500 mb-0">C/F</h6>
                        </div>
                    @endif
                </div>
                <!-- Sección de Pago -->
                <div class="d-flex align-items-center mb-1">

                    @if($tipoPago != 0)
                        <div class="flex items-center space-x-2">
                            <label id="namepago" name="namepago" class="font-medium">Pago:</label>
                            <h6 class="font-bold"> {{$this->obtenerTipoPago($tipoPago)}}</h6>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <h6>Pago:</h6>
                            <h6 class="text-red-500 mb-0">INGRESAR PAGO!!</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @include('livewire.components.empresa_header', ['empresa' => $empresa])

        <div class="text-xs leading-tight grid grid-cols-2 sm:grid-cols-3 mt-2 lg:grid-cols-1 py-0">
            <div class="text-right">
                @if($efectivo == 0 || is_null($efectivo))
                    <h6 class="text-red-500 mb-0">INGRESAR! EFECTIVO</h6>
                @else
                    <h6>Efectivo: Q {{number_format($efectivo, 2)}}</h6>
                @endif
                @if($totalPrice > 0)
                    <h6 class="">Total: Q {{ number_format($totalPrice, 2) }}</h6>
                    <input type="hidden" id="hiddenTotal" value="{{$totalPrice}}">
                    @if($change > 0)
                        <h6 class="">Cambio: Q {{ number_format($change, 2) }}</h6>
                    @elseif($change == 0)
                        <h6 class="">SIN CAMBIO</h6>
                    @else
                        <h6 class="text-red-400 mb-0">Falta Q {{ number_format(-$change, 2) }}</h6>
                    @endif
                    <h6 class="">Productos: {{ $totalProduct }}</h6>
                    <h6 class="">Artículos: {{ $itemsQuantity }}</h6>
                @else
                    <h6 class="text-muted">No hay productos en la venta</h6>
                @endif
            </div>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:place-items-center sm:justify-center items-center mt-4 mb-2">
            <button wire:click="saveSaleAndPrint" class="btn btn-info d-print-none mb-1 w-full sm:w-auto">Finalizar Venta
            </button>
            <button wire:click="revisarVenta" class="btn btn-accent d-print-none mb-1 w-full sm:w-auto"
                    @if ($tipoPago==0 || $efectivo < $totalPrice) disabled @endif>
                Detalles Venta
            </button>
            <a href="#" class="btn btn-primary w-full sm:w-auto mb-1" onclick="openPdfWindow('{{ route('report.venta', ['change' => $change, 'efectivo'=> $efectivo,'seller' => getNameSeller($vendedorSeleccionado), 'nextSaleNumber' => $nextSaleNumber]) }}')"
               @if ($tipoPago==0 || $efectivo < $totalPrice)
                disabled
            @endif>
                Imprimir
            </a>
        </div>
    </div>
@endif
