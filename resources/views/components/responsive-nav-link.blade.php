{{-- El menú lateral ya es responsivo; este componente se mantiene por compatibilidad con Breeze. --}}
@props(['active' => false, 'icon' => null])

<x-nav-link :active="$active" :icon="$icon" {{ $attributes }}>{{ $slot }}</x-nav-link>
