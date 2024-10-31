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
use App\Livewire\Cashout;
use App\Http\Controllers\ExportController;



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
    Route::get('cashout', Cashout::class)->name('cashout');

    //REPORTES PDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}/{selectTipoEstado}', [ExportController::class,'reportPDF']);
    Route::get('report/venta/{seller}/{nextSaleNumber}', [ExportController::class,'reportVenta'])->name('report.venta');
    Route::get('report/details/{seller}/{nextSaleNumber}', [ExportController::class, 'reportDetails'])->name('report.details');
    Route::get('report/box/{seller}/{nextSaleNumber}', [ExportController::class, 'reportBox'])->name('report.box');


    //REPORTES EXCEL
    Route::get('report-excel/{user}/{type}/{f1}/{f2}/{selectTipoEstado}', [ExportController::class,'reportExcel']);
    //Route::get('report-excel', [ExportController::class,'reportExcel']);
});



//Route::view('categories', Categories::class);
require __DIR__.'/auth.php';

