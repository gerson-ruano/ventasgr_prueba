<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">
    <div class="flex justify-center items-center mt-1 mb-1 mr-1 ml-1">
        <button wire:click="obtenerDatosDeLaApi" class="btn btn-primary">Ver Facturas</button>
        @include('livewire.components.button_add', ['color' => 'accent' ,'model' => 'openModal', 'icon' => 'plus', 'title' => "agregar factura"])
    </div>
    <div class="align flex-row">
        @if (session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        @if ($datos)
            <div class="border overflow-x-auto bg-base-200 rounded-lg shadow-lg w-full mx-auto mb-2">
                <table class="table table-xs">
                    <thead class="bg-base-200 dark:bg-gray-800">
                    <tr>
                        <th class="text-lg font-medium py-3 px-4 text-center">#</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">ID</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Documento</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Cliente</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Codigo de Referencia</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Identificación</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Total</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Estado</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Fecha de Enviado</th>
                        <th class="text-lg font-medium py-3 px-4 text-center">Forma de pago</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($datos as $key => $item)
                        {{--dd($key+1)--}}
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['number'] }}</td>
                            <td>{{ $item['client_name'] }}</td>
                            <td>{{ $item['reference_code'] }}</td>
                            <td>{{ $item['identification'] }}</td>
                            <td>{{ $item['total'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['payment_form'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- Paginación -->
                {{-- $datos->links() --}}
            </div>
        @endif
    </div>
</div>
