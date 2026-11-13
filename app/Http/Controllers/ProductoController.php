<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\PedidoItem;
use App\Models\CarritoItem;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        $categorias = Categoria::pluck('nombre', 'id');

        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(['id', 'nombre']);
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric|min:0|max:9999999999|decimal:0,2',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'required|in:0,1',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
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
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all(['id', 'nombre']);
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric|min:0|max:9999999999|decimal:0,2',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'required|in:0,1',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Un producto con pedidos o presente en algún carrito no se puede eliminar:
        // se debe desactivar desde la edición.
        if (PedidoItem::where('producto_id', $producto->id)->exists()
            || CarritoItem::where('producto_id', $producto->id)->exists()) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar: el producto tiene pedidos o está en un carrito. Desactívalo en su lugar.');
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
