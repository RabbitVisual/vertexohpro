<x-teacherpanel::layouts.master title="Minha Assinatura">
    <div class="p-6 max-w-5xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Assinatura & Faturamento</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Gerencie seu plano e histórico de pagamentos.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" style="solid" class="w-3 h-3 mr-1.5" />
                    Assinatura Ativa
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Plan Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Current Plan Card -->
                <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden group">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em] mb-2">Plano Atual</p>
                            <h2 class="text-3xl font-black tracking-tight mb-2">Vertex Oh Pro - Premium</h2>
                            <p class="text-slate-400 text-sm max-w-md">Acesso ilimitado ao assistente BNCC, downloads de materiais e gestão completa de turmas.</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-500 uppercase">Valor Mensal</p>
                            <h3 class="text-2xl font-bold italic">R$ 59,90</h3>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 relative z-10">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <p class="text-[10px] text-slate-500 uppercase font-bold mb-1">Próxima Cobrança</p>
                            <p class="text-sm font-bold">15 de Março, 2026</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <p class="text-[10px] text-slate-500 uppercase font-bold mb-1">Método de Pgto</p>
                            <p class="text-sm font-bold flex items-center gap-2">
                                <x-icon name="credit-card" style="solid" class="w-4 h-4 text-indigo-400" />
                                VISA •••• 4242
                            </p>
                        </div>
                    </div>

                    <div class="absolute -right-16 -bottom-16 opacity-5 group-hover:scale-110 transition-transform">
                        <x-icon name="gem" style="solid" class="w-64 h-64" />
                    </div>
                </div>

                <!-- Payment History -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Histórico de Faturas</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @for($i=0; $i<3; $i++)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-slate-800 dark:text-white">Fatura #VTX-{{ 1234 + $i }}</p>
                                            <p class="text-[10px] text-slate-500">Pago em {{ date('d/m/Y', strtotime("-".($i+1)." month")) }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">Pago</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-white">
                                            R$ 59,90
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-slate-400 hover:text-indigo-600 transition-colors">
                                                <x-icon name="download" style="solid" class="w-4 h-4" />
                                            </button>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Account & Support -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-6">Configurações Rápidas</h3>
                    <div class="space-y-3">
                        <button class="w-full bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 py-3 rounded-xl px-4 flex items-center justify-between group transition-all">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 flex items-center gap-3">
                                <x-icon name="credit-card" style="solid" class="w-4 h-4 text-indigo-500" />
                                Alterar Cartão
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-3 h-3 text-slate-400 group-hover:translate-x-1 transition-transform" />
                        </button>
                        <button class="w-full bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 py-3 rounded-xl px-4 flex items-center justify-between group transition-all">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 flex items-center gap-3">
                                <x-icon name="arrows-rotate" style="solid" class="w-4 h-4 text-emerald-500" />
                                Mudar Plano
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-3 h-3 text-slate-400 group-hover:translate-x-1 transition-transform" />
                        </button>
                        <button class="w-full bg-slate-50 dark:bg-slate-100/50 hover:bg-red-50 dark:hover:bg-red-900/10 py-3 rounded-xl px-4 flex items-center justify-between group transition-all">
                            <span class="text-xs font-bold text-red-500 flex items-center gap-3">
                                <x-icon name="circle-xmark" style="solid" class="w-4 h-4" />
                                Cancelar Assinatura
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/20">
                    <h3 class="text-lg font-bold mb-2">Dúvidas?</h3>
                    <p class="text-indigo-100 text-xs mb-6">Nossa equipe de faturamento está pronta para te ajudar com qualquer questão financeira.</p>
                    <a href="{{ route('support.index') }}" class="w-full bg-white text-indigo-600 py-3 rounded-xl font-bold text-sm block text-center hover:bg-slate-50 transition shadow-lg">
                        Falar com Suporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
