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

        $coloresPago = [
            'pendiente' => 'border-yellow-500 text-yellow-400 bg-yellow-500/10',
            'confirmado' => 'border-green-500 text-green-400 bg-green-500/10',
            'rechazado' => 'border-red-500 text-red-400 bg-red-500/10',
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

                    {{-- Mensaje de error --}}
                    @if (session('error'))
                        <div class="mb-4 rounded-md bg-red-500/10 border border-red-500 p-4 text-red-400">
                            {{ session('error') }}
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

                        @if ($pedido->estado == 'cancelado')
                            <div class="md:col-span-2">
                                <p class="text-zinc-400">Motivo de cancelación</p>
                                <p>{{ $pedido->motivo_cancelacion }}</p>
                            </div>
                        @endif

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

                    {{-- Pago --}}
                    <div class="mt-8 border-t border-zinc-700 pt-6">

                        <h4 class="text-base font-semibold mb-3">
                            Pago
                        </h4>

                        @if ($pago)

                            <div class="flex flex-wrap items-center gap-3 text-sm mb-3">

                                <span class="px-2 py-1 text-xs font-semibold rounded border {{ $coloresPago[$pago->estado] }}">
                                    {{ ucfirst($pago->estado) }}
                                </span>

                                <span class="text-zinc-400">
                                    Referencia: {{ $pago->referencia_transaccion }}
                                </span>

                            </div>

                            @if ($pago->estado == 'pendiente')
                                <p class="text-sm text-zinc-400">
                                    Tu pago está pendiente de verificación por un colaborador.
                                </p>
                            @endif

                        @else

                            <p class="text-sm text-zinc-400 mb-3">
                                Este pedido aún no tiene un pago registrado.
                            </p>

                        @endif

                        {{-- Se puede pagar si no hay pago o si el último fue rechazado --}}
                        @if ($pedido->estado != 'cancelado' && (! $pago || $pago->estado == 'rechazado'))
                            <a href="{{ route('pagos.create', ['pedido' => $pedido->id]) }}"
                               class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Registrar pago
                            </a>
                        @endif

                    </div>

                    {{-- Línea de tiempo de estados --}}
                    <div class="mt-8 border-t border-zinc-700 pt-6">

                        <h4 class="text-base font-semibold mb-4">
                            Seguimiento del pedido
                        </h4>

                        <ol class="relative border-l border-zinc-600 ml-2">

                            @foreach ($historial as $registro)

                                <li class="mb-4 ml-4">

                                    <span class="absolute -left-1.5 mt-1.5 h-3 w-3 rounded-full bg-violet-500"></span>

                                    <p class="text-sm font-semibold">
                                        {{ ucfirst(str_replace('_', ' ', $registro->estado_nuevo)) }}
                                    </p>

                                    <p class="text-xs text-zinc-400">
                                        {{ $registro->created_at->format('d/m/Y H:i') }}
                                    </p>

                                </li>

                            @endforeach

                        </ol>

                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 mt-6">

                        @if ($pedido->estado == 'recibido')

                            <form method="POST"
                                  action="{{ route('pedidos.cancelar', $pedido->id) }}">

                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md"
                                        onclick="return confirm('¿Está seguro de que desea cancelar este pedido?')">
                                    Cancelar pedido
                                </button>

                            </form>

                        @endif

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
