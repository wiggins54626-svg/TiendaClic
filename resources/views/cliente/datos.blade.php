<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteDatosController extends Controller
{
    /**
     * Muestra los datos de contacto y envío del cliente con sesión.
     */
    public function edit()
    {
        $cliente = Cliente::find(auth()->id());

        return view('cliente.datos', compact('cliente'));
    }

    /**
     * Guarda los datos del cliente (los crea la primera vez).
     */
    public function update(Request $request)
    {
        $request->validate([
            'telefono' => 'required|max:20',
            'direccion' => 'required|max:200',
            'ciudad' => 'required|max:80',
        ]);

        $cliente = Cliente::find(auth()->id());

        if ($cliente) {
            $cliente->update([
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
            ]);
        } else {
            Cliente::create([
                'usuario_id' => auth()->id(),
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
            ]);
        }

        return redirect()->route('mis-datos.edit')
            ->with('success', 'Tus datos fueron guardados.');
    }
}
