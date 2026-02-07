<x-core::layouts.master title="Painel do Autor">
    <div class="min-h-screen bg-slate-950 text-slate-100 p-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                    <x-icon name="chart-bar" class="w-8 h-8 text-amber-500" />
                    Painel do Autor
                </h1>
                <p class="text-slate-400 mt-1">Acompanhe seus rendimentos e vendas.</p>
            </div>

            <a href="{{ route('library.my-library') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar para Biblioteca
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Sales -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6">
                <div class="text-sm text-slate-400 font-medium mb-1">Vendas Totais (Bruto)</div>
                <div class="text-2xl font-bold text-white">R$ {{ number_format($totalGross, 2, ',', '.') }}</div>
                <div class="text-xs text-emerald-400 mt-2 flex items-center gap-1">
                    <x-icon name="shopping-cart" class="w-3 h-3" />
                    {{ $salesCount }} vendas realizadas
                </div>
            </div>

            <!-- Net Earnings -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="text-sm text-slate-400 font-medium mb-1">Saldo Disponível (90%)</div>
                    <div class="text-3xl font-bold text-indigo-400">R$ {{ number_format($netEarnings, 2, ',', '.') }}</div>
                    <div class="text-xs text-slate-500 mt-2">Taxa da plataforma: 10%</div>
                </div>
            </div>

            <!-- Withdrawal Action -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 flex flex-col justify-center">
                @if($hasPendingWithdrawal)
                    <div class="text-center">
                        <div class="w-12 h-12 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-3 text-amber-500">
                            <x-icon name="clock" class="w-6 h-6" />
                        </div>
                        <h3 class="text-white font-bold mb-1">Solicitação em Análise</h3>
                        <p class="text-xs text-slate-400">Aguarde o processamento do seu saque.</p>
                    </div>
                @else
                    <form action="{{ route('library.author.withdraw') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-lg shadow-emerald-900/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            @if($netEarnings < 50) disabled title="Mínimo R$ 50,00" @endif
                        >
                            <x-icon name="currency-dollar" class="w-5 h-5" />
                            Solicitar Saque
                        </button>
                        <p class="text-center text-xs text-slate-500 mt-3">Mínimo para saque: R$ 50,00</p>
                    </form>
                @endif
            </div>
        </div>

        <!-- Recent Sales Table -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
                <h3 class="font-bold text-white">Histórico Recente de Vendas</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-950 text-slate-500 uppercase font-medium">
                        <tr>
                            <th class="px-6 py-3">Data</th>
                            <th class="px-6 py-3">Material</th>
                            <th class="px-6 py-3 text-right">Valor Pago</th>
                            <th class="px-6 py-3 text-right">Sua Parte (90%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($recentSales as $sale)
                            <tr class="hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-white">
                                    {{ $sale->material_title }}
                                </td>
                                <td class="px-6 py-4 text-right text-slate-300">
                                    R$ {{ number_format($sale->price_paid, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-emerald-400">
                                    R$ {{ number_format($sale->price_paid * 0.90, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    Nenhuma venda registrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
<x-core::layouts.master title="Dashboard Financeiro">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Painel do Autor</h2>
        <p class="text-gray-600">Acompanhe suas vendas e saldo.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Card Total Sales -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <x-icon name="chart-line" class="h-8 w-8" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Total de Vendas</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($totalSales, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Card Available Balance -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-emerald-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                    <x-icon name="wallet" class="h-8 w-8" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase">Saldo Disponível (90%)</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($availableBalance, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Histórico de Vendas</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor (R$)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($salesHistory as $sale)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->resource->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->user->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">{{ number_format($sale->amount, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Nenhuma venda registrada ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $salesHistory->links() }}
        </div>
    </div>
</x-core::layouts.master>
