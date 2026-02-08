<section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden bg-white dark:bg-slate-950">
    <!-- Background Decor -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-50/50 dark:bg-purple-900/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 font-semibold text-sm border border-indigo-100 dark:border-indigo-900 animate-bounce">
                    <x-icon name="star" style="solid" />
                    <span>Plataforma Educacional Completa</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-display font-bold text-slate-950 dark:text-white leading-[1.1]">
                    Ensine com <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Excelência</span>, Sem Sobrecarga.
                </h1>

                <p class="text-xl text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    O Vertex Oh Pro é seu aliado pedagógico. Organize aulas, engaje alunos e otimize processos em uma única plataforma premium.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 py-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-2xl shadow-indigo-200 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 text-center">
                        Criar Minha Conta Grátis
                    </a>
                    <a href="{{ route('homepage') }}#funcionalidades" class="w-full sm:w-auto px-10 py-5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 rounded-2xl font-bold text-lg border border-slate-200 dark:border-slate-800 hover:border-indigo-400 transition-all text-center">
                        Ver Demonstração
                    </a>
                </div>
            </div>

            <div class="relative group hidden lg:block">
                <!-- Mockup de Dashboard -->
                <div class="relative z-10 bg-white dark:bg-slate-900 p-4 rounded-3xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] border border-slate-100 dark:border-slate-800 transform rotate-2 group-hover:rotate-0 transition-transform duration-700">
                    <div class="h-4 flex items-center gap-2 mb-4">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="h-8 w-1/3 bg-slate-100 dark:bg-slate-800 rounded-lg"></div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="h-32 bg-indigo-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center">
                                <x-icon name="chart-bar" style="solid" class="text-3xl text-indigo-500" />
                            </div>
                            <div class="h-32 bg-purple-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center">
                                <x-icon name="calendar-days" style="solid" class="text-3xl text-purple-500" />
                            </div>
                        </div>
                        <div class="h-48 bg-slate-50 dark:bg-slate-800 rounded-2xl"></div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute -top-10 -right-10 z-20 bg-emerald-500 text-white p-6 rounded-3xl shadow-xl animate-pulse delay-700">
                    <x-icon name="check" style="solid" size="2xl" />
                </div>
                <div class="absolute -bottom-10 -left-10 z-20 bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            <x-icon name="graduation-cap" style="solid" class="text-2xl text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Planos de Aula</p>
                            <p class="font-bold text-slate-800 dark:text-white">Baseado na BNCC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
