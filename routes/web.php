<?php
use App\Livewire\Asignar;
use App\Livewire\Pos;
use Illuminate\Support\Facades\Route;
use App\Livewire\Categories;
use App\Livewire\Products;
use App\Livewire\Coins;
use App\Livewire\Users;
use App\Livewire\Roles;
use App\Livewire\Permisos;
use App\Livewire\Reports;



Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('categories', Categories::class)->name('categories');
    Route::get('products', Products::class)->name('products');
    Route::get('coins', Coins::class)->name('coins');
    Route::get('users', Users::class)->name('users');
    Route::get('roles', Roles::class)->name('roles');
    Route::get('permisos', Permisos::class)->name('permisos');
    Route::get('asignar', Asignar::class)->name('asignar');
    Route::get('pos', Pos::class)->name('pos');
    Route::get('reports', Reports::class)->name('reports');
});



//Route::view('categories', Categories::class);
require __DIR__.'/auth.php';

