<x-classrecord::layouts.master title="Detalhes da Turma">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $class->name }} - {{ $class->subject }}</h1>
        <div class="flex gap-2">
            <x-button href="{{ route('classrecord.classes.export', $class->id) }}" icon="download" variant="secondary">
                Backup da Turma (Excel/CSV)
            </x-button>
        </div>
    </div>

    <!-- Class Details Content -->
    <x-card title="Visão Geral">
        <p>Total de Alunos: {{ $class->students()->count() }}</p>
        <!-- Add more details as needed -->
    </x-card>
</x-classrecord::layouts.master>
