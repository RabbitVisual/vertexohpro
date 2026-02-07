@props(['title' => 'Ajuda Rápida', 'videoSrc' => null, 'gifSrc' => null])

<div x-data="{ open: false }" class="inline-block" @keydown.window.escape="open = false">
    <!-- Trigger -->
    <button
        @click="open = true"
        type="button"
        class="text-slate-400 hover:text-indigo-500 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1"
        title="Ajuda sobre esta tela"
        aria-haspopup="dialog"
        :aria-expanded="open"
    >
        <i class="fa-duotone fa-circle-question text-xl"></i>
        <span class="sr-only">Ajuda</span>
    </button>

    <!-- Modal Backdrop & Panel -->
    <div
        x-show="open"
        style="display: none;"
        class="relative z-[60]"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500/75 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity"
            @click="open = false"
            aria-hidden="true"
        ></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    x-show="open"
                    x-trap.noscroll="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="open = false"
                    class="relative transform overflow-hidden rounded-lg bg-white dark:bg-slate-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-700"
                >
                    <div class="bg-white dark:bg-slate-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa-duotone fa-lightbulb-on text-indigo-600 dark:text-indigo-400 text-xl"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title">{{ $title }}</h3>

                                <div class="mt-4 space-y-4">
                                    @if($videoSrc)
                                        <div class="rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                                            <video controls class="w-full">
                                                <source src="{{ $videoSrc }}" type="video/mp4">
                                                Seu navegador não suporta vídeos.
                                            </video>
                                        </div>
                                    @elseif($gifSrc)
                                        <div class="rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
                                            <img src="{{ $gifSrc }}" alt="Demonstração" class="w-full h-auto">
                                        </div>
                                    @endif

                                    <div class="text-sm text-gray-500 dark:text-gray-300 space-y-2">
                                        {{ $slot }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-700/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button
                            type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-slate-600 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-slate-500 hover:bg-gray-50 dark:hover:bg-slate-500 sm:mt-0 sm:w-auto"
                            @click="open = false"
                        >
                            Entendi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
