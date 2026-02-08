<div
    x-data="{ show: @entangle('showModal') }"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false"
        class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
    ></div>

    <!-- Modal -->
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl p-8 border border-slate-200 dark:border-slate-800"
    >
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Novo Chamado</h2>
            <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition">
                <x-icon name="xmark" style="solid" class="w-5 h-5" />
            </button>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Subject -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Assunto</label>
                <input type="text" wire:model.defer="subject" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" placeholder="Ex: Erro ao gerar relatório">
                @error('subject') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Priority -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Prioridade</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="priority" value="low" class="peer sr-only">
                        <div class="text-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 dark:peer-checked:bg-blue-900/20 dark:peer-checked:text-blue-400 transition-all text-sm font-medium text-slate-600 dark:text-slate-400">
                            Baixa
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="priority" value="medium" class="peer sr-only">
                        <div class="text-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 dark:peer-checked:bg-amber-900/20 dark:peer-checked:text-amber-400 transition-all text-sm font-medium text-slate-600 dark:text-slate-400">
                            Média
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="priority" value="high" class="peer sr-only">
                        <div class="text-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-800 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 dark:peer-checked:bg-red-900/20 dark:peer-checked:text-red-400 transition-all text-sm font-medium text-slate-600 dark:text-slate-400">
                            Alta
                        </div>
                    </label>
                </div>
            </div>

            <!-- Message -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Mensagem</label>
                <textarea wire:model.defer="message" rows="5" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400 resize-none" placeholder="Descreva seu problema com detalhes..."></textarea>
                @error('message') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" wire:click="closeModal" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition">Cancelar</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                    <x-icon name="paper-plane-top" style="solid" class="w-4 h-4" />
                    Enviar Chamado
                </button>
            </div>
        </form>
    </div>
</div>
