<x-teacherpanel::layouts.master title="Visão Geral da Turma">
    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <x-icon name="chalkboard-teacher" style="solid" class="w-7 h-7" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $class->name }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $class->subject }} • {{ $class->year }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('class-record.overview', $class->id) }}" class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-5 py-2.5 rounded-xl font-bold transition flex items-center gap-2">
                    <x-icon name="chart-mixed" style="solid" class="w-4 h-4" />
                    Insights Avançados
                </a>
                <a href="{{ route('school-classes.edit', $class->id) }}" class="bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 px-5 py-2.5 rounded-xl font-medium border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition shadow-sm flex items-center gap-2">
                    <x-icon name="pen" style="solid" class="w-4 h-4" />
                    Configurar
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total de Alunos</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $class->students->count() }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Média Geral</p>
                @php $avg = $class->students->flatMap->grades->avg('score') ?? 0; @endphp
                <h3 class="text-3xl font-bold {{ $avg >= 7 ? 'text-emerald-500' : 'text-amber-500' }}">{{ number_format($avg, 1) }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Frequência</p>
                @php
                    $totalAtt = $class->attendances->count();
                    $present = $class->attendances->where('status', 'p')->count();
                    $freq = $totalAtt > 0 ? ($present / $totalAtt) * 100 : 100;
                @endphp
                <h3 class="text-3xl font-bold text-indigo-500">{{ number_format($freq, 0) }}%</h3>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lições Dadas</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $class->classDiaries->count() }}</h3>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Student List Card -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Lista de Alunos</h3>
                    <a href="{{ route('students.create', ['class_id' => $class->id]) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 shadow-lg shadow-indigo-900/20 transition-all hover:scale-105">
                        <x-icon name="user-plus" style="solid" class="w-3.5 h-3.5" />
                        Novo Aluno
                    </a>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                <th class="px-6 py-4">Aluno</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Média</th>
                                <th class="px-6 py-4 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($class->students->take(10) as $student)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group text-sm">
                                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $sAvg = $student->grades->avg('score') ?? 0; @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $sAvg >= 7 ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                            {{ $sAvg >= 7 ? 'Regular' : 'Atenção' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold">
                                        {{ number_format($sAvg, 1) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('students.show', $student->id) }}" class="text-slate-400 hover:text-indigo-600">
                                            <x-icon name="eye" style="solid" class="w-4 h-4" />
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Side Cards -->
            <div class="space-y-6">
                <!-- Recent Activities -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Atividades Recentes</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        @forelse($class->classDiaries->take(5) as $diary)
                            <div class="flex gap-4 relative">
                                <div class="w-2 bg-indigo-500 rounded-full h-full absolute left-[-1rem]"></div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ $diary->date->format('d M, Y') }}</p>
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-white mt-1">{{ $diary->content['title'] ?? 'Aula Registrada' }}</h4>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Nenhuma atividade registrada.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl shadow-indigo-900/20">
                    <h3 class="text-lg font-bold mb-4">Ações Rápidas</h3>
                    <div class="space-y-3">
                        <a href="{{ route('classrecords.attendance', $class->id) }}" class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl text-left px-4 flex items-center justify-between group transition-all">
                            <span class="text-sm font-bold flex items-center gap-3">
                                <x-icon name="calendar-check" style="solid" class="w-4 h-4 text-indigo-400" />
                                Lançar Frequência
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                        </a>
                        <button class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl text-left px-4 flex items-center justify-between group transition-all">
                            <span class="text-sm font-bold flex items-center gap-3">
                                <x-icon name="file-invoice" style="solid" class="w-4 h-4 text-emerald-400" />
                                Lançar Notas
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                        </button>
                        <button class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl text-left px-4 flex items-center justify-between group transition-all">
                            <span class="text-sm font-bold flex items-center gap-3">
                                <x-icon name="envelope" style="solid" class="w-4 h-4 text-amber-400" />
                                Emitir Boletins
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
