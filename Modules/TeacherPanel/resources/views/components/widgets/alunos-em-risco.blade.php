<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800"
     x-data="{
         students: [],
         loading: true,
         init() {
             fetch('{{ route('teacherpanel.widgets.students_at_risk') }}')
                 .then(res => res.json())
                 .then(data => {
                     this.students = data;
                     this.loading = false;
                 })
                 .catch(err => {
                     console.error('Failed to load students at risk', err);
                     this.loading = false;
                 });
         }
     }">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Alunos em Risco
        </h3>
        <x-icon name="triangle-exclamation" class="w-5 h-5 text-amber-500" />
    </div>

    <div x-show="loading" class="flex justify-center items-center h-32">
        <x-icon name="spinner" class="w-6 h-6 animate-spin text-indigo-500" />
    </div>

    <div x-show="!loading && students.length === 0" class="flex flex-col items-center justify-center h-32 text-slate-500">
        <x-icon name="check-circle" class="w-8 h-8 text-emerald-500 mb-2" />
        <span class="text-sm">Nenhum aluno em risco!</span>
    </div>

    <ul x-show="!loading && students.length > 0" class="space-y-3 overflow-y-auto max-h-64 pr-2 custom-scrollbar">
        <template x-for="student in students" :key="student.id">
            <li class="p-3 bg-red-50 dark:bg-red-900/20 rounded-md border-l-4 border-red-500">
                <div class="flex justify-between items-start mb-1">
                    <span class="font-semibold text-sm text-slate-800 dark:text-slate-200" x-text="student.name"></span>
                    <span class="text-xs font-mono text-slate-500" x-text="student.class_name"></span>
                </div>

                <div class="flex flex-col gap-1 text-xs">
                    <div x-show="student.is_risk_grade" class="flex items-center gap-1 text-red-600 dark:text-red-400">
                        <x-icon name="chart-simple" class="w-3 h-3" />
                        <span>Média: <strong x-text="student.average_grade"></strong></span>
                    </div>
                    <div x-show="student.is_risk_attendance" class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                        <x-icon name="user-clock" class="w-3 h-3" />
                        <span>Faltas: <strong x-text="student.absence_rate + '%'"></strong></span>
                    </div>
                </div>
            </li>
        </template>
    </ul>
</div>
