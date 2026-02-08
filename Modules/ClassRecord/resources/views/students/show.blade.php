<x-teacherpanel::layouts.master title="Perfil do Aluno: {{ $student->name }}">
    <div class="p-6 max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center gap-4">
                <a href="{{ route('school-classes.show', $student->class_id) }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                    <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                </a>
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl font-black">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $student->name }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $student->schoolClass->name }} • Matrícula: {{ $student->registration_number ?? '---' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('classrecords.reports.sign', $student->id) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-bold transition shadow-lg shadow-indigo-900/20 flex items-center gap-2">
                    <x-icon name="signature" style="solid" class="w-4 h-4" />
                    Emitir Boletim
                </a>
                <a href="{{ route('students.edit', $student->id) }}" class="bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 px-5 py-2.5 rounded-xl font-medium border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition shadow-sm flex items-center gap-2">
                    <x-icon name="pen" style="solid" class="w-4 h-4" />
                    Editar
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Stats & Grades -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Academic Performance -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Desempenho Acadêmico</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            @for($i=1; $i<=4; $i++)
                                @php $grade = $student->grades->where('cycle', $i)->avg('score'); @endphp
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 text-center">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">{{ $i }}º Ciclo</p>
                                    <p class="text-xl font-black {{ ($grade ?? 0) >= 7 ? 'text-emerald-500' : 'text-amber-500' }}">
                                        {{ $grade ? number_format($grade, 1) : '---' }}
                                    </p>
                                </div>
                            @endfor
                        </div>

                        <!-- Attendance Chart Placeholder -->
                        <div class="h-48 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center text-slate-400">
                            <x-icon name="chart-line" style="solid" class="w-8 h-8 mb-2 opacity-50" />
                            <p class="text-xs font-medium italic">Gráfico de evolução de frequência</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Notas por Avaliação</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Ciclo</th>
                                    <th class="px-6 py-4">Avaliação</th>
                                    <th class="px-6 py-4">Nota</th>
                                    <th class="px-6 py-4">Data</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($student->grades->sortByDesc('created_at') as $grade)
                                    <tr class="text-sm">
                                        <td class="px-6 py-4 font-bold text-indigo-600 dark:text-indigo-400">{{ $grade->cycle }}º Ciclo</td>
                                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">P{{ $grade->evaluation_number }}</td>
                                        <td class="px-6 py-4 font-black {{ $grade->score >= 7 ? 'text-emerald-600' : 'text-amber-600' }}">{{ number_format($grade->score, 1) }}</td>
                                        <td class="px-6 py-4 text-xs text-slate-400">{{ $grade->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic text-sm">Nenhuma nota lançada ainda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Contacts & Quick Info -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-6">Informações Gerais</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400">Frequência Total</span>
                            @php
                                $total = $student->schoolClass->attendances->count();
                                $present = $student->attendances->where('status', 'p')->count();
                                $freq = $total > 0 ? ($present / $total) * 100 : 100;
                            @endphp
                            <span class="font-bold text-indigo-600">{{ number_format($freq, 0) }}%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400">Faltas</span>
                            <span class="font-bold text-red-500">{{ $student->attendances->where('status', 'absent')->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Parents/Contact Card -->
                <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-900/20">
                    <h3 class="font-bold mb-4">Contato do Responsável</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-xs">
                            <x-icon name="envelope" style="solid" class="w-4 h-4 text-indigo-400" />
                            <span class="text-slate-400">Email indisponível</span>
                        </div>
                        <button class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl font-bold text-xs transition">
                            Enviar Aviso via E-mail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
