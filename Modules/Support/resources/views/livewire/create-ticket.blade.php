<div class="space-y-6">
    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 flex items-start gap-4">
            <div class="text-emerald-500 dark:text-emerald-400">
                <x-icon name="circle-check" style="solid" size="lg" />
            </div>
            <div>
                <h3 class="font-bold text-emerald-900 dark:text-emerald-100">Solicitação Enviada!</h3>
                <p class="text-emerald-700 dark:text-emerald-300 text-sm mt-1">
                    Recebemos seu contato. Em breve um de nossos especialistas retornará.
                    @auth
                        <a href="{{ route('support.index') }}" class="underline font-bold">Acompanhar meu chamado.</a>
                    @else
                        Verifique seu e-mail para acompanhar o status.
                    @endauth
                </p>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Seu Nome</label>
                    <input type="text" id="name" wire:model="name" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-900 dark:text-white" placeholder="Como podemos te chamar?">
                    @error('name') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Seu E-mail</label>
                    <input type="email" id="email" wire:model="email" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-900 dark:text-white" placeholder="seu@email.com">
                    @error('email') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Subject -->
            <div class="space-y-2">
                <label for="subject" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Assunto</label>
                <input type="text" id="subject" wire:model="subject" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-900 dark:text-white" placeholder="Resumo do problema ou dúvida">
                @error('subject') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Priority -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Prioridade</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach(['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta', 'critical' => 'Crítica'] as $value => $label)
                        <label class="cursor-pointer relative">
                            <input type="radio" wire:model="priority" value="{{ $value }}" class="peer sr-only">
                            <div class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-center text-sm font-medium text-slate-600 dark:text-slate-400 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-200 dark:peer-checked:border-indigo-800 transition-all hover:bg-slate-50 dark:hover:bg-slate-800">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('priority') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Message -->
            <div class="space-y-2">
                <label for="message" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Mensagem</label>
                <textarea id="message" wire:model="message" rows="5" class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-900 dark:text-white resize-none" placeholder="Descreva detalhadamente o que você precisa..."></textarea>
                @error('message') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Attachment -->
            <div class="space-y-2">
                <label for="attachment" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Anexo (Opcional)</label>
                <div class="flex items-center justify-center w-full">
                    <label for="attachment" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 dark:border-slate-700 border-dashed rounded-xl cursor-pointer bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <x-icon name="cloud-arrow-up" class="w-8 h-8 mb-3 text-slate-400" />
                            <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">Clique para enviar</span> ou arraste</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">PNG, JPG ou PDF (MAX. 10MB)</p>
                        </div>
                        <input id="attachment" type="file" wire:model="attachment" class="hidden" />
                    </label>
                </div>
                @if ($attachment)
                    <div class="text-sm text-green-600 font-bold mt-2 flex items-center gap-2">
                        <x-icon name="check" size="xs" />
                        Arquivo selecionado: {{ $attachment->getClientOriginalName() }}
                    </div>
                @endif
                @error('attachment') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                <span wire:loading.remove>Enviar Solicitação</span>
                <span wire:loading>
                    <x-icon name="spinner" class="animate-spin" />
                    Enviando...
                </span>
            </button>
        </form>
    @endif
</div>
