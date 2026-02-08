<x-teacherpanel::layouts.master title="Cadastrar Nova Turma">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('classrecord.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Nova Turma</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Configure os detalhes da sua nova turma de ensino.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <form action="{{ route('school-classes.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Class Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nome da Turma</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" placeholder="Ex: 6º Ano A">
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Disciplina / Matéria</label>
                        <input type="text" name="subject" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" placeholder="Ex: Geografia">
                    </div>

                    <!-- Year -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Ano Letivo</label>
                        <input type="text" name="year" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white placeholder-slate-400" value="{{ date('Y') }}">
                    </div>

                    <!-- Grade -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Série / Ciclo</label>
                        <select name="grade" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white">
                            <option value="1">1º Ano</option>
                            <option value="2">2º Ano</option>
                            <option value="3">3º Ano</option>
                            <option value="4">4º Ano</option>
                            <option value="5">5º Ano</option>
                            <option value="6" selected>6º Ano</option>
                            <option value="7">7º Ano</option>
                            <option value="8">8º Ano</option>
                            <option value="9">9º Ano</option>
                            <option value="10">Ensino Médio</option>
                        </select>
                    </div>
                </div>

                <!-- Multigrade Check -->
                <div class="p-4 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 flex items-start gap-4">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_multigrade" value="1" class="w-5 h-5 text-indigo-600 rounded-lg border-slate-300 focus:ring-indigo-600 transition-all">
                    </div>
                    <div class="text-sm">
                        <label class="font-bold text-indigo-900 dark:text-indigo-100">Turma Multisseriada</label>
                        <p class="text-indigo-700 dark:text-indigo-300/80">Marque se esta turma atende mais de uma série simultaneamente.</p>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('classrecord.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition text-sm">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105">
                        Salvar Turma
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teacherpanel::layouts.master>
