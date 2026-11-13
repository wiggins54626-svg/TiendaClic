<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use App\Models\Pago;
use App\Models\User;
use App\Models\HistorialEstadoPedido;

class GestionPedidoController extends Controller
{
    // Orden obligatorio de los estados
    private $secuencia = ['recibido', 'en_preparacion', 'despachado', 'entregado'];

    /**
     * Lista todos los pedidos (con filtro opcional por estado).
     */
    public function index(Request $request)
    {
        $consulta = Pedido::orderBy('id', 'desc');

        if ($request->filled('estado')) {
            $consulta->where('estado', $request->estado);
        }

        $pedidos = $consulta->get();
        $usuarios = User::pluck('name', 'id');

        return view('gestion-pedidos.index', compact('pedidos', 'usuarios'));
    }

    /**
     * Detalle de un pedido con su historial y su pago.
     */
    public function show(string $id)
    {
        $pedido = Pedido::findOrFail($id);

        $items = PedidoItem::where('pedido_id', $pedido->id)->get();

        $historial = HistorialEstadoPedido::where('pedido_id', $pedido->id)
            ->orderBy('id')
            ->get();

        $pago = Pago::where('pedido_id', $pedido->id)
            ->orderBy('id', 'desc')
            ->first();

        $usuarios = User::pluck('name', 'id');

        $siguiente = $this->siguienteEstado($pedido->estado);
        $puedeCancelar = in_array($pedido->estado, ['recibido', 'en_preparacion']);

        return view('gestion-pedidos.show', compact(
            'pedido', 'items', 'historial', 'pago', 'usuarios', 'siguiente', 'puedeCancelar'
        ));
    }

    /**
     * Avanza el estado (en orden) o cancela el pedido.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'accion' => 'required|in:avanzar,cancelar',
            'estado_nuevo' => 'required_if:accion,avanzar',
            'motivo_cancelacion' => 'required_if:accion,cancelar|nullable|max:255',
        ]);

        $pedido = Pedido::findOrFail($id);
        $estadoAnterior = $pedido->estado;

        if ($request->accion == 'avanzar') {

            $siguiente = $this->siguienteEstado($pedido->estado);

            if (! $siguiente) {
                return redirect()->route('gestion-pedidos.show', $pedido->id)
                    ->with('error', 'Este pedido ya no puede avanzar de estado.');
            }

            // No se permite saltar estados
            if ($request->estado_nuevo != $siguiente) {
                return redirect()->route('gestion-pedidos.show', $pedido->id)
                    ->with('error', 'Solo se puede avanzar al estado siguiente: ' . $siguiente . '.');
            }

            $pedido->update(['estado' => $siguiente]);
            $estadoNuevo = $siguiente;

        } else {

            if (! in_array($pedido->estado, ['recibido', 'en_preparacion'])) {
                return redirect()->route('gestion-pedidos.show', $pedido->id)
                    ->with('error', 'Solo se puede cancelar un pedido Recibido o En preparación.');
            }

            // Se repone el stock de cada producto del pedido
            foreach (PedidoItem::where('pedido_id', $pedido->id)->get() as $item) {
                $producto = Producto::find($item->producto_id);
                $producto->update(['stock' => $producto->stock + $item->cantidad]);
            }

            $pedido->update([
                'estado' => 'cancelado',
                'motivo_cancelacion' => $request->motivo_cancelacion,
            ]);
            $estadoNuevo = 'cancelado';
        }

        // Queda registrado quién hizo el cambio y cuándo
        HistorialEstadoPedido::create([
            'pedido_id' => $pedido->id,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'usuario_id' => auth()->id(),
        ]);

        return redirect()->route('gestion-pedidos.show', $pedido->id)
            ->with('success', 'Estado actualizado: ' . str_replace('_', ' ', $estadoNuevo) . '.');
    }

    /**
     * Devuelve el estado que sigue en la secuencia, o null si ya es el último.
     */
    private function siguienteEstado($estado)
    {
        $posicion = array_search($estado, $this->secuencia);

        if ($posicion === false || $posicion == count($this->secuencia) - 1) {
            return null;
        }

        return $this->secuencia[$posicion + 1];
    }
}
