<x-teacherpanel::layouts.master title="Editar Chamado">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('support.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Editar Chamado</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Atualize os detalhes do seu pedido de suporte.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-8">
            <p class="text-slate-500 dark:text-slate-400 text-sm italic">O suporte está processando seu chamado. Alterações podem ser feitas através do chat de atendimento.</p>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('support.show', $ticket->uuid ?? $ticket->id) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition duration-200">
                    Abrir Chat de Atendimento
                </a>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
