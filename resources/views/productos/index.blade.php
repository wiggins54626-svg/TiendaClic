<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Productos registrados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Listado de productos
                        </h3>

                        <a href="{{ route('productos.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                            + Crear nuevo producto
                        </a>
                    </div>

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

                    {{-- Tabla de productos --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-zinc-700">

                            <thead class="bg-zinc-700/50 text-zinc-300">
                                <tr>
                                    <th class="px-4 py-3 text-left">ID</th>
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Categoría</th>
                                    <th class="px-4 py-3 text-left">Precio</th>
                                    <th class="px-4 py-3 text-left">Stock</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-700">

                                @forelse ($productos as $producto)

                                    <tr class="hover:bg-zinc-700/40">

                                        <td class="px-4 py-3">
                                            {{ $producto->id }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $producto->nombre }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $categorias[$producto->categoria_id] ?? 'Sin categoría' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($producto->precio, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            @if ($producto->stock == 0)
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-500 text-white">
                                                    AGOTADO
                                                </span>
                                            @elseif ($producto->stock <= $producto->stock_minimo)
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-500 text-zinc-900">
                                                    BAJO ({{ $producto->stock }})
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500 text-zinc-900">
                                                    {{ $producto->stock }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">
                                            @if ($producto->activo)
                                                <span class="px-2 py-1 text-xs font-semibold rounded border border-green-500 text-green-400 bg-green-500/10">
                                                    Activo
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded border border-red-500 text-red-400 bg-red-500/10">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('productos.edit', $producto->id) }}"
                                                   class="px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm rounded-md">
                                                    Editar
                                                </a>

                                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md"
                                                            onclick="return confirm('¿Está seguro de que desea eliminar este producto?')">
                                                        Eliminar
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7"
                                            class="px-4 py-6 text-center text-zinc-400">
                                            No hay productos registrados.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
