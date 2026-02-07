<x-core::layouts.master title="Criar Novo Plano">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Novo Plano</h2>
        <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Slug (Identificador)</label>
                <input type="text" name="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Preço (R$)</label>
                <input type="number" step="0.01" name="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Módulos Inclusos</label>
                <div class="space-y-2">
                    @foreach(['planning', 'classrecord', 'library', 'teacherpanel', 'support'] as $mod)
                        <div class="flex items-center">
                            <input type="checkbox" name="modules_access[]" value="{{ $mod }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900 capitalize">{{ $mod }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label class="ml-2 block text-sm text-gray-900">Ativo</label>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.plans.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-2">Cancelar</a>
                <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Salvar</button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
