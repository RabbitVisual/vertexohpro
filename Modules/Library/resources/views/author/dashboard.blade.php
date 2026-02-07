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
