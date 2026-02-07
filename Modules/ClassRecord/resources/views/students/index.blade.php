<x-classrecord::layouts.master title="Lista de Alunos">
    <x-card title="Meus Alunos">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Turma</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    <!-- Dummy Data for Now -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-white">João Silva</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">6º Ano A</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-button size="sm" variant="ghost" icon="eye">Ver</x-button>
                        </td>
                    </tr>
                     <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-white">Maria Oliveira</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">6º Ano A</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-button size="sm" variant="ghost" icon="eye">Ver</x-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>
</x-classrecord::layouts.master>
