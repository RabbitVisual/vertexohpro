<x-core::layouts.master :title="$material->title">
    <div class="min-h-screen bg-slate-950 text-slate-100 pb-20">
        <!-- Breadcrumb & Header -->
        <div class="bg-slate-900 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <nav class="flex mb-4 text-sm text-slate-400">
                    <a href="{{ route('library.index') }}" class="hover:text-indigo-400 transition-colors">Marketplace</a>
                    <span class="mx-2">/</span>
                    <span class="text-slate-200 truncate">{{ $material->title }}</span>
                </nav>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">{{ $material->title }}</h1>
                    <div class="flex items-center gap-3">
                         @if($material->price > 0)
                            <span class="bg-indigo-600/20 text-indigo-400 border border-indigo-600/30 px-4 py-1.5 rounded-full text-lg font-bold">
                                R$ {{ number_format($material->price, 2, ',', '.') }}
                            </span>
                        @else
                            <span class="bg-emerald-600/20 text-emerald-400 border border-emerald-600/30 px-4 py-1.5 rounded-full text-lg font-bold">
                                GRÁTIS
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left Column: Preview -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- File Preview Card -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl relative group">
                        <div class="aspect-video bg-slate-800 flex items-center justify-center relative overflow-hidden">
                             <!-- Abstract Background -->
                            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-20"></div>

                            @php
                                $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                $icon = match($ext) {
                                    'pdf' => 'file-pdf',
                                    'doc', 'docx' => 'file-word',
                                    'zip', 'rar' => 'file-zipper',
                                    default => 'file',
                                };
                            @endphp

                            <x-icon name="{{ $icon }}" class="w-32 h-32 text-slate-700 group-hover:scale-110 transition-transform duration-500" />

                            <div class="absolute bottom-4 right-4 bg-black/50 backdrop-blur px-3 py-1 rounded text-xs font-mono text-slate-300 border border-white/10">
                                PREVIEW
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-invert prose-lg max-w-none">
                        <h3 class="text-xl font-bold text-white mb-4">Sobre este material</h3>
                        <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $material->description }}</p>
                    </div>

                    <!-- BNCC Codes -->
                    @if(!empty($material->bncc_codes))
                        <div class="bg-slate-900/50 rounded-xl p-6 border border-slate-800">
                            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                                <x-icon name="graduation-cap" class="w-5 h-5 text-indigo-400" />
                                Habilidades BNCC Trabalhadas
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($material->bncc_codes as $code)
                                    <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-lg text-sm font-bold font-mono" title="Pesquisar esta habilidade">
                                        {{ $code }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Ratings Section -->
                    <div class="pt-8 border-t border-slate-800">
                        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            Avaliações
                            <span class="text-sm font-normal text-slate-500 bg-slate-800 px-2 py-0.5 rounded-full ml-2">{{ $material->ratings->count() }}</span>
                        </h3>

                        @forelse($material->ratings as $rating)
                            <div class="bg-slate-900 rounded-xl p-6 mb-4 border border-slate-800">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $rating->user->photo_url }}" alt="{{ $rating->user->first_name }}" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <div class="font-bold text-white text-sm">{{ $rating->user->full_name }}</div>
                                            <div class="text-xs text-slate-500">{{ $rating->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <x-icon name="star" class="w-4 h-4 {{ $i <= $rating->rating ? 'text-amber-400 fill-current' : 'text-slate-700' }}" />
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-slate-300 text-sm">{{ $rating->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-slate-900/50 rounded-xl border border-slate-800 border-dashed">
                                <p class="text-slate-400">Seja o primeiro a avaliar este material!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Sidebar Actions -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Author Card -->
                    <div class="bg-slate-900 rounded-xl p-6 border border-slate-800 flex items-center gap-4">
                        <img src="{{ $material->author->photo_url }}" alt="{{ $material->author->first_name }}" class="w-16 h-16 rounded-full object-cover ring-2 ring-indigo-500/50">
                        <div>
                            <div class="text-xs text-slate-400 uppercase tracking-wide font-bold mb-1">Criado por</div>
                            <div class="text-lg font-bold text-white">{{ $material->author->full_name }}</div>
                            <div class="text-sm text-slate-500">Membro desde {{ $material->author->created_at->format('Y') }}</div>
                        </div>
                    </div>

                    <!-- Purchase / Download Panel -->
                    <div class="bg-slate-900 rounded-xl p-6 border border-slate-800 shadow-xl sticky top-6" x-data="{ loading: false }">
                        <div class="mb-6">
                            <div class="flex items-end justify-between mb-2">
                                <span class="text-slate-400">Preço</span>
                                <span class="text-2xl font-bold text-white">
                                    {{ $material->price > 0 ? 'R$ ' . number_format($material->price, 2, ',', '.') : 'Grátis' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-400">
                                <x-icon name="shield-check" class="w-4 h-4 text-emerald-500" />
                                Compra Segura via MercadoPago
                            </div>
                        </div>

                        @if($hasAccess)
                            <button
                                @click="
                                    loading = true;
                                    fetch('{{ route('api.materials.link', $material->id) }}')
                                        .then(res => res.json())
                                        .then(data => {
                                            if(data.url) {
                                                window.location.href = data.url;
                                                $dispatch('toast', { type: 'success', message: 'Download iniciado com sucesso!' });
                                                // Reset loading after delay since redirect might be fast or slow (stream)
                                                setTimeout(() => loading = false, 3000);
                                            } else {
                                                $dispatch('toast', { type: 'error', message: 'Erro ao gerar link.' });
                                                loading = false;
                                            }
                                        })
                                        .catch(() => {
                                            $dispatch('toast', { type: 'error', message: 'Erro de conexão.' });
                                            loading = false;
                                        });
                                "
                                class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-900/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3"
                                :class="{ 'opacity-75 cursor-wait': loading }"
                                :disabled="loading"
                            >
                                <span x-show="!loading" class="flex items-center gap-2">
                                    <x-icon name="download" class="w-6 h-6" />
                                    BAIXAR AGORA
                                </span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Gerando Link...
                                </span>
                            </button>
                            <p class="text-center text-xs text-slate-500 mt-3">Você já possui este material.</p>
                        @else
                             <button
                                @click="
                                    loading = true;
                                    fetch('{{ route('api.checkout.preference') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ material_id: {{ $material->id }} })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if(data.init_point) {
                                            window.location.href = data.init_point;
                                        } else if(data.error) {
                                            $dispatch('toast', { type: 'error', message: data.error });
                                            loading = false;
                                        } else {
                                             $dispatch('toast', { type: 'error', message: 'Erro inesperado.' });
                                             loading = false;
                                        }
                                    })
                                    .catch(err => {
                                        console.error(err);
                                        $dispatch('toast', { type: 'error', message: 'Erro ao iniciar checkout.' });
                                        loading = false;
                                    });
                                "
                                class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-900/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3"
                                :class="{ 'opacity-75 cursor-wait': loading }"
                                :disabled="loading"
                            >
                                <span x-show="!loading" class="flex items-center gap-2">
                                    <x-icon name="credit-card" class="w-6 h-6" />
                                    COMPRAR AGORA
                                </span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Processando...
                                </span>
                            </button>
                            <p class="text-center text-xs text-slate-500 mt-3">Acesso imediato após confirmação.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            @if(isset($relatedMaterials) && $relatedMaterials->count() > 0)
                <div class="mt-20">
                    <h2 class="text-2xl font-bold text-white mb-8">Professores que baixaram este material também gostaram de...</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedMaterials as $related)
                            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 group flex flex-col h-full">
                                <div class="p-5 flex flex-col h-full">
                                    <div class="flex items-center justify-between mb-3">
                                         @php
                                            $ext = strtolower(pathinfo($related->file_path, PATHINFO_EXTENSION));
                                            $icon = match($ext) {
                                                'pdf' => 'file-pdf',
                                                'doc', 'docx' => 'file-word',
                                                'zip', 'rar' => 'file-zipper',
                                                default => 'file',
                                            };
                                        @endphp
                                        <div class="bg-slate-800 p-2 rounded text-slate-400 group-hover:text-indigo-400 transition-colors">
                                            <x-icon name="{{ $icon }}" class="w-5 h-5" />
                                        </div>
                                        <span class="text-xs font-bold text-slate-500 bg-slate-800 px-2 py-1 rounded">
                                            {{ $related->price > 0 ? 'R$ ' . number_format($related->price, 2, ',', '.') : 'Grátis' }}
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-white mb-2 leading-tight">
                                        <a href="{{ route('library.show', $related->id) }}" class="hover:text-indigo-400 transition-colors">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-400 line-clamp-2 mb-4 flex-1">
                                        {{ $related->description }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
<x-core::layouts.master title="Library - show">
    <h1>Library show</h1>
    <p>Placeholder for show view.</p>
</x-core::layouts.master>
