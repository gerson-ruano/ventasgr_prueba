@if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-600 bg-opacity-50">

        <div
            class="relative bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-4xl mx-4 sm:w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/3 max-h-full overflow-y-auto">

            <button type="button"
                    class="absolute top-2 right-2 btn btn-sm btn-outline btn-square"
                    wire:click="closeModal">
                ✕
            </button>

            <h4 class="text-lg font-semibold mb-4 text-center">
                <i class="fas fa-file-invoice fa-lg mr-2"></i>
                {{ $selected_id ? 'Editar Factura' : 'Nueva Factura' }}
            </h4>
            <div class="flex justify-center mb-4 space-x-4 py-2">
                {{-- Indicador de pasos --}}
                @foreach ([1, 2, 3] as $i)
                    <div class="relative w-1/3">
                        {{-- Número arriba --}}
                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-md font-semibold
                {{ $step == $i ? 'text-blue-600' : 'text-gray-400' }}">
                            {{ $i }}
                        </div>

                        {{-- Barra de progreso --}}
                        <div class="{{ $step >= $i ? 'bg-blue-500' : 'bg-gray-300' }} h-2 mx-1 rounded"></div>
                    </div>
                @endforeach
            </div>

            <form wire:submit.prevent="{{ $selected_id ? 'update' : 'store' }}">
                <!-- PASO 1: Datos de Factura -->
                @if($step === 1)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm"><span class="text-red-500 font-bold mr-1">*</span>Código Ref. Factura</label>
                            <input type="text" class="input input-bordered input-info w-full" placeholder="Ej. 12345931AT"
                                   wire:model="reference_code">
                            @error('reference_code') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm">Descripción</label>
                            <input type="text" class="input input-bordered input-info w-full"  placeholder="caracteristicas de venta" wire:model="observation">
                            @error('observation') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_payment" class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Tipo de
                                Pago</label>
                            <select id="category_payment" wire:model="payment_method_code"
                                    class="select select-bordered select-info mt-1 w-full">
                                <option value="">Seleccionar</option>
                                <option value="10">Efectivo</option>
                                <option value="42">Consignación</option>
                                <option value="20">Cheque</option>
                                <option value="47">Transferencia</option>
                                <option value="71">Bonos</option>
                                <option value="72">Vales</option>
                                <option value="1">Pago no definido</option>
                                <option value="49">Tarjeta de Debito</option>
                                <option value="48">Tarjeta de Credito</option>
                            </select>
                            @error('payment_method_code')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Más campos si deseas -->
                    </div>

                @endif

                <!-- PASO 2: Datos del Cliente -->
                @if($step === 2)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm"><span class="text-red-500 font-bold mr-1">*</span>Identificación</label>
                            <input type="text" class="input input-bordered input-info w-full" placeholder="Ej. 1234567363"
                                   wire:model="customer.identification">
                            @error('customer.identification') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_names" class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Nombre</label>
                            <input id="category_names" type="text" placeholder="Ej. Juan Perez"
                                   class="input input-bordered input-info w-full"
                                   wire:model.debounce.500ms="customer.names"/>
                            @error('customer.names') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_address"
                                   class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Dirección</label>
                            <input id="category_address" type="text" placeholder="Ej. calle 1 # 2-68 Guatemala"
                                   class="input input-bordered input-info w-full"
                                   wire:model.debounce.500ms="customer.address"/>
                            @error('customer.address') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_email" class="block text-sm font-medium text-gray-700">correo
                                electronico</label>
                            <input id="category_email" type="email" placeholder="Ej. alanturing@enigmasas.com"
                                   class="input input-bordered input-info w-full"
                                   wire:model.debounce.500ms="customer.email"/>
                            @error('customer.email') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_phone" class="block text-sm font-medium text-gray-700">Telefono</label>
                            <input id="category_phone" type="text" placeholder="Ej. 12345674"
                                   class="input input-bordered input-info w-full"
                                   wire:model.debounce.500ms="customer.phone"/>
                            @error('customer.phone') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="municipality_id"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300"><span class="text-red-500 font-bold mr-1">*</span>Municipio</label>
                            <select wire:model.live="customer.municipality_id" id="customer.municipality_id"
                                    class="select select-bordered select-info w-full">
                                <option value="0" selected>Seleccionar</option>
                                @if($municipalitys)
                                    @foreach ($municipalitys as $valor)
                                        <option value="{{ $valor['id']}}">{{ $valor['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('customer.municipality_id') <span
                                class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <!-- Agrega los demás campos de cliente aquí -->
                    </div>
                @endif

                <!-- PASO 3: Datos del Producto -->
                @if($step === 3)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm"><span class="text-red-500 font-bold mr-1">*</span>Cod. Ref Prod.</label>
                            <input type="text" class="input input-bordered input-info w-full" placeholder="Ej. 12345"
                                   wire:model="items.0.code_reference">
                            @error('items.0.code_reference') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category_phone" class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Cantidad</label>
                            <input id="category_phone" type="number" placeholder="Ej. 2"
                                   class="input input-bordered input-info w-full"
                                   wire:model.debounce.500ms="items.0.quantity"/>
                            @error('items.0.quantity') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_producto"
                                   class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Producto</label>
                            <input id="category_producto" type="text" placeholder="Ej. Camisa, telefono"
                                   class="input input-bordered input-info mt-1 w-full"
                                   wire:model.debounce.500ms="items.0.name"/>
                            @error('items.0.name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_price" class="block text-sm font-medium text-gray-700"><span class="text-red-500 font-bold mr-1">*</span>Precio</label>
                            <input id="category_price" type="number" placeholder="Ej. 3000"
                                   class="input input-bordered input-info mt-1 w-full"
                                   wire:model.debounce.500ms="items.0.price"/>
                            @error('items.0.price') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <!-- Más campos de items aquí -->
                    </div>
                @endif

                <!-- BOTONES DE NAVEGACIÓN -->
                <div class="flex justify-between mt-6">
                    {{-- Botón Atrás visible solo en pasos 2 y 3 --}}
                    @if($step > 1)
                        <button type="button" class="btn btn-outline" wire:click="previousStep">Atrás</button>
                    @else
                        <div></div> {{-- Placeholder para alinear el botón derecho --}}
                    @endif

                    {{-- Botón Siguiente visible en pasos 1 y 2 --}}
                    @if($step < 3)
                        <button type="button" class="btn btn-info" wire:click="nextStep">Siguiente</button>
                    @else
                        {{-- Paso 3: botón Crear / Actualizar --}}
                        <button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}"
                                wire:loading.attr="disabled">
                            {{ $selected_id ? 'Actualizar' : 'Crear' }}
                        </button>
                    @endif
                </div>

                {{-- Indicador de carga --}}
                <div wire:loading wire:target="{{ $selected_id ? 'update' : 'store' }}" class="text-center mt-4">
                    <button class="btn">
                        <span class="loading loading-spinner"></span>
                        loading
                    </button>
                </div>
            </form>

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
