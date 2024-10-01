<div class="bg-white p-8 rounded-lg shadow-lg z-10 w-full max-w-5xl mx-4">
    <h2 class="text-lg font-semibold mb-4 text-center">
        {{-- $saleId ? '#Detalle de la Venta' : 'Nueva Categoría' --}}
        <b>Detalle de la Venta #{{$saleId}}</b>
    </h2>

    <div
        class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">

        <!-- Table Section -->
        <div class="border overflow-x-auto bg-base-200 rounded-lg shadow-lg w-full mx-auto">
            <table class="table table-xs">
                <thead class="bg-base-200 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-3 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Producto</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Precio</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Cantidad</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Importe</th>
                </tr>
                </thead>
                <tbody>

                @foreach($details as $d)
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td class="py-2 px-4 text-center">
                            {{ $loop->iteration }}</td>
                        </td>
                        <td class="py-2 px-4 text-center">
                            {{ $d->product }}</td>
                        <td class="py-2 px-4 text-center">
                            <h6>Q. {{number_format($d->price,2)}}</h6>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <h6>{{number_format($d->quantity,2)}}</h6>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <h6>{{number_format($d->price * $d->quantity,2)}}</h6>
                        </td>

                        {{--}}<td class="py-2 px-4 text-center">
                            <div class="flex flex-row items-center justify-center space-x-2">
                                <button wire:click.prevent="Edit({{$item->id}})"
                                        class="btn btn-sm btn-outline btn-success btn-i">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>--}}
                    </tr>
                @endforeach
                {{--}}<tfoot class="bg-base-100 dark:bg-gray-800">
                    <tr>
                        <th class="py-2 px-4 text-center">No.</th>
                        <th class="py-2 px-4 text-left">Descripción</th>
                        <th class="py-2 px-4 text-center">Imagen</th>
                        <th class="py-2 px-4 text-center">Acción</th>
                    </tr>
                </tfoot>--}}
                <tr class="font-semibold">
                    <td colspan="3">
                        <h5 class="text-center">TOTALES</h5>
                    </td>
                    <td>
                        <h5 class="text-center">{{$countDetails}}</h5>
                    </td>
                    <td>
                        <h5 class="text-center">Q. {{number_format($sumDetails,2)}}</h5>
                    </td>
                </tr>
            </table>
            </tbody>
            {{--}}<div class="mt-4">
                {{ $data->links() }}
            </div>--}}
        </div>
    </div>


    <form wire:submit="{{ $selected_id ? 'update' : 'store' }}">
        <div class="flex justify-end mt-4">
            <button type="button" class="btn btn-outline mr-2" wire:click="closeModal">Cancelar</button>
            {{--}}<button type="submit" class="btn {{ $selected_id ? 'btn-info' : 'btn-success' }}">
                {{ $selected_id ? 'Actualizar' : 'Guardar' }}
            </button>--}}
        </div>
    </form>
