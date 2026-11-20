<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ClienteDatosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GestionPedidoController;
use App\Http\Controllers\VerificacionPagoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [InicioController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

  

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
    Route::get('/catalogo/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');

    Route::get('/mis-datos', [ClienteDatosController::class, 'edit'])->name('mis-datos.edit');
    Route::put('/mis-datos', [ClienteDatosController::class, 'update'])->name('mis-datos.update');

    Route::resource('carrito', CarritoController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store', 'show']);
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    Route::resource('pagos', PagoController::class)->only(['create', 'store']);

    Route::middleware('rol:propietario')->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('categorias', CategoriaController::class);
        Route::resource('productos', ProductoController::class);
    });

    Route::middleware('rol:colaborador,propietario')->group(function () {
        Route::resource('gestion-pedidos', GestionPedidoController::class)->only(['index', 'show', 'update']);
        Route::resource('verificacion-pagos', VerificacionPagoController::class)->only(['index', 'update']);
    });

});

require __DIR__.'/auth.php';
