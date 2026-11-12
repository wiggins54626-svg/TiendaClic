<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:80|unique:categorias,nombre',
            'descripcion' => 'nullable|max:255',
            'activa' => 'required|in:0,1',
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
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
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|max:80|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|max:255',
            'activa' => 'required|in:0,1',
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        // No se puede eliminar una categoría que tiene productos
        if (Producto::where('categoria_id', $categoria->id)->exists()) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar: la categoría tiene productos.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
