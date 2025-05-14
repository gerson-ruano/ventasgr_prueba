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
                    <th class="title_table">No.</th>
                    <th class="title_table">Imagen</th>
                    <th class="title_table">Descripcion</th>
                    <th class="title_table">Precio</th>
                    <th class="title_table">Cantidad</th>
                    <th class="title_table">Importe</th>
                    <th class="title_table">Accion</th>
                </tr>
                </thead>
                <tbody>
                {{--dd($cart)--}}
                <!-- Mostrar notificación cuando no hay resultados -->
                {{--@include('livewire.components.no-results', ['result' => $sales ,'name' => $componentName])--}}

                @foreach($cart as $item)
                    <tr class="bg-white dark:bg-gray-700 border-b dark:border-gray-600">
                        <td class="row_table">
                            {{ $index}}
                        </td>
                        <td class="row_table">
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
                        <td class="row_table">{{ $item->name }}</td>
                        <td class="row_table">{{number_format($item->price,2)}}</td>
                        <td class="row_table">
                            <input type="number" id="r{{$item->id}}" wire:model="quantityInputs.{{$item->id}}"
                                   wire:change="updateQty({{$item->id}}, $event.target.value)"
                                   class="form-input text-center text-sm bg-blue-100 border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                        </td>
                        <td class="row_table">
                            <h6>
                                Q.{{number_format($item->price * $item->qty,2)}}
                            </h6>
                        </td>
                        <td class="row_table">
                            <div class="flex flex-row items-center justify-center space-x-2">
                                <button wire:click.prevent="increaseQty({{$item->id}})"
                                        class="btn btn-sm btn-outline btn-success rounded-lg">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                                <button wire:click.prevent="decreaseQty({{$item->id}})"
                                        class="btn btn-sm btn-outline">
                                    <i class="fas fa-minus-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline btn-error"
                                        onclick="Confirm('{{ $item->id }}','este CARRITO','{{ $item->name }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                        <?php $index++; ?>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="hidden">
            <!-- Este contenido solo se muestra si hay productos -->
            <!-- Se puede usar para evitar mostrar la tabla y otros elementos cuando está vacía -->
        </div>
    @endif
</div>
@if (count($cart) === 0)
    <div class="flex items-center justify-center w-full mt-1 mb-1 mr-1 ml-2">
        <div role="alert"
             class="alert alert-warning text-center w-full max-w-lg p-6 bg-gradient-to-r from-yellow-200 via-yellow-300 to-yellow-400 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out scale-100 hover:scale-105">
            <i class="fas fa-info-circle text-2xl text-yellow-700"></i>
            <div class="mt-2">
                <h3 class="font-bold text-lg text-yellow-800">No hay productos en la venta!</h3>
                <p class="text-sm text-yellow-700">Agrega productos, ingresando el CODIGO respectivo ejem. #205</p>
            </div>
        </div>
    </div>

@endif

