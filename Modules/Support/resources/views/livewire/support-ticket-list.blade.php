<div class="overflow-x-auto">
    <table class="w-full text-left bg-white dark:bg-slate-900">
        <thead>
            <tr class="border-b border-slate-100 dark:border-slate-800 text-xs uppercase tracking-wider text-slate-500 font-bold bg-slate-50/50 dark:bg-slate-900/50">
                <th class="px-6 py-4">Assunto</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Prioridade</th>
                <th class="px-6 py-4 text-right">Data</th>
                <th class="px-6 py-4 text-right">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
            @forelse($tickets as $ticket)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <x-icon name="ticket" style="solid" class="w-4 h-4" />
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $ticket->subject }}</p>
                                <p class="text-xs text-slate-500">ID: #{{ $ticket->uuid }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                            {{ $ticket->status === 'open' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' :
                               ($ticket->status === 'closed' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400') }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                            {{ $ticket->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-xs text-slate-500">
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('support.show', $ticket->uuid) }}" class="text-slate-400 hover:text-indigo-600 transition">
                            <x-icon name="eye" style="solid" class="w-4 h-4" />
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-2">
                            <x-icon name="inbox" style="solid" class="w-8 h-8 opacity-50" />
                            <p class="text-sm">Nenhum chamado encontrado.</p>
                            <button @click="Livewire.dispatch('open-modal', { name: 'create-ticket' })" class="mt-2 text-indigo-600 hover:text-indigo-500 text-sm font-bold flex items-center gap-2">
                                <x-icon name="plus" style="solid" class="w-3 h-3" />
                                Abrir Novo Chamado
                            </button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
        {{ $tickets->links() }}
    </div>
</div>
