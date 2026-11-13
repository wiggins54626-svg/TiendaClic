<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Pedido;

class PagoController extends Controller
{
    /**
     * Formulario para registrar el pago por transferencia de un pedido.
     * Se entra con: route('pagos.create', ['pedido' => $pedido->id])
     */
    public function create(Request $request)
    {
        $pedido = Pedido::where('id', $request->pedido)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $mensaje = $this->motivoNoPagable($pedido);

        if ($mensaje) {
            return redirect()->route('pedidos.show', $pedido->id)
                ->with('error', $mensaje);
        }

        return view('pagos.create', compact('pedido'));
    }

    /**
     * Registra el pago como pendiente de verificación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'referencia_transaccion' => 'required|max:100|unique:pagos,referencia_transaccion',
        ]);

        $pedido = Pedido::where('id', $request->pedido_id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $mensaje = $this->motivoNoPagable($pedido);

        if ($mensaje) {
            return redirect()->route('pedidos.show', $pedido->id)
                ->with('error', $mensaje);
        }

        Pago::create([
            'pedido_id' => $pedido->id,
            'metodo' => 'transferencia',
            'estado' => 'pendiente',
            'monto' => $pedido->total,
            'referencia_transaccion' => $request->referencia_transaccion,
        ]);

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('success', 'Pago registrado. Queda pendiente de verificación.');
    }

    /**
     * Devuelve un mensaje si el pedido no se puede pagar, o null si sí se puede.
     */
    private function motivoNoPagable(Pedido $pedido)
    {
        if ($pedido->estado == 'cancelado') {
            return 'No se puede pagar un pedido cancelado.';
        }

        $existe = Pago::where('pedido_id', $pedido->id)
            ->whereIn('estado', ['pendiente', 'confirmado'])
            ->exists();

        if ($existe) {
            return 'Este pedido ya tiene un pago registrado.';
        }

        return null;
    }
}
