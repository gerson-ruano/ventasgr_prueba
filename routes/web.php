<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categories;


Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

/*Route::get('categories', 'livewire.category.categories')
Route::get('categories', Categories::class)->name('category')
->middleware(['auth'])
->name('categories');*/

Route::middleware(['auth'])->group(function () {
    Route::get('categories', Categories::class)->name('categories');
});

//Route::view('categories', Categories::class);



require __DIR__.'/auth.php';

