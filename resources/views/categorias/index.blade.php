<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Categorías registradas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">
                            Listado de categorías
                        </h3>

                        <a href="{{ route('categorias.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
                            + Crear nueva categoría
                        </a>
                    </div>

                    {{-- Mensaje de confirmación --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Mensaje de error --}}
                    @if (session('error'))
                        <div class="mb-4 rounded-md bg-red-100 p-4 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Tabla de categorías --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">ID</th>
                                    <th class="px-4 py-3 text-left">Nombre</th>
                                    <th class="px-4 py-3 text-left">Descripción</th>
                                    <th class="px-4 py-3 text-left">Estado</th>
                                    <th class="px-4 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @forelse ($categorias as $categoria)

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                                        <td class="px-4 py-3">
                                            {{ $categoria->id }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $categoria->nombre }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $categoria->descripcion }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $categoria->activa ? 'Activa' : 'Inactiva' }}
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('categorias.edit', $categoria->id) }}"
                                                   class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-md">
                                                    Editar
                                                </a>

                                                <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md"
                                                            onclick="return confirm('¿Está seguro de que desea eliminar esta categoría?')">
                                                        Eliminar
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5"
                                            class="px-4 py-6 text-center text-gray-500">
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
    </div>

</x-app-layout>
