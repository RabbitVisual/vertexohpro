@props(['title' => null, 'actions' => null, 'padding' => 'p-6'])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md']) }}>
    @if($title || $actions)
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            @if($title)
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 font-display">
                    {{ $title }}
                </h3>
            @endif

            @if($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
