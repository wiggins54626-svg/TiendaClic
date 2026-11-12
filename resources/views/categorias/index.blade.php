<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="page-title">Categorías</h2>

            <a href="{{ route('categorias.create') }}" class="btn-primary">
                + Crear nueva categoría
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Mensaje de confirmación --}}
            @if (session('success'))
                <div class="alert-ok">{{ session('success') }}</div>
            @endif

            {{-- Mensaje de error --}}
            @if (session('error'))
                <div class="alert-bad">{{ session('error') }}</div>
            @endif

            {{-- Tabla de categorías --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table-base">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th class="!text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>

                                    <td class="!text-ink font-medium">{{ $categoria->nombre }}</td>

                                    <td>{{ $categoria->descripcion }}</td>

                                    <td>
                                        @if ($categoria->activa)
                                            <span class="badge-ok">Activa</span>
                                        @else
                                            <span class="badge-bad">Inactiva</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('categorias.edit', $categoria->id) }}"
                                               class="btn-secondary !px-3 !py-1.5">
                                                Editar
                                            </a>

                                            <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn-danger !px-3 !py-1.5"
                                                        onclick="return confirm('¿Está seguro de que desea eliminar esta categoría?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="!py-10 text-center text-muted">
                                        No hay categorías registradas.
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
