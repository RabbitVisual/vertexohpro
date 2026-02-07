<x-layouts.app title="Vertex Oh Pro! - Home">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100">

        <div class="text-center space-y-8 p-8 max-w-4xl">
            <!-- Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('storage/logo/logo.svg') }}" alt="Vertex Oh Pro!" class="h-24 md:h-32">
            </div>

            <!-- Hero Text -->
            <h1 class="text-4xl md:text-6xl font-bold font-display tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">
                Vertex Oh Pro!
            </h1>

            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 font-light max-w-2xl mx-auto">
                Transformando a produtividade pedagógica com tecnologia moderna e gestão eficiente de sala de aula.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="{{ route('login') }}" class="px-8 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition shadow-lg hover:shadow-indigo-500/30 flex items-center justify-center gap-2">
                    <x-icon name="right-to-bracket" />
                    Acessar Sistema
                </a>

                <a href="https://vertexsolutions.com.br" target="_blank" class="px-8 py-3 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-slate-800 transition font-medium flex items-center justify-center gap-2">
                    <x-icon name="circle-info" />
                    Saiba Mais
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-16 text-sm text-gray-500 dark:text-gray-500 text-center">
            <p>&copy; {{ date('Y') }} Vertex Solutions LTDA. Todos os direitos reservados.</p>
            <p class="mt-2 flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Sistema Operacional
            </p>
        </footer>

    </div>
</x-layouts.app>
