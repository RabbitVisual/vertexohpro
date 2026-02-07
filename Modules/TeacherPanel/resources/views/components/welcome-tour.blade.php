<div x-data="{
         step: 0,
         show: false,
         init() {
             if (!localStorage.getItem('teacher_panel_tour_completed')) {
                 setTimeout(() => {
                     this.show = true;
                     this.step = 1;
                 }, 1000);
             }
         },
         next() {
             this.step++;
         },
         finish() {
             this.show = false;
             localStorage.setItem('teacher_panel_tour_completed', 'true');
         }
     }"
     x-show="show"
     class="fixed inset-0 z-50 pointer-events-none"
     style="display: none;">

    <!-- Overlay backdrop -->
    <div class="absolute inset-0 bg-black/50 pointer-events-auto" @click="finish()"></div>

    <!-- Step 1: Widgets -->
    <div x-show="step === 1"
         class="absolute top-1/4 left-1/2 -translate-x-1/2 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-2xl max-w-sm pointer-events-auto border border-indigo-500"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex flex-col items-center text-center">
            <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-full mb-4">
                <x-icon name="grip-vertical" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Organize seu Espaço</h3>
            <p class="text-slate-600 dark:text-slate-300 mb-6 text-sm">
                Arraste e solte os widgets para personalizar seu painel. A ordem é salva automaticamente!
            </p>
            <button @click="next()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                Próximo
            </button>
        </div>
        <!-- Arrow pointing down -->
        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-white dark:bg-slate-800 border-b border-r border-indigo-500 rotate-45"></div>
    </div>

    <!-- Step 2: Command Center -->
    <div x-show="step === 2"
         class="absolute top-4 right-4 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-2xl max-w-sm pointer-events-auto border border-indigo-500 origin-top-right"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex flex-col items-center text-center">
            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mb-4">
                <x-icon name="magnifying-glass" class="w-8 h-8 text-amber-600 dark:text-amber-400" />
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Busca Rápida</h3>
            <p class="text-slate-600 dark:text-slate-300 mb-6 text-sm">
                Acesse o Command Center (Ctrl+K) para buscar alunos, turmas ou planos de aula instantaneamente.
            </p>
            <button @click="next()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                Próximo
            </button>
        </div>
        <!-- Arrow pointing up-right -->
        <div class="absolute -top-2 right-8 w-4 h-4 bg-white dark:bg-slate-800 border-t border-l border-indigo-500 rotate-45"></div>
    </div>

    <!-- Step 3: Finish -->
    <div x-show="step === 3"
         class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-2xl max-w-sm pointer-events-auto border border-emerald-500"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="flex flex-col items-center text-center">
            <div class="bg-emerald-100 dark:bg-emerald-900/30 p-3 rounded-full mb-4">
                <x-icon name="check" class="w-8 h-8 text-emerald-600 dark:text-emerald-400" />
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Tudo Pronto!</h3>
            <p class="text-slate-600 dark:text-slate-300 mb-6 text-sm">
                Aproveite seu novo painel de controle. Você pode reorganizar tudo quando quiser.
            </p>
            <button @click="finish()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-sm font-medium transition-colors">
                Vamos lá!
            </button>
        </div>
    </div>
</div>
