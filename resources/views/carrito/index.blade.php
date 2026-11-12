<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mi carrito
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Productos en el carrito
                        </h3>

                        <a href="{{ route('catalogo.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                            Seguir comprando
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

                    {{-- Tabla del carrito --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-zinc-700">

                            <thead class="bg-zinc-700/50 text-zinc-300">
                                <tr>
                                    <th class="px-4 py-3 text-left">Producto</th>
                                    <th class="px-4 py-3 text-left">Precio</th>
                                    <th class="px-4 py-3 text-left">Cantidad</th>
                                    <th class="px-4 py-3 text-left">Subtotal</th>
                                    <th class="px-4 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-700">

                                @forelse ($items as $fila)

                                    <tr class="hover:bg-zinc-700/40">

                                        <td class="px-4 py-3">
                                            {{ $fila['producto']->nombre }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($fila['producto']->precio, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">

                                            {{-- Cambiar cantidad --}}
                                            <form method="POST"
                                                  action="{{ route('carrito.update', $fila['item']->id) }}"
                                                  class="flex gap-2">

                                                @csrf
                                                @method('PUT')

                                                <input
                                                    type="number"
                                                    name="cantidad"
                                                    value="{{ $fila['item']->cantidad }}"
                                                    min="1"
                                                    max="{{ $fila['producto']->stock }}"
                                                    class="w-20 rounded-md border-zinc-600 bg-zinc-700 text-white text-sm focus:border-violet-500 focus:ring-violet-500"
                                                >

                                                <button type="submit"
                                                        class="px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm rounded-md">
                                                    Actualizar
                                                </button>

                                            </form>

                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($fila['subtotal'], 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex justify-center">

                                                <form action="{{ route('carrito.destroy', $fila['item']->id) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md"
                                                            onclick="return confirm('¿Quitar este producto del carrito?')">
                                                        Quitar
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5"
                                            class="px-4 py-6 text-center text-zinc-400">
                                            Tu carrito está vacío.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Resumen y continuar --}}
                    @if (count($items) > 0)

                        <div class="flex justify-end items-center gap-6 mt-6">

                            <p class="text-lg">
                                Total:
                                <span class="font-bold">
                                    ${{ number_format($total, 0, ',', '.') }}
                                </span>
                            </p>

                            <a href="{{ route('pedidos.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Continuar con el pedido
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
