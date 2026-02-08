<x-teacherpanel::layouts.master title="Escolher Plano">
    <div class="p-6 max-w-5xl mx-auto space-y-12">
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">Evolua sua Prática Docente</h1>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto italic">Escolha o plano ideal para transformar sua sala de aula com a potência da BNCC e inteligência artificial.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Free Plan -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full uppercase tracking-widest">Iniciante</span>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Plano Grátis</h3>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-4xl font-black text-slate-900 dark:text-white">R$ 0</span>
                    <span class="text-slate-400 text-sm">/mês</span>
                </div>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <x-icon name="check" style="solid" class="w-4 h-4 text-emerald-500" />
                        Até 2 turmas
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <x-icon name="check" style="solid" class="w-4 h-4 text-emerald-500" />
                        5 Planos de Aula/mês
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-300 dark:text-slate-600 line-through">
                        <x-icon name="xmark" style="solid" class="w-4 h-4" />
                        Assistente BNCC Mágico
                    </li>
                </ul>
                <button class="w-full py-4 rounded-2xl font-bold text-sm border-2 border-slate-100 dark:border-slate-800 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Plano Atual</button>
            </div>

            <!-- Pro Plan -->
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-indigo-900/40 space-y-8 relative overflow-hidden border-4 border-indigo-500">
                <div class="absolute top-6 right-6">
                    <span class="bg-indigo-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-lg">Mais Popular</span>
                </div>
                <div class="space-y-2">
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Ilimitado</span>
                    <h3 class="text-3xl font-black">Vertex Oh Pro</h3>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-5xl font-black text-white">R$ 59,90</span>
                    <span class="text-indigo-300 text-sm">/mês</span>
                </div>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm">
                        <x-icon name="star-shooting" style="solid" class="w-4 h-4 text-amber-400" />
                        Turmas Ilimitadas
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <x-icon name="star-shooting" style="solid" class="w-4 h-4 text-amber-400" />
                        IA BNCC Assistente Completo
                    </li>
                    <li class="flex items-center gap-3 text-sm">
                        <x-icon name="star-shooting" style="solid" class="w-4 h-4 text-amber-400" />
                        Exportação PDF Premium
                    </li>
                </ul>
                <button class="w-full bg-indigo-500 hover:bg-indigo-400 text-white py-5 rounded-3xl font-black text-lg shadow-xl shadow-indigo-950 transition-all hover:scale-105 active:scale-95">Upgrade Agora</button>

                <div class="absolute -right-12 -bottom-12 opacity-10">
                    <x-icon name="rocket-launch" style="solid" class="w-48 h-48" />
                </div>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
