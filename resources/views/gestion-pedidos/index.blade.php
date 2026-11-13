<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestión de pedidos
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

                    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">

                        <h3 class="text-lg font-semibold">
                            Todos los pedidos
                        </h3>

                        {{-- Filtro por estado --}}
                        <form method="GET"
                              action="{{ route('gestion-pedidos.index') }}"
                              class="flex gap-2">

                            <select
                                name="estado"
                                class="rounded-md border-zinc-600 bg-zinc-700 text-white text-sm focus:border-violet-500 focus:ring-violet-500"
                            >
                                <option value="">Todos los estados</option>
                                <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="en_preparacion" {{ request('estado') == 'en_preparacion' ? 'selected' : '' }}>En preparación</option>
                                <option value="despachado" {{ request('estado') == 'despachado' ? 'selected' : '' }}>Despachado</option>
                                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>

                            <button type="submit"
                                    class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Filtrar
                            </button>

                        </form>

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
                                    <th class="px-4 py-3 text-left">Cliente</th>
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
                                            {{ $usuarios[$pedido->usuario_id] ?? '-' }}
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
                                                <a href="{{ route('gestion-pedidos.show', $pedido->id) }}"
                                                   class="px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm rounded-md">
                                                    Gestionar
                                                </a>
                                            </div>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-6 text-center text-zinc-400">
                                            No hay pedidos para mostrar.
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
