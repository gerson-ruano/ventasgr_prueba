<?php
return [
    'Administración' => [
        'label' => 'Administración de Usuarios',
        'icon' => 'fas fa-users',
        'roles' => ['Admin'],
        'children' => [
            'users' => [
                'label' => 'Usuarios',
                'icon' => 'fas fa-user',
                'route' => 'users',
                'roles' => ['Admin'],
            ],
            'roles' => [
                'label' => 'Roles',
                'icon' => 'fas fa-user-tag',
                'route' => 'roles',
                'roles' => ['Admin'],
            ],
            'permisos' => [
                'label' => 'Permisos',
                'icon' => 'fas fa-unlock-alt',
                'route' => 'permisos',
                'roles' => ['Admin'],
            ],
            'asignar' => [
                'label' => 'Asignar Permisos',
                'icon' => 'fas fa-check-square',
                'route' => 'asignar',
                'roles' => ['Admin'],
            ],
        ],
    ],
    /*'configuración' => [
        'label' => 'Configuración',
        'icon' => 'fas fa-cogs',
        'roles' => ['Admin'],
        'children' => [
            'categories' => [
                'label' => 'Categorias',
                'icon' => 'fas fa-user',
                'route' => 'categories',
                'roles' => ['Admin'],
            ],
            'coins' => [
                'label' => 'Monedas',
                'icon' => 'fas fa-tags',
                'route' => 'coins',
                'roles' => ['Admin'],
            ],
            'products' => [
                'label' => 'Productos',
                'icon' => 'fas fa-box',
                'route' => 'permisos',
                'roles' => ['Admin'],
            ],
        ],
    ],*/
    'configuracion' => [
        'label' => 'Configuraciones',
        'icon' => 'fas fa-cogs',
        'route' => 'configuracion',
        'roles' => ['Admin'],
    ],
    'pos' => [
        'label' => 'Ventas',
        'icon' => 'fas fa-shopping-cart',
        'route' => 'pos',
        'roles' => ['Admin', 'Employee', 'Seller'],
    ],
    'api' => [
        'label' => 'API FACTUS',
        'icon' => 'fas fa-plug',
        'route' => 'api',
        'roles' => ['Admin', 'Employee', 'Seller'],
    ],
    'stock' => [
        'label' => 'Administración de Stock',
        'icon' => 'fas fa-boxes',
        'roles' => ['Admin'],
        'children' => [
            'categories' => [
                'label' => 'Categorias',
                'icon' => 'fas fa-user',
                'route' => 'categories',
                'roles' => ['Admin'],
            ],
            'products' => [
                'label' => 'Productos',
                'icon' => 'fas fa-box',
                'route' => 'permisos',
                'roles' => ['Admin'],
            ],
            'coins' => [
                'label' => 'Monedas',
                'icon' => 'fas fa-tags',
                'route' => 'coins',
                'roles' => ['Admin'],
            ],
        ],
    ],
    'graphics' => [
        'label' => 'Reporteria',
        'icon' => 'fas fa-chart-pie',
        'roles' => ['Admin'],
        'children' => [
            'cashout' => [
                'label' => 'Cierre Caja',
                'icon' => 'fas fa-money-check-alt',
                'route' => 'cashout',
                'roles' => ['Admin'],
            ],
            'reports' => [
                'label' => 'Reportes de Ventas',
                'icon' => 'fas fa-file-alt',
                'route' => 'reports',
                'roles' => ['Admin'],
            ],
            'grapics' => [
                'label' => 'Graficas y Estadisticas',
                'icon' => 'fas fa-chart-bar',
                'route' => 'graphics',
                'roles' => ['Admin'],
            ],
        ],
    ],
];



