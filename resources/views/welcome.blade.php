<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen overflow-hidden bg-canvas">
            {{-- Resplandor de marca --}}
            <div class="pointer-events-none absolute right-[-10rem] top-[-8rem] h-[32rem] w-[32rem] rounded-full bg-brand-500/20 blur-3xl"></div>

            <header class="relative mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
                <a href="/" aria-label="Tienda Clic">
                    <img src="{{ asset('images/brand/logotipo-claro.svg') }}" alt="Tienda Clic" class="h-8 w-auto">
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">Ir al panel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-ghost">Ingresar</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-primary">Crear cuenta</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="relative mx-auto grid max-w-6xl items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-28">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight text-ink sm:text-5xl">
                        Comercio fácil, a un clic de distancia.
                    </h1>

                    <p class="mt-5 max-w-lg text-lg text-ink-soft">
                        Administra tu catálogo, tus categorías y tus pedidos desde un solo lugar.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary !px-6 !py-3">Ir al panel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary !px-6 !py-3">Ingresar</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-secondary !px-6 !py-3">Crear cuenta</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="flex justify-center lg:justify-end">
                    <div class="card flex h-72 w-72 items-center justify-center shadow-glow sm:h-80 sm:w-80">
                        <img src="{{ asset('images/brand/isotipo-claro.svg') }}" alt="" class="h-40 w-auto sm:h-48">
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
