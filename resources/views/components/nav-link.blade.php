@props(['active' => false, 'icon' => null])

@php
$classes = $active
    ? 'bg-brand-500 text-white shadow-glow'
    : 'text-ink-soft hover:bg-raised hover:text-ink';
@endphp

<a {{ $attributes->merge(['class' => "group flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400 $classes"]) }}
   @if ($active) aria-current="page" @endif>
    @if ($icon)
        <x-icon :name="$icon" class="h-5 w-5 shrink-0" />
    @endif
    <span>{{ $slot }}</span>
</a>
