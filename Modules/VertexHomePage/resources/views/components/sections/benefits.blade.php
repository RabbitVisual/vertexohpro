<section id="funcionalidades" class="py-32 bg-slate-50 dark:bg-slate-950/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <h2 class="text-indigo-600 dark:text-indigo-400 font-bold tracking-widest uppercase text-sm">Funcionalidades</h2>
            <p class="text-4xl md:text-5xl font-display font-bold text-slate-950 dark:text-white leading-tight">
                Tudo o que você precisa em um só lugar.
            </p>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Desenvolvemos ferramentas específicas para o fluxo de trabalho real dos professores brasileiros.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    [
                        'title' => 'Gestão de Conteúdos',
                        'desc' => 'Organize seus materiais de forma clara e estruturada, prontos para qualquer aula.',
                        'icon' => 'folder-open',
                        'color' => 'indigo'
                    ],
                    [
                        'title' => 'Planejamento BNCC',
                        'desc' => 'Gere planos de aula alinhados à BNCC de forma simplificada e eficiente.',
                        'icon' => 'book',
                        'color' => 'purple'
                    ],
                    [
                        'title' => 'Recursos Visuais',
                        'desc' => 'Trabalhe conceitos de maneira muito mais didática com nosso suporte gráfico premium.',
                        'icon' => 'chalkboard-user',
                        'color' => 'emerald'
                    ],
                    [
                        'title' => 'Diário de Classe Digital',
                        'desc' => 'Frequência e notas simplificadas, com relatórios automáticos para facilitar o fechamento.',
                        'icon' => 'calendar-days',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Marketplace Exclusivo',
                        'desc' => 'Acesse e compartilhe as melhores atividades e materiais didáticos.',
                        'icon' => 'cart-shopping',
                        'color' => 'amber'
                    ],
                    [
                        'title' => 'Apoio Individualizado',
                        'desc' => 'Acompanhe o desenvolvimento de cada aluno com dashboards intuitivos.',
                        'icon' => 'users',
                        'color' => 'rose'
                    ]
                ];
            @endphp

            @foreach($features as $feature)
                <div class="group p-8 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-100 dark:hover:shadow-none hover:border-indigo-200 dark:hover:border-indigo-900">
                    <div class="w-14 h-14 rounded-2xl mb-6 flex items-center justify-center bg-{{ $feature['color'] }}-50 dark:bg-{{ $feature['color'] }}-900/20 text-{{ $feature['color'] }}-600 dark:text-{{ $feature['color'] }}-400 group-hover:scale-110 transition-transform duration-300">
                        <x-icon :name="$feature['icon']" style="solid" size="xl" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-950 dark:text-white mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $feature['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="beneficios" class="py-32 bg-white dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative">
                <div class="aspect-square bg-indigo-600 rounded-3xl overflow-hidden shadow-2xl relative">
                    <img src="{{ asset('storage/Default/prounsplash.avif') }}" alt="Educador" class="w-full h-full object-cover opacity-80 mix-blend-overlay">
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 to-transparent"></div>
                    <div class="absolute bottom-10 left-10 text-white space-y-2">
                        <p class="text-4xl font-display font-bold">Produtividade</p>
                        <p class="text-indigo-200">Ganhe tempo na preparação de aulas.</p>
                    </div>
                </div>
                <!-- Float card -->
                <div class="absolute -top-10 -right-10 bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800" data-aos="fade-left">
                    <div class="flex items-center gap-4 mb-4">
                        <x-icon name="check-circle" class="text-emerald-500" size="2xl" />
                        <p class="font-bold text-slate-800 dark:text-white">Qualidade Garantida</p>
                    </div>
                    <p class="text-sm text-slate-500">Materiais revisados e alinhados <br>com as normas pedagógicas.</p>
                </div>
            </div>

            <div class="space-y-10">
                <div class="space-y-4">
                    <h2 class="text-indigo-600 dark:text-indigo-400 font-bold tracking-widest uppercase text-sm">Benefícios</h2>
                    <p class="text-4xl md:text-5xl font-display font-bold text-slate-950 dark:text-white leading-tight">
                        Por que escolher o Vertex Oh Pro?
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Simplicidade e Usabilidade</p>
                            <p class="text-slate-600 dark:text-slate-400">Desenvolvido para ser usado por qualquer pessoa, sem necessidade de conhecimentos técnicos.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Aulas mais Atrativas</p>
                            <p class="text-slate-600 dark:text-slate-400">Mantenha seus alunos engajados com conteúdos mais visuais e dinâmicos.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                            <x-icon name="check" class="text-indigo-600 dark:text-indigo-400" size="xs" />
                        </div>
                        <div>
                            <p class="font-bold text-slate-950 dark:text-white mb-1">Segurança de Dados</p>
                            <p class="text-slate-600 dark:text-slate-400">Seus conteúdos e informações de alunos protegidos com tecnologia de ponta.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-bold group">
                        Saiba mais sobre a nossa filosofia
                        <x-icon name="arrow-right" class="group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
