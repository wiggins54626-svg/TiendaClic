<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;

class CatalogoController extends Controller
{

    public function index()
    {
        $productos = Producto::where('activo', 1)->get();
        $categorias = Categoria::pluck('nombre', 'id');

        return view('catalogo.index', compact('productos', 'categorias'));
    }

    public function show(Producto $producto)
    {
        // Un producto desactivado no se muestra a los clientes
        if (! $producto->activo) {
            abort(404);
        }

        $categorias = Categoria::pluck('nombre', 'id');

        return view('catalogo.show', compact('producto', 'categorias'));
    }
}
