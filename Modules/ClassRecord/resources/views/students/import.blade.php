<x-teacherpanel::layouts.master title="Importar Alunos">
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('classrecord.students.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Importar Alunos</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Adicione alunos em massa via arquivo CSV ou Excel.</p>
            </div>
        </div>

        <!-- Import Form -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-8">
            <form action="{{ route('classrecord.students.process-import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Class Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Selecione a Turma</label>
                    <select name="class_id" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white">
                        <option value="">Selecione uma turma...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->grade }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- File Upload -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Arquivo (CSV, XLSX)</label>
                    <input type="file" name="file" required accept=".csv,.xlsx,.xls" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <!-- Instructions -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-300 mb-2 flex items-center gap-2">
                        <x-icon name="circle-info" style="solid" class="w-4 h-4" />
                        Instruções
                    </h4>
                    <p class="text-xs text-indigo-700 dark:text-indigo-400">
                        O arquivo deve conter as colunas: <strong>name</strong>, <strong>registration_number</strong> (opcional).
                        <br>Certifique-se de que os nomes estejam corretos antes de importar.
                    </p>
                </div>

                <!-- Actions -->
                <div class="pt-4 flex justify-end gap-3">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105 flex items-center gap-2">
                        <x-icon name="file-import" style="solid" class="w-4 h-4" />
                        Importar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teacherpanel::layouts.master>
