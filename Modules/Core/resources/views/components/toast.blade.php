@props(['type' => 'info', 'message'])

@php
    $colors = [
        'success' => 'bg-emerald-500/10 border-emerald-500 text-emerald-600 dark:text-emerald-400',
        'error' => 'bg-red-500/10 border-red-500 text-red-600 dark:text-red-400',
        'warning' => 'bg-amber-500/10 border-amber-500 text-amber-600 dark:text-amber-400',
        'info' => 'bg-indigo-500/10 border-indigo-500 text-indigo-600 dark:text-indigo-400',
    ];

    $icons = [
        'success' => 'check-circle',
        'error' => 'circle-exclamation',
        'warning' => 'triangle-exclamation',
        'info' => 'circle-info',
    ];

    $style = $colors[$type] ?? $colors['info'];
    $icon = $icons[$type] ?? $icons['info'];
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto border-l-4 {{ $style }} bg-white dark:bg-slate-900 overflow-hidden mb-3">
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-icon :name="$icon" class="h-6 w-6" />
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false" class="inline-flex text-slate-400 hover:text-slate-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <x-icon name="times" class="h-5 w-5" />
                </button>
            </div>
        </div>
    </div>
</div>
