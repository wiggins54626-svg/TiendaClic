<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Datos del producto: {{ $producto->nombre }}
                    </h3>

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
                          action="{{ route('productos.update', $producto->id) }}">

                        @csrf
                        @method('PUT')

                        {{-- Nombre y categoría --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            <div>
                                <label for="nombre" class="block text-sm font-medium mb-1">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    value="{{ old('nombre', $producto->nombre) }}"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('nombre') border-red-500 @enderror"
                                >
                            </div>

                            <div>
                                <label for="categoria_id" class="block text-sm font-medium mb-1">
                                    Categoría
                                </label>

                                <select
                                    id="categoria_id"
                                    name="categoria_id"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('categoria_id') border-red-500 @enderror"
                                >
                                    <option value="">Seleccione una categoría</option>

                                    @foreach ($categorias as $categoria)
                                        <option
                                            value="{{ $categoria->id }}"
                                            {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}
                                        >
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- Precio, stock y stock mínimo --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                            <div>
                                <label for="precio" class="block text-sm font-medium mb-1">
                                    Precio
                                </label>

                                <input
                                    type="number"
                                    id="precio"
                                    name="precio"
                                    value="{{ old('precio', $producto->precio) }}"
                                    required
                                    step="0.01"
                                    min="0"
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('precio') border-red-500 @enderror"
                                >
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium mb-1">
                                    Stock
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    value="{{ old('stock', $producto->stock) }}"
                                    required
                                    min="0"
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('stock') border-red-500 @enderror"
                                >
                            </div>

                            <div>
                                <label for="stock_minimo" class="block text-sm font-medium mb-1">
                                    Stock mínimo
                                </label>

                                <input
                                    type="number"
                                    id="stock_minimo"
                                    name="stock_minimo"
                                    value="{{ old('stock_minimo', $producto->stock_minimo) }}"
                                    required
                                    min="0"
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('stock_minimo') border-red-500 @enderror"
                                >
                            </div>

                        </div>

                        {{-- Estado --}}
                        <div class="mb-4">
                            <label for="activo" class="block text-sm font-medium mb-1">
                                Estado
                            </label>

                            <select
                                id="activo"
                                name="activo"
                                required
                                class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('activo') border-red-500 @enderror"
                            >
                                <option value="1" {{ old('activo', $producto->activo) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('activo', $producto->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-6">
                            <label for="descripcion" class="block text-sm font-medium mb-1">
                                Descripción
                            </label>

                            <textarea
                                id="descripcion"
                                name="descripcion"
                                rows="3"
                                class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('descripcion') border-red-500 @enderror"
                            >{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end gap-3">

                            <a href="{{ route('productos.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Actualizar producto
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
