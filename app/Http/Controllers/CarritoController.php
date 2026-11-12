<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;

class CarritoController extends Controller
{
    /**
     * Muestra los productos del carrito del usuario con sesión.
     */
    public function index()
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

        return view('carrito.index', compact('items', 'total'));
    }

    /**
     * Agrega un producto al carrito (llega desde el catálogo).
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        if (! $producto->activo || $producto->stock == 0) {
            return redirect()->back()
                ->with('error', 'El producto no está disponible.');
        }

        // Si el usuario no tiene carrito, se crea
        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        if (! $carrito) {
            $carrito = Carrito::create(['usuario_id' => auth()->id()]);
        }

        // Si el producto ya está en el carrito, se suma la cantidad
        $item = CarritoItem::where('carrito_id', $carrito->id)
            ->where('producto_id', $producto->id)
            ->first();

        $cantidadTotal = $request->cantidad + ($item ? $item->cantidad : 0);

        if ($cantidadTotal > $producto->stock) {
            return redirect()->back()
                ->with('error', 'Stock insuficiente. Máximo disponible: ' . $producto->stock);
        }

        if ($item) {
            $item->update(['cantidad' => $cantidadTotal]);
        } else {
            CarritoItem::create([
                'carrito_id' => $carrito->id,
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
            ]);
        }

        return redirect()->route('carrito.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Cambia la cantidad de un ítem del carrito.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $item = $this->itemDelUsuario($id);
        $producto = Producto::find($item->producto_id);

        if ($request->cantidad > $producto->stock) {
            return redirect()->route('carrito.index')
                ->with('error', 'Stock insuficiente. Máximo disponible: ' . $producto->stock);
        }

        $item->update(['cantidad' => $request->cantidad]);

        return redirect()->route('carrito.index')
            ->with('success', 'Cantidad actualizada.');
    }

    /**
     * Quita un ítem del carrito.
     */
    public function destroy(string $id)
    {
        $item = $this->itemDelUsuario($id);
        $item->delete();

        return redirect()->route('carrito.index')
            ->with('success', 'Producto quitado del carrito.');
    }

    /**
     * Busca un ítem y verifica que sea del carrito del usuario con sesión.
     */
    private function itemDelUsuario(string $id)
    {
        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        if (! $carrito) {
            abort(404);
        }

        return CarritoItem::where('id', $id)
            ->where('carrito_id', $carrito->id)
            ->firstOrFail();
    }
}