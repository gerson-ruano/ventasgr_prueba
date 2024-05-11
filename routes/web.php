<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;

Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('categories', 'livewire.category.categories')
->middleware(['auth'])
->name('dashboard');

//Route::view('categories', Categories::class);



require __DIR__.'/auth.php';

