<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;

class InicioController extends Controller
{
    /**
     * Pantalla de inicio después de ingresar.
     * El personal ve el panel de administración; el cliente ve su propio inicio.
     */
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->rol != 'cliente') {
            return view('dashboard');
        }

        // Productos que el cliente tiene en su carrito
        $carrito = Carrito::where('usuario_id', $usuario->id)->first();
        $productosEnCarrito = $carrito
            ? CarritoItem::where('carrito_id', $carrito->id)->count()
            : 0;

        // Pedidos del cliente (del más reciente al más antiguo)
        $pedidos = Pedido::where('usuario_id', $usuario->id)
            ->orderBy('id', 'desc')
            ->get();

        $ultimos = $pedidos->take(3);
        $pedidosActivos = $pedidos->whereNotIn('estado', ['entregado', 'cancelado'])->count();

        return view('cliente.inicio', compact('productosEnCarrito', 'ultimos', 'pedidosActivos'));
    }
}
