{{--<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">--}}

@php
    $totalProduct = count($cart);
@endphp

@if($itemsQuantity > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 bg-base-300 rounded-box p-4 m-2">
        <!-- Información de la Venta -->
        <div class="flex flex-col space-y-2">
            <!-- Información de la Empresa -->
            {{--}}@include('livewire.components.empresa_header', ['empresa' => $empresa])--}}
            <!-- Button de agregar CLIENTE -->
            @if($vendedorSeleccionado == 0)
                <div class="flex flex-row flex-wrap justify-center items-center gap-2 mr-2">
                    @if(!empty($customer_data))
                        @include('livewire.components.button_add', ['color' => 'info' ,'model' => 'openModal', 'icon' => 'edit', 'title' => 'Cliente'])
                        @include('livewire.components.button_add', ['color' => 'error' ,'model' => 'deleteCustomer', 'icon' => 'trash', 'title' => 'Cliente'])
                    @else
                        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'openModal', 'icon' => 'plus', 'title' => 'Cliente'])
                    @endif
                </div>
            @endif
            <!-- Numero de venta -->
            <div class="p-2 bg-white rounded shadow">
                <div class="flex items-center justify-between">
                    <span class="font-medium">Venta No:</span>
                    {{--}}<h3 class="text-lg font-bold">{{ $nextSaleNumber }}</h3>--}}
                    <h6 class="font-bold {{ $nextSaleNumber == 0 ? 'text-red-500' : 'text-black' }}">
                        {{ $nextSaleNumber == 0 ? 'INGRESAR NUMERO DE VENTA!!' : $nextSaleNumber }}
                    </h6>
                </div>
            </div>

            <!-- Estado de Pago -->
            <div class="p-2 bg-white rounded shadow">
                <div class="flex items-center justify-between">
                    <span class="font-medium">Estado de Pago:</span>
                    <h6 class="font-bold {{ $tipoPago == 0 ? 'text-red-500' : 'text-black' }}">
                        {{ $tipoPago == 0 ? 'INGRESE ESTADO DE PAGO!!' : $this->obtenerTipoPago($tipoPago) }}
                    </h6>
                </div>
            </div>

            <!-- Información del Cliente o Vendedor -->
            <div class="p-2 bg-white rounded shadow">
                @if($vendedorSeleccionado != 0)
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Vendedor:</span>
                        <h6 class="font-bold">{{ getNameSeller($vendedorSeleccionado) }}</h6>
                    </div>
                @else
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Cliente:</span>
                        {{-- $customer_data['name'] ?? 'INGRESE CLIENTE' --}}
                        <h6 class="font-bold {{ $customer_data['name'] ?? 'text-red-500' }}">
                            {{ $customer_data['name'] ?? 'INGRESE CLIENTE!!' }}
                        </h6>
                    </div>
                @endif
            </div>

            <!-- Datos de la venta -->
            @if(!empty($customer_data))
                <div class="p-2 bg-gray-100 rounded text-center">
                    <div class="flex justify-between">
                        <strong>Metodo de Pago:</strong>
                        <p>{{ $this->obtenerMetodoPago($customer_data['method_page'])}}
                    </div>
                    <div class="flex justify-between">
                        <strong>Ref. de Pago:</strong>
                        <p>{{ $customer_data['ref_page'] ?? 'N/A'}}
                    </div>
                    <div class="flex justify-between">
                        <strong>NIT:</strong>
                        <p>{{ $customer_data['nit'] ?? 'N/A' }}
                    </div>
                    <div class="flex justify-between">
                        <strong>Dirección:</strong>
                        <p>{{ $customer_data['address'] ?? 'N/A' }}
                    </div>
                </div>
            @endif

        </div>

        <!-- Información Financiera -->
        <div class="p-2 bg-white rounded shadow space-y-1">
            <div class="flex justify-between">
                <span>Ingresado:</span>
                <span class="{{ $efectivo == 0 ? 'text-red-500' : '' }}">
                    Q {{ number_format($efectivo, 2) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span>Total:</span>
                <span>Q {{ number_format($totalPrice, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Cambio:</span>
                <span class="{{ $change < 0 ? 'text-red-400' : '' }}">
                    {{ $change == 0 ? 'SIN CAMBIO' : 'Q ' . number_format(abs($change), 2) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span>Productos:</span>
                <span>{{ $totalProduct }}</span>
            </div>
            <div class="flex justify-between">
                <span>Cantidad:</span>
                <span>{{ $itemsQuantity }}</span>
            </div>
            <div class="border-t mt-1 pt-1">
                <div class="flex justify-between">
                    <span>IVA (12%):</span>
                    <span>Q {{ number_format($totalTaxes, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Descuento:</span>
                    <span>Q {{ number_format($discount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>Q {{ number_format($totalPrice - $discount - $totalTaxes, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span>Q {{ number_format($totalPrice, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 w-full mt-4">
            <button wire:click="saveSaleAndPrint" class="btn btn-info w-full sm:w-auto">
        <span class="flex items-center justify-center space-x-2">
            <i class="fas fa-cart-plus"></i>
            <span>Finalizar Venta</span>
        </span>
            </button>

            <a href="#"
               class="btn btn-print w-full sm:w-auto label-text"
               onclick="openPdfWindow('{{ route('report.venta', ['change' => $change, 'efectivo'=> $efectivo, 'seller' => getNameSeller($vendedorSeleccionado), 'nextSaleNumber' => $nextSaleNumber, 'totalTaxes' => $totalTaxes, 'discount' => $discount, 'customer_data' => urlencode(json_encode($customer_data))]) }}')"
               @if ($tipoPago == 0 || $efectivo < $totalPrice) disabled @endif>
        <span class="flex items-center justify-center space-x-2">
            <i class="fas fa-print"></i>
            <span>Detalles de Venta</span>
        </span>
            </a>
        </div>

    </div>
@endif

