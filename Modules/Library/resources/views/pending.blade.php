<x-core::layouts.master title="Pagamento Pendente">
    <div class="min-h-screen bg-slate-950 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-2xl p-8 text-center shadow-2xl">
            <div class="w-20 h-20 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="clock" class="w-10 h-10 text-amber-500" />
            </div>

            <h1 class="text-2xl font-bold text-white mb-2">Pagamento em Processamento</h1>
            <p class="text-slate-400 mb-8">Estamos aguardando a confirmação do pagamento. Isso pode levar alguns minutos.</p>

            <a href="{{ route('library.my-library') }}" class="block w-full bg-amber-600 hover:bg-amber-500 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg shadow-amber-900/20">
                Verificar Minha Biblioteca
            </a>
        </div>
    </div>
</x-core::layouts.master>
