<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar categoría
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Datos de la categoría:
                        {{ $categoria->nombre }}
                    </h3>

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-md">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('categorias.update', $categoria->id) }}">

                        @csrf
                        @method('PUT')

                        {{-- Nombre y estado --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            <div>
                                <label for="nombre" class="block text-sm font-medium mb-1">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    value="{{ old('nombre', $categoria->nombre) }}"
                                    required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                                >
                            </div>

                            <div>
                                <label for="activa" class="block text-sm font-medium mb-1">
                                    Estado
                                </label>

                                <select
                                    id="activa"
                                    name="activa"
                                    required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('activa') border-red-500 @enderror"
                                >
                                    <option value="1" {{ old('activa', $categoria->activa) == 1 ? 'selected' : '' }}>Activa</option>
                                    <option value="0" {{ old('activa', $categoria->activa) == 0 ? 'selected' : '' }}>Inactiva</option>
                                </select>
                            </div>

                        </div>

                        {{-- Descripción --}}
                        <div class="mb-6">
                            <label for="descripcion" class="block text-sm font-medium mb-1">
                                Descripción
                            </label>

                            <input
                                type="text"
                                id="descripcion"
                                name="descripcion"
                                value="{{ old('descripcion', $categoria->descripcion) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror"
                            >
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end gap-3">

                            <a href="{{ route('categorias.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md">
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
                                Actualizar categoría
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
