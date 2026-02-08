<x-teacherpanel::layouts.master title="Cadastrar Novo Aluno">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('school-classes.show', $classId ?? 1) }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Novo Aluno</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Adicione um novo estudante à sua turma.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <form action="{{ route('students.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="space-y-6">
                    <!-- Student Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nome Completo</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" placeholder="Ex: Maria Oliveira dos Santos">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Class Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Turma</label>
                            <select name="class_id" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ ($classId ?? 0) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Registration Number -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Número de Matrícula (Opcional)</label>
                            <input type="text" name="registration_number" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" placeholder="Ex: 2026001">
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('school-classes.show', $classId ?? 1) }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition text-sm">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105">
                        Cadastrar Aluno
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teacherpanel::layouts.master>
