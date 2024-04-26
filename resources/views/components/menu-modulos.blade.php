<ul class="menu lg:menu-horizontal w-full bg-base-200 lg:mb-0">
    <li><a>
            <i class="fas fa-shopping-cart">
            </i>Ventas</a></li>
    <li>
        <details close>
            <summary> <i class="fas fa-project-diagram"></i>Gestion Stocks</summary>
            <ul>
                <li><a>Categorias</a></li>
                <li><a>Productos</a></li>
                <li><a>Monedas</a></li>
            </ul>
        </details>
    </li>
    <li>
        <details close>
            <summary><i class="fas fa-project-diagram"></i>Reporteria</summary>
            <ul>
                <li><a>Cierre de Caja</a></li>
                <li><a>Ventas</a></li>
                <li><a>Estadistica</a></li>
            </ul>
        </details>
    </li>
    <li>
        <details close>
            <summary><i class="fas fa-users"></i>Gestion Usuarios</summary>
            <ul>
                <li><a>Roles</a></li>
                <li><a>Permisos</a></li>
                <li><a>Asignar</a></li>
                <li><a>Usuarios</a></li>
            </ul>
        </details>
    </li>
    <li class="ml-auto">
        <label class="flex cursor-pointer gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5" />
                <path
                    d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
            </svg>
            <input type="checkbox" value="dark" class="toggle theme-controller" id="themeToggle" />
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </label>
    </li>
</ul>


<!--div id="menu" class="lg:sidebar lg:sidebar-left lg:sidebar-primary w-64 bg-base-200"-->
<!--button id="menu-button" class="btn btn-primary btn-outline lg:hidden">Mostrar</button-->

<!--ul class="menu">
        <ul class="menu bg-base-200">
            <li><a>Ventas</a></li>
            <li>
                <details close>
                    <summary>Gestion de Stocks</summary>
                    <ul>
                        <li><a>Categorias <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg></a></li>
                        <li><a>Productos <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        <li><a>Monedas <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        </li>
                    </ul>
                </details>
            </li>
            <li>
                <details close>
                    <summary>Reporteria</summary>
                    <ul>
                        <li><a>Cierre Caja <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg></a></li>
                        <li><a>Ventas <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        <li><a>Estadistica <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        </li>
                    </ul>
                </details>
            </li>
            <li>
                <details close>
                    <summary>Gestion de Usuarios</summary>
                    <ul>
                        <li><a>Roles <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg></a>
                        </li>
                        <li><a>Permisos <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        <li><a>Asignar <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        <li><a>Usuarios <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg></a></li>
                        <li>
                        </li>
                    </ul>
                </details>
            </li>
        </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var menu = document.getElementById('menu');
        var menuButton = document.getElementById('menu-button');

        // Quitamos la clase 'hidden' para mostrar el menú inicialmente
        menu.classList.remove('hidden');

        menuButton.addEventListener('click', function() {
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                this.innerText = 'Ocultar Menú';
            } else {
                menu.classList.add('hidden');
                this.innerText = 'Mostrar Menú';
            }
        });
    });
</script-->