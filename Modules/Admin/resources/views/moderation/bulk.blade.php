<x-core::layouts.master title="Moderação em Massa">
    <div x-data="{
        selected: [],
        allSelected: false,
        toggleAll() {
            this.allSelected = !this.allSelected;
            if (this.allSelected) {
                this.selected = {{ $pendingMaterials->pluck('id') }};
            } else {
                this.selected = [];
            }
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Moderação em Massa ({{ $pendingMaterials->total() }})</h2>

            <div class="flex space-x-2" x-show="selected.length > 0">
                <form action="{{ route('admin.moderation.bulk.action') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">Aprovar Selecionados (<span x-text="selected.length"></span>)</button>
                </form>

                <form action="{{ route('admin.moderation.bulk.action') }}" method="POST" class="flex space-x-2">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <input type="text" name="reason" placeholder="Motivo (opcional)" class="border-gray-300 rounded text-sm">
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reprovar</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" @click="toggleAll()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Autor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingMaterials as $material)
                        <tr>
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $material->id }}" x-model="selected" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $material->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $material->user->full_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $material->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum material pendente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pendingMaterials->links() }}
        </div>
    </div>
</x-core::layouts.master>
