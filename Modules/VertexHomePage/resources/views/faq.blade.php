<x-layouts.guest title="Centro de Conhecimento & FAQ - Vertex Oh Pro!">
    <div class="relative min-h-screen bg-white dark:bg-slate-950 overflow-hidden font-sans">
        <!-- Background Decorations (Premium Aesthetics) -->
        <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-indigo-500/10 blur-[150px] rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-[10%] -left-[10%] w-[50%] h-[50%] bg-purple-500/10 blur-[150px] rounded-full pointer-events-none"></div>

        <!-- Navbar -->
        <x-vertexhomepage::navbar />

        <main class="relative z-10 container mx-auto px-4 py-24 sm:py-32">
            <!-- Header Section: Didactic Focus -->
            <div class="max-w-4xl mx-auto text-center mb-24 space-y-8">
                <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-bold text-sm border border-indigo-100 dark:border-indigo-800 shadow-sm transition-all hover:scale-105">
                    <x-icon name="sparkles" style="duotone" class="fa-beat" />
                    <span>CENTRAL DE AJUDA & DIDÁTICA</span>
                </div>

                <h1 class="text-5xl md:text-8xl font-display font-bold text-slate-900 dark:text-white leading-[1.05] tracking-tight">
                    Aprenda a <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 dark:from-indigo-400 dark:to-purple-400">ensinar melhor</span>.
                </h1>

                <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-3xl mx-auto font-medium">
                    O Vertex Oh Pro! não é apenas um software, é uma nova forma de organizar o pensamento pedagógico. Encontre aqui como dominar cada recurso.
                </p>

                <!-- Philosphy Indicators -->
                <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest">
                    <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900 px-6 py-3 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                        <x-icon name="rabbit" class="text-indigo-500" />
                        <span>RabbitVisual</span>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900 px-6 py-3 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                        <x-icon name="bolt-lightning" class="text-indigo-500" />
                        <span>Local-First</span>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900 px-6 py-3 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                        <x-icon name="heart" class="text-indigo-500" />
                        <span>Foco Humano</span>
                    </div>
                </div>
            </div>

            <!-- Knowledge Explorer -->
            <div class="max-w-6xl mx-auto" x-data="{ activeCategory: 'geral' }">

                <div class="grid lg:grid-cols-12 gap-12 items-start">

                    <!-- Sidebar Navigation (Didactic Menu) -->
                    <aside class="lg:col-span-4 sticky top-32 space-y-6">
                        <h4 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] px-4">Categorias</h4>
                        <nav class="flex flex-col gap-3">
                            @foreach([
                                'geral' => ['label' => 'Conceitos Base', 'icon' => 'book-sparkles', 'desc' => 'Entenda a filosofia de ensino'],
                                'pedagogico' => ['label' => 'Didática & Ensino', 'icon' => 'chalkboard-user', 'desc' => 'Recursos para sala de aula'],
                                'tecnico' => ['label' => 'Tecnologia & Segurança', 'icon' => 'shield-check', 'desc' => 'Local-First e LGPD'],
                                'acesso' => ['label' => 'Acesso & Planos', 'icon' => 'key', 'desc' => 'Gestão de conta e suporte']
                            ] as $id => $cat)
                                <button
                                    @click="activeCategory = '{{ $id }}'"
                                    class="group p-5 rounded-3xl border-2 transition-all duration-500 text-left flex items-center gap-5"
                                    :class="activeCategory === '{{ $id }}'
                                        ? 'bg-indigo-600 border-indigo-600 text-white shadow-xl shadow-indigo-600/20 translate-x-2'
                                        : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800 hover:border-indigo-200 dark:hover:border-indigo-900 text-slate-600 dark:text-slate-400'">

                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-all duration-500"
                                         :class="activeCategory === '{{ $id }}' ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-800'">
                                        <x-icon name="{{ $cat['icon'] }}" size="lg" />
                                    </div>
                                    <div class="overflow-hidden">
                                        <h3 class="font-bold text-lg leading-tight">{{ $cat['label'] }}</h3>
                                        <p class="text-xs font-semibold opacity-70 truncate" :class="activeCategory === '{{ $id }}' ? 'text-indigo-50' : 'text-slate-500'">{{ $cat['desc'] }}</p>
                                    </div>
                                    <x-icon name="arrow-right" class="ml-auto opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0" />
                                </button>
                            @endforeach
                        </nav>

                        <!-- Support Card integrated -->
                        <div class="p-8 rounded-[2.5rem] bg-slate-900 dark:bg-indigo-900/40 text-white space-y-6 shadow-2xl">
                            <h5 class="text-xl font-display font-bold">Precisa de ajuda humana?</h5>
                            <p class="text-slate-400 dark:text-indigo-200/60 text-sm font-medium leading-relaxed">Nossa equipe pedagógica está pronta para te atender de Segunda a Sexta.</p>
                            <a href="{{ route('contact') }}" class="block px-6 py-4 bg-indigo-500 hover:bg-indigo-400 text-white rounded-2xl font-bold text-center transition-all shadow-lg shadow-indigo-500/20">
                                Contactar Suporte
                            </a>
                        </div>
                    </aside>

                    <!-- Content Area (Accordion Sections) -->
                    <div class="lg:col-span-8 bg-slate-50/50 dark:bg-slate-900/50 rounded-[3.5rem] p-6 sm:p-10 border border-slate-100 dark:border-slate-800 shadow-inner min-h-[600px]">

                        <!-- GERAL SECTION -->
                        <div x-show="activeCategory === 'geral'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                            <div class="mb-10 space-y-4">
                                <h2 class="text-3xl font-display font-bold text-slate-800 dark:text-white">Conceitos & Filosofia</h2>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">Entenda como o Vertex Oh Pro! revoluciona a forma como você organiza seu saber pedagógico.</p>
                            </div>

                            @php
                                $faqs_geral = [
                                    [
                                        'q' => 'O que é o sistema de "Didática Visual" RabbitVisual?',
                                        'a' => 'RabbitVisual é nossa linguagem de design exclusiva. Ela utiliza ícones proprietários, hierarquia de cores inteligentes e micro-interações para reduzir a "carga cognitiva". Para o professor, isso significa encontrar o que precisa num piscar de olhos. Para o aluno, significa um conteúdo muito mais fácil de digerir e memorizar.'
                                    ],
                                    [
                                        'q' => 'Como o Vertex Oh Pro! me ajuda a economizar tempo?',
                                        'a' => 'Nós eliminamos a fragmentação. Em vez de planejar num documento, buscar imagens no Google e gerenciar notas em outra planilha, você faz tudo dentro da mesma trilha. Nosso editor é otimizado para que uma aula completa seja planejada em menos de 10 minutos.'
                                    ],
                                    [
                                        'q' => 'A plataforma é indicada para quais níveis de ensino?',
                                        'a' => 'O Vertex foi desenhado para ser universal. Desde a Educação Básica (onde o visual é a chave) até o Ensino Superior (onde a organização de fontes e referências é vital). A estrutura se adapta à complexidade do seu conteúdo.'
                                    ],
                                    [
                                        'q' => 'O professor mantém sua autonomia total?',
                                        'a' => 'Sempre. O sistema nunca impõe conteúdos. Ele é um esqueleto robusto onde você insere sua metodologia, seu estilo e sua voz. Somos a ferramenta, você é o mestre.'
                                    ]
                                ];
                            @endphp

                            <div class="space-y-4">
                                @foreach($faqs_geral as $index => $faq)
                                    <div x-data="{ open: false }" class="group bg-white dark:bg-slate-900 rounded-3xl border-2 transition-all duration-300" :class="open ? 'border-indigo-500/40 shadow-xl shadow-indigo-500/5' : 'border-white dark:border-slate-800/50 hover:border-slate-200 dark:hover:border-slate-700'">
                                        <button @click="open = !open" class="w-full px-8 py-6 text-left flex items-center justify-between gap-6">
                                            <span class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">{{ $faq['q'] }}</span>
                                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 transition-all duration-500" :class="open ? 'bg-indigo-600 text-white rotate-180' : 'text-slate-400'">
                                                <x-icon name="chevron-down" size="xs" />
                                            </div>
                                        </button>
                                        <div x-show="open" x-collapse x-cloak>
                                            <div class="px-8 pb-8 pt-2 flex gap-6 animate-fade-in">
                                                <div class="w-1 bg-gradient-to-b from-indigo-500 to-indigo-100 dark:to-slate-800 rounded-full shrink-0"></div>
                                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">{{ $faq['a'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- PEDAGOGICO SECTION -->
                        <div x-show="activeCategory === 'pedagogico'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8" x-cloak>
                            <div class="mb-10 space-y-4">
                                <h2 class="text-3xl font-display font-bold text-slate-800 dark:text-white">Didática & Ensino</h2>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">Melhore o engajamento e a retenção de conhecimento dos seus alunos.</p>
                            </div>

                            @php
                                $faqs_ped = [
                                    [
                                        'q' => 'Como criar trilhas de aprendizagem visuais?',
                                        'a' => 'Dentro do seu painel, você utiliza o editor de trilhas. Cada módulo de conhecimento pode ser associado a ícones duotone e cores específicas. Isso cria um mapa mental inconsciente para o aluno, que passa a associar temas a indicadores visuais, facilitando o estudo.'
                                    ],
                                    [
                                        'q' => 'O sistema permite a entrega de atividades?',
                                        'a' => 'Sim! O Vertex possui um módulo de recepção de materiais que organiza os arquivos dos alunos por disciplina e data. Você recebe notificações em tempo real e pode dar feedbacks visuais rápidos.'
                                    ],
                                    [
                                        'q' => 'Como o sistema lida com diferentes ritmos de aprendizagem?',
                                        'a' => 'Nossa interface permite que você "esconda" ou "revele" conteúdos progressivamente. Isso evita sobrecarregar o aluno com muita informação de uma vez, permitindo uma trajetória personalizada conforme a evolução da turma.'
                                    ]
                                ];
                            @endphp

                            <div class="space-y-4">
                                @foreach($faqs_ped as $index => $faq)
                                    <div x-data="{ open: false }" class="group bg-white dark:bg-slate-900 rounded-3xl border-2 transition-all duration-300" :class="open ? 'border-indigo-500/40 shadow-xl shadow-indigo-500/5' : 'border-white dark:border-slate-800/50 hover:border-slate-200 dark:hover:border-slate-700'">
                                        <button @click="open = !open" class="w-full px-8 py-6 text-left flex items-center justify-between gap-6">
                                            <span class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">{{ $faq['q'] }}</span>
                                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 transition-all duration-500" :class="open ? 'bg-indigo-600 text-white rotate-180' : 'text-slate-400'">
                                                <x-icon name="chevron-down" size="xs" />
                                            </div>
                                        </button>
                                        <div x-show="open" x-collapse x-cloak>
                                            <div class="px-8 pb-8 pt-2 flex gap-6 animate-fade-in">
                                                <div class="w-1 bg-gradient-to-b from-indigo-500 to-indigo-100 dark:to-slate-800 rounded-full shrink-0"></div>
                                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">{{ $faq['a'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- TECNICO SECTION -->
                        <div x-show="activeCategory === 'tecnico'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8" x-cloak>
                            <div class="mb-10 space-y-4">
                                <h2 class="text-3xl font-display font-bold text-slate-800 dark:text-white">Tecnologia & Segurança</h2>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">Descubra a robustez por trás da interface elegante.</p>
                            </div>

                            @php
                                $faqs_tec = [
                                    [
                                        'q' => 'O que significa a plataforma ser "Local-First"?',
                                        'a' => 'Significa que o sistema é otimizado para rodar a maior parte da lógica diretamente no seu navegador. Isso garante uma velocidade de resposta "instantânea", mesmo em conexões de internet instáveis, o que é comum dentro de instituições de ensino.'
                                    ],
                                    [
                                        'q' => 'Como meus dados e os dos alunos são protegidos?',
                                        'a' => 'Utilizamos criptografia ponta-a-ponta e armazenamento seguro em servidores compatíveis com a LGDP. Além disso, temos backups automáticos diários de todo o seu material pedagógico.'
                                    ],
                                    [
                                        'q' => 'Posso usar o sistema em dispositivos antigos?',
                                        'a' => 'Nosso código é altamente otimizado e utiliza as tecnologias mais leves do mercado (Tailwind CSS v4 e Alpine.js). Ele foi desenhado para rodar fluidamente em tablets e computadores de entrada.'
                                    ]
                                ];
                            @endphp

                            <div class="space-y-4">
                                @foreach($faqs_tec as $index => $faq)
                                    <div x-data="{ open: false }" class="group bg-white dark:bg-slate-900 rounded-3xl border-2 transition-all duration-300" :class="open ? 'border-indigo-500/40 shadow-xl shadow-indigo-500/5' : 'border-white dark:border-slate-800/50 hover:border-slate-200 dark:hover:border-slate-700'">
                                        <button @click="open = !open" class="w-full px-8 py-6 text-left flex items-center justify-between gap-6">
                                            <span class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">{{ $faq['q'] }}</span>
                                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 transition-all duration-500" :class="open ? 'bg-indigo-600 text-white rotate-180' : 'text-slate-400'">
                                                <x-icon name="chevron-down" size="xs" />
                                            </div>
                                        </button>
                                        <div x-show="open" x-collapse x-cloak>
                                            <div class="px-8 pb-8 pt-2 flex gap-6 animate-fade-in">
                                                <div class="w-1 bg-gradient-to-b from-indigo-500 to-indigo-100 dark:to-slate-800 rounded-full shrink-0"></div>
                                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">{{ $faq['a'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- ACESSO SECTION -->
                        <div x-show="activeCategory === 'acesso'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8" x-cloak>
                            <div class="mb-10 space-y-4">
                                <h2 class="text-3xl font-display font-bold text-slate-800 dark:text-white">Gestão de Conta & Planos</h2>
                                <p class="text-slate-600 dark:text-slate-400 font-medium">Informações sobre assinaturas, acesso e privacidade.</p>
                            </div>

                            @php
                                $faqs_acc = [
                                    [
                                        'q' => 'Como funciona o período de teste?',
                                        'a' => 'Você pode explorar todas as funcionalidades do Vertex Oh Pro! gratuitamente por 14 dias. Não é necessário cartão de crédito para iniciar sua experiência. Após o período, você escolhe o plano que melhor se adapta à sua rotina.'
                                    ],
                                    [
                                        'q' => 'Existem descontos para instituições de ensino?',
                                        'a' => 'Sim! Temos planos corporativos desenhados para escolas e universidades que desejam padronizar a qualidade pedagógica visual entre todos os seus docentes. Entre em contato para um orçamento personalizado.'
                                    ],
                                    [
                                        'q' => 'Como recupero meu acesso se esquecer a senha?',
                                        'a' => 'Basta clicar em "Esqueci minha senha" na tela de login. Enviaremos um link de recuperação seguro para o seu e-mail cadastrado instantaneamente.'
                                    ]
                                ];
                            @endphp

                            <div class="space-y-4">
                                @foreach($faqs_acc as $index => $faq)
                                    <div x-data="{ open: false }" class="group bg-white dark:bg-slate-900 rounded-3xl border-2 transition-all duration-300" :class="open ? 'border-indigo-500/40 shadow-xl shadow-indigo-500/5' : 'border-white dark:border-slate-800/50 hover:border-slate-200 dark:hover:border-slate-700'">
                                        <button @click="open = !open" class="w-full px-8 py-6 text-left flex items-center justify-between gap-6">
                                            <span class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">{{ $faq['q'] }}</span>
                                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0 transition-all duration-500" :class="open ? 'bg-indigo-600 text-white rotate-180' : 'text-slate-400'">
                                                <x-icon name="chevron-down" size="xs" />
                                            </div>
                                        </button>
                                        <div x-show="open" x-collapse x-cloak>
                                            <div class="px-8 pb-8 pt-2 flex gap-6 animate-fade-in">
                                                <div class="w-1 bg-gradient-to-b from-indigo-500 to-indigo-100 dark:to-slate-800 rounded-full shrink-0"></div>
                                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">{{ $faq['a'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Expanded Didactic Footer -->
                <div class="mt-20 p-12 rounded-[3.5rem] bg-indigo-600 relative overflow-hidden text-center text-white">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-600/20 blur-[100px] rounded-full -translate-x-1/2 translate-y-1/2"></div>

                    <div class="relative z-10 max-w-3xl mx-auto space-y-8">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-3xl flex items-center justify-center mx-auto shadow-xl">
                            <x-icon name="rocket-launch" size="2xl" />
                        </div>
                        <h2 class="text-4xl md:text-5xl font-display font-bold">Transforme sua jornada pedagógica.</h2>
                        <p class="text-indigo-100 text-lg font-medium leading-relaxed">
                            A tecnologia deve ser o espelho da sua paixão por ensinar. O Vertex Oh Pro! está aqui para garantir que cada aula seja memorável, organizada e visualmente impactante.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-4">
                            <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-indigo-600 rounded-2xl font-bold text-lg transition-all hover:-translate-y-1 shadow-2xl shadow-white/10">
                                Começar Agora Grátis
                            </a>
                            <a href="{{ route('contact') }}" class="px-10 py-5 bg-indigo-500/50 backdrop-blur-md border border-white/20 text-white rounded-2xl font-bold text-lg transition-all hover:bg-indigo-500">
                                Tirar Outras Dúvidas
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <x-vertexhomepage::footer />
    </div>
</x-layouts.guest>
