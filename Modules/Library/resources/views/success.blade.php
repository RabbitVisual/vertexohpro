<x-core::layouts.master title="Compra Realizada!">
    <div class="min-h-screen bg-slate-950 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center shadow-2xl">
            <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="check-circle" class="w-10 h-10 text-emerald-500" />
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">Pagamento Confirmado!</h1>
            <p class="text-slate-400 mb-8">Seu material já está disponível na sua biblioteca.</p>

            <a href="{{ route('library.my-library') }}" class="block w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-emerald-900/20">
                Ir para Minha Biblioteca
            </a>

            <a href="{{ route('library.index') }}" class="block mt-4 text-sm text-slate-500 hover:text-slate-300">
                Voltar para o Marketplace
            </a>
        </div>
    </div>
</x-core::layouts.master>
