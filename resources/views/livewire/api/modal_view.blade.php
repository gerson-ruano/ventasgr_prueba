@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">
        <div
            class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/3 max-h-full overflow-y-auto">
            <h1 class="text-lg font-semibold mb-4 text-center">
                <i class="fas fa-file-invoice fa-lg mr-2"></i>{{ $selected_id ? 'Editar Factura' : 'Factura' }}
                <strong>No</strong> {{ $factura['bill']['id'] }} {{ $factura['bill']['status'] == 0 ? 'Sin Validar' : '' }}
            </h1>
            <form wire:submit.prevent="{{ $selected_id ? 'update' : 'show' }}">
                @if (!empty($factura))
                    {{--dd($factura)--}}
                    <div class="mt-6 border-t pt-4 mt-1">
                        <div class="flex flex-col w-full lg:flex-row lg:space-y-0 mt-1">
                            <div class="lg:w-3/4 text-left bordered ">
                                <p><strong>Cliente:</strong> {{ $factura['customer']['names'] ?? 'N/A' }}</p>
                                <p>
                                    <strong>Identificación:</strong> {{ $factura['customer']['identification'] ?? 'N/A' }}
                                </p>
                                <p><strong>Dirección:</strong> {{ $factura['customer']['address'] ?? 'N/A' }}</p>
                                <p><strong>Correo:</strong> {{ $factura['customer']['email'] ?? 'N/A' }}</p>
                                <p><strong>Telefono:</strong> {{ $factura['customer']['phone'] ?? 'N/A' }}</p>
                                <p>
                                    <strong>Organización:</strong> {{ $factura['customer']['legal_organization']['name'] ?? 'N/A' }}
                                </p>
                                <p><strong>Tributo:</strong> {{ $factura['customer']['tribute']['name'] ?? 'N/A' }}</p>
                                <p>
                                    <strong>Municipio:</strong> {{ $factura['customer']['municipality']['name'] ?? 'N/A' }}
                                </p><br>

                                <!-- ITEMS -->
                                {{--}}<p>
                                    <strong>Factura:</strong> {{ $factura['items'][0]['code_reference'] ?? 'Sin Codigo' }}
                                </p>
                                <p><strong>Documento:</strong> {{ $factura['items'][0]['name'] ?? 'N/A' }}</p>
                                <p><strong>Cantidad:</strong> {{ $factura['items'][0]['quantity'] ?? 'N/A' }}</p>
                                <p><strong>Descuento Rate:</strong> {{ $factura['items'][0]['discount_rate'] ?? 'N/A' }}
                                </p>
                                <p><strong>Descuento:</strong> {{ $factura['items'][0]['discount'] ?? 'N/A' }}</p>--}}
                                <p><strong>Observación:</strong> {{ $factura['bill']['observation'] ?? 'N/A' }}</p>
                                <p><strong>Forma de
                                        Pago:</strong> {{ $factura['bill']['payment_form']['name'] ?? 'N/A' }}</p>
                                <p><strong>Metodo de
                                        Pago:</strong> {{ $factura['bill']['payment_method']['name'] ?? 'N/A' }}</p>
                            </div>

                            <div class="lg:w-3/4 text-left">
                                    <!-- BILL -->
                                <div class="flex items-center space-x-1">
                                    <p class="font-bold"><strong>codigo QR</strong></p>
                                    <img src="{{ $factura['bill']['qr_image'] ?? 'N/A' }}" alt="QR Code"
                                         style="width: 150px; height: 120px;" class="ml-0">
                                </div><br>
                                <div class="flex items-center space-x-2">
                                    <p><strong>DIAN Link:</strong></p>
                                    <a class="font-bold text-blue-500" href="{{ $factura['bill']['qr'] ?? 'N/A' }}"
                                       target="_blank">{{ substr($factura['bill']['qr'], 0, 30) }}...</a>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <p><strong>Factus Link:</strong></p>
                                    <a class="font-bold text-blue-500" href="{{ $factura['bill']['public_url'] ?? 'N/A' }}"
                                       target="_blank">{{ substr($factura['bill']['public_url'], 0, 30) }}...</a>
                                </div>
                                <p><strong>Cufe:</strong> {{  substr($factura['bill']['cufe'], 0, 36) }}..</p>
                                <p><strong>Tipo de Doc:</strong> {{$factura['bill']['document']['name'] ?? 'N/A' }}</p>
                                <p><strong>Numero Documento:</strong> {{ $factura['bill']['number'] ?? 'N/A' }}</p>
                                <p><strong>Codigo de
                                        Referencia:</strong> {{ $factura['bill']['reference_code'] ?? 'N/A' }}</p>
                                <p><strong>Creación:</strong> {{ $factura['bill']['created_at'] ?? 'N/A' }}</p>
                                <p><strong>Validacion:</strong> {{ $factura['bill']['validated'] ?? 'N/A' }}</p>
                                <!--p><strong>Envio de Email:</strong> {{-- $factura['bill']['send_email'] --}}</p-->
                                {{--}}<p><strong>Numero:</strong> {{ $factura['bill']['status'] }}</p>--}}
                                {{--}}<p><strong>Tasa de Descuento:</strong> {{ $factura['bill']['discount_rate'] }}</p>
                                <p><strong>Descuento:</strong> {{ $factura['bill']['discount'] ?? 'N/A' }}</p>
                                <p><strong>Impuesto:</strong> {{ $factura['bill']['tax_amount'] ?? 'N/A' }}</p>
                                <p><strong>Total:</strong> {{ $factura['bill']['total'] ?? 'N/A' }}</p>--}}
                            </div>
                        </div>
                    </div>
                @endif
                <div wire:loading wire:target="{{ $selected_id ? 'update' : 'show' }}" class="text-center mt-4">
                    <span class="text-gray-500">Procesando...</span>
                </div>
            </form>
            <div class="flex justify-center">
                <h3 class="text-lg font-bold text-blue-500 mt-4"></h3>
                <button type="button" class="btn btn-outline ml-auto mr-2" wire:click="closeModal">Cerrar</button>
            </div>

        </div>
        @if (session('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif
