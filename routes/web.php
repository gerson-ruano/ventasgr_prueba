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
use App\Http\Controllers\GraphicsController;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::middleware(['auth','checkStatus'])->group(function () {

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

//Route::prefix('admin')->middleware(['permission'])->group(function () {
    Route::middleware(['role:Admin'])->group(function () {

        Route::get('users', Users::class)->name('users');
        Route::get('roles', Roles::class)->name('roles');
        Route::get('permisos', Permisos::class)->name('permisos');
        Route::get('asignar', Asignar::class)->name('asignar');


    });
    Route::middleware(['role:Admin|Employee'])->group(function () {

        Route::get('categories', Categories::class)->name('categories');
        Route::get('products', Products::class)->name('products');
        Route::get('coins', Coins::class)->name('coins');
        Route::get('reports', Reports::class)->name('reports');
        Route::get('cashout', Cashout::class)->name('cashout');
        Route::get('graphics', [GraphicsController::class, 'index']);

        //REPORTE GENERAL DE VENTAS PDF
        Route::get('report/pdf/{user}/{type}/{f1}/{f2}/{selectTipoEstado}', [ExportController::class, 'reportPDF']);
        //REPORTE DE X VENTA PDF
        Route::get('report/details/{seller}/{nextSaleNumber}', [ExportController::class, 'reportDetails'])->name('report.details');
        //REPORTE CIERRE DE CAJA X VENTA PDF
        Route::get('report/box/{seller}/{nextSaleNumber}', [ExportController::class, 'reportBox'])->name('report.box');
        //REPORTE GENERAL DE CIERRE DE CAJA PDF
        Route::get('report/box/{userid}/{f1}/{f2}', [ExportController::class, 'reportBoxGeneral'])->name('report.boxgeneral');
        //IMPRESION VENTA PDF
        Route::get('report/venta/{change}/{efectivo}/{seller}/{nextSaleNumber}', [ExportController::class, 'reportVenta'])->name('report.venta');

        //REPORTES EXCEL
        //Reporte general de ventas
        Route::get('report-excel/{user}/{type}/{f1}/{f2}/{selectTipoEstado}', [ExportController::class, 'reportExcel']);
        //Reporte general de cierre de caja
        Route::get('report-excel/{userid}/{f1}/{f2}', [ExportController::class, 'reportBoxExcel']);
        //Route::get('report-excel', [ExportController::class,'reportExcel']);
    });

    Route::middleware(['role:Admin|Employee|Seller'])->group(function () {
        Route::get('pos', Pos::class)->name('pos');
    });
});


//Route::view('categories', Categories::class);
require __DIR__ . '/auth.php';

