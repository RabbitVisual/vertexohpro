<x-teacherpanel::layouts.master title="Meus Planejamentos">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Meus Planejamentos</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Gerencie e organize suas aulas de forma eficiente.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('planning.lesson-plans.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                    <x-icon name="plus" style="solid" class="w-4 h-4" />
                    Novo Plano
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total de Planos</p>
                    <h3 class="text-4xl font-bold text-slate-800 dark:text-white mt-2">{{ $plans->total() }}</h3>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <x-icon name="book-sparkles" style="solid" class="w-32 h-32 text-indigo-500" />
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Este Mês</p>
                    <h3 class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $plans->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <x-icon name="calendar-check" style="solid" class="w-32 h-32 text-emerald-500" />
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Turmas Atendidas</p>
                    <h3 class="text-4xl font-bold text-amber-600 dark:text-amber-400 mt-2">{{ $plans->pluck('school_class_id')->unique()->count() }}</h3>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <x-icon name="users" style="solid" class="w-32 h-32 text-amber-500" />
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Plano</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Turma</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                            <x-icon name="file-pdf" style="solid" class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $plan->title }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{{ $plan->template_type }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $plan->schoolClass->name ?? 'Sem Turma' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $plan->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('planning.lesson-plans.export', $plan->id) }}" class="p-2 text-slate-400 hover:text-emerald-500 transition-colors" x-tooltip="'Exportar PDF'">
                                            <x-icon name="download" style="solid" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('planning.lesson-plans.duplicate', $plan->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 text-slate-400 hover:text-indigo-500 transition-colors" x-tooltip="'Duplicar'">
                                                <x-icon name="copy" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                        <a href="{{ route('planning.lesson-plans.edit', $plan->id) }}" class="p-2 text-slate-400 hover:text-amber-500 transition-colors" x-tooltip="'Editar'">
                                            <x-icon name="pen" style="solid" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('planning.lesson-plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors" x-tooltip="'Excluir'">
                                                <x-icon name="trash" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <x-icon name="book-open" style="solid" class="w-16 h-16 text-slate-200 dark:text-slate-700 mb-4" />
                                        <p class="text-slate-500 dark:text-slate-400">Nenhum planejamento encontrado.</p>
                                        <a href="{{ route('planning.lesson-plans.create') }}" class="text-indigo-600 hover:text-indigo-500 font-bold text-sm mt-2">Comece criando o primeiro!</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($plans->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30">
                    {{ $plans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-teacherpanel::layouts.master>
