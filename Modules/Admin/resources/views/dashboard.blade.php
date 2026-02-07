<x-layouts.app title="Admin Dashboard">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-display">
                    Dashboard Administrativo
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.health') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fa-duotone fa-heart-pulse mr-2"></i> Saúde do Sistema
                    </a>
                    <a href="{{ route('admin.audit') }}" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fa-duotone fa-file-csv mr-2"></i> Auditoria
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Churn Card -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Taxa de Churn</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $churnRate }}%</p>
                        </div>
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                            <i class="fa-duotone fa-user-minus text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 mt-4">
                        {{ $inactiveUsers }} inativos de {{ $totalUsers }} totais
                    </p>
                </div>

                <!-- Total Users -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Usuários Totais</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <i class="fa-duotone fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Growth Chart -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Crescimento de Usuários (30 dias)</h3>
                    <div class="relative h-64">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vendas Mensais</h3>
                    <div class="relative h-64">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Growth Chart
            new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: @json($growthData['labels']),
                    datasets: [{
                        label: 'Novos Usuários',
                        data: @json($growthData['data']),
                        borderColor: '#4f46e5', // Indigo 600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#334155' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Sales Chart
            new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: @json($salesData['labels']),
                    datasets: [{
                        label: 'Vendas (R$)',
                        data: @json($salesData['data']),
                        backgroundColor: '#10b981', // Emerald 500
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#334155' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-layouts.app>
