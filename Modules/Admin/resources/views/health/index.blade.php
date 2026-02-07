<x-layouts.app title="Saúde do Sistema">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                        <i class="fa-duotone fa-shield-check text-indigo-500 mr-2"></i>
                        Verificação de Integridade (ACL)
                    </h2>
                    @if(!$allGood)
                        <form action="{{ route('admin.health.fix') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold shadow-lg transition-all animate-pulse">
                                <i class="fa-duotone fa-wrench mr-2"></i> Corrigir Automaticamente
                            </button>
                        </form>
                    @else
                        <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-bold">
                            Sistema Saudável
                        </span>
                    @endif
                </div>

                <div class="p-6">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($status as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item['type'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item['status'] === 'OK')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                OK
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                MISSING
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
