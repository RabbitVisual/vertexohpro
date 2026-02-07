<x-core::layouts.master title="Erro no Pagamento">
    <div class="min-h-screen bg-slate-950 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center shadow-2xl">
            <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="x-circle" class="w-10 h-10 text-red-500" />
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">Pagamento Não Realizado</h1>
            <p class="text-slate-400 mb-8">Houve um problema ao processar seu pagamento. Por favor, tente novamente.</p>

            <a href="{{ route('library.index') }}" class="block w-full bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-4 rounded-xl transition-colors">
                Voltar para o Marketplace
            </a>
        </div>
    </div>
</x-core::layouts.master>
