<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <!-- Barra superior (móvil) -->
    <div class="lg:hidden sticky top-0 z-30 flex h-14 items-center justify-between border-b border-line bg-side/95 px-4 backdrop-blur">
        <a href="{{ route('dashboard') }}" aria-label="Tienda Clic">
            <x-application-logo class="h-8 w-auto" />
        </a>

        <button @click="open = true" type="button"
                class="inline-flex items-center justify-center rounded-lg p-2 text-ink-soft hover:bg-raised hover:text-ink focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400"
                aria-label="Abrir menú">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Fondo oscuro al abrir el menú en móvil -->
    <div x-show="open" x-transition.opacity @click="open = false"
         class="fixed inset-0 z-40 bg-black/60 lg:hidden" style="display: none;"></div>

    <!-- Barra lateral -->
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-line bg-side transition-transform duration-200 lg:translate-x-0">

        <!-- Logotipo -->
        <div class="flex h-16 shrink-0 items-center justify-between px-5">
            <a href="{{ route('dashboard') }}" aria-label="Tienda Clic, ir al panel">
                <img src="{{ asset('images/brand/logotipo-claro.svg') }}" alt="Tienda Clic" class="h-7 w-auto">
            </a>

            <button @click="open = false" type="button"
                    class="rounded-lg p-1.5 text-muted hover:bg-raised hover:text-ink lg:hidden" aria-label="Cerrar menú">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Enlaces -->
        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4" aria-label="Principal">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="panel">
                Panel
            </x-nav-link>
            <x-nav-link :href="route('catalogo.index')" :active="request()->routeIs('catalogo.*')" icon="catalogo">
                Catálogo
            </x-nav-link>
            <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')" icon="categorias">
                Categorías
            </x-nav-link>
            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" icon="productos">
                Productos
            </x-nav-link>
            <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" icon="usuarios">
                Usuarios
            </x-nav-link>
            <x-nav-link :href="route('carrito.index')" :active="request()->routeIs('carrito.*')" icon="carrito">
                Carrito
            </x-nav-link>
            <x-nav-link :href="route('pedidos.index')" :active="request()->routeIs('pedidos.*')" icon="pedidos">
                Pedidos
            </x-nav-link>
            <x-nav-link :href="route('gestion-pedidos.index')" :active="request()->routeIs('gestion-pedidos.*')">
                Gestión de pedidos
            </x-nav-link>
            <x-nav-link :href="route('verificacion-pagos.index')" :active="request()->routeIs('verificacion-pagos.*')">
                Verificar pagos
            </x-nav-link>
        </nav>

        <!-- Cuenta -->
        <div class="border-t border-line p-3">
            <div class="mb-2 flex items-center gap-3 px-3 py-2">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-500/20 text-sm font-semibold text-brand-300">
                    {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-medium text-ink">{{ Auth::user()->name }}</div>
                    <div class="truncate text-xs text-muted">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')" icon="perfil">
                Mi perfil
            </x-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')" icon="salir"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                    Cerrar sesión
                </x-nav-link>
            </form>
        </div>
    </aside>
</div>
