<x-core::layouts.master title="Minha Biblioteca">
    <div class="min-h-screen bg-slate-950 text-slate-100 p-8" x-data="{ search: '', tab: 'purchased' }">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                    <x-icon name="book-open" class="w-8 h-8 text-emerald-500" />
                    Minha Biblioteca
                </h1>
                <p class="text-slate-400 mt-1">Gerencie seus materiais adquiridos e criados.</p>
            </div>

            <!-- Search Bar -->
            <div class="relative group w-full md:w-96">
                <x-icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 group-focus-within:text-emerald-500 transition-colors" />
                <input
                    type="text"
                    x-model="search"
                    placeholder="Pesquisar em seus materiais..."
                    class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent placeholder-slate-500 shadow-sm transition-all"
                >
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex items-center gap-6 border-b border-slate-800 mb-8">
            <button
                @click="tab = 'purchased'"
                class="pb-4 text-sm font-bold uppercase tracking-wide transition-colors relative"
                :class="tab === 'purchased' ? 'text-emerald-500' : 'text-slate-400 hover:text-slate-300'"
            >
                Comprados
                <span x-show="tab === 'purchased'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 rounded-t-full"></span>
            </button>
            <button
                @click="tab = 'created'"
                class="pb-4 text-sm font-bold uppercase tracking-wide transition-colors relative"
                :class="tab === 'created' ? 'text-emerald-500' : 'text-slate-400 hover:text-slate-300'"
            >
                Criados por Mim
                <span x-show="tab === 'created'" class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 rounded-t-full"></span>
            </button>
        </div>

        <!-- Content: Purchased -->
        <div x-show="tab === 'purchased'" class="space-y-6">
            @if($purchased->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($purchased as $material)
                        <div
                            class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-emerald-500/50 transition-all duration-300 group flex flex-col h-full"
                            data-search="{{ strtolower($material->title . ' ' . $material->description) }}"
                            x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
                            x-transition
                        >
                            <div class="p-5 flex-1">
                                <div class="flex items-start justify-between mb-4">
                                    @php
                                        $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                        $icon = match($ext) {
                                            'pdf' => 'file-pdf',
                                            'doc', 'docx' => 'file-word',
                                            'zip', 'rar' => 'file-zipper',
                                            default => 'file',
                                        };
                                    @endphp
                                    <div class="bg-slate-800 p-2.5 rounded-lg text-slate-400 group-hover:text-emerald-400 transition-colors">
                                        <x-icon name="{{ $icon }}" class="w-6 h-6" />
                                    </div>
                                    <div class="text-xs font-mono text-slate-500 bg-slate-800 px-2 py-1 rounded">
                                        {{ $material->pivot->purchased_at ? \Carbon\Carbon::parse($material->pivot->purchased_at)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                                    <a href="{{ route('library.show', $material->id) }}" class="hover:text-emerald-400 transition-colors">{{ $material->title }}</a>
                                </h3>
                                <p class="text-sm text-slate-400 line-clamp-2">{{ $material->description }}</p>
                            </div>

                            <div class="bg-slate-800/50 px-5 py-4 border-t border-slate-800 flex items-center justify-between">
                                <a href="{{ route('library.show', $material->id) }}" class="text-sm font-bold text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                                    <x-icon name="eye" class="w-4 h-4" />
                                    Detalhes
                                </a>
                                <button
                                    @click="
                                        fetch('{{ route('api.materials.link', $material->id) }}')
                                            .then(res => res.json())
                                            .then(data => {
                                                if(data.url) {
                                                    window.location.href = data.url;
                                                    $dispatch('toast', { type: 'success', message: 'Download iniciado!' });
                                                } else {
                                                    $dispatch('toast', { type: 'error', message: 'Erro ao baixar.' });
                                                }
                                            })
                                            .catch(() => $dispatch('toast', { type: 'error', message: 'Erro de conexão.' }));
                                    "
                                    class="text-sm font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-2 transition-colors"
                                >
                                    <x-icon name="download" class="w-4 h-4" />
                                    Baixar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-slate-900/50 rounded-2xl border border-slate-800 border-dashed">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-600">
                        <x-icon name="shopping-bag" class="w-8 h-8" />
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Sua biblioteca está vazia</h3>
                    <p class="text-slate-400 mb-6">Explore o marketplace e encontre materiais incríveis.</p>
                    <a href="{{ route('library.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        Ir para o Marketplace
                    </a>
                </div>
            @endif
        </div>

        <!-- Content: Created -->
        <div x-show="tab === 'created'" class="space-y-6" style="display: none;">
             @if($created->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($created as $material)
                        <div
                            class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 group flex flex-col h-full"
                            data-search="{{ strtolower($material->title . ' ' . $material->description) }}"
                            x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
                            x-transition
                        >
                            <div class="p-5 flex-1">
                                <div class="flex items-start justify-between mb-4">
                                     @php
                                        $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                        $icon = match($ext) {
                                            'pdf' => 'file-pdf',
                                            'doc', 'docx' => 'file-word',
                                            'zip', 'rar' => 'file-zipper',
                                            default => 'file',
                                        };
                                    @endphp
                                    <div class="bg-slate-800 p-2.5 rounded-lg text-slate-400 group-hover:text-indigo-400 transition-colors">
                                        <x-icon name="{{ $icon }}" class="w-6 h-6" />
                                    </div>
                                    <div class="text-xs font-bold text-slate-500 bg-slate-800 px-2 py-1 rounded">
                                        R$ {{ number_format($material->price, 2, ',', '.') }}
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-white mb-2 leading-tight">
                                    <a href="{{ route('library.show', $material->id) }}" class="hover:text-indigo-400 transition-colors">{{ $material->title }}</a>
                                </h3>
                                <p class="text-sm text-slate-400 line-clamp-2">{{ $material->description }}</p>
                            </div>

                            <!-- Stats / Actions -->
                            <div class="bg-slate-800/50 px-5 py-3 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center gap-1">
                                        <x-icon name="shopping-cart" class="w-3 h-3" />
                                        {{ $material->purchasers->count() }} vendas
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <x-icon name="star" class="w-3 h-3 text-amber-400" />
                                        {{ number_format($material->average_rating, 1) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-slate-900/50 rounded-2xl border border-slate-800 border-dashed">
                    <p class="text-slate-400">Você ainda não criou nenhum material.</p>
                </div>
            @endif
        </div>

    </div>
</x-core::layouts.master>
