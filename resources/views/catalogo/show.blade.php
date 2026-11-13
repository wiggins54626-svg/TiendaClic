<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle del producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    {{-- Mensaje de error --}}
                    @if (session('error'))
                        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500 p-4 text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500 p-4 text-red-400">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Imagen (por ahora un recuadro vacío) --}}
                        <div class="h-64 rounded-md bg-zinc-700 flex items-center justify-center text-zinc-400 text-sm">
                            Sin imagen
                        </div>

                        <div>

                            <h3 class="text-2xl font-semibold mb-1">
                                {{ $producto->nombre }}
                            </h3>

                            <p class="text-sm text-zinc-400 mb-4">
                                Categoría: {{ $categorias[$producto->categoria_id] ?? 'Sin categoría' }}
                            </p>

                            <p class="text-zinc-300 mb-4">
                                {{ $producto->descripcion }}
                            </p>

                            <p class="text-3xl font-bold mb-3">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </p>

                            {{-- Insignia de stock --}}
                            <div class="flex items-center gap-3 mb-6">

                                @if ($producto->stock == 0)
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-red-500 text-white">
                                        AGOTADO
                                    </span>
                                @elseif ($producto->stock <= $producto->stock_minimo)
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-500 text-zinc-900">
                                        STOCK BAJO
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500 text-zinc-900">
                                        DISPONIBLE
                                    </span>
                                @endif

                                <span class="text-sm text-zinc-400">
                                    Unidades: {{ $producto->stock }}
                                </span>

                            </div>

                            {{-- Agregar al carrito --}}
                            <form method="POST"
                                  action="{{ route('carrito.store') }}"
                                  class="flex gap-2 mb-6">

                                @csrf

                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                                <input
                                    type="number"
                                    name="cantidad"
                                    value="1"
                                    min="1"
                                    max="{{ $producto->stock }}"
                                    {{ $producto->stock == 0 ? 'disabled' : '' }}
                                    class="w-20 rounded-md border-zinc-600 bg-zinc-700 text-white focus:border-violet-500 focus:ring-violet-500 disabled:opacity-50"
                                >

                                <button
                                    type="submit"
                                    {{ $producto->stock == 0 ? 'disabled' : '' }}
                                    class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                                    Agregar al carrito
                                </button>

                            </form>

                            <a href="{{ route('catalogo.index') }}"
                               class="text-sm text-violet-400 hover:text-violet-300">
                                &larr; Volver al catálogo
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
