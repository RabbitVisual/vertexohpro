<x-teacherpanel::layouts.master title="Central de Suporte">
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Central de Ajuda</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Gerencie seus chamados e dúvidas com nossa equipe.</p>
            </div>
            <button @click="Livewire.dispatch('open-modal', { name: 'create-ticket' })" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Novo Chamado
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <x-icon name="circle-check" style="solid" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Resolvidos</p>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">--</h3>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <x-icon name="clock" style="solid" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Em Aberto</p>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">--</h3>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <x-icon name="headset" style="solid" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tkt Médio</p>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">--</h3>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <livewire:support-ticket-list />
        </div>

        <livewire:support-create-ticket />
    </div>
</x-teacherpanel::layouts.master>
