<x-core::layouts.master title="Marketplace de Materiais">
    <div class="flex h-screen overflow-hidden bg-slate-950 text-slate-100">
        <!-- Sidebar Filters -->
        <aside class="w-72 bg-slate-900/50 border-r border-slate-800 flex flex-col overflow-y-auto hidden md:flex">
            <div class="p-6">
                <h2 class="text-lg font-bold text-indigo-400 mb-6 flex items-center gap-2">
                    <x-icon name="filter" class="w-5 h-5" />
                    Filtros
                </h2>

                <form action="{{ route('library.index') }}" method="GET" class="space-y-6">
                    <!-- Search inside filters for mobile consistency or separate? Keeping it separate in main area usually better, but let's put refined filters here -->

                    <!-- Grade Filter -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Série / Ano</h3>
                        <div class="space-y-2">
                            @foreach(['Educação Infantil', '1º Ano', '2º Ano', '3º Ano', '4º Ano', '5º Ano', '6º Ano', '7º Ano', '8º Ano', '9º Ano', 'Ensino Médio'] as $grade)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="grade" value="{{ $grade }}" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('grade') == $grade ? 'checked' : '' }}>
                                    <span class="text-slate-400 group-hover:text-indigo-300 transition-colors">{{ $grade }}</span>
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
                                    <span class="text-slate-400 group-hover:text-indigo-300 transition-colors">{{ $subject }}</span>
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
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors">Todos</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="price" value="free" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('price') == 'free' ? 'checked' : '' }}>
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors">Grátis</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="price" value="paid" class="form-radio text-indigo-500 bg-slate-800 border-slate-700 focus:ring-indigo-500 rounded-full" {{ request('price') == 'paid' ? 'checked' : '' }}>
                                <span class="text-slate-400 group-hover:text-indigo-300 transition-colors">Pagos</span>
                            </label>
                        </div>
                    </div>

                    <!-- BNCC Filter -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Habilidade BNCC</h3>
                        <input type="text" name="bncc" value="{{ request('bncc') }}" placeholder="Ex: EF01LP01" class="w-full bg-slate-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-slate-500">
                    </div>

                    <div class="pt-4 border-t border-slate-800">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <x-icon name="filter" class="w-4 h-4" />
                            Aplicar Filtros
                        </button>
                        @if(request()->anyFilled(['search', 'grade', 'subject', 'price', 'bncc']))
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
                    <a href="{{ route('library.my-library') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 font-medium">
                        <x-icon name="book-open" class="w-5 h-5 text-emerald-500" />
                        Minha Biblioteca
                    </a>
                    <form action="{{ route('library.index') }}" method="GET" class="relative group w-full md:w-80">
                         <!-- Preserve other filters -->
                        @foreach(request()->except('search') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <x-icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 group-focus-within:text-indigo-500 transition-colors" />
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título, assunto..." class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-slate-500 shadow-sm transition-all">
                    </form>
                </div>
            </div>

            <!-- Material Grid -->
            @if($materials->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($materials as $material)
                        @php
                            $ext = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));
                            $badgeColor = match($ext) {
                                'pdf' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                'doc', 'docx' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                'zip', 'rar' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                default => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                            };
                            $icon = match($ext) {
                                'pdf' => 'file-pdf',
                                'doc', 'docx' => 'file-word',
                                'zip', 'rar' => 'file-zipper',
                                default => 'file',
                            };
                        @endphp

                        <div class="group relative bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 flex flex-col h-full">
                            <!-- File Preview / Cover -->
                            <div class="aspect-[4/3] bg-slate-800 relative overflow-hidden flex items-center justify-center p-6">
                                <!-- Abstract Pattern Background -->
                                <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900 opacity-50"></div>

                                <!-- File Icon Large -->
                                <x-icon name="{{ $icon }}" class="w-20 h-20 text-slate-700 group-hover:scale-110 group-hover:text-indigo-400/50 transition-all duration-500" />

                                <!-- Price Tag -->
                                <div class="absolute top-3 right-3">
                                    @if($material->price > 0)
                                        <span class="bg-indigo-600/90 backdrop-blur text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-lg">
                                            R$ {{ number_format($material->price, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="bg-emerald-600/90 backdrop-blur text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-lg">
                                            GRÁTIS
                                        </span>
                                    @endif
                                </div>

                                <!-- Hover Overlay Button -->
                                <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="{{ route('library.show', $material->id) }}" class="bg-white text-slate-900 font-bold py-2 px-6 rounded-full hover:bg-indigo-50 transition-transform hover:scale-105 transform translate-y-4 group-hover:translate-y-0 duration-300 flex items-center gap-2 shadow-xl">
                                        <x-icon name="eye" class="w-4 h-4" />
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-1">
                                <!-- File Badge -->
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border {{ $badgeColor }}">
                                        <x-icon name="{{ $icon }}" class="w-3 h-3" />
                                        {{ $ext }}
                                    </span>

                                    <!-- BNCC Badge if exists -->
                                    @if(!empty($material->bncc_codes) && count($material->bncc_codes) > 0)
                                         <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border bg-purple-500/10 text-purple-400 border-purple-500/20 truncate max-w-[120px]">
                                            {{ $material->bncc_codes[0] }}
                                            @if(count($material->bncc_codes) > 1) +{{ count($material->bncc_codes) - 1 }} @endif
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-bold text-white mb-2 leading-snug line-clamp-2 group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ route('library.show', $material->id) }}" class="focus:outline-none">
                                        <span class="absolute inset-0 z-0"></span> <!-- Full card link via overlay trick if needed, but button handles explicit action -->
                                        {{ $material->title }}
                                    </a>
                                </h3>

                                <p class="text-sm text-slate-400 line-clamp-2 mb-4 flex-1">
                                    {{ $material->description }}
                                </p>

                                <!-- Footer: Author & Rating -->
                                <div class="flex items-center justify-between pt-4 border-t border-slate-800/50 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $material->author->photo_url ?? asset('assets/images/default-avatar.png') }}" alt="{{ $material->author->full_name }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-700">
                                        <span class="text-xs text-slate-400 font-medium truncate max-w-[100px]">{{ $material->author->first_name }}</span>
                                    </div>

                                    <div class="flex items-center gap-1 text-amber-400 text-xs font-bold bg-amber-400/10 px-1.5 py-0.5 rounded">
                                        <x-icon name="star" class="w-3 h-3 fill-current" />
                                        <span>{{ number_format($material->average_rating, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $materials->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-slate-900 rounded-full flex items-center justify-center mb-6 ring-1 ring-slate-800">
                        <x-icon name="search" class="w-10 h-10 text-slate-600" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Nenhum material encontrado</h3>
                    <p class="text-slate-400 max-w-md mx-auto mb-8">Não encontramos resultados para os filtros selecionados. Tente termos mais genéricos ou limpe os filtros.</p>
                    <a href="{{ route('library.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                        Limpar Filtros
                    </a>
                </div>
            @endif
        </main>
    </div>
</x-core::layouts.master>
