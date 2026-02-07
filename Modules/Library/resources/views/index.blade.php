<x-core::layouts.master title="Biblioteca de Materiais">
    <div class="p-6">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-100 font-poppins">Biblioteca</h1>
                <p class="text-slate-400">Descubra materiais criados por professores para professores.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('coupons.index') }}" class="text-slate-400 hover:text-white px-4 py-2 border border-slate-700 rounded-lg">
                    <i class="fa-duotone fa-ticket"></i> Meus Cupons
                </a>
                <a href="{{ route('library.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg font-medium shadow-lg shadow-indigo-900/50 flex items-center gap-2">
                    <i class="fa-duotone fa-upload"></i> Publicar Material
                </a>
            </div>
        </header>

        <!-- Search & Filter -->
        <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 mb-8 flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fa-duotone fa-search absolute left-4 top-3.5 text-slate-500"></i>
                <form action="{{ route('library.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título ou descrição..." class="w-full bg-slate-950 border-slate-700 text-white pl-12 rounded-lg focus:ring-indigo-500">
                </form>
            </div>
            <div class="w-full md:w-64">
                <form action="{{ route('library.index') }}" method="GET">
                    <select name="subject" onchange="this.form.submit()" class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500">
                        <option value="">Todas as Disciplinas</option>
                        <option value="Matemática" {{ request('subject') == 'Matemática' ? 'selected' : '' }}>Matemática</option>
                        <option value="Português" {{ request('subject') == 'Português' ? 'selected' : '' }}>Português</option>
                        <option value="História" {{ request('subject') == 'História' ? 'selected' : '' }}>História</option>
                        <option value="Geografia" {{ request('subject') == 'Geografia' ? 'selected' : '' }}>Geografia</option>
                        <option value="Ciências" {{ request('subject') == 'Ciências' ? 'selected' : '' }}>Ciências</option>
                        <option value="Artes" {{ request('subject') == 'Artes' ? 'selected' : '' }}>Artes</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($resources as $resource)
                <div class="bg-slate-900 rounded-xl border border-slate-800 overflow-hidden hover:border-indigo-500/50 transition group flex flex-col h-full">
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
                        @if(in_array($resource->subject, $userSubjects))
                            <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">
                                <i class="fa-solid fa-star text-yellow-300 mr-1"></i> Recomendado
                            </div>
                        @endif

                        <div class="absolute top-2 left-2 bg-slate-900/80 backdrop-blur text-slate-300 text-xs font-bold px-2 py-1 rounded border border-slate-700">
                            {{ $resource->subject ?? 'Geral' }}
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-white text-lg mb-1 line-clamp-1">{{ $resource->title }}</h3>
                        <p class="text-sm text-slate-400 mb-4 line-clamp-2 flex-1">{{ $resource->description }}</p>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-slate-800">
                            <span class="text-emerald-400 font-bold text-lg">
                                {{ $resource->price > 0 ? 'R$ ' . number_format($resource->price, 2, ',', '.') : 'Grátis' }}
                            </span>

                            @if($resource->price > 0)
                                <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                    Comprar
                                </button>
                            @else
                                <a href="{{ route('library.download', $resource->id) }}" class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition border border-slate-700">
                                    <i class="fa-duotone fa-download"></i> Baixar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-500">
                    <i class="fa-duotone fa-ghost text-4xl mb-3 opacity-50"></i>
                    <p>Nenhum material encontrado.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $resources->links() }}
        </div>
    </div>
</x-core::layouts.master>
