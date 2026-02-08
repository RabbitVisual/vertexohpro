<x-teacherpanel::layouts.master title="Detalhes do Chamado #{{ $ticket->id }}">
    <div class="p-6 max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('support.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                    <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Chamado #{{ $ticket->id }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $ticket->subject }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-widest
                    @if($ticket->status === 'open') bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400
                    @elseif($ticket->status === 'pending') bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400
                    @else bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 @endif">
                    {{ $ticket->status }}
                </span>
                <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-widest
                    @if($ticket->priority === 'high' || $ticket->priority === 'critical') bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                    @elseif($ticket->priority === 'medium') bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400
                    @else bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 @endif">
                    {{ $ticket->priority }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Chat Area -->
            <div class="lg:col-span-2">
                <livewire:support-ticket-chat :ticket="$ticket" />
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-icon name="circle-info" style="solid" class="w-4 h-4 text-indigo-500" />
                        Detalhes do Ticket
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm pb-3 border-b border-slate-50 dark:border-slate-800">
                            <span class="text-slate-400">Criado em</span>
                            <span class="font-medium text-slate-600 dark:text-slate-300">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm pb-3 border-b border-slate-50 dark:border-slate-800">
                            <span class="text-slate-400">Categoria</span>
                            <span class="font-medium text-slate-600 dark:text-slate-300">{{ $ticket->category ?? 'Geral' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400">Última Resp.</span>
                            <span class="font-medium text-slate-600 dark:text-slate-300">{{ $ticket->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Support Notice -->
                <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-2">Suporte Prioritário</h3>
                        <p class="text-slate-400 text-xs leading-relaxed">Nossa equipe responderá seu chamado em até 24h úteis. Obrigado pela paciência!</p>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                        <x-icon name="headset" style="solid" class="w-24 h-24" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
