<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';
