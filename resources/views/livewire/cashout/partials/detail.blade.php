<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">
    @if ($sale = count($sales) > 0 )
        <!-- Table Section -->
        <div class="border overflow-x-auto bg-base-200 rounded-lg shadow-lg w-full mx-auto">
            <table class="table table-xs">
                <thead class="bg-base-200 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-3 px-4 text-center">No. Venta</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Total</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Cantidad</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Colaborador</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Fecha y Hora</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Detalles</th>
                </tr>
                </thead>
                <tbody>

                @foreach($sales as $index => $item)
                    {{--dd($item)--}}
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td class="py-2 px-4 text-center">
                            {{ ($sales->currentPage() - 1) * $sales->perPage() + $index + 1 }}</td>
                        <td class="py-2 px-4 text-center">Q. {{number_format($item->total,2)}}</td>
                        <td class="py-2 px-4 text-center">
                            <h6>{{ $item->items }}</h6>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <h6>{{$this->obtenerNombreVendedor($item->seller)}}</h6>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <h6>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</h6>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <div class="flex flex-row items-center justify-center space-x-2">
                                <button wire:click.prevent="viewDetails({{$item}})" title="Detalles"
                                        class="btn btn-sm btn-outline btn-accent btn-i">
                                    <i class="fas fa-indent"></i>
                                </button>
                            </div>
                        </td>
                        {{--<td class="py-2 px-4 text-center">
                            <div class="flex flex-row items-center justify-center space-x-2">
                                <button wire:click.prevent="Edit({{$item->id}})" title="Editar"
                                        class="btn btn-sm btn-outline btn-success btn-i">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-outline btn-error"
                                        onclick="Confirm('{{ $item->id }}','este CARRITO','{{ $item->name }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
                {{--<tfoot class="bg-base-100 dark:bg-gray-800">
                    <tr>
                        <th class="py-2 px-4 text-center">No.</th>
                        <th class="py-2 px-4 text-left">Descripción</th>
                        <th class="py-2 px-4 text-center">Imagen</th>
                        <th class="py-2 px-4 text-center">Acción</th>
                    </tr>
                </tfoot>--}}
            </table>
            <div class="mt-4">
                {{ $sales->links() }}
            </div>

        </div>
    @else
        <div class="hidden">
            <!-- Este contenido solo se muestra si hay detalles -->
            <!-- Se puede usar para evitar mostrar la tabla y otros elementos cuando está vacía -->
        </div>
    @endif
</div>
@if (count($sales) === 0 && count($details) === 0)
    <div class="flex items-center justify-center w-full mt-4">
        <div role="alert"
             class="alert alert-warning text-center w-full max-w-lg p-6 bg-gradient-to-r from-yellow-200 via-yellow-300 to-yellow-400 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out scale-100 hover:scale-105">
            <i class="fas fa-info-circle text-2xl text-yellow-700"></i>
            <div class="mt-2">
                <h3 class="font-bold text-lg text-yellow-800">Ningun dato mostrado!</h3>
                <p class="text-sm text-yellow-700">Selecciona algun filtro de busqueda a tu izquierda</p>
            </div>
        </div>
    </div>
@endif
