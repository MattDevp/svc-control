<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspeccionController;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('inspecciones/exportar', [InspeccionController::class, 'exportar'])->name('inspecciones.exportar');
    Route::post('inspecciones/importar', [InspeccionController::class, 'importar'])->name('inspecciones.importar');

    Route::resource('inspecciones', InspeccionController::class)
        ->parameters(['inspecciones' => 'inspeccione'])
        ->except('show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
