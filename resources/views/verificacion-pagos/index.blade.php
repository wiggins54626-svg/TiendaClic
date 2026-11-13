<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Verificación de pagos
        </h2>
    </x-slot>

    @php
        $coloresPago = [
            'pendiente' => 'border-yellow-500 text-yellow-400 bg-yellow-500/10',
            'confirmado' => 'border-green-500 text-green-400 bg-green-500/10',
            'rechazado' => 'border-red-500 text-red-400 bg-red-500/10',
        ];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Pagos por transferencia
                    </h3>

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

                    {{-- Tabla de pagos --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-zinc-700">

                            <thead class="bg-zinc-700/50 text-zinc-300">
                                <tr>
                                    <th class="px-4 py-3 text-left">ID</th>
                                    <th class="px-4 py-3 text-left">Pedido</th>
                                    <th class="px-4 py-3 text-left">Referencia</th>
                                    <th class="px-4 py-3 text-left">Monto</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-zinc-700">

                                @forelse ($pagos as $pago)

                                    <tr class="hover:bg-zinc-700/40">

                                        <td class="px-4 py-3">
                                            {{ $pago->id }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <a href="{{ route('gestion-pedidos.show', $pago->pedido_id) }}"
                                               class="text-violet-400 hover:text-violet-300">
                                                {{ $pedidos[$pago->pedido_id] ?? $pago->pedido_id }}
                                            </a>
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $pago->referencia_transaccion }}
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format($pago->monto, 0, ',', '.') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-semibold rounded border {{ $coloresPago[$pago->estado] }}">
                                                {{ ucfirst($pago->estado) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex justify-center gap-2">

                                                @if ($pago->estado == 'pendiente')

                                                    <form action="{{ route('verificacion-pagos.update', $pago->id) }}"
                                                          method="POST">

                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="accion" value="confirmar">

                                                        <button type="submit"
                                                                class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-md">
                                                            Confirmar
                                                        </button>

                                                    </form>

                                                    <form action="{{ route('verificacion-pagos.update', $pago->id) }}"
                                                          method="POST">

                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="accion" value="rechazar">

                                                        <button type="submit"
                                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md"
                                                                onclick="return confirm('¿Rechazar este pago?')">
                                                            Rechazar
                                                        </button>

                                                    </form>

                                                @else

                                                    <span class="text-sm text-zinc-400">Verificado</span>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-6 text-center text-zinc-400">
                                            No hay pagos registrados.
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
