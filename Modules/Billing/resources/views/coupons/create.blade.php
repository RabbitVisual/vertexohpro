<x-core::layouts.master title="Novo Cupom">
    <div class="p-6 max-w-2xl mx-auto">
        <header class="mb-8">
            <a href="{{ route('coupons.index') }}" class="text-slate-400 hover:text-white mb-2 inline-block">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
            <h1 class="text-2xl font-bold text-slate-100">Criar Novo Cupom</h1>
        </header>

        <form action="{{ route('coupons.store') }}" method="POST" class="bg-slate-900 p-6 rounded-xl border border-slate-800 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-400 mb-2">Código do Cupom</label>
                <input type="text" name="code" required class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500 uppercase placeholder-slate-600" placeholder="EX: VOLTAAULAS2026">
                <p class="text-xs text-slate-500 mt-1">Use letras maiúsculas e números.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-400 mb-2">Porcentagem de Desconto (%)</label>
                <input type="number" name="discount_percent" min="1" max="100" required class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-400 mb-2">Válido Até (Opcional)</label>
                <input type="date" name="valid_until" class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500">
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg font-medium transition shadow-lg shadow-indigo-900/50">
                    Criar Cupom
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
