{{--<x-slot name="title">Inicio - Mi Aplicación</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white-200 leading-tight">
            {{ __('Category') }}
</h2>
</x-slot>--}}

{{--<main class="grid card rounded-box place-items-center mt-2">--}}

    {{--<div class="container">
            <h1>Categories lista</h1>
            @if($categories->isEmpty())
            <p>No categories found.</p>
            @else
            <ul>
                @foreach($categories as $category)
                <li>{{ $category->name }}</li>
    <!-- Suponiendo que 'name' es un campo en tu modelo Category -->
    @endforeach
    </ul>
    @endif
    </div>--}}

    <div class="flex flex-col w-full lg:flex-row lg:space-y-0|">
        <div class="lg:w-3/4">
            <div
                class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
                Muestra el carrito de Productos
                <h2>Este sera el carrito de compras para los productos agregadops al</h2>
                <br><br>
                <p>
                    afaghfdghaj adsjhsgbdahjgbd
                    asgdjhasgdjhgahj
                    askdjhaskuhdaksjhdkjas
                    asdjkashgdujkgahsjdhgsa
                    akhsdkujhsajdkasjd
                    asdkghawdugyhqwuigqeuwi
                    adfsiujfdghaiughdfjaksgd
                    adfiuhfidugyhaqwiudrfghyauifdh
                    asdfkasuhdkashdjkasg
                    adfaghsjdgawsjhdgashj
                    afsjgfujyasgfdjhagsdjh
                    asjdgayujasdgjyhdsgjyhd
                    asasjgdfjayhsgdjhas
                    asdjdgasyjhugdasyhj
                    asdfgajydgfasjyh
                    asyfdgasyujgdfasjyhgdf
                    asjghdhajsfdhas
                    aasgfdhasfdh
                </p>


            </div>
        </div>
        <!--div class="divider lg:divider-horizontal"></div-->
        <div class="lg:w-1/4">
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                contenido de la segunda columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la tercera columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la cuarta columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la quinta columna

            </div>

        </div>
    </div>
    <!--div class="flex flex-col w-full lg:flex-row lg:space-y-0">
        <div class="lg:w-3/4">
                <div class="grid flex-grow  h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">GRID IZQUIERDO 
                    

                </div>
            </div-->
{{--</main>--}}