<x-core::layouts.master title="Meus Cupons">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-100">Gerenciar Cupons</h1>
            <a href="{{ route('coupons.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2">
                <i class="fa-duotone fa-plus"></i> Novo Cupom
            </a>
        </header>

        <div class="bg-slate-900 rounded-xl border border-slate-800 overflow-hidden">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-950 text-slate-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Código</th>
                        <th class="px-6 py-4">Desconto</th>
                        <th class="px-6 py-4">Validade</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-slate-800/50 transition">
                            <td class="px-6 py-4 font-mono font-bold text-white">{{ $coupon->code }}</td>
                            <td class="px-6 py-4">{{ $coupon->discount_percent }}%</td>
                            <td class="px-6 py-4">
                                {{ $coupon->valid_until ? $coupon->valid_until->format('d/m/Y') : 'Indeterminado' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($coupon->isValid())
                                    <span class="bg-emerald-500/10 text-emerald-400 px-2 py-1 rounded text-xs font-bold">Ativo</span>
                                @else
                                    <span class="bg-red-500/10 text-red-400 px-2 py-1 rounded text-xs font-bold">Expirado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este cupom?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-500 hover:text-red-400 p-2">
                                        <i class="fa-duotone fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i class="fa-duotone fa-ticket text-4xl mb-3 opacity-50"></i>
                                <p>Nenhum cupom criado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $coupons->links() }}
        </div>
    </div>
</x-core::layouts.master>
