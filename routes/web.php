<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;

// Página pública
Route::get('/', function () {
    return redirect('/login');
});

// Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Productos
Route::middleware(['auth'])->group(function () {
    // Empleado: solo puede listar y ver
    Route::resource('productos', ProductoController::class)->only(['index','show']);

    // Admin: acceso completo
    Route::middleware('role:admin')->group(function () {
        Route::resource('productos', ProductoController::class)->except(['index','show']);
        Route::post('productos/{producto}/movimiento', [ProductoController::class, 'movimiento'])
             ->name('productos.movimiento');
    });
});

require __DIR__.'/auth.php';
