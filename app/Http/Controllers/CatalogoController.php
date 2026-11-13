<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class CatalogoController extends Controller
{

    public function index(Request $request)
    {
        $consulta = Producto::where('activo', 1);


        if ($request->filled('buscar')) {
            $consulta->where('nombre', 'like', '%' . $request->buscar . '%');
        }

   
        if ($request->filled('categoria')) {
            $consulta->where('categoria_id', $request->categoria);
        }


        if ($request->filled('precio_min')) {
            $consulta->where('precio', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $consulta->where('precio', '<=', $request->precio_max);
        }

        $productos = $consulta->get();
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
