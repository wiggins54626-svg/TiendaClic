<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Acceso restringido</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="card card-body text-center">

                <p class="text-5xl font-bold text-brand-300">403</p>

                <h3 class="section-title mt-3">
                    No tienes permiso para ver esta sección
                </h3>

                <p class="mt-2 text-sm text-muted">
                    Tu rol no permite entrar a esta página. Si crees que es un error,
                    comunícate con el propietario de la tienda.
                </p>

                <div class="mt-6 flex justify-center">
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        Volver al inicio
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
