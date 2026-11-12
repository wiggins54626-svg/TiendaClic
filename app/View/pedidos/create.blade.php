<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Confirmar pedido
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Datos de envío --}}
                <div class="lg:col-span-2 bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-zinc-100">

                        <h3 class="text-lg font-semibold mb-6">
                            Datos de envío
                        </h3>

                        {{-- Mensaje de error --}}
                        @if (session('error'))
                            <div class="mb-4 rounded-md bg-red-500/10 border border-red-500 p-4 text-red-400">
                                {{ session('error') }}
                            </div>
                        @endif

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
                              action="{{ route('pedidos.store') }}">

                            @csrf

                            {{-- Destinatario y teléfono --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                                <div>
                                    <label for="nombre_destinatario" class="block text-sm font-medium mb-1">
                                        Nombre del destinatario
                                    </label>

                                    <input
                                        type="text"
                                        id="nombre_destinatario"
                                        name="nombre_destinatario"
                                        value="{{ old('nombre_destinatario', auth()->user()->name) }}"
                                        required
                                        class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('nombre_destinatario') border-red-500 @enderror"
                                    >
                                </div>

                                <div>
                                    <label for="telefono_contacto" class="block text-sm font-medium mb-1">
                                        Teléfono de contacto
                                    </label>

                                    <input
                                        type="text"
                                        id="telefono_contacto"
                                        name="telefono_contacto"
                                        value="{{ old('telefono_contacto') }}"
                                        required
                                        class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('telefono_contacto') border-red-500 @enderror"
                                    >
                                </div>

                            </div>

                            {{-- Dirección y ciudad --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                                <div>
                                    <label for="direccion_envio" class="block text-sm font-medium mb-1">
                                        Dirección de envío
                                    </label>

                                    <input
                                        type="text"
                                        id="direccion_envio"
                                        name="direccion_envio"
                                        value="{{ old('direccion_envio') }}"
                                        required
                                        class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('direccion_envio') border-red-500 @enderror"
                                    >
                                </div>

                                <div>
                                    <label for="ciudad_envio" class="block text-sm font-medium mb-1">
                                        Ciudad
                                    </label>

                                    <input
                                        type="text"
                                        id="ciudad_envio"
                                        name="ciudad_envio"
                                        value="{{ old('ciudad_envio') }}"
                                        required
                                        class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('ciudad_envio') border-red-500 @enderror"
                                    >
                                </div>

                            </div>

                            {{-- Método de pago --}}
                            <div class="mb-6">
                                <label for="metodo_pago" class="block text-sm font-medium mb-1">
                                    Método de pago
                                </label>

                                <select
                                    id="metodo_pago"
                                    name="metodo_pago"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('metodo_pago') border-red-500 @enderror"
                                >
                                    <option value="transferencia" selected>Transferencia</option>
                                </select>
                            </div>

                            {{-- Botones --}}
                            <div class="flex justify-end gap-3">

                                <a href="{{ route('carrito.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                                    Volver al carrito
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                    Confirmar pedido
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

                {{-- Resumen del pedido --}}
                <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-zinc-100">

                        <h3 class="text-lg font-semibold mb-4">
                            Resumen del pedido
                        </h3>

                        <ul class="divide-y divide-zinc-700 mb-4">

                            @foreach ($items as $fila)
                                <li class="flex justify-between py-2 text-sm">
                                    <span>
                                        {{ $fila['producto']->nombre }}
                                        <span class="text-zinc-400">x {{ $fila['item']->cantidad }}</span>
                                    </span>
                                    <span>
                                        ${{ number_format($fila['subtotal'], 0, ',', '.') }}
                                    </span>
                                </li>
                            @endforeach

                        </ul>

                        <p class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span>${{ number_format($total, 0, ',', '.') }}</span>
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
