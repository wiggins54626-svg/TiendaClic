<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registrar pago por transferencia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Pedido {{ $pedido->numero_orden }}
                    </h3>

                    <div class="mb-6 rounded-md bg-zinc-700/50 p-4">
                        <p class="text-sm text-zinc-400">Valor a transferir</p>
                        <p class="text-2xl font-bold">
                            ${{ number_format($pedido->total, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="mb-6 text-sm text-zinc-300">
                        Realiza la transferencia por el valor del pedido e ingresa aquí la
                        referencia o número de comprobante de la operación. Un colaborador
                        verificará el pago.
                    </p>

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-md bg-red-500/10 border border-red-500 p-4 text-red-400">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('pagos.store') }}">

                        @csrf

                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">

                        <div class="mb-6">
                            <label for="referencia_transaccion" class="block text-sm font-medium mb-1">
                                Referencia de la transferencia
                            </label>

                            <input
                                type="text"
                                id="referencia_transaccion"
                                name="referencia_transaccion"
                                value="{{ old('referencia_transaccion') }}"
                                required
                                class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('referencia_transaccion') border-red-500 @enderror"
                            >
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end gap-3">

                            <a href="{{ route('pedidos.show', $pedido->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Registrar pago
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
