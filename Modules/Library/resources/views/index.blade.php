<x-core::layouts.master title="Marketplace de Materiais">
    <div class="flex h-screen overflow-hidden bg-slate-950 text-slate-100">
        <!-- Sidebar Filters -->
        <aside class="w-72 bg-slate-900/50 border-r border-slate-800 flex flex-col overflow-y-auto hidden md:flex">
            <div class="p-6">
                <h2 class="text-lg font-bold text-indigo-400 mb-6 flex items-center gap-2">
                    <i class="fa-duotone fa-filter"></i>
                    Filtros
                </h2>

                <form action="{{ route('library.index') }}" method="GET" class="space-y-6">
                    <!-- Grade Filter -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Série / Ano</h3>
                        <div class="space-y-2">
                            @foreach(['Educação Infantil', '1º Ano', '2º Ano', '3º Ano', '4º Ano', '5º Ano', '6º Ano', '7º Ano', '8º Ano', '9º Ano', 'Ensino Médio'] as $grade)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="grade" value="{{ $grade }}" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('grade') == $grade ? 'checked' : '' }}>
                                    <span class="text-slate-400 group-hover:text-indigo-300 transition-colors text-sm">{{ $grade }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Subject Filter -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Disciplina</h3>
                        <div class="space-y-2">
                            @foreach(['Matemática', 'Português', 'Ciências', 'História', 'Geografia', 'Inglês', 'Artes', 'Educação Física'] as $subject)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="subject" value="{{ $subject }}" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('subject') == $subject ? 'checked' : '' }}>
                                    <span class="text-slate-400 group-hover:text-indigo-300 transition-colors text-sm">{{ $subject }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Preço</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="price" value="all" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('price', 'all') == 'all' ? 'checked' : '' }}>
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors text-sm">Todos</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="price" value="free" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('price') == 'free' ? 'checked' : '' }}>
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors text-sm">Grátis</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="price" value="paid" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('price') == 'paid' ? 'checked' : '' }}>
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors text-sm">Pagos</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                             <i class="fa-duotone fa-magnifying-glass text-sm"></i>
                            Aplicar Filtros
                        </button>
                        @if(request()->anyFilled(['search', 'grade', 'subject', 'price']))
                            <a href="{{ route('library.index') }}" class="w-full mt-3 text-center text-sm text-slate-500 hover:text-slate-300 transition-colors block">
                                Limpar Filtros
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8 relative">
            <!-- Header & Search -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Vitrine Oh Pro!</h1>
                    <p class="text-slate-400 mt-1">Explore milhares de recursos pedagógicos criados por professores para professores.</p>
                </div>
                <div class="w-full md:w-auto flex items-center gap-4">
                     <a href="{{ route('library.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/50 flex items-center gap-2 transition whitespace-nowrap">
                        <i class="fa-duotone fa-upload"></i> Publicar
                    </a>
                    <a href="{{ route('library.my-library') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 font-medium whitespace-nowrap">
                        <i class="fa-duotone fa-book-open text-emerald-500"></i>
                        Minha Biblioteca
                    </a>
                    <form action="{{ route('library.index') }}" method="GET" class="relative group w-full md:w-80">
                         @foreach(request()->except('search') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <i class="fa-duotone fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar material..." class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-slate-500 shadow-sm transition-all">
                    </form>
                </div>
            </div>

            <!-- Material Grid -->
            @if($resources->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($resources as $resource)
                        <div class="group relative bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 flex flex-col h-full">

                            <!-- Preview Image -->
                            <div class="aspect-video bg-slate-950 relative overflow-hidden">
                                @if($resource->preview_image_path)
                                    <img src="{{ Storage::url($resource->preview_image_path) }}" alt="{{ $resource->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-700">
                                        <i class="fa-duotone fa-file-pdf text-5xl"></i>
                                    </div>
                                @endif

                                <!-- Recommendation Badge -->
                                @if(isset($userSubjects) && in_array($resource->subject, $userSubjects))
                                    <div class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg uppercase">
                                        <i class="fa-solid fa-star text-yellow-300 mr-1"></i> Recomendado
                                    </div>
                                @endif

                                <!-- Price Tag -->
                                <div class="absolute top-3 right-3">
                                    @if($resource->price > 0)
                                        <span class="bg-slate-900/80 backdrop-blur text-white text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-700 shadow-lg">
                                            R$ {{ number_format($resource->price, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="bg-emerald-600/90 backdrop-blur text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-lg">
                                            GRÁTIS
                                        </span>
                                    @endif
                                </div>

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="{{ route('library.show', $resource->id) }}" class="bg-white text-slate-900 font-bold py-2 px-6 rounded-full hover:bg-indigo-50 transition-transform hover:scale-105 transform translate-y-4 group-hover:translate-y-0 duration-300 flex items-center gap-2 shadow-xl text-sm">
                                        <i class="fa-duotone fa-eye"></i>
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border border-slate-700 bg-slate-800 text-slate-400">
                                        {{ $resource->subject ?? 'Geral' }}
                                    </span>

                                    @if(!empty($resource->tags) && count($resource->tags) > 0)
                                         <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border bg-purple-500/10 text-purple-400 border-purple-500/20 truncate max-w-[120px]">
                                            {{ $resource->tags[0] }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-bold text-white mb-2 leading-snug line-clamp-2 group-hover:text-indigo-400 transition-colors">
                                    {{ $resource->title }}
                                </h3>

                                <p class="text-sm text-slate-400 line-clamp-2 mb-4 flex-1">
                                    {{ $resource->description }}
                                </p>

                                <!-- Footer: Author -->
                                <div class="flex items-center justify-between pt-4 border-t border-slate-800/50 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $resource->author->photo_url ?? asset('assets/images/default-avatar.png') }}" alt="{{ $resource->author->name ?? '' }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-700">
                                        <span class="text-xs text-slate-400 font-medium truncate max-w-[100px]">{{ $resource->author->name ?? 'Professor' }}</span>
                                    </div>

                                    @if($resource->price == 0)
                                        <a href="{{ route('library.download', $resource->id) }}" class="text-indigo-400 hover:text-indigo-300 text-xs font-bold flex items-center gap-1">
                                            <i class="fa-duotone fa-download"></i> Baixar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $resources->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-slate-900 rounded-full flex items-center justify-center mb-6 ring-1 ring-slate-800 shadow-xl">
                        <i class="fa-duotone fa-search text-3xl text-slate-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Nenhum material encontrado</h3>
                    <p class="text-slate-400 max-w-md mx-auto mb-8">Não encontramos resultados para os filtros selecionados.</p>
                    <a href="{{ route('library.index') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-medium py-2 px-6 rounded-xl transition border border-slate-700">
                        Limpar Filtros
                    </a>
                </div>
            @endif
        </main>
    </div>
</x-core::layouts.master>
