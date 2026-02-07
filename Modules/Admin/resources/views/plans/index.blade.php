<x-core::layouts.master title="Gerenciador de Planos">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Planos de Assinatura</h2>
        <a href="{{ route('admin.plans.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Novo Plano</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($plans as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $plan->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ {{ number_format($plan->price, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $plan->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $plan->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-core::layouts.master>
