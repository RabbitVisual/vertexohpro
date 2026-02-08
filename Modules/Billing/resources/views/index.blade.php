<x-teacherpanel::layouts.master title="Faturamento e Planos">
    <div class="p-6 max-w-6xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
            <div class="z-10">
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Faturamento e Assinatura</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Gerencie seu plano, métodos de pagamento e histórico.</p>
            </div>
            <div class="flex gap-3 z-10">
                <a href="{{ route('billing.edit', 1) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                    <x-icon name="credit-card" style="solid" class="w-4 h-4" />
                    Gerenciar Assinatura
                </a>
            </div>
            <!-- Background Decoration -->
            <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-indigo-50/50 to-transparent dark:from-indigo-900/10 pointer-events-none"></div>
        </div>

        <!-- Current Plan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-indigo-200 text-sm font-bold uppercase tracking-wider mb-1">Seu Plano Atual</p>
                            <h2 class="text-3xl font-bold">Professor Pro</h2>
                        </div>
                        <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold border border-white/20">Ativo</span>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-indigo-200 text-xs mb-1">Próxima Renovação</p>
                            <p class="font-mono font-bold text-lg">15 Dez 2026</p>
                        </div>
                        <div>
                            <p class="text-indigo-200 text-xs mb-1">Valor</p>
                            <p class="font-mono font-bold text-lg">R$ 49,90<span class="text-sm text-indigo-300 font-normal">/mês</span></p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-lg bg-black/20 text-xs border border-white/10">Acesso Ilimitado</span>
                        <span class="px-3 py-1 rounded-lg bg-black/20 text-xs border border-white/10">Suporte Prioritário</span>
                        <span class="px-3 py-1 rounded-lg bg-black/20 text-xs border border-white/10">IA Avançada</span>
                    </div>
                </div>

                <!-- Decor -->
                <x-icon name="gem" style="duotone" class="absolute -bottom-10 -right-10 w-64 h-64 text-white opacity-10 rotate-12" />
            </div>

            <!-- Payment Method -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4">Método de Pagamento</h3>
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-100 dark:border-slate-800 mb-4">
                        <div class="w-10 h-6 bg-slate-800 rounded flex items-center justify-center text-white text-[8px] font-bold">
                            VISA
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-300">•••• •••• •••• 4242</p>
                            <p class="text-xs text-slate-400">Expira em 12/29</p>
                        </div>
                    </div>
                </div>
                <button class="w-full py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Atualizar Cartão
                </button>
            </div>
        </div>

        <!-- Billing History -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Histórico de Faturas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-950 text-xs uppercase text-slate-500 font-bold tracking-wider">
                            <th class="px-6 py-4">Data</th>
                            <th class="px-6 py-4">Descrição</th>
                            <th class="px-6 py-4">Valor</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Download</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <!-- Mock Data -->
                        @foreach([1, 2, 3] as $i)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono text-sm">15/{{ 12 - $i }}/2025</td>
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-white text-sm">Assinatura Pro - Mensal</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-mono text-sm">R$ 49,90</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 uppercase">Pago</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-indigo-600">
                                    <x-icon name="file-arrow-down" style="solid" class="w-4 h-4" />
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
