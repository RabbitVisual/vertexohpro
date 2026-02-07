<x-core::layouts.master title="Visão Geral da Turma">
    <div class="p-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-slate-100 font-poppins">Visão Geral: {{ $schoolClass->name }}</h1>
            <p class="text-slate-400">{{ $schoolClass->subject }} - {{ $schoolClass->year }}</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Grade Comparison Chart -->
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-800 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Média da Turma por Bimestre</h3>
                <div class="relative h-64">
                    <canvas id="cycleComparisonChart"></canvas>
                </div>
            </div>

            <!-- Actions Panel -->
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-800 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Ações Pedagógicas</h3>

                <div class="space-y-4">
                    <!-- Close Cycle -->
                    <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                        <h4 class="font-medium text-indigo-400 mb-2">Fechamento de Ciclo</h4>
                        <p class="text-sm text-slate-400 mb-4">Bloquear notas e gerar relatórios finais. Requer assinatura.</p>

                        <form action="{{ route('class-record.close-cycle', $schoolClass->id) }}" method="POST" class="space-y-4" onsubmit="return confirm('Tem certeza? Isso bloqueará as notas deste ciclo.')">
                            @csrf
                            <div class="flex gap-2">
                                <select name="cycle" class="bg-slate-900 border-slate-700 text-slate-200 rounded px-3 py-2 text-sm focus:ring-indigo-500 w-full">
                                    <option value="1">1º Bimestre</option>
                                    <option value="2">2º Bimestre</option>
                                    <option value="3">3º Bimestre</option>
                                    <option value="4">4º Bimestre</option>
                                </select>
                            </div>

                            <!-- Signature Pad Integration -->
                            <div class="bg-white p-2 rounded">
                                <x-signature-pad name="signature" label="Assine para confirmar" />
                            </div>

                            <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded text-sm transition font-medium flex items-center justify-center gap-2">
                                <i class="fa-duotone fa-lock"></i>
                                Assinar e Fechar Ciclo
                            </button>
                        </form>
                    </div>

                    <!-- Batch Export -->
                    <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                        <h4 class="font-medium text-indigo-400 mb-2">Relatórios em Lote</h4>
                        <p class="text-sm text-slate-400 mb-4">Baixar boletins de todos os alunos (ZIP).</p>
                        <a href="{{ route('class-record.batch-export', $schoolClass->id) }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded text-sm transition font-medium w-full justify-center">
                            <i class="fa-duotone fa-file-zipper"></i>
                            Gerar Pacote de Boletins
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('vendor/chartjs/chart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('cycleComparisonChart').getContext('2d');

            // Data from controller
            const data = @json($cycleAverages);
            const labels = Object.keys(data).map(k => k + 'º Bimestre');
            const values = Object.values(data);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Média da Turma',
                        data: values,
                        backgroundColor: 'rgba(79, 70, 229, 0.6)', // Indigo-600 with opacity
                        borderColor: 'rgb(79, 70, 229)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#cbd5e1'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-core::layouts.master>
