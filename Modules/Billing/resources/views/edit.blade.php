<x-teacherpanel::layouts.master title="Dados de Faturamento">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('billing.show', 'current') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Dados de Faturamento</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Atualize suas informações de pagamento e endereço.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <form action="{{ route('billing.update', 'current') }}" method="POST" class="p-8 space-y-6 text-sm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">Nome no Cartão</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="REINAN RODRIGUES">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">Número do Cartão</label>
                        <div class="relative">
                            <input type="text" class="w-full pl-12 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="•••• •••• •••• 4242">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <x-icon name="credit-card" style="solid" class="w-5 h-5" />
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">Expiração</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="05/30">
                    </div>
                    <div class="space-y-2">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">CVC</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="•••">
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('billing.show', 'current') }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-50 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105 active:scale-95">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teacherpanel::layouts.master>
