<div class="flex flex-col h-[600px] bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-950">
        <div>
            <h2 class="font-bold text-slate-800 dark:text-slate-200 text-lg">{{ $ticket->subject }}</h2>
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>#{{ substr($ticket->uuid, 0, 8) }}</span>
                <span>&bull;</span>
                <span class="{{ $ticket->status === 'open' ? 'text-emerald-500' : 'text-slate-500' }}">
                    {{ ucfirst($ticket->status) }}
                </span>
            </div>
        </div>
        <div class="text-xs text-slate-400">
            Atualização em tempo real <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block ml-1 animate-pulse"></span>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4" wire:poll.7s>
        @foreach ($messages as $msg)
            <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] {{ $msg->user_id === auth()->id() ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-bl-none' }} rounded-2xl p-4 shadow-sm relative group">
                    @if($msg->attachment_path)
                        <div class="mb-2 p-2 bg-white/20 rounded-lg">
                            <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank" class="flex items-center gap-2 text-sm underline hover:text-indigo-200">
                                <x-icon name="paperclip" size="xs" />
                                Ver Anexo
                            </a>
                        </div>
                    @endif

                    <p class="whitespace-pre-wrap text-sm leading-relaxed">{{ $msg->message }}</p>

                    <div class="text-[10px] opacity-70 mt-1 flex items-center gap-1 justify-end">
                        {{ $msg->created_at->format('H:i') }}
                        @if($msg->user_id !== auth()->id())
                            <span class="font-bold ml-1">{{ $msg->user->name ?? 'Suporte' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input Area -->
    <div class="p-4 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
        @if($ticket->status !== 'closed')
            <form wire:submit.prevent="sendMessage" class="relative">
                <div class="flex gap-2">
                    <div class="flex-1 relative">
                        <textarea wire:model="newMessage" rows="1" class="block w-full pl-4 pr-12 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-900 dark:text-white resize-none" placeholder="Digite sua resposta..."></textarea>

                        <label for="chat-attachment" class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 hover:text-indigo-600 transition-colors">
                            <x-icon name="paperclip" />
                            <input type="file" id="chat-attachment" wire:model="attachment" class="hidden">
                        </label>
                    </div>

                    <button type="submit" class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                        <x-icon name="paper-plane" wire:loading.remove />
                        <x-icon name="spinner" class="animate-spin" wire:loading />
                    </button>
                </div>
                @error('newMessage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                @if ($attachment)
                    <div class="text-xs text-green-600 font-bold mt-1 flex items-center gap-1">
                        <x-icon name="check" size="2xs" /> {{ $attachment->getClientOriginalName() }}
                    </div>
                @endif
            </form>
        @else
            <div class="text-center p-4 bg-slate-100 dark:bg-slate-800 rounded-xl text-slate-500 dark:text-slate-400 text-sm">
                <x-icon name="lock" class="mb-2" />
                <p>Este chamado foi encerrado. Caso precise, abra uma nova solicitação.</p>
            </div>
        @endif
    </div>
</div>
