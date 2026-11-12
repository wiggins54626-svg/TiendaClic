<x-app-layout>

    <x-slot name="header">
        <h2 class="page-title">Registro de nueva categoría</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="card card-body">

                <h3 class="section-title mb-6">Datos de la categoría</h3>

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert-bad mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('categorias.store') }}">

                    @csrf

                    {{-- Nombre y estado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        <div>
                            <label for="nombre" class="label">Nombre</label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                required
                                class="input @error('nombre') !border-bad @enderror"
                            >
                        </div>

                        <div>
                            <label for="activa" class="label">Estado</label>

                            <select
                                id="activa"
                                name="activa"
                                required
                                class="input @error('activa') !border-bad @enderror"
                            >
                                <option value="1" {{ old('activa', '1') == '1' ? 'selected' : '' }}>Activa</option>
                                <option value="0" {{ old('activa') == '0' ? 'selected' : '' }}>Inactiva</option>
                            </select>
                        </div>

                    </div>

                    {{-- Descripción --}}
                    <div class="mb-6">
                        <label for="descripcion" class="label">Descripción</label>

                        <input
                            type="text"
                            id="descripcion"
                            name="descripcion"
                            value="{{ old('descripcion') }}"
                            class="input @error('descripcion') !border-bad @enderror"
                        >
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('categorias.index') }}" class="btn-secondary">Cancelar</a>

                        <button type="submit" class="btn-primary">Guardar categoría</button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
