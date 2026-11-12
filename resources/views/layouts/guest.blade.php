<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-10 bg-canvas overflow-hidden">
            {{-- Resplandor de marca detrás del formulario --}}
            <div class="pointer-events-none absolute -top-40 left-1/2 -translate-x-1/2 h-[28rem] w-[44rem] rounded-full bg-brand-500/20 blur-3xl"></div>

            <a href="/" class="relative flex flex-col items-center gap-3" aria-label="Tienda Clic, ir al inicio">
                <x-application-logo class="h-16 w-auto" />
                <img src="{{ asset('images/brand/logotipo-claro.svg') }}" alt="Tienda Clic" class="h-8 w-auto">
            </a>

            <div class="relative w-full sm:max-w-md mt-8 px-6 py-6 card shadow-2xl shadow-black/40">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
