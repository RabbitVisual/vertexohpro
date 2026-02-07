<x-classrecord::layouts.master title="Importar Alunos">
    <x-card title="Importar Lista de Alunos via CSV">
        <div class="max-w-xl mx-auto">
            <p class="text-sm text-slate-500 mb-4">
                Envie um arquivo CSV contendo apenas uma coluna com o nome dos alunos. A primeira linha (cabeçalho) será ignorada se contiver "Nome" ou "Name".
            </p>

            <form action="{{ route('classrecord.students.process-import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Selecione a Turma</label>
                    <select name="school_class_id" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                        <option value="">Selecione...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }} - {{ $class->subject }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Arquivo CSV</label>
                    <input type="file" name="file" accept=".csv" required class="mt-1 block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                    "/>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" icon="upload">Importar Alunos</x-button>
                </div>
            </form>
        </div>
    </x-card>
</x-classrecord::layouts.master>
