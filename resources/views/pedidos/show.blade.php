<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pedido {{ $pedido->numero_orden }}
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    {{-- Mensaje de confirmación --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-500/10 border border-green-500 p-4 text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">

                        <h3 class="text-lg font-semibold">
                            Detalle del pedido
                        </h3>

                        <span class="px-2 py-1 text-xs font-semibold rounded border {{ $colores[$pedido->estado] }}">
                            {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                        </span>

                    </div>

                    {{-- Datos del pedido y del envío --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm">

                        <div>
                            <p class="text-zinc-400">Fecha</p>
                            <p>{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-400">Método de pago</p>
                            <p>{{ ucfirst($pedido->metodo_pago) }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-400">Destinatario</p>
                            <p>{{ $pedido->nombre_destinatario }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-400">Teléfono</p>
                            <p>{{ $pedido->telefono_contacto }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-400">Dirección</p>
                            <p>{{ $pedido->direccion_envio }}</p>
                        </div>

                        <div>
                            <p class="text-zinc-400">Ciudad</p>
                            <p>{{ $pedido->ciudad_envio }}</p>
                        </div>

                    </div>

                    {{-- Productos del pedido --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-zinc-700">

                            <thead class="bg-zinc-700/50 text-zinc-300">
                                <tr>
                                    <th class="px-4 py-3 text-left">Producto</th>
                                    <th class="px-4 py-3 text-left">Precio</th>
                                    <th class="px-4 py-3 text-left">Cantidad</th>
                                    <th class="px-4 py-3 text-left">Subtotal</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-700">

                                @foreach ($items as $item)

                                    <tr class="hover:bg-zinc-700/40">

                                        <td class="px-4 py-3">
                                            {{ $item->nombre_producto }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($item->precio_unitario, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $item->cantidad }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <p class="flex justify-end gap-4 mt-6 text-lg font-bold">
                        <span>Total</span>
                        <span>${{ number_format($pedido->total, 0, ',', '.') }}</span>
                    </p>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('pedidos.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                            Volver a mis pedidos
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
