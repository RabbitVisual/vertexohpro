<x-teacherpanel::layouts.master title="Diário de Classe">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Diário de Classe</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Acompanhe a frequência e desempenho de suas turmas.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('school-classes.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                    <x-icon name="plus" style="solid" class="w-4 h-4" />
                    Nova Turma
                </a>
            </div>
        </div>

        <!-- Class Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($classes as $class)
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group flex flex-col overflow-hidden">
                    <div class="p-6 flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <x-icon name="chalkboard-teacher" style="solid" class="w-6 h-6" />
                            </div>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('school-classes.edit', $class->id) }}" class="p-2 text-slate-400 hover:text-amber-500 transition-colors">
                                    <x-icon name="pen" style="solid" class="w-3.5 h-3.5" />
                                </a>
                                <form action="{{ route('school-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Excluir turma e todos os dados vinculados?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <x-icon name="trash" style="solid" class="w-3.5 h-3.5" />
                                    </button>
                                </form>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $class->name }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $class->subject }} • {{ $class->year }}</p>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex -space-x-2">
                                @foreach($class->students->take(4) as $student)
                                    <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[10px] font-bold text-slate-600" title="{{ $student->name }}">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                @endforeach
                                @if($class->students->count() > 4)
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white dark:border-slate-900 flex items-center justify-center text-[10px] font-bold text-slate-400">
                                        +{{ $class->students->count() - 4 }}
                                    </div>
                                @endif
                            </div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $class->students->count() }} Alunos</p>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <a href="{{ route('classrecords.attendance', $class->id) }}" class="flex-1 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-bold py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-200 dark:hover:border-emerald-800 transition-all text-center">
                            Frequência
                        </a>
                        <a href="{{ route('class-record.overview', $class->id) }}" class="flex-1 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-bold py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all text-center">
                            Notas & Insights
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-center">
                    <x-icon name="graduation-cap" style="solid" class="w-16 h-16 text-slate-200 dark:text-slate-800 mb-4" />
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Nenhuma turma cadastrada</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-xs mt-2">Comece criando sua primeira turma para gerenciar diários e notas.</p>
                    <a href="{{ route('school-classes.create') }}" class="mt-6 text-indigo-600 dark:text-indigo-400 font-bold hover:underline">Criar Turma Agora</a>
                </div>
            @endforelse
        </div>
    </div>
</x-teacherpanel::layouts.master>
