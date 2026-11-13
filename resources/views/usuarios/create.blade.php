<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registro de nuevo usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-zinc-800 border border-zinc-700 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-zinc-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Datos del usuario
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
                          action="{{ route('usuarios.store') }}">

                        @csrf
                        {{-- Nombre y correo --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            <div>
                                <label for="name" class="block text-sm font-medium mb-1">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('name') border-red-500 @enderror"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium mb-1">
                                    Correo electrónico
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('email') border-red-500 @enderror"
                                >
                            </div>

                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-4">

                            <div>
                                <label for="password" class="block text-sm font-medium mb-1">
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('password') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-zinc-400">
                                    Mínimo 8 caracteres.
                                </p>
                            </div>

                        </div>

                        {{-- Rol y estado --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                            <div>
                                <label for="rol" class="block text-sm font-medium mb-1">
                                    Rol
                                </label>

                                <select
                                    id="rol"
                                    name="rol"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('rol') border-red-500 @enderror"
                                >
                                    <option value="cliente" {{ old('rol', 'cliente') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                    <option value="colaborador" {{ old('rol', 'cliente') == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                                    <option value="propietario" {{ old('rol', 'cliente') == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                </select>
                            </div>

                            <div>
                                <label for="activo" class="block text-sm font-medium mb-1">
                                    Estado
                                </label>

                                <select
                                    id="activo"
                                    name="activo"
                                    required
                                    class="w-full rounded-md border-zinc-600 bg-zinc-700 text-white shadow-sm focus:border-violet-500 focus:ring-violet-500 @error('activo') border-red-500 @enderror"
                                >
                                    <option value="1" {{ old('activo', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>

                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end gap-3">

                            <a href="{{ route('usuarios.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-500 text-white text-sm font-medium rounded-md">
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md">
                                Guardar usuario
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
