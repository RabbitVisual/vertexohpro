<x-teacherpanel::layouts.master title="Novo Chamado">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('support.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Novo Chamado</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Descreva sua dúvida ou problema para que possamos te ajudar.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <livewire:support-ticket-create />
        </div>
    </div>
</x-teacherpanel::layouts.master>
