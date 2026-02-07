<div
    x-data="{
        open: false,
        toggle() { this.open = !this.open; if(this.open) $nextTick(() => $refs.searchInput.focus()); }
    }"
    @keydown.window.cmd.k.prevent="toggle()"
    @keydown.window.ctrl.k.prevent="toggle()"
    @keydown.window.escape="open = false"
    class="relative z-[100]"
    role="dialog"
    aria-modal="true"
    style="display: none;"
    x-show="open"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500/75 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity"
        @click="open = false">
    </div>

    <!-- Panel -->
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto p-4 sm:p-6 md:p-20">
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="mx-auto max-w-2xl transform divide-y divide-gray-100 dark:divide-slate-700 overflow-hidden rounded-xl bg-white dark:bg-slate-800 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
        >
            <!-- Search Input -->
            <div class="relative">
                <i class="fa-duotone fa-magnifying-glass absolute top-3.5 left-4 h-5 w-5 text-gray-400 dark:text-slate-500"></i>
                <input
                    x-ref="searchInput"
                    wire:model.live.debounce.250ms="query"
                    type="text"
                    class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:ring-0 sm:text-sm"
                    placeholder="Busque por turmas, alunos ou módulos..."
                    role="combobox"
                    aria-expanded="false"
                    aria-controls="options"
                >
            </div>

            <!-- Results -->
            @if(count($results) > 0)
                <ul class="max-h-96 scroll-py-3 overflow-y-auto p-3" id="options" role="listbox">
                    @foreach($results as $index => $result)
                        <li class="group flex cursor-default select-none rounded-xl p-3 hover:bg-indigo-50 dark:hover:bg-indigo-900/20" id="option-{{ $index }}" role="option" tabindex="-1">
                            <a href="{{ $result['url'] }}" class="flex flex-1" wire:navigate>
                                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                                    <i class="fa-duotone fa-{{ $result['icon'] }} h-6 w-6 text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <div class="ml-4 flex-auto">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                        {{ $result['title'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-500/70 dark:group-hover:text-indigo-300/70">
                                        {{ $result['subtitle'] }}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @elseif(strlen($query) >= 2)
                <div class="px-6 py-14 text-center text-sm sm:px-14">
                    <i class="fa-duotone fa-circle-exclamation mx-auto h-6 w-6 text-gray-400 dark:text-slate-500"></i>
                    <p class="mt-4 font-semibold text-gray-900 dark:text-white">Nenhum resultado encontrado</p>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Não conseguimos encontrar nada com esse termo. Tente novamente.</p>
                </div>
            @else
                 <div class="px-6 py-14 text-center text-sm sm:px-14">
                    <div class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-600 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-700/50">
                        <i class="fa-duotone fa-command text-2xl"></i>
                    </div>
                    <p class="mt-4 font-semibold text-gray-900 dark:text-white">Command Center</p>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Digite para buscar rapidamente. <br>
                        <span class="text-xs text-gray-400 dark:text-slate-500 mt-2 block">Dica: Use as setas para navegar (futuro).</span>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
