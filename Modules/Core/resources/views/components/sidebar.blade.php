<aside class="flex flex-col h-screen bg-slate-50 dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-all duration-300 z-40 fixed left-0 top-0"
       :class="sidebarCollapsed ? 'w-20' : 'w-64'">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2 font-display font-bold text-xl text-indigo-600 dark:text-indigo-400 overflow-hidden whitespace-nowrap" x-show="!sidebarCollapsed">
            <img src="{{ asset('storage/logo/logo.svg') }}" class="h-8 w-8" alt="Logo">
            <span>Vertex</span>
        </div>
        <div x-show="sidebarCollapsed" class="mx-auto text-indigo-600 dark:text-indigo-400">
            <img src="{{ asset('storage/logo/logo.svg') }}" class="h-8 w-8" alt="Logo">
        </div>

        <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-500">
            <x-icon name="bars" />
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        @php
            $menuItems = [
                ['label' => 'Dashboard', 'icon' => 'home', 'route' => '#'],
                ['label' => 'Planejamento', 'icon' => 'book', 'route' => '#'],
                ['label' => 'Diário', 'icon' => 'calendar', 'route' => '#'],
                ['label' => 'Biblioteca', 'icon' => 'folder', 'route' => '#'],
                ['label' => 'Alunos', 'icon' => 'user', 'route' => '#'],
                ['label' => 'Suporte', 'icon' => 'envelope', 'route' => '#'],
            ];
        @endphp

        @foreach($menuItems as $item)
            <a href="{{ $item['route'] }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-400 hover:shadow-sm transition-all group relative"
               x-tooltip="sidebarCollapsed ? '{{ $item['label'] }}' : ''">

                <div class="w-6 flex justify-center">
                    <x-icon :name="$item['icon']" class="group-hover:scale-110 transition-transform" />
                </div>

                <span class="font-medium whitespace-nowrap" x-show="!sidebarCollapsed" x-transition>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Footer / User -->
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-slate-700 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                U
            </div>
            <div class="overflow-hidden" x-show="!sidebarCollapsed">
                <p class="text-sm font-bold text-slate-800 dark:text-white truncate">Professor</p>
                <p class="text-xs text-slate-500 truncate">professor@vertex.com</p>
            </div>
        </div>
        <div class="mt-4 flex justify-between" x-show="!sidebarCollapsed">
             <button class="text-slate-400 hover:text-indigo-500" x-tooltip="'Configurações'">
                <x-icon name="settings" />
             </button>
             <button class="text-slate-400 hover:text-red-500" x-tooltip="'Sair'">
                <x-icon name="arrow-right" />
             </button>
        </div>
    </div>
</aside>
