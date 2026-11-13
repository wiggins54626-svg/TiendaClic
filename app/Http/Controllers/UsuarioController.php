<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'rol' => 'required|in:cliente,colaborador,propietario',
            'activo' => 'required|in:0,1',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
            'activo' => $request->activo,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:8',
            'rol' => 'required|in:cliente,colaborador,propietario',
            'activo' => 'required|in:0,1',
        ]);

        $datos = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'activo' => $request->activo,
        ];

        // La contraseña solo se cambia si se escribe una nueva
        if ($request->filled('password')) {
            $datos['password'] = bcrypt($request->password);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Los usuarios no se eliminan: se desactivan.
     */
    public function destroy(User $usuario)
    {
        if ($usuario->id == auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario->update(['activo' => 0]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario desactivado exitosamente.');
    }
}
