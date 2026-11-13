<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Pedido;

class VerificacionPagoController extends Controller
{
    /**
     * Lista los pagos registrados (los pendientes se pueden verificar).
     */
    public function index()
    {
        $pagos = Pago::orderBy('id', 'desc')->get();
        $pedidos = Pedido::pluck('numero_orden', 'id');

        return view('verificacion-pagos.index', compact('pagos', 'pedidos'));
    }

    /**
     * Confirma o rechaza un pago pendiente.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'accion' => 'required|in:confirmar,rechazar',
        ]);

        $pago = Pago::findOrFail($id);

        if ($pago->estado != 'pendiente') {
            return redirect()->route('verificacion-pagos.index')
                ->with('error', 'Este pago ya fue verificado.');
        }

        $confirmar = ($request->accion == 'confirmar');

        $pago->update([
            'estado' => $confirmar ? 'confirmado' : 'rechazado',
            'verificado_por' => auth()->id(),
            'fecha_pago' => $confirmar ? now() : null,
        ]);

        return redirect()->route('verificacion-pagos.index')
            ->with('success', $confirmar ? 'Pago confirmado.' : 'Pago rechazado.');
    }
}
