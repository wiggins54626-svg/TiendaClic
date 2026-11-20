<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GestionPedidoController;
use App\Http\Controllers\VerificacionPagoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ClienteDatosController;


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
    

    // Catálogo (Andrés)
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
    Route::get('/catalogo/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');

    // Usuarios (Juan)
    Route::resource('usuarios', UsuarioController::class);

    // Categorías y productos (Christian)
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);

    // Carrito y pedidos (Daniel)
    Route::resource('carrito', CarritoController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store', 'show']);

    // Pagos del cliente y cancelación de pedido (Daniel)
    Route::resource('pagos', PagoController::class)->only(['create', 'store']);
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');

    // Gestión de pedidos y verificación de pagos del colaborador (Christian)
    Route::resource('gestion-pedidos', GestionPedidoController::class)->only(['index', 'show', 'update']);
    Route::resource('verificacion-pagos', VerificacionPagoController::class)->only(['index', 'update']);

    // Datos del cliente (Christian)
    Route::get('/mis-datos', [ClienteDatosController::class, 'edit'])->name('mis-datos.edit');
    Route::put('/mis-datos', [ClienteDatosController::class, 'update'])->name('mis-datos.update');

});

require __DIR__.'/auth.php';
