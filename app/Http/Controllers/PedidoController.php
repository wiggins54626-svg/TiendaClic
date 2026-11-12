<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use App\Models\HistorialEstadoPedido;

class PedidoController extends Controller
{
    /**
     * Lista los pedidos del usuario con sesión.
     */
    public function index()
    {
        $pedidos = Pedido::where('usuario_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Formulario de datos de envío (checkout).
     */
    public function create()
    {
        [$items, $total] = $this->resumenCarrito();

        if (count($items) == 0) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('pedidos.create', compact('items', 'total'));
    }

    /**
     * Confirma el pedido a partir del carrito.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_destinatario' => 'required|max:120',
            'direccion_envio' => 'required|max:200',
            'ciudad_envio' => 'required|max:80',
            'telefono_contacto' => 'required|max:20',
            'metodo_pago' => 'required|in:transferencia',
        ]);

        [$items, $total] = $this->resumenCarrito();

        if (count($items) == 0) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // Se verifica el stock de todos los productos antes de crear el pedido
        foreach ($items as $fila) {
            if (! $fila['producto']->activo || $fila['item']->cantidad > $fila['producto']->stock) {
                return redirect()->route('carrito.index')
                    ->with('error', 'Stock insuficiente para: ' . $fila['producto']->nombre);
            }
        }

        $pedido = Pedido::create([
            'usuario_id' => auth()->id(),
            'estado' => 'recibido',
            'total' => $total,
            'metodo_pago' => $request->metodo_pago,
            'nombre_destinatario' => $request->nombre_destinatario,
            'direccion_envio' => $request->direccion_envio,
            'ciudad_envio' => $request->ciudad_envio,
            'telefono_contacto' => $request->telefono_contacto,
        ]);

        // Un PedidoItem por producto; se copian nombre y precio del momento de la compra
        foreach ($items as $fila) {
            PedidoItem::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $fila['producto']->id,
                'nombre_producto' => $fila['producto']->nombre,
                'precio_unitario' => $fila['producto']->precio,
                'cantidad' => $fila['item']->cantidad,
                'subtotal' => $fila['subtotal'],
            ]);

            // Se descuenta el stock
            $fila['producto']->update([
                'stock' => $fila['producto']->stock - $fila['item']->cantidad,
            ]);
        }

        // Número de orden único
        $pedido->update(['numero_orden' => 'TC-' . $pedido->id]);

        // Primer registro del historial de estados
        HistorialEstadoPedido::create([
            'pedido_id' => $pedido->id,
            'estado_anterior' => null,
            'estado_nuevo' => 'recibido',
            'usuario_id' => auth()->id(),
        ]);

        // Se vacía el carrito
        $carrito = Carrito::where('usuario_id', auth()->id())->first();
        CarritoItem::where('carrito_id', $carrito->id)->delete();

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('success', 'Pedido creado. Número de orden: ' . $pedido->numero_orden);
    }

    /**
     * Detalle de un pedido (solo si es del usuario con sesión).
     */
    public function show(string $id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $items = PedidoItem::where('pedido_id', $pedido->id)->get();

        return view('pedidos.show', compact('pedido', 'items'));
    }

    /**
     * Arma las filas del carrito del usuario y su total.
     */
    private function resumenCarrito()
    {
        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        $items = [];
        $total = 0;

        if ($carrito) {
            foreach (CarritoItem::where('carrito_id', $carrito->id)->get() as $item) {
                $producto = Producto::find($item->producto_id);
                $subtotal = $producto->precio * $item->cantidad;
                $total += $subtotal;

                $items[] = [
                    'item' => $item,
                    'producto' => $producto,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return [$items, $total];
    }
}
