<style>
    details>summary::-webkit-details-marker {
        display: none;
    }

    details[open]>ul {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    details summary {
        list-style: none;
    }
</style>


<ul class="menu lg:menu-horizontal w-full bg-base-200 lg:mb-0 z-50">
    <li>
    <li class="">
        <a href="{{ url('home') }}"
            class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Seller|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
            <i class="fas fa-home mr-1"></i>Home
        </a>
    </li>
    </li>
    <li>
        <details>
            <summary <a
                class="border dark:border-gray-200 {{ Auth::user()->hasRole('Admin|Seller|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                {{-- }}href="{{url('pos')}}"> --}}
                <i class="fas fa-shopping-cart"></i>Venta</a>
            </summary>

            <ul class="">
                <li class="">
                    <a href="{{ url('pos') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Seller|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-cart-plus mr-1"></i>Pos
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('api') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Seller') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-compress-alt mr-1"></i>Factus
                    </a>
                </li>
            </ul>
        </details>
    </li>

    <li>
        <details>
            <summary <a
                 class="border dark:border-gray-200 {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                <i class="fas fa-project-diagram"></i>Gestion Stocks</a>
            </summary>
            <ul class="">
                <li class="">
                    <a href="{{ url('categories') }}"
                        class="border dark:border-gray-200 {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-tags mr-1"></i>Categorias
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('products') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-shopping-basket mr-1"></i>Productos
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('coins') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-money-bill-alt mr-1"></i>Monedas
                    </a>
                </li>
            </ul>
        </details>
    </li>
    <li>
        <details>
            <summary
                class="border dark:border-gray-200 {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                <i class="fas fa-print mr-1"></i>Reporteria
            </summary>
            <ul>
                <li class="">
                    <a href="{{ url('cashout') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-cash-register mr-1"></i>Cierre
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('reports') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin|Employee') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-file-contract mr-1"></i>Reportes
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('graphics') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-chart-bar mr-1"></i>Estadistica
                    </a>
                </li>
            </ul>
        </details>
    </li>
    <li class="ml-1">
        <details>
            <summary
                class="border dark:border-gray-200 {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                <i class="fas fa-users mr-1"></i>Gestion Usuarios
            </summary>
            <ul>
                <li class="">
                    <a href="{{ url('roles') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-street-view mr-1"></i>Roles
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('permisos') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-unlock-alt mr-1"></i>Permisos
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('asignar') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-check-square mr-1"></i>Asignar Permisos
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('users') }}"
                        class="border dark:border-gray-200 flex items-center {{ Auth::user()->hasRole('Admin') ? '' : 'opacity-50 pointer-events-none' }}">
                        <i class="fas fa-user mr-1"></i>Usuarios
                    </a>
                </li>
            </ul>
        </details>
    </li>
    <li>
        <div>
            {{-- @include('partials.search')
            <livewire:components.searchbox :model="'search'" /> --}}
        </div>
    </li>
    <li>
        <livewire:layout.navigation />
    </li>
    <li class="ml-auto">
        <label class="flex cursor-pointer gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5" />
                <path
                    d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
            </svg>
            <input type="checkbox" value="dark" class="toggle theme-controller" id="themeToggle"
                {{ auth()->user()->tema == 0 ? 'checked' : '' }} />
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </label>
    </li>
</ul>
