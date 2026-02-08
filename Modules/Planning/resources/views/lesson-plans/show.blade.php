<x-teacherpanel::layouts.master title="Visualizar Plano de Aula">
    <div class="p-6 max-w-5xl mx-auto space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-xs text-slate-400">
                        <li><a href="{{ route('planning.lesson-plans.index') }}" class="hover:text-indigo-500 transition-colors">Planejamentos</a></li>
                        <li><x-icon name="chevron-right" style="solid" class="w-2 h-2" /></li>
                        <li class="text-slate-500 font-medium truncate max-w-[200px]">{{ $plan->title }}</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $plan->title }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    <x-icon name="calendar" style="solid" class="w-3.5 h-3.5 inline mr-1" />
                    Criado em {{ $plan->created_at->format('d/m/Y') }}
                    @if($plan->schoolClass)
                        • <x-icon name="users" style="solid" class="w-3.5 h-3.5 inline mx-1" /> {{ $plan->schoolClass->name }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 px-5 py-2.5 rounded-xl font-medium border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition shadow-sm flex items-center gap-2">
                    <x-icon name="print" style="solid" class="w-4 h-4" />
                    Imprimir
                </button>
                <a href="{{ route('planning.lesson-plans.edit', $plan->id) }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/20 flex items-center gap-2 transition duration-200">
                    <x-icon name="pen" style="solid" class="w-4 h-4" />
                    Editar
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Plan Content -->
            <div class="lg:col-span-2 space-y-6 print:col-span-1">
                @foreach($plan->sections ?? [] as $section)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">{{ $section['title'] }}</h3>
                        </div>
                        <div class="p-6 prose dark:prose-invert max-w-none">
                            {!! $section['content'] !!}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6 print:hidden">
                <!-- BNCC Codes -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4">Habilidades BNCC</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($plan->bncc_codes ?? [] as $code)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                                {{ $code }}
                            </span>
                        @empty
                            <p class="text-xs text-slate-500 italic">Nenhuma habilidade vinculada.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Launch to Diary -->
                <div class="bg-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-2">Lançar no Diário</h3>
                        <p class="text-indigo-100 text-xs mb-4">Registre a execução desta aula diretamente no diário de classe da sua turma.</p>
                        <form action="{{ route('planning.lesson-plans.launch', $plan->id) }}" method="POST">
                            @csrf
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-indigo-700/50 border-none rounded-xl text-white text-sm px-4 py-2 mb-4 focus:ring-white/20">
                            <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-xl font-bold text-sm hover:bg-slate-50 transition shadow-lg">
                                Lançar Agora
                            </button>
                        </form>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <x-icon name="calendar-check" style="solid" class="w-32 h-32" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .print\:hidden { display: none !important; }
            body { background: white !important; color: black !important; }
            .bg-white, .bg-slate-50, .dark\:bg-slate-900 { background: white !important; border-color: #eee !important; }
            .shadow-sm, .shadow-lg, .shadow-xl { shadow: none !important; }
            .rounded-3xl { border-radius: 0 !important; }
            .prose, .text-slate-800, .dark\:text-white { color: black !important; }
        }
    </style>
</x-teacherpanel::layouts.master>
