<x-layouts.app title="Gerenciar Chamado - Admin - Vertex Oh Pro!">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.support.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors">
                <x-icon name="arrow-left" size="sm" />
                Voltar para lista
            </a>

            <div class="flex gap-2">
                <!-- Status Actions could go here, managed by Livewire likely -->
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <!-- Reusing component but maybe we need admin mode?
                     TicketChat component checks Auth::id().
                     If admin is just a user with role, it works.
                     We might want to visually distinguish admin messages.
                     TicketChat component sets is_admin = false.
                     We should probably update TicketChat to support Admin mode or create AdminTicketChat.

                     For now, reusing TicketChat. It will post as the logged in user (Admin).
                     But 'is_admin' column won't be true unless we update logic.
                     Let's stick to simple reuse for MVP, or I can update `TicketChat` to check `isAdmin` trait/role.
                -->
                <livewire:support-ticket-chat :ticket="$ticket" />
            </div>

            <div class="space-y-6">
                <!-- Admin Controls -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <h3 class="font-bold text-slate-800 dark:text-slate-200 mb-4">Gerenciar Chamado</h3>

                    <!-- We would ideally have a Livewire component here to change status/priority -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Atual</label>
                            <span class="px-3 py-1 rounded-full text-xs font-bold inline-block
                                @if($ticket->status === 'open') bg-emerald-100 text-emerald-700
                                @elseif($ticket->status === 'pending') bg-amber-100 text-amber-700
                                @elseif($ticket->status === 'resolved') bg-blue-100 text-blue-700
                                @else bg-slate-100 text-slate-600 @endif">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Usuário</label>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold">
                                    {{ substr($ticket->user->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $ticket->user->name ?? 'Convidado' }}</p>
                                    <p class="text-xs text-slate-500">{{ $ticket->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
