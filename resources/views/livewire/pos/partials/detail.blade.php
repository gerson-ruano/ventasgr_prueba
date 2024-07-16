@php
$index = 1; // Inicializamos el contador fuera del bucle
@endphp
<div class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-2 lg:mr-2">
    @if ($totalProduct = count($cart) > 0 )
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

                @foreach($cart as $item)
                <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                    <td class="py-2 px-4 text-center">
                        {{ $index}}
                    </td>
                    <td class="px-4 text-center">
                        @php
                        $imagePath = 'storage/products/' . $item->options->image;
                        $defaultImagePath = 'img/noimg.jpg';
                        @endphp

                        @if (is_file(public_path($imagePath)))
                        <img src="{{ asset($imagePath) }}" alt="Imagen del producto"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                        @else
                        <img src="{{ asset($defaultImagePath) }}" alt="Imagen por defecto"
                            class="rounded-lg h-12 w-12 object-cover mx-auto">
                        @endif
                    </td>
                    <td class="py-2 px-4 text-center">{{ $item->name }}</td>
                    <td class="py-2 px-4 text-center">{{number_format($item->price,2)}}</td>
                    <td class="py-2 px-4 text-center">
                        <input type="number" id="r{{$item->id}}" wire:model="quantityInputs.{{$item->id}}"
                            wire:change="updateQty({{$item->id}}, $event.target.value)"
                            class="form-input text-center text-sm" />
                    </td>
                    <td class="py-2 px-4 text-center">
                        <h6>
                            Q.{{number_format($item->price * $item->qty,2)}}
                        </h6>
                    </td>
                    <td class="py-2 px-4 text-center">
                        <div class="flex flex-col sm:flex-row items-center justify-center">
                            <button class="btn btn-sm btn-outline btn-error sm:mr-1 mr-1"
                                onclick="Confirm('{{ $item->id }}','este CARRITO','{{ $item->name }}')"
                                title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button wire:click.prevent="increaseQty({{$item->id}})"
                                class="btn btn-sm btn-outline btn-success btn-i mr-1">
                                <i class="fas fa-plus-square"></i>
                            </button>
                            <button wire:click.prevent="decreaseQty({{$item->id}})"
                                class="btn btn-sm btn-outline btn-default mr-1">
                                <i class="fas fa-minus-square"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php $index++; ?>
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
    @else
    <div role="alert" class="alert alert-warning shadow-lg text-center p-2 items-center justify-center">
        <i class="fas fa-info-circle"></i>
        <div class="items-center justify-center">
            <h3 class="font-bold text-sm">No hay productos en la venta!</h3>
            <div class="text-xs">Agrega productos, ingresando el CODIGO respectivo ejem. #205</div>
        </div>
    </div>
    @endif
</div>