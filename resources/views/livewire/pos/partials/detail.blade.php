<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
    <!-- Table Section -->
    <div class="border overflow-x-auto bg-base-200 rounded-lg shadow-lg w-full mx-auto">

        <table class="table table-xs">
            <thead class="bg-base-200 dark:bg-gray-800">
                <tr>
                    <th class="text-lg font-medium py-3 px-4 text-center">No.</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Imagen</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Descripcion</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Precio</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Cantidad</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Importe</th>
                    <th class="text-lg font-medium py-3 px-4 text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
                {{--dd($cart)--}}
                <!-- Mostrar notificación cuando no hay resultados -->
                {{--@include('livewire.components.no-results', ['result' => $sales ,'name' => $componentName])--}}

                @foreach($cart as $index => $item)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{-- ($denominations->currentPage() - 1) * $denominations->perPage() + $index + 1 --}}</td>
                    <td class="">
                        @if(isset($item->attributes[0]))
                        @php
                        $imagenPath = public_path('storage/products/' . $item->attributes[0]);
                        @endphp

                        @if (is_file($imagenPath))
                        <img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen de producto"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                        @else
                        <img src="{{ asset('assets/img/noimg.jpg') }}" alt="imagen por defecto"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                        @endif
                        @else
                        <img src="{{ asset('assets/img/noimg.jpg') }}" alt="imagen por defecto"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                        @endif
                    </td>
                    <td class="py-2 px-4 text-left">{{ $item->name }}</td>
                    <td class="py-2 px-4 text-left">{{number_format($item->price,2)}}</td>
                    <td>
                        <input type="number" id="r{{$item->id}}"
                            wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )"
                            style="font-size: 1rem!important" class="form-control text-center"
                            value="{{$item->quantity}}">
                    </td>
                    <td class="py-2 px-4 text-center">
                        <h6>
                            Q.{{number_format($item->price * $item->quantity,2)}}
                        </h6>
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button class="btn btn-sm btn-info mr-2" wire:click="edit({{ $item->id }})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline btn-danger"
                            onclick="Confirm('{{ $item->id }}','{{ '' }}','{{ $item->name }}','{{ $item->count() }}','PRODUCTOS', )"
                            title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
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
    </div>
</div>