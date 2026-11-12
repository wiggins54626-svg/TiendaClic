<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de confirmación --}}
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-500/10 border border-green-500 p-4 text-green-400">
                    {{ session('success') }}
                </div>
            @endif

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

            {{-- Cuadrícula de productos --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                @forelse ($productos as $producto)

                    <div class="flex flex-col bg-zinc-800 border border-zinc-700 rounded-lg p-4 text-zinc-100">

                        {{-- Imagen (por ahora un recuadro vacío) --}}
                        <div class="h-32 mb-3 rounded-md bg-zinc-700 flex items-center justify-center text-zinc-400 text-sm">
                            Sin imagen
                        </div>

                        <a href="{{ route('catalogo.show', $producto->id) }}"
                           class="font-semibold hover:text-violet-400">
                            {{ $producto->nombre }}
                        </a>

                        <p class="text-xs text-zinc-400 mb-2">
                            Categoría: {{ $categorias[$producto->categoria_id] ?? 'Sin categoría' }}
                        </p>

                        <div class="flex items-center justify-between mb-3">

                            <span class="text-lg font-bold">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </span>

                            {{-- Insignia de stock --}}
                            @if ($producto->stock == 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-500 text-white">
                                    AGOTADO
                                </span>
                            @elseif ($producto->stock <= $producto->stock_minimo)
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-500 text-zinc-900">
                                    STOCK BAJO ({{ $producto->stock }})
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500 text-zinc-900">
                                    DISPONIBLE
                                </span>
                            @endif

                        </div>

                        {{-- Agregar al carrito --}}
                        <form method="POST"
                              action="{{ route('carrito.store') }}"
                              class="mt-auto flex gap-2">

                            @csrf

                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                            <input
                                type="number"
                                name="cantidad"
                                value="1"
                                min="1"
                                max="{{ $producto->stock }}"
                                {{ $producto->stock == 0 ? 'disabled' : '' }}
                                class="w-16 rounded-md border-zinc-600 bg-zinc-700 text-white text-sm focus:border-violet-500 focus:ring-violet-500 disabled:opacity-50"
                            >

                            <button
                                type="submit"
                                {{ $producto->stock == 0 ? 'disabled' : '' }}
                                class="flex-1 px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                                Agregar al carrito
                            </button>

                        </form>

                    </div>

                @empty

                    <div class="col-span-full p-6 text-center text-zinc-400 bg-zinc-800 border border-zinc-700 rounded-lg">
                        No hay productos disponibles.
                    </div>

                @endforelse

            </div>

        </div>
    </div>

</x-app-layout>
