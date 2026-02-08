<x-teacherpanel::layouts.master title="{{ $resource->title }}">
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <!-- Breadcrumb & Back -->
        <div class="flex items-center gap-4">
            <a href="{{ route('library.index') }}" class="p-2.5 text-slate-400 hover:text-indigo-500 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 transition shadow-sm">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
            </a>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-xs text-slate-400">
                    <li><a href="{{ route('library.index') }}" class="hover:text-indigo-500 transition-colors">Biblioteca</a></li>
                    <li><x-icon name="chevron-right" style="solid" class="w-2 h-2" /></li>
                    <li class="text-slate-500 font-medium truncate max-w-[200px]">{{ $resource->title }}</li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Content & Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Info Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <!-- Hero/Preview Image -->
                    <div class="aspect-video w-full bg-slate-100 dark:bg-slate-800 relative overflow-hidden">
                        @if($resource->preview_image_path)
                            <img src="{{ Storage::url($resource->preview_image_path) }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 dark:text-slate-700">
                                <x-icon name="image" style="solid" class="w-16 h-16 mb-4" />
                                <p class="text-sm font-bold uppercase tracking-widest">Visualização indisponível</p>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="bg-white/90 dark:bg-slate-900/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                                {{ $resource->subject ?? 'Geral' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight mb-4">{{ $resource->title }}</h1>

                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                    {{ substr($resource->author->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $resource->author->name ?? 'Autor Independente' }}</span>
                            </div>
                            <div class="h-4 w-px bg-slate-200 dark:bg-slate-800"></div>
                            <div class="flex items-center gap-1 text-amber-500">
                                <x-icon name="star" style="solid" class="w-3.5 h-3.5" />
                                <span class="text-sm font-bold">4.9</span>
                                <span class="text-xs text-slate-400 font-normal">(128 avaliações)</span>
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed">
                            {!! $resource->description !!}
                        </div>

                        <!-- Tags -->
                        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-wrap gap-2">
                            @foreach($resource->tags ?? [] as $tag)
                                <span class="bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-lg text-xs font-medium text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-700">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-8">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">O que os professores dizem</h3>
                    <div class="space-y-6">
                        @for($i=0; $i<2; $i++)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex-shrink-0"></div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-slate-800 dark:text-white">Prof. Silva</span>
                                        <div class="flex text-amber-500 scale-75 transform origin-left">
                                            <x-icon name="star" style="solid" class="w-3" />
                                            <x-icon name="star" style="solid" class="w-3" />
                                            <x-icon name="star" style="solid" class="w-3" />
                                            <x-icon name="star" style="solid" class="w-3" />
                                            <x-icon name="star" style="solid" class="w-3" />
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Material excelente! Me ajudou muito a organizar o conteúdo de Geografia do 6º ano.</p>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right: Buy/Download Card -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl p-8 sticky top-6">
                    @if($resource->price > 0)
                        <div class="mb-6">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Preço do Material</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-bold text-slate-500">R$</span>
                                <span class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter">{{ number_format($resource->price, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <span class="inline-flex px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg text-xs font-bold uppercase tracking-widest">Grátis</span>
                        </div>
                    @endif

                    @if($hasAccess)
                        <div class="space-y-4">
                            <div class="p-4 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 flex flex-col items-center text-center">
                                <x-icon name="circle-check" style="solid" class="w-8 h-8 text-indigo-500 mb-2" />
                                <p class="text-xs font-bold text-indigo-900 dark:text-indigo-100">Você possui acesso!</p>
                                <p class="text-[10px] text-indigo-700 dark:text-indigo-300/80">Este material faz parte da sua biblioteca.</p>
                            </div>
                            <a href="{{ route('library.download', $resource->id) }}" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-lg shadow-indigo-900/20 transition-all active:scale-95">
                                <x-icon name="download" style="solid" class="w-5 h-5" />
                                Baixar Agora (PDF)
                            </a>
                        </div>
                    @else
                        <button class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-lg shadow-indigo-900/20 transition-all active:scale-95 mb-4">
                            <x-icon name="cart-shopping" style="solid" class="w-5 h-5" />
                            Adquirir Material
                        </button>
                    @endif

                    <div class="mt-8 space-y-4">
                        <div class="flex items-center gap-3 grayscale opacity-60">
                            <x-icon name="file-pdf" style="solid" class="w-5 h-5 text-red-500" />
                            <div>
                                <p class="text-[10px] font-bold text-slate-800 dark:text-white uppercase">Formato PDF</p>
                                <p class="text-[9px] text-slate-400">Compatível com todos os dispositivos</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 grayscale opacity-60">
                            <x-icon name="shield-check" style="solid" class="w-5 h-5 text-emerald-500" />
                            <div>
                                <p class="text-[10px] font-bold text-slate-800 dark:text-white uppercase">Certificado BNCC</p>
                                <p class="text-[9px] text-slate-400">Alinhado com as competências base</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Materials -->
                @if($relatedMaterials->count() > 0)
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white px-2">Materiais Recomendados</h4>
                        @foreach($relatedMaterials as $related)
                            <a href="{{ route('library.show', $related->id) }}" class="flex items-center gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-indigo-300 transition-all group">
                                <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-slate-800 flex-shrink-0 overflow-hidden">
                                    @if($related->preview_image_path)
                                        <img src="{{ Storage::url($related->preview_image_path) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-bold text-slate-800 dark:text-white truncate group-hover:text-indigo-600">{{ $related->title }}</h5>
                                    <p class="text-[10px] text-slate-500 mt-1">{{ $related->author->name ?? 'Autor' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-teacherpanel::layouts.master>
