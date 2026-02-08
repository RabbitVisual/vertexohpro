<x-layouts.app title="Gestão de Suporte (Admin) - Vertex Oh Pro!">
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Gestão de Chamados</h1>
            <div class="flex gap-2">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Abertos: {{ $tickets->where('status', 'open')->count() }}</span>
                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Pendentes: {{ $tickets->where('status', 'pending')->count() }}</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">ID / Assunto</th>
                        <th class="p-4 font-semibold">Usuário</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Prioridade</th>
                        <th class="p-4 font-semibold">Criado em</th>
                        <th class="p-4 font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="p-4">
                                <span class="font-mono text-xs text-slate-400 block">#{{ substr($ticket->uuid, 0, 8) }}</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $ticket->subject }}</span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">
                                        {{ substr($ticket->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <span class="text-slate-600 dark:text-slate-300">{{ $ticket->user->name ?? 'Convidado' }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    @if($ticket->status === 'open') bg-emerald-100 text-emerald-700
                                    @elseif($ticket->status === 'pending') bg-amber-100 text-amber-700
                                    @elseif($ticket->status === 'resolved') bg-blue-100 text-blue-700
                                    @else bg-slate-100 text-slate-600 @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold
                                    @if($ticket->priority === 'high' || $ticket->priority === 'critical') text-red-500
                                    @elseif($ticket->priority === 'medium') text-amber-500
                                    @else text-emerald-500 @endif">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-500">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4">
                                <a href="{{ route('admin.support.show', $ticket->uuid) }}" class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline">
                                    Gerenciar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">Nenhum chamado encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
