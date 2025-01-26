@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">
        <div
            class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/3 max-h-full overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4 text-center">
                {{ $selected_id ? 'Editar Documento' : 'Buscar Documento' }}
            </h2>

            <!-- Formulario para buscar el documento -->
            <form wire:submit.prevent="bill">
                <div class="grid grid-cols-1 xs:grid-cols-1 gap-2">
                    <div class="mb-4 text-center">
                        <input type="text" wire:model.debounce.500ms="document_number"
                               placeholder="Ingrese número de documento"
                               class="input input-bordered input-info mt-1 w-full"/>
                        @error('document_number') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Mensajes de éxito o error -->
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

                <!-- Resultados de la búsqueda -->
                @if (!empty($factura))
                    <div class="mt-6 border-t pt-4 mt-1">
                        <div class="flex flex-col w-full lg:flex-row lg:space-y-0 mt-1">
                            <!--div class="divider lg:divider-horizontal"></div-->
                            <div class="lg:w-3/4 text-left">
                                <p class="text-left"><strong>Cliente:</strong> {{ $factura['customer']['names'] }}</p>
                                <p><strong>Identificación:</strong> {{ $factura['customer']['identification'] }}</p>
                                <p><strong>Cliente:</strong> {{ $factura['customer']['names'] }}</p>
                                <p><strong>Dirección:</strong> {{ $factura['customer']['address'] }}</p>
                                <p><strong>Correo:</strong> {{ $factura['customer']['email'] }}</p>
                                <p><strong>Telefono:</strong> {{ $factura['customer']['phone'] }}</p>
                                <p><strong>Organización:</strong> {{ $factura['customer']['legal_organization']['name'] }}
                                </p>
                                <p><strong>Tributo:</strong> {{ $factura['customer']['tribute']['name'] }}</p>
                                <p><strong>Municipio:</strong> {{ $factura['customer']['municipality']['name'] }}</p>
                            </div>

                            <p><strong>Factura:</strong> {{ $factura['items']['code_reference'] }}</p>
                            <p><strong>Documento:</strong> {{ $factura['items']['name'] }}</p>
                            <p><strong>Cantidad:</strong> {{ $factura['items']['quantity'] }}</p>
                            <p><strong>Descuento Rate:</strong> {{ $factura['items']['discount_rate'] }}</p>
                            <p><strong>Descuento:</strong> {{ $factura['items']['discount'] }}</p>
                            <p><strong>Documento:</strong> {{ $factura['items']['name'] }}</p>

                            <div class="lg:w-3/4 text-left">
                                <!-- BILL -->
                                <p><strong>Factura:</strong> {{ $factura['bill']['id'] }}</p>
                                <p><strong>Documento:</strong> {{ $factura['bill']['document']['name'] }}</p>
                                <p><strong>Numero:</strong> {{ $factura['bill']['number'] }}</p>
                                <p><strong>Codigo de Referencia:</strong> {{ $factura['bill']['reference_code'] }}</p>
                                <p><strong>Numero:</strong> {{ $factura['bill']['status'] }}</p>
                                <!--p><strong>Envio de Email:</strong> {{ $factura['bill']['send_email'] }}</p-->
                                <!--p><strong>Qr:</strong> {{ $factura['bill']['qr'] }}</p-->
                                <!--p><strong>Cufe:</strong> {{ $factura['bill']['cufe'] }}</p-->
                                <p><strong>Validacion:</strong> {{ $factura['bill']['validated'] }}</p>
                                <p><strong>Descuento Rate:</strong> {{ $factura['bill']['discount_rate'] }}</p>
                                <p><strong>Descuento:</strong> {{ $factura['bill']['discount'] }}</p>
                                <p><strong>Impuesto:</strong> {{ $factura['bill']['tax_amount'] }}</p>
                                <p><strong>Total:</strong> {{ $factura['bill']['total'] }}</p>
                                <p><strong>Observación:</strong> {{ $factura['bill']['observation'] }}</p>
                                <p><strong>Creación:</strong> {{ $factura['bill']['created_at'] }}</p>
                                <!--p><strong>qr imagen:</strong> {{ $factura['bill']['qr_image'] }}</p-->
                                <p><strong>Forma de Pago:</strong> {{ $factura['bill']['payment_form']['name'] }}</p>
                                <p><strong>Metodo de Pago:</strong> {{ $factura['bill']['payment_method']['name'] }}</p>

                            </div>
                        </div>




                        {{--}}<div class="space-y-2 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- CUSTOMER -->
                            <p><strong>Cliente:</strong> {{ $factura['customer']['names'] }}</p>
                            <p><strong>Identificación:</strong> {{ $factura['customer']['identification'] }}</p>
                            <p><strong>Cliente:</strong> {{ $factura['customer']['names'] }}</p>
                            <p><strong>Dirección:</strong> {{ $factura['customer']['address'] }}</p>
                            <p><strong>Correo:</strong> {{ $factura['customer']['email'] }}</p>
                            <p><strong>Telefono:</strong> {{ $factura['customer']['phone'] }}</p>
                            <p><strong>Organización:</strong> {{ $factura['customer']['legal_organization']['name'] }}
                            </p>
                            <p><strong>Tributo:</strong> {{ $factura['customer']['tribute']['name'] }}</p>
                            <p><strong>Municipio:</strong> {{ $factura['customer']['municipality']['name'] }}</p>
                            <!-- NUMBERING -->
                            <p><strong>Rango de numero:</strong> {{ $factura['numbering_range']['prefix'] }}</p>
                            <p><strong>De:</strong> {{ $factura['numbering_range']['from'] }}</p>
                            <p><strong>Hasta:</strong> {{ $factura['numbering_range']['to'] }}</p>
                            <p><strong>Resolución
                                    Number:</strong> {{ $factura['numbering_range']['resolution_number'] }}</p>
                            <p><strong>Fecha Inicio:</strong> {{ $factura['numbering_range']['start_date'] }}</p>
                            <p><strong>Fecha Fin:</strong> {{ $factura['numbering_range']['end_date'] }}</p>
                            <!--p><strong>Meses:</strong> {{ $factura['numbering_range']['months'] }}</p-->
                            <!-- BILL -->
                            <p><strong>Factura:</strong> {{ $factura['bill']['id'] }}</p>
                            <p><strong>Documento:</strong> {{ $factura['bill']['document']['name'] }}</p>
                            <p><strong>Numero:</strong> {{ $factura['bill']['number'] }}</p>
                            <p><strong>Codigo de Referencia:</strong> {{ $factura['bill']['reference_code'] }}</p>
                            <p><strong>Numero:</strong> {{ $factura['bill']['status'] }}</p>
                            <!--p><strong>Envio de Email:</strong> {{ $factura['bill']['send_email'] }}</p-->
                            <p><strong>Qr:</strong> {{ $factura['bill']['qr'] }}</p>
                            <p><strong>Cufe:</strong> {{ $factura['bill']['cufe'] }}</p>
                            <p><strong>Validacion:</strong> {{ $factura['bill']['validated'] }}</p>
                            <p><strong>Descuento Rate:</strong> {{ $factura['bill']['discount_rate'] }}</p>
                            <p><strong>Descuento:</strong> {{ $factura['bill']['discount'] }}</p>
                            <p><strong>Impuesto:</strong> {{ $factura['bill']['tax_amount'] }}</p>
                            <p><strong>Total:</strong> {{ $factura['bill']['total'] }}</p>
                            <p><strong>Observación:</strong> {{ $factura['bill']['observation'] }}</p>
                            <p><strong>Creación:</strong> {{ $factura['bill']['created_at'] }}</p>
                            <p><strong>qr imagen:</strong> {{ $factura['bill']['qr_image'] }}</p>
                            <p><strong>Forma de Pago:</strong> {{ $factura['bill']['payment_form']['name'] }}</p>
                            <p><strong>Metodo de Pago:</strong> {{ $factura['bill']['payment_method']['name'] }}</p>
                            <p><strong>url publica:</strong> {{ $factura['bill']['public_url'] }}</p>
                            <!-- ITEMS -->

                            <p><strong>Factura:</strong> {{ $factura['items']['code_reference'] }}</p>
                            <p><strong>Documento:</strong> {{ $factura['items']['name'] }}</p>
                            <p><strong>Cantidad:</strong> {{ $factura['items']['quantity'] }}</p>
                            <p><strong>Descuento Rate:</strong> {{ $factura['items']['discount_rate'] }}</p>
                            <p><strong>Descuento:</strong> {{ $factura['items']['discount'] }}</p>
                            <p><strong>Documento:</strong> {{ $factura['items']['name'] }}</p>


                        </div>--}}
                        <h3 class="text-lg font-bold text-center text-blue-500">Resultados de la Búsqueda</h3>
                    </div>
                @endif


                <div class="flex justify-center mt-4">
                    <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
                    <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}"
                            wire:loading.attr="disabled">
                        {{ $selected_id ? 'Actualizar' : 'Buscar' }}
                    </button>
                </div>
                <div wire:loading wire:target="bill" class="text-center mt-4">
                    <span class="text-gray-500">Procesando...</span>
                </div>
            </form>

        </div>
    </div>
@endif

