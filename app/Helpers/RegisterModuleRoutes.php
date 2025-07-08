<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;


// Función para recorrer módulos
function registerModuleRoutes($modules)
{
    foreach ($modules as $key => $module) {
        if (isset($module['children'])) {
            registerModuleRoutes($module['children']);
        } elseif (isset($module['route'], $module['roles'])) {
            $routeName = $module['route'];

            Route::middleware(['auth', 'checkStatus', 'role:' . implode('|', $module['roles'])])
                ->get($routeName, fn () => app()->call([resolve("App\\Livewire\\" . ucfirst($routeName)), '__invoke']))
                ->name($routeName);
        }
    }
}
