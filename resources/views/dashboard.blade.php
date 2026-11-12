<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Panel</h2>
        <p class="mt-1 text-sm text-muted">Hola, {{ Auth::user()->name }}. Elige un módulo para empezar.</p>
    </x-slot>

    @php
        $modulos = [
            ['ruta' => 'catalogo.index',   'titulo' => 'Catálogo',   'texto' => 'Explora los productos disponibles.',        'icono' => 'catalogo'],
            ['ruta' => 'productos.index',  'titulo' => 'Productos',  'texto' => 'Crea y edita lo que vendes.',               'icono' => 'productos'],
            ['ruta' => 'categorias.index', 'titulo' => 'Categorías', 'texto' => 'Organiza tus productos por grupos.',        'icono' => 'categorias'],
            ['ruta' => 'pedidos.index',    'titulo' => 'Pedidos',    'texto' => 'Revisa el estado de cada compra.',          'icono' => 'pedidos'],
            ['ruta' => 'carrito.index',    'titulo' => 'Carrito',    'texto' => 'Consulta los productos por comprar.',       'icono' => 'carrito'],
            ['ruta' => 'usuarios.index',   'titulo' => 'Usuarios',   'texto' => 'Gestiona quién accede a la tienda.',        'icono' => 'usuarios'],
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($modulos as $m)
                    <a href="{{ route($m['ruta']) }}"
                       class="card group flex items-start gap-4 p-5 transition hover:border-brand-500/60 hover:bg-raised focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-brand-500/15 text-brand-300 group-hover:bg-brand-500 group-hover:text-white transition">
                            <x-icon :name="$m['icono']" class="h-6 w-6" />
                        </span>
                        <span>
                            <span class="block font-semibold text-ink">{{ $m['titulo'] }}</span>
                            <span class="mt-0.5 block text-sm text-muted">{{ $m['texto'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
