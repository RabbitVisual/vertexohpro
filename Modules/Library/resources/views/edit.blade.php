<x-teacherpanel::layouts.master title="Editar Material">
    <div class="p-6 max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('library.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Editar Material</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Atualize as informações do material "{{ $resource->title }}".</p>
            </div>
        </div>

        <!-- Update Form -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <form action="{{ route('library.update', $resource->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Título do Material</label>
                        <input type="text" name="title" value="{{ $resource->title }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="Ex: Caderno de Atividades de Geografia">
                    </div>

                    <!-- Description -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Descrição Detalhada</label>
                        <textarea name="description" rows="5" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="Explique o que o professor encontrará neste material...">{{ $resource->description }}</textarea>
                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Preço (R$)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">R$</span>
                            <input type="number" step="0.01" name="price" value="{{ $resource->price }}" required class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white">
                        </div>
                        <p class="text-[10px] text-slate-400">Use 0.00 para materiais gratuitos.</p>
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Disciplina</label>
                        <input type="text" name="subject" value="{{ $resource->subject }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-indigo-500 transition-all text-slate-900 dark:text-white" placeholder="Ex: Geografia">
                    </div>

                    <!-- Files -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Arquivo PDF (Opcional)</label>
                        <input type="file" name="file" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        <p class="text-[10px] text-slate-400">Deixe em branco para manter o arquivo atual.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Imagem de Capa (Opcional)</label>
                        <input type="file" name="preview_image" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('library.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition text-sm">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-indigo-900/20 transition-all hover:scale-105">
                        Atualizar Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-teacherpanel::layouts.master>
