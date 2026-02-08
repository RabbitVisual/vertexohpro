<div class="space-y-6">
    <!-- Filters -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Meus Chamados</h2>
        <div>
            <select wire:model.live="statusFilter" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                <option value="">Todos os Status</option>
                <option value="open">Abertos</option>
                <option value="pending">Pendentes</option>
                <option value="resolved">Resolvidos</option>
                <option value="closed">Fechados</option>
            </select>
        </div>
    </div>

    <!-- Ticket List -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        @if ($tickets->count() > 0)
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($tickets as $ticket)
                    <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-mono text-slate-400">#{{ substr($ticket->uuid, 0, 8) }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                @if($ticket->status === 'open') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                @elseif($ticket->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                @elseif($ticket->status === 'resolved') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @else bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                        <a href="{{ route('support.show', $ticket->uuid) }}" class="block group">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-1">
                                {{ $ticket->subject }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1">
                                {{ $ticket->messages->first()?->message ?? 'Sem mensagens.' }}
                            </p>
                        </a>
                        <div class="mt-4 flex items-center gap-4 text-xs text-slate-400">
                            <div class="flex items-center gap-1">
                                <x-icon name="clock" size="xs" />
                                {{ $ticket->created_at->diffForHumans() }}
                            </div>
                            <div class="flex items-center gap-1">
                                <x-icon name="message" size="xs" />
                                {{ $ticket->messages->count() }} mensagens
                            </div>
                            @if($ticket->priority === 'high' || $ticket->priority === 'critical')
                                <div class="flex items-center gap-1 text-red-500 font-bold">
                                    <x-icon name="circle-exclamation" size="xs" />
                                    Prioridade Alta
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <x-icon name="ticket" size="xl" />
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">Nenhum chamado encontrado</h3>
                <p>Você ainda não abriu nenhuma solicitação de suporte.</p>
                <a href="{{ route('contact') }}" class="mt-6 inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors">
                    Abrir Novo Chamado
                </a>
            </div>
        @endif
    </div>
</div>
