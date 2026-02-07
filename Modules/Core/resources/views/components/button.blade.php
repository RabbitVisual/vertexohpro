@props([
    'variant' => 'primary', // primary, secondary, danger, ghost, outline
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => null,
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm focus:ring-indigo-500 border border-transparent',
        'secondary' => 'bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 shadow-sm focus:ring-indigo-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm focus:ring-red-500 border border-transparent',
        'ghost' => 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:ring-slate-500',
        'outline' => 'bg-transparent border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 focus:ring-indigo-500',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <x-icon name="spinner" class="fa-spin mr-2" wire:loading wire:target="{{ $loading }}" />
        @endif

        @if($icon && $iconPosition === 'left' && !$loading)
            <x-icon :name="$icon" class="mr-2" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-icon :name="$icon" class="ml-2" />
        @endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <x-icon name="spinner" class="fa-spin mr-2" wire:loading wire:target="{{ $loading }}" />
        @endif

        @if($icon && $iconPosition === 'left' && !$loading)
            <x-icon :name="$icon" class="mr-2" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-icon :name="$icon" class="ml-2" />
        @endif
    </button>
@endif
