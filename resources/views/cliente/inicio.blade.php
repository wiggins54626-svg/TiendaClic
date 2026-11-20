<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Inicio</h2>
        <p class="mt-1 text-sm text-muted">Hola, {{ Auth::user()->name }}. ¿Qué quieres hacer hoy?</p>
    </x-slot>

    @php
        $estados = [
            'recibido' => 'badge-info',
            'en_preparacion' => 'badge-warn',
            'despachado' => 'badge-info',
            'entregado' => 'badge-ok',
            'cancelado' => 'badge-bad',
        ];

        $accesos = [
            [
                'ruta' => 'catalogo.index',
                'titulo' => 'Catálogo',
                'texto' => 'Explora los productos disponibles.',
                'icono' => 'catalogo',
            ],
            [
                'ruta' => 'carrito.index',
                'titulo' => 'Mi carrito',
                'texto' => $productosEnCarrito == 1 ? '1 producto por comprar.' : $productosEnCarrito . ' productos por comprar.',
                'icono' => 'carrito',
            ],
            [
                'ruta' => 'pedidos.index',
                'titulo' => 'Mis pedidos',
                'texto' => $pedidosActivos == 1 ? '1 pedido en curso.' : $pedidosActivos . ' pedidos en curso.',
                'icono' => 'pedidos',
            ],
            [
                'ruta' => 'mis-datos.edit',
                'titulo' => 'Mis datos',
                'texto' => 'Tu teléfono y dirección de envío.',
                'icono' => 'perfil',
            ],
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Accesos rápidos --}}
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($accesos as $acceso)
                    <a href="{{ route($acceso['ruta']) }}"
                       class="card group flex items-start gap-4 p-5 transition hover:border-brand-500/60 hover:bg-raised focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-brand-500/15 text-brand-300 group-hover:bg-brand-500 group-hover:text-white transition">
                            <x-icon :name="$acceso['icono']" class="h-6 w-6" />
                        </span>
                        <span>
                            <span class="block font-semibold text-ink">{{ $acceso['titulo'] }}</span>
                            <span class="mt-0.5 block text-sm text-muted">{{ $acceso['texto'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Últimos pedidos --}}
            <div class="card overflow-hidden">

                <div class="flex items-center justify-between border-b border-line px-6 py-4">
                    <h3 class="section-title">Mis últimos pedidos</h3>

                    <a href="{{ route('pedidos.index') }}" class="btn-ghost">
                        Ver todos
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-base">
                        <thead>
                            <tr>
                                <th>N.º de orden</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th class="!text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($ultimos as $pedido)
                                <tr>
                                    <td class="!text-ink font-medium">{{ $pedido->numero_orden }}</td>

                                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>

                                    <td>${{ number_format($pedido->total, 0, ',', '.') }}</td>

                                    <td>
                                        <span class="{{ $estados[$pedido->estado] }}">
                                            {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="flex justify-center">
                                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn-secondary">
                                                Ver detalle
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="!py-8 text-center text-muted">
                                        Aún no tienes pedidos.
                                        <a href="{{ route('catalogo.index') }}" class="text-brand-300 hover:text-brand-400">
                                            Empieza en el catálogo.
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
