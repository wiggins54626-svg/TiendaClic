<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mis pedidos
        </h2>
    </x-slot>

    @php
        $colores = [
            'recibido' => 'border-violet-500 text-violet-400 bg-violet-500/10',
            'en_preparacion' => 'border-yellow-500 text-yellow-400 bg-yellow-500/10',
            'despachado' => 'border-blue-500 text-blue-400 bg-blue-500/10',
            'entregado' => 'border-green-500 text-green-400 bg-green-500/10',
            'cancelado' => 'border-red-500 text-red-400 bg-red-500/10',
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Historial de pedidos
                        </h3>

                        <a href="{{ route('catalogo.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                            Ir al catálogo
                        </a>
                    </div>

                    {{-- Mensaje de confirmación --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-500/10 border border-green-500 p-4 text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabla de pedidos --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-zinc-700">

                            <thead class="bg-zinc-700/50 text-zinc-300">
                                <tr>
                                    <th class="px-4 py-3 text-left">N.º de orden</th>
                                    <th class="px-4 py-3 text-left">Fecha</th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-700">

                                @forelse ($pedidos as $pedido)

                                    <tr class="hover:bg-zinc-700/40">

                                        <td class="px-4 py-3">
                                            {{ $pedido->numero_orden }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($pedido->total, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-semibold rounded border {{ $colores[$pedido->estado] }}">
                                                {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="flex justify-center">
                                                <a href="{{ route('pedidos.show', $pedido->id) }}"
                                                   class="px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm rounded-md">
                                                    Ver detalle
                                                </a>
                                            </div>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5"
                                            class="px-4 py-6 text-center text-zinc-400">
                                            Aún no tienes pedidos.
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
