<x-teacherpanel::layouts.master title="Lista de Alunos">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Gestão de Alunos</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Gerencie informações, notas e relatórios de seus alunos.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('classrecord.students.import') }}" class="text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 px-5 py-2.5 rounded-xl font-medium border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition shadow-sm flex items-center gap-2">
                    <x-icon name="upload" style="solid" class="w-4 h-4" />
                    Importar
                </a>
                <a href="{{ route('students.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                    <x-icon name="plus" style="solid" class="w-4 h-4" />
                    Novo Aluno
                </a>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row gap-4">
            <form action="{{ route('classrecord.students.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <x-icon name="search" style="solid" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4" />
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou matrícula..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                </div>
                <select name="class_id" class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm min-w-[200px]" onchange="this.form.submit()">
                    <option value="">Todas as Turmas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Student Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aluno</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Turma</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Desempenho</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold group-hover:scale-105 transition-transform">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $student->name }}</p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400">#{{ $student->registration_number ?? 'S/M' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $student->schoolClass->name ?? 'Não Enturmado' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @php
                                            $avg = $student->grades->avg('score') ?? 0;
                                            $color = $avg >= 7 ? 'emerald' : ($avg >= 5 ? 'amber' : 'red');
                                        @endphp
                                        <div class="w-24 h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-{{ $color }}-500 transition-all duration-500" style="width: {{ $avg * 10 }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ number_format($avg, 1) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-2 text-slate-400 hover:text-indigo-500 transition-colors" x-tooltip="'Ver Perfil'">
                                            <x-icon name="eye" style="solid" class="w-4 h-4" />
                                        </button>
                                        <form action="{{ route('classrecord.email_report', $student->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 text-slate-400 hover:text-emerald-500 transition-colors" x-tooltip="'Enviar Boletim'">
                                                <x-icon name="envelope" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Excluir aluno?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                                <x-icon name="trash" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-slate-500">
                                    <p>Nenhum aluno encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($students->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>
</x-teacherpanel::layouts.master>
